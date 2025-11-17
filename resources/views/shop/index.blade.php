<x-guest-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-2">
            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Sidebar Filters -->
                <aside class="w-full lg:w-64 flex-shrink-0">
                    <div class="bg-white rounded-lg shadow-md p-5 sticky top-4">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-gray-800">Filters</h3>
                            @if(request()->hasAny(['category', 'color', 'search', 'min_price', 'max_price']))
                                <a href="{{ route('shop') }}" 
                                   class="text-xs text-blue-600 hover:text-blue-800 underline">
                                    Clear All
                                </a>
                            @endif
                        </div>

                        <form method="GET" action="{{ route('shop') }}" id="filterForm">
                            <!-- Search Bar -->
                            <div class="mb-4">
                                <label for="search" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Search
                                </label>
                                <div class="relative">
                                    <input type="text" 
                                           name="search" 
                                           id="search"
                                           value="{{ request('search') }}"
                                           placeholder="Search products..."
                                           class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                    @if(request('search'))
                                        <button type="button" 
                                                onclick="document.getElementById('search').value=''; document.getElementById('filterForm').submit();"
                                                class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <!-- Price Range Filter -->
                            <div class="mb-4 pb-4 border-b">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Price Range
                                </label>
                                <div class="flex gap-2 items-center">
                                    <input type="number" 
                                           name="min_price" 
                                           id="min_price"
                                           value="{{ request('min_price') }}"
                                           placeholder="Min"
                                           min="0"
                                           step="0.01"
                                           class="w-full px-2 py-1.5 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <span class="text-gray-500">-</span>
                                    <input type="number" 
                                           name="max_price" 
                                           id="max_price"
                                           value="{{ request('max_price') }}"
                                           placeholder="Max"
                                           min="0"
                                           step="0.01"
                                           class="w-full px-2 py-1.5 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                @if($priceRange)
                                    <p class="text-xs text-gray-500 mt-1">
                                        Range: ${{ number_format($priceRange->min, 2) }} - ${{ number_format($priceRange->max, 2) }}
                                    </p>
                                @endif
                            </div>

                            <!-- Categories Filter -->
                            <div class="mb-4">
                                <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Category
                                </label>
                                <select name="category" 
                                        id="category"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" 
                                                {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }} ({{ $category->products_count }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Colors Filter -->
                            @if($colors->count() > 0)
                                <div class="mb-4 pb-4 border-b">
                                    <label for="color" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Color
                                    </label>
                                    <select name="color" 
                                            id="color"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                        <option value="">All Colors</option>
                                        @foreach($colors as $color)
                                            <option value="{{ $color->id }}" 
                                                    {{ request('color') == $color->id ? 'selected' : '' }}>
                                                {{ $color->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <!-- Apply Filters Button -->
                            <button type="submit" 
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition text-sm font-semibold">
                                Apply Filters
                            </button>

                            <!-- Active Filters Display -->
                            @if(request()->hasAny(['category', 'color', 'search', 'min_price', 'max_price']))
                                <div class="mt-4 pt-4 border-t">
                                    <p class="text-xs font-semibold text-gray-600 mb-2">Active Filters:</p>
                                    <div class="space-y-2">
                                        @if(request('search'))
                                            <div class="flex items-center justify-between text-xs bg-blue-50 px-2 py-1.5 rounded">
                                                <span class="text-gray-700 truncate">Search: "{{ request('search') }}"</span>
                                                <a href="{{ route('shop', array_filter(['category' => request('category'), 'color' => request('color'), 'min_price' => request('min_price'), 'max_price' => request('max_price')])) }}" 
                                                   class="text-red-600 hover:text-red-800 ml-2">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                        @endif
                                        
                                        @if(request('min_price') || request('max_price'))
                                            <div class="flex items-center justify-between text-xs bg-blue-50 px-2 py-1.5 rounded">
                                                <span class="text-gray-700">
                                                    Price: ${{ request('min_price', '0') }} - ${{ request('max_price', '∞') }}
                                                </span>
                                                <a href="{{ route('shop', array_filter(['category' => request('category'), 'color' => request('color'), 'search' => request('search')])) }}" 
                                                   class="text-red-600 hover:text-red-800 ml-2">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                        @endif

                                        @if(isset($selectedCategory))
                                            <div class="flex items-center justify-between text-xs bg-blue-50 px-2 py-1.5 rounded">
                                                <span class="text-gray-700">{{ $selectedCategory->name }}</span>
                                                <a href="{{ route('shop', array_filter(['color' => request('color'), 'search' => request('search'), 'min_price' => request('min_price'), 'max_price' => request('max_price')])) }}" 
                                                   class="text-red-600 hover:text-red-800">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                        @endif
                                        
                                        @if(isset($selectedColor))
                                            <div class="flex items-center justify-between text-xs bg-blue-50 px-2 py-1.5 rounded">
                                                <div class="flex items-center gap-1.5">
                                                    <div class="w-3 h-3 rounded-full border border-gray-300" 
                                                         style="background-color: {{ $selectedColor->hex_code }}">
                                                    </div>
                                                    <span class="text-gray-700">{{ $selectedColor->name }}</span>
                                                </div>
                                                <a href="{{ route('shop', array_filter(['category' => request('category'), 'search' => request('search'), 'min_price' => request('min_price'), 'max_price' => request('max_price')])) }}" 
                                                   class="text-red-600 hover:text-red-800">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </form>
                    </div>
                </aside>

                <!-- Products Grid -->
                <div class="flex-1 min-w-0">
                    <div class="mb-6 flex justify-between items-center">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800">
                                @if(isset($selectedCategory) && isset($selectedColor))
                                    {{ $selectedCategory->name }} - {{ $selectedColor->name }}
                                @elseif(isset($selectedCategory))
                                    {{ $selectedCategory->name }}
                                @elseif(isset($selectedColor))
                                    Products in {{ $selectedColor->name }}
                                @elseif(request('search'))
                                    Search Results for "{{ request('search') }}"
                                @else
                                    Our Products
                                @endif
                            </h1>
                            <p class="text-gray-600 mt-2">Showing {{ $products->count() }} of {{ $products->total() }} products</p>
                        </div>

                        <!-- Sort Dropdown -->
                        <div>
                            <form method="GET" action="{{ route('shop') }}" id="sortForm">
                                <!-- Păstrează filtrele existente -->
                                @if(request('category'))
                                    <input type="hidden" name="category" value="{{ request('category') }}">
                                @endif
                                @if(request('color'))
                                    <input type="hidden" name="color" value="{{ request('color') }}">
                                @endif
                                @if(request('search'))
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                @endif
                                @if(request('min_price'))
                                    <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                                @endif
                                @if(request('max_price'))
                                    <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                                @endif
                                
                                <select name="sort" 
                                        onchange="document.getElementById('sortForm').submit()"
                                        class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                    <option value="">Sort by</option>
                                    <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                                    <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                                    <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Name: A to Z</option>
                                    <option value="name_desc" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>Name: Z to A</option>
                                </select>
                            </form>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-6">
                        @forelse($products as $product)
                            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition group">
                                @php
                                    $primaryCategory = $product->categories->first();
                                    $productUrl = $primaryCategory 
                                        ? route('shop.product', [$primaryCategory->slug, $product->slug])
                                        : route('shop.product', ['uncategorized', $product->slug]);
                                @endphp
                                
                                <a href="{{ $productUrl }}">
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
                                    <a href="{{ $productUrl }}">
                                        <h3 class="text-lg font-semibold text-gray-800 hover:text-blue-600 transition mb-2 line-clamp-1">
                                            {{ $product->title }}
                                        </h3>
                                    </a>
                                    
                                    <!-- Categories -->
                                    @if($product->categories->count() > 0)
                                        <div class="flex flex-wrap gap-1 mb-2">
                                            @foreach($product->categories as $category)
                                                <a href="{{ route('shop.category', $category->slug) }}" 
                                                   class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded hover:bg-gray-200 transition">
                                                    {{ $category->name }}
                                                </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="mb-2">
                                            <span class="text-xs bg-gray-100 text-gray-500 px-2 py-1 rounded italic">
                                                Uncategorized
                                            </span>
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
                                <a href="{{ route('shop') }}" class="text-blue-600 hover:underline mt-2 inline-block">Clear filters</a>
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

    <!-- Footer Component -->
    <livewire:layout.footer />

    <script>
        function addToCart(productId, quantity) {
            Livewire.dispatch('cart-add-item', { productId: productId, quantity: quantity });
        }
    </script>
</x-guest-layout>