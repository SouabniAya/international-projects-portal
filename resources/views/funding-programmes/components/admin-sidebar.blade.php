@props(['active' => null])

@php
    $adminUser = auth('admin')->user() ?? auth()->user();
    $isSuperAdmin = $adminUser?->isSuperAdmin() ?? false;
    $isFunctionalAdmin = $adminUser?->isFunctionalAdmin() ?? false;
    $canManageContent = $isSuperAdmin || $isFunctionalAdmin || $adminUser !== null;

    $resolvedActive = $active ?? match (true) {
        Route::is('admin.dashboard') => 'dashboard',
        Route::is('admin.content-management') || Route::is('admin.content.create') || Route::is('admin.content.store') || Route::is('admin.partnerships.store') || Route::is('admin.school-presentation*') || Route::is('admin.faqs*') || Route::is('admin.news*') => 'cooperation',
        Route::is('admin.events*') => 'events',
        Route::is('admin.partner-management*') => 'partners',
        Route::is('admin.agreements*') || Route::is('admin.agreement-details') => 'agreements',
        Route::is('admin.projects*') || Route::is('admin.project-details') => 'projects',
        Route::is('admin.funding-programmes*') => 'funding-programmes',
        Route::is('admin.calls*') || Route::is('admin.call-details') => 'calls',
        Route::is('admin.mobility*') || Route::is('admin.mobility-details') => 'mobility',
        Route::is('admin.testimonials*') => 'testimonials',
        Route::is('admin.documents*') => 'documents',
        Route::is('admin.requests-documents*') => 'requests',
        Route::is('admin.reports') => 'reports',
        Route::is('admin.users*') => 'users',
        Route::is('admin.settings*') || Route::is('admin.profile') => 'settings',
        default => 'dashboard',
    };
@endphp

<aside class="admin-sidebar">
  <nav class="admin-sidebar__nav" aria-label="Admin navigation">
    <ul>
      <li><a href="{{ url('/admin/dashboard') }}" @if($resolvedActive === 'dashboard') aria-current="page" @endif>{{ __('Dashboard') }}</a></li>
    </ul>

    @if($canManageContent)
      <p class="admin-sidebar__group-label">{{ __('Content') }}</p>
      <ul>
        <li><a href="{{ url('/admin/cooperation') }}" @if($resolvedActive === 'cooperation') aria-current="page" @endif>{{ __('Content Management') }}</a></li>
        <li><a href="{{ url('/admin/school-presentation') }}" @if(Route::is('admin.school-presentation*')) aria-current="page" @endif>{{ __('School Presentation') }}</a></li>
        <li><a href="{{ url('/admin/faqs') }}" @if(Route::is('admin.faqs*')) aria-current="page" @endif>{{ __('FAQ') }}</a></li>
        <li><a href="{{ url('/admin/news') }}" @if(Route::is('admin.news*')) aria-current="page" @endif>{{ __('News') }}</a></li>
        <li><a href="{{ url('/admin/events') }}" @if($resolvedActive === 'events') aria-current="page" @endif>{{ __('Events') }}</a></li>
        <li><a href="{{ url('/admin/testimonials') }}" @if($resolvedActive === 'testimonials') aria-current="page" @endif>{{ __('Testimonials') }}</a></li>
      </ul>

      <p class="admin-sidebar__group-label">{{ __('Partnerships') }}</p>
      <ul>
        <li><a href="{{ url('/admin/partner-management') }}" @if($resolvedActive === 'partners') aria-current="page" @endif>{{ __('Partners') }}</a></li>
        <li><a href="{{ url('/admin/agreements') }}" @if($resolvedActive === 'agreements') aria-current="page" @endif>{{ __('Agreements') }}</a></li>
      </ul>

      <p class="admin-sidebar__group-label">{{ __('Projects') }}</p>
      <ul>
        <li><a href="{{ url('/admin/projects') }}" @if($resolvedActive === 'projects') aria-current="page" @endif>{{ __('Projects') }}</a></li>
      </ul>

      <p class="admin-sidebar__group-label">{{ __('Opportunities') }}</p>
      <ul>
        <li><a href="{{ url('/admin/funding-programmes') }}" @if($resolvedActive === 'funding-programmes') aria-current="page" @endif>{{ __('Funding Programmes') }}</a></li>
        <li><a href="{{ url('/admin/calls') }}" @if($resolvedActive === 'calls') aria-current="page" @endif>{{ __('Calls') }}</a></li>
        <li><a href="{{ url('/admin/mobility') }}" @if($resolvedActive === 'mobility') aria-current="page" @endif>{{ __('Mobility') }}</a></li>
      </ul>

      <p class="admin-sidebar__group-label">{{ __('Operations') }}</p>
      <ul>
        <li><a href="{{ url('/admin/documents') }}" @if($resolvedActive === 'documents') aria-current="page" @endif>{{ __('Documents') }}</a></li>
        <li><a href="{{ url('/admin/requests-documents') }}" @if($resolvedActive === 'requests') aria-current="page" @endif>{{ __('Requests') }}</a></li>
        <li><a href="{{ url('/admin/reports') }}" @if($resolvedActive === 'reports') aria-current="page" @endif>{{ __('Reports') }}</a></li>
      </ul>
    @endif

    @if($isSuperAdmin)
      <p class="admin-sidebar__group-label">{{ __('Administration') }}</p>
      <ul>
        <li><a href="{{ url('/admin/users') }}" @if($resolvedActive === 'users') aria-current="page" @endif>{{ __('Users & Permissions') }}</a></li>
        <li><a href="{{ url('/admin/settings') }}" @if($resolvedActive === 'settings') aria-current="page" @endif>{{ __('Settings') }}</a></li>
      </ul>
    @endif
  </nav>
</aside>