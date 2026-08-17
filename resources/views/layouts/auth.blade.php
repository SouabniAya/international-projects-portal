<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logoEsi.png') }}">
    <title>@yield('title', 'Sign In') — International Projects Web Portal</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <div class="auth-page">

        <div class="auth-page__brand">
            <div class="auth-page__brand-shapes" aria-hidden="true">
                <svg viewBox="0 0 700 900" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
                    <circle class="shape-cerulean" cx="560" cy="120" r="260"/>
                    <circle class="shape-sky" cx="80" cy="760" r="220"/>
                    <path class="shape-cerulean" d="M0,620 C180,560 340,700 520,630 C600,600 660,640 700,610 L700,900 L0,900 Z"/>
                </svg>
            </div>
            <div class="auth-page__brand-content">
                <img src="{{ asset('images/logoEsi.png') }}" alt="ESI logo">
                <h2>International Projects Web Portal</h2>
                <p>Manage partnerships, projects, calls for proposals, and mobility opportunities from one place.</p>
            </div>
            <p class="auth-page__brand-quote">"Building bridges through international collaboration, research and academic excellence." — International Relations Office</p>
        </div>

        <div class="auth-page__form">
            <div class="auth-card">
                <div class="auth-card__logo">
                    <img src="{{ asset('images/logoEsi.png') }}" alt="ESI logo">
                </div>
                @yield('content')
            </div>
        </div>

    </div>

</body>
</html>
