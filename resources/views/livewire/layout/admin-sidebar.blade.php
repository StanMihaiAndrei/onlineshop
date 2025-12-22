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

<div x-data="{ open: true, mobileOpen: false, nomenclaturesOpen: false }" 
     @toggle-mobile-menu.window="mobileOpen = !mobileOpen"
     class="relative">
    
    <!-- Overlay for mobile -->
    <div x-show="mobileOpen" 
         @click="mobileOpen = false"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden"
         style="display: none;">
    </div>

    <!-- Sidebar -->
    <aside :class="{
        'w-64': open,
        'w-20': !open,
        'translate-x-0': mobileOpen,
        '-translate-x-full': !mobileOpen
    }" 
    class="bg-gray-800 text-white min-h-screen lg:h-screen transition-all duration-300 flex flex-col fixed lg:sticky lg:top-0 z-40 lg:translate-x-0 lg:overflow-y-auto">
        <!-- Logo & Toggle -->
        <div class="p-4 flex items-center justify-between border-b border-gray-700 flex-shrink-0">
            <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center space-x-2">
                {{-- <x-application-logo class="block h-9 w-auto fill-current text-white" /> --}}
                <span x-show="open" class="font-bold text-lg">Panou admin</span>
            </a>
            <button @click="open = !open" class="text-gray-400 hover:text-white hidden lg:block">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            <button @click="mobileOpen = false" class="text-gray-400 hover:text-white lg:hidden">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 px-2 py-4 space-y-2 overflow-y-auto">
            <a href="{{ route('dashboard') }}" wire:navigate 
               @click="mobileOpen = false"
               class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition {{ request()->routeIs('dashboard') ? 'bg-gray-700' : '' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span x-show="open">Panou</span>
            </a>

            <a href="{{ route('admin.products.index') }}" wire:navigate 
               @click="mobileOpen = false"
               class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition {{ request()->routeIs('admin.products.*') ? 'bg-gray-700' : '' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <span x-show="open">Produse</span>
            </a>

            <a href="{{ route('admin.orders.index') }}" wire:navigate 
               @click="mobileOpen = false"
               class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition {{ request()->routeIs('admin.orders.*') ? 'bg-gray-700' : '' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <span x-show="open">Comenzi</span>
            </a>

            <a href="{{ route('admin.users.index') }}" wire:navigate 
               @click="mobileOpen = false"
               class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition {{ request()->routeIs('admin.users.*') ? 'bg-gray-700' : '' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <span x-show="open">Utilizatori</span>
            </a>

            <a href="{{ route('admin.coupons.index') }}" wire:navigate 
               @click="mobileOpen = false"
               class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition {{ request()->routeIs('admin.coupons.*') ? 'bg-gray-700' : '' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                </svg>
                <span x-show="open">Cupoane reducere</span>
            </a>

            <!-- Nomenclatoare Dropdown -->
            <div class="space-y-1">
                <button @click="nomenclaturesOpen = !nomenclaturesOpen" 
                        class="w-full flex items-center justify-between px-4 py-3 rounded-lg hover:bg-gray-700 transition {{ request()->routeIs('admin.colors.*') || request()->routeIs('admin.categories.*') ? 'bg-gray-700' : '' }}">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <span x-show="open">Nomenclatoare</span>
                    </div>
                    <svg x-show="open" 
                         :class="{'rotate-180': nomenclaturesOpen}" 
                         class="w-4 h-4 transition-transform" 
                         fill="none" 
                         stroke="currentColor" 
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <!-- Dropdown Items -->
                <div x-show="nomenclaturesOpen && open" 
                     x-collapse
                     class="ml-8 space-y-1">
                    <a href="{{ route('admin.colors.index') }}" wire:navigate 
                       @click="mobileOpen = false"
                       class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-gray-700 transition text-sm {{ request()->routeIs('admin.colors.*') ? 'bg-gray-700' : '' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                        </svg>
                        <span>Culori</span>
                    </a>

                    <a href="{{ route('admin.categories.index') }}" wire:navigate 
                       @click="mobileOpen = false"
                       class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-gray-700 transition text-sm {{ request()->routeIs('admin.categories.*') ? 'bg-gray-700' : '' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        <span>Categorii</span>
                    </a>
                </div>
            </div>
        </nav>

        <!-- User Info & Logout -->
        <div class="p-4 border-t border-gray-700 flex-shrink-0">
            <div x-show="open" class="mb-3">
                <div class="text-sm font-medium">{{ auth()->user()->name }}</div>
                <div class="text-xs text-gray-400">{{ auth()->user()->email }}</div>
            </div>
            <button wire:click="logout" class="flex items-center space-x-3 px-4 py-2 w-full rounded-lg hover:bg-gray-700 transition text-red-400 hover:text-red-300">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                <span x-show="open">Logout</span>
            </button>
        </div>
    </aside>
</div>