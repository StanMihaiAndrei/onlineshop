<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }
}; ?>

<div>
    <nav x-data="{ open: false, scrolled: false }" 
         x-init="window.addEventListener('scroll', () => { scrolled = window.pageYOffset > 20 })"
         :class="scrolled ? 'shadow-lg bg-white/95 backdrop-blur-md' : 'bg-white shadow-sm'"
         class="fixed w-full top-0 z-50 transition-all duration-300">
        
        <!-- Primary Navigation Menu -->
        <div class="max-w-[1920px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            <div class="flex justify-between items-center transition-all duration-300" :class="scrolled ? 'h-20' : 'h-28'">
                <!-- Logo - Mult Mai Mare și mai la dreapta -->
                <div class="flex-shrink-0 transition-all duration-300 lg:mr-12">
                    <a href="{{ route('home') }}" wire:navigate class="flex items-center group">
                        <img src="{{ asset('images/transparent.png') }}" 
                        alt="Craft Gifts Logo" 
                        :class="scrolled ? 'h-32' : 'h-40'"
                        width="160" 
                        height="160"
                        fetchpriority="high"
                        class="w-auto transition-all duration-300 group-hover:scale-105">
                    </a>
                </div>

                <!-- Navigation Links - Desktop - Centrat și mai spațios -->
                <div class="hidden lg:flex lg:items-center lg:space-x-2 flex-1 justify-center">
                    @auth
                        @if(auth()->user()->role === 'client')
                            <!-- Meniu pentru CLIENȚI -->
                            <a href="{{ route('home') }}" wire:navigate 
                               class="inline-flex items-center px-5 py-2.5 text-sm font-semibold transition-all duration-200 rounded-lg relative {{ request()->routeIs('home') ? 'text-primary bg-primary-light/30' : 'text-text hover:text-primary hover:bg-background' }}">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                Acasă
                            </a>
                            
                            <a href="{{ route('dashboard') }}" wire:navigate 
                               class="inline-flex items-center px-5 py-2.5 text-sm font-semibold transition-all duration-200 rounded-lg relative {{ request()->routeIs('dashboard') ? 'text-primary bg-primary-light/30' : 'text-text hover:text-primary hover:bg-background' }}">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Contul meu
                            </a>
                            
                            <a href="{{ route('shop') }}" wire:navigate 
                               class="inline-flex items-center px-5 py-2.5 text-sm font-semibold transition-all duration-200 rounded-lg relative {{ request()->routeIs('shop*') ? 'text-primary bg-primary-light/30' : 'text-text hover:text-primary hover:bg-background' }}">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                                Magazin
                            </a>

                            <a href="{{ route('about') }}" wire:navigate 
                               class="inline-flex items-center px-5 py-2.5 text-sm font-semibold transition-all duration-200 rounded-lg relative {{ request()->routeIs('about') ? 'text-primary bg-primary-light/30' : 'text-text hover:text-primary hover:bg-background' }}">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Despre noi
                            </a>

                            <a href="{{ route('contact') }}" wire:navigate 
                               class="inline-flex items-center px-5 py-2.5 text-sm font-semibold transition-all duration-200 rounded-lg relative {{ request()->routeIs('contact') ? 'text-primary bg-primary-light/30' : 'text-text hover:text-primary hover:bg-background' }}">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                Contact
                            </a>
                            
                            <a href="{{ route('orders.index') }}" wire:navigate 
                               class="inline-flex items-center px-5 py-2.5 text-sm font-semibold transition-all duration-200 rounded-lg relative {{ request()->routeIs('orders*') ? 'text-primary bg-primary-light/30' : 'text-text hover:text-primary hover:bg-background' }}">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                Comenzile mele
                            </a>
                        @endif
                    @else
                        <!-- Meniu pentru GUEST -->
                        <a href="{{ route('home') }}" wire:navigate 
                           class="inline-flex items-center px-5 py-2.5 text-sm font-semibold transition-all duration-200 rounded-lg relative {{ request()->routeIs('home') ? 'text-primary bg-primary-light/30' : 'text-text hover:text-primary hover:bg-background' }}">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            Acasă
                        </a>
                        
                        <a href="{{ route('shop') }}" wire:navigate 
                           class="inline-flex items-center px-5 py-2.5 text-sm font-semibold transition-all duration-200 rounded-lg relative {{ request()->routeIs('shop*') ? 'text-primary bg-primary-light/30' : 'text-text hover:text-primary hover:bg-background' }}">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            Magazin
                        </a>
                        
                        <a href="{{ route('about') }}" wire:navigate 
                           class="inline-flex items-center px-5 py-2.5 text-sm font-semibold transition-all duration-200 rounded-lg relative {{ request()->routeIs('about') ? 'text-primary bg-primary-light/30' : 'text-text hover:text-primary hover:bg-background' }}">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Despre noi
                        </a>
                        
                        <a href="{{ route('contact') }}" wire:navigate 
                           class="inline-flex items-center px-5 py-2.5 text-sm font-semibold transition-all duration-200 rounded-lg relative {{ request()->routeIs('contact') ? 'text-primary bg-primary-light/30' : 'text-text hover:text-primary hover:bg-background' }}">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Contact
                        </a>
                    @endauth
                </div>

                <!-- Right Side - Cart & Auth Buttons - mai la stânga -->
                <div class="flex items-center gap-3 lg:gap-4 lg:ml-12">
                     <!-- Wishlist -->
                    <livewire:wishlist-component />
                    
                    <!-- Shopping Cart -->
                    <livewire:cart />

                    @guest
                        <!-- Guest Auth Buttons - Desktop -->
                        <div class="hidden lg:flex items-center gap-3">
                            <a href="{{ route('login') }}" wire:navigate 
                               class="inline-flex items-center px-5 py-2.5 text-sm font-semibold text-text hover:text-primary hover:bg-background rounded-lg transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                </svg>
                                Autentificare
                            </a>
                            <a href="{{ route('register') }}" wire:navigate 
                               class="inline-flex items-center px-6 py-2.5 bg-primary text-white text-sm font-semibold rounded-full hover:bg-primary-dark hover:shadow-lg hover:scale-105 transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                </svg>
                                Înregistrare
                            </a>
                        </div>
                    @else
                        <!-- Settings Dropdown - Desktop -->
                        <div class="hidden lg:block">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-4 py-2.5 border-2 border-background text-sm leading-4 font-semibold rounded-full text-text bg-white hover:bg-background hover:border-primary focus:outline-none transition-all duration-200">
                                        <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                                        <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link :href="route('profile')" wire:navigate>
                                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        Profilul meu
                                    </x-dropdown-link>
                                    <button wire:click="logout" class="w-full text-start">
                                        <x-dropdown-link>
                                            <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                            </svg>
                                            Logout
                                        </x-dropdown-link>
                                    </button>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @endguest

                    <!-- Hamburger - Mobile -->
                    <div class="lg:hidden">
                        <button @click="open = ! open" 
                                class="inline-flex items-center justify-center p-2 rounded-lg text-text hover:text-primary hover:bg-primary-light/30 focus:outline-none focus:bg-primary-light/30 transition-all duration-200">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': ! open }" 
                                      class="inline-flex" 
                                      stroke-linecap="round" 
                                      stroke-linejoin="round" 
                                      stroke-width="2" 
                                      d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': ! open, 'inline-flex': open }" 
                                      class="hidden" 
                                      stroke-linecap="round" 
                                      stroke-linejoin="round" 
                                      stroke-width="2" 
                                      d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu - Mobile -->
        <div x-show="open" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 transform -translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform -translate-y-2"
             class="lg:hidden border-t border-gray-100 bg-white shadow-lg">
            
            <div class="px-4 pt-2 pb-3 space-y-1">
                @auth
                    @if(auth()->user()->role === 'client')
                        <!-- Meniu mobil pentru CLIENȚI -->
                        <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')" wire:navigate
                            class="{{ request()->routeIs('home') ? 'bg-primary-light/50 text-primary border-l-4 border-primary' : '' }}">
                            <svg class="w-5 h-5 mr-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            Acasă
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate
                            class="{{ request()->routeIs('dashboard') ? 'bg-primary-light/50 text-primary border-l-4 border-primary' : '' }}">
                            <svg class="w-5 h-5 mr-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Contul meu
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('shop')" :active="request()->routeIs('shop*')" wire:navigate
                            class="{{ request()->routeIs('shop*') ? 'bg-primary-light/50 text-primary border-l-4 border-primary' : '' }}">
                            <svg class="w-5 h-5 mr-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            Magazin
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('about')" :active="request()->routeIs('about')" wire:navigate
                            class="{{ request()->routeIs('about') ? 'bg-primary-light/50 text-primary border-l-4 border-primary' : '' }}">
                            <svg class="w-5 h-5 mr-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Despre noi
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('contact')" :active="request()->routeIs('contact')" wire:navigate
                            class="{{ request()->routeIs('contact') ? 'bg-primary-light/50 text-primary border-l-4 border-primary' : '' }}">
                            <svg class="w-5 h-5 mr-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Contact
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('orders.index')" :active="request()->routeIs('orders*')" wire:navigate
                            class="{{ request()->routeIs('orders*') ? 'bg-primary-light/50 text-primary border-l-4 border-primary' : '' }}">
                            <svg class="w-5 h-5 mr-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            Comenzile mele
                        </x-responsive-nav-link>
                    @endif
                @else
                    <!-- Meniu mobil pentru GUEST -->
                    <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')" wire:navigate
                        class="{{ request()->routeIs('home') ? 'bg-primary-light/50 text-primary border-l-4 border-primary' : '' }}">
                        <svg class="w-5 h-5 mr-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Acasă
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('shop')" :active="request()->routeIs('shop*')" wire:navigate
                        class="{{ request()->routeIs('shop*') ? 'bg-primary-light/50 text-primary border-l-4 border-primary' : '' }}">
                        <svg class="w-5 h-5 mr-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                       Magazin
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('about')" :active="request()->routeIs('about')" wire:navigate
                        class="{{ request()->routeIs('about') ? 'bg-primary-light/50 text-primary border-l-4 border-primary' : '' }}">
                        <svg class="w-5 h-5 mr-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Despre noi
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('contact')" :active="request()->routeIs('contact')" wire:navigate
                        class="{{ request()->routeIs('contact') ? 'bg-primary-light/50 text-primary border-l-4 border-primary' : '' }}">
                        <svg class="w-5 h-5 mr-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Contact
                    </x-responsive-nav-link>

                    <!-- Auth Buttons Mobile -->
                    <div class="pt-4 border-t border-gray-200 space-y-2">
                        <x-responsive-nav-link :href="route('login')" wire:navigate>
                            <svg class="w-5 h-5 mr-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                            Autentificare
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('register')" wire:navigate class="!bg-primary !text-white hover:!bg-primary-dark hover:!shadow-lg">
                            <svg class="w-5 h-5 mr-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                            Înregistrare
                        </x-responsive-nav-link>
                    </div>
                @endauth
            </div>

            <!-- Responsive Settings Options -->
            @auth
            <div class="pt-4 pb-3 border-t border-gray-200 bg-background/30">
                <div class="px-4 mb-3">
                    <div class="font-medium text-base text-text flex items-center"
                        x-data="{{ json_encode(['name' => auth()->user()->name]) }}"
                        x-on:profile-updated.window="name = $event.detail.name">
                        <svg class="w-8 h-8 mr-3 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span x-text="name"></span>
                    </div>
                    <div class="font-medium text-sm text-gray-500 ml-11">
                        {{ auth()->user()->email }}
                    </div>
                </div>

                <div class="space-y-1 px-4">
                    <x-responsive-nav-link :href="route('profile')" wire:navigate>
                        <svg class="w-5 h-5 mr-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Profilul meu
                    </x-responsive-nav-link>
                    <button wire:click="logout" class="w-full text-start">
                        <x-responsive-nav-link>
                            <svg class="w-5 h-5 mr-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Logout
                        </x-responsive-nav-link>
                    </button>
                </div>
            </div>
            @endauth
        </div>
    </nav>

    <!-- Spacer pentru ca sticky nav să nu ascundă conținutul -->
    <div class="h-28"></div>
    <!-- Cookie Banner -->
    <x-cookie-banner />
</div>