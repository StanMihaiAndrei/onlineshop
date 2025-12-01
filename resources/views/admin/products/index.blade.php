<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Products</h2>
            <a href="{{ route('admin.products.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition text-center">
                + Add New Product
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Desktop Table View -->
        <div class="hidden md:block bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($products as $product)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($product->first_image)
                                    <img src="{{ asset('storage/' . $product->first_image) }}" 
                                         alt="{{ $product->title }}" 
                                         class="h-12 w-12 object-cover rounded">
                                @else
                                    <div class="h-12 w-12 bg-gray-200 rounded flex items-center justify-center">
                                        <span class="text-gray-400 text-xs">No image</span>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $product->title }}</div>
                                <div class="text-sm text-gray-500">{{ Str::limit($product->description, 50) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($product->hasDiscount())
                                    <div class="flex flex-col">
                                        <span class="text-xs line-through text-gray-400">
                                            ${{ number_format($product->price, 2) }}
                                        </span>
                                        <span class="text-sm font-bold text-red-600">
                                            ${{ number_format($product->final_price, 2) }}
                                        </span>
                                        <span class="text-xs bg-red-100 text-red-800 px-1.5 py-0.5 rounded font-bold inline-block w-fit mt-1">
                                            -{{ $product->discount_percentage }}%
                                        </span>
                                    </div>
                                @else
                                    <span class="text-sm text-gray-900">
                                        ${{ number_format($product->price, 2) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $product->stock }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $product->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.products.show', $product) }}" 
                                   class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                <a href="{{ route('admin.products.edit', $product) }}" 
                                   class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                <form action="{{ route('admin.products.destroy', $product) }}" 
                                      method="POST" 
                                      class="inline"
                                      onsubmit="return confirm('Are you sure you want to delete this product?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                No products found. <a href="{{ route('admin.products.create') }}" class="text-blue-600">Add your first product</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View -->
        <div class="md:hidden space-y-4">
            @forelse($products as $product)
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="p-4">
                        <div class="flex gap-4 mb-3">
                            @if($product->first_image)
                                <img src="{{ asset('storage/' . $product->first_image) }}" 
                                     alt="{{ $product->title }}" 
                                     class="h-20 w-20 object-cover rounded flex-shrink-0">
                            @else
                                <div class="h-20 w-20 bg-gray-200 rounded flex items-center justify-center flex-shrink-0">
                                    <span class="text-gray-400 text-xs">No image</span>
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <h3 class="text-sm font-semibold text-gray-900 mb-1">{{ $product->title }}</h3>
                                <p class="text-xs text-gray-500 line-clamp-2">{{ $product->description }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3 mb-3">
                            <div>
                                <p class="text-xs text-gray-500">Price</p>
                                @if($product->hasDiscount())
                                    <div class="flex flex-col">
                                        <span class="text-xs line-through text-gray-400">
                                            ${{ number_format($product->price, 2) }}
                                        </span>
                                        <span class="text-sm font-bold text-red-600">
                                            ${{ number_format($product->final_price, 2) }}
                                        </span>
                                        <span class="text-xs bg-red-100 text-red-800 px-1.5 py-0.5 rounded font-bold inline-block w-fit mt-0.5">
                                            -{{ $product->discount_percentage }}%
                                        </span>
                                    </div>
                                @else
                                    <p class="text-sm font-semibold text-gray-900">
                                        ${{ number_format($product->price, 2) }}
                                    </p>
                                @endif
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Stock</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $product->stock }}</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('admin.products.show', $product) }}" 
                               class="flex-1 text-center px-3 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition">
                                View
                            </a>
                            <a href="{{ route('admin.products.edit', $product) }}" 
                               class="flex-1 text-center px-3 py-2 bg-indigo-600 text-white text-sm rounded-lg hover:bg-indigo-700 transition">
                                Edit
                            </a>
                            <form action="{{ route('admin.products.destroy', $product) }}" 
                                  method="POST" 
                                  class="flex-1"
                                  onsubmit="return confirm('Are you sure you want to delete this product?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full px-3 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <p class="text-gray-500">
                        No products found. <a href="{{ route('admin.products.create') }}" class="text-blue-600">Add your first product</a>
                    </p>
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $products->links() }}
        </div>
    </div>
</x-app-layout>