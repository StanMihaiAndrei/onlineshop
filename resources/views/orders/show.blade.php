<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('orders.index') }}" class="text-blue-600 hover:text-blue-800">
                    ← Back to My Orders
                </a>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 md:p-8">
                <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4 mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Order {{ $order->order_number }}</h1>
                        <p class="text-gray-600">Placed on {{ $order->created_at->format('F d, Y \a\t H:i') }}</p>
                    </div>
                    
                    <span class="px-4 py-2 text-sm font-semibold rounded-full 
                        {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                        {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                @if($order->coupon_id && $order->discount_amount > 0)
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                        <div class="flex items-start gap-2">
                            <span class="text-2xl">🎉</span>
                            <div>
                                <p class="font-semibold text-green-800">Coupon Applied: {{ $order->coupon->code }}</p>
                                <p class="text-sm text-green-700">
                                    You saved ${{ number_format($order->discount_amount, 2) }}
                                    @if($order->coupon->type === 'percentage')
                                        ({{ $order->coupon->value }}% discount)
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Shipping Information Section -->
                @if($order->status !== 'cancelled')
                    <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-6 mb-6">
                        <h2 class="text-lg font-bold text-blue-900 mb-4 flex items-center gap-2">
                            <span class="text-2xl">🚚</span>
                            Shipping Information
                        </h2>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between items-start">
                                <span class="text-sm text-gray-600 font-medium">Delivery Type:</span>
                                <span class="text-sm font-semibold text-gray-900">
                                    @if($order->delivery_type === 'home')
                                        🏠 Home Delivery
                                    @else
                                        📦 EasyBox Delivery
                                    @endif
                                </span>
                            </div>

                            @if($order->delivery_type === 'home')
                                <div class="bg-white rounded-lg p-3 border border-blue-100">
                                    <p class="text-xs text-gray-500 mb-1">Delivery Address:</p>
                                    <p class="text-sm font-medium text-gray-900">{{ $order->shipping_address }}</p>
                                    <p class="text-sm text-gray-700">{{ $order->shipping_city }}@if($order->shipping_postal_code), {{ $order->shipping_postal_code }}@endif</p>
                                    <p class="text-sm text-gray-700">{{ $order->shipping_country }}</p>
                                </div>
                            @else
                                <div class="bg-white rounded-lg p-3 border border-blue-100">
                                    <p class="text-xs text-gray-500 mb-1">EasyBox Location:</p>
                                    <p class="text-sm font-semibold text-gray-900">{{ $order->sameday_locker_name }}</p>
                                    <p class="text-sm text-gray-700">{{ $order->shipping_city }}</p>
                                </div>
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                                    <p class="text-xs text-yellow-800">
                                        <span class="font-semibold">💡 Note:</span> You will receive an SMS/email with the EasyBox opening code when your package arrives.
                                    </p>
                                </div>
                            @endif

                            <div class="flex justify-between items-start">
                                <span class="text-sm text-gray-600 font-medium">Shipping Cost:</span>
                                <span class="text-sm font-semibold {{ $order->shipping_cost > 0 ? 'text-gray-900' : 'text-green-600' }}">
                                    @if($order->shipping_cost > 0)
                                        ${{ number_format($order->shipping_cost, 2) }}
                                    @else
                                        FREE
                                    @endif
                                </span>
                            </div>

                            @if($order->sameday_awb_number)
                                <div class="bg-green-50 border-2 border-green-300 rounded-lg p-4 mt-4">
                                    <p class="text-sm font-semibold text-green-900 mb-2">📦 Package Tracking</p>
                                    <p class="text-xs text-green-700 mb-1">AWB Number:</p>
                                    <p class="text-lg font-bold text-green-900 font-mono mb-3">{{ $order->sameday_awb_number }}</p>
                                    <a href="https://sameday.ro/tracking" target="_blank" 
                                       class="inline-flex items-center gap-2 text-sm text-green-700 hover:text-green-900 font-medium underline">
                                        Track your package
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                    </a>
                                </div>
                            @else
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mt-4">
                                    <p class="text-xs text-yellow-800">
                                        <span class="font-semibold">⏳ Tracking number pending</span> - You will receive the AWB number via email once your package is picked up by the courier.
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                @if($order->status === 'cancelled' && $order->cancellation_reason)
                    <div class="bg-red-50 border-2 border-red-200 rounded-lg p-4 mb-6">
                        <h3 class="font-bold text-red-900 mb-2 flex items-center gap-2">
                            <span class="text-xl">⚠️</span>
                            Cancellation Reason:
                        </h3>
                        <p class="text-sm text-red-800">{{ $order->cancellation_reason }}</p>
                    </div>
                @endif

                <!-- Order Items -->
                <div class="border-t border-gray-200 pt-6 mb-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Order Items</h2>
                    
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                            <div class="flex gap-4">
                                @if($item->product && $item->product->first_image)
                                    <img src="{{ asset('storage/' . $item->product->first_image) }}" 
                                         alt="{{ $item->product_title }}"
                                         class="w-20 h-20 object-cover rounded">
                                @else
                                    <div class="w-20 h-20 bg-gray-200 rounded flex items-center justify-center">
                                        <span class="text-gray-400 text-xs">No image</span>
                                    </div>
                                @endif
                                
                                <div class="flex-1">
                                    <h3 class="font-medium text-gray-900">{{ $item->product_title }}</h3>
                                    <p class="text-sm text-gray-600">Quantity: {{ $item->quantity }}</p>
                                    <p class="text-sm text-gray-600">Price: ${{ number_format($item->price, 2) }}</p>
                                </div>
                                
                                <div class="text-right">
                                    <p class="font-semibold text-gray-900">${{ number_format($item->subtotal, 2) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="border-t border-gray-200 pt-6 mb-6">
                    @php
                        $subtotal = $order->items->sum('subtotal');
                    @endphp
                    
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-medium">${{ number_format($subtotal, 2) }}</span>
                    </div>
                    
                    @if($order->discount_amount > 0)
                        <div class="flex justify-between mb-2 text-green-600">
                            <span>Discount ({{ $order->coupon->code }})</span>
                            <span class="font-medium">-${{ number_format($order->discount_amount, 2) }}</span>
                        </div>
                    @endif
                    
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Shipping</span>
                        <span class="font-medium {{ $order->shipping_cost > 0 ? '' : 'text-green-600' }}">
                            @if($order->shipping_cost > 0)
                                ${{ number_format($order->shipping_cost, 2) }}
                            @else
                                FREE
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between pt-2 border-t border-gray-200">
                        <span class="text-lg font-bold">Total</span>
                        <span class="text-xl font-bold text-blue-600">${{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>

                <!-- Contact & Payment Info -->
                <div class="border-t border-gray-200 pt-6 grid md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="font-bold text-gray-900 mb-2">Contact Information</h3>
                        <p class="text-gray-700">{{ $order->shipping_name }}</p>
                        <p class="text-gray-700">{{ $order->shipping_email }}</p>
                        <p class="text-gray-700">{{ $order->shipping_phone }}</p>
                    </div>
                    
                    <div>
                        <h3 class="font-bold text-gray-900 mb-2">Payment Method</h3>
                        <p class="text-gray-700">
                            @if($order->payment_method === 'card')
                                💳 Card Payment
                            @else
                                💵 Cash on Delivery
                            @endif
                        </p>
                        <p class="text-sm text-gray-600 mt-2">
                            Payment Status: 
                            <span class="font-semibold {{ $order->payment_status === 'paid' ? 'text-green-600' : 'text-yellow-600' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </p>
                    </div>
                </div>

                @if($order->notes)
                    <div class="border-t border-gray-200 pt-6 mt-6">
                        <h3 class="font-bold text-gray-900 mb-2">Order Notes</h3>
                        <p class="text-gray-700">{{ $order->notes }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>