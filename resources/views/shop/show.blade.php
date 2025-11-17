<x-guest-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="mb-6 text-sm">
                <ol class="flex items-center space-x-2 text-gray-600">
                    <li><a href="{{ route('shop') }}" class="hover:text-blue-600">Shop</a></li>
                    @if(isset($category))
                        <li><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
                        <li><a href="{{ route('shop.category', $category->slug) }}" class="hover:text-blue-600">{{ $category->name }}</a></li>
                    @endif
                    <li><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
                    <li class="font-semibold text-gray-900">{{ $product->title }}</li>
                </ol>
            </nav>

            <div class="mb-6">
                <a href="{{ isset($category) ? route('shop.category', $category->slug) : route('shop') }}" 
                   class="text-blue-600 hover:text-blue-800 inline-flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to {{ isset($category) ? $category->name : 'Shop' }}
                </a>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-6">
                    <!-- Images Section -->
                    <div x-data="{ currentImage: 0, images: {{ json_encode($product->images ?? []) }} }">
                        @if($product->images && count($product->images) > 0)
                            <div class="relative">
                                <div class="aspect-w-1 aspect-h-1 bg-gray-100 rounded-lg overflow-hidden mb-4">
                                    <template x-for="(image, index) in images" :key="index">
                                        <img :src="`/storage/${image}`" 
                                             x-show="currentImage === index"
                                             :alt="`{{ $product->title }} - Image ${index + 1}`"
                                             class="w-full h-96 object-contain">
                                    </template>
                                </div>
                                
                                @if(count($product->images) > 1)
                                    <div class="grid grid-cols-4 gap-2">
                                        @foreach($product->images as $index => $image)
                                            <button @click="currentImage = {{ $index }}"
                                                    :class="currentImage === {{ $index }} ? 'ring-2 ring-blue-500' : 'ring-1 ring-gray-300'"
                                                    class="aspect-w-1 aspect-h-1 rounded-lg overflow-hidden hover:ring-2 hover:ring-blue-400 transition">
                                                <img src="{{ asset('storage/' . $image) }}" 
                                                     alt="Thumbnail {{ $index + 1 }}"
                                                     class="w-full h-20 object-cover">
                                            </button>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="aspect-w-1 aspect-h-1 bg-gray-200 rounded-lg flex items-center justify-center">
                                <svg class="w-32 h-32 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Product Info Section -->
                    <div x-data="{ quantity: 1 }">
                        <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $product->title }}</h1>
                        
                        <!-- Categories -->
                        @if($product->categories->count() > 0)
                            <div class="flex flex-wrap gap-2 mb-4">
                                @foreach($product->categories as $cat)
                                    <a href="{{ route('shop.category', $cat->slug) }}" 
                                       class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm hover:bg-gray-200 transition">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                        {{ $cat->name }}
                                    </a>
                                @endforeach
                            </div>
                        @endif

                        <!-- Colors -->
                        @if($product->colors->count() > 0)
                            <div class="mb-6">
                                <h3 class="text-sm font-semibold text-gray-700 mb-2">Available Colors:</h3>
                                <div class="flex flex-wrap gap-3">
                                    @foreach($product->colors as $color)
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-full border-2 border-gray-300 shadow-sm" 
                                                 style="background-color: {{ $color->hex_code }}"
                                                 title="{{ $color->name }}">
                                            </div>
                                            <span class="text-sm text-gray-700">{{ $color->name }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        
                        <div class="flex items-center gap-4 mb-6">
                            <span class="text-4xl font-bold text-blue-600">
                                ${{ number_format($product->price, 2) }}
                            </span>
                            <span class="px-3 py-1 text-sm font-semibold rounded-full 
                                {{ $product->stock > 10 ? 'bg-green-100 text-green-800' : ($product->stock > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                @if($product->stock > 10)
                                    In Stock ({{ $product->stock }})
                                @elseif($product->stock > 0)
                                    Only {{ $product->stock }} left
                                @else
                                    Out of Stock
                                @endif
                            </span>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Description</h3>
                            <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
                        </div>

                        @if($product->stock > 0)
                            <div class="flex gap-4 mb-6">
                                <div class="flex items-center border border-gray-300 rounded-lg">
                                    <button @click="quantity = Math.max(1, quantity - 1)" 
                                            class="px-4 py-2 hover:bg-gray-100 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                        </svg>
                                    </button>
                                    <input type="number" 
                                           x-model="quantity" 
                                           min="1" 
                                           :max="{{ $product->stock }}"
                                           class="w-16 text-center border-0 focus:ring-0">
                                    <button @click="quantity = Math.min({{ $product->stock }}, quantity + 1)" 
                                            class="px-4 py-2 hover:bg-gray-100 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </button>
                                </div>
                                <button @click="addToCart({{ $product->id }}, quantity)" 
                                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    Add to Cart
                                </button>
                            </div>
                        @else
                            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                                <p class="text-red-800 font-semibold">This product is currently out of stock</p>
                            </div>
                        @endif

                        <!-- Product Meta -->
                        <div class="border-t pt-6 space-y-2 text-sm text-gray-600">
                            <div class="flex justify-between">
                                <span>SKU:</span>
                                <span class="font-medium">{{ $product->id }}</span>
                            </div>
                            @if($product->categories->count() > 0)
                                <div class="flex justify-between">
                                    <span>Categories:</span>
                                    <span class="font-medium">{{ $product->categories->pluck('name')->join(', ') }}</span>
                                </div>
                            @endif
                        </div>
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