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
                        <span class="font-medium">FREE</span>
                    </div>
                    <div class="flex justify-between pt-2 border-t border-gray-200">
                        <span class="text-lg font-bold">Total</span>
                        <span class="text-xl font-bold text-blue-600">${{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="border-t border-gray-200 pt-6 grid md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="font-bold text-gray-900 mb-2">Shipping Address</h3>
                        <p class="text-gray-700">{{ $order->shipping_name }}</p>
                        <p class="text-gray-700">{{ $order->shipping_address }}</p>
                        <p class="text-gray-700">{{ $order->shipping_city }}, {{ $order->shipping_postal_code }}</p>
                        <p class="text-gray-700">{{ $order->shipping_country }}</p>
                    </div>
                    
                    <div>
                        <h3 class="font-bold text-gray-900 mb-2">Payment Method</h3>
                        <p class="text-gray-700">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
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