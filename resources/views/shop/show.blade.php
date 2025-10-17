<x-guest-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('shop') }}" class="text-blue-600 hover:text-blue-800">
                    ← Back to Shop
                </a>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-6">
                    <!-- Images Section -->
                    <div x-data="{ currentImage: 0, images: {{ json_encode($product->images ?? []) }} }">
                        @if($product->images && count($product->images) > 0)
                            <div class="relative">
                                <div class="aspect-w-1 aspect-h-1 bg-gray-100 rounded-lg overflow-hidden">
                                    <template x-for="(image, index) in images" :key="index">
                                        <img :src="`/storage/${image}`" 
                                             x-show="currentImage === index"
                                             class="w-full h-96 object-contain">
                                    </template>
                                </div>
                                
                                @if(count($product->images) > 1)
                                    <div class="flex gap-2 mt-4 overflow-x-auto">
                                        @foreach($product->images as $index => $image)
                                            <button @click="currentImage = {{ $index }}"
                                                    :class="currentImage === {{ $index }} ? 'ring-2 ring-blue-500' : ''"
                                                    class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden">
                                                <img src="{{ asset('storage/' . $image) }}" 
                                                     class="w-full h-full object-cover">
                                            </button>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="aspect-w-1 aspect-h-1 bg-gray-200 rounded-lg flex items-center justify-center">
                                <span class="text-gray-400">No image available</span>
                            </div>
                        @endif
                    </div>

                    <!-- Product Info Section -->
                    <div x-data="{ quantity: 1 }">
                        <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $product->title }}</h1>
                        
                        <div class="flex items-center gap-4 mb-6">
                            <span class="text-4xl font-bold text-blue-600">
                                ${{ number_format($product->price, 2) }}
                            </span>
                            <span class="px-3 py-1 text-sm font-semibold rounded-full 
                                {{ $product->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                            </span>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Description</h3>
                            <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
                        </div>

                        @if($product->stock > 0)
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                                <div class="flex items-center gap-4">
                                    <button @click="quantity = Math.max(1, quantity - 1)" 
                                            class="w-10 h-10 rounded-lg border border-gray-300 hover:bg-gray-50 flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                        </svg>
                                    </button>
                                    <input type="number" 
                                           x-model="quantity" 
                                           min="1" 
                                           :max="{{ $product->stock }}"
                                           class="w-20 text-center border border-gray-300 rounded-lg py-2">
                                    <button @click="quantity = Math.min({{ $product->stock }}, quantity + 1)" 
                                            class="w-10 h-10 rounded-lg border border-gray-300 hover:bg-gray-50 flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                    </button>
                                    <span class="text-sm text-gray-600">{{ $product->stock }} available</span>
                                </div>
                            </div>

                            <button @click="addToCart({{ $product->id }}, quantity)"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition flex items-center justify-center gap-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Add to Cart
                            </button>
                        @else
                            <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center">
                                <p class="text-red-800 font-semibold">This product is currently out of stock</p>
                            </div>
                        @endif
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