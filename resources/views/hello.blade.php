<x-guest-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-violet-500 text-white p-8 rounded-lg shadow-lg">
            <h1 class="text-3xl font-bold mb-4">Hello Tailwind!</h1>
            <p class="text-green-300">Tailwind funcționează perfect!</p>
        </div>

        <div class="mt-8 bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-bold mb-4">Livewire Counter</h2>
            <livewire:counter />
        </div>

        <div x-data="{ open: false }" class="mt-8 bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-bold mb-4">Alpine.js Test</h2>
            <button @click="open = !open" class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg transition">
                Toggle Alpine
            </button>
            <div x-show="open" x-transition class="mt-4 p-4 bg-green-100 text-green-900 rounded-lg">
                🎉 Alpine.js funcționează excelent!
            </div>
        </div>
    </div>
</x-guest-layout>