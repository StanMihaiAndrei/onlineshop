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

<div x-data="{ open: true }" class="relative">
    <!-- Sidebar -->
    <aside :class="open ? 'w-64' : 'w-20'" class="bg-gray-800 text-white min-h-screen transition-all duration-300 flex flex-col">
        <!-- Logo & Toggle -->
        <div class="p-4 flex items-center justify-between border-b border-gray-700">
            <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center space-x-2">
                <x-application-logo class="block h-9 w-auto fill-current text-white" />
                <span x-show="open" class="font-bold text-lg">Admin Panel</span>
            </a>
            <button @click="open = !open" class="text-gray-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 px-2 py-4 space-y-2">
            <a href="{{ route('dashboard') }}" wire:navigate 
               class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition {{ request()->routeIs('dashboard') ? 'bg-gray-700' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span x-show="open">Dashboard</span>
            </a>

            <a href="{{ route('admin.products') }}" wire:navigate 
               class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition {{ request()->routeIs('admin.products') ? 'bg-gray-700' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <span x-show="open">Products</span>
            </a>

            <a href="{{ route('admin.orders') }}" wire:navigate 
               class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition {{ request()->routeIs('admin.orders') ? 'bg-gray-700' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <span x-show="open">Orders</span>
            </a>
        </nav>

        <!-- User Info & Logout -->
        <div class="p-4 border-t border-gray-700">
            <div x-show="open" class="mb-3">
                <div class="text-sm font-medium">{{ auth()->user()->name }}</div>
                <div class="text-xs text-gray-400">{{ auth()->user()->email }}</div>
            </div>
            <button wire:click="logout" class="flex items-center space-x-3 px-4 py-2 w-full rounded-lg hover:bg-gray-700 transition text-red-400 hover:text-red-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                <span x-show="open">Logout</span>
            </button>
        </div>
    </aside>
</div>