<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logoEsi.png') }}">
    <title>@yield('title', 'International Projects Web Portal') — ESI</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <x-header />

    <main>
        @yield('content')
    </main>

    <x-footer-public />

</body>
</html>
