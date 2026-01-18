<x-app-layout>
    <div class="container mx-auto px-4 py-6 max-w-6xl">
        <!-- Mobile Navigation -->
        <div class="mb-6 space-y-3 md:hidden">
            <a href="{{ route('admin.products.index') }}" 
               class="flex items-center justify-center w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Inapoi la Produse
            </a>
            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('admin.products.edit', $product) }}" 
                   class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-center transition">
                    Editează Produs
                </a>
                <form id="delete-form-mobile-show" 
                      action="{{ route('admin.products.destroy', $product) }}" 
                      method="POST"
                      x-data
                      @confirm-delete.window="if ($event.detail === 'product-show-mobile') $el.submit()">
                    @csrf
                    @method('DELETE')
                    <button type="button" 
                            @click="$dispatch('open-modal', 'product-show-mobile')"
                            class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                        Șterge
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
                Înapoi la Produse
            </a>
            <div class="space-x-2">
                <a href="{{ route('admin.products.edit', $product) }}" 
                   class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Editează Produs
                </a>
                <form id="delete-form-desktop-show" 
                      action="{{ route('admin.products.destroy', $product) }}" 
                      method="POST" 
                      class="inline"
                      x-data
                      @confirm-delete.window="if ($event.detail === 'product-show-desktop') $el.submit()">
                    @csrf
                    @method('DELETE')
                    <button type="button" 
                            @click="$dispatch('open-modal', 'product-show-desktop')"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                        Șterge
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
                                         alt="{{ $product->title }}"
                                         x-show="currentImage === index"
                                         class="w-full h-96 object-contain">
                                </template>
                            </div>
                            
                            <!-- Thumbnails -->
                            @if(count($product->images) > 1)
                                <div class="grid grid-cols-4 gap-2">
                                    @foreach($product->images as $index => $image)
                                        <button @click="currentImage = {{ $index }}" 
                                                :class="currentImage === {{ $index }} ? 'ring-2 ring-blue-500' : ''"
                                                class="bg-gray-100 rounded-lg overflow-hidden hover:opacity-75 transition">
                                            <img src="{{ asset('storage/' . $image) }}" 
                                                 alt="{{ $product->title }}" 
                                                 class="w-full h-20 object-cover">
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
                                <p class="mt-2">Fara imagine</p>
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
                        <p class="text-sm text-gray-600 mb-1">Descriere</p>
                        <p class="text-gray-800 leading-relaxed">{{ $product->description }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-600 mb-2">Preț</p>
                            @if($product->hasDiscount())
                                <div class="flex flex-col gap-1">
                                    <span class="text-lg line-through text-gray-400">
                                        ${{ number_format($product->price, 2) }}
                                    </span>
                                    <span class="text-2xl font-bold text-red-600">
                                        ${{ number_format($product->discount_price, 2) }}
                                    </span>
                                    <span class="text-xs text-red-600">
                                        Economisește {{ number_format((($product->price - $product->discount_price) / $product->price) * 100) }}%
                                    </span>
                                </div>
                            @else
                                <p class="text-2xl font-bold text-gray-800">
                                    ${{ number_format($product->price, 2) }}
                                </p>
                            @endif
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-600 mb-2">Stoc</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $product->stock }}</p>
                            <p class="text-sm text-gray-500">unități disponibile</p>
                        </div>
                    </div>

                    @if($product->dimensions)
                        <div class="bg-blue-50 rounded-lg p-4 mb-6">
                            <p class="text-sm text-gray-600 mb-2">Dimensiuni (L × Î × A)</p>
                            <p class="text-xl font-semibold text-gray-800">{{ $product->dimensions }}</p>
                        </div>
                    @endif

                    @if($product->categories->count() > 0)
                        <div class="mb-6">
                            <p class="text-sm text-gray-600 mb-2">Categorii</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($product->categories as $category)
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                                        {{ $category->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($product->colors->count() > 0)
                        <div class="mb-6">
                            <p class="text-sm text-gray-600 mb-2">Culori Disponibile</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($product->colors as $color)
                                    <div class="flex items-center gap-2 px-3 py-1 bg-gray-100 rounded-full">
                                        <div class="w-4 h-4 rounded-full border border-gray-300" 
                                             style="background-color: {{ $color->hex_code }}"></div>
                                        <span class="text-sm">{{ $color->name }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="border-t pt-4 mt-6">
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-600">ID Produs</p>
                                <p class="text-gray-800 font-medium">#{{ $product->id }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Slug</p>
                                <p class="text-gray-800 font-medium break-all">{{ $product->slug }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Creat</p>
                                <p class="text-gray-800 font-medium">{{ $product->created_at->format('M d, Y H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Ultima Actualizare</p>
                                <p class="text-gray-800 font-medium">{{ $product->updated_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modals -->
    <x-delete-confirmation-modal 
        modalId="product-show-mobile"
        title="Șterge Produs"
        message="Ești sigur că vrei să ștergi '{{ $product->title }}'? Această acțiune nu poate fi anulată." />
    
    <x-delete-confirmation-modal 
        modalId="product-show-desktop"
        title="Șterge Produs"
        message="Ești sigur că vrei să ștergi '{{ $product->title }}'? Această acțiune nu poate fi anulată." />
</x-app-layout>