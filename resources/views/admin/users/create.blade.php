<x-app-layout>
    <div class="py-4 sm:py-6">
        <div class="max-w-3xl mx-auto px-3 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 overflow-hidden shadow-lg sm:rounded-lg border border-green-100">
                <div class="p-4 sm:p-6">
                    <!-- Header cu icon -->
                    <div class="mb-6 pb-4 border-b-2 border-green-200">
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-800 flex items-center gap-2">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            Adaugă Utilizator Nou
                        </h2>
                    </div>

                    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <!-- Name Field -->
                        <div class="bg-white rounded-lg p-4 shadow-sm border-l-4 border-blue-500">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">👤 Nume</label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name') }}" 
                                   class="shadow-sm border rounded-lg w-full py-2.5 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                                   placeholder="Introdu numele utilizatorului">
                            @error('name')
                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div class="bg-white rounded-lg p-4 shadow-sm border-l-4 border-purple-500">
                            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">📧 Email</label>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   value="{{ old('email') }}" 
                                   class="shadow-sm border rounded-lg w-full py-2.5 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('email') border-red-500 @enderror"
                                   placeholder="exemplu@email.com">
                            @error('email')
                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="bg-white rounded-lg p-4 shadow-sm border-l-4 border-indigo-500">
                            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">🔒 Parolă</label>
                            <input type="password" 
                                   name="password" 
                                   id="password" 
                                   class="shadow-sm border rounded-lg w-full py-2.5 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('password') border-red-500 @enderror"
                                   placeholder="Minimum 8 caractere">
                            @error('password')
                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="bg-white rounded-lg p-4 shadow-sm border-l-4 border-indigo-500">
                            <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">🔒 Confirmă Parola</label>
                            <input type="password" 
                                   name="password_confirmation" 
                                   id="password_confirmation" 
                                   class="shadow-sm border rounded-lg w-full py-2.5 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                   placeholder="Re-introdu parola">
                        </div>

                        <!-- Role Field -->
                        <div class="bg-white rounded-lg p-4 shadow-sm border-l-4 border-pink-500">
                            <label for="role" class="block text-gray-700 text-sm font-bold mb-2">🎭 Rol</label>
                            <select name="role" 
                                    id="role" 
                                    class="shadow-sm border rounded-lg w-full py-2.5 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('role') border-red-500 @enderror">
                                <option value="client" {{ old('role') === 'client' ? 'selected' : '' }}>Client</option>
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role')
                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email Verified Checkbox -->
                        <div class="bg-white rounded-lg p-4 shadow-sm border-l-4 border-green-500">
                            <label class="flex items-start">
                                <input type="checkbox" 
                                       name="email_verified" 
                                       value="1" 
                                       {{ old('email_verified') ? 'checked' : '' }}
                                       class="mt-1 rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                <div class="ml-3">
                                    <span class="text-sm font-semibold text-gray-700">✓ Marchează Email-ul ca Verificat</span>
                                    <p class="text-xs text-gray-500 mt-1">Bifează această opțiune dacă dorești să creezi un utilizator cu email verificat.</p>
                                </div>
                            </label>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t-2 border-green-200">
                            <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-150 shadow-md">
                                ✅ Creează Utilizator
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="flex-1 text-center bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-6 rounded-lg transition duration-150">
                                ❌ Anulează
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>