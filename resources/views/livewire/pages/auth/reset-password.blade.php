<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    #[Locked]
    public string $token = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function mount(string $token): void
    {
        $this->token = $token;
        $this->email = request()->string('email');
    }

    public function resetPassword(): void
    {
        $this->validate([
            'token' => ['required'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) {
                $user->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])->save();
                event(new PasswordReset($user));
            }
        );

        if ($status != Password::PASSWORD_RESET) {
            $this->addError('email', __($status));
            return;
        }

        Session::flash('status', __($status));
        $this->redirectRoute('login', navigate: true);
    }
}; ?>

<div class="flex justify-center items-center min-h-screen py-32 px-4 sm:px-6 lg:px-8" style="background: linear-gradient(135deg, rgba(219, 28, 181, 0.05) 0%, rgba(255, 255, 255, 1) 100%);">
    <div class="w-full max-w-md">
        <!-- Card Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2" style="font-family: 'Playfair Display', serif;">Resetare Parolă</h1>
            <p class="text-gray-600">Introdu noua ta parolă</p>
        </div>

        <!-- Card -->
        <div class="bg-white px-8 py-10 shadow-2xl rounded-2xl border border-gray-100">
            <form wire:submit="resetPassword" class="space-y-6">
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
                        autocomplete="username"
                        placeholder="adresa@email.com"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Parolă Nouă')" class="text-gray-700 font-semibold mb-2" />
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
                        Resetează Parola
                    </button>
                </div>
            </form>
        </div>

        <!-- Additional Info -->
        <div class="text-center mt-6">
            <a href="{{ route('login') }}" wire:navigate class="text-sm text-gray-600 transition-colors" style="text-decoration: none;" onmouseover="this.style.color='rgb(219, 28, 181)'" onmouseout="this.style.color='rgb(107, 114, 128)'">
                ← Înapoi la autentificare
            </a>
        </div>
    </div>
</div>