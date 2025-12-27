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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between transition-all duration-300" :class="scrolled ? 'h-20' : 'h-28'">
                <div class="flex items-center">
                    <!-- Logo - Mult Mai Mare -->
                    <div class="shrink-0 flex items-center transition-all duration-300">
                        <a href="{{ route('home') }}" wire:navigate class="flex items-center group">
                            <img src="{{ asset('images/transparent.png') }}" 
                                 alt="Craft Gifts Logo" 
                                 :class="scrolled ? 'h-16' : 'h-24'"
                                 class="w-auto transition-all duration-300 group-hover:scale-105">
                        </a>
                    </div>

                    <!-- Navigation Links - Desktop -->
                    <div class="hidden md:flex md:items-center md:space-x-1 md:ml-10">
                        @auth
                            @if(auth()->user()->role === 'client')
                                <!-- Meniu pentru CLIENȚI -->
                                <a href="{{ route('home') }}" wire:navigate 
                                   class="inline-flex items-center px-4 py-2 text-sm font-medium transition-all duration-200 relative {{ request()->routeIs('home') ? 'text-pink-600 font-bold' : 'text-gray-700 hover:text-pink-600' }}">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                    {{ __('Home') }}
                                    @if(request()->routeIs('home'))
                                        <span class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 w-3/4 h-0.5 bg-gradient-to-r from-pink-600 to-purple-600 rounded-full"></span>
                                    @endif
                                </a>
                                
                                <a href="{{ route('dashboard') }}" wire:navigate 
                                   class="inline-flex items-center px-4 py-2 text-sm font-medium transition-all duration-200 relative {{ request()->routeIs('dashboard') ? 'text-pink-600 font-bold' : 'text-gray-700 hover:text-pink-600' }}">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    {{ __('My Account') }}
                                    @if(request()->routeIs('dashboard'))
                                        <span class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 w-3/4 h-0.5 bg-gradient-to-r from-pink-600 to-purple-600 rounded-full"></span>
                                    @endif
                                </a>
                                
                                <a href="{{ route('shop') }}" wire:navigate 
                                   class="inline-flex items-center px-4 py-2 text-sm font-medium transition-all duration-200 relative {{ request()->routeIs('shop*') ? 'text-pink-600 font-bold' : 'text-gray-700 hover:text-pink-600' }}">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                    {{ __('Shop') }}
                                    @if(request()->routeIs('shop*'))
                                        <span class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 w-3/4 h-0.5 bg-gradient-to-r from-pink-600 to-purple-600 rounded-full"></span>
                                    @endif
                                </a>

                                <a href="{{ route('about') }}" wire:navigate 
                                   class="inline-flex items-center px-4 py-2 text-sm font-medium transition-all duration-200 relative {{ request()->routeIs('about') ? 'text-pink-600 font-bold' : 'text-gray-700 hover:text-pink-600' }}">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ __('Despre Noi') }}
                                    @if(request()->routeIs('about'))
                                        <span class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 w-3/4 h-0.5 bg-gradient-to-r from-pink-600 to-purple-600 rounded-full"></span>
                                    @endif
                                </a>

                                <a href="{{ route('contact') }}" wire:navigate 
                                   class="inline-flex items-center px-4 py-2 text-sm font-medium transition-all duration-200 relative {{ request()->routeIs('contact') ? 'text-pink-600 font-bold' : 'text-gray-700 hover:text-pink-600' }}">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    {{ __('Contact') }}
                                    @if(request()->routeIs('contact'))
                                        <span class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 w-3/4 h-0.5 bg-gradient-to-r from-pink-600 to-purple-600 rounded-full"></span>
                                    @endif
                                </a>
                                
                                <a href="{{ route('orders.index') }}" wire:navigate 
                                   class="inline-flex items-center px-4 py-2 text-sm font-medium transition-all duration-200 relative {{ request()->routeIs('orders*') ? 'text-pink-600 font-bold' : 'text-gray-700 hover:text-pink-600' }}">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    {{ __('My Orders') }}
                                    @if(request()->routeIs('orders*'))
                                        <span class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 w-3/4 h-0.5 bg-gradient-to-r from-pink-600 to-purple-600 rounded-full"></span>
                                    @endif
                                </a>
                            @endif
                        @else
                            <!-- Meniu pentru GUEST -->
                            <a href="{{ route('home') }}" wire:navigate 
                               class="inline-flex items-center px-4 py-2 text-sm font-medium transition-all duration-200 relative {{ request()->routeIs('home') ? 'text-pink-600 font-bold' : 'text-gray-700 hover:text-pink-600' }}">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                {{ __('Home') }}
                                @if(request()->routeIs('home'))
                                    <span class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 w-3/4 h-0.5 bg-gradient-to-r from-pink-600 to-purple-600 rounded-full"></span>
                                @endif
                            </a>
                            
                            <a href="{{ route('shop') }}" wire:navigate 
                               class="inline-flex items-center px-4 py-2 text-sm font-medium transition-all duration-200 relative {{ request()->routeIs('shop*') ? 'text-pink-600 font-bold' : 'text-gray-700 hover:text-pink-600' }}">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                                {{ __('Shop') }}
                                @if(request()->routeIs('shop*'))
                                    <span class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 w-3/4 h-0.5 bg-gradient-to-r from-pink-600 to-purple-600 rounded-full"></span>
                                @endif
                            </a>
                            
                            <a href="{{ route('about') }}" wire:navigate 
                               class="inline-flex items-center px-4 py-2 text-sm font-medium transition-all duration-200 relative {{ request()->routeIs('about') ? 'text-pink-600 font-bold' : 'text-gray-700 hover:text-pink-600' }}">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ __('Despre Noi') }}
                                @if(request()->routeIs('about'))
                                    <span class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 w-3/4 h-0.5 bg-gradient-to-r from-pink-600 to-purple-600 rounded-full"></span>
                                @endif
                            </a>
                            
                            <a href="{{ route('contact') }}" wire:navigate 
                               class="inline-flex items-center px-4 py-2 text-sm font-medium transition-all duration-200 relative {{ request()->routeIs('contact') ? 'text-pink-600 font-bold' : 'text-gray-700 hover:text-pink-600' }}">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                {{ __('Contact') }}
                                @if(request()->routeIs('contact'))
                                    <span class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 w-3/4 h-0.5 bg-gradient-to-r from-pink-600 to-purple-600 rounded-full"></span>
                                @endif
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Right Side - Cart & Auth Buttons -->
                <div class="flex items-center gap-3">
                     <!-- Wishlist -->
                    <livewire:wishlist-component />
                    
                    <!-- Shopping Cart -->
                    <livewire:cart />

                    @guest
                        <!-- Guest Auth Buttons - Desktop -->
                        <div class="hidden md:flex items-center gap-3">
                            <a href="{{ route('login') }}" wire:navigate 
                               class="inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 hover:text-pink-600 transition-colors duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                </svg>
                                {{ __('Login') }}
                            </a>
                            <a href="{{ route('register') }}" wire:navigate 
                               class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-pink-600 to-purple-600 text-white text-sm font-semibold rounded-full hover:shadow-lg hover:scale-105 transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                </svg>
                                {{ __('Register') }}
                            </a>
                        </div>
                    @else
                        <!-- Settings Dropdown - Desktop -->
                        <div class="hidden md:block">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-4 py-2 border border-gray-200 text-sm leading-4 font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50 hover:border-pink-300 focus:outline-none transition-all duration-200">
                                        <svg class="w-5 h-5 mr-2 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                        {{ __('Profile') }}
                                    </x-dropdown-link>
                                    <button wire:click="logout" class="w-full text-start">
                                        <x-dropdown-link>
                                            <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                            </svg>
                                            {{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </button>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @endguest

                    <!-- Hamburger - Mobile -->
                    <div class="md:hidden">
                        <button @click="open = ! open" 
                                class="inline-flex items-center justify-center p-2 rounded-lg text-gray-600 hover:text-pink-600 hover:bg-pink-50 focus:outline-none focus:bg-pink-50 transition-all duration-200">
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
             class="md:hidden border-t border-gray-100 bg-white shadow-lg">
            
            <div class="px-4 pt-2 pb-3 space-y-1">
                @auth
                    @if(auth()->user()->role === 'client')
                        <!-- Meniu mobil pentru CLIENȚI -->
                        <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')" wire:navigate
                            class="{{ request()->routeIs('home') ? 'bg-pink-50 text-pink-600 border-l-4 border-pink-600' : '' }}">
                            <svg class="w-5 h-5 mr-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            {{ __('Home') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate
                            class="{{ request()->routeIs('dashboard') ? 'bg-pink-50 text-pink-600 border-l-4 border-pink-600' : '' }}">
                            <svg class="w-5 h-5 mr-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            {{ __('My Account') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('shop')" :active="request()->routeIs('shop*')" wire:navigate
                            class="{{ request()->routeIs('shop*') ? 'bg-pink-50 text-pink-600 border-l-4 border-pink-600' : '' }}">
                            <svg class="w-5 h-5 mr-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            {{ __('Shop') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('about')" :active="request()->routeIs('about')" wire:navigate
                            class="{{ request()->routeIs('about') ? 'bg-pink-50 text-pink-600 border-l-4 border-pink-600' : '' }}">
                            <svg class="w-5 h-5 mr-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ __('Despre Noi') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('contact')" :active="request()->routeIs('contact')" wire:navigate
                            class="{{ request()->routeIs('contact') ? 'bg-pink-50 text-pink-600 border-l-4 border-pink-600' : '' }}">
                            <svg class="w-5 h-5 mr-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            {{ __('Contact') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('orders.index')" :active="request()->routeIs('orders*')" wire:navigate
                            class="{{ request()->routeIs('orders*') ? 'bg-pink-50 text-pink-600 border-l-4 border-pink-600' : '' }}">
                            <svg class="w-5 h-5 mr-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            {{ __('My Orders') }}
                        </x-responsive-nav-link>
                    @endif
                @else
                    <!-- Meniu mobil pentru GUEST -->
                    <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')" wire:navigate
                        class="{{ request()->routeIs('home') ? 'bg-pink-50 text-pink-600 border-l-4 border-pink-600' : '' }}">
                        <svg class="w-5 h-5 mr-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        {{ __('Home') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('shop')" :active="request()->routeIs('shop*')" wire:navigate
                        class="{{ request()->routeIs('shop*') ? 'bg-pink-50 text-pink-600 border-l-4 border-pink-600' : '' }}">
                        <svg class="w-5 h-5 mr-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        {{ __('Shop') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('about')" :active="request()->routeIs('about')" wire:navigate
                        class="{{ request()->routeIs('about') ? 'bg-pink-50 text-pink-600 border-l-4 border-pink-600' : '' }}">
                        <svg class="w-5 h-5 mr-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ __('Despre Noi') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('contact')" :active="request()->routeIs('contact')" wire:navigate
                        class="{{ request()->routeIs('contact') ? 'bg-pink-50 text-pink-600 border-l-4 border-pink-600' : '' }}">
                        <svg class="w-5 h-5 mr-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        {{ __('Contact') }}
                    </x-responsive-nav-link>

                    <!-- Auth Buttons Mobile -->
                    <div class="pt-4 border-t border-gray-200 space-y-2">
                        <x-responsive-nav-link :href="route('login')" wire:navigate>
                            <svg class="w-5 h-5 mr-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                            {{ __('Login') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('register')" wire:navigate class="!bg-gradient-to-r !from-pink-600 !to-purple-600 !text-white hover:!shadow-lg">
                            <svg class="w-5 h-5 mr-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                            {{ __('Register') }}
                        </x-responsive-nav-link>
                    </div>
                @endauth
            </div>

            <!-- Responsive Settings Options -->
            @auth
            <div class="pt-4 pb-3 border-t border-gray-200 bg-gray-50">
                <div class="px-4 mb-3">
                    <div class="font-medium text-base text-gray-800 flex items-center"
                        x-data="{{ json_encode(['name' => auth()->user()->name]) }}"
                        x-on:profile-updated.window="name = $event.detail.name">
                        <svg class="w-8 h-8 mr-3 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        {{ __('Profile') }}
                    </x-responsive-nav-link>
                    <button wire:click="logout" class="w-full text-start">
                        <x-responsive-nav-link>
                            <svg class="w-5 h-5 mr-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </button>
                </div>
            </div>
            @endauth
        </div>
    </nav>

    <!-- Spacer pentru ca sticky nav să nu ascundă conținutul -->
    <div class="h-28"></div>
</div>