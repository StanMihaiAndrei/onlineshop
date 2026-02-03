<x-app-layout>
    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4">
            <div class="mb-6">
                <a href="{{ route('admin.coupons.index') }}" class="text-blue-600 hover:text-blue-800">
                    Înapoi la Cupoane
                </a>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <h1 class="text-2xl font-bold text-gray-900 mb-6">Creează Cupon</h1>

                <form action="{{ route('admin.coupons.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="code" class="block text-sm font-medium text-gray-700 mb-1">Cod Cupon *</label>
                        <input type="text" name="code" id="code" value="{{ old('code') }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 uppercase @error('code') border-red-500 @enderror"
                               placeholder="SUMMER2025">
                        @error('code')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Tip Discount *</label>
                            <select name="type" id="type" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('type') border-red-500 @enderror">
                                <option value="percentage" {{ old('type') === 'percentage' ? 'selected' : '' }}>Procent (%)</option>
                                <option value="fixed" {{ old('type') === 'fixed' ? 'selected' : '' }}>Sumă Fixă (RON)</option>
                            </select>
                            @error('type')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="value" class="block text-sm font-medium text-gray-700 mb-1">Valoare *</label>
                            <input type="number" name="value" id="value" value="{{ old('value') }}" step="0.01" min="0" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('value') border-red-500 @enderror"
                                   placeholder="10 or 50">
                            @error('value')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="valid_from" class="block text-sm font-medium text-gray-700 mb-1">Valabil De La</label>
                            <input type="datetime-local" name="valid_from" id="valid_from" value="{{ old('valid_from') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('valid_from') border-red-500 @enderror"
                                   style="color-scheme: light;">
                            @error('valid_from')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="valid_until" class="block text-sm font-medium text-gray-700 mb-1">Valabil Până La</label>
                            <input type="datetime-local" name="valid_until" id="valid_until" value="{{ old('valid_until') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('valid_until') border-red-500 @enderror"
                                   style="color-scheme: light;">
                            @error('valid_until')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="usage_limit" class="block text-sm font-medium text-gray-700 mb-1">Limită Utilizare</label>
                            <input type="number" name="usage_limit" id="usage_limit" value="{{ old('usage_limit') }}" min="1"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('usage_limit') border-red-500 @enderror"
                                   placeholder="Lasa gol pentru nelimitat">
                            @error('usage_limit')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="minimum_order_amount" class="block text-sm font-medium text-gray-700 mb-1">Sumă Minimă Comandă (RON)</label>
                            <input type="number" name="minimum_order_amount" id="minimum_order_amount" value="{{ old('minimum_order_amount') }}" step="0.01" min="0"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('minimum_order_amount') border-red-500 @enderror"
                                   placeholder="0.00">
                            @error('minimum_order_amount')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600 rounded">
                            <span class="ml-2 text-sm text-gray-700">Activ (utilizatorii pot folosi acest cupon)</span>
                        </label>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 pt-4">
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition">
                            Creează Cupon
                        </button>
                        <a href="{{ route('admin.coupons.index') }}" 
                           class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded-lg font-medium transition text-center">
                            Anulează
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>