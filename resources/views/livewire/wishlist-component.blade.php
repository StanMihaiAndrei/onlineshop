<div x-data="{ open: @entangle('isOpen') }" class="relative">
    <!-- Wishlist Button -->
    <button @click="open = !open" 
            type="button"
            class="relative p-2 text-gray-700 hover:text-pink-600 transition-colors duration-200 group">
        <svg class="w-6 h-6 transition-transform group-hover:scale-110" 
             fill="none" 
             stroke="currentColor" 
             viewBox="0 0 24 24">
            <path stroke-linecap="round" 
                  stroke-linejoin="round" 
                  stroke-width="2" 
                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
        </svg>
        @if($wishlistCount > 0)
            <span class="absolute -top-1 -right-1 bg-primary text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center animate-pulse">
                {{ $wishlistCount }}
            </span>
        @endif
    </button>

    <!-- Wishlist Dropdown Panel -->
   <div x-show="open" 
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0 translate-y-1"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100 translate-y-0"
     x-transition:leave-end="opacity-0 translate-y-1"
     @click.away="open = false"
     class="fixed sm:absolute left-1/2 sm:left-auto right-auto sm:right-0 -translate-x-1/2 sm:translate-x-0 mt-2 w-[calc(100vw-2rem)] sm:w-96 max-w-md bg-white rounded-xl shadow-2xl border border-gray-200 z-50 max-h-[32rem] overflow-hidden flex flex-col">
        
        <!-- Header -->
        <div class="px-4 py-3 border-b border-gray-200 bg-gradient-to-r from-pink-50 to-purple-50">
            <div class="flex items-center justify-between">
                <h3 class="text-base font-bold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-pink-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                    </svg>
                    My Wishlist
                    @if($wishlistCount > 0)
                        <span class="ml-2 text-sm text-pink-600">({{ $wishlistCount }})</span>
                    @endif
                </h3>
                <button @click="open = false" class="text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        @if($wishlistCount > 0)
            <!-- Wishlist Items -->
            <div class="flex-1 overflow-y-auto p-4 space-y-3">
                @foreach($wishlistItems as $item)
                    <div class="flex gap-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition border border-gray-200">
                        <div class="flex-shrink-0">
                            @if($item['image'])
                                <img src="{{ asset('storage/' . $item['image']) }}" 
                                     alt="{{ $item['title'] }}"
                                     class="w-20 h-20 object-cover rounded-lg shadow-sm">
                            @else
                                <div class="w-20 h-20 bg-gradient-to-br from-pink-100 to-purple-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-8 h-8 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('shop.product', [$item['category_slug'], $item['slug']]) }}" 
                               class="font-semibold text-gray-900 hover:text-pink-600 text-sm line-clamp-2 transition">
                                {{ $item['title'] }}
                            </a>
                            
                            <div class="mt-1">
                                @if($item['has_discount'])
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs line-through text-gray-400">
                                            ${{ number_format($item['price'], 2) }}
                                        </span>
                                        <span class="text-sm font-bold text-pink-600">
                                            ${{ number_format($item['final_price'], 2) }}
                                        </span>
                                        <span class="text-xs bg-red-100 text-red-700 px-2 py-0.5 rounded-full font-bold">
                                            -{{ $item['discount_percentage'] }}%
                                        </span>
                                    </div>
                                @else
                                    <span class="text-sm font-bold text-gray-900">
                                        ${{ number_format($item['price'], 2) }}
                                    </span>
                                @endif
                            </div>

                            @if($item['is_active'] && $item['stock'] > 0)
                                <div class="flex gap-2 mt-2">
                                    <button wire:click="moveToCart({{ $item['id'] }})"
                                            class="flex-1 px-3 py-1.5 bg-pink-600 text-white text-xs font-semibold rounded-lg hover:bg-pink-700 transition flex items-center justify-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        Add to Cart
                                    </button>
                                    <button wire:click="removeFromWishlist({{ $item['id'] }})"
                                            class="px-3 py-1.5 bg-gray-200 text-gray-700 text-xs font-semibold rounded-lg hover:bg-red-100 hover:text-red-600 transition">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            @else
                                <div class="flex gap-2 mt-2">
                                    <span class="text-xs text-red-600 font-semibold">Out of Stock</span>
                                    <button wire:click="removeFromWishlist({{ $item['id'] }})"
                                            class="ml-auto px-3 py-1.5 bg-gray-200 text-gray-700 text-xs font-semibold rounded-lg hover:bg-red-100 hover:text-red-600 transition">
                                        Remove
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Footer Actions -->
            <div class="px-4 py-3 border-t border-gray-200 bg-gray-50 space-y-2">
                <button wire:click="clearWishlist"
                        wire:confirm="Are you sure you want to clear your wishlist?"
                        class="w-full px-4 py-2 bg-gray-200 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-300 transition">
                    Clear Wishlist
                </button>
            </div>
        @else
            <!-- Empty State -->
            <div class="p-8 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
                <p class="text-gray-500 font-medium mb-4">Your wishlist is empty</p>
                <a href="{{ route('shop') }}" 
                   @click="open = false"
                   class="inline-block px-6 py-2 bg-pink-600 text-white text-sm font-semibold rounded-lg hover:bg-pink-700 transition">
                    Start Shopping
                </a>
            </div>
        @endif
    </div>
</div>