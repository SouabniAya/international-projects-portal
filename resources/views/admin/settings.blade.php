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

@if(session('success'))
    <div class="alert alert--success" style="margin-bottom:20px;">
        {{ session('success') }}
    </div>
@endif

<div class="two-col two-col--equal" style="margin-bottom:0;">

    {{-- Personal Information --}}
    <div class="card">
        <div class="card__body">

            <h3 class="card__title">{{ __('Personal Information') }}</h3>

            @if($errors->any() && old('first_name') !== null)
                <div class="alert alert--error" style="margin-top:12px;">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.settings.profile') }}">
                @csrf
                @method('PUT')

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
                            value="{{ old('first_name', $user->firstName) }}"
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
                            value="{{ old('last_name', $user->lastName) }}"
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
                        value="{{ old('email', $user->email) }}"
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
                        value="{{ old('phone', $user->phoneNumber) }}"
                        placeholder="{{ __('Enter phone number') }}"
                    >
                </div>

                <button type="submit" class="btn btn--primary btn--sm">
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

                @error('current_password')
                    <div class="alert alert--error" style="margin-top:12px;">{{ $message }}</div>
                @enderror
                @error('new_password')
                    <div class="alert alert--error" style="margin-top:12px;">{{ $message }}</div>
                @enderror

                <form method="POST" action="{{ route('admin.settings.password') }}">
                    @csrf
                    @method('PUT')

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

                    <div class="form-group">
                        <label class="form-label" for="newPasswordConfirmation">
                            {{ __('Confirm new password') }}
                        </label>

                        <input
                            class="form-control"
                            type="password"
                            id="newPasswordConfirmation"
                            name="new_password_confirmation"
                            placeholder="{{ __('Re-enter new password') }}"
                        >
                    </div>

                    <button type="submit" class="btn btn--outline btn--sm">
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

                <span class="badge {{ $user->twoFactorEnabled ? 'badge--approved' : 'badge--pending' }}" style="margin-top:8px;">
                    {{ $user->twoFactorEnabled ? __('Enabled') : __('Not enabled') }}
                </span>

                <div>
                    <form method="POST" action="{{ route('admin.settings.two-factor') }}">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn--outline btn--sm" style="margin-top:12px;">
                            {{ $user->twoFactorEnabled ? __('Disable 2FA') : __('Enable 2FA') }}
                        </button>
                    </form>
                </div>

            </div>
        </div>


        {{-- Recent Login Activity --}}
        <div class="card" style="margin-top:20px;">
            <div class="card__body">

                <h3 class="card__title">
                    {{ __('Recent Login Activity') }}
                </h3>

                <div class="data-table-wrap" style="border:0; margin-top:8px;">
                    <table class="data-table">
                        <tbody>
                            @forelse($loginHistory as $login)
                                <tr>
                                    <td>{{ $login['when'] }}</td>
                                    <td>{{ $login['ip'] }}</td>
                                    <td>
                                        <span class="badge {{ $login['successful'] ? 'badge--approved' : 'badge--rejected' }}">
                                            {{ $login['successful'] ? __('Success') : __('Failed') }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">{{ __('No login activity recorded yet.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>

</div>

@endsection