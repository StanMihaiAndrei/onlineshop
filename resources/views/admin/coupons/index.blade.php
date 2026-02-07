<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Cupoane reducere</h1>
                <a href="{{ route('admin.coupons.create') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-3 sm:px-4 py-2 rounded-lg font-medium transition text-sm sm:text-base">
                    <span class="hidden sm:inline">Adaugă cupon</span>
                    <span class="sm:hidden">Adaugă</span>
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Desktop Table View -->
            <div class="hidden lg:block bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cod</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tip</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Valoare</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Perioadă Valabilă</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Utilizare</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stare</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acțiuni</th>
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
                                        RON {{ number_format($coupon->value, 2) }}
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    @if($coupon->valid_from || $coupon->valid_until)
                                        <div>
                                            @if($coupon->valid_from)
                                                De la: {{ $coupon->valid_from->format('M d, Y') }}<br>
                                            @endif
                                            @if($coupon->valid_until)
                                                Până la: {{ $coupon->valid_until->format('M d, Y') }}
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
                                        {{ $coupon->is_active ? 'Activ' : 'Inactiv' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="{{ route('admin.coupons.edit', $coupon) }}" 
                                       class="text-blue-600 hover:text-blue-900">Editează</a>
                                    <form id="delete-form-{{ $coupon->id }}" 
                                          action="{{ route('admin.coupons.destroy', $coupon) }}" 
                                          method="POST" 
                                          class="inline"
                                          x-data
                                          @confirm-delete.window="if ($event.detail === 'coupon-{{ $coupon->id }}') $el.submit()">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                @click="$dispatch('open-modal', 'coupon-{{ $coupon->id }}')"
                                                class="text-red-600 hover:text-red-900">
                                            Șterge
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                    Nu s-au găsit cupoane. Creează primul tău cupon!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="lg:hidden space-y-4">
                @forelse($coupons as $coupon)
                    <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <p class="font-mono font-bold text-blue-600 text-lg">{{ $coupon->code }}</p>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="px-2 py-0.5 text-xs rounded-full {{ $coupon->type === 'percentage' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($coupon->type) }}
                                    </span>
                                    <span class="px-2 py-0.5 text-xs rounded-full {{ $coupon->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $coupon->is_active ? 'Activ' : 'Inactiv' }}
                                    </span>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold text-gray-900">
                                    @if($coupon->type === 'percentage')
                                        {{ $coupon->value }}%
                                    @else
                                        RON {{ number_format($coupon->value, 2) }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Usage:</span>
                                <span class="text-gray-900 font-medium">
                                    {{ $coupon->usage_count }}
                                    @if($coupon->usage_limit)
                                        / {{ $coupon->usage_limit }}
                                    @else
                                        / ∞
                                    @endif
                                </span>
                            </div>
                            @if($coupon->valid_from || $coupon->valid_until)
                                <div class="text-sm">
                                    <span class="text-gray-500">Perioadă Valabilă:</span>
                                    <div class="text-gray-900 mt-1">
                                        @if($coupon->valid_from)
                                            <div>De la: {{ $coupon->valid_from->format('M d, Y') }}</div>
                                        @endif
                                        @if($coupon->valid_until)
                                            <div>Până la: {{ $coupon->valid_until->format('M d, Y') }}</div>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Perioadă Valabilă:</span>
                                    <span class="text-gray-400">Permanent</span>
                                </div>
                            @endif
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('admin.coupons.edit', $coupon) }}" 
                               class="flex-1 text-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                                Editează
                            </a>
                            <form id="delete-form-mobile-{{ $coupon->id }}" 
                                  action="{{ route('admin.coupons.destroy', $coupon) }}" 
                                  method="POST" 
                                  class="flex-1"
                                  x-data
                                  @confirm-delete.window="if ($event.detail === 'coupon-mobile-{{ $coupon->id }}') $el.submit()">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        @click="$dispatch('open-modal', 'coupon-mobile-{{ $coupon->id }}')"
                                        class="w-full bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-sm">
                                    Șterge
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500 bg-white rounded-lg border border-gray-200">
                        Nu s-au găsit cupoane. Creează primul tău cupon!
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $coupons->links() }}
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modals -->
    @foreach($coupons as $coupon)
        <x-delete-confirmation-modal 
            modalId="coupon-{{ $coupon->id }}"
            title="Delete Coupon"
            message="Are you sure you want to delete coupon '{{ $coupon->code }}'? This action cannot be undone." />
        
        <x-delete-confirmation-modal 
            modalId="coupon-mobile-{{ $coupon->id }}"
            title="Delete Coupon"
            message="Are you sure you want to delete coupon '{{ $coupon->code }}'? This action cannot be undone." />
    @endforeach
</x-app-layout>