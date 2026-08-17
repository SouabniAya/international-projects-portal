{{-- resources/views/auth/login.blade.php — UC2 Authentication --}}
@extends('layouts.auth')

@section('title', 'Sign In')

@section('content')

<h1 class="auth-card__title">Staff Sign In</h1>
<p class="auth-card__subtitle">Enter your credentials to access the administration area.</p>

@if ($errors->any())
    <div class="alert alert--danger" style="margin-bottom:20px;">
        {{ $errors->first() }}
    </div>
@endif

<form method="POST" action="{{ route('login.store') }}" data-demo-submit="Signed in (demo — connect this route to real authentication).">
    @csrf

    <div class="form-group">
        <label class="form-label" for="email">Email</label>
        <input class="form-control" type="email" id="email" name="email" autocomplete="username" required autofocus>
    </div>

    <div class="form-group">
        <label class="form-label" for="password">Password</label>
        <input class="form-control" type="password" id="password" name="password" autocomplete="current-password" required>
    </div>

    <div class="auth-card__row">
        <label class="auth-card__remember">
            <input type="checkbox" name="remember">
            Remember me
        </label>
        <a href="{{ route('password.request') }}" class="auth-card__link">Forgot password?</a>
    </div>

    <button type="submit" class="btn btn--primary" style="width:100%;">Sign In</button>

    <p class="auth-card__hint">
        Two-factor authentication will be requested here automatically once enabled on your account (FR-12.3).
    </p>
</form>

<a href="{{ url('/') }}" class="auth-card__back">← Back to the public portal</a>

@endsection
