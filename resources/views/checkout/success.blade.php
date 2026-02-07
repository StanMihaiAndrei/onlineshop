<x-app-layout>
    <div class="py-12" style="background-color: var(--color-background);">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <div class="mb-6">
                    <svg class="w-20 h-20 mx-auto" style="color: var(--color-primary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>

                <h1 class="text-3xl font-bold mb-2" style="color: var(--color-text);">Comanda plasată cu succes!</h1>
                <p class="mb-6" style="color: var(--color-text); opacity: 0.7;">Vă mulțumim pentru comandă. Vă vom trimite un e-mail de confirmare în scurt timp.</p>

                <div class="rounded-lg p-6 mb-8" style="background-color: var(--color-background);">
                    <div class="grid grid-cols-2 gap-4 text-left">
                        <div>
                            <p class="text-sm" style="color: var(--color-text); opacity: 0.7;">Număr comandă</p>
                            <p class="font-semibold" style="color: var(--color-text);">{{ $order->order_number }}</p>
                        </div>
                        <div>
                            <p class="text-sm" style="color: var(--color-text); opacity: 0.7;">Sumă totală</p>
                            <p class="font-semibold" style="color: var(--color-text);">RON {{ number_format($order->total_amount, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-sm" style="color: var(--color-text); opacity: 0.7;">Metoda de plată</p>
                            <p class="font-semibold" style="color: var(--color-text);">
                                @if($order->payment_method === 'card')
                                    Card
                                @else
                                    Ramburs
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm" style="color: var(--color-text); opacity: 0.7;">Status</p>
                            <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full" 
                                style="background-color: var(--color-primary-light); color: var(--color-primary);">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="space-y-3">
                    @auth
                        <a href="{{ route('orders.index') }}" 
                            class="block w-full text-white font-semibold py-3 px-6 rounded-lg transition hover:opacity-90"
                            style="background-color: var(--color-primary);">
                            Vezi comenzile mele
                        </a>
                    @else
                        <a href="{{ route('register') }}" 
                            class="block w-full text-white font-semibold py-3 px-6 rounded-lg transition hover:opacity-90"
                            style="background-color: var(--color-primary);">
                            Creează un cont pentru a vedea detaliile comenzilor viitoare
                        </a>
                    @endauth
                    <a href="{{ route('shop') }}" 
                        class="block w-full font-semibold py-3 px-6 rounded-lg transition hover:opacity-90"
                        style="background-color: var(--color-secondary); color: white;">
                        Continuă cumpărăturile
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>