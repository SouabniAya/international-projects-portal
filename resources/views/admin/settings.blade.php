{{-- resources/views/admin/profile.blade.php — FR-12.1 to FR-12.4 --}}
@extends('layouts.admin')

@section('title', 'Account Settings')

@php($active = 'settings')

@section('content')

<div class="section__header" style="margin-bottom:24px;">
    <h2 style="margin:0;">Administrator Profile</h2>
    <p style="margin:4px 0 0;">Manage your account details, password, and security settings.</p>
</div>

<div class="two-col two-col--equal" style="margin-bottom:0;">
    <div class="card">
        <div class="card__body">
            <h3 class="card__title">Personal Information</h3>
            <form method="POST" action="{{ route('admin.settings.update') }}" data-demo-submit="Profile saved (demo — connect this route to persist).">
                @csrf
                @method('PATCH')
                <div class="form-row" style="margin-top:12px;">
                    <div class="form-group">
                        <label class="form-label" for="firstName">First name</label>
                        <input class="form-control" type="text" id="firstName" name="first_name" value="Admin">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="lastName">Last name</label>
                        <input class="form-control" type="text" id="lastName" name="last_name" value="User">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input class="form-control" type="email" id="email" name="email" value="admin@esi.dz">
                </div>
                <div class="form-group">
                    <label class="form-label" for="phone">Phone</label>
                    <input class="form-control" type="tel" id="phone" name="phone">
                </div>
                <button type="submit" class="btn btn--primary btn--sm">Save changes</button>
            </form>
        </div>
    </div>

    <div>
        <div class="card">
            <div class="card__body">
                <h3 class="card__title">Change Password</h3>
                <form method="POST" action="{{ route('admin.settings.password') }}" data-demo-submit="Password updated (demo — connect this route to persist).">
                    @csrf
                    @method('PATCH')
                    <div class="form-group" style="margin-top:12px;">
                        <label class="form-label" for="currentPassword">Current password</label>
                        <input class="form-control" type="password" id="currentPassword" name="current_password">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="newPassword">New password</label>
                        <input class="form-control" type="password" id="newPassword" name="new_password">
                        <p class="form-hint">Minimum 8 characters, including a number and a symbol.</p>
                    </div>
                    <button type="submit" class="btn btn--outline btn--sm">Update password</button>
                </form>
            </div>
        </div>

        <div class="card" style="margin-top:20px;">
            <div class="card__body">
                <h3 class="card__title">Two-Factor Authentication</h3>
                <p class="card__text">Add an extra layer of security to your account.</p>
                <span class="badge badge--pending" style="margin-top:8px;">Not enabled</span>
                <div>
                    <button type="button" class="btn btn--outline btn--sm" style="margin-top:12px;" data-toast="2FA setup started (demo — connect a real 2FA flow, e.g. Laravel Fortify, once the backend exists).">Enable 2FA</button>
                </div>
            </div>
        </div>

        <div class="card" style="margin-top:20px;">
            <div class="card__body">
                <h3 class="card__title">Recent Login Activity</h3>
                <div class="data-table-wrap" style="border:0; margin-top:8px;">
                    <table class="data-table">
                        <tbody>
                            <tr><td>Today, 09:14</td><td>192.168.1.4</td><td><span class="badge badge--approved">Success</span></td></tr>
                            <tr><td>Yesterday, 17:02</td><td>192.168.1.4</td><td><span class="badge badge--approved">Success</span></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
