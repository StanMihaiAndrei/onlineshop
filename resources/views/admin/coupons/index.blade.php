<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-900">Coupons</h1>
                <a href="{{ route('admin.coupons.create') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition">
                    + Add New Coupon
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Code</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Value</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Valid Period</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Usage</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($coupons as $coupon)
                            <tr>
                                <td class="px-6 py-4">
                                    <span class="font-mono font-bold text-blue-600">{{ $coupon->code }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs rounded-full {{ $coupon->type === 'percentage' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($coupon->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-semibold">
                                    @if($coupon->type === 'percentage')
                                        {{ $coupon->value }}%
                                    @else
                                        ${{ number_format($coupon->value, 2) }}
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    @if($coupon->valid_from || $coupon->valid_until)
                                        <div>
                                            @if($coupon->valid_from)
                                                From: {{ $coupon->valid_from->format('M d, Y') }}<br>
                                            @endif
                                            @if($coupon->valid_until)
                                                Until: {{ $coupon->valid_until->format('M d, Y') }}
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-gray-400">Permanent</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    {{ $coupon->usage_count }}
                                    @if($coupon->usage_limit)
                                        / {{ $coupon->usage_limit }}
                                    @else
                                        / ∞
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs rounded-full {{ $coupon->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $coupon->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="{{ route('admin.coupons.edit', $coupon) }}" 
                                       class="text-blue-600 hover:text-blue-900">Edit</a>
                                    <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('Are you sure?')"
                                                class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                    No coupons found. Create your first coupon!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $coupons->links() }}
            </div>
        </div>
    </div>
</x-app-layout>