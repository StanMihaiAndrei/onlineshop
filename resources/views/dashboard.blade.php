<x-app-layout>
    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 py-3 sm:py-8">
        @if(auth()->user()->role === 'admin')
        <!-- Admin Dashboard -->
        <div class="mb-3 sm:mb-6">
            <h2 class="text-xl sm:text-3xl font-bold text-gray-900">Admin Dashboard</h2>
            <p class="text-gray-600 mt-1 text-xs sm:text-base">{{ __("Welcome back, Admin!") }}</p>
        </div>

        <!-- Statistici principale -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 mb-4 sm:mb-8">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white p-3 sm:p-6 rounded-lg shadow-lg">
                <div class="flex items-center justify-between gap-2">
                    <div class="min-w-0 flex-1">
                        <p class="text-blue-100 text-xs">Produse totale</p>
                        <p class="text-xl sm:text-3xl font-bold mt-1">{{ $totalProducts }}</p>
                        <p class="text-blue-100 text-xs mt-0.5">{{ $activeProducts }} active</p>
                    </div>
                    <svg class="w-8 h-8 sm:w-12 sm:h-12 text-blue-200 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-500 to-green-600 text-white p-3 sm:p-6 rounded-lg shadow-lg">
                <div class="flex items-center justify-between gap-2">
                    <div class="min-w-0 flex-1">
                        <p class="text-green-100 text-xs">Comenzi totale</p>
                        <p class="text-xl sm:text-3xl font-bold mt-1">{{ $totalOrders }}</p>
                        <p class="text-green-100 text-xs mt-0.5">{{ $pendingOrders }} în așteptare</p>
                    </div>
                    <svg class="w-8 h-8 sm:w-12 sm:h-12 text-green-200 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
            </div>

            <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white p-3 sm:p-6 rounded-lg shadow-lg">
                <div class="flex items-center justify-between gap-2">
                    <div class="min-w-0 flex-1">
                        <p class="text-purple-100 text-xs">Total Utilizatori</p>
                        <p class="text-xl sm:text-3xl font-bold mt-1">{{ $totalUsers }}</p>
                        <p class="text-purple-100 text-xs mt-0.5">Clienți înregistrați</p>
                    </div>
                    <svg class="w-8 h-8 sm:w-12 sm:h-12 text-purple-200 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>

            <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 text-white p-3 sm:p-6 rounded-lg shadow-lg">
                <div class="flex items-center justify-between gap-2">
                    <div class="min-w-0 flex-1">
                        <p class="text-yellow-100 text-xs">Venit total</p>
                        <p class="text-xl sm:text-3xl font-bold mt-1 break-all">{{ number_format($totalRevenue, 0) }} RON</p>
                        <p class="text-yellow-100 text-xs mt-0.5 break-all">{{ number_format($monthlyRevenue, 0) }} RON luna</p>
                    </div>
                    <svg class="w-8 h-8 sm:w-12 sm:h-12 text-yellow-200 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Status comenzi -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-6 mb-4 sm:mb-8">
            <div class="bg-white p-3 sm:p-6 rounded-lg shadow">
                <h3 class="font-semibold text-gray-700 mb-1 text-xs sm:text-base">Comenzi în așteptare</h3>
                <p class="text-2xl sm:text-4xl font-bold text-orange-500">{{ $pendingOrders }}</p>
            </div>
            <div class="bg-white p-3 sm:p-6 rounded-lg shadow">
                <h3 class="font-semibold text-gray-700 mb-1 text-xs sm:text-base">Comenzi în procesare</h3>
                <p class="text-2xl sm:text-4xl font-bold text-blue-500">{{ $processingOrders }}</p>
            </div>
            <div class="bg-white p-3 sm:p-6 rounded-lg shadow">
                <h3 class="font-semibold text-gray-700 mb-1 text-xs sm:text-base">Comenzi finalizate</h3>
                <p class="text-2xl sm:text-4xl font-bold text-green-500">{{ $completedOrders }}</p>
            </div>
        </div>

        <!-- Top produse și stoc scăzut -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 sm:gap-6 mb-4 sm:mb-8">
            <!-- Top 5 produse -->
            <div class="bg-white rounded-lg shadow p-3 sm:p-6">
                <h3 class="text-base sm:text-xl font-bold text-gray-900 mb-2 sm:mb-4">Top 5 Cele Mai Vândute Produse</h3>
                @if($topProducts->count() > 0)
                    <div class="space-y-2 sm:space-y-4">
                        @foreach($topProducts as $product)
                        <div class="flex items-center justify-between border-b pb-2 gap-2">
                            <div class="min-w-0 flex-1">
                                <p class="font-semibold text-gray-900 text-xs sm:text-base truncate">{{ $product->product_title }}</p>
                                <p class="text-xs text-gray-600">{{ $product->total_sold }} unități</p>
                            </div>
                            <p class="text-green-600 font-bold text-xs sm:text-base whitespace-nowrap">{{ number_format($product->total_revenue, 0) }} RON</p>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-xs sm:text-sm">Nu există date despre vânzări disponibile încă.</p>
                @endif
            </div>

            <!-- Produse cu stoc scăzut -->
            <div class="bg-white rounded-lg shadow p-3 sm:p-6">
                <h3 class="text-base sm:text-xl font-bold text-gray-900 mb-2 sm:mb-4">Alerte Stoc Scăzut</h3>
                @if($lowStockProducts->count() > 0)
                    <div class="space-y-2 sm:space-y-4">
                        @foreach($lowStockProducts as $product)
                        <div class="flex items-center justify-between border-b pb-2 gap-2">
                            <div class="min-w-0 flex-1">
                                <p class="font-semibold text-gray-900 text-xs sm:text-base truncate">{{ $product->title }}</p>
                                <p class="text-xs text-gray-600 truncate">SKU: {{ $product->id }}</p>
                            </div>
                            <span class="px-2 py-0.5 text-xs font-semibold rounded-full whitespace-nowrap {{ $product->stock == 0 ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $product->stock }} rămase
                            </span>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-xs sm:text-sm">Toate produsele au stoc suficient.</p>
                @endif
            </div>
        </div>

        <!-- Comenzi recente -->
        <div class="bg-white rounded-lg shadow p-3 sm:p-6">
            <h3 class="text-base sm:text-xl font-bold text-gray-900 mb-2 sm:mb-4">Comenzi Recente</h3>
            @if($recentOrders->count() > 0)
                <div class="overflow-x-auto -mx-3 sm:mx-0">
                    <div class="inline-block min-w-full align-middle">
                        <div class="overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-2 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase">Comanda</th>
                                        <th class="px-2 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase hidden md:table-cell">Client</th>
                                        <th class="px-2 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                                        <th class="px-2 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                        <th class="px-2 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase hidden lg:table-cell">Data</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($recentOrders as $order)
                                    <tr>
                                        <td class="px-2 sm:px-6 py-2 sm:py-4 whitespace-nowrap text-xs font-medium text-gray-900">
                                            #{{ $order->order_number }}
                                        </td>
                                        <td class="px-2 sm:px-6 py-2 sm:py-4 text-xs text-gray-500 hidden md:table-cell">
                                            <div class="max-w-[100px] lg:max-w-none truncate">{{ $order->shipping_name }}</div>
                                        </td>
                                        <td class="px-2 sm:px-6 py-2 sm:py-4 whitespace-nowrap text-xs text-gray-900">
                                            {{ number_format($order->total_amount, 0) }} RON
                                        </td>
                                        <td class="px-2 sm:px-6 py-2 sm:py-4 whitespace-nowrap">
                                            <span class="px-1.5 py-0.5 text-xs font-semibold rounded-full 
                                                @if($order->status === 'completed') bg-green-100 text-green-800
                                                @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                                @else bg-yellow-100 text-yellow-800
                                                @endif">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="px-2 sm:px-6 py-2 sm:py-4 whitespace-nowrap text-xs text-gray-500 hidden lg:table-cell">
                                            {{ $order->created_at->format('d M Y') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <p class="text-gray-500 text-xs sm:text-sm">Nu există comenzi încă.</p>
            @endif
        </div>

        @else
        <!-- Client Dashboard -->
        <div class="mb-3 sm:mb-6">
            <h2 class="text-xl sm:text-3xl font-bold text-gray-900">Panoul meu</h2>
            <p class="text-gray-600 mt-1 text-xs sm:text-base">{{ __("Bine ai revenit!") }}</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 mb-4 sm:mb-8">
            <div class="bg-blue-100 p-3 sm:p-6 rounded-lg shadow">
                <h3 class="font-bold text-sm sm:text-lg text-gray-700">Total Comenzi</h3>
                <p class="text-xl sm:text-3xl mt-1 sm:mt-2 font-bold text-blue-600">{{ $totalOrders }}</p>
            </div>
            <div class="bg-yellow-100 p-3 sm:p-6 rounded-lg shadow">
                <h3 class="font-bold text-sm sm:text-lg text-gray-700">Comenzi În Așteptare</h3>
                <p class="text-xl sm:text-3xl mt-1 sm:mt-2 font-bold text-yellow-600">{{ $pendingOrders }}</p>
            </div>
            <div class="bg-green-100 p-3 sm:p-6 rounded-lg shadow">
                <h3 class="font-bold text-sm sm:text-lg text-gray-700">Comenzi Finalizate</h3>
                <p class="text-xl sm:text-3xl mt-1 sm:mt-2 font-bold text-green-600">{{ $completedOrders }}</p>
            </div>
            <div class="bg-purple-100 p-3 sm:p-6 rounded-lg shadow">
                <h3 class="font-bold text-sm sm:text-lg text-gray-700">Total Cheltuit</h3>
                <p class="text-xl sm:text-3xl mt-1 sm:mt-2 font-bold text-purple-600">{{ number_format($totalSpent, 0) }} RON</p>
            </div>
        </div>

        <!-- Comenzi recente client -->
        <div class="bg-white rounded-lg shadow p-3 sm:p-6">
            <h3 class="text-base sm:text-xl font-bold text-gray-900 mb-2 sm:mb-4">Comenzi Recente</h3>
            @if($recentOrders->count() > 0)
                <div class="space-y-3">
                    @foreach($recentOrders as $order)
                    <div class="border rounded-lg p-3 hover:shadow-md transition">
                        <div class="flex justify-between items-start mb-2 gap-2">
                            <div class="min-w-0 flex-1">
                                <p class="font-semibold text-gray-900 text-sm">Comanda #{{ $order->order_number }}</p>
                                <p class="text-xs text-gray-500">{{ $order->created_at->format('d.m.Y, H:i') }}</p>
                            </div>
                            <span class="px-2 py-0.5 text-xs font-semibold rounded-full whitespace-nowrap
                                @if($order->status === 'completed') bg-green-100 text-green-800
                                @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <p class="text-gray-700 font-bold text-sm">{{ number_format($order->total_amount, 2) }} RON</p>
                        <a href="{{ route('orders.show', $order) }}" class="text-blue-600 hover:text-blue-800 text-xs mt-1 inline-block">
                            Vezi Detalii →
                        </a>
                    </div>
                    @endforeach
                </div>
                <a href="{{ route('orders.index') }}" class="mt-3 inline-block text-blue-600 hover:text-blue-800 font-semibold text-sm">
                    Vezi Toate Comenzile →
                </a>
            @else
                <p class="text-gray-500 text-xs sm:text-sm">Nu ați plasat încă nicio comandă.</p>
                <a href="{{ route('shop') }}" class="mt-3 inline-block bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm">
                    Începeți cumpărăturile
                </a>
            @endif
        </div>
        @endif
    </div>
</x-app-layout>