<x-app-layout>
    <div class="container mx-auto px-4 py-6 max-w-2xl">
        <div class="mb-6">
            <a href="{{ route('admin.categories.index') }}" class="text-blue-600 hover:text-blue-800">
                Inapoi la Categorii
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Editează Categoria</h2>

            <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                @csrf
                @method('PUT')

                @if($category->isParent())
                    <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <p class="text-sm text-blue-800">
                            <strong>Categoria Principală</strong> - Aceasta este o categorie părinte
                            @if($category->allChildren->count() > 0)
                                cu {{ $category->allChildren->count() }} subcategorie(i)
                            @endif
                        </p>
                    </div>
                @else
                    <div class="mb-4">
                        <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-2">Categorie Părinte</label>
                        <select name="parent_id" 
                                id="parent_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Niciuna - Creează o categorie principală</option>
                            @foreach($parentCategories as $parent)
                                <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                                    {{ $parent->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('parent_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                @endif

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nume Categorie *</label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name', $category->name) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Slug</label>
                    <input type="text" 
                           value="{{ $category->slug }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50"
                           disabled>
                    <p class="text-xs text-gray-500 mt-1">Slug este generat automat din nume</p>
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Descriere</label>
                    <textarea name="description" 
                              id="description" 
                              rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('description', $category->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="is_active" 
                               value="1"
                               {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Activ</span>
                    </label>
                </div>

                @if($category->products_count > 0)
                    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <p class="text-sm text-blue-800">
                            <strong>Notă:</strong> Această categorie este atribuită la {{ $category->products_count }} produs(e).
                        </p>
                    </div>
                @endif

                <div class="flex flex-col sm:flex-row justify-center gap-3 sm:space-x-4">
                    <a href="{{ route('admin.categories.index') }}" 
                       class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 text-center">
                        Anulează
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Actualizează
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>