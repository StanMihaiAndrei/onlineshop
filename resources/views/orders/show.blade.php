<x-app-layout>
    <div class="min-h-screen py-8 sm:py-12" style="background-color: var(--color-background);">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('orders.index') }}" 
                   class="inline-flex items-center gap-2 text-sm font-medium hover:underline"
                   style="color: var(--color-primary);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span>Înapoi la Comenzile Mele</span>
                </a>
            </div>

            <!-- Main Card -->
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <!-- Header -->
                <div class="px-6 sm:px-8 py-6 border-b" style="background: linear-gradient(135deg, rgba(246, 241, 235, 0.5) 0%, rgba(255, 255, 255, 1) 100%);">
                    <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                        <div>
                            <div class="flex items-center gap-3 mb-2">
                                <svg class="w-6 h-6" style="color: var(--color-primary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <h1 class="text-2xl sm:text-3xl font-bold" style="color: var(--color-text);">{{ $order->order_number }}</h1>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>{{ $order->created_at->format('d.m.Y H:i') }}</span>
                            </div>
                        </div>
                        
                        <span class="px-5 py-2.5 text-sm font-semibold rounded-xl w-fit
                            {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $order->status === 'delivering' ? 'text-white' : '' }}
                            {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}"
                            @if($order->status === 'delivering') style="background-color: var(--color-primary);" @endif>
                            {{ $order->status_label }}
                        </span>
                    </div>
                </div>

                <div class="px-6 sm:px-8 py-8">
                    <!-- Coupon -->
                    @if($order->coupon_id && $order->discount_amount > 0)
                        <div class="mb-6 p-4 rounded-xl border-2" style="background-color: rgba(143, 174, 158, 0.05); border-color: var(--color-secondary);">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6" style="color: var(--color-secondary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold mb-1" style="color: var(--color-text);">Cupon Aplicat: <span class="font-mono">{{ $order->coupon->code }}</span></p>
                                    <p class="text-sm" style="color: var(--color-secondary);">
                                        Ai economisit: RON {{ number_format($order->discount_amount, 2) }}
                                        @if($order->coupon->type === 'percentage')
                                            ({{ $order->coupon->value }}% reducere)
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Invoice -->
                    @if($order->smartbill_series && $order->smartbill_number)
                        <div class="mb-6 p-6 rounded-xl" style="background: linear-gradient(135deg, rgba(219, 28, 181, 0.05) 0%, rgba(240, 213, 234, 0.3) 100%); border: 2px solid var(--color-primary-light);">
                            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                                <div class="flex items-start gap-3">
                                    <svg class="w-8 h-8" style="color: var(--color-primary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium text-gray-600 mb-1">Factura Ta</p>
                                        <p class="text-2xl font-bold font-mono" style="color: var(--color-primary);">{{ $order->smartbill_series }}-{{ $order->smartbill_number }}</p>
                                        <p class="text-sm text-gray-600 mt-1">
                                            @if($order->is_company)
                                                {{ $order->billing_company_name ?? $order->billing_name }}
                                            @else
                                                {{ $order->billing_name ?? $order->shipping_name }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <a href="{{ route('orders.downloadInvoice', $order) }}" 
                                   target="_blank"
                                   class="inline-flex items-center gap-2 px-6 py-3 rounded-xl font-semibold text-white transition-all hover:shadow-lg"
                                   style="background-color: var(--color-primary);">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span>Descarcă</span>
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Shipping & Billing Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Shipping -->
                        @if($order->status !== 'cancelled')
                            <div class="p-6 rounded-xl border-2" style="background-color: rgba(143, 174, 158, 0.03); border-color: rgba(143, 174, 158, 0.2);">
                                <div class="flex items-center gap-2 mb-4">
                                    <svg class="w-5 h-5" style="color: var(--color-secondary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                                    </svg>
                                    <h3 class="font-bold" style="color: var(--color-text);">Informații Livrare</h3>
                                </div>
                                
                                <div class="space-y-3 text-sm">
                                    <div>
                                        <p class="text-gray-600 mb-1">Tip Livrare</p>
                                        <p class="font-semibold" style="color: var(--color-text);">{{ $order->delivery_type_label }}</p>
                                    </div>

                                    @if($order->delivery_type === 'home')
                                        <div>
                                            <p class="text-gray-600 mb-1">Adresă</p>
                                            <p class="font-medium" style="color: var(--color-text);">{{ $order->shipping_address }}</p>
                                            <p class="text-gray-600">{{ $order->shipping_city }}, {{ $order->shipping_postal_code }}</p>
                                        </div>
                                    @else
                                        <div>
                                            <p class="text-gray-600 mb-1">EasyBox</p>
                                            <p class="font-medium" style="color: var(--color-text);">{{ $order->sameday_locker_name }}</p>
                                            <p class="text-gray-600">{{ $order->shipping_city }}</p>
                                        </div>
                                    @endif

                                    <div>
                                        <p class="text-gray-600 mb-1">Cost Livrare</p>
                                        <p class="font-bold text-lg" style="color: {{ $order->shipping_cost > 0 ? 'var(--color-text)' : 'var(--color-secondary)' }};">
                                            @if($order->shipping_cost > 0)
                                                RON {{ number_format($order->shipping_cost, 2) }}
                                            @else
                                                GRATUIT
                                            @endif
                                        </p>
                                    </div>

                                    @if($order->sameday_awb_number)
                                        <div class="pt-3 border-t">
                                            <p class="text-gray-600 mb-2">Număr AWB</p>
                                            <p class="font-mono font-bold text-lg mb-3" style="color: var(--color-secondary);">{{ $order->sameday_awb_number }}</p>
                                            <a href="https://sameday.ro/awb-tracking/?awb={{ $order->sameday_awb_number }}" target="_blank" 
                                               class="inline-flex items-center gap-2 text-sm font-medium hover:underline"
                                               style="color: var(--color-secondary);">
                                                <span>Urmărește coletul</span>
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                </svg>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Billing -->
                        <div class="p-6 rounded-xl border-2" style="background-color: rgba(219, 28, 181, 0.02); border-color: var(--color-primary-light);">
                            <div class="flex items-center gap-2 mb-4">
                                <svg class="w-5 h-5" style="color: var(--color-primary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <h3 class="font-bold" style="color: var(--color-text);">Informații Facturare</h3>
                            </div>
                            
                            <div class="space-y-3 text-sm">
                                <div>
                                    <p class="text-gray-600 mb-1">Tip</p>
                                    <p class="font-semibold" style="color: var(--color-text);">
                                        {{ $order->is_company ? 'Persoană Juridică' : 'Persoană Fizică' }}
                                    </p>
                                </div>

                                @if($order->is_company && $order->billing_company_name)
                                    <div>
                                        <p class="text-gray-600 mb-1">Companie</p>
                                        <p class="font-semibold" style="color: var(--color-text);">{{ $order->billing_company_name }}</p>
                                        <p class="text-gray-600">CIF: {{ $order->billing_cif ?? 'N/A' }}</p>
                                    </div>
                                @endif

                                <div>
                                    <p class="text-gray-600 mb-1">Nume</p>
                                    <p class="font-medium" style="color: var(--color-text);">{{ $order->billing_name ?? $order->shipping_name }}</p>
                                </div>

                                <div>
                                    <p class="text-gray-600 mb-1">Contact</p>
                                    <p class="text-gray-700">{{ $order->billing_email ?? $order->shipping_email }}</p>
                                    <p class="text-gray-700">{{ $order->billing_phone ?? $order->shipping_phone }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cancellation -->
                    @if($order->status === 'cancelled' && $order->cancellation_reason)
                        <div class="mb-8 p-5 rounded-xl bg-red-50 border-2 border-red-200">
                            <div class="flex items-start gap-3">
                                <svg class="w-6 h-6 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <div>
                                    <p class="font-bold text-red-900 mb-1">Motivul Anulării</p>
                                    <p class="text-sm text-red-800">{{ $order->cancellation_reason }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Products -->
                    <div class="mb-8">
                        <h3 class="text-xl font-bold mb-5" style="color: var(--color-text);">Produse Comandate</h3>
                        <div class="space-y-4">
                            @foreach($order->items as $item)
                                <div class="flex gap-4 p-4 rounded-xl border border-gray-100 hover:shadow-sm transition">
                                    @if($item->product && $item->product->first_image)
                                        <img src="{{ asset('storage/' . $item->product->first_image) }}" 
                                             alt="{{ $item->product_title }}"
                                             class="w-20 h-20 object-cover rounded-lg">
                                    @else
                                        <div class="w-20 h-20 rounded-lg flex items-center justify-center" style="background-color: var(--color-background);">
                                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                    
                                    <div class="flex-1">
                                        <h4 class="font-semibold mb-1" style="color: var(--color-text);">{{ $item->product_title }}</h4>
                                        <p class="text-sm text-gray-600">Cantitate: {{ $item->quantity }} × RON {{ number_format($item->price, 2) }}</p>
                                    </div>
                                    
                                    <div class="text-right">
                                        <p class="text-lg font-bold" style="color: var(--color-primary);">RON {{ number_format($item->subtotal, 2) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Summary -->
                    <div class="p-6 rounded-xl" style="background-color: rgba(143, 174, 158, 0.05);">
                        @php
                            $subtotal = $order->items->sum('subtotal');
                        @endphp
                        
                        <div class="space-y-3">
                            <div class="flex justify-between text-gray-700">
                                <span>Subtotal</span>
                                <span class="font-semibold">RON {{ number_format($subtotal, 2) }}</span>
                            </div>
                            
                            @if($order->discount_amount > 0)
                                <div class="flex justify-between" style="color: var(--color-secondary);">
                                    <span>Reducere ({{ $order->coupon->code }})</span>
                                    <span class="font-semibold">-RON {{ number_format($order->discount_amount, 2) }}</span>
                                </div>
                            @endif
                            
                            <div class="flex justify-between text-gray-700">
                                <span>Livrare</span>
                                <span class="font-semibold" style="color: {{ $order->shipping_cost > 0 ? 'inherit' : 'var(--color-secondary)' }};">
                                    @if($order->shipping_cost > 0)
                                        RON {{ number_format($order->shipping_cost, 2) }}
                                    @else
                                        GRATUIT
                                    @endif
                                </span>
                            </div>
                            
                            <div class="pt-3 border-t-2 flex justify-between items-center" style="border-color: var(--color-secondary);">
                                <span class="text-xl font-bold" style="color: var(--color-text);">Total</span>
                                <span class="text-3xl font-bold" style="color: var(--color-primary);">RON {{ number_format($order->total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Info -->
                    <div class="mt-6 p-6 rounded-xl bg-gray-50">
                        <div class="flex items-center gap-3 mb-4">
                            <svg class="w-5 h-5" style="color: var(--color-primary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                            <h3 class="font-bold" style="color: var(--color-text);">Metodă de Plată</h3>
                        </div>
                        <p class="text-gray-700 mb-2">{{ $order->payment_method_label }}</p>
                        <p class="text-sm">
                            Status: 
                            <span class="font-semibold {{ $order->payment_status === 'paid' ? 'text-green-600' : ($order->payment_status === 'failed' ? 'text-red-600' : 'text-yellow-600') }}">
                                {{ $order->payment_status_label }}
                            </span>
                        </p>
                    </div>

                    @if($order->notes)
                        <div class="mt-6 p-6 rounded-xl border-2" style="border-color: var(--color-primary-light); background-color: rgba(240, 213, 234, 0.1);">
                            <h3 class="font-bold mb-2" style="color: var(--color-text);">Notele Tale</h3>
                            <p class="text-gray-700">{{ $order->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>