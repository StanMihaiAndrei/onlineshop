<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">My Orders</h1>

            @if($orders->count() > 0)
                <div class="space-y-4">
                    @foreach($orders as $order)
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4 mb-4">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Order {{ $order->order_number }}</h3>
                                    <p class="text-sm text-gray-600">Placed on {{ $order->created_at->format('F d, Y') }}</p>
                                </div>
                                
                                <div class="flex gap-2">
                                    <span class="px-3 py-1 text-sm font-semibold rounded-full 
                                        {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                            </div>

                            <div class="border-t border-gray-200 pt-4">
                                <div class="space-y-3 mb-4">
                                    @foreach($order->items as $item)
                                        <div class="flex gap-3">
                                            @if($item->product && $item->product->first_image)
                                                <img src="{{ asset('storage/' . $item->product->first_image) }}" 
                                                     alt="{{ $item->product_title }}"
                                                     class="w-16 h-16 object-cover rounded">
                                            @else
                                                <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                                    <span class="text-gray-400 text-xs">No image</span>
                                                </div>
                                            @endif
                                            
                                            <div class="flex-1">
                                                <h4 class="text-sm font-medium text-gray-900">{{ $item->product_title }}</h4>
                                                <p class="text-sm text-gray-600">Qty: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}</p>
                                            </div>
                                            
                                            <div class="text-right">
                                                <p class="text-sm font-semibold text-gray-900">${{ number_format($item->subtotal, 2) }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                                    <span class="text-lg font-semibold text-gray-900">Total: ${{ number_format($order->total_amount, 2) }}</span>
                                    <a href="{{ route('orders.show', $order) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                        View Details →
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No orders yet</h3>
                    <p class="text-gray-600 mb-6">Start shopping to create your first order!</p>
                    <a href="{{ route('shop') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition">
                        Browse Products
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>