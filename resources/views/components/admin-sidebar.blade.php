{{--
    Admin Sidebar component
    Usage: <x-admin-sidebar active="dashboard" />
    $active should match one of: dashboard, cooperation, projects, calls, mobility, users, reports, settings
--}}
@props(['active' => 'dashboard'])

<aside class="admin-sidebar">
  <nav class="admin-sidebar__nav" aria-label="Admin navigation">
    <ul>
      <li><a href="{{ url('/admin/dashboard') }}" @if($active === 'dashboard') aria-current="page" @endif>{{ __('Dashboard') }}</a></li>
      <li><a href="{{ url('/admin/cooperation') }}" @if($active === 'cooperation') aria-current="page" @endif>{{ __('Cooperation') }}</a></li>
      <li><a href="{{ url('/admin/projects') }}" @if($active === 'projects') aria-current="page" @endif>{{ __('Projects') }}</a></li>
      <li><a href="{{ url('/admin/partner-management') }}" @if($active === 'partners') aria-current="page" @endif>{{ __('Partners') }}</a></li>
      <li><a href="{{ url('/admin/calls') }}" @if($active === 'calls') aria-current="page" @endif>{{ __('Calls') }}</a></li>
      <li><a href="{{ url('/admin/mobility') }}" @if($active === 'mobility') aria-current="page" @endif>{{ __('Mobility') }}</a></li>
      <li><a href="{{ url('/admin/documents') }}" @if($active === 'documents') aria-current="page" @endif>{{ __('Documents') }}</a></li>
      <li><a href="{{ url('/admin/opportunities') }}" @if($active === 'opportunities') aria-current="page" @endif>{{ __('Opportunities') }}</a></li>
      <li><a href="{{ url('/admin/requests-documents') }}" @if($active === 'requests') aria-current="page" @endif>{{ __('Requests') }}</a></li>
      <li><a href="{{ url('/admin/users') }}" @if($active === 'users') aria-current="page" @endif>{{ __('Users & Permissions') }}</a></li>
      <li><a href="{{ url('/admin/reports') }}" @if($active === 'reports') aria-current="page" @endif>{{ __('Reports') }}</a></li>
      <li><a href="{{ url('/admin/settings') }}" @if($active === 'settings') aria-current="page" @endif>{{ __('Settings') }}</a></li>
    </ul>
  </nav>
</aside>