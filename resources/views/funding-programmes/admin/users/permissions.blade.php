@extends('layouts.admin')

@section('title', 'Permissions')

@section('content')

<div class="users-page">

    {{-- HEADER --}}
    <div class="users-page__head">

        <div>
            <h1>Permissions Management</h1>
            <p>Manage roles and access permissions</p>
        </div>

        <div class="users-page__actions">

            <a href="{{ route('admin.users.index') }}"
               class="users-page__btn users-page__btn--outline">
                ← Back to Users
            </a>

        </div>

    </div>

    {{-- TABS --}}
    <div class="users-tabs">

        <a href="{{ route('admin.users.index') }}"
           class="users-tabs__btn">
            Users
        </a>

        <a href="{{ route('admin.users.permissions') }}"
           class="users-tabs__btn is-active">
            Permissions
        </a>

        @if(Route::has('admin.users.login-history'))
            <a href="{{ route('admin.users.login-history') }}"
               class="users-tabs__btn">
                Login History
            </a>
        @endif

    </div>

    {{-- PERMISSIONS CARD --}}
    <div class="users-form-card">

        <div class="users-form-card__header">

            <h2>Roles & Permissions</h2>

            <p>
                Configure which permissions are available to each system role.
            </p>

        </div>

        @if(isset($roles) && count($roles) > 0)

            <div class="permissions-list">

                @foreach($roles as $role)

                    <div class="permission-role">

                        <div class="permission-role__info">

                            <div class="permission-role__icon">
                                <svg viewBox="0 0 24 24" fill="none">
                                    <path
                                        d="M12 3l7 3v6c0 5-3 8-7 9-4-1-7-4-7-9V6l7-3Z"
                                        stroke="currentColor"
                                        stroke-width="1.6"
                                        stroke-linejoin="round"
                                    />
                                </svg>
                            </div>

                            <div>

                                <strong>
                                    {{ $role->roleName }}
                                </strong>

                                @if(isset($role->description) && $role->description)
                                    <p>
                                        {{ $role->description }}
                                    </p>
                                @else
                                    <p>
                                        System role and access permissions
                                    </p>
                                @endif

                            </div>

                        </div>

                        <div class="permission-role__action">
<a href="{{ route('admin.users.permissions.manage', $role->roleID) }}"
   class="users-page__btn users-page__btn--outline">
    Manage
</a>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="users-table__empty">
                No roles have been configured yet.
            </div>

        @endif

    </div>

</div>

@endsection