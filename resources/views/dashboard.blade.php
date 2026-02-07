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
        <div class="mb-6">
            <h2 class="text-3xl sm:text-4xl font-bold" style="color: var(--color-text);">Panoul Meu</h2>
            <p class="text-gray-600 mt-2">Bine ai revenit! Iată un rezumat al contului tău.</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
            <div class="p-6 rounded-2xl shadow-sm hover-lift" style="background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(59, 130, 246, 0.05) 100%);">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background-color: rgba(59, 130, 246, 0.1);">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                </div>
                <p class="text-gray-600 text-sm mb-1">Total Comenzi</p>
                <p class="text-3xl font-bold text-blue-600">{{ $totalOrders }}</p>
            </div>

            <div class="p-6 rounded-2xl shadow-sm hover-lift" style="background: linear-gradient(135deg, rgba(234, 179, 8, 0.1) 0%, rgba(234, 179, 8, 0.05) 100%);">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background-color: rgba(234, 179, 8, 0.1);">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-gray-600 text-sm mb-1">În Așteptare</p>
                <p class="text-3xl font-bold text-yellow-600">{{ $pendingOrders }}</p>
            </div>

            <div class="p-6 rounded-2xl shadow-sm hover-lift" style="background: linear-gradient(135deg, rgba(34, 197, 94, 0.1) 0%, rgba(34, 197, 94, 0.05) 100%);">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background-color: rgba(34, 197, 94, 0.1);">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-gray-600 text-sm mb-1">Finalizate</p>
                <p class="text-3xl font-bold text-green-600">{{ $completedOrders }}</p>
            </div>

            <div class="p-6 rounded-2xl shadow-sm hover-lift" style="background: linear-gradient(135deg, rgba(219, 28, 181, 0.1) 0%, rgba(219, 28, 181, 0.05) 100%);">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background-color: var(--color-primary-light);">
                        <svg class="w-6 h-6" style="color: var(--color-primary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-gray-600 text-sm mb-1">Total Cheltuit</p>
                <p class="text-2xl sm:text-3xl font-bold" style="color: var(--color-primary);">{{ number_format($totalSpent, 0) }} RON</p>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="bg-white rounded-2xl shadow-sm p-6 sm:p-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl sm:text-2xl font-bold" style="color: var(--color-text);">Comenzi Recente</h3>
                @if($recentOrders->count() > 0)
                    <a href="{{ route('orders.index') }}" 
                    class="inline-flex items-center gap-2 text-sm font-medium hover:underline"
                    style="color: var(--color-primary);">
                        <span>Vezi Toate</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                @endif
            </div>

            @if($recentOrders->count() > 0)
                <div class="space-y-4">
                    @foreach($recentOrders as $order)
                        <div class="p-5 rounded-xl border-2 border-gray-100 hover:shadow-md transition-all hover-lift">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: rgba(219, 28, 181, 0.1);">
                                        <svg class="w-5 h-5" style="color: var(--color-primary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-bold" style="color: var(--color-text);">{{ $order->order_number }}</p>
                                        <p class="text-sm text-gray-600">{{ $order->created_at->format('d.m.Y, H:i') }}</p>
                                    </div>
                                </div>
                                <span class="px-4 py-2 text-sm font-semibold rounded-full w-fit
                                    @if($order->status === 'completed') bg-green-100 text-green-800
                                    @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                    @elseif($order->status === 'delivering') text-white
                                    @else bg-yellow-100 text-yellow-800
                                    @endif"
                                    @if($order->status === 'delivering') style="background-color: var(--color-primary);" @endif>
                                    {{ $order->status_label }}
                                </span>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <p class="text-xl font-bold" style="color: var(--color-primary);">{{ number_format($order->total_amount, 2) }} RON</p>
                                <a href="{{ route('orders.show', $order) }}" 
                                class="inline-flex items-center gap-2 text-sm font-medium hover:underline"
                                style="color: var(--color-primary);">
                                    <span>Vezi Detalii</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-20 h-20 mx-auto mb-6 rounded-full flex items-center justify-center" style="background-color: rgba(219, 28, 181, 0.1);">
                        <svg class="w-10 h-10" style="color: var(--color-primary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <p class="text-gray-600 mb-6">Nu ați plasat încă nicio comandă.</p>
                    <a href="{{ route('shop') }}" 
                    class="inline-flex items-center gap-2 px-8 py-4 rounded-xl font-semibold text-white transition-all hover:shadow-lg"
                    style="background-color: var(--color-primary);">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span>Începeți Cumpărăturile</span>
                    </a>
                </div>
            @endif
        </div>
        @endif
    </div>
</x-app-layout>