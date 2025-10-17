<x-guest-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-8">Our Products</h1>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($products as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition group">
                        <a href="{{ route('shop.show', $product->slug) }}">
                            <div class="aspect-w-1 aspect-h-1 bg-gray-200">
                                @if($product->first_image)
                                    <img src="{{ asset('storage/' . $product->first_image) }}" 
                                         alt="{{ $product->title }}" 
                                         class="w-full h-64 object-cover group-hover:scale-105 transition duration-300">
                                @else
                                    <div class="w-full h-64 flex items-center justify-center bg-gray-200">
                                        <span class="text-gray-400">No image</span>
                                    </div>
                                @endif
                            </div>
                        </a>
                        
                        <div class="p-4">
                            <a href="{{ route('shop.show', $product->slug) }}">
                                <h3 class="text-lg font-semibold text-gray-800 mb-2 line-clamp-2 hover:text-blue-600">
                                    {{ $product->title }}
                                </h3>
                            </a>
                            <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                                {{ Str::limit($product->description, 80) }}
                            </p>
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-xl font-bold text-blue-600">
                                    ${{ number_format($product->price, 2) }}
                                </span>
                                <span class="text-sm {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                                </span>
                            </div>
                            
                            @if($product->stock > 0)
                                <button 
                                    onclick="addToCart({{ $product->id }}, 1)"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Add to Cart
                                </button>
                            @else
                                <button disabled class="w-full bg-gray-300 text-gray-500 font-semibold py-2 px-4 rounded-lg cursor-not-allowed">
                                    Out of Stock
                                </button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-600 text-lg">No products available at the moment.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $products->links() }}
            </div>
        </div>
    </div>

    <script>
        function addToCart(productId, quantity) {
            Livewire.dispatch('cart-add-item', { productId: productId, quantity: quantity });
        }
    </script>
</x-guest-layout>