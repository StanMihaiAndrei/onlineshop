<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Finalizare Comandă</h1>

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('checkout.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                @csrf

                <!-- Left Column - Forms -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- ========================================= -->
                    <!-- 🚚 SECȚIUNEA 1: INFORMAȚII LIVRARE (SHIPPING) -->
                    <!-- ========================================= -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                            </svg>
                            Informații Livrare (pentru Curier)
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Nume Contact Livrare -->
                            <div>
                                <label for="shipping_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nume Contact Livrare <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="shipping_name" id="shipping_name" required
                                    value="{{ old('shipping_name', auth()->user()->name ?? '') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                @error('shipping_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email Contact Livrare -->
                            <div>
                                <label for="shipping_email" class="block text-sm font-medium text-gray-700 mb-2">
                                    Email Contact <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="shipping_email" id="shipping_email" required
                                    value="{{ old('shipping_email', auth()->user()->email ?? '') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                @error('shipping_email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Telefon Contact -->
                            <div class="md:col-span-2">
                                <label for="shipping_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                    Telefon Contact <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="shipping_phone" id="shipping_phone" required
                                    value="{{ old('shipping_phone') }}"
                                    placeholder="Ex: 0712345678"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                @error('shipping_phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Tip Livrare -->
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Tip Livrare <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition">
                                    <input type="radio" name="delivery_type" id="delivery_home" value="home" checked
                                        class="w-5 h-5 text-blue-600">
                                    <span class="ml-3 text-gray-900 font-medium">🏠 Livrare la Domiciliu</span>
                                </label>
                                <label class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition">
                                    <input type="radio" name="delivery_type" id="delivery_locker" value="locker"
                                        class="w-5 h-5 text-blue-600">
                                    <span class="ml-3 text-gray-900 font-medium">📦 Livrare la EasyBox</span>
                                </label>
                            </div>
                        </div>

                        <!-- Județ și Oraș -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                            <!-- Județ -->
                            <div class="custom-select-wrapper">
                                <label for="sameday_county" class="block text-sm font-medium text-gray-700 mb-2">
                                    Județ <span class="text-red-500">*</span>
                                </label>
                                <select name="sameday_county_id" id="sameday_county" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                    <option value="">Selectează județul</option>
                                </select>
                            </div>

                            <!-- Oraș -->
                            <div class="custom-select-wrapper">
                                <label for="sameday_city" class="block text-sm font-medium text-gray-700 mb-2">
                                    Oraș <span class="text-red-500">*</span>
                                </label>
                                <select name="sameday_city_id" id="sameday_city" required disabled
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 disabled:bg-gray-100">
                                    <option value="">Selectează orașul</option>
                                </select>
                                <input type="hidden" name="shipping_city" id="shipping_city">
                            </div>
                        </div>

                        <!-- Adresă Domiciliu (doar pentru home delivery) -->
                        <div id="address_field" class="mt-4">
                            <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-2">
                                Adresa Completă <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="shipping_address" id="shipping_address"
                                value="{{ old('shipping_address') }}"
                                placeholder="Strada, Număr, Bloc, Scara, Apartament"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            @error('shipping_address')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Cod Poștal (doar pentru home delivery) -->
                        <div id="postal_code_field" class="mt-4">
                            <label for="shipping_postal_code" class="block text-sm font-medium text-gray-700 mb-2">
                                Cod Poștal <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="shipping_postal_code" id="shipping_postal_code"
                                value="{{ old('shipping_postal_code') }}"
                                placeholder="Ex: 010101"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            @error('shipping_postal_code')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- EasyBox Locker (doar pentru locker delivery) -->
                        <div id="locker_field" class="mt-4 hidden">
                            <div class="custom-select-wrapper">
                                <label for="sameday_locker" class="block text-sm font-medium text-gray-700 mb-2">
                                    Selectează EasyBox <span class="text-red-500">*</span>
                                </label>
                                <select name="sameday_locker_id" id="sameday_locker" disabled
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 disabled:bg-gray-100">
                                    <option value="">Selectează un EasyBox</option>
                                </select>
                                <input type="hidden" name="sameday_locker_name" id="sameday_locker_name">
                            </div>
                        </div>

                        <!-- Hidden Country -->
                        <input type="hidden" name="shipping_country" value="Romania">
                    </div>

                    <!-- ========================================= -->
                    <!-- 📄 SECȚIUNEA 2: INFORMAȚII FACTURARE (BILLING) -->
                    <!-- ========================================= -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Informații Facturare
                        </h2>

                        <!-- Tip Persoană -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Tip Comandă <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-green-500 transition">
                                    <input type="radio" name="is_company" id="is_person" value="0" checked
                                        class="w-5 h-5 text-green-600">
                                    <span class="ml-3 text-gray-900 font-medium">👤 Persoană Fizică</span>
                                </label>
                                <label class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-green-500 transition">
                                    <input type="radio" name="is_company" id="is_company_radio" value="1"
                                        class="w-5 h-5 text-green-600">
                                    <span class="ml-3 text-gray-900 font-medium">🏢 Persoană Juridică (Firmă)</span>
                                </label>
                            </div>
                        </div>

                        <!-- Câmpuri Firmă (ascunse implicit) -->
                        <div id="company_fields" class="hidden mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                            <h3 class="text-sm font-semibold text-green-800 mb-4">Detalii Firmă</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-2">
                                    <label for="billing_company_name" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nume Firmă <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="billing_company_name" id="billing_company_name"
                                        value="{{ old('billing_company_name') }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                                </div>
                                <div>
                                    <label for="billing_cif" class="block text-sm font-medium text-gray-700 mb-2">
                                        CUI/CIF <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="billing_cif" id="billing_cif"
                                        value="{{ old('billing_cif') }}"
                                        placeholder="Ex: RO12345678"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                                </div>
                                <div>
                                    <label for="billing_reg_com" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nr. Reg. Com. (opțional)
                                    </label>
                                    <input type="text" name="billing_reg_com" id="billing_reg_com"
                                        value="{{ old('billing_reg_com') }}"
                                        placeholder="Ex: J40/1234/2020"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                                </div>
                            </div>
                        </div>

                        <!-- Câmpuri Facturare -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="billing_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nume Complet / Reprezentant <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="billing_name" id="billing_name" required
                                    value="{{ old('billing_name', auth()->user()->name ?? '') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                                @error('billing_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="billing_email" class="block text-sm font-medium text-gray-700 mb-2">
                                    Email Facturare <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="billing_email" id="billing_email" required
                                    value="{{ old('billing_email', auth()->user()->email ?? '') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                                @error('billing_email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="billing_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                    Telefon Facturare <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="billing_phone" id="billing_phone" required
                                    value="{{ old('billing_phone') }}"
                                    placeholder="Ex: 0712345678"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                                @error('billing_phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="billing_address" class="block text-sm font-medium text-gray-700 mb-2">
                                    Adresă Facturare <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="billing_address" id="billing_address" required
                                    value="{{ old('billing_address') }}"
                                    placeholder="Strada, Număr, Bloc, Scara, Apartament"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                                @error('billing_address')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="billing_city" class="block text-sm font-medium text-gray-700 mb-2">
                                    Oraș Facturare <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="billing_city" id="billing_city" required
                                    value="{{ old('billing_city') }}"
                                    placeholder="Ex: București"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                                @error('billing_city')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="billing_county" class="block text-sm font-medium text-gray-700 mb-2">
                                    Județ Facturare <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="billing_county" id="billing_county" required
                                    value="{{ old('billing_county') }}"
                                    placeholder="Ex: București"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                                @error('billing_county')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="billing_postal_code" class="block text-sm font-medium text-gray-700 mb-2">
                                    Cod Poștal Facturare <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="billing_postal_code" id="billing_postal_code" required
                                    value="{{ old('billing_postal_code') }}"
                                    placeholder="Ex: 010101"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                                @error('billing_postal_code')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="billing_country" class="block text-sm font-medium text-gray-700 mb-2">
                                    Țară <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="billing_country" value="Romania" readonly
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100">
                            </div>
                        </div>

                        <!-- Checkbox pentru "Aceeași adresă" -->
                        <div class="mt-4">
                            <label class="flex items-center">
                                <input type="checkbox" id="same_as_shipping" class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                <span class="ml-2 text-sm text-gray-700">Adresa de facturare este aceeași cu adresa de livrare</span>
                            </label>
                        </div>
                    </div>

                    <!-- Metoda de Plată -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Metodă de Plată</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <label class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition">
                                <input type="radio" name="payment_method" value="card" checked class="w-5 h-5 text-blue-600">
                                <span class="ml-3 text-gray-900 font-medium">💳 Card Bancar (Stripe)</span>
                            </label>
                            <label class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition">
                                <input type="radio" name="payment_method" value="cash_on_delivery" class="w-5 h-5 text-blue-600">
                                <span class="ml-3 text-gray-900 font-medium">💵 Ramburs la Livrare</span>
                            </label>
                        </div>
                    </div>

                    <!-- Notițe -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Notițe pentru Comandă (opțional)
                        </label>
                        <textarea name="notes" id="notes" rows="3"
                            placeholder="Instrucțiuni speciale pentru livrare..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('notes') }}</textarea>
                    </div>
                </div>

                <!-- Right Column - Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Sumar Comandă</h2>

                        <!-- Products -->
                        <div class="space-y-4 mb-4">
                            @foreach($cartItems as $item)
                                <div class="flex items-center gap-3">
                                    @if(!empty($item['image']))
                                        <img src="{{ asset('storage/' . $item['image']) }}" 
                                            alt="{{ $item['title'] }}" 
                                            class="w-16 h-16 object-cover rounded">
                                    @else
                                        <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                            <span class="text-gray-400 text-xs">No image</span>
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <p class="text-sm font-medium">{{ $item['title'] }}</p>
                                        <p class="text-xs text-gray-500">Cantitate: {{ $item['quantity'] }}</p>
                                        <p class="text-sm font-bold text-blue-600">RON {{ number_format($item['final_price'] * $item['quantity'], 2) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="border-t border-gray-200 pt-4 space-y-2">
                            <div class="flex justify-between">
                                <span>Subtotal:</span>
                                <span class="font-medium">RON {{ number_format($cartTotal, 2) }}</span>
                            </div>

                            @if($discountAmount > 0)
                                <div class="flex justify-between text-green-600">
                                    <span>Reducere:</span>
                                    <span class="font-medium">- RON {{ number_format($discountAmount, 2) }}</span>
                                </div>
                            @endif

                            <div class="flex justify-between text-blue-600">
                                <span>Livrare:</span>
                                <span class="font-medium" id="shipping-cost-display">
                                    @if($shippingCost > 0)
                                        RON {{ number_format($shippingCost, 2) }}
                                    @else
                                        Se calculează...
                                    @endif
                                </span>
                            </div>

                            <div class="flex justify-between text-lg font-bold border-t border-gray-200 pt-2">
                                <span>Total:</span>
                                <span class="text-blue-600" id="total-display">RON {{ number_format($finalTotal, 2) }}</span>
                            </div>
                        </div>

                        <button type="submit" 
                            class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition mt-6">
                            Plasează Comanda
                        </button>
                    </div>
                </div>
            </form>
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
        pointer-events: none;
    }
</style>
@endpush

@push('scripts')
<script>
    // Custom Searchable Select Component
    class SearchableSelect {
        constructor(selectElement) {
            this.select = selectElement;
            this.wrapper = selectElement.closest('.custom-select-wrapper');
            this.options = Array.from(selectElement.options).slice(1);
            this.selectedOption = null;
            this.isOpen = false;
            
            this.createCustomElements();
            this.attachEvents();
        }

        createCustomElements() {
            // Create search input
            this.searchInput = document.createElement('input');
            this.searchInput.type = 'text';
            this.searchInput.className = 'custom-select-search';
            this.searchInput.placeholder = 'Caută...';
            
            // Create options container
            this.optionsContainer = document.createElement('div');
            this.optionsContainer.className = 'custom-select-options';
            
            // Create no results message
            this.noResults = document.createElement('div');
            this.noResults.className = 'custom-select-no-results hidden';
            this.noResults.textContent = 'Nu s-au găsit rezultate';
            
            this.wrapper.appendChild(this.searchInput);
            this.wrapper.appendChild(this.optionsContainer);
            this.optionsContainer.appendChild(this.noResults);
            
            this.renderOptions();
        }

        renderOptions(filter = '') {
            // Clear existing options
            const existingOptions = this.optionsContainer.querySelectorAll('.custom-select-option');
            existingOptions.forEach(opt => opt.remove());
            
            const filteredOptions = this.options.filter(option => 
                option.text.toLowerCase().includes(filter.toLowerCase())
            );
            
            if (filteredOptions.length === 0) {
                this.noResults.classList.remove('hidden');
            } else {
                this.noResults.classList.add('hidden');
                
                filteredOptions.forEach(option => {
                    const optionElement = document.createElement('div');
                    optionElement.className = 'custom-select-option';
                    optionElement.textContent = option.text;
                    optionElement.dataset.value = option.value;
                    
                    if (option.value === this.select.value) {
                        optionElement.classList.add('selected');
                    }
                    
                    optionElement.addEventListener('click', () => this.selectOption(option));
                    this.optionsContainer.appendChild(optionElement);
                });
            }
        }

        selectOption(option) {
            this.select.value = option.value;
            this.selectedOption = option;
            
            // Trigger change event
            const event = new Event('change', { bubbles: true });
            this.select.dispatchEvent(event);
            
            this.close();
        }

        attachEvents() {
            // Toggle on select click
            this.select.addEventListener('click', (e) => {
                e.stopPropagation();
                this.isOpen ? this.close() : this.open();
            });
            
            // Search functionality
            this.searchInput.addEventListener('input', (e) => {
                this.renderOptions(e.target.value);
            });
            
            this.searchInput.addEventListener('click', (e) => {
                e.stopPropagation();
            });
            
            // Close on outside click
            document.addEventListener('click', (e) => {
                if (!this.wrapper.contains(e.target)) {
                    this.close();
                }
            });
        }

        open() {
            this.isOpen = true;
            this.searchInput.classList.add('active');
            this.optionsContainer.classList.add('active');
            this.searchInput.focus();
            this.renderOptions();
        }

        close() {
            this.isOpen = false;
            this.searchInput.classList.remove('active');
            this.optionsContainer.classList.remove('active');
            this.searchInput.value = '';
        }

        updateOptions(options) {
            // Clear existing options
            this.select.innerHTML = '<option value="">Selectează...</option>';
            
            // Add new options
            options.forEach(opt => {
                const option = document.createElement('option');
                option.value = opt.value;
                option.textContent = opt.text;
                this.select.appendChild(option);
            });
            
            this.options = Array.from(this.select.options).slice(1);
            this.renderOptions();
        }

        enable() {
            this.select.disabled = false;
            this.select.classList.remove('disabled:bg-gray-100');
        }

        disable() {
            this.select.disabled = true;
            this.select.classList.add('disabled:bg-gray-100');
            this.close();
        }

        reset() {
            this.select.value = '';
            this.selectedOption = null;
            this.close();
        }
    }

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
        const postalCodeField = document.getElementById('postal_code_field');
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
            countySearchable = new SearchableSelect(countySelect);
            citySearchable = new SearchableSelect(citySelect);
            lockerSearchable = new SearchableSelect(lockerSelect);
            
            citySearchable.disable();
            lockerSearchable.disable();
        }, 100);

        // Toggle delivery type
        function toggleDeliveryFields() {
            if (deliveryHome.checked) {
                addressField.classList.remove('hidden');
                postalCodeField.classList.remove('hidden');
                lockerField.classList.add('hidden');
                document.getElementById('shipping_address').required = true;
                document.getElementById('shipping_postal_code').required = true;
                lockerSelect.required = false;
            } else {
                addressField.classList.add('hidden');
                postalCodeField.classList.add('hidden');
                lockerField.classList.remove('hidden');
                document.getElementById('shipping_address').required = false;
                document.getElementById('shipping_postal_code').required = false;
                lockerSelect.required = true;
            }
            calculateShipping();
        }

        deliveryHome.addEventListener('change', toggleDeliveryFields);
        deliveryLocker.addEventListener('change', toggleDeliveryFields);

        // Load counties
        console.log('Loading counties...');
        fetch('{{ route('checkout.counties') }}')
            .then(response => response.json())
            .then(data => {
                console.log('Counties received:', data.length, 'items');
                const options = data.map(county => ({
                    value: county.id,
                    text: county.name
                }));
                countySearchable.updateOptions(options);
                countySearchable.enable();
            })
            .catch(error => {
                console.error('Error loading counties:', error);
                alert('Eroare la încărcarea județelor. Vă rugăm să reîncărcați pagina.');
            });

        // Load cities when county changes
        countySelect.addEventListener('change', function() {
            const countyId = this.value;
            
            if (!countyId) {
                citySearchable.reset();
                citySearchable.disable();
                lockerSearchable.reset();
                lockerSearchable.disable();
                return;
            }

            console.log('Loading cities for county:', countyId);
            
            fetch(`{{ route('checkout.cities') }}?county_id=${countyId}`)
                .then(response => response.json())
                .then(data => {
                    console.log('Cities received:', data.length, 'items');
                    const options = data.map(city => ({
                        value: city.id,
                        text: city.name
                    }));
                    citySearchable.updateOptions(options);
                    citySearchable.enable();
                    citySearchable.reset();
                    
                    lockerSearchable.reset();
                    lockerSearchable.disable();
                })
                .catch(error => {
                    console.error('Error loading cities:', error);
                    alert('Eroare la încărcarea orașelor.');
                });
            
            calculateShipping();
        });

        // Load lockers and update shipping_city when city changes
        citySelect.addEventListener('change', function() {
            const countyId = countySelect.value;
            const cityId = this.value;
            const cityName = this.options[this.selectedIndex].text;
            
            // Update hidden shipping_city field
            shippingCityInput.value = cityName;
            
            if (!cityId) {
                lockerSearchable.reset();
                lockerSearchable.disable();
                return;
            }

            if (deliveryLocker.checked) {
                console.log('Loading lockers for city:', cityId);
                
                fetch(`{{ route('checkout.lockers') }}?county_id=${countyId}&city_id=${cityId}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log('Lockers received:', data.length, 'items');
                        const options = data.map(locker => ({
                            value: locker.id,
                            text: locker.name
                        }));
                        lockerSearchable.updateOptions(options);
                        lockerSearchable.enable();
                        lockerSearchable.reset();
                    })
                    .catch(error => {
                        console.error('Error loading lockers:', error);
                        alert('Eroare la încărcarea EasyBox-urilor.');
                    });
            }
            
            calculateShipping();
        });

        // Update locker name hidden field
        lockerSelect.addEventListener('change', function() {
            const lockerName = this.options[this.selectedIndex].text;
            lockerNameInput.value = lockerName;
            
            // Also update shipping_address for locker delivery
            shippingAddressInput.value = lockerName;
            
            calculateShipping();
        });

        // ========================================
        // BILLING FIELDS - Toggle company fields
        // ========================================
        const isPersonRadio = document.getElementById('is_person');
        const isCompanyRadio = document.getElementById('is_company_radio');
        const companyFields = document.getElementById('company_fields');
        const billingCompanyName = document.getElementById('billing_company_name');
        const billingCif = document.getElementById('billing_cif');

        function toggleCompanyFields() {
            if (isCompanyRadio.checked) {
                companyFields.classList.remove('hidden');
                billingCompanyName.required = true;
                billingCif.required = true;
            } else {
                companyFields.classList.add('hidden');
                billingCompanyName.required = false;
                billingCif.required = false;
            }
        }

        isPersonRadio.addEventListener('change', toggleCompanyFields);
        isCompanyRadio.addEventListener('change', toggleCompanyFields);

        // ========================================
        // SAME AS SHIPPING - Copy shipping to billing
        // ========================================
        const sameAsShippingCheckbox = document.getElementById('same_as_shipping');
        
        sameAsShippingCheckbox.addEventListener('change', function() {
            if (this.checked) {
                // Copy shipping data to billing
                document.getElementById('billing_name').value = document.getElementById('shipping_name').value;
                document.getElementById('billing_email').value = document.getElementById('shipping_email').value;
                document.getElementById('billing_phone').value = document.getElementById('shipping_phone').value;
                document.getElementById('billing_address').value = document.getElementById('shipping_address').value;
                document.getElementById('billing_city').value = shippingCityInput.value || document.getElementById('shipping_city').value;
                document.getElementById('billing_postal_code').value = document.getElementById('shipping_postal_code').value;
                
                // Get county name from select
                const countySelect = document.getElementById('sameday_county');
                const countyName = countySelect.options[countySelect.selectedIndex]?.text || '';
                document.getElementById('billing_county').value = countyName;
            }
        });

        // Also update billing when shipping fields change (if checkbox is checked)
        ['shipping_name', 'shipping_email', 'shipping_phone', 'shipping_address', 'shipping_postal_code'].forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field) {
                field.addEventListener('input', function() {
                    if (sameAsShippingCheckbox.checked) {
                        const billingFieldId = fieldId.replace('shipping_', 'billing_');
                        const billingField = document.getElementById(billingFieldId);
                        if (billingField) {
                            billingField.value = this.value;
                        }
                    }
                });
            }
        });
        
        console.log('Checkout form initialized successfully');
    });

    // Function to calculate shipping cost
    function calculateShipping() {
    if (!countySelect || !countySelect.value) {
        console.log('County not selected yet');
        return;
    }

    const deliveryType = document.querySelector('input[name="delivery_type"]:checked')?.value;
    const countyId = countySelect.value;
    const cityId = citySelect.value;
    const lockerId = lockerSelect.value;
    
    console.log('Calculating shipping:', {deliveryType, countyId, cityId, lockerId});
    
    if (!deliveryType || !countyId) {
        console.log('Missing delivery type or county');
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
            county_id: countyId,
            city_id: cityId,
            locker_id: lockerId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.shipping_cost !== null && data.shipping_cost !== undefined) {
            // Convert to number to ensure it's numeric
            currentShippingCost = parseFloat(data.shipping_cost);
            
            // Update shipping cost display
            const shippingDisplay = document.getElementById('shipping-cost-display');
            if (shippingDisplay) {
                shippingDisplay.textContent = `RON ${currentShippingCost.toFixed(2)}`;
            }
            
            // Update total
            updateTotal();
            
            console.log('Shipping cost updated:', currentShippingCost);
        } else {
            console.error('Shipping calculation failed:', data.message || data.error);
            alert(data.message || data.error || 'Eroare la calcularea costului de livrare.');
            
            // Reset shipping cost
            currentShippingCost = 0;
            const shippingDisplay = document.getElementById('shipping-cost-display');
            if (shippingDisplay) {
                shippingDisplay.textContent = 'RON 0.00';
            }
            updateTotal();
        }
    })
    .catch(error => {
        console.error('Error calculating shipping:', error);
        alert('Eroare la calcularea costului de livrare. Vă rugăm încercați din nou.');
        
        // Reset shipping cost on error
        currentShippingCost = 0;
        const shippingDisplay = document.getElementById('shipping-cost-display');
        if (shippingDisplay) {
            shippingDisplay.textContent = 'RON 0.00';
        }
        updateTotal();
    });
}

    // Function to update total
    function updateTotal() {
        const finalTotal = currentCartTotal - currentDiscount + currentShippingCost;
        
        // Update the total display
        const totalDisplay = document.getElementById('total-display');
        if (totalDisplay) {
            totalDisplay.textContent = `RON ${finalTotal.toFixed(2)}`;
        }
        
        console.log('Total updated:', {
            cart: currentCartTotal,
            discount: currentDiscount,
            shipping: currentShippingCost,
            total: finalTotal
        });
    }
</script>
@endpush
</x-app-layout>