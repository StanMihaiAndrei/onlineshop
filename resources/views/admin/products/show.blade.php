<x-app-layout>
    <div class="container mx-auto px-4 py-6 max-w-4xl">
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
            <a href="{{ route('admin.products.index') }}" class="text-blue-600 hover:text-blue-800">
                ← Back to Products
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
            @if($product->images && count($product->images) > 0)
                <div class="relative" x-data="{ currentImage: 0 }">
                    <div class="aspect-w-16 aspect-h-9 bg-gray-100">
                        <template x-for="(image, index) in {{ json_encode($product->images) }}" :key="index">
                            <img :src="`/storage/${image}`" 
                                 x-show="currentImage === index"
                                 class="w-full h-64 md:h-96 object-contain">
                        </template>
                    </div>
                    
                    @if(count($product->images) > 1)
                        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                            @foreach($product->images as $index => $image)
                                <button @click="currentImage = {{ $index }}"
                                        :class="currentImage === {{ $index }} ? 'bg-white' : 'bg-gray-400'"
                                        class="w-3 h-3 rounded-full transition"></button>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif

            <div class="p-4 md:p-6">
                <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-3 mb-4">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800">{{ $product->title }}</h1>
                    <span class="px-3 py-1 text-sm font-semibold rounded-full w-fit
                        {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $product->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-4 md:gap-6 mb-6">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Price</p>
                        <p class="text-xl md:text-2xl font-bold text-gray-800">${{ number_format($product->price, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Stock</p>
                        <p class="text-xl md:text-2xl font-bold text-gray-800">{{ $product->stock }} units</p>
                    </div>
                </div>

                <div class="mb-6">
                    <p class="text-sm text-gray-600 mb-2">Description</p>
                    <p class="text-gray-800 leading-relaxed">{{ $product->description }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-600">Slug</p>
                        <p class="text-gray-800 font-medium break-all">{{ $product->slug }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Created</p>
                        <p class="text-gray-800 font-medium">{{ $product->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>