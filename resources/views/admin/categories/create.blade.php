<x-app-layout>
    <div class="container mx-auto px-4 py-6 max-w-2xl">
        <div class="mb-6">
            <a href="{{ route('admin.categories.index') }}" class="text-blue-600 hover:text-blue-800">
               Inapoi la Categorii
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Creează Categorie</h2>

            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-2">Categorie Părinte (Opțional)</label>
                    <select name="parent_id" 
                            id="parent_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Niciuna - Creează o categorie principală</option>
                        @foreach($parentCategories as $parent)
                            <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('parent_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Lasă necompletat pentru a crea o categorie principală sau selectează un părinte pentru a crea o subcategorie</p>
                </div>

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nume Categorie *</label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name') }}"
                           placeholder="e.g., Bebelusi, Animale"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Slug-ul va fi generat automat din nume</p>
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Descriere</label>
                    <textarea name="description" 
                              id="description" 
                              rows="4"
                              placeholder="Descriere opțională pentru această categorie"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col sm:flex-row justify-center gap-3 sm:space-x-4">
                    <a href="{{ route('admin.categories.index') }}" 
                       class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 text-center">
                        Anulează
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Creează
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>