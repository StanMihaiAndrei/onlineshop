<x-app-layout>
    <div class="container mx-auto px-4 py-6 max-w-6xl">
        <!-- Mobile Navigation -->
        <div class="mb-6 space-y-3 md:hidden">
            <a href="{{ route('admin.products.index') }}" 
               class="flex items-center justify-center w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Products
            </a>
            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('admin.products.edit', $product) }}" 
                   class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-center transition">
                    Edit Product
                </a>
                <form action="{{ route('admin.products.destroy', $product) }}" 
                      method="POST" 
                      onsubmit="return confirm('Are you sure you want to delete this product?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                        Delete
                    </button>
                </form>
            </div>
        </div>

        <!-- Desktop Navigation -->
        <div class="hidden md:flex mb-6 justify-between items-center">
            <a href="{{ route('admin.products.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Products
            </a>
            <div class="space-x-2">
                <a href="{{ route('admin.products.edit', $product) }}" 
                   class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Edit Product
                </a>
                <form action="{{ route('admin.products.destroy', $product) }}" 
                      method="POST" 
                      class="inline"
                      onsubmit="return confirm('Are you sure you want to delete this product?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                        Delete
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
                <!-- Left Side - Images -->
                <div>
                    @if($product->images && count($product->images) > 0)
                        <div x-data="{ currentImage: 0 }">
                            <!-- Main Image Display -->
                            <div class="bg-gray-100 rounded-lg overflow-hidden mb-4">
                                <template x-for="(image, index) in {{ json_encode($product->images) }}" :key="index">
                                    <img :src="`/storage/${image}`" 
                                         x-show="currentImage === index"
                                         class="w-full h-96 object-contain">
                                </template>
                            </div>
                            
                            <!-- Thumbnails -->
                            @if(count($product->images) > 1)
                                <div class="grid grid-cols-4 gap-2">
                                    @foreach($product->images as $index => $image)
                                        <button @click="currentImage = {{ $index }}"
                                                :class="currentImage === {{ $index }} ? 'ring-2 ring-blue-500' : 'ring-1 ring-gray-300'"
                                                class="rounded-lg overflow-hidden hover:ring-2 hover:ring-blue-400 transition">
                                            <img src="/storage/{{ $image }}" class="w-full h-20 object-cover">
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="bg-gray-100 rounded-lg flex items-center justify-center h-96">
                            <div class="text-center text-gray-400">
                                <svg class="mx-auto h-24 w-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="mt-2">No images</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Side - Product Info -->
                <div>
                    <div class="flex justify-between items-start mb-4">
                        <h1 class="text-3xl font-bold text-gray-800">{{ $product->title }}</h1>
                        <span class="px-3 py-1 text-sm font-semibold rounded-full
                            {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    <div class="mb-6">
                        <p class="text-sm text-gray-600 mb-1">Description</p>
                        <p class="text-gray-800 leading-relaxed">{{ $product->description }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-600 mb-2">Price</p>
                            @if($product->hasDiscount())
                                <div class="flex flex-col gap-1">
                                    <span class="text-lg line-through text-gray-400">
                                        ${{ number_format($product->price, 2) }}
                                    </span>
                                    <span class="text-2xl font-bold text-red-600">
                                        ${{ number_format($product->final_price, 2) }}
                                    </span>
                                    <span class="text-sm bg-red-100 text-red-800 px-2 py-1 rounded font-bold inline-block w-fit">
                                        -{{ $product->discount_percentage }}%
                                    </span>
                                </div>
                            @else
                                <p class="text-2xl font-bold text-gray-800">
                                    ${{ number_format($product->price, 2) }}
                                </p>
                            @endif
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-600 mb-2">Stock</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $product->stock }}</p>
                            <p class="text-sm text-gray-500">units available</p>
                        </div>
                    </div>

                    @if($product->dimensions)
                        <div class="bg-blue-50 rounded-lg p-4 mb-6">
                            <p class="text-sm text-gray-600 mb-2">Dimensions (W × H × L)</p>
                            <p class="text-xl font-semibold text-gray-800">{{ $product->dimensions }}</p>
                        </div>
                    @endif

                    @if($product->categories->count() > 0)
                        <div class="mb-6">
                            <p class="text-sm text-gray-600 mb-2">Categories</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($product->categories as $category)
                                    <span class="px-3 py-1 bg-purple-100 text-purple-800 text-sm rounded-full">
                                        {{ $category->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($product->colors->count() > 0)
                        <div class="mb-6">
                            <p class="text-sm text-gray-600 mb-2">Available Colors</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($product->colors as $color)
                                    <div class="flex items-center gap-2 px-3 py-1 bg-gray-100 rounded-full">
                                        <div class="w-5 h-5 rounded-full border-2 border-gray-300" 
                                             style="background-color: {{ $color->hex_code }}"></div>
                                        <span class="text-sm text-gray-700">{{ $color->name }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="border-t pt-4 mt-6">
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-600">Product ID</p>
                                <p class="text-gray-800 font-medium">#{{ $product->id }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Slug</p>
                                <p class="text-gray-800 font-medium break-all">{{ $product->slug }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Created</p>
                                <p class="text-gray-800 font-medium">{{ $product->created_at->format('M d, Y H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Last Updated</p>
                                <p class="text-gray-800 font-medium">{{ $product->updated_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>