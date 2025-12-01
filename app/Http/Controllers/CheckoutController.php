<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmationMail;
use App\Mail\OrderCreatedMail;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = session()->get('cart', []);
        
        if (empty($cartItems)) {
            return redirect()->route('shop')->with('error', 'Your cart is empty');
        }

        $cartTotal = collect($cartItems)->sum(function ($item) {
            return $item['final_price'] * $item['quantity'];
        });

       // Get applied coupon from session
        $couponCode = session()->get('coupon_code');
        $coupon = null;
        $discountAmount = 0;

        if ($couponCode) {
            $coupon = Coupon::where('code', $couponCode)->first();
            if ($coupon) {
                $validation = $coupon->isValid($cartTotal);
                if ($validation['valid']) {
                    $discountAmount = $coupon->calculateDiscount($cartTotal);
                } else {
                    // Cuponul nu mai este valid, șterge-l din sesiune
                    session()->forget('coupon_code');
                    $coupon = null;
                }
            }
        }

        $finalTotal = $cartTotal - $discountAmount;

        return view('checkout.index', compact('cartItems', 'cartTotal', 'coupon', 'discountAmount', 'finalTotal'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_email' => 'required|email|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:500',
            'shipping_city' => 'required|string|max:100',
            'shipping_postal_code' => 'required|string|max:20',
            'shipping_country' => 'required|string|max:100',
            'payment_method' => 'required|in:card,cash_on_delivery',
            'notes' => 'nullable|string|max:1000',
        ]);

        $cartItems = session()->get('cart', []);
        
        if (empty($cartItems)) {
            return redirect()->route('shop')->with('error', 'Your cart is empty');
        }

        try {
            DB::beginTransaction();

            // Calculate total
            $totalAmount = collect($cartItems)->sum(function ($item) {
                return $item['final_price'] * $item['quantity'];
            });

            // Apply coupon if exists
            $couponCode = session()->get('coupon_code');
            $coupon = null;
            $discountAmount = 0;

            if ($couponCode) {
                $coupon = Coupon::where('code', $couponCode)->first();
                if ($coupon) {
                    $validation = $coupon->isValid($totalAmount);
                    if ($validation['valid']) {
                        $discountAmount = $coupon->calculateDiscount($totalAmount);
                    }
                }
            }

            $finalTotal = $totalAmount - $discountAmount;

            // Create order
            $order = Order::create([
                'user_id' => auth()->check() ? auth()->id() : null,
                'coupon_id' => $coupon?->id,
                'total_amount' => $finalTotal,
                'discount_amount' => $discountAmount,
                'shipping_name' => $validated['shipping_name'],
                'shipping_email' => $validated['shipping_email'],
                'shipping_phone' => $validated['shipping_phone'],
                'shipping_address' => $validated['shipping_address'],
                'shipping_city' => $validated['shipping_city'],
                'shipping_postal_code' => $validated['shipping_postal_code'],
                'shipping_country' => $validated['shipping_country'],
                'payment_method' => $validated['payment_method'],
                'payment_status' => $validated['payment_method'] === 'card' ? 'pending' : 'pending',
                'notes' => $validated['notes'] ?? null,
            ]);

            // Create order items and update product stock
            foreach ($cartItems as $item) {
                $product = Product::find($item['id']);
                
                if (!$product || $product->stock < $item['quantity']) {
                    throw new \Exception("Product {$item['title']} is out of stock");
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_title' => $product->title,
                    'price' => $item['final_price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['final_price'] * $item['quantity'],
                ]);

                // Update stock
                $product->decrement('stock', $item['quantity']);
            }

            // Increment coupon usage
            if ($coupon) {
                $coupon->incrementUsage();
            }

            // Load order items for emails
            $order->load('items');

            DB::commit();

            // If card payment, redirect to Stripe (NO emails sent yet)
            if ($validated['payment_method'] === 'card') {
                return $this->createStripeSession($order, $cartItems);
            }

            // For cash on delivery, send emails and show success
            $this->sendOrderEmails($order);
            session()->forget(['cart', 'coupon_code']);
            return redirect()->route('checkout.success', $order)->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error placing order: ' . $e->getMessage())->withInput();
        }
    }

     public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
        ]);

        $cartItems = session()->get('cart', []);
        $cartTotal = collect($cartItems)->sum(fn($item) => $item['price'] * $item['quantity']);

        $coupon = Coupon::where('code', strtoupper($request->coupon_code))->first();

        if (!$coupon) {
            return back()->with('error', 'Coupon code not found.');
        }

        $validation = $coupon->isValid($cartTotal);

        if (!$validation['valid']) {
            return back()->with('error', $validation['message']);
        }

        // Salvează cuponul în sesiune
        session()->put('coupon_code', $coupon->code);

        return back()->with('success', 'Coupon applied successfully!');
    }

    public function removeCoupon()
    {
        session()->forget('coupon_code');
        return back()->with('success', 'Coupon removed.');
    }

    private function sendOrderEmails(Order $order)
    {
        try {
            // Queue customer email first (no delay)
            Mail::to($order->shipping_email)
                ->queue(new OrderConfirmationMail($order));

            // Queue admin email after (15 seconds delay)
            Mail::to(config('mail.admin_email'))
                ->queue(new OrderCreatedMail($order));

        } catch (\Exception $e) {
            // Log email errors but don't fail the order
            \Log::error('Failed to queue order emails: ' . $e->getMessage());
        }
    }

    // ...existing code...

    private function createStripeSession(Order $order, array $cartItems)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $lineItems = [];
        
        // Add products
        foreach ($cartItems as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'ron',
                    'product_data' => [
                        'name' => $item['title'],
                        'images' => $item['image'] ? [asset('storage/' . $item['image'])] : [],
                    ],
                    'unit_amount' => intval($item['final_price'] * 100), // Convert to cents
                ],
                'quantity' => $item['quantity'],
            ];
        }

        // If coupon applied, add it as a discount in Stripe (NOT as negative line item)
        $discounts = [];
        if ($order->discount_amount > 0 && $order->coupon) {
            // Create a Stripe Coupon for this discount
            try {
                $stripeCoupon = \Stripe\Coupon::create([
                    'amount_off' => intval($order->discount_amount * 100), // in cents
                    'currency' => 'ron',
                    'duration' => 'once',
                    'name' => $order->coupon->code,
                ]);
                
                $discounts[] = ['coupon' => $stripeCoupon->id];
            } catch (\Exception $e) {
                // If coupon creation fails, just log it
                \Log::error('Stripe coupon creation failed: ' . $e->getMessage());
            }
        }

        $sessionData = [
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('stripe.success', ['order' => $order->id]),
            'cancel_url' => route('stripe.cancel', ['order' => $order->id]),
            'customer_email' => $order->shipping_email,
            'metadata' => [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'coupon_code' => $order->coupon?->code ?? '',
                'discount_amount' => $order->discount_amount,
            ],
        ];

        // Add discounts if available
        if (!empty($discounts)) {
            $sessionData['discounts'] = $discounts;
        }

        $session = StripeSession::create($sessionData);

        // Store Stripe session ID
        $order->update(['stripe_session_id' => $session->id]);

        return redirect($session->url);
    }

    public function stripeSuccess(Request $request, Order $order)
    {
        // Mark payment as paid
        $order->update(['payment_status' => 'paid']);
        
        // Load order items for emails
        $order->load('items');
        
        // NOW send emails after successful payment
        $this->sendOrderEmails($order);
        
        // Clear cart
        session()->forget('cart');
        
        return redirect()->route('checkout.success', $order)
            ->with('success', 'Payment successful! Order placed successfully!');
    }

    public function stripeCancel(Request $request, Order $order)
    {
        // Restore stock
        foreach ($order->items as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
                $product->increment('stock', $item->quantity);
            }
        }

        // Delete order
        $order->delete();

        return redirect()->route('checkout')
            ->with('error', 'Payment cancelled. Please try again.');
    }

    public function webhook(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        $endpoint_secret = config('services.stripe.webhook_secret');

        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        // Handle the event
        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;
            
            $order = Order::where('stripe_session_id', $session->id)->first();
            if ($order && $order->payment_status !== 'paid') {
                $order->update(['payment_status' => 'paid']);
                // NU mai trimite email-uri aici - se trimit din stripeSuccess
            }
        }

        return response()->json(['status' => 'success']);
    }

    public function success(Order $order)
    {
        // Allow guest users to see their success page
        // For logged in users, verify they own the order
        if (auth()->check() && $order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('checkout.success', compact('order'));
    }
}