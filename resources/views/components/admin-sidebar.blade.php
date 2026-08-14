{{--
    Admin Sidebar component
    Usage: <x-admin-sidebar active="dashboard" />
    $active should match one of: dashboard, cooperation, projects, calls, mobility, users, reports, settings
--}}
@props(['active' => 'dashboard'])

<aside class="admin-sidebar">
  <nav class="admin-sidebar__nav" aria-label="Admin navigation">
    <ul>
      <li><a href="{{ url('/admin/dashboard') }}" @if($active === 'dashboard') aria-current="page" @endif>Dashboard</a></li>
      <li><a href="{{ url('/admin/cooperation') }}" @if($active === 'cooperation') aria-current="page" @endif>Cooperation</a></li>
      <li><a href="{{ url('/admin/projects') }}" @if($active === 'projects') aria-current="page" @endif>Projects</a></li>
      <li><a href="{{ url('/admin/calls') }}" @if($active === 'calls') aria-current="page" @endif>Calls</a></li>
      <li><a href="{{ url('/admin/mobility') }}" @if($active === 'mobility') aria-current="page" @endif>Mobility</a></li>
      <li><a href="{{ url('/admin/users') }}" @if($active === 'users') aria-current="page" @endif>Users &amp; Permissions</a></li>
      <li><a href="{{ url('/admin/reports') }}" @if($active === 'reports') aria-current="page" @endif>Reports</a></li>
      <li><a href="{{ url('/admin/settings') }}" @if($active === 'settings') aria-current="page" @endif>Settings</a></li>
    </ul>
  </nav>
</aside>
