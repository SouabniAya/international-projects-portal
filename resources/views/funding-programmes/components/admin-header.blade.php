<header class="admin-header">
  <a href="{{ url('/admin/dashboard') }}" aria-label="{{ __('Admin home') }}">
    <img src="{{ asset('images/logoEsi.png') }}" alt="ESI logo" class="admin-header__logo">
  </a>

  <div class="admin-header__search">
    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
      <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/>
      <path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
    </svg>
    <input type="search" placeholder="{{ __('Search for users, roles, permissions...') }}">
  </div>

  <div class="admin-header__right">
    <div class="admin-header__lang" role="group" aria-label="{{ __('Language switcher') }}">
      <a href="{{ route('lang.switch', 'en') }}" aria-current="{{ app()->getLocale() === 'en' ? 'true' : 'false' }}">EN</a>
      <a href="{{ route('lang.switch', 'fr') }}" aria-current="{{ app()->getLocale() === 'fr' ? 'true' : 'false' }}">FR</a>
      <a href="{{ route('lang.switch', 'ar') }}" aria-current="{{ app()->getLocale() === 'ar' ? 'true' : 'false' }}">AR</a>
    </div>

    <a href="{{ route('admin.notifications') }}" class="admin-header__icon-btn" aria-label="{{ __('Notifications') }}">
      <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
        <path d="M12 3a5 5 0 0 0-5 5v3.2c0 .6-.2 1.2-.6 1.7L5 15h14l-1.4-2.1a2.8 2.8 0 0 1-.6-1.7V8a5 5 0 0 0-5-5Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
        <path d="M9.5 18a2.5 2.5 0 0 0 5 0" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
      </svg>
      @if(($unreadNotificationsCount ?? 0) > 0)<span class="admin-header__badge"></span>@endif
    </a>

    <a href="{{ url('/admin/help') }}" class="admin-header__icon-btn" aria-label="{{ __('Help') }}" title="{{ __('Help') }}">
      <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
        <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/>
        <path d="M9.5 9.3a2.5 2.5 0 1 1 3.7 2.2c-.7.4-1.2.9-1.2 1.7v.3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
        <circle cx="12" cy="16.8" r="0.9" fill="currentColor"/>
      </svg>
    </a>

    @php
      $adminUser = auth('admin')->user() ?? auth()->user();
      $firstName = $adminUser?->firstName ?? 'Admin';
      $lastName = $adminUser?->lastName ?? 'User';
      $roleName = $currentRoleName ?? $adminUser?->roles()->first()?->roleName ?? 'Administrator';
      $initials = strtoupper(substr((string) $firstName, 0, 1) . substr((string) $lastName, 0, 1));
    @endphp

    <div class="admin-header__profile" data-dropdown-toggle="profileMenu" role="button" tabindex="0" aria-haspopup="true" aria-expanded="false">
      <span class="admin-header__avatar">{{ $initials ?: 'AU' }}</span>
      <span class="admin-header__profile-text">
        <span class="admin-header__profile-name">{{ $firstName }} {{ $lastName }}</span>
        <span class="admin-header__profile-role">{{ __($roleName) }}</span>
      </span>
      <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>

      <div class="dropdown-menu" id="profileMenu">
        <a href="{{ url('/admin/profile') }}" class="dropdown-menu__item">{{ __('Profile') }}</a>
        @if($adminUser?->isSuperAdmin())
          <a href="{{ url('/admin/settings') }}" class="dropdown-menu__item">{{ __('Settings') }}</a>
        @endif
        <div class="dropdown-menu__divider"></div>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="dropdown-menu__item dropdown-menu__item--danger">{{ __('Sign Out') }}</button>
        </form>
      </div>
    </div>
  </div>
</header>
