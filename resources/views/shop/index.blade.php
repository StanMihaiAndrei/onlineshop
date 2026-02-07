<x-guest-layout>
    <div class="py-8 bg-background">
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
                            <h3 class="text-base font-bold text-gray-900">Filtre</h3>
                            @if(request()->hasAny(['category', 'color', 'search', 'min_price', 'max_price']))
                                <a href="{{ route('shop') }}" 
                                   class="text-xs text-primary hover:text-primary-dark underline font-medium">
                                    Eliminați toate filtrele
                                </a>
                            @endif
                        </div>

                        <form method="GET" action="{{ route('shop') }}" id="filterForm" class="space-y-4">
                            <!-- Search Bar -->
                            <div>
                                <label for="search" class="block text-xs font-semibold text-gray-700 mb-2">
                                    Caută produse
                                </label>
                                <div class="relative">
                                    <input type="text" 
                                           name="search" 
                                           id="search"
                                           value="{{ request('search') }}"
                                           placeholder="Caută..."
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
                                    Interval preț
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
                                        Interval: RON {{ number_format($priceRange->min, 2) }} - RON {{ number_format($priceRange->max, 2) }}
                                    </p>
                                @endif
                            </div>

                            <!-- Categories Filter with Subcategories -->
                            <div class="pb-4 border-b border-gray-200">
                                <label class="block text-xs font-semibold text-gray-700 mb-2">
                                    Categorii
                                </label>
                                
                                <div class="space-y-1">
                                    <!-- All Products Option -->
                                    <a href="{{ route('shop') }}"
                                    class="w-full text-left px-3 py-2 rounded-lg transition text-sm flex items-center justify-between {{ !request('category') ? 'bg-primary text-white font-semibold' : 'hover:bg-gray-50 text-gray-700' }}">
                                        <span>Toate produsele</span>
                                    </a>

                                    <!-- Parent Categories with Subcategories -->
                                    @foreach($categories as $cat)
                                        <div class="space-y-1" x-data="{ expanded: {{ request('category') == $cat->id || $cat->children->contains('id', request('category')) ? 'true' : 'false' }} }">
                                            <!-- Parent Category -->
                                            <div class="flex items-center gap-1">
                                                @if($cat->children->count() > 0)
                                                    <!-- Toggle Button for Subcategories -->
                                                    <button type="button"
                                                            @click="expanded = !expanded"
                                                            class="p-1 hover:bg-gray-100 rounded transition">
                                                        <svg class="w-4 h-4 transition-transform" 
                                                            :class="expanded ? 'rotate-90' : ''"
                                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                        </svg>
                                                    </button>
                                                @else
                                                    <div class="w-6"></div>
                                                @endif

                                                <!-- Category Link - Redirect to category page -->
                                                <a href="{{ route('shop.category', $cat->slug) }}"
                                                class="flex-1 text-left px-3 py-2 rounded-lg transition text-sm flex items-center justify-between {{ request('category') == $cat->id ? 'bg-primary text-white font-semibold' : 'hover:bg-gray-50 text-gray-700' }}">
                                                    <span>{{ $cat->name }}</span>
                                                    <span class="text-xs px-2 py-0.5 rounded-full font-semibold"
                                                        :class="'{{ request('category') == $cat->id ? 'bg-white text-primary' : 'bg-gray-200 text-gray-700' }}'">
                                                        {{ $cat->products_count }}
                                                    </span>
                                                </a>
                                            </div>

                                            <!-- Subcategories -->
                                            @if($cat->children->count() > 0)
                                                <div x-show="expanded" 
                                                    x-transition:enter="transition ease-out duration-200"
                                                    x-transition:enter-start="opacity-0 -translate-y-1"
                                                    x-transition:enter-end="opacity-100 translate-y-0"
                                                    class="ml-6 space-y-1 border-l-2 border-gray-200 pl-2">
                                                    @foreach($cat->children as $subcat)
                                                        <a href="{{ route('shop.category', ['categorySlug' => $cat->slug, 'subcategory' => $subcat->id]) }}"
                                                        class="w-full text-left px-3 py-2 rounded-lg transition text-sm flex items-center justify-between {{ request('category') == $subcat->id ? 'bg-pink-100 text-primary font-semibold' : 'hover:bg-gray-50 text-gray-700' }}">
                                                            <span>{{ $subcat->name }}</span>
                                                            <span class="text-xs px-2 py-0.5 rounded-full font-semibold {{ request('category') == $subcat->id ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700' }}">
                                                                {{ $subcat->products_count }}
                                                            </span>
                                                        </a>
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
                                        Culoare
                                    </label>
                                    <select name="color" 
                                            id="color"
                                            class="w-full px-3 py-2 text-sm border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition">
                                        <option value="">Toate culorile</option>
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
                                Aplică filtrele
                            </button>

                            <!-- Active Filters Display -->
                            @if(request()->hasAny(['category', 'color', 'search', 'min_price', 'max_price']))
                                <div class="pt-4 border-t border-gray-200">
                                    <p class="text-xs font-semibold text-gray-700 mb-2">Filtre active:</p>
                                    <div class="space-y-1.5">
                                        @if(request('search'))
                                            <div class="flex items-center justify-between text-xs bg-pink-50 px-2 py-1.5 rounded border border-pink-200">
                                                <span class="text-gray-700 truncate font-medium">Căutare: "{{ request('search') }}"</span>
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
                                    Produse în <span class="text-primary">{{ $selectedColor->name }}</span>
                                @elseif(request('search'))
                                    Căutare: "<span class="text-primary">{{ request('search') }}</span>"
                                @else
                                    Produsele noastre
                                @endif
                            </h1>
                            <p class="text-sm text-gray-600">{{ $products->count() }} din {{ $products->total() }} produse</p>
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
                                    <option value="">Sortează după</option>
                                    <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Preț: Crescător</option>
                                    <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Preț: Descrescător</option>
                                    <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Nume: A la Z</option>
                                    <option value="name_desc" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>Nume: Z la A</option>
                                </select>
                            </form>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                        @forelse($products as $product)
                            <x-product-card :product="$product" />
                        @empty
                            <div class="col-span-full text-center py-12">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                                <p class="text-gray-600 text-sm font-medium mb-2">Nu s-au găsit produse.</p>
                                <a href="{{ route('shop') }}" class="text-primary hover:text-primary-dark font-semibold text-sm underline">Eliminați filtrele</a>
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

        function toggleWishlist(productId) {
            Livewire.dispatch('wishlist-toggle', { productId: productId });
        }

         // Listen for wishlist updates from Livewire
    document.addEventListener('livewire:init', () => {
        Livewire.on('wishlist-icon-updated', () => {
            // Refresh page data to sync wishlist state
            setTimeout(() => {
                window.location.reload();
            }, 300);
        });
    });
    </script>
</x-guest-layout>