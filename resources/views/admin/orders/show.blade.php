<x-app-layout>
    <div class="py-4 sm:py-6">
        <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    <!-- Header optimizat pentru mobile -->
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-6">
                        <h2 class="text-lg sm:text-2xl font-bold text-gray-800">Detalii Comandă</h2>
                        <a href="{{ route('admin.orders.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white text-sm font-semibold py-2 px-3 rounded text-center whitespace-nowrap">
                            ← Înapoi
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-3 py-2 text-sm rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-3 py-2 text-sm rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Order Info & Invoice Section -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 mb-6">
                        <!-- Order Information -->
                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-4 rounded-lg border-l-4 border-blue-500 shadow-sm">
                            <h3 class="text-base sm:text-lg font-semibold mb-3 flex items-center gap-2 text-blue-900">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Informații Comandă
                            </h3>
                            <div class="space-y-2">
                                <p class="text-sm sm:text-base"><strong>Număr:</strong> <span class="font-mono">{{ $order->order_number }}</span></p>
                                <p class="text-sm sm:text-base"><strong>Data:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                                
                                @if($order->coupon_id && $order->discount_amount > 0)
                                    <div class="bg-green-50 border border-green-200 rounded p-2 my-2">
                                        <p class="text-green-800 text-sm"><strong>🎉 Cupon:</strong> {{ $order->coupon->code }}</p>
                                        <p class="text-green-700 text-xs sm:text-sm">
                                            Discount: RON {{ number_format($order->discount_amount, 2) }}
                                            @if($order->coupon->type === 'percentage')
                                                ({{ $order->coupon->value }}% off)
                                            @endif
                                        </p>
                                    </div>
                                @endif
                                
                                <p class="text-sm sm:text-base"><strong>Total:</strong> <span class="text-lg font-bold text-blue-600">RON {{ number_format($order->total_amount, 2) }}</span></p>
                                <p class="text-sm sm:text-base"><strong>Metodă Plată:</strong> {{ $order->payment_method === 'card' ? '💳 Card' : '💵 Ramburs' }}</p>
                                <p class="text-sm sm:text-base"><strong>Status:</strong> 
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                        @elseif($order->status === 'delivering') bg-purple-100 text-purple-800
                                        @elseif($order->status === 'completed') bg-green-100 text-green-800
                                        @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                        @endif">
                                        {{ $order->status_label }}
                                    </span>
                                </p>
                                <p class="text-sm sm:text-base"><strong>Status Plată:</strong> 
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($order->payment_status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($order->payment_status === 'paid') bg-green-100 text-green-800
                                        @elseif($order->payment_status === 'failed') bg-red-100 text-red-800
                                        @endif">
                                        {{ $order->payment_status_label }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <!-- Invoice Information -->
                        <div class="bg-gradient-to-br from-purple-50 to-pink-50 p-4 rounded-lg border-l-4 border-purple-500 shadow-sm">
                            <h3 class="text-base sm:text-lg font-semibold mb-3 flex items-center gap-2 text-purple-900">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Date Facturare
                            </h3>
                            <div class="space-y-2">
                                @if($order->smartbill_series && $order->smartbill_number)
                                    <div class="bg-green-50 border-2 border-green-300 rounded-lg p-3 mb-3">
                                        <p class="text-sm font-semibold text-green-900 mb-1">✅ Factură Emisă</p>
                                        <p class="text-lg font-bold font-mono text-green-800">{{ $order->smartbill_series }}-{{ $order->smartbill_number }}</p>
                                        <a href="{{ route('admin.orders.downloadInvoice', $order) }}" 
                                           target="_blank"
                                           class="inline-flex items-center gap-1 text-xs text-green-700 hover:text-green-900 font-medium underline mt-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            Descarcă Factură PDF
                                        </a>
                                    </div>
                                @else
                                    <div class="bg-yellow-50 border border-yellow-200 rounded p-2 mb-3">
                                        <p class="text-xs text-yellow-800">⏳ Factură în curs de emitere</p>
                                    </div>
                                @endif

                                <p class="text-sm sm:text-base"><strong>Tip:</strong> {{ $order->is_company ? '🏢 Persoană Juridică' : '👤 Persoană Fizică' }}</p>
                                
                                @if($order->is_company)
                                    <p class="text-sm sm:text-base"><strong>Firmă:</strong> {{ $order->billing_company_name ?? 'N/A' }}</p>
                                    <p class="text-sm sm:text-base"><strong>CIF:</strong> {{ $order->billing_cif ?? 'N/A' }}</p>
                                    @if($order->billing_reg_com)
                                        <p class="text-sm sm:text-base"><strong>Reg. Com.:</strong> {{ $order->billing_reg_com }}</p>
                                    @endif
                                @endif

                                <p class="text-sm sm:text-base"><strong>Nume:</strong> {{ $order->billing_name ?? $order->shipping_name }}</p>
                                <p class="text-sm sm:text-base"><strong>Email:</strong> <span class="break-all">{{ $order->billing_email ?? $order->shipping_email }}</span></p>
                                <p class="text-sm sm:text-base"><strong>Telefon:</strong> {{ $order->billing_phone ?? $order->shipping_phone }}</p>
                                
                                @if($order->billing_address)
                                    <div class="text-sm sm:text-base">
                                        <strong>Adresă Facturare:</strong>
                                        <p class="text-gray-700 mt-1">
                                            {{ $order->billing_address }}<br>
                                            {{ $order->billing_city }}@if($order->billing_postal_code), {{ $order->billing_postal_code }}@endif<br>
                                            {{ $order->billing_county }}, {{ $order->billing_country }}
                                        </p>
                                    </div>
                                @else
                                    <p class="text-xs text-gray-500 italic">Adresă facturare identică cu livrarea</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Shipping & Billing Section Side by Side -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 mb-6">
                        <!-- Shipping Information -->
                        <div class="bg-gradient-to-br from-green-50 to-teal-50 p-4 rounded-lg border-l-4 border-green-500 shadow-sm">
                            <h3 class="text-base sm:text-lg font-semibold mb-3 flex items-center gap-2 text-green-900">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                </svg>
                                Date Livrare
                            </h3>
                            <div class="space-y-2">
                                <p class="text-sm sm:text-base"><strong>Tip Livrare:</strong> 
                                    @if($order->delivery_type === 'home')
                                        🏠 Domiciliu
                                    @else
                                        📦 Easybox
                                    @endif
                                </p>
                                @if($order->delivery_type === 'home')
                                    <div class="bg-white rounded p-2 border border-green-200">
                                        <p class="text-sm"><strong>{{ $order->shipping_name }}</strong></p>
                                        <p class="text-sm text-gray-700">{{ $order->shipping_address }}</p>
                                        <p class="text-sm text-gray-700">{{ $order->shipping_city }}, {{ $order->shipping_postal_code }}</p>
                                        <p class="text-sm text-gray-700">{{ $order->shipping_country }}</p>
                                    </div>
                                @else
                                    <div class="bg-white rounded p-2 border border-green-200">
                                        <p class="text-sm"><strong>Locker:</strong> {{ $order->sameday_locker_name }}</p>
                                        <p class="text-sm text-gray-700"><strong>Oraș:</strong> {{ $order->shipping_city }}</p>
                                    </div>
                                @endif
                                <p class="text-sm sm:text-base"><strong>Email:</strong> <span class="break-all">{{ $order->shipping_email }}</span></p>
                                <p class="text-sm sm:text-base"><strong>Telefon:</strong> {{ $order->shipping_phone }}</p>
                            </div>
                        </div>

                        <!-- Client Notes -->
                        @if($order->notes || $order->cancellation_reason)
                            <div class="bg-gradient-to-br from-amber-50 to-orange-50 p-4 rounded-lg border-l-4 border-amber-500 shadow-sm">
                                <h3 class="text-base sm:text-lg font-semibold mb-3 flex items-center gap-2 text-amber-900">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                    </svg>
                                    Notițe
                                </h3>
                                @if($order->notes)
                                    <div class="bg-white rounded p-3 border border-amber-200 mb-3">
                                        <p class="text-xs font-semibold text-gray-500 mb-1">Notițe Client:</p>
                                        <p class="text-sm">{{ $order->notes }}</p>
                                    </div>
                                @endif
                                @if($order->cancellation_reason)
                                    <div class="bg-red-50 border border-red-200 rounded p-3">
                                        <p class="text-xs font-semibold text-red-700 mb-1">⚠️ Motiv Anulare:</p>
                                        <p class="text-sm text-red-800">{{ $order->cancellation_reason }}</p>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Sameday AWB Section -->
                    @if($order->sameday_county_id && $order->sameday_city_id)
                        <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-4 sm:p-6 mb-6">
                            <h3 class="text-base sm:text-lg font-semibold mb-4 text-blue-900">📦 Livrare Sameday</h3>
                            
                            @if($order->hasAwb())
                                <div class="bg-white rounded-lg p-3 sm:p-4 mb-4">
                                    <div class="grid grid-cols-2 gap-3 sm:gap-4">
                                        <div>
                                            <p class="text-xs sm:text-sm text-gray-600">Număr AWB</p>
                                            <p class="text-sm sm:text-lg font-bold text-blue-600 break-all">{{ $order->sameday_awb_number }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs sm:text-sm text-gray-600">Cost Livrare</p>
                                            <p class="text-sm sm:text-lg font-semibold">RON {{ number_format($order->sameday_awb_cost, 2) }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs sm:text-sm text-gray-600">Status AWB</p>
                                            <p class="text-xs sm:text-sm font-semibold">
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
                                            <p class="text-xs sm:text-sm text-gray-600">Greutate</p>
                                            <p class="text-xs sm:text-sm">{{ $order->getTotalWeight() }} kg</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                                    @if($order->sameday_awb_pdf)
                                        <a href="{{ route('admin.orders.downloadAwbPdf', $order) }}" 
                                           class="bg-green-500 hover:bg-green-600 text-white text-xs sm:text-sm font-semibold py-2 px-3 rounded inline-flex items-center justify-center">
                                            <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <span class="hidden sm:inline">Descarcă AWB PDF</span>
                                            <span class="sm:hidden">AWB PDF</span>
                                        </a>
                                    @endif

                                    <form action="{{ route('admin.orders.syncAwbStatus', $order) }}" method="POST" class="flex-1 sm:flex-initial">
                                        @csrf
                                        <button type="submit" class="w-full sm:w-auto bg-blue-500 hover:bg-blue-600 text-white text-xs sm:text-sm font-semibold py-2 px-3 rounded inline-flex items-center justify-center">
                                            <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                            <span class="hidden sm:inline">Sincronizează Status</span>
                                            <span class="sm:hidden">Sincronizează</span>
                                        </button>
                                    </form>
                                </div>

                                @if($order->sameday_tracking_history)
                                    <div class="mt-4 bg-white rounded-lg p-3 sm:p-4">
                                        <h4 class="font-semibold mb-2 text-sm sm:text-base">Istoric Tracking</h4>
                                        <div class="text-xs sm:text-sm text-gray-600 overflow-x-auto">
                                            <pre class="whitespace-pre-wrap break-all">{{ json_encode($order->sameday_tracking_history, JSON_PRETTY_PRINT) }}</pre>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="mb-4">
                                    <p class="text-sm sm:text-base text-gray-700 mb-4">AWB nu a fost creat încă. Crează AWB pentru a activa livrarea.</p>
                                    
                                    @if(!$order->canCreateAwb())
                                        <div class="bg-yellow-50 border border-yellow-200 rounded p-3 mb-4">
                                            <p class="text-xs sm:text-sm text-yellow-800">
                                                ⚠️ Pentru a crea AWB, comanda trebuie să fie plătită și să aibă status "pending" sau "processing".
                                            </p>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                                    @if($order->delivery_type === 'home')
                                        <form action="{{ route('admin.orders.createHomeAwb', $order) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button type="submit" 
                                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-semibold py-2 px-3 sm:px-4 rounded inline-flex items-center justify-center {{ !$order->canCreateAwb() ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                    {{ !$order->canCreateAwb() ? 'disabled' : '' }}>
                                                <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                                </svg>
                                                <span class="hidden sm:inline">🚚 Creează AWB - Livrare la Domiciliu</span>
                                                <span class="sm:hidden">🚚 AWB Domiciliu</span>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.orders.createLockerAwb', $order) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button type="submit" 
                                                    class="w-full bg-purple-600 hover:bg-purple-700 text-white text-xs sm:text-sm font-semibold py-2 px-3 sm:px-4 rounded inline-flex items-center justify-center {{ !$order->canCreateAwb() ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                    {{ !$order->canCreateAwb() ? 'disabled' : '' }}>
                                                <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                </svg>
                                                <span class="hidden sm:inline">📦 Creează AWB - Livrare la Easybox</span>
                                                <span class="sm:hidden">📦 AWB Easybox</span>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Status Update Forms -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 mb-6">
                        <div class="bg-gray-50 p-3 sm:p-4 rounded-lg">
                            <h3 class="text-base sm:text-lg font-semibold mb-3">Status Comandă</h3>
                            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" id="statusForm">
                                @csrf
                                @method('PATCH')
                                <div class="mb-3">
                                    <select id="statusSelect" name="status" class="w-full border-gray-300 rounded text-sm p-2">
                                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>⏳ În Așteptare</option>
                                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>📦 În Procesare</option>
                                        <option value="delivering" {{ $order->status === 'delivering' ? 'selected' : '' }}>🚚 În Curs de Livrare</option>
                                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>✅ Finalizată</option>
                                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>❌ Anulată</option>
                                    </select>
                                </div>
                                <button type="submit" class="w-full sm:w-auto bg-blue-500 hover:bg-blue-700 text-white text-sm font-semibold py-2 px-4 rounded">
                                    Actualizează Status
                                </button>
                            </form>
                        </div>

                        <div class="bg-gray-50 p-3 sm:p-4 rounded-lg">
                            <h3 class="text-base sm:text-lg font-semibold mb-3">Status Plată</h3>
                            <form action="{{ route('admin.orders.updatePayment', $order) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="mb-3">
                                   <select name="payment_status" class="w-full border-gray-300 rounded text-sm p-2">
                                        <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>⏳ În Așteptare</option>
                                        <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>✅ Plătită</option>
                                        <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>❌ Eșuată</option>
                                    </select>
                                </div>
                                <button type="submit" class="w-full sm:w-auto bg-green-500 hover:bg-green-700 text-white text-sm font-semibold py-2 px-4 rounded">
                                    Actualizează Plată
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="bg-gray-50 p-3 sm:p-4 rounded-lg">
                        <h3 class="text-base sm:text-lg font-semibold mb-3">Produse Comandate</h3>
                        <div class="space-y-3">
                            @foreach($order->items as $item)
                                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 bg-white p-3 rounded">
                                    <div class="flex-1">
                                        <p class="font-medium text-sm sm:text-base">{{ $item->product_title }}</p>
                                        <p class="text-xs sm:text-sm text-gray-600">Cantitate: {{ $item->quantity }} × RON {{ number_format($item->price, 2) }}</p>
                                    </div>
                                    <div class="text-left sm:text-right">
                                        <p class="font-medium text-sm sm:text-base">RON {{ number_format($item->subtotal, 2) }}</p>
                                    </div>
                                </div>
                            @endforeach
                            
                            <div class="border-t pt-3 mt-3">
                                @php
                                    $subtotal = $order->items->sum('subtotal');
                                @endphp
                                
                                <div class="flex justify-between items-center mb-2 text-sm sm:text-base">
                                    <span class="text-gray-700">Subtotal produse:</span>
                                    <span class="font-medium">RON {{ number_format($subtotal, 2) }}</span>
                                </div>
                                
                                @if($order->discount_amount > 0)
                                    <div class="flex justify-between items-center mb-2 text-green-600 text-sm sm:text-base">
                                        <span>Discount ({{ $order->coupon->code }}):</span>
                                        <span class="font-medium">-RON {{ number_format($order->discount_amount, 2) }}</span>
                                    </div>
                                @endif
                                
                                @if($order->shipping_cost > 0)
                                    <div class="flex justify-between items-center mb-2 text-blue-600 text-sm sm:text-base">
                                        <span>
                                            🚚 Cost livrare Sameday 
                                            @if($order->delivery_type === 'locker')
                                                (📦 Easybox)
                                            @else
                                                (🏠 Domiciliu)
                                            @endif
                                        </span>
                                        <span class="font-medium">RON {{ number_format($order->shipping_cost, 2) }}</span>
                                    </div>
                                @endif
                                
                                <div class="flex justify-between items-center font-bold text-base sm:text-lg pt-2 border-t">
                                    <span>Total de plată:</span>
                                    <span class="text-blue-600">RON {{ number_format($order->total_amount, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal pentru motivul anulării -->
    <div id="cancelModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="p-4 sm:p-6">
                <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-4">Anulare comandă</h3>
                <p class="text-sm sm:text-base text-gray-600 mb-4">Te rugăm să specifici motivul pentru care anulezi această comandă:</p>
                
                <form id="cancelForm" action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="cancelled">
                    
                    <div class="mb-4">
                        <textarea 
                            name="cancellation_reason" 
                            rows="4" 
                            class="w-full text-sm sm:text-base border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                            placeholder="Introdu motivul anulării..." 
                            required
                        ></textarea>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row justify-end gap-2 sm:gap-3">
                        <button type="button" onclick="closeCancelModal()" class="w-full sm:w-auto bg-gray-500 hover:bg-gray-700 text-white text-sm font-semibold py-2 px-4 rounded order-2 sm:order-1">
                            Renunță
                        </button>
                        <button type="submit" class="w-full sm:w-auto bg-red-500 hover:bg-red-700 text-white text-sm font-semibold py-2 px-4 rounded order-1 sm:order-2">
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