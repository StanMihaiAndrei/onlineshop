<x-app-layout>
    <div class="py-6">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Detalii Utilizator</h2>
                        <a href="{{ route('admin.users.edit', $user) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Editează Utilizator
                        </a>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">ID</label>
                            <p class="text-gray-900">{{ $user->id }}</p>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Nume</label>
                            <p class="text-gray-900">{{ $user->name }}</p>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                            <p class="text-gray-900">{{ $user->email }}</p>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Rol</label>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Status Verificare Email</label>
                            <div class="flex items-center gap-3">
                                @if($user->email_verified_at)
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        ✓ Verificat
                                    </span>
                                    <span class="text-sm text-gray-600">
                                        on {{ $user->email_verified_at->format('d.m.Y H:i') }}
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        ✗ Neverificat
                                    </span>
                                @endif
                                
                                <!-- Toggle Button -->
                                <form action="{{ route('admin.users.toggle-email-verification', $user) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="text-xs px-3 py-1 rounded {{ $user->email_verified_at ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }} text-white font-semibold transition">
                                        {{ $user->email_verified_at ? 'Elimină Verificarea' : 'Marchează ca Verificat' }}
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Creat La</label>
                            <p class="text-gray-900">{{ $user->created_at->format('d.m.Y H:i') }}</p>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Actualizat La</label>
                            <p class="text-gray-900">{{ $user->updated_at->format('d.m.Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="mt-6 flex space-x-2">
                        <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:text-gray-800">Înapoi la Utilizatori</a>
                        @if($user->id !== auth()->id())
                            <form id="delete-form-user-show" 
                                  action="{{ route('admin.users.destroy', $user) }}" 
                                  method="POST" 
                                  class="inline"
                                  x-data
                                  @confirm-delete.window="if ($event.detail === 'user-show') $el.submit()">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        @click="$dispatch('open-modal', 'user-show')"
                                        class="text-red-600 hover:text-red-900 ml-4">
                                    Șterge Utilizator
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