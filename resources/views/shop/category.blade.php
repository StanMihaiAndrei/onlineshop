<x-guest-layout>
    <!-- SEO Meta Tags -->
    <x-slot name="head">
        @php
            $pageTitle = isset($selectedSubcategory) ? $selectedSubcategory->name . ' | ' . $category->name : $category->name;
            $pageDescription = isset($selectedSubcategory) && $selectedSubcategory->description 
                ? Str::limit($selectedSubcategory->description, 155) 
                : ($category->description ? Str::limit($category->description, 155) : 'Descoperă produse handmade din categoria ' . $category->name . ' la Craft Gifts. Decorațiuni artizanale și cadouri personalizate create cu pasiune.');
            $keywords = [$category->name];
            if(isset($selectedSubcategory)) $keywords[] = $selectedSubcategory->name;
            if(isset($selectedColor)) $keywords[] = $selectedColor->name;
            $keywords[] = 'decoratiuni handmade';
            $keywords[] = 'cadouri personalizate';
            $keywords[] = 'craft Romania';
        @endphp
        
        <title>{{ $pageTitle }} - Craft Gifts | Decorațiuni Handmade</title>
        <meta name="description" content="{{ $pageDescription }}">
        <meta name="keywords" content="{{ implode(', ', $keywords) }}">
        <meta name="robots" content="index, follow">
        
        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="product.group">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:title" content="{{ $pageTitle }} - Craft Gifts">
        <meta property="og:description" content="{{ $pageDescription }}">
        @if($products->count() > 0 && $products->first()->images && count($products->first()->images) > 0)
        <meta property="og:image" content="{{ asset('storage/' . $products->first()->images[0]) }}">
        @else
        <meta property="og:image" content="{{ asset('images/transparent.jpg') }}">
        @endif
        
        <!-- Twitter -->
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="{{ url()->current() }}">
        <meta property="twitter:title" content="{{ $pageTitle }} - Craft Gifts">
        <meta property="twitter:description" content="{{ $pageDescription }}">
        @if($products->count() > 0 && $products->first()->images && count($products->first()->images) > 0)
        <meta property="twitter:image" content="{{ asset('storage/' . $products->first()->images[0]) }}">
        @else
        <meta property="twitter:image" content="{{ asset('images/transparent.jpg') }}">
        @endif
        
        <!-- Canonical URL -->
        <link rel="canonical" href="{{ url()->current() }}">
        
        <!-- Schema.org ItemList Structured Data -->
        <script type="application/ld+json">
        {
            "context": "https://schema.org",
            "type": "ItemList",
            "name": "{{ $pageTitle }}",
            "description": "{{ $pageDescription }}",
            "numberOfItems": "{{ $products->total() }}",
            "itemListElement": [
                @foreach($products->take(10) as $index => $product)
                {
                    "type": "ListItem",
                    "position": {{ $index + 1 }},
                    "item": {
                        "type": "Product",
                        "name": "{{ $product->title }}",
                        "url": "{{ route('shop', ['categorySlug' => $category->slug, 'productSlug' => $product->slug]) }}",
                        @if($product->images && count($product->images) > 0)
                        "image": "{{ asset('storage/' . $product->images[0]) }}",
                        @endif
                        "offers": {
                            "type": "Offer",
                            "price": "{{ $product->hasDiscount() ? $product->discount_price : $product->price }}",
                            "priceCurrency": "RON",
                            "availability": "{{ $product->stock > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' }}"
                        }
                    }
                }{{ $index < min(9, $products->count() - 1) ? ',' : '' }}
                @endforeach
            ]
        }
        </script>
        
        <!-- BreadcrumbList Schema -->
        <script type="application/ld+json">
        {
            "context": "https://schema.org",
            "type": "BreadcrumbList",
            "itemListElement": [
                {
                    "type": "ListItem",
                    "position": 1,
                    "name": "Acasă",
                    "item": "{{ route('home') }}"
                },
                {
                    "type": "ListItem",
                    "position": 2,
                    "name": "Shop",
                    "item": "{{ route('shop') }}"
                }
                @if($category->parent)
                ,
                {
                    "type": "ListItem",
                    "position": 3,
                    "name": "{{ $category->parent->name }}",
                    "item": "{{ route('shop.category', $category->parent->slug) }}"
                },
                {
                    "type": "ListItem",
                    "position": 4,
                    "name": "{{ $category->name }}",
                    "item": "{{ route('shop.category', $category->slug) }}"
                }
                @else
                ,
                {
                    "type": "ListItem",
                    "position": 3,
                    "name": "{{ $category->name }}",
                    "item": "{{ route('shop.category', $category->slug) }}"
                }
                @endif
                @if(isset($selectedSubcategory))
                ,
                {
                    "type": "ListItem",
                    "position": {{ $category->parent ? 5 : 4 }},
                    "name": "{{ $selectedSubcategory->name }}",
                    "item": "{{ url()->current() }}"
                }
                @endif
            ]
        }
        </script>
    </x-slot>

    <div class="py-8 bg-background">
        <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="mb-6 text-sm">
                <ol class="flex items-center space-x-2 text-gray-600">
                    <li><a href="{{ route('shop') }}" class="hover:text-primary font-medium transition">Shop</a></li>
                    <li><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
                    @if($category->parent)
                        <li><a href="{{ route('shop.category', $category->parent->slug) }}" class="hover:text-primary font-medium transition">{{ $category->parent->name }}</a></li>
                        <li><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
                    @endif
                    <li class="font-bold text-primary">{{ $category->name }}</li>
                </ol>
            </nav>

            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Sidebar Filters -->
                <aside class="w-full lg:w-72 flex-shrink-0">
                    <div class="bg-white rounded-xl shadow-md p-5 sticky top-6 border border-gray-100"
                         x-data="{ 
                            expandedCategories: [{{ $category->id }}]
                         }">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-base font-bold text-gray-900">Filtre</h3>
                            @if(request()->hasAny(['subcategory', 'color', 'search', 'min_price', 'max_price']))
                                <a href="{{ route('shop.category', $category->slug) }}" 
                                   class="text-xs text-primary hover:text-primary-dark underline font-medium">
                                    Eliminați toate filtrele
                                </a>
                            @endif
                        </div>

                        <form method="GET" action="{{ route('shop.category', $category->slug) }}" id="filterForm" class="space-y-4">
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
                                           placeholder="Search in {{ $category->name }}..."
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

                            <!-- Subcategories Filter (if available) -->
                            @if($category->children->count() > 0)
                                <div class="pb-4 border-b border-gray-200">
                                    <label class="block text-xs font-semibold text-gray-700 mb-2">
                                        Subcategorii în {{ $category->name }}
                                    </label>
                                    
                                    <div class="space-y-1">
                                        <!-- All from main category -->
                                        <a href="{{ route('shop.category', $category->slug) }}" 
                                           class="flex items-center justify-between px-3 py-2 rounded-lg transition text-sm {{ !request('subcategory') ? 'bg-primary text-white font-semibold' : 'hover:bg-gray-50 text-gray-700' }}">
                                            <span>All {{ $category->name }}</span>
                                        </a>

                                        <!-- Subcategories list -->
                                        @foreach($category->children as $subcat)
                                            <a href="{{ route('shop.category', ['categorySlug' => $category->slug, 'subcategory' => $subcat->id]) }}" 
                                               class="flex items-center justify-between px-3 py-2 rounded-lg transition text-sm {{ request('subcategory') == $subcat->id ? 'bg-pink-100 text-primary font-semibold' : 'hover:bg-gray-50 text-gray-700' }}">
                                                <span class="flex items-center gap-2">
                                                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                    </svg>
                                                    {{ $subcat->name }}
                                                </span>
                                                <span class="text-xs px-2 py-0.5 rounded-full font-semibold {{ request('subcategory') == $subcat->id ? 'bg-primary text-white' : 'bg-gray-200 text-gray-600' }}">
                                                    {{ $subcat->products_count }}
                                                </span>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        
                            <!-- All Categories Navigation -->
                            <div class="pb-4 border-b border-gray-200">
                                <h4 class="font-semibold text-gray-700 mb-3 text-sm">Toate categoriile</h4>
                                <div class="space-y-1">
                                    <a href="{{ route('shop') }}" 
                                       class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-pink-50 transition text-gray-700 text-sm">
                                        <span>Toate produsele</span>
                                    </a>
                                    @foreach($categories as $cat)
                                        <div class="space-y-1">
                                            <!-- Parent Category -->
                                            <div class="flex items-center gap-1">
                                                @if($cat->children->count() > 0)
                                                    <!-- Toggle Button -->
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

                                                <!-- Category Link -->
                                                <a href="{{ route('shop.category', $cat->slug) }}" 
                                                   class="flex-1 flex items-center justify-between px-3 py-2 rounded-lg transition text-sm {{ $cat->id === $category->id ? 'bg-pink-100 text-primary font-semibold' : 'hover:bg-gray-50 text-gray-700' }}">
                                                    <span>{{ $cat->name }}</span>
                                                    <span class="text-xs px-2 py-0.5 rounded-full font-semibold {{ $cat->id === $category->id ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700' }}">
                                                        {{ $cat->products_count }}
                                                    </span>
                                                </a>
                                            </div>

                                            <!-- Subcategories -->
                                            @if($cat->children->count() > 0)
                                                <div x-show="expandedCategories.includes({{ $cat->id }})" 
                                                     x-transition:enter="transition ease-out duration-200"
                                                     x-transition:enter-start="opacity-0 -translate-y-1"
                                                     x-transition:enter-end="opacity-100 translate-y-0"
                                                     class="ml-6 space-y-1 border-l-2 border-gray-200 pl-2">
                                                    @foreach($cat->children as $subcat)
                                                        <a href="{{ route('shop.category', $subcat->slug) }}" 
                                                           class="flex items-center justify-between px-3 py-2 rounded-lg transition text-sm {{ $subcat->id === $category->id ? 'bg-pink-100 text-primary font-semibold' : 'hover:bg-gray-50 text-gray-600' }}">
                                                            <span class="flex items-center gap-2">
                                                                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                                </svg>
                                                                {{ $subcat->name }}
                                                            </span>
                                                            <span class="text-xs px-2 py-0.5 rounded-full font-semibold {{ $subcat->id === $category->id ? 'bg-primary text-white' : 'bg-gray-200 text-gray-600' }}">
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
                                <div class="pb-4">
                                    <h4 class="font-semibold text-gray-700 mb-3 text-sm">Colors</h4>
                                    <div class="grid grid-cols-4 gap-2">
                                        @foreach($colors as $color)
                                            <a href="{{ route('shop.category', ['categorySlug' => $category->slug, 'color' => $color->id] + request()->only(['subcategory', 'search', 'min_price', 'max_price'])) }}" 
                                               class="group relative">
                                                <div class="w-10 h-10 rounded-full border-2 cursor-pointer hover:scale-110 transition shadow-md {{ isset($selectedColor) && $selectedColor->id === $color->id ? 'border-primary ring-4 ring-pink-200' : 'border-gray-300' }}" 
                                                     style="background-color: {{ $color->hex_code }}"
                                                     title="{{ $color->name }}">
                                                </div>
                                                <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 text-xs text-white bg-gray-900 rounded opacity-0 group-hover:opacity-100 transition whitespace-nowrap z-10 font-medium">
                                                    {{ $color->name }}
                                                </span>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Apply Filters Button -->
                            <button type="submit" 
                                    class="w-full bg-primary hover:bg-primary-dark text-white px-4 py-2.5 rounded-lg transition transform hover:scale-105 font-semibold text-sm shadow-md">
                                Aplică filtrele
                            </button>

                            <!-- Active Filters Display -->
                            @if(request()->hasAny(['subcategory', 'color', 'search', 'min_price', 'max_price']))
                                <div class="pt-4 border-t border-gray-200">
                                    <p class="text-xs font-semibold text-gray-700 mb-2">Filtre active:</p>
                                    <div class="space-y-1.5">
                                        @if(request('search'))
                                            <div class="flex items-center justify-between text-xs bg-pink-50 px-2 py-1.5 rounded border border-pink-200">
                                                <span class="text-gray-700 truncate font-medium">Caută: "{{ request('search') }}"</span>
                                                <a href="{{ route('shop.category', ['categorySlug' => $category->slug] + request()->except('search')) }}" 
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
                                                <a href="{{ route('shop.category', ['categorySlug' => $category->slug] + request()->except(['min_price', 'max_price'])) }}" 
                                                   class="text-primary hover:text-primary-dark ml-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                        @endif

                                        @if(isset($selectedSubcategory))
                                            <div class="flex items-center justify-between text-xs bg-pink-50 px-2 py-1.5 rounded border border-pink-200">
                                                <span class="text-gray-700 font-medium">{{ $selectedSubcategory->name }}</span>
                                                <a href="{{ route('shop.category', ['categorySlug' => $category->slug] + request()->except('subcategory')) }}" 
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
                                                <a href="{{ route('shop.category', ['categorySlug' => $category->slug] + request()->except('color')) }}" 
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
                <div class="flex-1">
                    <div class="mb-6">
                        <h1 class="text-xl font-bold text-gray-900 mb-2">
                            @if(isset($selectedSubcategory))
                                {{ $selectedSubcategory->name }}
                                <span class="text-sm text-gray-500 font-normal">in {{ $category->name }}</span>
                            @else
                                {{ $category->name }}
                            @endif
                            @if(isset($selectedColor))
                                <span class="text-primary">- {{ $selectedColor->name }}</span>
                            @endif
                        </h1>
                        @if($category->description && !isset($selectedSubcategory))
                            <p class="text-gray-600 text-sm mt-2">{{ $category->description }}</p>
                        @endif
                        @if(isset($selectedSubcategory) && $selectedSubcategory->description)
                            <p class="text-gray-600 text-sm mt-2">{{ $selectedSubcategory->description }}</p>
                        @endif
                        <p class="text-gray-600 text-sm mt-2">Afișare {{ $products->count() }} din {{ $products->total() }} produse</p>
                    </div>

                    <!-- Sort Dropdown -->
                    <div class="mb-4 flex justify-end">
                        <form method="GET" action="{{ route('shop.category', $category->slug) }}" id="sortForm">
                            @if(request('subcategory'))<input type="hidden" name="subcategory" value="{{ request('subcategory') }}">@endif
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

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                        @forelse($products as $product)
                            <x-product-card :product="$product" :categorySlug="$category->slug" />
                        @empty
                            <div class="col-span-full text-center py-12">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                                <p class="text-gray-600 text-sm font-medium mb-2">Nu s-au găsit produse care să corespundă filtrelor tale.</p>
                                <a href="{{ route('shop.category', $category->slug) }}" class="text-primary hover:text-primary-dark font-semibold text-sm underline">Șterge filtrele</a>
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