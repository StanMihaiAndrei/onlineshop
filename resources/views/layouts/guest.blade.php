<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- SEO Meta Tags (can be overridden by pages) -->
        @if (isset($head))
            {{ $head }}
        @else
            <title>{{ config('app.name', 'Laravel') }}</title>
        @endif

        <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.cdnfonts.com">
        <link href="https://fonts.cdnfonts.com/css/comic-relief" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-background text-text">
        <!-- Navigation pentru clienți și guest -->
        <livewire:layout.navigation />

        <!-- Page Content -->
        <main class="min-h-screen bg-background">
            {{ $slot }}
        </main>

        <!-- Footer Component -->
        <livewire:layout.footer />
    </body>
</html>