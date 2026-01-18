<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Categories & Subcategories</h2>
                <a href="{{ route('admin.categories.create') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-3 sm:px-6 py-2 rounded-lg transition text-sm sm:text-base">
                    <span class="hidden sm:inline">+ Add New Category</span>
                    <span class="sm:hidden">+ Add</span>
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- Desktop Table View -->
            <div class="hidden lg:block bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Slug</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Products</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($categories as $category)
                            {{-- Categoria principală --}}
                            <tr class="bg-blue-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                        </svg>
                                        <div>
                                            <div class="text-sm font-bold text-gray-900">{{ $category->name }}</div>
                                            @if($category->description)
                                                <div class="text-sm text-gray-500">{{ Str::limit($category->description, 50) }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $category->slug }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">
                                        {{ $category->products_count }} products
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.categories.edit', $category) }}" 
                                       class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                    <form id="delete-form-cat-{{ $category->id }}" 
                                          action="{{ route('admin.categories.destroy', $category) }}" 
                                          method="POST" 
                                          class="inline"
                                          x-data
                                          @confirm-delete.window="if ($event.detail === 'category-{{ $category->id }}') $el.submit()">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                @click="$dispatch('open-modal', 'category-{{ $category->id }}')"
                                                class="text-red-600 hover:text-red-900">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            {{-- Subcategoriile --}}
                            @foreach($category->allChildren as $subcategory)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center pl-8">
                                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ $subcategory->name }}</div>
                                                @if($subcategory->description)
                                                    <div class="text-sm text-gray-500">{{ Str::limit($subcategory->description, 50) }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $subcategory->slug }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs">
                                            {{ $subcategory->products_count }} products
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $subcategory->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $subcategory->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.categories.edit', $subcategory) }}" 
                                           class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                        <form id="delete-form-subcat-{{ $subcategory->id }}" 
                                              action="{{ route('admin.categories.destroy', $subcategory) }}" 
                                              method="POST" 
                                              class="inline"
                                              x-data
                                              @confirm-delete.window="if ($event.detail === 'subcategory-{{ $subcategory->id }}') $el.submit()">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" 
                                                    @click="$dispatch('open-modal', 'subcategory-{{ $subcategory->id }}')"
                                                    class="text-red-600 hover:text-red-900">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                    No categories found. <a href="{{ route('admin.categories.create') }}" class="text-blue-600">Add your first category</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="lg:hidden space-y-4">
                @forelse($categories as $category)
                    {{-- Categoria principală --}}
                    <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-4 shadow-sm">
                        <div class="flex items-start gap-3 mb-3">
                            <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                            </svg>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-gray-900 text-base">{{ $category->name }}</h3>
                                @if($category->description)
                                    <p class="text-xs text-gray-600 mt-1">{{ Str::limit($category->description, 60) }}</p>
                                @endif
                            </div>
                        </div>
                        
                        <div class="space-y-2 mb-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Slug:</span>
                                <span class="text-gray-900 font-mono text-xs truncate ml-2">{{ $category->slug }}</span>
                            </div>
                            <div class="flex justify-between text-sm items-center">
                                <span class="text-gray-600">Products:</span>
                                <span class="px-2 py-0.5 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">
                                    {{ $category->products_count }}
                                </span>
                            </div>
                            <div class="flex justify-between text-sm items-center">
                                <span class="text-gray-600">Status:</span>
                                <span class="px-2 py-0.5 text-xs rounded-full {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('admin.categories.edit', $category) }}" 
                               class="flex-1 text-center bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm">
                                Edit
                            </a>
                            <form id="delete-form-cat-mobile-{{ $category->id }}" 
                                  action="{{ route('admin.categories.destroy', $category) }}" 
                                  method="POST" 
                                  class="flex-1"
                                  x-data
                                  @confirm-delete.window="if ($event.detail === 'category-mobile-{{ $category->id }}') $el.submit()">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        @click="$dispatch('open-modal', 'category-mobile-{{ $category->id }}')"
                                        class="w-full bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-sm">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Subcategoriile pentru mobile --}}
                    @foreach($category->allChildren as $subcategory)
                        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm ml-4">
                            <div class="flex items-start gap-2 mb-3">
                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-gray-900 text-sm">{{ $subcategory->name }}</h4>
                                    @if($subcategory->description)
                                        <p class="text-xs text-gray-500 mt-1">{{ Str::limit($subcategory->description, 50) }}</p>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="space-y-2 mb-3">
                                <div class="flex justify-between text-xs">
                                    <span class="text-gray-500">Slug:</span>
                                    <span class="text-gray-900 font-mono truncate ml-2">{{ $subcategory->slug }}</span>
                                </div>
                                <div class="flex justify-between text-xs items-center">
                                    <span class="text-gray-500">Products:</span>
                                    <span class="px-2 py-0.5 bg-gray-100 text-gray-800 rounded-full">
                                        {{ $subcategory->products_count }}
                                    </span>
                                </div>
                                <div class="flex justify-between text-xs items-center">
                                    <span class="text-gray-500">Status:</span>
                                    <span class="px-2 py-0.5 rounded-full {{ $subcategory->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $subcategory->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex gap-2">
                                <a href="{{ route('admin.categories.edit', $subcategory) }}" 
                                   class="flex-1 text-center bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-1.5 px-3 rounded text-xs">
                                    Edit
                                </a>
                                <form id="delete-form-subcat-mobile-{{ $subcategory->id }}" 
                                      action="{{ route('admin.categories.destroy', $subcategory) }}" 
                                      method="POST" 
                                      class="flex-1"
                                      x-data
                                      @confirm-delete.window="if ($event.detail === 'subcategory-mobile-{{ $subcategory->id }}') $el.submit()">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                            @click="$dispatch('open-modal', 'subcategory-mobile-{{ $subcategory->id }}')"
                                            class="w-full bg-red-500 hover:bg-red-700 text-white font-bold py-1.5 px-3 rounded text-xs">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @empty
                    <div class="text-center py-8 text-gray-500 bg-white rounded-lg border border-gray-200">
                        No categories found. <a href="{{ route('admin.categories.create') }}" class="text-blue-600">Add your first category</a>
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $categories->links() }}
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modals -->
    @foreach($categories as $category)
        <x-delete-confirmation-modal 
            modalId="category-{{ $category->id }}"
            title="Delete Category"
            message="Are you sure you want to delete category '{{ $category->name }}'? This will also delete all its subcategories. This action cannot be undone." />
        
        <x-delete-confirmation-modal 
            modalId="category-mobile-{{ $category->id }}"
            title="Delete Category"
            message="Are you sure you want to delete category '{{ $category->name }}'? This will also delete all its subcategories. This action cannot be undone." />
        
        @foreach($category->allChildren as $subcategory)
            <x-delete-confirmation-modal 
                modalId="subcategory-{{ $subcategory->id }}"
                title="Delete Subcategory"
                message="Are you sure you want to delete subcategory '{{ $subcategory->name }}'? This action cannot be undone." />
            
            <x-delete-confirmation-modal 
                modalId="subcategory-mobile-{{ $subcategory->id }}"
                title="Delete Subcategory"
                message="Are you sure you want to delete subcategory '{{ $subcategory->name }}'? This action cannot be undone." />
        @endforeach
    @endforeach
</x-app-layout>