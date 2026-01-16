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
use App\Services\SamedayService;

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
                    session()->forget('coupon_code');
                    $coupon = null;
                }
            }
        }

        // Get shipping cost from session (calculated via AJAX)
        $shippingCost = session()->get('shipping_cost', 0);

        $finalTotal = $cartTotal - $discountAmount + $shippingCost;

        return view('checkout.index', compact('cartItems', 'cartTotal', 'coupon', 'discountAmount', 'shippingCost', 'finalTotal'));
    }

    public function store(Request $request)
    {

        // Convert empty strings to null for integer fields
        $request->merge([
            'sameday_county_id' => $request->sameday_county_id ?: null,
            'sameday_city_id' => $request->sameday_city_id ?: null,
            'sameday_locker_id' => $request->sameday_locker_id ?: null,
            'is_company' => $request->has('is_company') ? (bool) $request->is_company : false,
        ]);

        $validated = $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_email' => 'required|email|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address' => 'required_if:delivery_type,home|nullable|string|max:500',
            'shipping_city' => 'nullable|string|max:100',
            'shipping_postal_code' => 'required_if:delivery_type,home|nullable|string|max:20',
            'shipping_country' => 'required|string|max:100',
            'is_company' => 'boolean',
            'delivery_type' => 'required|in:home,locker',
            'sameday_county_id' => 'required|integer',
            'sameday_city_id' => 'required|integer',
            'sameday_locker_id' => 'required_if:delivery_type,locker|nullable|integer',
            'sameday_locker_name' => 'nullable|string',
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

            // Get shipping cost
            $shippingCost = session()->get('shipping_cost', 0);

            // Calculate final total
            $finalTotal = $totalAmount - $discountAmount + $shippingCost;

            // Ensure shipping_address has a value for locker delivery
            if ($validated['delivery_type'] === 'locker' && empty($validated['shipping_address'])) {
                $validated['shipping_address'] = $validated['sameday_locker_name'] ?? 'Easybox Locker';
            }

            // Create order
            $order = Order::create([
                'user_id' => auth()->check() ? auth()->id() : null,
                'coupon_id' => $coupon?->id,
                'total_amount' => $finalTotal,
                'discount_amount' => $discountAmount,
                'shipping_cost' => $shippingCost,
                'shipping_name' => $validated['shipping_name'],
                'shipping_email' => $validated['shipping_email'],
                'shipping_phone' => $validated['shipping_phone'],
                'shipping_address' => $validated['shipping_address'],
                'shipping_city' => $validated['shipping_city'],
                'shipping_postal_code' => $validated['shipping_postal_code'],
                'shipping_country' => $validated['shipping_country'],
                'is_company' => $validated['is_company'] ?? false,
                'delivery_type' => $validated['delivery_type'],
                'sameday_county_id' => $validated['sameday_county_id'],
                'sameday_city_id' => $validated['sameday_city_id'],
                'sameday_locker_id' => $validated['sameday_locker_id'] ?? null,
                'sameday_locker_name' => $validated['sameday_locker_name'] ?? null,
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

        // Add shipping as a line item
        if ($order->shipping_cost > 0) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'ron',
                    'product_data' => [
                        'name' => '🚚 Livrare Sameday ' . ($order->delivery_type === 'locker' ? '(Easybox)' : '(Domiciliu)'),
                        'description' => 'Cost transport',
                    ],
                    'unit_amount' => intval($order->shipping_cost * 100), // Convert to cents
                ],
                'quantity' => 1,
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
                'shipping_cost' => $order->shipping_cost,
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
         $order = $order->fresh(['items', 'coupon']);

        // NOW send emails after successful payment
        $this->sendOrderEmails($order);

        // Clear cart
        session()->forget(['cart', 'coupon_code', 'shipping_cost']);

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

    public function getCounties()
    {
        $samedayService = new SamedayService();
        $counties = $samedayService->getCounties();
        return response()->json($counties);
    }

    public function getCities(Request $request)
    {
        $countyId = $request->input('county_id');
        $samedayService = new SamedayService();
        $cities = $samedayService->getCities($countyId);
        return response()->json($cities);
    }

    // public function getLockers(Request $request)
    // {
    //     $countyId = $request->input('county_id');
    //     $cityId = $request->input('city_id');
    //     $samedayService = new SamedayService();
    //     $lockers = $samedayService->getLockers(0, $countyId, $cityId); // 0 = Easybox
    //     return response()->json($lockers);
    // }

    public function getLockers(Request $request)
    {
        $countyId = $request->input('county_id');
        $cityId = $request->input('city_id');
        $samedayService = new SamedayService();
        $lockers = $samedayService->getLockers(0, $countyId, $cityId); // 0 = Easybox

        // Map oohId to id for frontend consistency and ensure it's an integer
        $formattedLockers = array_map(function ($locker) {
            return [
                'id' => (int) $locker['oohId'], // Ensure integer
                'name' => $locker['name'] ?? '',
                'address' => $locker['address'] ?? '',
                'countyId' => $locker['countyId'] ?? null,
                'cityId' => $locker['cityId'] ?? null,
            ];
        }, $lockers);

        return response()->json($formattedLockers);
    }

    public function calculateShipping(Request $request)
    {
        $request->validate([
            'delivery_type' => 'required|in:home,locker',
            'county_id' => 'required|integer',
            'locker_id' => 'nullable|integer',
        ]);

        try {
            $samedayService = new SamedayService();

            // Calculate total weight from cart
            $cartItems = session()->get('cart', []);
            $totalWeight = 0;

            foreach ($cartItems as $item) {
                // 0.5kg per produs (ajustează după nevoie)
                $totalWeight += ($item['quantity'] * 0.5);
            }

            // Minimum 1kg
            $totalWeight = max($totalWeight, 1);

            $shippingCost = $samedayService->estimateShippingCost(
                $request->delivery_type,
                $totalWeight,
                $request->county_id,
                $request->locker_id
            );

            // Save to session
            session()->put('shipping_cost', $shippingCost);

            return response()->json([
                'success' => true,
                'shipping_cost' => $shippingCost,
                'formatted' => number_format($shippingCost, 2)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Could not calculate shipping cost'
            ], 400);
        }
    }
}
