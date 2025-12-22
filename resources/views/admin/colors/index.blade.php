<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Colors</h2>
                <a href="{{ route('admin.colors.create') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-3 sm:px-6 py-2 rounded-lg transition text-sm sm:text-base">
                    <span class="hidden sm:inline">+ Add New Color</span>
                    <span class="sm:hidden">+ Add</span>
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Desktop Table View -->
            <div class="hidden lg:block bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Color</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hex Code</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($colors as $color)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="w-10 h-10 rounded-full border-2 border-gray-300" 
                                         style="background-color: {{ $color->hex_code }}"></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $color->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $color->hex_code }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $color->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $color->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.colors.edit', $color) }}" 
                                       class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                    <form action="{{ route('admin.colors.destroy', $color) }}" 
                                          method="POST" 
                                          class="inline"
                                          onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                    No colors found. <a href="{{ route('admin.colors.create') }}" class="text-blue-600">Add your first color</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="lg:hidden space-y-4">
                @forelse($colors as $color)
                    <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                        <div class="flex items-center gap-4 mb-3">
                            <div class="w-16 h-16 rounded-full border-2 border-gray-300 flex-shrink-0" 
                                 style="background-color: {{ $color->hex_code }}"></div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-gray-900 text-base">{{ $color->name }}</h3>
                                <p class="text-sm text-gray-500 font-mono">{{ $color->hex_code }}</p>
                                <span class="inline-block mt-1 px-2 py-0.5 text-xs rounded-full {{ $color->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $color->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('admin.colors.edit', $color) }}" 
                               class="flex-1 text-center bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm">
                                Edit
                            </a>
                            <form action="{{ route('admin.colors.destroy', $color) }}" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Are you sure you want to delete this color?')"
                                        class="w-full bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-sm">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500 bg-white rounded-lg border border-gray-200">
                        No colors found. <a href="{{ route('admin.colors.create') }}" class="text-blue-600">Add your first color</a>
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $colors->links() }}
            </div>
        </div>
    </div>
</x-app-layout>