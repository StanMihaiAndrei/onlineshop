<div wire:ignore.self>
    <!-- Cart Button in Navigation -->
    <button @click="$wire.toggleCart()" class="relative p-2 text-gray-600 hover:text-gray-800 transition">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
        @if($cartCount > 0)
            <span class="absolute -top-1 -right-1 bg-primary text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                {{ $cartCount }}
            </span>
        @endif
    </button>

    <!-- Cart Modal Overlay -->
    <div x-show="$wire.isOpen" 
         x-transition.opacity
         @click="$wire.toggleCart()"
         class="fixed inset-0 bg-black bg-opacity-50 z-[60]"
         x-cloak>
    </div>

    <!-- Cart Sidebar -->
    <div x-show="$wire.isOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         x-init="$watch('$wire.isOpen', value => {
             if (value) {
                 document.body.style.overflow = 'hidden';
                 document.body.style.paddingRight = (window.innerWidth - document.documentElement.clientWidth) + 'px';
             } else {
                 document.body.style.overflow = '';
                 document.body.style.paddingRight = '';
             }
         })"
         class="fixed right-0 top-0 h-screen w-full max-w-md bg-white shadow-2xl z-[70] flex flex-col"
         x-cloak>
        
        <!-- Header -->
        <div class="flex items-center justify-between p-6 border-b flex-shrink-0">
            <h2 class="text-xl font-bold text-gray-800">Coș de cumpărături ({{ $cartCount }})</h2>
            <button @click="$wire.toggleCart()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Cart Items -->
        <div class="flex-1 overflow-y-auto p-6">
            @if(count($cartItems) > 0)
                <div class="space-y-4">
                    @foreach($cartItems as $item)
                        <div class="flex gap-4 bg-gray-50 p-4 rounded-lg" wire:key="cart-item-{{ $item['id'] }}">
                            <a href="{{ route('shop.product', [$item['category_slug'] ?? 'uncategorized', $item['slug']]) }}" class="flex-shrink-0">
                                @if($item['image'])
                                    <img src="{{ asset('storage/' . $item['image']) }}" 
                                         alt="{{ $item['title'] }}"
                                         class="w-20 h-20 object-cover rounded">
                                @else
                                    <div class="w-20 h-20 bg-gray-200 rounded flex items-center justify-center">
                                        <span class="text-gray-400 text-xs">Fără imagine</span>
                                    </div>
                                @endif
                            </a>
                            
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('shop.product', [$item['category_slug'] ?? 'uncategorized', $item['slug']]) }}" 
                                   class="text-sm font-semibold text-gray-800 hover:text-blue-600 line-clamp-2">
                                    {{ $item['title'] }}
                                </a>
                                
                                <!-- Price Display with Discount -->
                                <div class="mt-1">
                                    @if($item['has_discount'] ?? false)
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs line-through text-gray-400">${{ number_format($item['price'], 2) }}</span>
                                            <span class="text-sm font-bold text-red-600">${{ number_format($item['final_price'], 2) }}</span>
                                            <span class="text-xs bg-red-100 text-red-800 px-1.5 py-0.5 rounded font-bold">
                                                -{{ $item['discount_percentage'] }}%
                                            </span>
                                        </div>
                                    @else
                                        <p class="text-sm text-gray-600">${{ number_format($item['final_price'], 2) }}</p>
                                    @endif
                                </div>
                                
                                <!-- Quantity Controls -->
                                <div class="flex items-center gap-2 mt-2">
                                    <button wire:click="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] - 1 }})"
                                            class="w-7 h-7 rounded border border-gray-300 hover:bg-gray-100 flex items-center justify-center">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                        </svg>
                                    </button>
                                    
                                    <span class="w-8 text-center text-sm font-medium">{{ $item['quantity'] }}</span>
                                    
                                    <button wire:click="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] + 1 }})"
                                            {{ $item['quantity'] >= $item['stock'] ? 'disabled' : '' }}
                                            class="w-7 h-7 rounded border border-gray-300 hover:bg-gray-100 flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                    </button>
                                    
                                    <button wire:click="removeFromCart({{ $item['id'] }})"
                                            class="ml-auto text-red-600 hover:text-red-800">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                                
                                <!-- Subtotal -->
                                <div class="mt-2">
                                    @if($item['has_discount'] ?? false)
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs text-gray-500">Subtotal:</span>
                                            <span class="text-xs line-through text-gray-400">
                                                ${{ number_format($item['price'] * $item['quantity'], 2) }}
                                            </span>
                                            <span class="text-sm font-bold text-gray-800">
                                                ${{ number_format($item['final_price'] * $item['quantity'], 2) }}
                                            </span>
                                        </div>
                                    @else
                                        <p class="text-sm font-semibold text-gray-800">
                                            Subtotal: ${{ number_format($item['final_price'] * $item['quantity'], 2) }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Clear Cart Button -->
                <div x-data="{ showClearModal: false }">
                    <button @click="showClearModal = true" 
                            class="w-full mt-4 text-sm text-red-600 hover:text-red-800 underline">
                        Golește coșul
                    </button>

                    <!-- Clear Cart Modal -->
                    <div x-show="showClearModal"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="fixed inset-0 bg-black bg-opacity-50 z-[80] flex items-center justify-center p-4 sm:p-6"
                        style="display: none;"
                        @click.self="showClearModal = false"
                        @keydown.escape.window="showClearModal = false">
                        
                        <div x-show="showClearModal"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                            x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                            class="bg-white rounded-xl shadow-2xl max-w-sm w-full overflow-hidden relative"
                            @click.stop>
                            
                            <!-- Modal Header -->
                            <div class="bg-red-50 px-4 sm:px-6 py-4 border-b border-red-100">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-900">Golește coșul?</h3>
                                </div>
                            </div>
                            
                            <!-- Modal Body -->
                            <div class="px-4 sm:px-6 py-4">
                                <p class="text-sm text-gray-600">
                                    Ești sigur că vrei să ștergi toate produsele din coș? Această acțiune nu poate fi anulată.
                                </p>
                                <div class="mt-3 bg-gray-50 rounded-lg p-3">
                                    <p class="text-xs text-gray-500">
                                        <span class="font-semibold">{{ $cartCount }}</span> produs{{ $cartCount !== 1 ? 'e' : '' }} în coș
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Modal Footer -->
                            <div class="bg-gray-50 px-4 sm:px-6 py-4 flex flex-col sm:flex-row gap-3">
                                <button @click="showClearModal = false" 
                                        class="flex-1 px-4 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition">
                                    Anulează
                                </button>
                                <button @click="showClearModal = false; $wire.clearCart()" 
                                        class="flex-1 px-4 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium transition">
                                    Golește coșul
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <p class="text-gray-500 text-lg">Coșul tău este gol</p>
                    <a href="{{ route('shop') }}" 
                       @click="$wire.toggleCart()"
                       class="inline-block mt-4 text-primary hover:text-primary-dark">
                        Continuă cumpărăturile
                    </a>
                </div>
            @endif
        </div>

        <!-- Footer -->
        @if(count($cartItems) > 0)
            <div class="border-t p-6 bg-gray-50 flex-shrink-0">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-lg font-semibold text-gray-800">Total:</span>
                    <span class="text-2xl font-bold text-primary">${{ number_format($cartTotal, 2) }}</span>
                </div>
                
                <a href="{{ route('checkout') }}" 
                   class="block w-full bg-primary hover:bg-primary-dark text-white text-center font-semibold py-3 px-6 rounded-lg transition">
                    Finalizează comanda
                </a>
                
                <button @click="$wire.toggleCart()" 
                        class="block w-full mt-2 text-gray-600 hover:text-gray-800 text-center py-2">
                    Continuă cumpărăturile
                </button>
            </div>
        @endif
    </div>
</div>