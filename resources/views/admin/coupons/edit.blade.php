<x-app-layout>
    <div class="py-6">
        <div class="max-w-3xl mx-auto">
            <div class="mb-6">
                <a href="{{ route('admin.coupons.index') }}" class="text-blue-600 hover:text-blue-800">
                    ← Back to Coupons
                </a>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <h1 class="text-2xl font-bold text-gray-900 mb-6">Edit Coupon</h1>

                <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="code" class="block text-sm font-medium text-gray-700 mb-1">Coupon Code *</label>
                        <input type="text" name="code" id="code" value="{{ old('code', $coupon->code) }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 uppercase @error('code') border-red-500 @enderror">
                        @error('code')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Discount Type *</label>
                            <select name="type" id="type" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('type') border-red-500 @enderror">
                                <option value="percentage" {{ old('type', $coupon->type) === 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                                <option value="fixed" {{ old('type', $coupon->type) === 'fixed' ? 'selected' : '' }}>Fixed Amount (RON)</option>
                            </select>
                            @error('type')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="value" class="block text-sm font-medium text-gray-700 mb-1">Value *</label>
                            <input type="number" name="value" id="value" value="{{ old('value', $coupon->value) }}" step="0.01" min="0" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('value') border-red-500 @enderror">
                            @error('value')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="valid_from" class="block text-sm font-medium text-gray-700 mb-1">Valid From</label>
                            <input type="datetime-local" name="valid_from" id="valid_from" 
                                   value="{{ old('valid_from', $coupon->valid_from?->format('Y-m-d\TH:i')) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('valid_from') border-red-500 @enderror">
                            @error('valid_from')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="valid_until" class="block text-sm font-medium text-gray-700 mb-1">Valid Until</label>
                            <input type="datetime-local" name="valid_until" id="valid_until" 
                                   value="{{ old('valid_until', $coupon->valid_until?->format('Y-m-d\TH:i')) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('valid_until') border-red-500 @enderror">
                            @error('valid_until')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="usage_limit" class="block text-sm font-medium text-gray-700 mb-1">Usage Limit</label>
                            <input type="number" name="usage_limit" id="usage_limit" value="{{ old('usage_limit', $coupon->usage_limit) }}" min="1"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('usage_limit') border-red-500 @enderror">
                            @error('usage_limit')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">Currently used: {{ $coupon->usage_count }} times</p>
                        </div>

                        <div>
                            <label for="minimum_order_amount" class="block text-sm font-medium text-gray-700 mb-1">Minimum Order Amount (RON)</label>
                            <input type="number" name="minimum_order_amount" id="minimum_order_amount" 
                                   value="{{ old('minimum_order_amount', $coupon->minimum_order_amount) }}" step="0.01" min="0"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('minimum_order_amount') border-red-500 @enderror">
                            @error('minimum_order_amount')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $coupon->is_active) ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600 rounded">
                            <span class="ml-2 text-sm text-gray-700">Active (users can use this coupon)</span>
                        </label>
                    </div>

                    <div class="flex gap-4 pt-4">
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition">
                            Update Coupon
                        </button>
                        <a href="{{ route('admin.coupons.index') }}" 
                           class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded-lg font-medium transition">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>