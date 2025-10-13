<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'OnlineShop')</title>
    @vite('resources/css/app.css')
    @livewireStyles
</head>
<body>
    @yield('content')

    @livewireScripts
    @vite('resources/js/app.js')
</body>
</html>