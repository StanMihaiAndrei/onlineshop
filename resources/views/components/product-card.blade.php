@props(['product', 'categorySlug' => null])

@php
    $primaryCategory = $product->categories->first();
    
    // Determinăm URL-ul produsului
    if ($categorySlug) {
        $productUrl = route('shop.product', [$categorySlug, $product->slug]);
    } elseif ($primaryCategory) {
        $productUrl = route('shop.product', [$primaryCategory->slug, $product->slug]);
    } else {
        $productUrl = route('shop.product', ['uncategorized', $product->slug]);
    }
    
    // Determinăm numele produsului (title sau name)
    $productName = $product->title ?? $product->name;
    
    // Determinăm prima imagine
    if (isset($product->first_image)) {
        $firstImage = $product->first_image;
    } elseif (is_array($product->images) && count($product->images) > 0) {
        $firstImage = $product->images[0];
    } else {
        $firstImage = null;
    }
@endphp

<div class="bg-white rounded-xl shadow-md overflow-hidden hover-lift group border border-gray-100 flex flex-col h-full">
    <!-- Imagine container cu poziție relativă pentru wishlist button -->
    <div class="relative">
        <a href="{{ $productUrl }}" class="block">
            <div class="bg-gradient-to-br from-pink-100 to-purple-100 relative overflow-hidden" style="height: 320px;">
                @if($firstImage)
                    <img src="{{ asset('storage/' . $firstImage) }}" 
                         alt="{{ $productName }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <svg class="w-16 h-16 text-primary opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                @endif
                
                @if($product->stock <= 0)
                    <div class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center">
                        <span class="bg-red-600 text-white px-3 py-1.5 rounded-full font-bold text-xs shadow-lg">Stoc epuizat</span>
                    </div>
                @endif
            </div>
        </a>
        
        <!-- Wishlist Button - OUTSIDE the <a> tag but positioned absolutely -->
        <div class="absolute top-3 right-3 z-10" onclick="event.stopPropagation();">
            <x-wishlist-icon :productId="$product->id" 
                             class="p-2 bg-white hover:bg-white rounded-full shadow-lg transition-all hover:scale-110" />
        </div>
    </div>
    
    <div class="p-4 flex flex-col flex-grow">
        <a href="{{ $productUrl }}">
            <h3 class="text-sm font-bold text-gray-900 hover:text-primary transition mb-1.5 h-10 line-clamp-2">
                {{ $productName }}
            </h3>
        </a>
        
        <div class="h-6 mb-2">
            @if($product->categories->count() > 0)
                <div class="flex flex-wrap gap-1">
                    @foreach($product->categories->take(2) as $cat)
                        <span class="text-xs bg-pink-50 text-primary px-2 py-0.5 rounded-full font-medium">
                            {{ $cat->name }}
                        </span>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="h-6 mb-2">
            @if($product->colors->count() > 0)
                <div class="flex gap-1">
                    @foreach($product->colors->take(5) as $color)
                        <div class="w-4 h-4 rounded-full border border-gray-300 shadow-sm" 
                             style="background-color: {{ $color->hex_code }}"
                             title="{{ $color->name }}">
                        </div>
                    @endforeach
                    @if($product->colors->count() > 5)
                        <span class="text-xs text-gray-500 self-center">+{{ $product->colors->count() - 5 }}</span>
                    @endif
                </div>
            @endif
        </div>
        
        <div class="flex justify-between items-center mb-3 h-6">
            <div class="flex items-center gap-2">
                @if(method_exists($product, 'hasDiscount') && $product->hasDiscount())
                    <span class="text-xs line-through text-gray-400">
                        RON {{ number_format($product->price, 2) }}
                    </span>
                    <span class="text-xs font-bold text-red-600">
                        RON {{ number_format($product->final_price, 2) }}
                    </span>
                    <span class="text-xs bg-red-100 text-red-800 px-2 py-0.5 rounded-full font-bold">
                        -{{ $product->discount_percentage }}%
                    </span>
                @else
                    <span class="text-sm font-bold text-primary">
                        RON {{ number_format($product->price, 2) }}
                    </span>
                @endif
            </div>
            @if($product->stock > 0 && $product->stock <= 5)
                <span class="text-xs text-orange-600 font-semibold">Stoc limitat!</span>
            @endif
        </div>
        
        <div class="mt-auto pt-3 border-t border-gray-100">
            @if($product->stock > 0)
                <button onclick="addToCart({{ $product->id }}, 1)"
                        class="w-full bg-primary hover:bg-primary-dark text-white px-4 py-2.5 rounded-lg transition transform hover:scale-105 font-semibold text-sm shadow-md flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Adaugă în coș
                </button>
            @else
                <button disabled
                        class="w-full bg-gray-300 text-gray-500 px-4 py-2.5 rounded-lg cursor-not-allowed font-semibold text-sm">
                    Stoc epuizat
                </button>
            @endif
        </div>
    </div>
</div>