<x-app-layout>
    <div class="py-4 sm:py-6">
        <div class="max-w-3xl mx-auto px-3 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-amber-50 to-yellow-50 overflow-hidden shadow-lg sm:rounded-lg border border-amber-100">
                <div class="p-4 sm:p-6">
                    <!-- Header cu icon -->
                    <div class="mb-6 pb-4 border-b-2 border-amber-200">
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-800 flex items-center gap-2">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Editează: {{ $user->name }}
                        </h2>
                    </div>

                    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <!-- Name Field -->
                        <div class="bg-white rounded-lg p-4 shadow-sm border-l-4 border-blue-500">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">👤 Nume</label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name', $user->name) }}" 
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
                                   value="{{ old('email', $user->email) }}" 
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
                                   placeholder="Lasă necompletat pentru a păstra actuala">
                            <p class="text-xs text-gray-500 mt-1">💡 Lasă câmpul gol dacă nu dorești să schimbi parola</p>
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
                                   placeholder="Re-introdu parola nouă">
                        </div>

                        <!-- Role Field -->
                        <div class="bg-white rounded-lg p-4 shadow-sm border-l-4 border-pink-500">
                            <label for="role" class="block text-gray-700 text-sm font-bold mb-2">🎭 Rol</label>
                            <select name="role" 
                                    id="role" 
                                    class="shadow-sm border rounded-lg w-full py-2.5 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('role') border-red-500 @enderror">
                                <option value="client" {{ old('role', $user->role) === 'client' ? 'selected' : '' }}>Client</option>
                                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
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
                                       {{ old('email_verified', $user->email_verified_at ? true : false) ? 'checked' : '' }}
                                       class="mt-1 rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                                <div class="ml-3">
                                    <span class="text-sm font-semibold text-gray-700">✓ Email Verificat</span>
                                    @if($user->email_verified_at)
                                        <p class="text-xs text-gray-500 mt-1">Verificat la: {{ $user->email_verified_at->format('d.m.Y H:i') }}</p>
                                    @else
                                        <p class="text-xs text-gray-500 mt-1">Email-ul nu este încă verificat</p>
                                    @endif
                                </div>
                            </label>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t-2 border-amber-200">
                            <button type="submit" class="flex-1 bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition duration-150 shadow-md">
                                💾 Actualizează Utilizator
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