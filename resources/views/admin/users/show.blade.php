<x-app-layout>
    <div class="py-4 sm:py-6">
        <div class="max-w-3xl mx-auto px-3 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 overflow-hidden shadow-lg sm:rounded-lg border border-blue-100">
                <div class="p-4 sm:p-6">
                    <!-- Header cu gradient -->
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-6 pb-4 border-b-2 border-blue-200">
                        <div>
                            <h2 class="text-xl sm:text-2xl font-bold text-gray-800 flex items-center gap-2">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Detalii Utilizator
                            </h2>
                        </div>
                        <a href="{{ route('admin.users.edit', $user) }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-2 px-4 rounded-lg shadow-md transition duration-150 text-center">
                            ✏️ Editează
                        </a>
                    </div>

                    <!-- Info Cards cu culori -->
                    <div class="space-y-3">
                        <!-- ID Card -->
                        <div class="bg-white rounded-lg p-4 shadow-sm border-l-4 border-gray-400">
                            <label class="block text-gray-500 text-xs font-semibold mb-1 uppercase tracking-wide">ID Utilizator</label>
                            <p class="text-gray-900 text-lg font-semibold">#{{ $user->id }}</p>
                        </div>

                        <!-- Name Card -->
                        <div class="bg-white rounded-lg p-4 shadow-sm border-l-4 border-blue-500">
                            <label class="block text-gray-500 text-xs font-semibold mb-1 uppercase tracking-wide">👤 Nume</label>
                            <p class="text-gray-900 text-lg font-semibold">{{ $user->name }}</p>
                        </div>

                        <!-- Email Card -->
                        <div class="bg-white rounded-lg p-4 shadow-sm border-l-4 border-purple-500">
                            <label class="block text-gray-500 text-xs font-semibold mb-1 uppercase tracking-wide">📧 Email</label>
                            <p class="text-gray-900 text-base break-all">{{ $user->email }}</p>
                        </div>

                        <!-- Role Card -->
                        <div class="bg-white rounded-lg p-4 shadow-sm border-l-4 border-indigo-500">
                            <label class="block text-gray-500 text-xs font-semibold mb-1 uppercase tracking-wide">🎭 Rol</label>
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>

                        <!-- Email Verification Card -->
                        <div class="bg-white rounded-lg p-4 shadow-sm border-l-4 {{ $user->email_verified_at ? 'border-green-500' : 'border-red-500' }}">
                            <label class="block text-gray-500 text-xs font-semibold mb-2 uppercase tracking-wide">📬 Status Verificare Email</label>
                            <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3">
                                @if($user->email_verified_at)
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 w-fit">
                                        ✓ Verificat
                                    </span>
                                    <span class="text-xs sm:text-sm text-gray-600">
                                        {{ $user->email_verified_at->format('d.m.Y H:i') }}
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 w-fit">
                                        ✗ Neverificat
                                    </span>
                                @endif
                                
                                <!-- Toggle Button -->
                                <form action="{{ route('admin.users.toggle-email-verification', $user) }}" method="POST" class="inline mt-2 sm:mt-0">
                                    @csrf
                                    <button type="submit" 
                                            class="text-xs px-3 py-1.5 rounded-lg {{ $user->email_verified_at ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }} text-white font-semibold transition shadow-sm">
                                        {{ $user->email_verified_at ? 'Elimină Verificarea' : 'Marchează ca Verificat' }}
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Created At Card -->
                        <div class="bg-white rounded-lg p-4 shadow-sm border-l-4 border-teal-500">
                            <label class="block text-gray-500 text-xs font-semibold mb-1 uppercase tracking-wide">📅 Creat La</label>
                            <p class="text-gray-900 text-base">{{ $user->created_at->format('d.m.Y H:i') }}</p>
                        </div>

                        <!-- Updated At Card -->
                        <div class="bg-white rounded-lg p-4 shadow-sm border-l-4 border-orange-500">
                            <label class="block text-gray-500 text-xs font-semibold mb-1 uppercase tracking-wide">🔄 Actualizat La</label>
                            <p class="text-gray-900 text-base">{{ $user->updated_at->format('d.m.Y H:i') }}</p>
                        </div>
                    </div>

                    <!-- Footer Actions -->
                    <div class="mt-6 pt-4 border-t-2 border-blue-200 flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('admin.users.index') }}" class="text-center bg-gray-500 hover:bg-gray-600 text-white text-sm font-semibold py-2 px-4 rounded-lg transition duration-150">
                            ← Înapoi la Utilizatori
                        </a>
                        @if($user->id !== auth()->id())
                            <form id="delete-form-user-show" 
                                  action="{{ route('admin.users.destroy', $user) }}" 
                                  method="POST" 
                                  class="flex-1"
                                  x-data
                                  @confirm-delete.window="if ($event.detail === 'user-show') $el.submit()">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        @click="$dispatch('open-modal', 'user-show')"
                                        class="w-full bg-red-500 hover:bg-red-600 text-white text-sm font-semibold py-2 px-4 rounded-lg transition duration-150">
                                    🗑️ Șterge Utilizator
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($user->id !== auth()->id())
        <x-delete-confirmation-modal 
            modalId="user-show"
            title="Delete User"
            message="Are you sure you want to delete user '{{ $user->name }}'? This action cannot be undone." />
    @endif
</x-app-layout>