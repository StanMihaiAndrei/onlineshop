<?php

use Livewire\Volt\Component;

new class extends Component
{
    //
}; ?>

<div class="bg-white shadow-sm border-b border-gray-200">
    <div class="px-6 py-4">
        <div class="flex items-center justify-between">
            <!-- Mobile Menu Button (visible only on small screens) -->
            <button @click="$dispatch('toggle-mobile-menu')" class="lg:hidden p-2 rounded-lg text-gray-800 hover:bg-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

            <div>
                <h1 class="text-2xl font-semibold text-gray-800">
                    @if(request()->routeIs('dashboard'))
                        Admin Dashboard
                    @elseif(request()->routeIs('admin.products'))
                        Products Management
                    @elseif(request()->routeIs('admin.orders'))
                        Orders Management
                    @else
                        Admin Panel
                    @endif
                </h1>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-600">Welcome, {{ auth()->user()->name }}</span>
            </div>
        </div>
    </div>
</div>