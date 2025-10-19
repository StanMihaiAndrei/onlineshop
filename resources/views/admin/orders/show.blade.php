<!-- filepath: c:\Apache24\htdocs\onlineshop\resources\views\admin\orders\show.blade.php -->
<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('admin.orders.index') }}" class="text-blue-600 hover:text-blue-800">
                    ← Back to Orders
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Order Details -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Order Info -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Order {{ $order->order_number }}</h2>
                        
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <p class="text-sm text-gray-600">Order Date</p>
                                <p class="font-medium">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Total Amount</p>
                                <p class="font-bold text-xl text-blue-600">${{ number_format($order->total_amount, 2) }}</p>
                            </div>
                        </div>

                        <!-- Update Status -->
                        <div class="border-t pt-4">
                            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="flex gap-2 items-end">
                                @csrf
                                @method('PATCH')
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Order Status</label>
                                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </div>
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                                    Update
                                </button>
                            </form>
                        </div>

                        <!-- Update Payment Status -->
                        <div class="border-t pt-4 mt-4">
                            <form action="{{ route('admin.orders.updatePayment', $order) }}" method="POST" class="flex gap-2 items-end">
                                @csrf
                                @method('PATCH')
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Payment Status</label>
                                    <select name="payment_status" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                        <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                                        <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Failed</option>
                                    </select>
                                </div>
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg">
                                    Update
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Order Items</h3>
                        
                        <div class="space-y-4">
                            @foreach($order->items as $item)
                                <div class="flex gap-4 border-b pb-4 last:border-b-0">
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
                                        <h4 class="font-medium text-gray-900">{{ $item->product_title }}</h4>
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
                </div>

                <!-- Customer & Shipping Info -->
                <div class="space-y-6">
                    <!-- Customer Info -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Customer Information</h3>
                        
                        <div class="space-y-2">
                            <div>
                                <p class="text-sm text-gray-600">Name</p>
                                <p class="font-medium">{{ $order->shipping_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Email</p>
                                <p class="font-medium">{{ $order->shipping_email }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Phone</p>
                                <p class="font-medium">{{ $order->shipping_phone }}</p>
                            </div>
                            @if($order->user)
                                <div>
                                    <p class="text-sm text-gray-600">Account</p>
                                    <a href="{{ route('admin.users.show', $order->user) }}" class="text-blue-600 hover:text-blue-800">
                                        View User Profile
                                    </a>
                                </div>
                            @else
                                <div>
                                    <p class="text-sm text-gray-500 italic">Guest Order</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Shipping Address</h3>
                        
                        <div class="space-y-1">
                            <p class="font-medium">{{ $order->shipping_address }}</p>
                            <p>{{ $order->shipping_city }}, {{ $order->shipping_postal_code }}</p>
                            <p>{{ $order->shipping_country }}</p>
                        </div>
                    </div>

                    <!-- Payment Info -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Payment Information</h3>
                        
                        <div class="space-y-2">
                            <div>
                                <p class="text-sm text-gray-600">Payment Method</p>
                                <p class="font-medium">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Notes -->
                    @if($order->notes)
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Order Notes</h3>
                            <p class="text-gray-700">{{ $order->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>