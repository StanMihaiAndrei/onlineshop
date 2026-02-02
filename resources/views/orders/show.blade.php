<x-app-layout>
    <div class="py-6 sm:py-12">
        <div class="max-w-4xl mx-auto px-3 sm:px-4 lg:px-8">
            <div class="mb-4 sm:mb-6">
                <a href="{{ route('orders.index') }}" class="text-blue-600 hover:text-blue-800 text-sm sm:text-base inline-flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Înapoi la Comenzile Mele
                </a>
            </div>

            <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 md:p-8">
                <!-- Header -->
                <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4 mb-6 pb-4 border-b-2">
                    <div>
                        <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Comanda {{ $order->order_number }}</h1>
                        <p class="text-sm sm:text-base text-gray-600">Plasată la {{ $order->created_at->format('d.m.Y H:i') }}</p>
                    </div>
                    
                    <span class="px-4 py-2 text-sm font-semibold rounded-full w-fit
                        {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                        {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                <!-- Coupon Info -->
                @if($order->coupon_id && $order->discount_amount > 0)
                    <div class="bg-green-50 border border-green-200 rounded-lg p-3 sm:p-4 mb-6">
                        <div class="flex items-start gap-2">
                            <span class="text-xl sm:text-2xl">🎉</span>
                            <div>
                                <p class="font-semibold text-green-800 text-sm sm:text-base">Cupon Aplicat: {{ $order->coupon->code }}</p>
                                <p class="text-xs sm:text-sm text-green-700">
                                    Ai economisit: RON {{ number_format($order->discount_amount, 2) }}
                                    @if($order->coupon->type === 'percentage')
                                        ({{ $order->coupon->value }}% discount)
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Invoice Section -->
                @if($order->smartbill_series && $order->smartbill_number)
                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 border-2 border-purple-200 rounded-lg p-4 sm:p-6 mb-6">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div>
                                <h2 class="text-base sm:text-lg font-bold text-purple-900 mb-2 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Factura Ta
                                </h2>
                                <p class="text-2xl sm:text-3xl font-bold font-mono text-purple-800">
                                    {{ $order->smartbill_series }}-{{ $order->smartbill_number }}
                                </p>
                                <p class="text-xs sm:text-sm text-purple-700 mt-1">
                                    @if($order->is_company)
                                        🏢 {{ $order->billing_company_name ?? $order->billing_name }}
                                    @else
                                        👤 {{ $order->billing_name ?? $order->shipping_name }}
                                    @endif
                                </p>
                            </div>
                            <a href="{{ route('orders.downloadInvoice', $order) }}" 
                               target="_blank"
                               class="inline-flex items-center justify-center gap-2 bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition duration-150">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span>Descarcă Factura</span>
                            </a>
                        </div>
                    </div>
                @endif

                <!-- Shipping & Billing Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 mb-6">
                    <!-- Shipping Information -->
                    @if($order->status !== 'cancelled')
                        <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-4 sm:p-6">
                            <h2 class="text-base sm:text-lg font-bold text-blue-900 mb-4 flex items-center gap-2">
                                <span class="text-xl sm:text-2xl">🚚</span>
                                Informații Livrare
                            </h2>
                            
                            <div class="space-y-3">
                                <div class="flex justify-between items-start text-sm">
                                    <span class="text-gray-600 font-medium">Tip Livrare:</span>
                                    <span class="font-semibold text-gray-900 text-right">
                                        @if($order->delivery_type === 'home')
                                            🏠 La Domiciliu
                                        @else
                                            📦 EasyBox
                                        @endif
                                    </span>
                                </div>

                                @if($order->delivery_type === 'home')
                                    <div class="bg-white rounded-lg p-3 border border-blue-100">
                                        <p class="text-xs text-gray-500 mb-1">Adresa de Livrare:</p>
                                        <p class="text-sm font-medium text-gray-900">{{ $order->shipping_address }}</p>
                                        <p class="text-sm text-gray-700">{{ $order->shipping_city }}@if($order->shipping_postal_code), {{ $order->shipping_postal_code }}@endif</p>
                                        <p class="text-sm text-gray-700">{{ $order->shipping_country }}</p>
                                    </div>
                                @else
                                    <div class="bg-white rounded-lg p-3 border border-blue-100">
                                        <p class="text-xs text-gray-500 mb-1">Locație EasyBox:</p>
                                        <p class="text-sm font-semibold text-gray-900">{{ $order->sameday_locker_name }}</p>
                                        <p class="text-sm text-gray-700">{{ $order->shipping_city }}</p>
                                    </div>
                                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-2">
                                        <p class="text-xs text-yellow-800">
                                            💡 Vei primi un SMS/email cu codul de deschidere EasyBox când pachetul tău va ajunge.
                                        </p>
                                    </div>
                                @endif

                                <div class="flex justify-between items-start text-sm">
                                    <span class="text-gray-600 font-medium">Cost Livrare:</span>
                                    <span class="font-semibold {{ $order->shipping_cost > 0 ? 'text-gray-900' : 'text-green-600' }}">
                                        @if($order->shipping_cost > 0)
                                            RON {{ number_format($order->shipping_cost, 2) }}
                                        @else
                                            GRATUIT
                                        @endif
                                    </span>
                                </div>

                                @if($order->sameday_awb_number)
                                    <div class="bg-green-50 border-2 border-green-300 rounded-lg p-3 sm:p-4 mt-4">
                                        <p class="text-xs sm:text-sm font-semibold text-green-900 mb-2">📦 Urmărire Pachet</p>
                                        <p class="text-xs text-green-700 mb-1">Număr AWB:</p>
                                        <p class="text-base sm:text-lg font-bold text-green-900 font-mono mb-3">{{ $order->sameday_awb_number }}</p>
                                        <a href="https://sameday.ro/tracking" target="_blank" 
                                           class="inline-flex items-center gap-2 text-xs sm:text-sm text-green-700 hover:text-green-900 font-medium underline">
                                            Urmărește pachetul tău
                                            <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                            </svg>
                                        </a>
                                    </div>
                                @else
                                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mt-4">
                                        <p class="text-xs text-yellow-800">
                                            <span class="font-semibold">⏳ Număr de urmărire în așteptare</span> - Vei primi numărul AWB prin email odată ce pachetul tău este preluat de curier.
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Billing Information -->
                    <div class="bg-purple-50 border-2 border-purple-200 rounded-lg p-4 sm:p-6">
                        <h2 class="text-base sm:text-lg font-bold text-purple-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Informații Facturare
                        </h2>
                        
                        <div class="space-y-2 text-sm">
                            <div>
                                <span class="text-gray-600">Tip:</span>
                                <span class="font-semibold ml-2">{{ $order->is_company ? '🏢 Persoană Juridică' : '👤 Persoană Fizică' }}</span>
                            </div>

                            @if($order->is_company && $order->billing_company_name)
                                <div class="bg-white rounded-lg p-3 border border-purple-100 mt-2">
                                    <p class="font-semibold text-gray-900">{{ $order->billing_company_name }}</p>
                                    <p class="text-xs text-gray-600">CIF: {{ $order->billing_cif ?? 'N/A' }}</p>
                                    @if($order->billing_reg_com)
                                        <p class="text-xs text-gray-600">Reg. Com.: {{ $order->billing_reg_com }}</p>
                                    @endif
                                </div>
                            @endif

                            <div>
                                <span class="text-gray-600">Nume:</span>
                                <span class="font-semibold ml-2">{{ $order->billing_name ?? $order->shipping_name }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Email:</span>
                                <span class="ml-2 break-all">{{ $order->billing_email ?? $order->shipping_email }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Telefon:</span>
                                <span class="ml-2">{{ $order->billing_phone ?? $order->shipping_phone }}</span>
                            </div>

                            @if($order->billing_address)
                                <div class="bg-white rounded-lg p-3 border border-purple-100 mt-2">
                                    <p class="text-xs text-gray-500 mb-1">Adresă Facturare:</p>
                                    <p class="text-sm text-gray-900">{{ $order->billing_address }}</p>
                                    <p class="text-sm text-gray-700">{{ $order->billing_city }}@if($order->billing_postal_code), {{ $order->billing_postal_code }}@endif</p>
                                    <p class="text-sm text-gray-700">{{ $order->billing_county }}, {{ $order->billing_country }}</p>
                                </div>
                            @else
                                <p class="text-xs text-gray-500 italic mt-2">Adresă identică cu livrarea</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Cancellation Reason -->
                @if($order->status === 'cancelled' && $order->cancellation_reason)
                    <div class="bg-red-50 border-2 border-red-200 rounded-lg p-4 mb-6">
                        <h3 class="font-bold text-red-900 mb-2 flex items-center gap-2 text-sm sm:text-base">
                            <span class="text-lg sm:text-xl">⚠️</span>
                            Motivul Anulării:
                        </h3>
                        <p class="text-xs sm:text-sm text-red-800">{{ $order->cancellation_reason }}</p>
                    </div>
                @endif

                <!-- Order Items -->
                <div class="border-t border-gray-200 pt-6 mb-6">
                    <h2 class="text-base sm:text-lg font-bold text-gray-900 mb-4">Produse Comandate</h2>
                    
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                            <div class="flex gap-3 sm:gap-4">
                                @if($item->product && $item->product->first_image)
                                    <img src="{{ asset('storage/' . $item->product->first_image) }}" 
                                         alt="{{ $item->product_title }}"
                                         class="w-16 h-16 sm:w-20 sm:h-20 object-cover rounded">
                                @else
                                    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gray-200 rounded flex items-center justify-center">
                                        <span class="text-gray-400 text-xs">No image</span>
                                    </div>
                                @endif
                                
                                <div class="flex-1">
                                    <h3 class="font-medium text-gray-900 text-sm sm:text-base">{{ $item->product_title }}</h3>
                                    <p class="text-xs sm:text-sm text-gray-600">Cantitate: {{ $item->quantity }}</p>
                                    <p class="text-xs sm:text-sm text-gray-600">Preț: RON {{ number_format($item->price, 2) }}</p>
                                </div>
                                
                                <div class="text-right">
                                    <p class="font-semibold text-gray-900 text-sm sm:text-base">RON {{ number_format($item->subtotal, 2) }}</p>
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
                    
                    <div class="flex justify-between mb-2 text-sm sm:text-base">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-medium">RON {{ number_format($subtotal, 2) }}</span>
                    </div>
                    
                    @if($order->discount_amount > 0)
                        <div class="flex justify-between mb-2 text-green-600 text-sm sm:text-base">
                            <span>Discount ({{ $order->coupon->code }})</span>
                            <span class="font-medium">-RON {{ number_format($order->discount_amount, 2) }}</span>
                        </div>
                    @endif
                    
                    <div class="flex justify-between mb-2 text-sm sm:text-base">
                        <span class="text-gray-600">Livrare</span>
                        <span class="font-medium {{ $order->shipping_cost > 0 ? '' : 'text-green-600' }}">
                            @if($order->shipping_cost > 0)
                                RON {{ number_format($order->shipping_cost, 2) }}
                            @else
                                GRATUIT
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between pt-2 border-t border-gray-200">
                        <span class="text-lg sm:text-xl font-bold">Total</span>
                        <span class="text-xl sm:text-2xl font-bold text-blue-600">RON {{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>

                <!-- Payment Info -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="font-bold text-gray-900 mb-3 text-sm sm:text-base">Metoda de Plată</h3>
                    <div class="bg-gray-50 rounded-lg p-3 sm:p-4">
                        <p class="text-gray-700 text-sm sm:text-base">
                            @if($order->payment_method === 'card')
                                💳 Plată cu Cardul
                            @else
                                💵 Plată la Livrare (Ramburs)
                            @endif
                        </p>
                        <p class="text-xs sm:text-sm text-gray-600 mt-2">
                            Status Plată: 
                            <span class="font-semibold {{ $order->payment_status === 'paid' ? 'text-green-600' : 'text-yellow-600' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </p>
                    </div>
                </div>

                @if($order->notes)
                    <div class="border-t border-gray-200 pt-6 mt-6">
                        <h3 class="font-bold text-gray-900 mb-2 text-sm sm:text-base">Notele Tale</h3>
                        <p class="text-gray-700 text-sm sm:text-base bg-gray-50 p-3 rounded">{{ $order->notes }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>