<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Checkout</h1>

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if(!auth()->check())
                <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded mb-6">
                    <p class="font-medium">Already have an account?</p>
                    <p class="text-sm">
                        <a href="{{ route('login') }}" class="underline hover:text-blue-900">Login</a> to checkout faster or 
                        <a href="{{ route('register') }}" class="underline hover:text-blue-900">Create an account</a> to track your orders.
                    </p>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Checkout Form -->
                <div class="lg:col-span-2">
                    <form action="{{ route('checkout.store') }}" method="POST" class="bg-white rounded-lg shadow-md p-6">
                        @csrf

                        <!-- Shipping Information -->
                        <div class="mb-8">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Shipping Information</h2>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="shipping_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                                    <input type="text" name="shipping_name" id="shipping_name" 
                                           value="{{ old('shipping_name', auth()->check() ? auth()->user()->name : '') }}" required
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('shipping_name') border-red-500 @enderror">
                                    @error('shipping_name')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="shipping_email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                                    <input type="email" name="shipping_email" id="shipping_email" 
                                           value="{{ old('shipping_email', auth()->check() ? auth()->user()->email : '') }}" required
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('shipping_email') border-red-500 @enderror">
                                    @error('shipping_email')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="shipping_phone" class="block text-sm font-medium text-gray-700 mb-1">Phone *</label>
                                    <input type="tel" name="shipping_phone" id="shipping_phone" value="{{ old('shipping_phone') }}" required
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('shipping_phone') border-red-500 @enderror">
                                    @error('shipping_phone')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="shipping_country" class="block text-sm font-medium text-gray-700 mb-1">Country *</label>
                                    <input type="text" name="shipping_country" id="shipping_country" value="{{ old('shipping_country', 'Romania') }}" required
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('shipping_country') border-red-500 @enderror">
                                    @error('shipping_country')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-1">Address *</label>
                                    <input type="text" name="shipping_address" id="shipping_address" value="{{ old('shipping_address') }}" required
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('shipping_address') border-red-500 @enderror">
                                    @error('shipping_address')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="shipping_city" class="block text-sm font-medium text-gray-700 mb-1">City *</label>
                                    <input type="text" name="shipping_city" id="shipping_city" value="{{ old('shipping_city') }}" required
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('shipping_city') border-red-500 @enderror">
                                    @error('shipping_city')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="shipping_postal_code" class="block text-sm font-medium text-gray-700 mb-1">Postal Code *</label>
                                    <input type="text" name="shipping_postal_code" id="shipping_postal_code" value="{{ old('shipping_postal_code') }}" required
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('shipping_postal_code') border-red-500 @enderror">
                                    @error('shipping_postal_code')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="mb-8">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Payment Method</h2>
                            
                            <div class="space-y-3">
                                <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                                    <input type="radio" name="payment_method" value="cash_on_delivery" checked class="w-4 h-4 text-blue-600">
                                    <div class="ml-3">
                                        <span class="text-gray-900 font-medium">Cash on Delivery</span>
                                        <p class="text-xs text-gray-500 mt-1">Pay when you receive your order</p>
                                    </div>
                                </label>

                                <label class="flex items-center p-4 border-2 border-blue-500 rounded-lg cursor-pointer hover:bg-blue-50 transition bg-gradient-to-r from-blue-50 to-indigo-50">
                                    <input type="radio" name="payment_method" value="card" class="w-4 h-4 text-blue-600">
                                    <div class="ml-3 flex-1">
                                        <div class="flex items-center justify-between">
                                            <span class="text-gray-900 font-medium">Credit/Debit Card</span>
                                            <div class="flex gap-1">
                                                <svg class="w-8 h-5" viewBox="0 0 32 20" fill="none">
                                                    <rect width="32" height="20" rx="2" fill="#1434CB"/>
                                                    <circle cx="12" cy="10" r="6" fill="#EB001B"/>
                                                    <circle cx="20" cy="10" r="6" fill="#FF5F00"/>
                                                </svg>
                                                <svg class="w-8 h-5" viewBox="0 0 32 20" fill="none">
                                                    <rect width="32" height="20" rx="2" fill="#0165AC"/>
                                                    <path d="M18 4h8v12h-8z" fill="#FFA500"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <p class="text-xs text-gray-600 mt-1">🔒 Secure payment powered by Stripe</p>
                                    </div>
                                </label>
                            </div>
                            @error('payment_method')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Order Notes -->
                        <div class="mb-8">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Order Notes (Optional)</label>
                            <textarea name="notes" id="notes" rows="3" 
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                      placeholder="Any special instructions for your order...">{{ old('notes') }}</textarea>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 px-6 rounded-lg transition shadow-lg hover:shadow-xl">
                            Place Order
                        </button>
                    </form>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Order Summary</h2>
                        
                        <div class="space-y-4 mb-6">
                            @foreach($cartItems as $item)
                                <div class="flex gap-3">
                                    <a href="{{ route('shop.product', [$item['category_slug'] ?? 'uncategorized', $item['slug']]) }}" class="flex-shrink-0">
                                        @if($item['image'])
                                            <img src="{{ asset('storage/' . $item['image']) }}" 
                                                 alt="{{ $item['title'] }}"
                                                 class="w-16 h-16 object-cover rounded">
                                        @else
                                            <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                                <span class="text-gray-400 text-xs">No image</span>
                                            </div>
                                        @endif
                                    </a>
                                    
                                    <div class="flex-1">
                                        <a href="{{ route('shop.product', [$item['category_slug'] ?? 'uncategorized', $item['slug']]) }}" 
                                           class="text-sm font-medium text-gray-900 hover:text-blue-600 line-clamp-2">
                                            {{ $item['title'] }}
                                        </a>
                                        <p class="text-sm text-gray-600">Qty: {{ $item['quantity'] }}</p>
                                        <p class="text-sm font-semibold text-gray-900">${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Coupon Section -->
                        <div class="border-t border-gray-200 pt-4 pb-4">
                            @if(isset($coupon) && $coupon)
                                <div class="bg-green-50 border border-green-200 rounded-lg p-3 mb-3">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="text-sm font-semibold text-green-800">
                                            🎉 Coupon Applied: {{ $coupon->code }}
                                        </span>
                                        <form action="{{ route('checkout.removeCoupon') }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs text-red-600 hover:text-red-800">Remove</button>
                                        </form>
                                    </div>
                                    <p class="text-xs text-green-700">
                                        You save ${{ number_format($discountAmount, 2) }}
                                        @if($coupon->type === 'percentage')
                                            ({{ $coupon->value }}% off)
                                        @endif
                                    </p>
                                </div>
                            @else
                                <form action="{{ route('checkout.applyCoupon') }}" method="POST" class="mb-3">
                                    @csrf
                                    <label for="coupon_code" class="block text-sm font-medium text-gray-700 mb-2">Have a coupon?</label>
                                    <div class="flex gap-2">
                                        <input type="text" name="coupon_code" id="coupon_code" 
                                               class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm uppercase"
                                               placeholder="Enter code">
                                        <button type="submit" 
                                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                                            Apply
                                        </button>
                                    </div>
                                </form>
                            @endif
                        </div>

                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-medium">${{ number_format($cartTotal, 2) }}</span>
                            </div>
                            
                            @if(isset($discountAmount) && $discountAmount > 0)
                                <div class="flex justify-between items-center mb-2 text-green-600">
                                    <span>Discount</span>
                                    <span class="font-medium">-${{ number_format($discountAmount, 2) }}</span>
                                </div>
                            @endif

                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-600">Shipping</span>
                                <span class="font-medium text-green-600">FREE</span>
                            </div>
                            <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                                <span class="text-lg font-semibold">Total</span>
                                <div class="text-right">
                                    @if(isset($discountAmount) && $discountAmount > 0)
                                        <div class="text-sm text-gray-500 line-through">${{ number_format($cartTotal, 2) }}</div>
                                    @endif
                                    <span class="text-2xl font-bold text-blue-600">${{ number_format($finalTotal ?? $cartTotal, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>