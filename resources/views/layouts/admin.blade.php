<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — International Projects Web Portal</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <div class="admin-layout">

        <x-admin-header />

        <div class="admin-layout__body">

            <x-admin-sidebar :active="$active ?? 'dashboard'" />

            <main class="admin-layout__content">
                @yield('content')
            </main>

        </div>
    </div>

</body>
</html>