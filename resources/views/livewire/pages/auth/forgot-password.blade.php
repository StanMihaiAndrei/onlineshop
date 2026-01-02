<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        $status = Password::sendResetLink($this->only('email'));

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));
            return;
        }

        $this->reset('email');
        session()->flash('status', __($status));
    }
}; ?>

<div class="flex justify-center items-center min-h-screen py-32 px-4 sm:px-6 lg:px-8" style="background: linear-gradient(135deg, rgba(219, 28, 181, 0.05) 0%, rgba(255, 255, 255, 1) 100%);">
    <div class="w-full max-w-md">
        <!-- Card Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full mb-4" style="background-color: rgba(219, 28, 181, 0.1);">
                <svg class="w-10 h-10" style="color: rgb(219, 28, 181);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-2" style="font-family: 'Playfair Display', serif;">Ai uitat parola?</h1>
            <p class="text-gray-600">Îți vom trimite un link de resetare</p>
        </div>

        <!-- Card -->
        <div class="bg-white px-8 py-10 shadow-2xl rounded-2xl border border-gray-100">
            <div class="space-y-6">
                <!-- Info Message -->
                <div class="text-center">
                    <p class="text-gray-600 leading-relaxed">
                        Nicio problemă! Introdu adresa ta de email și îți vom trimite un link prin care poți reseta parola și alege una nouă.
                    </p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form wire:submit="sendPasswordResetLink" class="space-y-6">
                    <!-- Email -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-semibold mb-2" />
                        <x-text-input 
                            wire:model="email" 
                            id="email" 
                            class="block mt-1 w-full px-4 py-3 rounded-lg border-gray-300 focus:border-[rgb(219,28,181)] focus:ring focus:ring-[rgb(219,28,181)] focus:ring-opacity-50 transition-all" 
                            type="email" 
                            name="email" 
                            required 
                            autofocus
                            placeholder="adresa@email.com"
                        />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" class="w-full text-white px-6 py-3 rounded-lg transition-all transform hover:scale-105 font-semibold text-lg shadow-lg" style="background-color: rgb(219, 28, 181);" onmouseover="this.style.backgroundColor='rgb(180, 20, 145)'" onmouseout="this.style.backgroundColor='rgb(219, 28, 181)'">
                            Trimite Link de Resetare
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Additional Info -->
        <div class="text-center mt-6">
            <a href="{{ route('login') }}" wire:navigate class="text-sm text-gray-600 transition-colors" style="text-decoration: none;" onmouseover="this.style.color='rgb(219, 28, 181)'" onmouseout="this.style.color='rgb(107, 114, 128)'">
                ← Înapoi la autentificare
            </a>
        </div>
    </div>
</div>