<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Toate Comenzile</h2>
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
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Comanda #</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Client</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stare</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Plată</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Data</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acțiuni</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($orders as $order)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $order->order_number }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            @if($order->user)
                                                {{ $order->user->name }}
                                            @else
                                                <span class="text-gray-500">Invitat</span>
                                            @endif
                                            <br>
                                            <span class="text-xs text-gray-500">{{ $order->shipping_email }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            RON {{ number_format($order->total_amount, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                                                {{ $order->status === 'delivering' ? 'bg-purple-100 text-purple-800' : '' }}
                                                {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                                {{ $order->status_label }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $order->payment_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $order->payment_status === 'failed' ? 'bg-red-100 text-red-800' : '' }}">
                                                {{ $order->payment_status_label }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $order->created_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:text-blue-900">Vezi Detalii</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">Nu s-au găsit comenzi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Card View -->
                    <div class="lg:hidden space-y-4">
                        @forelse($orders as $order)
                            <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $order->order_number }}</p>
                                        <p class="text-sm text-gray-600">
                                            @if($order->user)
                                                {{ $order->user->name }}
                                            @else
                                                Invitat
                                            @endif
                                        </p>
                                    </div>
                                    <span class="text-lg font-bold text-gray-900">RON {{ number_format($order->total_amount, 2) }}</span>
                                </div>
                                
                                <div class="space-y-2 mb-4">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500">Status:</span>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $order->status === 'delivering' ? 'bg-purple-100 text-purple-800' : '' }}
                                            {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ $order->status_label }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500">Plată:</span>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $order->payment_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $order->payment_status === 'failed' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ $order->payment_status_label }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500">Data:</span>
                                        <span class="text-gray-900">{{ $order->created_at->format('d/m/Y') }}</span>
                                    </div>
                                </div>

                                <a href="{{ route('admin.orders.show', $order) }}" class="block w-full text-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Vezi Detalii
                                </a>
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-500">Nu s-au găsit comenzi.</div>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>