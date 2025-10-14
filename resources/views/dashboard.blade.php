<x-app-layout>
    <div class="max-w-7xl mx-auto">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            @if(auth()->user()->role === 'admin')
            <div class="p-6 text-gray-900">
                <h2 class="text-2xl font-bold mb-4">Admin Dashboard</h2>
                <p>{{ __("You're logged in as Admin!") }}</p>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                    <div class="bg-blue-100 p-6 rounded-lg">
                        <h3 class="font-bold text-lg">Total Products</h3>
                        <p class="text-3xl mt-2">0</p>
                    </div>
                    <div class="bg-green-100 p-6 rounded-lg">
                        <h3 class="font-bold text-lg">Total Orders</h3>
                        <p class="text-3xl mt-2">0</p>
                    </div>
                    <div class="bg-purple-100 p-6 rounded-lg">
                        <h3 class="font-bold text-lg">Total Users</h3>
                        <p class="text-3xl mt-2">0</p>
                    </div>
                </div>
            </div>
            @else
            <div class="p-6 text-gray-900">
                <h2 class="text-2xl font-bold mb-4">Client Dashboard</h2>
                <p>{{ __("You're logged in as Client!") }}</p>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>