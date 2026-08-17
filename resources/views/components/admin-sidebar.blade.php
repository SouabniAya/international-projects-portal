{{-- Admin Sidebar component. Prop: active (dashboard, cooperation, projects, calls, mobility, users, reports, settings). --}}
@props(['active' => 'dashboard'])

<aside class="admin-sidebar">
  <nav class="admin-sidebar__nav" aria-label="Admin navigation">
    <ul>
      <li><a href="{{ url('/admin/dashboard') }}" @if($active === 'dashboard') aria-current="page" @endif>{{ __('admin.dashboard') }}</a></li>
      <li><a href="{{ url('/admin/cooperation') }}" @if($active === 'cooperation') aria-current="page" @endif>{{ __('admin.cooperation') }}</a></li>
      <li><a href="{{ url('/admin/projects') }}" @if($active === 'projects') aria-current="page" @endif>{{ __('admin.projects') }}</a></li>
      <li><a href="{{ url('/admin/calls') }}" @if($active === 'calls') aria-current="page" @endif>{{ __('admin.calls') }}</a></li>
      <li><a href="{{ url('/admin/mobility') }}" @if($active === 'mobility') aria-current="page" @endif>{{ __('admin.mobility') }}</a></li>
      <li><a href="{{ url('/admin/users') }}" @if($active === 'users') aria-current="page" @endif>{{ __('admin.users_permissions') }}</a></li>
      <li><a href="{{ url('/admin/reports') }}" @if($active === 'reports') aria-current="page" @endif>{{ __('admin.reports') }}</a></li>
      <li><a href="{{ url('/admin/settings') }}" @if($active === 'settings') aria-current="page" @endif>{{ __('admin.settings') }}</a></li>
    </ul>
  </nav>
</aside>
