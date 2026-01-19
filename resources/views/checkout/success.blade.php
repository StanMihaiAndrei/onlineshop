<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <div class="mb-6">
                    <svg class="w-20 h-20 mx-auto text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>

                <h1 class="text-3xl font-bold text-gray-900 mb-2">Comanda plasată cu succes!</h1>
                <p class="text-gray-600 mb-6">Vă mulțumim pentru comandă. Vă vom trimite un e-mail de confirmare în scurt timp.</p>

                <div class="bg-gray-50 rounded-lg p-6 mb-8">
                    <div class="grid grid-cols-2 gap-4 text-left">
                        <div>
                            <p class="text-sm text-gray-600">Număr comandă</p>
                            <p class="font-semibold text-gray-900">{{ $order->order_number }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Sumă totală</p>
                            <p class="font-semibold text-gray-900">${{ number_format($order->total_amount, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Metoda de plată</p>
                            <p class="font-semibold text-gray-900">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Status</p>
                            <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="space-y-3">
                    @auth
                        <a href="{{ route('orders.index') }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition">
                            Vezi comenzile mele
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition">
                            Creează un cont pentru vedea detaliile comenzilor viitoare
                        </a>
                    @endauth
                    <a href="{{ route('shop') }}" class="block w-full bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-3 px-6 rounded-lg transition">
                        Continuă cumpărăturile
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>