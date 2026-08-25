@extends('layouts.admin')

@section('title', 'Login History')

@section('content')

<div class="users-page">

    {{-- HEADER --}}
    <div class="users-page__head">

        <div>
            <h1>Login History</h1>
            <p>Monitor user login activity</p>
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

        @if(Route::has('admin.users.permissions'))
            <a href="{{ route('admin.users.permissions') }}"
               class="users-tabs__btn">
                Permissions
            </a>
        @endif

        <a href="{{ route('admin.users.login-history') }}"
           class="users-tabs__btn is-active">
            Login History
        </a>

    </div>

    {{-- TABLE --}}
    <div class="users-table-wrap">

        <table class="users-table">

            <thead>
                <tr>
                    <th>User</th>
                    <th>Login Time</th>
                    <th>IP Address</th>
                    <th>Status</th>
                    <th>Failure Reason</th>
                </tr>
            </thead>

            <tbody>

            @forelse($loginHistory as $login)

                <tr>

                    {{-- USER --}}
                    <td>

                        <div class="users-table__user">

                            <div class="users-table__avatar">
                                @if($login->user)
                                    {{ strtoupper(substr($login->user->firstName ?? 'U', 0, 1)) }}
                                @else
                                    U
                                @endif
                            </div>

                            <div>

                                @if($login->user)

                                    <strong>
                                        {{ $login->user->firstName }}
                                        {{ $login->user->lastName }}
                                    </strong>

                                    <small>
                                        {{ $login->user->email }}
                                    </small>

                                @else

                                    <strong>Unknown user</strong>

                                @endif

                            </div>

                        </div>

                    </td>

                    {{-- LOGIN TIME --}}
                    <td>

                        @if($login->loginTime)

                            {{ \Carbon\Carbon::parse($login->loginTime)->format('d/m/Y H:i') }}

                        @else

                            —

                        @endif

                    </td>

                    {{-- IP --}}
                    <td>
                        {{ $login->ipAddress ?? '—' }}
                    </td>

                    {{-- STATUS --}}
                    <td>

                        @if($login->successful)

                            <span class="users-table__status">
                                Successful
                            </span>

                        @else

                            <span class="users-table__status users-table__status--inactive">
                                Failed
                            </span>

                        @endif

                    </td>

                    {{-- FAILURE --}}
                    <td>
                        {{ $login->failureReason ?? '—' }}
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="5"
                        class="users-table__empty">
                        No login history found.
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    {{-- PAGINATION --}}
    @if(method_exists($loginHistory, 'links'))

        @if($loginHistory->hasPages())

            <div class="users-pagination">

                <span>
                    Showing
                    {{ $loginHistory->firstItem() ?? 0 }}
                    to
                    {{ $loginHistory->lastItem() ?? 0 }}
                    of
                    {{ $loginHistory->total() }}
                    records
                </span>

                <div class="users-pagination__buttons">
                    {{ $loginHistory->links() }}
                </div>

            </div>

        @endif

    @endif

</div>

@endsection