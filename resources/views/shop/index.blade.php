<x-guest-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-8">Our Products</h1>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($products as $product)
                    <a href="{{ route('shop.show', $product->slug) }}" 
                       class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition group">
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
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2 line-clamp-2">
                                {{ $product->title }}
                            </h3>
                            <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                                {{ Str::limit($product->description, 80) }}
                            </p>
                            <div class="flex justify-between items-center">
                                <span class="text-xl font-bold text-blue-600">
                                    ${{ number_format($product->price, 2) }}
                                </span>
                                <span class="text-sm text-gray-500">
                                    {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                                </span>
                            </div>
                        </div>
                    </a>
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
</x-guest-layout>