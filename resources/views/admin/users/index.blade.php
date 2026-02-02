<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Header optimizat pentru mobile -->
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-6">
                        <h2 class="text-xl font-bold text-gray-800">Management Conturi</h2>
                        <a href="{{ route('admin.users.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center">
                            Adaugă Utilizator
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Desktop Table View -->
                    <div class="hidden lg:block overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nume</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rol</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Creat La</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acțiuni</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($users as $user)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->created_at->format('d/m/Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                            <a href="{{ route('admin.users.show', $user) }}" class="text-blue-600 hover:text-blue-900">Vezi</a>
                                            <a href="{{ route('admin.users.edit', $user) }}" class="text-indigo-600 hover:text-indigo-900">Editează</a>
                                            @if($user->id !== auth()->id())
                                                <form id="delete-form-{{ $user->id }}" 
                                                      action="{{ route('admin.users.destroy', $user) }}" 
                                                      method="POST" 
                                                      class="inline"
                                                      x-data
                                                      @confirm-delete.window="if ($event.detail === 'user-{{ $user->id }}') $el.submit()">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" 
                                                            @click="$dispatch('open-modal', 'user-{{ $user->id }}')"
                                                            class="text-red-600 hover:text-red-900">
                                                        Șterge
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">Nu s-au găsit utilizatori.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Card View -->
                    <div class="lg:hidden space-y-4">
                        @forelse($users as $user)
                            <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                                <div class="flex justify-between items-start mb-3">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $user->name }}</h3>
                                        <p class="text-sm text-gray-600">{{ $user->email }}</p>
                                    </div>
                                    <span class="px-2 py-1 text-xs leading-5 font-semibold rounded-full {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </div>
                                
                                <div class="space-y-2 text-sm mb-4">
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">ID:</span>
                                        <span class="text-gray-900">{{ $user->id }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Creat La:</span>
                                        <span class="text-gray-900">{{ $user->created_at->format('d/m/Y') }}</span>
                                    </div>
                                </div>

                                <div class="flex gap-2 pt-3 border-t border-gray-200">
                                    <a href="{{ route('admin.users.show', $user) }}" class="flex-1 text-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                                        Vezi
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="flex-1 text-center bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm">
                                        Editează
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <form id="delete-form-mobile-{{ $user->id }}" 
                                              action="{{ route('admin.users.destroy', $user) }}" 
                                              method="POST" 
                                              class="flex-1"
                                              x-data
                                              @confirm-delete.window="if ($event.detail === 'user-mobile-{{ $user->id }}') $el.submit()">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" 
                                                    @click="$dispatch('open-modal', 'user-mobile-{{ $user->id }}')"
                                                    class="w-full bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-sm">
                                                Șterge
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-500">
                                Nu s-au găsit utilizatori.
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modals -->
    @foreach($users as $user)
        @if($user->id !== auth()->id())
            <x-delete-confirmation-modal 
                modalId="user-{{ $user->id }}"
                title="Delete User"
                message="Are you sure you want to delete user '{{ $user->name }}'? This action cannot be undone." />
            
            <x-delete-confirmation-modal 
                modalId="user-mobile-{{ $user->id }}"
                title="Delete User"
                message="Are you sure you want to delete user '{{ $user->name }}'? This action cannot be undone." />
        @endif
    @endforeach
</x-app-layout>