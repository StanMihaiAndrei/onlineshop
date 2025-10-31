<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(auth()->user()->role === 'admin')
        <!-- Admin Dashboard -->
        <div class="mb-6">
            <h2 class="text-3xl font-bold text-gray-900">Admin Dashboard</h2>
            <p class="text-gray-600 mt-1">{{ __("Welcome back, Admin!") }}</p>
        </div>

        <!-- Statistici principale -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white p-6 rounded-lg shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm">Total Products</p>
                        <p class="text-3xl font-bold mt-2">{{ $totalProducts }}</p>
                        <p class="text-blue-100 text-xs mt-1">{{ $activeProducts }} active</p>
                    </div>
                    <svg class="w-12 h-12 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-500 to-green-600 text-white p-6 rounded-lg shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm">Total Orders</p>
                        <p class="text-3xl font-bold mt-2">{{ $totalOrders }}</p>
                        <p class="text-green-100 text-xs mt-1">{{ $pendingOrders }} pending</p>
                    </div>
                    <svg class="w-12 h-12 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
            </div>

            <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white p-6 rounded-lg shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm">Total Users</p>
                        <p class="text-3xl font-bold mt-2">{{ $totalUsers }}</p>
                        <p class="text-purple-100 text-xs mt-1">Registered clients</p>
                    </div>
                    <svg class="w-12 h-12 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>

            <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 text-white p-6 rounded-lg shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-yellow-100 text-sm">Total Revenue</p>
                        <p class="text-3xl font-bold mt-2">{{ number_format($totalRevenue, 2) }} RON</p>
                        <p class="text-yellow-100 text-xs mt-1">{{ number_format($monthlyRevenue, 2) }} RON this month</p>
                    </div>
                    <svg class="w-12 h-12 text-yellow-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Status comenzi -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="font-semibold text-gray-700 mb-2">Pending Orders</h3>
                <p class="text-4xl font-bold text-orange-500">{{ $pendingOrders }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="font-semibold text-gray-700 mb-2">Processing Orders</h3>
                <p class="text-4xl font-bold text-blue-500">{{ $processingOrders }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="font-semibold text-gray-700 mb-2">Completed Orders</h3>
                <p class="text-4xl font-bold text-green-500">{{ $completedOrders }}</p>
            </div>
        </div>

        <!-- Top produse și stoc scăzut -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Top 5 produse -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Top 5 Best Selling Products</h3>
                @if($topProducts->count() > 0)
                    <div class="space-y-4">
                        @foreach($topProducts as $product)
                        <div class="flex items-center justify-between border-b pb-3">
                            <div>
                                <p class="font-semibold text-gray-900">{{ $product->product_title }}</p>
                                <p class="text-sm text-gray-600">{{ $product->total_sold }} units sold</p>
                            </div>
                            <p class="text-green-600 font-bold">{{ number_format($product->total_revenue, 2) }} RON</p>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">No sales data available yet.</p>
                @endif
            </div>

            <!-- Produse cu stoc scăzut -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Low Stock Alert</h3>
                @if($lowStockProducts->count() > 0)
                    <div class="space-y-4">
                        @foreach($lowStockProducts as $product)
                        <div class="flex items-center justify-between border-b pb-3">
                            <div>
                                <p class="font-semibold text-gray-900">{{ $product->title }}</p>
                                <p class="text-sm text-gray-600">SKU: {{ $product->sku }}</p>
                            </div>
                            <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $product->stock == 0 ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $product->stock }} left
                            </span>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">All products have sufficient stock.</p>
                @endif
            </div>
        </div>

        <!-- Comenzi recente -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Recent Orders</h3>
            @if($recentOrders->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order #</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($recentOrders as $order)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #{{ $order->order_number }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->shipping_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ number_format($order->total_amount, 2) }} RON
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        @if($order->status === 'completed') bg-green-100 text-green-800
                                        @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                        @else bg-yellow-100 text-yellow-800
                                        @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->created_at->format('d M Y') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500">No orders yet.</p>
            @endif
        </div>

        @else
        <!-- Client Dashboard -->
        <div class="mb-6">
            <h2 class="text-3xl font-bold text-gray-900">My Dashboard</h2>
            <p class="text-gray-600 mt-1">{{ __("Welcome back!") }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-blue-100 p-6 rounded-lg shadow">
                <h3 class="font-bold text-lg text-gray-700">Total Orders</h3>
                <p class="text-3xl mt-2 font-bold text-blue-600">{{ $totalOrders }}</p>
            </div>
            <div class="bg-yellow-100 p-6 rounded-lg shadow">
                <h3 class="font-bold text-lg text-gray-700">Pending Orders</h3>
                <p class="text-3xl mt-2 font-bold text-yellow-600">{{ $pendingOrders }}</p>
            </div>
            <div class="bg-green-100 p-6 rounded-lg shadow">
                <h3 class="font-bold text-lg text-gray-700">Completed Orders</h3>
                <p class="text-3xl mt-2 font-bold text-green-600">{{ $completedOrders }}</p>
            </div>
            <div class="bg-purple-100 p-6 rounded-lg shadow">
                <h3 class="font-bold text-lg text-gray-700">Total Spent</h3>
                <p class="text-3xl mt-2 font-bold text-purple-600">{{ number_format($totalSpent, 2) }} RON</p>
            </div>
        </div>

        <!-- Comenzi recente client -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-4">My Recent Orders</h3>
            @if($recentOrders->count() > 0)
                <div class="space-y-4">
                    @foreach($recentOrders as $order)
                    <div class="border rounded-lg p-4 hover:shadow-md transition">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <p class="font-semibold text-gray-900">Order #{{ $order->order_number }}</p>
                                <p class="text-sm text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            </div>
                            <span class="px-3 py-1 text-sm font-semibold rounded-full 
                                @if($order->status === 'completed') bg-green-100 text-green-800
                                @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <p class="text-gray-700 font-bold">{{ number_format($order->total_amount, 2) }} RON</p>
                        <a href="{{ route('orders.show', $order) }}" class="text-blue-600 hover:text-blue-800 text-sm mt-2 inline-block">
                            View Details →
                        </a>
                    </div>
                    @endforeach
                </div>
                <a href="{{ route('orders.index') }}" class="mt-4 inline-block text-blue-600 hover:text-blue-800 font-semibold">
                    View All Orders →
                </a>
            @else
                <p class="text-gray-500">You haven't placed any orders yet.</p>
                <a href="{{ route('shop') }}" class="mt-4 inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    Start Shopping
                </a>
            @endif
        </div>
        @endif
    </div>
</x-app-layout>