@extends('layouts.admin')

@section('title', 'Users & Permissions')

@section('content')

<div class="users-page">

    {{-- ============================================================
        HEADER
    ============================================================ --}}
    <div class="users-page__head">
        <div>
            <h1>Users & Permissions Management</h1>
            <p>Manage users, roles and access permissions</p>
        </div>

        <div class="users-page__actions">

            @if(Route::has('admin.users.export'))
                <a href="{{ route('admin.users.export') }}"
                   class="users-page__btn users-page__btn--outline">

                    <svg viewBox="0 0 24 24" fill="none">
                        <path
                            d="M12 3v12m0 0l-4-4m4 4l4-4M5 21h14"
                            stroke="currentColor"
                            stroke-width="1.6"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>

                    Export data
                </a>
            @endif

            @if(Route::has('admin.users.create'))
                <a href="{{ route('admin.users.create') }}"
                   class="users-page__btn users-page__btn--solid">

                    <svg viewBox="0 0 24 24" fill="none">
                        <path
                            d="M12 5v14M5 12h14"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                        />
                    </svg>

                    Create User
                </a>
            @endif

        </div>
    </div>


    {{-- ============================================================
        SUCCESS / ERROR MESSAGES
    ============================================================ --}}

    @if(session('success'))
        <div class="users-alert users-alert--success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="users-alert users-alert--error">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="users-alert users-alert--error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- ============================================================
        TABS
    ============================================================ --}}

    <div class="users-tabs">

        <a href="{{ route('admin.users.index') }}"
           class="users-tabs__btn is-active">

            <svg viewBox="0 0 24 24" fill="none">
                <circle
                    cx="12"
                    cy="8"
                    r="4"
                    stroke="currentColor"
                    stroke-width="1.6"
                />
                <path
                    d="M4 20c0-4 3.6-6 8-6s8 2 8 6"
                    stroke="currentColor"
                    stroke-width="1.6"
                    stroke-linecap="round"
                />
            </svg>

            Users
        </a>

        @if(Route::has('admin.users.permissions'))
            <a href="{{ route('admin.users.permissions') }}"
               class="users-tabs__btn">

                <svg viewBox="0 0 24 24" fill="none">
                    <path
                        d="M12 3l7 3v6c0 5-3 8-7 9-4-1-7-4-7-9V6l7-3Z"
                        stroke="currentColor"
                        stroke-width="1.6"
                        stroke-linejoin="round"
                    />
                </svg>

                Permissions
            </a>
        @endif

        @if(Route::has('admin.users.login-history'))
            <a href="{{ route('admin.users.login-history') }}"
               class="users-tabs__btn">

                <svg viewBox="0 0 24 24" fill="none">
                    <circle
                        cx="12"
                        cy="12"
                        r="9"
                        stroke="currentColor"
                        stroke-width="1.6"
                    />
                    <path
                        d="M12 7v5l3.5 2"
                        stroke="currentColor"
                        stroke-width="1.6"
                        stroke-linecap="round"
                    />
                </svg>

                Login History
            </a>
        @endif

    </div>


    {{-- ============================================================
        STATISTICS
    ============================================================ --}}

    <div class="users-stats">

        {{-- TOTAL USERS --}}
        <div class="users-stat">

            <svg
                viewBox="0 0 24 24"
                fill="none"
                class="users-stat__icon"
            >
                <circle
                    cx="12"
                    cy="8"
                    r="4"
                    stroke="currentColor"
                    stroke-width="1.6"
                />

                <path
                    d="M4 20c0-4 3.6-6 8-6s8 2 8 6"
                    stroke="currentColor"
                    stroke-width="1.6"
                    stroke-linecap="round"
                />
            </svg>

            <div>
                <h3>Total Users</h3>

                <p class="users-stat__value">
                    {{ $totalUsers ?? 0 }}
                </p>

                <p class="users-stat__delta">
                    Total registered users
                </p>
            </div>

        </div>


        {{-- ACTIVE USERS --}}
        <div class="users-stat">

            <svg
                viewBox="0 0 24 24"
                fill="none"
                class="users-stat__icon users-stat__icon--active"
            >
                <circle
                    cx="12"
                    cy="8"
                    r="4"
                    stroke="currentColor"
                    stroke-width="1.6"
                />

                <path
                    d="M4 20c0-4 3.6-6 8-6s8 2 8 6"
                    stroke="currentColor"
                    stroke-width="1.6"
                    stroke-linecap="round"
                />
            </svg>

            <div>
                <h3>Active Users</h3>

                <p class="users-stat__value">
                    {{ $activeUsers ?? 0 }}
                </p>

                <p class="users-stat__delta">
                    Active accounts
                </p>
            </div>

        </div>


        {{-- INACTIVE USERS --}}
        <div class="users-stat">

            <svg
                viewBox="0 0 24 24"
                fill="none"
                class="users-stat__icon"
            >
                <circle
                    cx="10"
                    cy="8"
                    r="4"
                    stroke="currentColor"
                    stroke-width="1.6"
                />

                <path
                    d="M16 6l4 4m0-4l-4 4"
                    stroke="currentColor"
                    stroke-width="1.6"
                    stroke-linecap="round"
                />

                <path
                    d="M2 20c0-4 3.6-6 8-6s8 2 8 6"
                    stroke="currentColor"
                    stroke-width="1.6"
                    stroke-linecap="round"
                />
            </svg>

            <div>
                <h3>Inactive Users</h3>

                <p class="users-stat__value">
                    {{ $inactiveUsers ?? 0 }}
                </p>

                <p class="users-stat__delta users-stat__delta--muted">
                    Disabled accounts
                </p>
            </div>

        </div>


        {{-- ROLES --}}
        <div class="users-stat">

            <svg
                viewBox="0 0 24 24"
                fill="none"
                class="users-stat__icon"
            >
                <path
                    d="M12 3l7 3v6c0 5-3 8-7 9-4-1-7-4-7-9V6l7-3Z"
                    stroke="currentColor"
                    stroke-width="1.6"
                    stroke-linejoin="round"
                />
            </svg>

            <div>
                <h3>Roles</h3>

                <p class="users-stat__value">
                    {{ $rolesCount ?? 0 }}
                </p>

                <p class="users-stat__delta">
                    System roles
                </p>
            </div>

        </div>

    </div>


    {{-- ============================================================
        SEARCH / FILTER TOOLBAR
    ============================================================ --}}

    <form
        method="GET"
        action="{{ route('admin.users.index') }}"
        class="users-toolbar"
    >

        {{-- SEARCH --}}
        <div class="users-toolbar__search">

            <svg viewBox="0 0 24 24" fill="none">
                <circle
                    cx="11"
                    cy="11"
                    r="7"
                    stroke="currentColor"
                    stroke-width="2"
                />

                <path
                    d="M21 21l-4.3-4.3"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                />
            </svg>

            <input
                type="search"
                name="search"
                value="{{ $search ?? request('search') }}"
                placeholder="Search users..."
            >

        </div>


        {{-- ROLE FILTER --}}
        <select
            name="role"
            class="users-toolbar__filter"
        >

            <option value="">All Roles</option>

            @foreach($roles as $role)

                <option
                    value="{{ $role->roleID }}"
                    {{ (string) request('role') === (string) $role->roleID ? 'selected' : '' }}
                >
                    {{ $role->roleName }}
                </option>

            @endforeach

        </select>


        {{-- STATUS FILTER --}}
        <select
            name="status"
            class="users-toolbar__filter"
        >

            <option value="">All Status</option>

            <option
                value="active"
                {{ request('status') === 'active' ? 'selected' : '' }}
            >
                Active
            </option>

            <option
                value="disabled"
                {{ request('status') === 'disabled' ? 'selected' : '' }}
            >
                Disabled
            </option>

        </select>


        {{-- FILTER BUTTON --}}
        <button
            type="submit"
            class="users-toolbar__filters-btn"
        >

            <span>Filter</span>

            <svg viewBox="0 0 24 24" fill="none">
                <path
                    d="M4 6h16M7 12h10M10 18h4"
                    stroke="currentColor"
                    stroke-width="1.6"
                    stroke-linecap="round"
                />
            </svg>

        </button>

    </form>


    {{-- ============================================================
        USERS TABLE
    ============================================================ --}}

    <div class="users-table-wrap">

        <table class="users-table">

            <thead>
                <tr>
                    <th>User</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Last Login</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

            @forelse($users as $user)

                <tr>

                    {{-- USER --}}
                    <td>

                        <div class="users-table__user">

                            <div
                                class="users-table__avatar"
                                style="
                                    width:36px;
                                    height:36px;
                                    border-radius:50%;
                                    display:flex;
                                    align-items:center;
                                    justify-content:center;
                                    background:var(--color-cerulean);
                                    color:var(--color-white);
                                    font-weight:700;
                                    flex-shrink:0;
                                "
                            >
                                {{ strtoupper(substr($user->firstName ?? 'U', 0, 1)) }}
                            </div>

                            <span>
                                {{ $user->firstName ?? '' }}
                                {{ $user->lastName ?? '' }}
                            </span>

                        </div>

                    </td>


                    {{-- EMAIL --}}
                    <td>
                        {{ $user->email ?? '—' }}
                    </td>


                    {{-- USERNAME --}}
                    <td>
                        {{ $user->userName ?? '—' }}
                    </td>


                    {{-- ROLE --}}
                    <td>

                        @if($user->roles && $user->roles->isNotEmpty())

                            {{ $user->roles->pluck('roleName')->implode(', ') }}

                        @else

                            <span style="color:var(--color-neutral-500);">
                                No role
                            </span>

                        @endif

                    </td>


                    {{-- STATUS --}}
                    <td>

                        @if($user->accountStatus === 'active')

                            <span class="users-table__status">
                                Active
                            </span>

                        @else

                            <span class="users-table__status users-table__status--inactive">
                                Disabled
                            </span>

                        @endif

                    </td>


                    {{-- LAST LOGIN --}}
                    <td>

                        @php
                            $lastLogin = $user->loginHistory->first();
                        @endphp

                        @if($lastLogin)
                            {{ $lastLogin->loginTime }}
                        @else
                            Never
                        @endif

                    </td>


                    {{-- ACTIONS --}}
                    <td>

                        <div class="users-table__actions">

                            {{-- VIEW --}}
                            @if(Route::has('admin.users.show'))

                                <a
                                    href="{{ route('admin.users.show', $user->userID) }}"
                                    class="users-table__action"
                                    title="View user"
                                    aria-label="View user"
                                >

                                    <svg
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z"
                                            stroke="currentColor"
                                            stroke-width="1.6"
                                            stroke-linejoin="round"
                                        />

                                        <circle
                                            cx="12"
                                            cy="12"
                                            r="2.5"
                                            stroke="currentColor"
                                            stroke-width="1.6"
                                        />
                                    </svg>

                                </a>

                            @endif


                            {{-- EDIT --}}
                            @if(Route::has('admin.users.edit'))

                                <a
                                    href="{{ route('admin.users.edit', $user->userID) }}"
                                    class="users-table__action"
                                    title="Edit user"
                                    aria-label="Edit user"
                                >

                                    <svg
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            d="M4 20h4l10.5-10.5a2.12 2.12 0 0 0-3-3L5 17v3Z"
                                            stroke="currentColor"
                                            stroke-width="1.6"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        />

                                        <path
                                            d="m14.5 7.5 2 2"
                                            stroke="currentColor"
                                            stroke-width="1.6"
                                            stroke-linecap="round"
                                        />
                                    </svg>

                                </a>

                            @endif


                            {{-- EMAIL --}}
                            @if(!empty($user->email))

                                <a
                                    href="mailto:{{ $user->email }}"
                                    class="users-table__action"
                                    title="Send email"
                                    aria-label="Send email"
                                >

                                    <svg
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <rect
                                            x="3"
                                            y="5"
                                            width="18"
                                            height="14"
                                            rx="2"
                                            stroke="currentColor"
                                            stroke-width="1.6"
                                        />

                                        <path
                                            d="M3 7l9 6 9-6"
                                            stroke="currentColor"
                                            stroke-width="1.6"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        />
                                    </svg>

                                </a>

                            @endif


                            {{-- DELETE --}}
                            @if(Route::has('admin.users.destroy'))

                                <form
                                    method="POST"
                                    action="{{ route('admin.users.destroy', $user->userID) }}"
                                    style="display:inline;"
                                    onsubmit="return confirm('Are you sure you want to delete this user?');"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        title="Delete user"
                                        aria-label="Delete user"
                                    >

                                        <svg
                                            viewBox="0 0 24 24"
                                            fill="none"
                                        >
                                            <path
                                                d="M5 7h14"
                                                stroke="currentColor"
                                                stroke-width="1.6"
                                                stroke-linecap="round"
                                            />

                                            <path
                                                d="M10 11v6M14 11v6"
                                                stroke="currentColor"
                                                stroke-width="1.6"
                                                stroke-linecap="round"
                                            />

                                            <path
                                                d="M6 7l1 14h10l1-14"
                                                stroke="currentColor"
                                                stroke-width="1.6"
                                                stroke-linejoin="round"
                                            />

                                            <path
                                                d="M9 7V4h6v3"
                                                stroke="currentColor"
                                                stroke-width="1.6"
                                                stroke-linejoin="round"
                                            />
                                        </svg>

                                    </button>

                                </form>

                            @endif

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td
                        colspan="7"
                        class="users-table__empty"
                    >
                        No users found.
                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>


    {{-- ============================================================
        PAGINATION
    ============================================================ --}}

    @if($users->hasPages())

        <div class="users-pagination">

            <span>
                Showing
                {{ $users->firstItem() ?? 0 }}
                to
                {{ $users->lastItem() ?? 0 }}
                of
                {{ $users->total() }}
                users
            </span>

            <div class="users-pagination__buttons">
                {{ $users->links() }}
            </div>

        </div>

    @endif

</div>

@endsection