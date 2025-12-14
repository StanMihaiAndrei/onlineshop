<x-app-layout>
    <div class="container mx-auto px-4 py-6 max-w-4xl">
        <div class="mb-6">
            <a href="{{ route('admin.products.index') }}" class="text-blue-600 hover:text-blue-800">
                ← Back to Products
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Product</h2>

            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                    <input type="text" 
                           name="title" 
                           id="title" 
                           value="{{ old('title', $product->title) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           required>
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                    <textarea name="description" 
                              id="description" 
                              rows="5"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              required>{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Price ($) *</label>
                        <input type="number" 
                               name="price" 
                               id="price" 
                               value="{{ old('price', $product->price) }}"
                               step="0.01"
                               min="0"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               required>
                        @error('price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="discount_price" class="block text-sm font-medium text-gray-700 mb-2">
                            Discount Price ($)
                            <span class="text-xs text-gray-500">(Optional - 0 = no discount)</span>
                        </label>
                        <input type="number" 
                               name="discount_price" 
                               id="discount_price" 
                               value="{{ old('discount_price', $product->discount_price) }}"
                               step="0.01"
                               min="0"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('discount_price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        @if($product->hasDiscount())
                            <p class="text-green-600 text-sm mt-1">
                                Current discount: {{ $product->discount_percentage }}% off
                            </p>
                        @endif
                    </div>

                    <div>
                        <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">Stock *</label>
                        <input type="number" 
                               name="stock" 
                               id="stock" 
                               value="{{ old('stock', $product->stock) }}"
                               min="0"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               required>
                        @error('stock')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                    <!-- Dimensions -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label for="width" class="block text-sm font-medium text-gray-700 mb-2">
                            Width (cm)
                            <span class="text-xs text-gray-500">(Optional)</span>
                        </label>
                        <input type="number" 
                            name="width" 
                            id="width" 
                            value="{{ old('width', $product->width) }}"
                            step="0.01"
                            min="0"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('width')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="height" class="block text-sm font-medium text-gray-700 mb-2">
                            Height (cm)
                            <span class="text-xs text-gray-500">(Optional)</span>
                        </label>
                        <input type="number" 
                            name="height" 
                            id="height" 
                            value="{{ old('height', $product->height) }}"
                            step="0.01"
                            min="0"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('height')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="length" class="block text-sm font-medium text-gray-700 mb-2">
                            Length (cm)
                            <span class="text-xs text-gray-500">(Optional)</span>
                        </label>
                        <input type="number" 
                            name="length" 
                            id="length" 
                            value="{{ old('length', $product->length) }}"
                            step="0.01"
                            min="0"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('length')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Categories -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Categories</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 p-4 border border-gray-300 rounded-lg max-h-48 overflow-y-auto">
                        @forelse($categories as $category)
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       name="categories[]" 
                                       value="{{ $category->id }}"
                                       {{ in_array($category->id, old('categories', $product->categories->pluck('id')->toArray())) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">{{ $category->name }}</span>
                            </label>
                        @empty
                            <p class="text-sm text-gray-500 col-span-3">No categories available. <a href="{{ route('admin.categories.create') }}" class="text-blue-600">Create one</a></p>
                        @endforelse
                    </div>
                    @error('categories')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Colors -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Colors</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 p-4 border border-gray-300 rounded-lg max-h-48 overflow-y-auto">
                        @forelse($colors as $color)
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       name="colors[]" 
                                       value="{{ $color->id }}"
                                       {{ in_array($color->id, old('colors', $product->colors->pluck('id')->toArray())) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                                <div class="w-6 h-6 rounded-full ml-2 border-2 border-gray-300" 
                                     style="background-color: {{ $color->hex_code }}"></div>
                                <span class="ml-2 text-sm text-gray-700">{{ $color->name }}</span>
                            </label>
                        @empty
                            <p class="text-sm text-gray-500 col-span-4">No colors available. <a href="{{ route('admin.colors.create') }}" class="text-blue-600">Create one</a></p>
                        @endforelse
                    </div>
                    @error('colors')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="is_active" 
                               value="1"
                               {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Active (visible to customers)</span>
                    </label>
                </div>

                @if($product->images && count($product->images) > 0)
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Current Images 
                            <span class="text-xs text-gray-500">({{ count($product->images) }} image(s))</span>
                        </label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($product->images as $index => $image)
                                <div class="relative group">
                                    @if($index === 0)
                                        <span class="absolute top-0 left-0 bg-blue-600 text-white text-xs px-2 py-1 rounded-br">
                                            Main
                                        </span>
                                    @endif
                                    <img src="{{ asset('storage/' . $image) }}" 
                                         alt="Product image {{ $index + 1 }}" 
                                         class="h-32 w-full object-cover rounded border-2 {{ $index === 0 ? 'border-blue-500' : 'border-gray-200' }}">
                                    <button type="button"
                                            onclick="deleteImage({{ $product->id }}, {{ $index }})"
                                            class="absolute top-2 right-2 bg-red-600 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition shadow-lg hover:bg-red-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="mb-6" x-data="{ files: [] }">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Add New Images</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                        <input type="file" 
                               name="images[]" 
                               multiple 
                               accept="image/*"
                               @change="files = Array.from($event.target.files)"
                               class="hidden" 
                               id="images">
                        <label for="images" class="cursor-pointer">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <p class="mt-2 text-sm text-gray-600">Click to upload images</p>
                            <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF up to 2MB</p>
                        </label>
                        <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4" x-show="files.length > 0" style="display: none;">
                            <template x-for="(file, index) in files" :key="index">
                                <div class="relative">
                                    <img :src="URL.createObjectURL(file)" class="h-24 w-full object-cover rounded border-2 border-green-500">
                                    <p class="text-xs text-gray-600 mt-1 truncate" x-text="file.name"></p>
                                    <span class="absolute top-0 right-0 bg-green-600 text-white text-xs px-2 py-1 rounded-bl">New</span>
                                </div>
                            </template>
                        </div>
                    </div>
                    @error('images.*')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('admin.products.index') }}" 
                       class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Update Product
                    </button>
                </div>
            </form>
        </div>
    </div>

    <form id="delete-image-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
        <input type="hidden" name="image_index" id="delete-image-index">
    </form>

    <script>
        function deleteImage(productId, imageIndex) {
            if (confirm('Are you sure you want to delete this image?')) {
                const form = document.getElementById('delete-image-form');
                form.action = `/admin/products/${productId}/images`;
                document.getElementById('delete-image-index').value = imageIndex;
                form.submit();
            }
        }
    </script>
</x-app-layout>