<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">


        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @if(auth()->check() && auth()->user()->role === 'admin')
                <!-- Layout pentru ADMIN cu Sidebar -->
                <div class="flex">
                    <!-- Sidebar pentru Admin -->
                    <livewire:layout.admin-sidebar />

                    <!-- Main Content -->
                    <div class="flex-1">
                        <!-- Top Navigation -->
                        <livewire:layout.admin-top-navigation />

                        <!-- Page Content -->
                        <main class="p-6">
                            {{ $slot }}
                        </main>
                    </div>
                </div>
            @else
                <!-- Layout pentru CLIENT (redirect la guest layout) -->
                <livewire:layout.navigation />
                
                <!-- Page Content -->
                <main>
                    <div class="py-12">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            {{ $slot }}
                        </div>
                    </div>
                </main>
            @endif
        </div>
    </body>
</html>