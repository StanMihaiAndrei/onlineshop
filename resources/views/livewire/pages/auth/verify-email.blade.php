<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public function sendVerification(): void
    {
        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
            return;
        }

        Auth::user()->sendEmailVerificationNotification();
        Session::flash('status', 'verification-link-sent');
    }

    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }
}; ?>

<div class="flex justify-center items-center min-h-screen py-32 px-4 sm:px-6 lg:px-8" style="background: linear-gradient(135deg, rgba(219, 28, 181, 0.05) 0%, rgba(255, 255, 255, 1) 100%);">
    <div class="w-full max-w-md">
        <!-- Card Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full mb-4" style="background-color: rgba(219, 28, 181, 0.1);">
                <svg class="w-10 h-10" style="color: rgb(219, 28, 181);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-2" style="font-family: 'Playfair Display', serif;">Verifică Email-ul</h1>
            <p class="text-gray-600">Un pas mai e până finalizăm înregistrarea</p>
        </div>

        <!-- Card -->
        <div class="bg-white px-8 py-10 shadow-2xl rounded-2xl border border-gray-100">
            <div class="space-y-6">
                <!-- Info Message -->
                <div class="text-center">
                    <p class="text-gray-600 leading-relaxed">
                        Mulțumim pentru înregistrare! Înainte de a continua, te rugăm să verifici adresa de email făcând click pe link-ul pe care tocmai ți l-am trimis. 
                    </p>
                    <p class="text-gray-600 leading-relaxed mt-3">
                        Dacă nu ai primit email-ul, cu plăcere îți vom trimite unul nou.
                    </p>
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <div class="flex">
                            <svg class="h-5 w-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-sm font-medium text-green-800">
                                Un nou link de verificare a fost trimis la adresa de email pe care ai furnizat-o la înregistrare.
                            </p>
                        </div>
                    </div>
                @endif

                <!-- Actions -->
                <div class="flex flex-col gap-3 pt-4">
                    <button wire:click="sendVerification" class="w-full text-white px-6 py-3 rounded-lg transition-all transform hover:scale-105 font-semibold shadow-lg" style="background-color: rgb(219, 28, 181);" onmouseover="this.style.backgroundColor='rgb(180, 20, 145)'" onmouseout="this.style.backgroundColor='rgb(219, 28, 181)'">
                        Retrimite Email de Verificare
                    </button>

                    <button wire:click="logout" type="button" class="w-full border-2 border-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-50 transition-all font-semibold">
                        Deconectează-te
                    </button>
                </div>
            </div>
        </div>

        <!-- Additional Info -->
        <div class="text-center mt-6">
            <p class="text-sm text-gray-600">
                Verifică și folderul de spam/junk dacă nu găsești email-ul
            </p>
        </div>
    </div>
</div>