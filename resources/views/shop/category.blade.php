<x-guest-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="mb-6 text-sm">
                <ol class="flex items-center space-x-2 text-gray-600">
                    <li><a href="{{ route('shop') }}" class="hover:text-blue-600">Shop</a></li>
                    <li><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
                    <li class="font-semibold text-gray-900">{{ $category->name }}</li>
                </ol>
            </nav>

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Sidebar Filters -->
                <aside class="w-full lg:w-64 flex-shrink-0">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-gray-800">Filters</h3>
                            @if(request()->has('color'))
                                <a href="{{ route('shop.category', $category->slug) }}" 
                                   class="text-xs text-blue-600 hover:text-blue-800">
                                    Clear all
                                </a>
                            @endif
                        </div>

                        <!-- Active Filters -->
                        @if(isset($selectedColor))
                            <div class="mb-4 p-3 bg-blue-50 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <div class="w-4 h-4 rounded-full border border-gray-300" 
                                             style="background-color: {{ $selectedColor->hex_code }}">
                                        </div>
                                        <span class="text-sm font-medium text-gray-700">{{ $selectedColor->name }}</span>
                                    </div>
                                    <a href="{{ route('shop.category', $category->slug) }}" 
                                       class="text-gray-500 hover:text-red-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Categories Filter -->
                        <div class="mb-6">
                            <h4 class="font-semibold text-gray-700 mb-3">Categories</h4>
                            <div class="space-y-2">
                                <a href="{{ route('shop') }}" 
                                   class="flex items-center justify-between px-3 py-2 rounded hover:bg-gray-100 transition text-gray-700">
                                    <span>All Products</span>
                                </a>
                                @foreach($categories as $cat)
                                    <a href="{{ route('shop.category', $cat->slug) }}" 
                                       class="flex items-center justify-between px-3 py-2 rounded hover:bg-gray-100 transition {{ $cat->id === $category->id ? 'bg-blue-50 text-blue-600' : 'text-gray-700' }}">
                                        <span>{{ $cat->name }}</span>
                                        <span class="text-xs bg-gray-200 px-2 py-1 rounded-full">{{ $cat->products_count }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <!-- Colors Filter -->
                        @if($colors->count() > 0)
                            <div class="border-t pt-6">
                                <h4 class="font-semibold text-gray-700 mb-3">Colors</h4>
                                <div class="grid grid-cols-4 gap-2">
                                    @foreach($colors as $color)
                                        <a href="{{ route('shop.category', ['categorySlug' => $category->slug, 'color' => $color->id]) }}" 
                                           class="group relative">
                                            <div class="w-10 h-10 rounded-full border-2 cursor-pointer hover:scale-110 transition {{ isset($selectedColor) && $selectedColor->id === $color->id ? 'border-blue-500 ring-2 ring-blue-300' : 'border-gray-300' }}" 
                                                 style="background-color: {{ $color->hex_code }}"
                                                 title="{{ $color->name }}">
                                            </div>
                                            <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 text-xs text-white bg-gray-800 rounded opacity-0 group-hover:opacity-100 transition whitespace-nowrap z-10">
                                                {{ $color->name }}
                                            </span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </aside>

                <!-- Products Grid -->
                <div class="flex-1">
                    <div class="mb-6">
                        <h1 class="text-3xl font-bold text-gray-800">
                            {{ $category->name }}
                            @if(isset($selectedColor))
                                <span class="text-2xl text-gray-600">in {{ $selectedColor->name }}</span>
                            @endif
                        </h1>
                        @if($category->description)
                            <p class="text-gray-600 mt-2">{{ $category->description }}</p>
                        @endif
                        <p class="text-gray-600 mt-2">Showing {{ $products->count() }} of {{ $products->total() }} products</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($products as $product)
                            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition group">
                                <a href="{{ route('shop.product', [$category->slug, $product->slug]) }}">
                                    <div class="aspect-w-1 aspect-h-1 bg-gray-200 relative overflow-hidden">
                                        @if($product->first_image)
                                            <img src="{{ asset('storage/' . $product->first_image) }}" 
                                                 alt="{{ $product->title }}"
                                                 class="w-full h-64 object-cover group-hover:scale-105 transition duration-300">
                                        @else
                                            <div class="w-full h-64 flex items-center justify-center">
                                                <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                        
                                        @if($product->stock <= 0)
                                            <div class="absolute top-0 left-0 right-0 bottom-0 bg-black bg-opacity-50 flex items-center justify-center">
                                                <span class="bg-red-600 text-white px-4 py-2 rounded-lg font-semibold">Out of Stock</span>
                                            </div>
                                        @endif
                                    </div>
                                </a>
                                
                                <div class="p-4">
                                    <a href="{{ route('shop.product', [$category->slug, $product->slug]) }}">
                                        <h3 class="text-lg font-semibold text-gray-800 hover:text-blue-600 transition mb-2 line-clamp-1">
                                            {{ $product->title }}
                                        </h3>
                                    </a>
                                    
                                    <!-- Other Categories -->
                                    @if($product->categories->count() > 1)
                                        <div class="flex flex-wrap gap-1 mb-2">
                                            @foreach($product->categories->where('id', '!=', $category->id) as $otherCategory)
                                                <a href="{{ route('shop.category', $otherCategory->slug) }}" 
                                                   class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded hover:bg-gray-200 transition">
                                                    {{ $otherCategory->name }}
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif

                                    <!-- Colors -->
                                    @if($product->colors->count() > 0)
                                        <div class="flex gap-1 mb-3">
                                            @foreach($product->colors->take(5) as $color)
                                                <div class="w-5 h-5 rounded-full border border-gray-300" 
                                                     style="background-color: {{ $color->hex_code }}"
                                                     title="{{ $color->name }}">
                                                </div>
                                            @endforeach
                                            @if($product->colors->count() > 5)
                                                <span class="text-xs text-gray-500 self-center">+{{ $product->colors->count() - 5 }}</span>
                                            @endif
                                        </div>
                                    @endif

                                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                                        {{ $product->description }}
                                    </p>
                                    
                                    <div class="flex justify-between items-center mb-3">
                                        <span class="text-2xl font-bold text-blue-600">
                                            ${{ number_format($product->price, 2) }}
                                        </span>
                                        <span class="text-sm text-gray-500">
                                            Stock: {{ $product->stock }}
                                        </span>
                                    </div>
                                    
                                    @if($product->stock > 0)
                                        <button onclick="addToCart({{ $product->id }}, 1)"
                                                class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition flex items-center justify-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                            Add to Cart
                                        </button>
                                    @else
                                        <button disabled 
                                                class="w-full bg-gray-300 text-gray-500 px-4 py-2 rounded-lg cursor-not-allowed">
                                            Out of Stock
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-12">
                                <svg class="w-20 h-20 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                                <p class="text-gray-600 text-lg">No products found matching your filters.</p>
                                <a href="{{ route('shop.category', $category->slug) }}" class="text-blue-600 hover:underline mt-2 inline-block">Clear filters</a>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-8">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function addToCart(productId, quantity) {
            Livewire.dispatch('cart-add-item', { productId: productId, quantity: quantity });
        }
    </script>
</x-guest-layout>