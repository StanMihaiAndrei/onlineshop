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
use Illuminate\Support\Facades\Cache;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use App\Services\SamedayService;

class CheckoutController extends Controller
{
    // Cache duration: 24 hours for counties/cities/lockers, 1 hour for shipping costs
    const CACHE_DURATION_LONG = 60 * 24; // 24 hours
    const CACHE_DURATION_SHORT = 60; // 1 hour

    public function index()
    {
        $cartItems = session()->get('cart', []);

        if (empty($cartItems)) {
            return redirect()->route('shop')->with('error', 'Cosul tău este gol');
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
            // Shipping (Livrare) - pentru Sameday
            'shipping_name' => 'required|string|max:255',
            'shipping_email' => 'required|email|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address' => 'required_if:delivery_type,home|nullable|string|max:500',
            'shipping_city' => 'nullable|string|max:100',
            'shipping_postal_code' => 'required_if:delivery_type,home|nullable|string|max:20', // Doar pentru home delivery
            'shipping_country' => 'required|string|max:100',

            // Billing (Facturare) - pentru SmartBill
            'billing_name' => 'required|string|max:255',
            'billing_email' => 'required|email|max:255',
            'billing_phone' => 'required|string|max:20',
            'billing_address' => 'required|string|max:500',
            'billing_city' => 'required|string|max:100',
            'billing_county' => 'required|string|max:100',
            'billing_postal_code' => 'required|string|max:20',
            'billing_country' => 'required|string|max:100',

            // Câmpuri pentru firme (opționale, doar dacă is_company = true)
            'billing_company_name' => 'required_if:is_company,true|nullable|string|max:255',
            'billing_cif' => 'required_if:is_company,true|nullable|string|max:50',
            'billing_reg_com' => 'nullable|string|max:100',

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
            return redirect()->route('shop')->with('error', 'Cosul tău este gol');
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

                // Shipping (Livrare) - pentru Sameday
                'shipping_name' => $validated['shipping_name'],
                'shipping_email' => $validated['shipping_email'],
                'shipping_phone' => $validated['shipping_phone'],
                'shipping_address' => $validated['shipping_address'],
                'shipping_city' => $validated['shipping_city'],
                'shipping_postal_code' => $validated['shipping_postal_code'] ?? null,
                'shipping_country' => $validated['shipping_country'],
                //'shipping_county' => session()->get('shipping_county_name', 'Bucuresti'),

                // Billing (Facturare) - pentru SmartBill
                'billing_name' => $validated['billing_name'],
                'billing_email' => $validated['billing_email'],
                'billing_phone' => $validated['billing_phone'],
                'billing_address' => $validated['billing_address'],
                'billing_city' => $validated['billing_city'],
                'billing_county' => $validated['billing_county'],
                'billing_postal_code' => $validated['billing_postal_code'],
                'billing_country' => $validated['billing_country'],
                'billing_company_name' => $validated['billing_company_name'] ?? null,
                'billing_cif' => $validated['billing_cif'] ?? null,
                'billing_reg_com' => $validated['billing_reg_com'] ?? null,

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
                    throw new \Exception("Produsul {$item['title']} este epuizat sau nu are stoc suficient.");
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
            session()->forget(['cart', 'coupon_code', 'shipping_cost']);
            return redirect()->route('checkout.success', $order)->with('success', 'Comanda a fost plasată cu succes!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Eroare la plasarea comenzii: ' . $e->getMessage())->withInput();
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
            return back()->with('error', 'Codul de cupon nu a fost găsit.');
        }

        $validation = $coupon->isValid($cartTotal);

        if (!$validation['valid']) {
            return back()->with('error', $validation['message']);
        }

        // Salvează cuponul în sesiune
        session()->put('coupon_code', $coupon->code);

        return back()->with('success', 'Cupon aplicat cu succes!');
    }

    public function removeCoupon()
    {
        session()->forget('coupon_code');
        return back()->with('success', 'Cupon eliminat cu succes!');
    }

    private function sendOrderEmails(Order $order)
    {
        try {
            // Pregătește datele pentru SmartBill - folosește BILLING (facturare)
            $orderData = [
                'order' => [
                    'order_number' => $order->order_number,
                    'billing_name' => $order->billing_name, // ✅ BILLING
                    'billing_email' => $order->billing_email,
                    'billing_phone' => $order->billing_phone,
                    'billing_address' => $order->billing_address,
                    'billing_city' => $order->billing_city,
                    'billing_county' => $order->billing_county,
                    'billing_country' => $order->billing_country ?? 'Romania',
                    'billing_company_name' => $order->billing_company_name,
                    'billing_cif' => $order->billing_cif,
                    'billing_reg_com' => $order->billing_reg_com,
                    'is_company' => $order->is_company,
                    'shipping_cost' => $order->shipping_cost,
                ],
                'items' => []
            ];

            // Adaugă produsele (folosind 'title' în loc de 'name')
            foreach ($order->items as $item) {
                $orderData['items'][] = [
                    'name' => $item->product->title,
                    'code' => $item->product->code ?? 'PROD' . $item->product->id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ];
            }

            // Creează factura în SmartBill
            $smartbillService = new \App\Services\SmartBillService();
            $invoice = $smartbillService->createInvoice($orderData);

            $invoiceSeries = null;
            $invoiceNumber = null;
            $invoicePdfPath = null;

            if ($invoice) {
                $invoiceSeries = $invoice['series'];
                $invoiceNumber = $invoice['number'];

                // Salvează informațiile facturii în comandă
                $order->update([
                    'smartbill_series' => $invoiceSeries,
                    'smartbill_number' => $invoiceNumber,
                ]);

                // Descarcă PDF-ul facturii și salvează-l local
                $pdfContent = $smartbillService->getInvoicePdf($invoiceSeries, $invoiceNumber);
                if ($pdfContent) {
                    $invoicePdfPath = "invoices/{$order->order_number}_factura_{$invoiceSeries}{$invoiceNumber}.pdf";
                    \Storage::disk('public')->put($invoicePdfPath, $pdfContent);

                    \Log::info('SmartBill Invoice PDF saved', [
                        'series' => $invoiceSeries,
                        'number' => $invoiceNumber,
                        'path' => $invoicePdfPath
                    ]);
                }
            }

            // Trimite email-ul de confirmare către client cu PDF-ul atașat
            Mail::to($order->shipping_email)
                ->send(new OrderConfirmationMail($order, $invoiceSeries, $invoiceNumber, $invoicePdfPath));

            // Trimite email către admin
            Mail::to(config('mail.from.address'))
                ->queue(new OrderCreatedMail($order));
        } catch (\Exception $e) {
            \Log::error('Failed to send order emails or create invoice: ' . $e->getMessage());
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
                    'unit_amount' => intval($item['final_price'] * 100),
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
                    'unit_amount' => intval($order->shipping_cost * 100),
                ],
                'quantity' => 1,
            ];
        }

        $discounts = [];
        if ($order->discount_amount > 0 && $order->coupon) {
            try {
                $stripeCoupon = \Stripe\Coupon::create([
                    'amount_off' => intval($order->discount_amount * 100),
                    'currency' => 'ron',
                    'duration' => 'once',
                    'name' => $order->coupon->code,
                ]);

                $discounts[] = ['coupon' => $stripeCoupon->id];
            } catch (\Exception $e) {
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

        if (!empty($discounts)) {
            $sessionData['discounts'] = $discounts;
        }

        $session = StripeSession::create($sessionData);
        $order->update(['stripe_session_id' => $session->id]);

        return redirect($session->url);
    }

    public function stripeSuccess(Request $request, Order $order)
    {
        $order->update(['payment_status' => 'paid']);
        $order = $order->fresh(['items', 'coupon']);
        $this->sendOrderEmails($order);
        session()->forget(['cart', 'coupon_code', 'shipping_cost']);

        return redirect()->route('checkout.success', $order)
            ->with('success', 'Plata a fost efectuată cu succes! Comanda a fost plasată cu succes!');
    }

    public function stripeCancel(Request $request, Order $order)
    {
        foreach ($order->items as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
                $product->increment('stock', $item->quantity);
            }
        }

        $order->delete();

        return redirect()->route('checkout')
            ->with('error', 'Plata a fost anulată. Vă rugăm să încercați din nou.');
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

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            $order = Order::where('stripe_session_id', $session->id)->first();
            if ($order && $order->payment_status !== 'paid') {
                $order->update(['payment_status' => 'paid']);
            }
        }

        return response()->json(['status' => 'success']);
    }

    public function success(Order $order)
    {
        if (auth()->check() && $order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('checkout.success', compact('order'));
    }

    /**
     * 🔥 REDIS CACHE: Get counties with 24h cache
     */
    public function getCounties()
    {
        try {
            $counties = Cache::remember('sameday_counties', self::CACHE_DURATION_LONG, function () {
                $samedayService = new SamedayService();
                return $samedayService->getCounties();
            });

            \Log::info('Counties loaded from cache', ['count' => count($counties)]);
            return response()->json($counties);
        } catch (\Exception $e) {
            \Log::error('Error loading counties: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load counties'], 500);
        }
    }

    /**
     * 🔥 REDIS CACHE: Get cities by county with 24h cache
     */
    public function getCities(Request $request)
    {
        try {
            $countyId = $request->input('county_id');

            if (!$countyId) {
                return response()->json(['error' => 'County ID required'], 400);
            }

            $cacheKey = "sameday_cities_{$countyId}";

            $cities = Cache::remember($cacheKey, self::CACHE_DURATION_LONG, function () use ($countyId) {
                $samedayService = new SamedayService();
                return $samedayService->getCities($countyId);
            });

            \Log::info("Cities loaded from cache for county {$countyId}", ['count' => count($cities)]);
            return response()->json($cities);
        } catch (\Exception $e) {
            \Log::error('Error loading cities: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load cities'], 500);
        }
    }

    /**
     * 🔥 REDIS CACHE: Get lockers with 24h cache
     */
    public function getLockers(Request $request)
    {
        try {
            $countyId = $request->input('county_id');
            $cityId = $request->input('city_id');

            if (!$countyId || !$cityId) {
                return response()->json(['error' => 'County ID and City ID required'], 400);
            }

            $cacheKey = "sameday_lockers_{$countyId}_{$cityId}";

            $lockers = Cache::remember($cacheKey, self::CACHE_DURATION_LONG, function () use ($countyId, $cityId) {
                $samedayService = new SamedayService();
                $rawLockers = $samedayService->getLockers(0, $countyId, $cityId);

                // Format lockers
                return array_map(function ($locker) {
                    return [
                        'id' => (int) $locker['oohId'],
                        'name' => $locker['name'] ?? '',
                        'address' => $locker['address'] ?? '',
                        'countyId' => $locker['countyId'] ?? null,
                        'cityId' => $locker['cityId'] ?? null,
                    ];
                }, $rawLockers);
            });

            \Log::info("Lockers loaded from cache for county {$countyId}, city {$cityId}", ['count' => count($lockers)]);
            return response()->json($lockers);
        } catch (\Exception $e) {
            \Log::error('Error loading lockers: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load lockers'], 500);
        }
    }

    /**
     * 🔥 REDIS CACHE: Calculate shipping with 1h cache
     */
    public function calculateShipping(Request $request)
    {
        $request->validate([
            'delivery_type' => 'required|in:home,locker',
            'county_id' => 'required|integer',
            'locker_id' => 'nullable|integer',
        ]);

        try {
            $deliveryType = $request->delivery_type;
            $countyId = $request->county_id;
            $lockerId = $request->locker_id;

            // Calculate total weight from cart
            $cartItems = session()->get('cart', []);
            $totalWeight = 0;

            foreach ($cartItems as $item) {
                $totalWeight += ($item['quantity'] * 0.5); // 0.5kg per product
            }

            $totalWeight = max($totalWeight, 1); // Minimum 1kg

            // Cache key includes weight for accuracy
            $cacheKey = "shipping_cost_{$deliveryType}_{$countyId}_{$lockerId}_{$totalWeight}";

            $shippingCost = Cache::remember($cacheKey, self::CACHE_DURATION_SHORT, function () use ($deliveryType, $totalWeight, $countyId, $lockerId) {
                $samedayService = new SamedayService();
                return $samedayService->estimateShippingCost($deliveryType, $totalWeight, $countyId, $lockerId);
            });

            // ✅ Obține și salvează numele județului
            // $counties = Cache::remember(
            //     'sameday_counties',
            //     self::CACHE_DURATION_LONG,
            //     function () {
            //         $samedayService = new SamedayService();
            //         return $samedayService->getCounties();
            //     }
            // );

            // $countyName = collect($counties['data'] ?? [])
            //     ->firstWhere('id', $countyId)['name'] ?? 'Bucuresti';

            // Save to session
            session()->put('shipping_cost', $shippingCost);
            // session()->put('shipping_county_name', $countyName); // ✅ ADĂUGAT

            \Log::info("Shipping cost calculated", [
                'delivery_type' => $deliveryType,
                'county_id' => $countyId,
                //'county_name' => $countyName, // ✅ ADĂUGAT
                'weight' => $totalWeight,
                'cost' => $shippingCost
            ]);

            return response()->json([
                'success' => true,
                'shipping_cost' => $shippingCost,
                'formatted' => number_format($shippingCost, 2)
            ]);
        } catch (\Exception $e) {
            \Log::error('Error calculating shipping: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Could not calculate shipping cost',
                'shipping_cost' => 0
            ], 400);
        }
    }

    /**
     * 🔥 Clear specific Sameday cache (pentru debugging)
     */
    public function clearSamedayCache()
    {
        try {
            // Clear all Sameday related cache
            Cache::forget('sameday_counties');

            // Clear all cities and lockers (wildcard not supported in Predis, so manual clear)
            // În producție, folosește Redis tags sau pattern matching

            return response()->json([
                'success' => true,
                'message' => 'Sameday cache cleared successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
