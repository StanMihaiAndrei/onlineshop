<div wire:ignore.self>
    <!-- Cart Button in Navigation -->
    <button @click="$wire.toggleCart()" class="relative p-2 text-gray-600 hover:text-gray-800 transition">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
        @if($cartCount > 0)
            <span class="absolute -top-1 -right-1 bg-blue-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                {{ $cartCount }}
            </span>
        @endif
    </button>

    <!-- Cart Modal Overlay -->
    <div x-show="$wire.isOpen" 
         x-transition.opacity
         @click="$wire.toggleCart()"
         class="fixed inset-0 bg-black bg-opacity-50 z-40"
         style="display: none;">
    </div>

    <!-- Cart Sidebar -->
    <div x-show="$wire.isOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         class="fixed right-0 top-0 h-full w-full max-w-md bg-white shadow-2xl z-50 flex flex-col"
         style="display: none;">
        
        <!-- Header -->
        <div class="flex items-center justify-between p-6 border-b">
            <h2 class="text-xl font-bold text-gray-800">Shopping Cart ({{ $cartCount }})</h2>
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
                            <a href="{{ route('shop.show', $item['slug']) }}" class="flex-shrink-0">
                                @if($item['image'])
                                    <img src="{{ asset('storage/' . $item['image']) }}" 
                                         alt="{{ $item['title'] }}"
                                         class="w-20 h-20 object-cover rounded">
                                @else
                                    <div class="w-20 h-20 bg-gray-200 rounded flex items-center justify-center">
                                        <span class="text-gray-400 text-xs">No image</span>
                                    </div>
                                @endif
                            </a>
                            
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('shop.show', $item['slug']) }}" 
                                   class="text-sm font-semibold text-gray-800 hover:text-blue-600 line-clamp-2">
                                    {{ $item['title'] }}
                                </a>
                                <p class="text-sm text-gray-600 mt-1">${{ number_format($item['price'], 2) }}</p>
                                
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
                                
                                <p class="text-sm font-semibold text-gray-800 mt-2">
                                    Subtotal: ${{ number_format($item['price'] * $item['quantity'], 2) }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Clear Cart -->
                <button wire:click="clearCart" 
                        wire:confirm="Are you sure you want to clear the cart?"
                        class="w-full mt-4 text-sm text-red-600 hover:text-red-800 underline">
                    Clear Cart
                </button>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <p class="text-gray-500 text-lg">Your cart is empty</p>
                    <a href="{{ route('shop') }}" 
                       @click="$wire.toggleCart()"
                       class="inline-block mt-4 text-blue-600 hover:text-blue-800">
                        Continue Shopping
                    </a>
                </div>
            @endif
        </div>

        <!-- Footer -->
        @if(count($cartItems) > 0)
            <div class="border-t p-6 bg-gray-50">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-lg font-semibold text-gray-800">Total:</span>
                    <span class="text-2xl font-bold text-blue-600">${{ number_format($cartTotal, 2) }}</span>
                </div>
                
                <a href="{{ route('checkout') }}" 
                   class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center font-semibold py-3 px-6 rounded-lg transition">
                    Proceed to Checkout
                </a>
                
                <button @click="$wire.toggleCart()" 
                        class="block w-full mt-2 text-gray-600 hover:text-gray-800 text-center py-2">
                    Continue Shopping
                </button>
            </div>
        @endif
    </div>
</div>