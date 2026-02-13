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

<div class="bg-white rounded-2xl overflow-hidden border border-gray-200 transition-all duration-300 hover:border-[#db1cb5] hover:-translate-y-1 hover:shadow-[0_15px_40px_rgba(219,28,181,0.15)] flex flex-col h-full">
    <!-- Imagine container -->
    <div class="relative">
        <a href="{{ $productUrl }}" class="block">
            <div class="relative overflow-hidden aspect-[3/4]">
               @if($firstImage)
                <img src="{{ asset('storage/' . $firstImage) }}" 
                    alt="{{ $productName }}"
                    width="350"
                    height="350"
                    loading="lazy"
                    decoding="async"
                    class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-pink-100 to-purple-100">
                        <svg class="w-16 h-16 text-[#db1cb5] opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
        
        <!-- Discount Badge - Top Left -->
        @if(method_exists($product, 'hasDiscount') && $product->hasDiscount() && $product->stock > 0)
            <div class="absolute top-3 left-3 bg-[#db1cb5] text-white px-3 py-1.5 rounded-full text-xs font-medium shadow-lg z-10">
                -{{ $product->discount_percentage }}%
            </div>
        @endif
        
        <!-- Wishlist Button - Top Right -->
        <div class="absolute top-3 right-3 z-10">
            <x-wishlist-icon :productId="$product->id" 
                             class="!p-2 !bg-white hover:!bg-[#db1cb5] !rounded-full !shadow-lg !transition-all hover:!scale-110 [&_svg]:hover:!text-white [&_svg]:!transition-colors" />
        </div>
    </div>
    
    <div class="p-3 sm:p-4 flex flex-col flex-grow">
        <!-- Category -->
        @if($product->categories->count() > 0)
            <div class="text-xs text-gray-500 uppercase tracking-wide mb-1">
                {{ $product->categories->first()->name }}
            </div>
        @endif
        
        <a href="{{ $productUrl }}">
            <h3 class="text-base font-semibold text-gray-900 hover:text-[#db1cb5] transition mb-2 h-12 line-clamp-2" style="font-family: 'Fraunces', serif;">
                {{ $productName }}
            </h3>
        </a>

        <!-- Colors -->
        <div class="h-6 mb-3">
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
        
        <!-- Price and Add to Cart -->
        <div class="flex justify-between items-center mt-auto">
            <div>
                @if(method_exists($product, 'hasDiscount') && $product->hasDiscount())
                    <div class="flex flex-col">
                        <span class="text-xs line-through text-gray-400">
                            RON {{ number_format($product->price, 2) }}
                        </span>
                        <span class="text-xl font-semibold text-[#db1cb5]">
                            RON {{ number_format($product->final_price, 2) }}
                        </span>
                    </div>
                @else
                    <span class="text-xl font-semibold text-[#db1cb5]">
                        RON {{ number_format($product->price, 2) }}
                    </span>
                @endif
            </div>
            
            @if($product->stock > 0)
                <button onclick="addToCart({{ $product->id }}, 1)"
                        class="bg-[#f5d5ee] text-[#db1cb5] px-3 py-2 rounded-lg font-medium text-sm transition-all duration-300 hover:bg-[#db1cb5] hover:text-white">
                    Adaugă
                </button>
            @else
                <button disabled
                        class="bg-gray-300 text-gray-500 px-3 py-2 rounded-lg cursor-not-allowed font-medium text-sm">
                    Epuizat
                </button>
            @endif
        </div>
    </div>
</div>