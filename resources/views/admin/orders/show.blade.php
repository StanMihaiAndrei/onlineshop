<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Order Details</h2>
                        <a href="{{ route('admin.orders.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back to Orders
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Order Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold mb-3">Order Information</h3>
                            <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
                            <p><strong>Date:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                            
                            @if($order->coupon_id && $order->discount_amount > 0)
                                <div class="bg-green-50 border border-green-200 rounded p-2 my-2">
                                    <p class="text-green-800"><strong>🎉 Coupon Applied:</strong> {{ $order->coupon->code }}</p>
                                    <p class="text-green-700 text-sm">
                                        Discount: ${{ number_format($order->discount_amount, 2) }}
                                        @if($order->coupon->type === 'percentage')
                                            ({{ $order->coupon->value }}% off)
                                        @endif
                                    </p>
                                </div>
                            @endif
                            
                            <p><strong>Total:</strong> ${{ number_format($order->total_amount, 2) }}</p>
                            <p><strong>Payment Method:</strong> {{ $order->payment_method === 'card' ? 'Card' : 'Cash on Delivery' }}</p>
                            <p><strong>Status:</strong> 
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                    @elseif($order->status === 'completed') bg-green-100 text-green-800
                                    @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </p>
                            <p><strong>Payment Status:</strong> 
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($order->payment_status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($order->payment_status === 'paid') bg-green-100 text-green-800
                                    @elseif($order->payment_status === 'failed') bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold mb-3">Customer Information</h3>
                            <p><strong>Name:</strong> {{ $order->shipping_name }}</p>
                            <p><strong>Email:</strong> {{ $order->shipping_email }}</p>
                            <p><strong>Phone:</strong> {{ $order->shipping_phone }}</p>
                            <p><strong>Address:</strong> {{ $order->shipping_address }}, {{ $order->shipping_city }}, {{ $order->shipping_postal_code }}, {{ $order->shipping_country }}</p>
                        </div>
                    </div>

                    <!-- Status Update Forms -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold mb-3">Order Status</h3>
                            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" id="statusForm">
                                @csrf
                                @method('PATCH')
                                <div class="mb-4">
                                    <select name="status" id="statusSelect" class="w-full border border-gray-300 rounded-md px-3 py-2">
                                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </div>
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Update Status
                                </button>
                            </form>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold mb-3">Payment Status</h3>
                            <form action="{{ route('admin.orders.updatePayment', $order) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="mb-4">
                                    <select name="payment_status" class="w-full border border-gray-300 rounded-md px-3 py-2">
                                        <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                                        <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Failed</option>
                                    </select>
                                </div>
                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    Update Payment
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold mb-3">Order Items</h3>
                        <div class="space-y-3">
                            @foreach($order->items as $item)
                                <div class="flex justify-between items-center bg-white p-3 rounded">
                                    <div>
                                        <p class="font-medium">{{ $item->product_title }}</p>
                                        <p class="text-sm text-gray-600">Quantity: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-medium">${{ number_format($item->subtotal, 2) }}</p>
                                    </div>
                                </div>
                            @endforeach
                            
                            <div class="border-t pt-3 mt-3">
                                @php
                                    $subtotal = $order->items->sum('subtotal');
                                @endphp
                                
                                <div class="flex justify-between items-center mb-2">
                                    <span>Subtotal:</span>
                                    <span>${{ number_format($subtotal, 2) }}</span>
                                </div>
                                
                                @if($order->discount_amount > 0)
                                    <div class="flex justify-between items-center mb-2 text-green-600">
                                        <span>Discount ({{ $order->coupon->code }}):</span>
                                        <span>-${{ number_format($order->discount_amount, 2) }}</span>
                                    </div>
                                @endif
                                
                                <div class="flex justify-between items-center font-bold text-lg pt-2 border-t">
                                    <span>Total:</span>
                                    <span>${{ number_format($order->total_amount, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($order->notes)
                        <div class="bg-gray-50 p-4 rounded-lg mt-6">
                            <h3 class="text-lg font-semibold mb-3">Order Notes</h3>
                            <p>{{ $order->notes }}</p>
                        </div>
                    @endif

                    @if($order->cancellation_reason)
                        <div class="bg-red-50 border border-red-200 p-4 rounded-lg mt-6">
                            <h3 class="text-lg font-semibold mb-3 text-red-800">Cancellation Reason</h3>
                            <p class="text-red-700">{{ $order->cancellation_reason }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal pentru motivul anulării -->
    <div id="cancelModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Anulare comandă</h3>
                <p class="text-gray-600 mb-4">Te rugăm să specifici motivul pentru care anulezi această comandă:</p>
                
                <form id="cancelForm" action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="cancelled">
                    
                    <div class="mb-4">
                        <textarea 
                            name="cancellation_reason" 
                            rows="4" 
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                            placeholder="Introdu motivul anulării..." 
                            required
                        ></textarea>
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeCancelModal()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Renunță
                        </button>
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Anulează comanda
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('statusSelect').addEventListener('change', function(e) {
            if (e.target.value === 'cancelled') {
                e.preventDefault();
                document.getElementById('cancelModal').classList.remove('hidden');
                // Reset the select to previous value
                e.target.value = '{{ $order->status }}';
                return false;
            }
        });

        function closeCancelModal() {
            document.getElementById('cancelModal').classList.add('hidden');
            document.getElementById('statusSelect').value = '{{ $order->status }}';
        }

        // Close modal when clicking outside
        document.getElementById('cancelModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeCancelModal();
            }
        });
    </script>
</x-app-layout>