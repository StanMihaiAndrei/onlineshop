<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmationMail;
use App\Mail\OrderCreatedMail;
use App\Models\Order;
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
            return $item['price'] * $item['quantity'];
        });

        return view('checkout.index', compact('cartItems', 'cartTotal'));
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
                return $item['price'] * $item['quantity'];
            });

            // Create order
            $order = Order::create([
                'user_id' => auth()->check() ? auth()->id() : null,
                'total_amount' => $totalAmount,
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
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);

                // Update stock
                $product->decrement('stock', $item['quantity']);
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
            session()->forget('cart');
            return redirect()->route('checkout.success', $order)->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error placing order: ' . $e->getMessage())->withInput();
        }
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
        foreach ($cartItems as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'ron',
                    'product_data' => [
                        'name' => $item['title'],
                        'images' => $item['image'] ? [asset('storage/' . $item['image'])] : [],
                    ],
                    'unit_amount' => intval($item['price'] * 100), // Convert to cents
                ],
                'quantity' => $item['quantity'],
            ];
        }

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('stripe.success', ['order' => $order->id]),
            'cancel_url' => route('stripe.cancel', ['order' => $order->id]),
            'customer_email' => $order->shipping_email,
            'metadata' => [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
            ],
        ]);

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