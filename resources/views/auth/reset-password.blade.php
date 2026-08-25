{{-- resources/views/auth/reset-password.blade.php — UC2 alternate flow A1/A2 --}}
@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')

<h1 class="auth-card__title">Choose a New Password</h1>
<p class="auth-card__subtitle">Enter a new password for your account.</p>

@if ($errors->any())
    <div class="alert alert--danger" style="margin-bottom:20px;">
        {{ $errors->first() }}
    </div>
@endif

<form method="POST" action="{{ route('password.update') }}">
    @csrf

    <input type="hidden" name="token" value="{{ $token }}">

    <div class="form-group">
        <label class="form-label" for="email">Email</label>
        <input class="form-control" type="email" id="email" name="email" value="{{ old('email', $email) }}" autocomplete="username" required autofocus>
    </div>

    <div class="form-group">
        <label class="form-label" for="password">New Password</label>
        <input class="form-control" type="password" id="password" name="password" autocomplete="new-password" required minlength="8">
    </div>

    <div class="form-group">
        <label class="form-label" for="password_confirmation">Confirm New Password</label>
        <input class="form-control" type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password" required minlength="8">
    </div>

    <button type="submit" class="btn btn--primary" style="width:100%;">Reset Password</button>
</form>

<a href="{{ route('login') }}" class="auth-card__back">← Back to Sign In</a>

@endsection