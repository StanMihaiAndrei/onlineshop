<x-app-layout>
    <div class="py-6">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">User Details</h2>
                        <a href="{{ route('admin.users.edit', $user) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Edit User
                        </a>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">ID</label>
                            <p class="text-gray-900">{{ $user->id }}</p>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                            <p class="text-gray-900">{{ $user->name }}</p>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                            <p class="text-gray-900">{{ $user->email }}</p>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Role</label>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Email Verified At</label>
                            <p class="text-gray-900">{{ $user->email_verified_at ? $user->email_verified_at->format('d/m/Y H:i') : 'Not verified' }}</p>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Created At</label>
                            <p class="text-gray-900">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Updated At</label>
                            <p class="text-gray-900">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="mt-6 flex space-x-2">
                        <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:text-gray-800">Back to Users</a>
                        @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 ml-4">Delete User</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>