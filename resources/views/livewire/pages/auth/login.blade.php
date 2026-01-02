<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    public function login(): void
    {
        $this->validate();
        $this->form->authenticate();
        Session::regenerate();
        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="flex justify-center items-center min-h-screen py-32 px-4 sm:px-6 lg:px-8" style="background: linear-gradient(135deg, rgba(219, 28, 181, 0.05) 0%, rgba(255, 255, 255, 1) 100%);">
    <div class="w-full max-w-md">
        <!-- Card Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2" style="font-family: 'Playfair Display', serif;">Bine ai revenit!</h1>
            <p class="text-gray-600">Autentifică-te pentru a continua</p>
        </div>

        <!-- Card -->
        <div class="bg-white px-8 py-10 shadow-2xl rounded-2xl border border-gray-100">
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form wire:submit="login" class="space-y-6">
                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-semibold mb-2" />
                    <x-text-input 
                        wire:model="form.email" 
                        id="email" 
                        class="block mt-1 w-full px-4 py-3 rounded-lg border-gray-300 focus:border-[rgb(219,28,181)] focus:ring focus:ring-[rgb(219,28,181)] focus:ring-opacity-50 transition-all" 
                        type="email" 
                        name="email" 
                        required 
                        autofocus 
                        autocomplete="username" 
                        placeholder="adresa@email.com"
                    />
                    <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Parolă')" class="text-gray-700 font-semibold mb-2" />
                    <x-text-input 
                        wire:model="form.password" 
                        id="password" 
                        class="block mt-1 w-full px-4 py-3 rounded-lg border-gray-300 focus:border-[rgb(219,28,181)] focus:ring focus:ring-[rgb(219,28,181)] focus:ring-opacity-50 transition-all" 
                        type="password" 
                        name="password" 
                        required 
                        autocomplete="current-password"
                        placeholder="••••••••"
                    />
                    <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label for="remember" class="inline-flex items-center cursor-pointer">
                        <input 
                            wire:model="form.remember" 
                            id="remember" 
                            type="checkbox" 
                            class="rounded border-gray-300 shadow-sm focus:ring-[rgb(219,28,181)] cursor-pointer" 
                            style="color: rgb(219, 28, 181);"
                            name="remember"
                        >
                        <span class="ms-2 text-sm text-gray-600 font-medium">Ține-mă minte</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm font-medium transition-colors" style="color: rgb(219, 28, 181);" onmouseover="this.style.color='rgb(180, 20, 145)'" onmouseout="this.style.color='rgb(219, 28, 181)'" href="{{ route('password.request') }}" wire:navigate>
                            Ai uitat parola?
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" class="w-full text-white px-6 py-3 rounded-lg transition-all transform hover:scale-105 font-semibold text-lg shadow-lg" style="background-color: rgb(219, 28, 181);" onmouseover="this.style.backgroundColor='rgb(180, 20, 145)'" onmouseout="this.style.backgroundColor='rgb(219, 28, 181)'">
                        Autentifică-te
                    </button>
                </div>

                <!-- Register Link -->
                <div class="text-center pt-4 border-t border-gray-200">
                    <p class="text-gray-600">
                        Nu ai un cont? 
                        <a href="{{ route('register') }}" wire:navigate class="font-semibold transition-colors" style="color: rgb(219, 28, 181);" onmouseover="this.style.color='rgb(180, 20, 145)'" onmouseout="this.style.color='rgb(219, 28, 181)'">
                            Înregistrează-te aici
                        </a>
                    </p>
                </div>
            </form>
        </div>

        <!-- Additional Info -->
        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="text-sm text-gray-600 transition-colors" style="text-decoration: none;" onmouseover="this.style.color='rgb(219, 28, 181)'" onmouseout="this.style.color='rgb(107, 114, 128)'">
                ← Înapoi la pagina principală
            </a>
        </div>
    </div>
</div>