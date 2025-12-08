<x-guest-layout>
    <div class="py-8 bg-gradient-to-b from-pink-50 to-white">
        <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Sidebar Filters -->
                <aside class="w-full lg:w-72 flex-shrink-0">
                    <div class="bg-white rounded-xl shadow-md p-5 sticky top-6 border border-gray-100"
                         x-data="{ 
                            selectedCategory: {{ request('category') ?? 'null' }},
                            expandedCategories: {{ request('category') ? '[' . request('category') . ']' : '[]' }}
                         }">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-base font-bold text-gray-900">Filters</h3>
                            @if(request()->hasAny(['category', 'color', 'search', 'min_price', 'max_price']))
                                <a href="{{ route('shop') }}" 
                                   class="text-xs text-primary hover:text-primary-dark underline font-medium">
                                    Clear All
                                </a>
                            @endif
                        </div>

                        <form method="GET" action="{{ route('shop') }}" id="filterForm" class="space-y-4">
                            <!-- Search Bar -->
                            <div>
                                <label for="search" class="block text-xs font-semibold text-gray-700 mb-2">
                                    Search Products
                                </label>
                                <div class="relative">
                                    <input type="text" 
                                           name="search" 
                                           id="search"
                                           value="{{ request('search') }}"
                                           placeholder="Search..."
                                           class="w-full px-3 py-2 text-sm border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition">
                                    @if(request('search'))
                                        <button type="button" 
                                                onclick="document.getElementById('search').value=''; document.getElementById('filterForm').submit();"
                                                class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-primary">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <!-- Price Range Filter -->
                            <div class="pb-4 border-b border-gray-200">
                                <label class="block text-xs font-semibold text-gray-700 mb-2">
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
                                           class="w-full px-2 py-1.5 text-sm border-2 border-gray-200 rounded-md focus:ring-2 focus:ring-primary focus:border-primary transition">
                                    <span class="text-gray-400 text-sm">—</span>
                                    <input type="number" 
                                           name="max_price" 
                                           id="max_price"
                                           value="{{ request('max_price') }}"
                                           placeholder="Max"
                                           min="0"
                                           step="0.01"
                                           class="w-full px-2 py-1.5 text-sm border-2 border-gray-200 rounded-md focus:ring-2 focus:ring-primary focus:border-primary transition">
                                </div>
                                @if($priceRange)
                                    <p class="text-xs text-gray-500 mt-1.5">
                                        Range: ${{ number_format($priceRange->min, 2) }} - ${{ number_format($priceRange->max, 2) }}
                                    </p>
                                @endif
                            </div>

                            <!-- Categories Filter with Subcategories -->
                            <div class="pb-4 border-b border-gray-200">
                                <label class="block text-xs font-semibold text-gray-700 mb-2">
                                    Categories
                                </label>
                                <input type="hidden" name="category" x-model="selectedCategory">
                                
                                <div class="space-y-1">
                                    <!-- All Products Option -->
                                    <button type="button"
                                            @click="selectedCategory = null; $nextTick(() => $el.closest('form').submit())"
                                            class="w-full text-left px-3 py-2 rounded-lg transition text-sm flex items-center justify-between"
                                            :class="selectedCategory === null ? 'bg-primary text-white font-semibold' : 'hover:bg-gray-50 text-gray-700'">
                                        <span>All Products</span>
                                    </button>

                                    <!-- Parent Categories with Subcategories -->
                                    @foreach($categories as $cat)
                                        <div class="space-y-1">
                                            <!-- Parent Category -->
                                            <div class="flex items-center gap-1">
                                                @if($cat->children->count() > 0)
                                                    <!-- Toggle Button for Subcategories -->
                                                    <button type="button"
                                                            @click="expandedCategories.includes({{ $cat->id }}) 
                                                                ? expandedCategories = expandedCategories.filter(id => id !== {{ $cat->id }})
                                                                : expandedCategories.push({{ $cat->id }})"
                                                            class="p-1 hover:bg-gray-100 rounded transition">
                                                        <svg class="w-4 h-4 transition-transform" 
                                                             :class="expandedCategories.includes({{ $cat->id }}) ? 'rotate-90' : ''"
                                                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                        </svg>
                                                    </button>
                                                @else
                                                    <div class="w-6"></div>
                                                @endif

                                                <!-- Category Button -->
                                                <button type="button"
                                                        @click="selectedCategory = {{ $cat->id }}; $nextTick(() => $el.closest('form').submit())"
                                                        class="flex-1 text-left px-3 py-2 rounded-lg transition text-sm flex items-center justify-between"
                                                        :class="selectedCategory == {{ $cat->id }} ? 'bg-primary text-white font-semibold' : 'hover:bg-gray-50 text-gray-700'">
                                                    <span>{{ $cat->name }}</span>
                                                    <span class="text-xs px-2 py-0.5 rounded-full font-semibold"
                                                          :class="selectedCategory == {{ $cat->id }} ? 'bg-white text-primary' : 'bg-gray-200 text-gray-700'">
                                                        {{ $cat->products_count }}
                                                    </span>
                                                </button>
                                            </div>

                                            <!-- Subcategories -->
                                            @if($cat->children->count() > 0)
                                                <div x-show="expandedCategories.includes({{ $cat->id }})" 
                                                     x-transition:enter="transition ease-out duration-200"
                                                     x-transition:enter-start="opacity-0 -translate-y-1"
                                                     x-transition:enter-end="opacity-100 translate-y-0"
                                                     class="ml-6 space-y-1 border-l-2 border-gray-200 pl-2">
                                                    @foreach($cat->children as $subcat)
                                                        <button type="button"
                                                                @click="selectedCategory = {{ $subcat->id }}; $nextTick(() => $el.closest('form').submit())"
                                                                class="w-full text-left px-3 py-2 rounded-lg transition text-sm flex items-center justify-between"
                                                                :class="selectedCategory == {{ $subcat->id }} ? 'bg-pink-100 text-primary font-semibold' : 'hover:bg-gray-50 text-gray-600'">
                                                            <span class="flex items-center gap-2">
                                                                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                                </svg>
                                                                {{ $subcat->name }}
                                                            </span>
                                                            <span class="text-xs px-2 py-0.5 rounded-full font-semibold"
                                                                  :class="selectedCategory == {{ $subcat->id }} ? 'bg-primary text-white' : 'bg-gray-200 text-gray-600'">
                                                                {{ $subcat->products_count }}
                                                            </span>
                                                        </button>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Colors Filter -->
                            @if($colors->count() > 0)
                                <div class="pb-4 border-b border-gray-200">
                                    <label for="color" class="block text-xs font-semibold text-gray-700 mb-2">
                                        Color
                                    </label>
                                    <select name="color" 
                                            id="color"
                                            class="w-full px-3 py-2 text-sm border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition">
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
                                    class="w-full bg-primary hover:bg-primary-dark text-white px-4 py-2.5 rounded-lg transition transform hover:scale-105 font-semibold text-sm shadow-md">
                                Apply Filters
                            </button>

                            <!-- Active Filters Display -->
                            @if(request()->hasAny(['category', 'color', 'search', 'min_price', 'max_price']))
                                <div class="pt-4 border-t border-gray-200">
                                    <p class="text-xs font-semibold text-gray-700 mb-2">Active Filters:</p>
                                    <div class="space-y-1.5">
                                        @if(request('search'))
                                            <div class="flex items-center justify-between text-xs bg-pink-50 px-2 py-1.5 rounded border border-pink-200">
                                                <span class="text-gray-700 truncate font-medium">Search: "{{ request('search') }}"</span>
                                                <a href="{{ route('shop', array_filter(['category' => request('category'), 'color' => request('color'), 'min_price' => request('min_price'), 'max_price' => request('max_price')])) }}" 
                                                   class="text-primary hover:text-primary-dark ml-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                        @endif
                                        
                                        @if(request('min_price') || request('max_price'))
                                            <div class="flex items-center justify-between text-xs bg-pink-50 px-2 py-1.5 rounded border border-pink-200">
                                                <span class="text-gray-700 font-medium">
                                                    ${{ request('min_price', '0') }} - ${{ request('max_price', '∞') }}
                                                </span>
                                                <a href="{{ route('shop', array_filter(['category' => request('category'), 'color' => request('color'), 'search' => request('search')])) }}" 
                                                   class="text-primary hover:text-primary-dark ml-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                        @endif

                                        @if(isset($selectedCategory))
                                            <div class="flex items-center justify-between text-xs bg-pink-50 px-2 py-1.5 rounded border border-pink-200">
                                                <span class="text-gray-700 font-medium">
                                                    {{ $selectedCategory->name }}
                                                    @if($selectedCategory->parent)
                                                        <span class="text-gray-500">({{ $selectedCategory->parent->name }})</span>
                                                    @endif
                                                </span>
                                                <a href="{{ route('shop', array_filter(['color' => request('color'), 'search' => request('search'), 'min_price' => request('min_price'), 'max_price' => request('max_price')])) }}" 
                                                   class="text-primary hover:text-primary-dark">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                        @endif
                                        
                                        @if(isset($selectedColor))
                                            <div class="flex items-center justify-between text-xs bg-pink-50 px-2 py-1.5 rounded border border-pink-200">
                                                <div class="flex items-center gap-1.5">
                                                    <div class="w-3 h-3 rounded-full border border-gray-300" 
                                                         style="background-color: {{ $selectedColor->hex_code }}">
                                                    </div>
                                                    <span class="text-gray-700 font-medium">{{ $selectedColor->name }}</span>
                                                </div>
                                                <a href="{{ route('shop', array_filter(['category' => request('category'), 'search' => request('search'), 'min_price' => request('min_price'), 'max_price' => request('max_price')])) }}" 
                                                   class="text-primary hover:text-primary-dark">
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
                            <h1 class="text-xl font-bold text-gray-900 mb-1">
                                @if(isset($selectedCategory) && isset($selectedColor))
                                    {{ $selectedCategory->name }} - <span class="text-primary">{{ $selectedColor->name }}</span>
                                @elseif(isset($selectedCategory))
                                    {{ $selectedCategory->name }}
                                    @if($selectedCategory->parent)
                                        <span class="text-sm text-gray-500 font-normal">in {{ $selectedCategory->parent->name }}</span>
                                    @endif
                                @elseif(isset($selectedColor))
                                    Products in <span class="text-primary">{{ $selectedColor->name }}</span>
                                @elseif(request('search'))
                                    Search: "<span class="text-primary">{{ request('search') }}</span>"
                                @else
                                    Our Products
                                @endif
                            </h1>
                            <p class="text-sm text-gray-600">{{ $products->count() }} of {{ $products->total() }} products</p>
                        </div>

                        <!-- Sort Dropdown -->
                        <div>
                            <form method="GET" action="{{ route('shop') }}" id="sortForm">
                                @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
                                @if(request('color'))<input type="hidden" name="color" value="{{ request('color') }}">@endif
                                @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}">@endif
                                @if(request('min_price'))<input type="hidden" name="min_price" value="{{ request('min_price') }}">@endif
                                @if(request('max_price'))<input type="hidden" name="max_price" value="{{ request('max_price') }}">@endif
                                
                                <select name="sort" 
                                        onchange="document.getElementById('sortForm').submit()"
                                        class="px-3 py-2 text-sm border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition font-medium">
                                    <option value="">Sort by</option>
                                    <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                                    <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                                    <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Name: A to Z</option>
                                    <option value="name_desc" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>Name: Z to A</option>
                                </select>
                            </form>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                        @forelse($products as $product)
                            <div class="bg-white rounded-xl shadow-md overflow-hidden hover-lift group border border-gray-100 flex flex-col h-full">
                                @php
                                    $primaryCategory = $product->categories->first();
                                    $productUrl = $primaryCategory 
                                        ? route('shop.product', [$primaryCategory->slug, $product->slug])
                                        : route('shop.product', ['uncategorized', $product->slug]);
                                @endphp
                                
                                <a href="{{ $productUrl }}" class="block">
                                    <div class="bg-gradient-to-br from-pink-100 to-purple-100 relative overflow-hidden h-64">
                                        @if($product->first_image)
                                            <img src="{{ asset('storage/' . $product->first_image) }}" 
                                                 alt="{{ $product->title }}"
                                                 class="w-full h-64 object-cover group-hover:scale-110 transition duration-500">
                                        @else
                                            <div class="w-full h-64 flex items-center justify-center">
                                                <svg class="w-16 h-16 text-primary opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                        
                                        @if($product->stock <= 0)
                                            <div class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center">
                                                <span class="bg-red-600 text-white px-3 py-1.5 rounded-full font-bold text-xs shadow-lg">Out of Stock</span>
                                            </div>
                                        @endif
                                    </div>
                                </a>
                                
                                <div class="p-4 flex flex-col flex-grow">
                                    <a href="{{ $productUrl }}">
                                        <h3 class="text-sm font-bold text-gray-900 hover:text-primary transition mb-1.5 h-10 line-clamp-2">
                                            {{ $product->title }}
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

                                    <p class="text-gray-600 text-xs mb-3 h-10 line-clamp-2 leading-relaxed">
                                        {{ $product->description }}
                                    </p>
                                    
                                   <div class="flex justify-between items-center mb-3 h-6">
                                        <div class="flex items-center gap-2">
                                            @if($product->hasDiscount())
                                                <span class="text-xs line-through text-gray-400">
                                                    ${{ number_format($product->price, 2) }}
                                                </span>
                                                <span class="text-lg font-bold text-red-600">
                                                    ${{ number_format($product->final_price, 2) }}
                                                </span>
                                                <span class="text-xs bg-red-100 text-red-800 px-2 py-0.5 rounded-full font-bold">
                                                    -{{ $product->discount_percentage }}%
                                                </span>
                                            @else
                                                <span class="text-lg font-bold text-primary">
                                                    ${{ number_format($product->price, 2) }}
                                                </span>
                                            @endif
                                        </div>
                                        <span class="text-xs text-gray-500">
                                            Stock: {{ $product->stock }}
                                        </span>
                                    </div>
                                    
                                    <div class="mt-auto">
                                        @if($product->stock > 0)
                                            <button onclick="addToCart({{ $product->id }}, 1)"
                                                    class="w-full bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded-lg transition transform hover:scale-105 flex items-center justify-center font-semibold text-sm shadow-md">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                </svg>
                                                Add to Cart
                                            </button>
                                        @else
                                            <button disabled 
                                                    class="w-full bg-gray-200 text-gray-500 px-4 py-2 rounded-lg cursor-not-allowed font-semibold text-sm">
                                                Out of Stock
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-12">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                                <p class="text-gray-600 text-sm font-medium mb-2">No products found.</p>
                                <a href="{{ route('shop') }}" class="text-primary hover:text-primary-dark font-semibold text-sm underline">Clear filters</a>
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