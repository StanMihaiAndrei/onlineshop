<x-app-layout>
    <div class="container mx-auto px-4 py-6 max-w-2xl">
        <div class="mb-6">
            <a href="{{ route('admin.colors.index') }}" class="text-blue-600 hover:text-blue-800">
                Înapoi la Culori
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Editează Culoare</h2>

            <form action="{{ route('admin.colors.update', $color) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nume Culoare *</label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name', $color->name) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="hex_code" class="block text-sm font-medium text-gray-700 mb-2">Cod Hex *</label>
                    <div class="flex gap-2">
                        <input type="color" 
                               id="color_picker" 
                               value="{{ old('hex_code', $color->hex_code) }}"
                               class="h-10 w-20 border border-gray-300 rounded cursor-pointer">
                        <input type="text" 
                               name="hex_code" 
                               id="hex_code" 
                               value="{{ old('hex_code', $color->hex_code) }}"
                               maxlength="7"
                               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               required>
                    </div>
                    @error('hex_code')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="is_active" 
                               value="1"
                               {{ old('is_active', $color->is_active) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Activ</span>
                    </label>
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('admin.colors.index') }}" 
                       class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        Anulează
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Actualizează Culoare
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const colorPicker = document.getElementById('color_picker');
        const hexInput = document.getElementById('hex_code');

        colorPicker.addEventListener('input', (e) => {
            hexInput.value = e.target.value.toUpperCase();
        });

        hexInput.addEventListener('input', (e) => {
            const value = e.target.value;
            if (/^#[0-9A-F]{6}$/i.test(value)) {
                colorPicker.value = value;
            }
        });
    </script>
</x-app-layout>