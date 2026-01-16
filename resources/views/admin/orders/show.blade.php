<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Detalii Comandă</h2>
                        <a href="{{ route('admin.orders.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Înapoi la Comenzi
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Order Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold mb-3">Informații Comandă</h3>
                            <p><strong>Număr Comandă:</strong> {{ $order->order_number }}</p>
                            <p><strong>Data:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                            
                            @if($order->coupon_id && $order->discount_amount > 0)
                                <div class="bg-green-50 border border-green-200 rounded p-2 my-2">
                                    <p class="text-green-800"><strong>🎉 Cupon Aplicat:</strong> {{ $order->coupon->code }}</p>
                                    <p class="text-green-700 text-sm">
                                        Discount: ${{ number_format($order->discount_amount, 2) }}
                                        @if($order->coupon->type === 'percentage')
                                            ({{ $order->coupon->value }}% off)
                                        @endif
                                    </p>
                                </div>
                            @endif
                            
                            <p><strong>Total:</strong> ${{ number_format($order->total_amount, 2) }}</p>
                            <p><strong>Metodă Plată:</strong> {{ $order->payment_method === 'card' ? 'Card' : 'Ramburs' }}</p>
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
                            <p><strong>Status Plată:</strong> 
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
                            <h3 class="text-lg font-semibold mb-3">Informații Client</h3>
                            <p><strong>Nume:</strong> {{ $order->shipping_name }}</p>
                            <p><strong>Tip:</strong> {{ $order->is_company ? 'Persoană Juridică' : 'Persoană Fizică' }}</p>
                            <p><strong>Email:</strong> {{ $order->shipping_email }}</p>
                            <p><strong>Telefon:</strong> {{ $order->shipping_phone }}</p>
                            <p><strong>Tip Livrare:</strong> 
                                @if($order->delivery_type === 'home')
                                    🏠 Domiciliu
                                @else
                                    📦 Easybox
                                @endif
                            </p>
                            @if($order->delivery_type === 'home')
                                <p><strong>Adresă:</strong> {{ $order->shipping_address }}, {{ $order->shipping_city }}, {{ $order->shipping_postal_code }}, {{ $order->shipping_country }}</p>
                            @else
                                <p><strong>Locker:</strong> {{ $order->sameday_locker_name }}</p>
                                <p><strong>Oraș:</strong> {{ $order->shipping_city }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Sameday AWB Section -->
                    @if($order->sameday_county_id && $order->sameday_city_id)
                        <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-6 mb-6">
                            <h3 class="text-lg font-semibold mb-4 text-blue-900">📦 Livrare Sameday</h3>
                            
                            @if($order->hasAwb())
                                <!-- AWB exists -->
                                <div class="bg-white rounded-lg p-4 mb-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-sm text-gray-600">Număr AWB</p>
                                            <p class="text-lg font-bold text-blue-600">{{ $order->sameday_awb_number }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600">Cost Livrare</p>
                                            <p class="text-lg font-semibold">${{ number_format($order->sameday_awb_cost, 2) }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600">Status AWB</p>
                                            <p class="text-sm font-semibold">
                                                <span class="px-2 py-1 rounded-full text-xs
                                                    @if($order->sameday_awb_status === 'created') bg-blue-100 text-blue-800
                                                    @elseif($order->sameday_awb_status === 'in_transit') bg-yellow-100 text-yellow-800
                                                    @elseif($order->sameday_awb_status === 'delivered') bg-green-100 text-green-800
                                                    @elseif($order->sameday_awb_status === 'returned') bg-red-100 text-red-800
                                                    @endif">
                                                    {{ ucfirst(str_replace('_', ' ', $order->sameday_awb_status)) }}
                                                </span>
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600">Greutate</p>
                                            <p class="text-sm">{{ $order->getTotalWeight() }} kg</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex gap-3">
                                    @if($order->sameday_awb_pdf)
                                        <a href="{{ route('admin.orders.downloadAwbPdf', $order) }}" 
                                           class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            Descarcă AWB PDF
                                        </a>
                                    @endif

                                    <form action="{{ route('admin.orders.syncAwbStatus', $order) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                            Sincronizează Status
                                        </button>
                                    </form>
                                </div>

                                @if($order->sameday_tracking_history)
                                    <div class="mt-4 bg-white rounded-lg p-4">
                                        <h4 class="font-semibold mb-2">Istoric Tracking</h4>
                                        <div class="text-sm text-gray-600">
                                            <pre class="whitespace-pre-wrap">{{ json_encode($order->sameday_tracking_history, JSON_PRETTY_PRINT) }}</pre>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <!-- No AWB yet -->
                                <div class="mb-4">
                                    <p class="text-gray-700 mb-4">AWB nu a fost creat încă. Crează AWB pentru a activa livrarea.</p>
                                    
                                    @if(!$order->canCreateAwb())
                                        <div class="bg-yellow-50 border border-yellow-200 rounded p-3 mb-4">
                                            <p class="text-sm text-yellow-800">
                                                ⚠️ Pentru a crea AWB, comanda trebuie să fie plătită și să aibă status "pending" sau "processing".
                                            </p>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex gap-3">
                                    @if($order->delivery_type === 'home')
                                        <form action="{{ route('admin.orders.createHomeAwb', $order) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded inline-flex items-center {{ !$order->canCreateAwb() ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                    {{ !$order->canCreateAwb() ? 'disabled' : '' }}>
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                                </svg>
                                                🚚 Creează AWB - Livrare la Domiciliu
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.orders.createLockerAwb', $order) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-6 rounded inline-flex items-center {{ !$order->canCreateAwb() ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                    {{ !$order->canCreateAwb() ? 'disabled' : '' }}>
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                </svg>
                                                📦 Creează AWB - Livrare la Easybox
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Status Update Forms -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold mb-3">Status Comandă</h3>
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
                                    Actualizează Status
                                </button>
                            </form>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold mb-3">Status Plată</h3>
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
                                    Actualizează Plată
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold mb-3">Produse Comandate</h3>
                        <div class="space-y-3">
                            @foreach($order->items as $item)
                                <div class="flex justify-between items-center bg-white p-3 rounded">
                                    <div>
                                        <p class="font-medium">{{ $item->product_title }}</p>
                                        <p class="text-sm text-gray-600">Cantitate: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}</p>
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
                                    <span class="text-gray-700">Subtotal produse:</span>
                                    <span class="font-medium">${{ number_format($subtotal, 2) }}</span>
                                </div>
                                
                                @if($order->discount_amount > 0)
                                    <div class="flex justify-between items-center mb-2 text-green-600">
                                        <span>Discount ({{ $order->coupon->code }}):</span>
                                        <span class="font-medium">-${{ number_format($order->discount_amount, 2) }}</span>
                                    </div>
                                @endif
                                
                                @if($order->shipping_cost > 0)
                                    <div class="flex justify-between items-center mb-2 text-blue-600">
                                        <span>
                                            🚚 Cost livrare Sameday 
                                            @if($order->delivery_type === 'locker')
                                                (📦 Easybox)
                                            @else
                                                (🏠 Domiciliu)
                                            @endif
                                        </span>
                                        <span class="font-medium">${{ number_format($order->shipping_cost, 2) }}</span>
                                    </div>
                                @endif
                                
                                <div class="flex justify-between items-center font-bold text-lg pt-2 border-t">
                                    <span>Total de plată:</span>
                                    <span class="text-blue-600">${{ number_format($order->total_amount, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($order->notes)
                        <div class="bg-gray-50 p-4 rounded-lg mt-6">
                            <h3 class="text-lg font-semibold mb-3">Notițe Comandă</h3>
                            <p>{{ $order->notes }}</p>
                        </div>
                    @endif

                    @if($order->cancellation_reason)
                        <div class="bg-red-50 border border-red-200 p-4 rounded-lg mt-6">
                            <h3 class="text-lg font-semibold mb-3 text-red-800">Motiv Anulare</h3>
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
                e.target.value = '{{ $order->status }}';
                return false;
            }
        });

        function closeCancelModal() {
            document.getElementById('cancelModal').classList.add('hidden');
            document.getElementById('statusSelect').value = '{{ $order->status }}';
        }

        document.getElementById('cancelModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeCancelModal();
            }
        });
    </script>
</x-app-layout>