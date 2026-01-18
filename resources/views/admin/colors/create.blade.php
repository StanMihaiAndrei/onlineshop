{{-- filepath: resources/views/admin/colors/create.blade.php --}}
<x-app-layout>
    <div class="container mx-auto px-4 py-6 max-w-2xl">
        <div class="mb-6">
            <a href="{{ route('admin.colors.index') }}" class="text-blue-600 hover:text-blue-800">
                Inapoi la Culori
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Creează Culoare Nouă</h2>

            <form action="{{ route('admin.colors.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nume Culoare *</label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name') }}"
                           placeholder="e.g., Red, Blue, Green"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="hex_code" class="block text-sm font-medium text-gray-700 mb-2">Cod Hex *</label>
                    <div class="flex gap-2">
                        <input type="color" 
                               id="color_picker" 
                               value="{{ old('hex_code', '#000000') }}"
                               class="h-10 w-20 border border-gray-300 rounded cursor-pointer">
                        <input type="text" 
                               name="hex_code" 
                               id="hex_code" 
                               value="{{ old('hex_code', '#000000') }}"
                               placeholder="#FF5733"
                               maxlength="7"
                               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               required>
                    </div>
                    @error('hex_code')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('admin.colors.index') }}" 
                       class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        Anulează
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Creează Culoare
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