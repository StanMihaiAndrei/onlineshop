@props(['productId'])

@php
    if (auth()->check()) {
        $inWishlist = \App\Models\Wishlist::where('user_id', auth()->id())
                                         ->where('product_id', $productId)
                                         ->exists();
    } else {
        $wishlist = session()->get('wishlist', []);
        $inWishlist = in_array($productId, $wishlist);
    }
@endphp

<div x-data="{ 
    inWishlist: {{ $inWishlist ? 'true' : 'false' }},
    toggle() {
        this.inWishlist = !this.inWishlist;
        toggleWishlist({{ $productId }});
    }
}" 
@wishlist-icon-updated.window="
    if ($event.detail.productId == {{ $productId }}) {
        inWishlist = $event.detail.inWishlist;
    }
">
    <button 
        @click.stop="toggle()"
        type="button"
        class="group {{ $attributes->get('class', '') }}"
        :title="inWishlist ? 'Remove from wishlist' : 'Add to wishlist'">
        
        <template x-if="inWishlist">
            <svg class="w-5 h-5 text-pink-600 fill-current transition-transform group-hover:scale-110" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
            </svg>
        </template>
        
        <template x-if="!inWishlist">
            <svg class="w-5 h-5 text-gray-400 group-hover:text-pink-600 transition-all group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
        </template>
    </button>
</div>