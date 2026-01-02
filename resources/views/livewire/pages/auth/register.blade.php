<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        event(new Registered($user = User::create($validated)));
        Auth::login($user);
        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="flex justify-center items-center min-h-screen py-32 px-4 sm:px-6 lg:px-8" style="background: linear-gradient(135deg, rgba(219, 28, 181, 0.05) 0%, rgba(255, 255, 255, 1) 100%);">
    <div class="w-full max-w-md">
        <!-- Card Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2" style="font-family: 'Playfair Display', serif;">Creează cont nou</h1>
            <p class="text-gray-600">Alătură-te comunității Craft Gifts</p>
        </div>

        <!-- Card -->
        <div class="bg-white px-8 py-10 shadow-2xl rounded-2xl border border-gray-100">
            <form wire:submit="register" class="space-y-6">
                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Nume')" class="text-gray-700 font-semibold mb-2" />
                    <x-text-input 
                        wire:model="name" 
                        id="name" 
                        class="block mt-1 w-full px-4 py-3 rounded-lg border-gray-300 focus:border-[rgb(219,28,181)] focus:ring focus:ring-[rgb(219,28,181)] focus:ring-opacity-50 transition-all" 
                        type="text" 
                        name="name" 
                        required 
                        autofocus 
                        autocomplete="name"
                        placeholder="Numele tău complet"
                    />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

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
                        autocomplete="username"
                        placeholder="adresa@email.com"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Parolă')" class="text-gray-700 font-semibold mb-2" />
                    <x-text-input 
                        wire:model="password" 
                        id="password" 
                        class="block mt-1 w-full px-4 py-3 rounded-lg border-gray-300 focus:border-[rgb(219,28,181)] focus:ring focus:ring-[rgb(219,28,181)] focus:ring-opacity-50 transition-all" 
                        type="password" 
                        name="password" 
                        required 
                        autocomplete="new-password"
                        placeholder="••••••••"
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirmă Parola')" class="text-gray-700 font-semibold mb-2" />
                    <x-text-input 
                        wire:model="password_confirmation" 
                        id="password_confirmation" 
                        class="block mt-1 w-full px-4 py-3 rounded-lg border-gray-300 focus:border-[rgb(219,28,181)] focus:ring focus:ring-[rgb(219,28,181)] focus:ring-opacity-50 transition-all" 
                        type="password" 
                        name="password_confirmation" 
                        required 
                        autocomplete="new-password"
                        placeholder="••••••••"
                    />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" class="w-full text-white px-6 py-3 rounded-lg transition-all transform hover:scale-105 font-semibold text-lg shadow-lg" style="background-color: rgb(219, 28, 181);" onmouseover="this.style.backgroundColor='rgb(180, 20, 145)'" onmouseout="this.style.backgroundColor='rgb(219, 28, 181)'">
                        Creează Cont
                    </button>
                </div>

                <!-- Login Link -->
                <div class="text-center pt-4 border-t border-gray-200">
                    <p class="text-gray-600">
                        Ai deja un cont? 
                        <a href="{{ route('login') }}" wire:navigate class="font-semibold transition-colors" style="color: rgb(219, 28, 181);" onmouseover="this.style.color='rgb(180, 20, 145)'" onmouseout="this.style.color='rgb(219, 28, 181)'">
                            Autentifică-te aici
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