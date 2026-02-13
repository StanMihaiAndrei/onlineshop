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
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-touch-icon.png') }}">
        <link rel="manifest" href="{{ asset('site.webmanifest') }}">
        <meta name="theme-color" content="#db1cb5">
        <meta http-equiv="content-language" content="ro">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <meta name="apple-mobile-web-app-title" content="Craft Gifts">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.cdnfonts.com">
        <link href="https://fonts.cdnfonts.com/css/comic-relief" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'], 'build', ['crossorigin' => 'anonymous'])
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