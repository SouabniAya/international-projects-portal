@extends('layouts.admin')

@section('title', __('Users & Permissions'))

@section('content')
<div class="users-page">

    <div class="users-page__head">
        <div>
            <h1>{{ __('Users & Permissions Management') }}</h1>
            <p>{{ __('Manage users, roles and access permissions') }}</p>
        </div>

        <div class="users-page__actions">
            <button type="button" class="users-page__btn users-page__btn--outline">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M12 3v12m0 0l-4-4m4 4l4-4M5 21h14"
                          stroke="currentColor" stroke-width="1.6"
                          stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                {{ __('Export data') }}
            </button>

            <button type="button" class="users-page__btn users-page__btn--solid">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M12 5v14M5 12h14"
                          stroke="currentColor" stroke-width="1.8"
                          stroke-linecap="round"/>
                </svg>
                {{ __('Create User') }}
            </button>
        </div>
    </div>

    {{-- Sub-tabs --}}
    <div class="users-tabs">

        <button type="button" class="users-tabs__btn is-active">
            <svg viewBox="0 0 24 24" fill="none">
                <circle cx="12" cy="8" r="4"
                        stroke="currentColor" stroke-width="1.6"/>
                <path d="M4 20c0-4 3.6-6 8-6s8 2 8 6"
                      stroke="currentColor" stroke-width="1.6"
                      stroke-linecap="round"/>
            </svg>
            {{ __('User') }}
        </button>

        <button type="button" class="users-tabs__btn">
            <svg viewBox="0 0 24 24" fill="none">
                <circle cx="9" cy="8" r="3.2"
                        stroke="currentColor" stroke-width="1.6"/>
                <path d="M2.5 19c0-3.2 3-5 6.5-5s6.5 1.8 6.5 5"
                      stroke="currentColor" stroke-width="1.6"
                      stroke-linecap="round"/>
                <circle cx="17" cy="8.5" r="2.6"
                        stroke="currentColor" stroke-width="1.6"/>
                <path d="M14.8 19c.3-2.6 2.3-4 4.7-4s4.4 1.4 4.7 4"
                      stroke="currentColor" stroke-width="1.6"
                      stroke-linecap="round"/>
            </svg>
            {{ __('Users') }}
        </button>

        <button type="button" class="users-tabs__btn">
            <svg viewBox="0 0 24 24" fill="none">
                <path d="M12 3l7 3v6c0 5-3 8-7 9-4-1-7-4-7-9V6l7-3Z"
                      stroke="currentColor" stroke-width="1.6"
                      stroke-linejoin="round"/>
            </svg>
            {{ __('Permissions') }}
        </button>

        <button type="button" class="users-tabs__btn">
            <svg viewBox="0 0 24 24" fill="none">
                <circle cx="12" cy="12" r="9"
                        stroke="currentColor" stroke-width="1.6"/>
                <path d="M12 7v5l3.5 2"
                      stroke="currentColor" stroke-width="1.6"
                      stroke-linecap="round"/>
            </svg>
            {{ __('Login History') }}
        </button>

    </div>

    {{-- Stat cards --}}
    <div class="users-stats">

        <div class="users-stat">
            <svg viewBox="0 0 24 24" fill="none" class="users-stat__icon">
                <circle cx="12" cy="8" r="4"
                        stroke="currentColor" stroke-width="1.6"/>
                <path d="M4 20c0-4 3.6-6 8-6s8 2 8 6"
                      stroke="currentColor" stroke-width="1.6"
                      stroke-linecap="round"/>
            </svg>

            <div>
                <h3>{{ __('Total Users') }}</h3>
                <p class="users-stat__value">128</p>
                <p class="users-stat__delta">
                    {{ __('↑ 12 this month') }}
                </p>
            </div>
        </div>

        <div class="users-stat">
            <svg viewBox="0 0 24 24" fill="none"
                 class="users-stat__icon users-stat__icon--active">
                <circle cx="12" cy="8" r="4"
                        stroke="currentColor" stroke-width="1.6"/>
                <path d="M4 20c0-4 3.6-6 8-6s8 2 8 6"
                      stroke="currentColor" stroke-width="1.6"
                      stroke-linecap="round"/>
            </svg>

            <div>
                <h3>{{ __('Active Users') }}</h3>
                <p class="users-stat__value">98</p>
                <p class="users-stat__delta">
                    {{ __('76.6% of total') }}
                </p>
            </div>
        </div>

        <div class="users-stat">
            <svg viewBox="0 0 24 24" fill="none" class="users-stat__icon">
                <circle cx="10" cy="8" r="4"
                        stroke="currentColor" stroke-width="1.6"/>
                <path d="M16 6l4 4m0-4l-4 4"
                      stroke="currentColor" stroke-width="1.6"
                      stroke-linecap="round"/>
                <path d="M2 20c0-4 3.6-6 8-6s8 2 8 6"
                      stroke="currentColor" stroke-width="1.6"
                      stroke-linecap="round"/>
            </svg>

            <div>
                <h3>{{ __('Inactive Users') }}</h3>
                <p class="users-stat__value">30</p>
                <p class="users-stat__delta">
                    {{ __('23.4% of total') }}
                </p>
            </div>
        </div>

        <div class="users-stat">
            <svg viewBox="0 0 24 24" fill="none" class="users-stat__icon">
                <path d="M12 3l7 3v6c0 5-3 8-7 9-4-1-7-4-7-9V6l7-3Z"
                      stroke="currentColor" stroke-width="1.6"
                      stroke-linejoin="round"/>
            </svg>

            <div>
                <h3>{{ __('Roles') }}</h3>
                <p class="users-stat__value">8</p>
                <p class="users-stat__delta users-stat__delta--muted">
                    {{ __('System roles') }}
                </p>
            </div>
        </div>

    </div>

    {{-- Toolbar --}}
    <div class="users-toolbar">

        <div class="users-toolbar__search">
            <svg viewBox="0 0 24 24" fill="none">
                <circle cx="11" cy="11" r="7"
                        stroke="currentColor" stroke-width="2"/>
                <path d="M21 21l-4.3-4.3"
                      stroke="currentColor" stroke-width="2"
                      stroke-linecap="round"/>
            </svg>

            <input type="search"
                   placeholder="{{ __('Search users...') }}">
        </div>

        <div class="users-toolbar__filter">
            <span>{{ __('All Roles') }}</span>
            <svg viewBox="0 0 24 24" fill="none">
                <path d="M6 9l6 6 6-6"
                      stroke="currentColor"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"/>
            </svg>
        </div>

        <div class="users-toolbar__filter">
            <span>{{ __('All Status') }}</span>
            <svg viewBox="0 0 24 24" fill="none">
                <path d="M6 9l6 6 6-6"
                      stroke="currentColor"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"/>
            </svg>
        </div>

        <button type="button" class="users-toolbar__filters-btn">
            <span>{{ __('Filters') }}</span>
            <svg viewBox="0 0 24 24" fill="none">
                <path d="M4 6h16M7 12h10M10 18h4"
                      stroke="currentColor"
                      stroke-width="1.6"
                      stroke-linecap="round"/>
            </svg>
        </button>

    </div>

    {{-- Table --}}
    <div class="users-table-wrap">

        <table class="users-table">

            <thead>
                <tr>
                    <th>{{ __('User') }}</th>
                    <th>{{ __('Email') }}</th>
                    <th>{{ __('Roles') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Last Login') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>

            <tbody>

                @php
                    $users = collect(range(1, 5))->map(fn() => [
                        'name' => 'Aya Souabni',
                        'email' => 'aya.souabni@esi.dz',
                        'role' => 'Super Admin',
                        'status' => 'Active',
                        'last_login' => 'Today, 09:42 AM',
                        'avatar' => 'images/avatar-placeholder.png',
                    ]);
                @endphp

                @foreach($users as $user)

                <tr>

                    <td>
                        <div class="users-table__user">
                            <img src="{{ asset($user['avatar']) }}" alt="">
                            <span>{{ $user['name'] }}</span>
                        </div>
                    </td>

                    <td>{{ $user['email'] }}</td>

                    <td>{{ __($user['role']) }}</td>

                    <td>
                        <span class="users-table__status">
                            {{ __($user['status']) }}
                        </span>
                    </td>

                    <td>{{ __($user['last_login']) }}</td>

                    <td>
                        <div class="users-table__actions">

                            <button type="button"
                                    aria-label="{{ __('Call') }}">
                                <!-- icon -->
                            </button>

                            <button type="button"
                                    aria-label="{{ __('Email') }}">
                                <!-- icon -->
                            </button>

                            <button type="button"
                                    aria-label="{{ __('More options') }}">
                                <!-- icon -->
                            </button>

                        </div>
                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

    <div class="users-pagination">

        <span>
            {{ __('Showing 1 to 5 of 128 users') }}
        </span>

        <div class="users-pagination__buttons">

            <button type="button"
                    aria-label="{{ __('Previous page') }}">
                ‹
            </button>

            <button type="button" class="is-active">1</button>
            <button type="button">2</button>
            <button type="button">3</button>

            <span>…</span>

            <button type="button">9</button>

            <button type="button"
                    aria-label="{{ __('Next page') }}">
                ›
            </button>

        </div>

    </div>

</div>
@endsection