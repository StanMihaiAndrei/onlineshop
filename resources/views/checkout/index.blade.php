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
                    <form action="{{ route('checkout.store') }}" method="POST" class="bg-white rounded-lg shadow-md p-6" id="checkoutForm">
                        @csrf

                        <!-- Tip Persoană -->
                        <div class="mb-8">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Tip Client</h2>
                            <div class="flex gap-4">
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="is_company" value="0" checked class="w-4 h-4 text-blue-600">
                                    <span class="ml-2 text-gray-700">Persoană Fizică</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="is_company" value="1" class="w-4 h-4 text-blue-600">
                                    <span class="ml-2 text-gray-700">Persoană Juridică</span>
                                </label>
                            </div>
                        </div>

                        <!-- Tip Livrare -->
                        <div class="mb-8">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Metodă Livrare</h2>
                            <div class="space-y-3">
                                <label class="flex items-start p-4 border-2 border-blue-500 rounded-lg cursor-pointer hover:bg-blue-50 transition">
                                    <input type="radio" name="delivery_type" value="home" checked class="w-4 h-4 text-blue-600 mt-1" id="delivery_home">
                                    <div class="ml-3">
                                        <span class="text-gray-900 font-medium">🏠 Livrare la Domiciliu</span>
                                        <p class="text-xs text-gray-500 mt-1">Curier Sameday - Livrare în 24-48h</p>
                                    </div>
                                </label>

                                <label class="flex items-start p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                                    <input type="radio" name="delivery_type" value="locker" class="w-4 h-4 text-blue-600 mt-1" id="delivery_locker">
                                    <div class="ml-3">
                                        <span class="text-gray-900 font-medium">📦 Ridicare de la Easybox</span>
                                        <p class="text-xs text-gray-500 mt-1">Livrare în locker - disponibil 24/7</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Shipping Information -->
                        <div class="mb-8">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Informații Livrare</h2>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="shipping_name" class="block text-sm font-medium text-gray-700 mb-1">Nume Complet *</label>
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
                                    <label for="shipping_phone" class="block text-sm font-medium text-gray-700 mb-1">Telefon *</label>
                                    <input type="tel" name="shipping_phone" id="shipping_phone" value="{{ old('shipping_phone') }}" required
                                           placeholder="07xxxxxxxx"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('shipping_phone') border-red-500 @enderror">
                                    @error('shipping_phone')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="shipping_country" class="block text-sm font-medium text-gray-700 mb-1">Țară *</label>
                                    <input type="text" name="shipping_country" id="shipping_country" value="{{ old('shipping_country', 'Romania') }}" required readonly
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50">
                                </div>

                                <!-- Județ -->
                                <div>
                                    <label for="sameday_county" class="block text-sm font-medium text-gray-700 mb-1">Județ *</label>
                                    <select name="sameday_county_id" id="sameday_county" required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('sameday_county_id') border-red-500 @enderror">
                                        <option value="">Selectează județ...</option>
                                    </select>
                                    @error('sameday_county_id')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Oraș -->
                                <div>
                                    <label for="sameday_city" class="block text-sm font-medium text-gray-700 mb-1">Oraș *</label>
                                    <select name="sameday_city_id" id="sameday_city" required disabled
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('sameday_city_id') border-red-500 @enderror">
                                        <option value="">Selectează oraș...</option>
                                    </select>
                                    @error('sameday_city_id')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Adresă - doar pentru livrare la domiciliu -->
                                <div class="md:col-span-2" id="address_field">
                                    <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-1">Adresă Completă *</label>
                                    <input type="text" name="shipping_address" id="shipping_address" value="{{ old('shipping_address') }}"
                                           placeholder="Str. Exemplu, Nr. 10, Bl. A, Sc. B, Ap. 5"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('shipping_address') border-red-500 @enderror">
                                    @error('shipping_address')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Easybox - doar pentru livrare la locker -->
                                <div class="md:col-span-2 hidden" id="locker_field">
                                    <label for="sameday_locker" class="block text-sm font-medium text-gray-700 mb-1">Easybox *</label>
                                    <select name="sameday_locker_id" id="sameday_locker" disabled
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <option value="">Selectează locker...</option>
                                    </select>
                                    <input type="hidden" name="sameday_locker_name" id="sameday_locker_name">
                                    @error('sameday_locker_id')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Oraș pentru formular standard -->
                                <div>
                                    <label for="shipping_city" class="block text-sm font-medium text-gray-700 mb-1">Oraș (text) *</label>
                                    <input type="text" name="shipping_city" id="shipping_city" value="{{ old('shipping_city') }}" required readonly
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50">
                                    <p class="text-xs text-gray-500 mt-1">Se completează automat</p>
                                </div>

                                <div>
                                    <label for="shipping_postal_code" class="block text-sm font-medium text-gray-700 mb-1">Cod Poștal</label>
                                    <input type="text" name="shipping_postal_code" id="shipping_postal_code" value="{{ old('shipping_postal_code') }}"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="mb-8">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Metodă de Plată</h2>
                            
                            <div class="space-y-3">
                                <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                                    <input type="radio" name="payment_method" value="cash_on_delivery" checked class="w-4 h-4 text-blue-600">
                                    <div class="ml-3">
                                        <span class="text-gray-900 font-medium">💵 Ramburs (Cash on Delivery)</span>
                                        <p class="text-xs text-gray-500 mt-1">Plătești când primești coletul</p>
                                    </div>
                                </label>

                                <label class="flex items-center p-4 border-2 border-blue-500 rounded-lg cursor-pointer hover:bg-blue-50 transition bg-gradient-to-r from-blue-50 to-indigo-50">
                                    <input type="radio" name="payment_method" value="card" class="w-4 h-4 text-blue-600">
                                    <div class="ml-3 flex-1">
                                        <div class="flex items-center justify-between">
                                            <span class="text-gray-900 font-medium">💳 Card Bancar</span>
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
                                        <p class="text-xs text-gray-600 mt-1">🔒 Plată securizată prin Stripe</p>
                                    </div>
                                </label>
                            </div>
                            @error('payment_method')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Order Notes -->
                        <div class="mb-8">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notițe Comandă (Opțional)</label>
                            <textarea name="notes" id="notes" rows="3" 
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                      placeholder="Instrucțiuni speciale pentru comanda ta...">{{ old('notes') }}</textarea>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 px-6 rounded-lg transition shadow-lg hover:shadow-xl">
                            Plasează Comanda
                        </button>
                    </form>
                </div>

                <!-- Order Summary - același cod ca înainte -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Sumar Comandă</h2>
                        
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
                                        @if($item['has_discount'] ?? false)
                                            <div class="flex items-center gap-2 text-xs">
                                                <span class="line-through text-gray-400">${{ number_format($item['price'], 2) }}</span>
                                                <span class="text-red-600 font-bold">${{ number_format($item['final_price'], 2) }}</span>
                                                <span class="bg-red-100 text-red-800 px-1.5 py-0.5 rounded font-bold">
                                                    -{{ $item['discount_percentage'] }}%
                                                </span>
                                            </div>
                                        @else
                                            <p class="text-sm font-semibold text-gray-900">${{ number_format($item['final_price'] * $item['quantity'], 2) }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="border-t pt-4 space-y-2">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal:</span>
                                <span>${{ number_format($cartTotal, 2) }}</span>
                            </div>

                            @if($coupon && $discountAmount > 0)
                                <div class="flex justify-between text-green-600">
                                    <span>Discount ({{ $coupon->code }}):</span>
                                    <span>-${{ number_format($discountAmount, 2) }}</span>
                                </div>
                            @endif

                            <div class="flex justify-between mb-2" id="shipping-cost-row">
                                <span class="text-gray-600">Shipping:</span>
                                <span class="font-medium text-gray-500 text-sm" id="shipping-cost-display">
                                    Selectați localitatea
                                </span>
                            </div>

                            <div class="flex justify-between text-lg font-bold text-gray-900 pt-2 border-t">
                                <span>Total:</span>
                                <span id="total-display">${{ number_format($cartTotal - $discountAmount, 2) }}</span>
                            </div>
                        </div>

                        @if($coupon)
                            <div class="mt-4 p-3 bg-green-50 border border-green-200 rounded-lg">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-green-800">✓ Cupon aplicat: <strong>{{ $coupon->code }}</strong></span>
                                    <form action="{{ route('checkout.removeCoupon') }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm">✕</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <div class="mt-4">
                                <form action="{{ route('checkout.applyCoupon') }}" method="POST" class="flex gap-2">
                                    @csrf
                                    <input type="text" name="coupon_code" placeholder="Cod cupon" 
                                           class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                    <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-lg text-sm">
                                        Aplică
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@push('styles')
<style>
    .custom-select-wrapper {
        position: relative;
    }

    .custom-select-search {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        padding: 0.5rem 1rem;
        border: 2px solid #3b82f6;
        border-radius: 0.5rem;
        background: white;
        z-index: 10;
        display: none;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .custom-select-search.active {
        display: block;
    }

    .custom-select-options {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        max-height: 300px;
        overflow-y: auto;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        margin-top: 0.25rem;
        z-index: 20;
        display: none;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .custom-select-options.active {
        display: block;
    }

    .custom-select-option {
        padding: 0.75rem 1rem;
        cursor: pointer;
        transition: background-color 0.15s;
        border-bottom: 1px solid #f3f4f6;
    }

    .custom-select-option:hover {
        background-color: #eff6ff;
    }

    .custom-select-option.selected {
        background-color: #dbeafe;
        font-weight: 600;
    }

    .custom-select-option.hidden {
        display: none;
    }

    .custom-select-no-results {
        padding: 1rem;
        text-align: center;
        color: #6b7280;
        font-size: 0.875rem;
    }

    .search-icon {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        pointer-events: none;
    }
</style>
@endpush

@push('scripts')
<script>
    // Custom Searchable Select Component
    class SearchableSelect {
        constructor(selectElement, options = {}) {
            this.select = selectElement;
            this.options = {
                placeholder: 'Caută...',
                noResultsText: 'Nu s-au găsit rezultate',
                minChars: 0,
                ...options
            };
            
            this.wrapper = null;
            this.searchInput = null;
            this.optionsContainer = null;
            this.isOpen = false;
            
            this.init();
        }

        init() {
            // Create wrapper
            this.wrapper = document.createElement('div');
            this.wrapper.className = 'custom-select-wrapper';
            this.select.parentNode.insertBefore(this.wrapper, this.select);
            this.wrapper.appendChild(this.select);

            // Create search input
            this.searchInput = document.createElement('input');
            this.searchInput.type = 'text';
            this.searchInput.className = 'custom-select-search';
            this.searchInput.placeholder = this.options.placeholder;
            this.searchInput.autocomplete = 'off';
            this.wrapper.appendChild(this.searchInput);

            // Create options container
            this.optionsContainer = document.createElement('div');
            this.optionsContainer.className = 'custom-select-options';
            this.wrapper.appendChild(this.optionsContainer);

            // Add search icon
            const searchIcon = document.createElement('span');
            searchIcon.className = 'search-icon';
            searchIcon.innerHTML = '🔍';
            this.wrapper.appendChild(searchIcon);

            // Bind events
            this.bindEvents();

            // Sync initial options
            this.syncOptions();
        }

        bindEvents() {
            // Show search on select click
            this.select.addEventListener('click', (e) => {
                e.preventDefault();
                if (!this.select.disabled) {
                    this.open();
                }
            });

            // Search input events
            this.searchInput.addEventListener('input', () => this.filterOptions());
            this.searchInput.addEventListener('keydown', (e) => this.handleKeyboard(e));

            // Close on outside click
            document.addEventListener('click', (e) => {
                if (!this.wrapper.contains(e.target)) {
                    this.close();
                }
            });

            // Sync when select options change
            const observer = new MutationObserver(() => this.syncOptions());
            observer.observe(this.select, { childList: true, subtree: true });
        }

        open() {
            this.isOpen = true;
            this.searchInput.classList.add('active');
            this.optionsContainer.classList.add('active');
            this.select.style.opacity = '0';
            this.select.style.pointerEvents = 'none';
            this.searchInput.focus();
            this.searchInput.value = '';
            this.filterOptions();
        }

        close() {
            this.isOpen = false;
            this.searchInput.classList.remove('active');
            this.optionsContainer.classList.remove('active');
            this.select.style.opacity = '1';
            this.select.style.pointerEvents = 'auto';
            this.searchInput.value = '';
        }

        syncOptions() {
            this.optionsContainer.innerHTML = '';
            
            Array.from(this.select.options).forEach((option, index) => {
                if (option.value === '') return; // Skip placeholder

                const optionDiv = document.createElement('div');
                optionDiv.className = 'custom-select-option';
                optionDiv.textContent = option.textContent;
                optionDiv.dataset.value = option.value;
                optionDiv.dataset.text = option.textContent.toLowerCase();
                optionDiv.dataset.index = index;

                // Copy data attributes
                Array.from(option.attributes).forEach(attr => {
                    if (attr.name.startsWith('data-')) {
                        optionDiv.setAttribute(attr.name, attr.value);
                    }
                });

                if (option.selected) {
                    optionDiv.classList.add('selected');
                }

                optionDiv.addEventListener('click', () => this.selectOption(index));

                this.optionsContainer.appendChild(optionDiv);
            });
        }

        filterOptions() {
            const searchTerm = this.searchInput.value.toLowerCase();
            const options = this.optionsContainer.querySelectorAll('.custom-select-option');
            let hasResults = false;

            options.forEach(option => {
                const text = option.dataset.text;
                const matches = text.includes(searchTerm);
                
                if (matches) {
                    option.classList.remove('hidden');
                    hasResults = true;
                    
                    // Highlight matching text
                    if (searchTerm) {
                        const regex = new RegExp(`(${searchTerm})`, 'gi');
                        const originalText = option.textContent;
                        option.innerHTML = originalText.replace(regex, '<mark style="background-color: #fef08a; font-weight: 600;">$1</mark>');
                    } else {
                        option.textContent = option.textContent; // Reset highlighting
                    }
                } else {
                    option.classList.add('hidden');
                }
            });

            // Show/hide no results message
            let noResults = this.optionsContainer.querySelector('.custom-select-no-results');
            if (!hasResults) {
                if (!noResults) {
                    noResults = document.createElement('div');
                    noResults.className = 'custom-select-no-results';
                    noResults.textContent = this.options.noResultsText;
                    this.optionsContainer.appendChild(noResults);
                }
                noResults.style.display = 'block';
            } else if (noResults) {
                noResults.style.display = 'none';
            }
        }

        selectOption(index) {
            this.select.selectedIndex = index;
            this.select.dispatchEvent(new Event('change', { bubbles: true }));
            this.close();
            
            // Update selected styling
            const options = this.optionsContainer.querySelectorAll('.custom-select-option');
            options.forEach((opt, idx) => {
                opt.classList.toggle('selected', idx === index - 1); // -1 because we skip placeholder
            });
        }

        handleKeyboard(e) {
            const visibleOptions = Array.from(this.optionsContainer.querySelectorAll('.custom-select-option:not(.hidden)'));
            
            if (e.key === 'Escape') {
                this.close();
            } else if (e.key === 'Enter' && visibleOptions.length > 0) {
                e.preventDefault();
                const firstOption = visibleOptions[0];
                const index = parseInt(firstOption.dataset.index);
                this.selectOption(index);
            } else if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
                e.preventDefault();
                // Could implement keyboard navigation here
            }
        }

        enable() {
            this.select.disabled = false;
            this.wrapper.style.opacity = '1';
            this.wrapper.style.pointerEvents = 'auto';
        }

        disable() {
            this.select.disabled = true;
            this.wrapper.style.opacity = '0.5';
            this.wrapper.style.pointerEvents = 'none';
            this.close();
        }

        destroy() {
            this.wrapper.replaceWith(this.select);
        }
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        const deliveryHome = document.getElementById('delivery_home');
        const deliveryLocker = document.getElementById('delivery_locker');
        const addressField = document.getElementById('address_field');
        const lockerField = document.getElementById('locker_field');
        const countySelect = document.getElementById('sameday_county');
        const citySelect = document.getElementById('sameday_city');
        const lockerSelect = document.getElementById('sameday_locker');
        const shippingCityInput = document.getElementById('shipping_city');
        const shippingAddressInput = document.getElementById('shipping_address');
        const lockerNameInput = document.getElementById('sameday_locker_name');

        // Initialize searchable selects
        let countySearchable, citySearchable, lockerSearchable;

        setTimeout(() => {
            countySearchable = new SearchableSelect(countySelect, {
                placeholder: 'Caută județ...',
                noResultsText: 'Niciun județ găsit'
            });

            citySearchable = new SearchableSelect(citySelect, {
                placeholder: 'Caută oraș...',
                noResultsText: 'Niciun oraș găsit'
            });

            lockerSearchable = new SearchableSelect(lockerSelect, {
                placeholder: 'Caută Easybox...',
                noResultsText: 'Niciun Easybox găsit'
            });

            citySearchable.disable();
            lockerSearchable.disable();
        }, 100);

        // Toggle delivery type
        function toggleDeliveryFields() {
            if (deliveryLocker.checked) {
                addressField.classList.add('hidden');
                lockerField.classList.remove('hidden');
                shippingAddressInput.removeAttribute('required');
                lockerSelect.setAttribute('required', 'required');
            } else {
                addressField.classList.remove('hidden');
                lockerField.classList.add('hidden');
                shippingAddressInput.setAttribute('required', 'required');
                lockerSelect.removeAttribute('required');
            }
        }

        deliveryHome.addEventListener('change', toggleDeliveryFields);
        deliveryLocker.addEventListener('change', toggleDeliveryFields);

        // Load counties
        console.log('Loading counties...');
        fetch('{{ route('checkout.counties') }}')
            .then(response => response.json())
            .then(data => {
                console.log('Counties data received:', data);
                
                countySelect.innerHTML = '<option value="">Selectează județ...</option>';
                
                if (Array.isArray(data) && data.length > 0) {
                    data.forEach(county => {
                        const option = document.createElement('option');
                        option.value = county.id;
                        option.textContent = county.name;
                        countySelect.appendChild(option);
                    });
                    console.log('Counties loaded successfully:', data.length);
                    
                    if (countySearchable) {
                        countySearchable.syncOptions();
                    }
                } else {
                    console.error('Invalid counties data format:', data);
                    alert('Eroare la încărcarea județelor.');
                }
            })
            .catch(error => {
                console.error('Error loading counties:', error);
                alert('Eroare la încărcarea județelor: ' + error.message);
            });

        // Load cities when county changes
        countySelect.addEventListener('change', function() {
            const countyId = this.value;
            console.log('County changed:', countyId);
            
            citySelect.innerHTML = '<option value="">Selectează oraș...</option>';
            if (citySearchable) citySearchable.disable();
            
            lockerSelect.innerHTML = '<option value="">Selectează locker...</option>';
            if (lockerSearchable) lockerSearchable.disable();
            
            shippingCityInput.value = '';

            if (countyId) {
                console.log('Loading cities for county:', countyId);
                fetch(`{{ route('checkout.cities') }}?county_id=${countyId}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log('Cities data received:', data);
                        
                        if (Array.isArray(data) && data.length > 0) {
                            data.forEach(city => {
                                const option = document.createElement('option');
                                option.value = city.id;
                                option.textContent = city.name;
                                citySelect.appendChild(option);
                            });
                            
                            if (citySearchable) {
                                citySearchable.syncOptions();
                                citySearchable.enable();
                            }
                            
                            console.log('Cities loaded successfully:', data.length);
                        } else {
                            console.error('Invalid cities data format:', data);
                            alert('Eroare la încărcarea orașelor.');
                        }
                    })
                    .catch(error => {
                        console.error('Error loading cities:', error);
                        alert('Eroare la încărcarea orașelor: ' + error.message);
                    });
            }
        });

        // Load lockers and update shipping_city when city changes
        citySelect.addEventListener('change', function() {
            const cityId = this.value;
            const cityName = this.options[this.selectedIndex].text;
            const countyId = countySelect.value;
            
            console.log('City changed:', cityId, cityName);
            
            shippingCityInput.value = cityName;
            
            lockerSelect.innerHTML = '<option value="">Selectează locker...</option>';
            if (lockerSearchable) lockerSearchable.disable();

            if (cityId && countyId) {
                console.log('Loading lockers for city:', cityId, 'county:', countyId);
                fetch(`{{ route('checkout.lockers') }}?county_id=${countyId}&city_id=${cityId}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log('Lockers data received:', data);
                        
                        if (Array.isArray(data) && data.length > 0) {
                            data.forEach(locker => {
                                const option = document.createElement('option');
                                option.value = locker.id;
                                option.textContent = `${locker.name} - ${locker.address}`;
                                option.setAttribute('data-address', locker.address);
                                lockerSelect.appendChild(option);
                            });
                            
                            if (lockerSearchable) {
                                lockerSearchable.syncOptions();
                                lockerSearchable.enable();
                            }
                            
                            console.log('Lockers loaded successfully:', data.length);
                        } else {
                            console.warn('No lockers found for this location');
                            const option = document.createElement('option');
                            option.value = '';
                            option.textContent = 'Nu există Easybox-uri în această locație';
                            lockerSelect.appendChild(option);
                        }
                    })
                    .catch(error => {
                        console.error('Error loading lockers:', error);
                        alert('Eroare la încărcarea locker-elor: ' + error.message);
                    });
            }
        });

        // Update locker name hidden field
        lockerSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value) {
                lockerNameInput.value = selectedOption.textContent;
                console.log('Locker selected:', selectedOption.textContent);
            } else {
                lockerNameInput.value = '';
            }
        });
        
        console.log('Checkout form with searchable selects initialized successfully');
    });

    // Function to calculate shipping cost
// Global variables for shipping calculation
let countySelect, citySelect, lockerSelect, deliveryHome, deliveryLocker;
let currentCartTotal = {{ $cartTotal }};
let currentDiscount = {{ $discountAmount }};
let currentShippingCost = 0;

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    deliveryHome = document.getElementById('delivery_home');
    deliveryLocker = document.getElementById('delivery_locker');
    const addressField = document.getElementById('address_field');
    const lockerField = document.getElementById('locker_field');
    countySelect = document.getElementById('sameday_county');
    citySelect = document.getElementById('sameday_city');
    lockerSelect = document.getElementById('sameday_locker');
    const shippingCityInput = document.getElementById('shipping_city');
    const shippingAddressInput = document.getElementById('shipping_address');
    const lockerNameInput = document.getElementById('sameday_locker_name');

    // Initialize searchable selects
    let countySearchable, citySearchable, lockerSearchable;

    setTimeout(() => {
        countySearchable = new SearchableSelect(countySelect, {
            placeholder: 'Caută județ...',
            noResultsText: 'Niciun județ găsit'
        });

        citySearchable = new SearchableSelect(citySelect, {
            placeholder: 'Caută oraș...',
            noResultsText: 'Niciun oraș găsit'
        });

        lockerSearchable = new SearchableSelect(lockerSelect, {
            placeholder: 'Caută Easybox...',
            noResultsText: 'Niciun Easybox găsit'
        });

        citySearchable.disable();
        lockerSearchable.disable();
    }, 100);

    // Toggle delivery type
    function toggleDeliveryFields() {
        if (deliveryLocker.checked) {
            addressField.classList.add('hidden');
            lockerField.classList.remove('hidden');
            shippingAddressInput.removeAttribute('required');
            lockerSelect.setAttribute('required', 'required');
        } else {
            addressField.classList.remove('hidden');
            lockerField.classList.add('hidden');
            shippingAddressInput.setAttribute('required', 'required');
            lockerSelect.removeAttribute('required');
        }
        // Recalculate shipping when delivery type changes
        calculateShipping();
    }

    deliveryHome.addEventListener('change', toggleDeliveryFields);
    deliveryLocker.addEventListener('change', toggleDeliveryFields);

    // Load counties
    console.log('Loading counties...');
    fetch('{{ route('checkout.counties') }}')
        .then(response => response.json())
        .then(data => {
            console.log('Counties data received:', data);
            
            countySelect.innerHTML = '<option value="">Selectează județ...</option>';
            
            if (Array.isArray(data) && data.length > 0) {
                data.forEach(county => {
                    const option = document.createElement('option');
                    option.value = county.id;
                    option.textContent = county.name;
                    countySelect.appendChild(option);
                });
                console.log('Counties loaded successfully:', data.length);
                
                if (countySearchable) {
                    countySearchable.syncOptions();
                }
            } else {
                console.error('Invalid counties data format:', data);
                alert('Eroare la încărcarea județelor.');
            }
        })
        .catch(error => {
            console.error('Error loading counties:', error);
            alert('Eroare la încărcarea județelor: ' + error.message);
        });

    // Load cities when county changes
    countySelect.addEventListener('change', function() {
        const countyId = this.value;
        console.log('County changed:', countyId);
        
        citySelect.innerHTML = '<option value="">Selectează oraș...</option>';
        if (citySearchable) citySearchable.disable();
        
        lockerSelect.innerHTML = '<option value="">Selectează locker...</option>';
        if (lockerSearchable) lockerSearchable.disable();
        
        shippingCityInput.value = '';

        if (countyId) {
            console.log('Loading cities for county:', countyId);
            fetch(`{{ route('checkout.cities') }}?county_id=${countyId}`)
                .then(response => response.json())
                .then(data => {
                    console.log('Cities data received:', data);
                    
                    if (Array.isArray(data) && data.length > 0) {
                        data.forEach(city => {
                            const option = document.createElement('option');
                            option.value = city.id;
                            option.textContent = city.name;
                            citySelect.appendChild(option);
                        });
                        
                        if (citySearchable) {
                            citySearchable.syncOptions();
                            citySearchable.enable();
                        }
                        
                        console.log('Cities loaded successfully:', data.length);
                    } else {
                        console.error('Invalid cities data format:', data);
                        alert('Eroare la încărcarea orașelor.');
                    }
                })
                .catch(error => {
                    console.error('Error loading cities:', error);
                    alert('Eroare la încărcarea orașelor: ' + error.message);
                });
        }
        // Calculate shipping when county changes
        calculateShipping();
    });

    // Load lockers and update shipping_city when city changes
    citySelect.addEventListener('change', function() {
        const cityId = this.value;
        const cityName = this.options[this.selectedIndex].text;
        const countyId = countySelect.value;
        
        console.log('City changed:', cityId, cityName);
        
        shippingCityInput.value = cityName;
        
        lockerSelect.innerHTML = '<option value="">Selectează locker...</option>';
        if (lockerSearchable) lockerSearchable.disable();

        if (cityId && countyId) {
            console.log('Loading lockers for city:', cityId, 'county:', countyId);
            fetch(`{{ route('checkout.lockers') }}?county_id=${countyId}&city_id=${cityId}`)
                .then(response => response.json())
                .then(data => {
                    console.log('Lockers data received:', data);
                    
                    if (Array.isArray(data) && data.length > 0) {
                        data.forEach(locker => {
                            const option = document.createElement('option');
                            option.value = locker.id;
                            option.textContent = `${locker.name} - ${locker.address}`;
                            option.setAttribute('data-address', locker.address);
                            lockerSelect.appendChild(option);
                        });
                        
                        if (lockerSearchable) {
                            lockerSearchable.syncOptions();
                            lockerSearchable.enable();
                        }
                        
                        console.log('Lockers loaded successfully:', data.length);
                    } else {
                        console.warn('No lockers found for this location');
                        const option = document.createElement('option');
                        option.value = '';
                        option.textContent = 'Nu există Easybox-uri în această locație';
                        lockerSelect.appendChild(option);
                    }
                })
                .catch(error => {
                    console.error('Error loading lockers:', error);
                    alert('Eroare la încărcarea locker-elor: ' + error.message);
                });
        }
        // Calculate shipping when city changes
        calculateShipping();
    });

    // Update locker name hidden field
    lockerSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
            lockerNameInput.value = selectedOption.textContent;
            console.log('Locker selected:', selectedOption.textContent);
        } else {
            lockerNameInput.value = '';
        }
        // Calculate shipping when locker changes
        calculateShipping();
    });
    
    console.log('Checkout form with searchable selects initialized successfully');
});

// Function to calculate shipping cost
function calculateShipping() {
    if (!countySelect || !countySelect.value) {
        console.log('County not selected, skipping shipping calculation');
        return;
    }

    const deliveryType = document.querySelector('input[name="delivery_type"]:checked')?.value;
    const countyId = countySelect.value;
    const cityId = citySelect.value;
    const lockerId = lockerSelect.value;
    
    console.log('Calculating shipping:', {deliveryType, countyId, cityId, lockerId});
    
    if (!deliveryType || !countyId) {
        console.log('Missing required fields for shipping calculation');
        return;
    }
    
    // For locker delivery, wait until city is selected (locker is optional for calculation)
    if (deliveryType === 'locker' && !cityId) {
        console.log('Waiting for city selection for locker delivery');
        return;
    }
    
    fetch('{{ route('checkout.calculateShipping') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            delivery_type: deliveryType,
            county_id: parseInt(countyId),
            locker_id: lockerId ? parseInt(lockerId) : null
        })
    })
     .then(response => response.json())
    .then(data => {
        if (data.success) {
            currentShippingCost = data.shipping_cost;
            
            // Update shipping cost display
            const shippingDisplay = document.getElementById('shipping-cost-display');
            
            if (currentShippingCost > 0) {
                shippingDisplay.innerHTML = '<span class="text-blue-600 font-semibold">$' + currentShippingCost.toFixed(2) + '</span>';
            } else {
                shippingDisplay.innerHTML = '<span class="text-green-600 font-semibold">GRATUIT</span>';
            }
            
            // Update total
            updateTotal();
            
            console.log('Shipping calculated:', currentShippingCost);
        } else {
            console.error('Shipping calculation failed:', data.message);
        }
    })
    .catch(error => {
        console.error('Error calculating shipping:', error);
    });
}

// Function to update total
function updateTotal() {
    const finalTotal = currentCartTotal - currentDiscount + currentShippingCost;
    
    // Update the total display
    const totalDisplay = document.getElementById('total-display');
    if (totalDisplay) {
        totalDisplay.textContent = '$' + finalTotal.toFixed(2);
    }
    
    console.log('Total updated:', {
        cartTotal: currentCartTotal,
        discount: currentDiscount,
        shipping: currentShippingCost,
        total: finalTotal
    });
}
</script>
@endpush
</x-app-layout>