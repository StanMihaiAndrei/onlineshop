<x-app-layout>
    <div class="min-h-screen py-8 sm:py-12" style="background-color: var(--color-background);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-8">
                <h1 class="text-3xl sm:text-4xl font-bold mb-2" style="color: var(--color-text);">Comenzile Mele</h1>
                <p class="text-gray-600">Vizualizează și urmărește toate comenzile tale</p>
            </div>

            @if($orders->count() > 0)
                <div class="space-y-6">
                    @foreach($orders as $order)
                        <div class="bg-white rounded-2xl shadow-sm hover-lift overflow-hidden border border-gray-100">
                            <!-- Order Header -->
                            <div class="p-6 border-b" style="background: linear-gradient(135deg, rgba(246, 241, 235, 0.5) 0%, rgba(255, 255, 255, 1) 100%);">
                                <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-2">
                                            <svg class="w-5 h-5" style="color: var(--color-primary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <h3 class="text-lg font-bold" style="color: var(--color-text);">{{ $order->order_number }}</h3>
                                        </div>
                                        <div class="flex items-center gap-2 text-sm text-gray-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span>{{ $order->created_at->format('d.m.Y H:i') }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="flex flex-wrap items-center gap-3">
                                        <span class="px-4 py-2 text-sm font-semibold rounded-full
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
                            </div>

                            <!-- Shipping Info -->
                            @if($order->status !== 'cancelled')
                                <div class="px-6 py-4" style="background-color: rgba(143, 174, 158, 0.05);">
                                    <div class="flex items-start gap-3">
                                        <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center" style="background-color: var(--color-secondary); opacity: 0.2;">
                                            <svg class="w-5 h-5" style="color: var(--color-secondary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold mb-1" style="color: var(--color-text);">
                                                {{ $order->delivery_type_label }}
                                                @if($order->shipping_cost > 0)
                                                    <span class="text-gray-600">- RON {{ number_format($order->shipping_cost, 2) }}</span>
                                                @else
                                                    <span style="color: var(--color-secondary);">- GRATUIT</span>
                                                @endif
                                            </p>
                                            @if($order->sameday_awb_number)
                                                <div class="flex items-center gap-2 text-xs" style="color: var(--color-secondary);">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                                    </svg>
                                                    <span>AWB: <span class="font-mono font-semibold">{{ $order->sameday_awb_number }}</span></span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Order Items -->
                            <div class="px-6 py-5">
                                <div class="space-y-4 mb-5">
                                    @foreach($order->items->take(2) as $item)
                                        <div class="flex gap-4">
                                            @if($item->product && $item->product->first_image)
                                                <img src="{{ asset('storage/' . $item->product->first_image) }}" 
                                                     alt="{{ $item->product_title }}"
                                                     class="w-16 h-16 object-cover rounded-lg border border-gray-200">
                                            @else
                                                <div class="w-16 h-16 rounded-lg border border-gray-200 flex items-center justify-center" style="background-color: var(--color-background);">
                                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            @endif
                                            
                                            <div class="flex-1 min-w-0">
                                                <h4 class="text-sm font-medium mb-1 truncate" style="color: var(--color-text);">{{ $item->product_title }}</h4>
                                                <p class="text-sm text-gray-600">{{ $item->quantity }} × RON {{ number_format($item->price, 2) }}</p>
                                            </div>
                                            
                                            <div class="text-right">
                                                <p class="text-sm font-semibold" style="color: var(--color-text);">RON {{ number_format($item->subtotal, 2) }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                    
                                    @if($order->items->count() > 2)
                                        <p class="text-sm text-gray-500 text-center">+ încă {{ $order->items->count() - 2 }} produs(e)</p>
                                    @endif
                                </div>

                                <!-- Footer -->
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 pt-5 border-t border-gray-100">
                                    <div>
                                        <p class="text-sm text-gray-600 mb-1">Total Comandă</p>
                                        <p class="text-2xl font-bold" style="color: var(--color-primary);">RON {{ number_format($order->total_amount, 2) }}</p>
                                    </div>
                                    <a href="{{ route('orders.show', $order) }}" 
                                       class="inline-flex items-center gap-2 px-6 py-3 rounded-xl font-semibold text-white transition-all hover:shadow-lg"
                                       style="background-color: var(--color-primary);">
                                        <span>Vezi Detalii</span>
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $orders->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-2xl shadow-sm p-12 text-center">
                    <div class="w-20 h-20 mx-auto mb-6 rounded-full flex items-center justify-center" style="background-color: rgba(219, 28, 181, 0.1);">
                        <svg class="w-10 h-10" style="color: var(--color-primary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-2" style="color: var(--color-text);">Nu aveți comenzi încă</h3>
                    <p class="text-gray-600 mb-8">Începeți să cumpărați pentru a crea prima comandă!</p>
                    <a href="{{ route('shop') }}" 
                       class="inline-flex items-center gap-2 px-8 py-4 rounded-xl font-semibold text-white transition-all hover:shadow-lg"
                       style="background-color: var(--color-primary);">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span>Răsfoiește Produse</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>