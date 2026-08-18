{{-- resources/views/admin/settings.blade.php --}}
@extends('layouts.admin')

@section('title', 'Account Settings')

@php($active = 'settings')

@section('content')

<div class="section__header" style="margin-bottom:24px;">
    <h2 style="margin:0;">{{ __('Profile Settings') }}</h2>
    <p style="margin:4px 0 0;">
        {{ __('Manage your account details, password, and security settings.') }}
    </p>
</div>

<div class="two-col two-col--equal" style="margin-bottom:0;">

    {{-- Personal Information --}}
    <div class="card">
        <div class="card__body">

            <h3 class="card__title">{{ __('Personal Information') }}</h3>

            <form
                method="POST"
                action="#"
                data-demo-submit="{{ __('Profile saved (demo — backend not connected yet).') }}"
                onsubmit="return false;"
            >

                <div class="form-row" style="margin-top:12px;">

                    <div class="form-group">
                        <label class="form-label" for="firstName">
                            {{ __('First name') }}
                        </label>

                        <input
                            class="form-control"
                            type="text"
                            id="firstName"
                            name="first_name"
                            value="Admin"
                        >
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="lastName">
                            {{ __('Last name') }}
                        </label>

                        <input
                            class="form-control"
                            type="text"
                            id="lastName"
                            name="last_name"
                            value="User"
                        >
                    </div>

                </div>

                <div class="form-group">
                    <label class="form-label" for="email">
                        {{ __('Email') }}
                    </label>

                    <input
                        class="form-control"
                        type="email"
                        id="email"
                        name="email"
                        value="admin@esi.dz"
                    >
                </div>

                <div class="form-group">
                    <label class="form-label" for="phone">
                        {{ __('Phone') }}
                    </label>

                    <input
                        class="form-control"
                        type="tel"
                        id="phone"
                        name="phone"
                        value=""
                        placeholder="{{ __('Enter phone number') }}"
                    >
                </div>

                <button
                    type="button"
                    class="btn btn--primary btn--sm"
                    data-toast="{{ __('Profile saved (demo — backend not connected yet).') }}"
                >
                    {{ __('Save changes') }}
                </button>

            </form>

        </div>
    </div>


    {{-- Security / Password --}}
    <div>

        {{-- Change Password --}}
        <div class="card">
            <div class="card__body">

                <h3 class="card__title">
                    {{ __('Change Password') }}
                </h3>

                <form
                    method="POST"
                    action="#"
                    onsubmit="return false;"
                >

                    <div class="form-group" style="margin-top:12px;">
                        <label class="form-label" for="currentPassword">
                            {{ __('Current password') }}
                        </label>

                        <input
                            class="form-control"
                            type="password"
                            id="currentPassword"
                            name="current_password"
                            placeholder="{{ __('Enter current password') }}"
                        >
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="newPassword">
                            {{ __('New password') }}
                        </label>

                        <input
                            class="form-control"
                            type="password"
                            id="newPassword"
                            name="new_password"
                            placeholder="{{ __('Enter new password') }}"
                        >

                        <p class="form-hint">
                            {{ __('Minimum 8 characters, including a number and a symbol.') }}
                        </p>
                    </div>

                    <button
                        type="button"
                        class="btn btn--outline btn--sm"
                        data-toast="{{ __('Password updated (demo — backend not connected yet).') }}"
                    >
                        {{ __('Update password') }}
                    </button>

                </form>

            </div>
        </div>


        {{-- Two-Factor Authentication --}}
        <div class="card" style="margin-top:20px;">
            <div class="card__body">

                <h3 class="card__title">
                    {{ __('Two-Factor Authentication') }}
                </h3>

                <p class="card__text">
                    {{ __('Add an extra layer of security to your account.') }}
                </p>

                <span
                    class="badge badge--pending"
                    style="margin-top:8px;"
                >
                    {{ __('Not enabled') }}
                </span>

                <div>
                    <button
                        type="button"
                        class="btn btn--outline btn--sm"
                        style="margin-top:12px;"
                        data-toast="{{ __('2FA setup started (demo — backend not connected yet).') }}"
                    >
                        {{ __('Enable 2FA') }}
                    </button>
                </div>

            </div>
        </div>


        {{-- Recent Login Activity --}}
        <div class="card" style="margin-top:20px;">
            <div class="card__body">

                <h3 class="card__title">
                    {{ __('Recent Login Activity') }}
                </h3>

                <div
                    class="data-table-wrap"
                    style="border:0; margin-top:8px;"
                >
                    <table class="data-table">
                        <tbody>

                            <tr>
                                <td>{{ __('Today, 09:14') }}</td>
                                <td>192.168.1.4</td>
                                <td>
                                    <span class="badge badge--approved">
                                        {{ __('Success') }}
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <td>{{ __('Yesterday, 17:02') }}</td>
                                <td>192.168.1.4</td>
                                <td>
                                    <span class="badge badge--approved">
                                        {{ __('Success') }}
                                    </span>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>

</div>

@endsection