<?php

use Livewire\Volt\Component;

new class extends Component
{
    //
}; ?>

<div class="bg-white shadow-sm border-b border-gray-200">
    <div class="px-6 py-4">
        <div class="flex items-center justify-between">
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