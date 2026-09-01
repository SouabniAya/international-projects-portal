{{-- Shared Header component. --}}
<header class="site-header">
  <div class="site-header__inner">

    <a href="{{ url('/') }}" class="site-header__logo" aria-label="ESI — Home">
      <img src="{{ asset('images/logoEsi.png') }}" alt="ESI logo">
    </a>

    <nav class="site-header__nav" aria-label="Main navigation">
      <a href="{{ url('/calls') }}" @if(request()->routeIs('calls*')) aria-current="page" @endif>Calls</a>
      <a href="{{ url('/contact') }}" @if(request()->routeIs('contact*')) aria-current="page" @endif>Contact</a>
      <a href="{{ url('/projects') }}" @if(request()->routeIs('projects*')) aria-current="page" @endif>Projects</a>
      <a href="{{ url('/mobility') }}" @if(request()->routeIs('mobility*')) aria-current="page" @endif>Mobility</a>
      <a href="{{ url('/documents') }}" @if(request()->routeIs('documents*')) aria-current="page" @endif>Documents</a>
      <a href="{{ url('/partnerships') }}" @if(request()->routeIs('partnerships*')) aria-current="page" @endif>Partnerships</a>
    </nav>

    <div class="site-header__staff">
      <a href="{{ url('/staff') }}" class="site-header__staff-link">staff Portal &nbsp;→</a>
      <a href="{{ route('login') }}" class="site-header__signin">
        <span>Sign In</span>
        <svg viewBox="0 0 16 19" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <rect x="2" y="8.5" width="12" height="9.5" rx="1.5" stroke-width="1.4"/>
          <path d="M4.5 8.5V5.8A3.5 3.5 0 0 1 8 2.3a3.5 3.5 0 0 1 3.5 3.5v2.7" stroke-width="1.4" stroke-linecap="round"/>
        </svg>
      </a>
    </div>

    <div class="site-header__lang" role="group" aria-label="Language switcher">
      <button type="button" aria-current="{{ app()->getLocale() === 'en' ? 'true' : 'false' }}" data-lang="en">EN</button>
      <button type="button" aria-current="{{ app()->getLocale() === 'fr' ? 'true' : 'false' }}" data-lang="fr">FR</button>
      <button type="button" aria-current="{{ app()->getLocale() === 'ar' ? 'true' : 'false' }}" data-lang="ar">AR</button>
    </div>

  </div>
</header>
