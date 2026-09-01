{{-- resources/views/auth/forgot-password.blade.php — UC2 alternate flow A1/A2 --}}
@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('content')

<h1 class="auth-card__title">Reset Your Password</h1>
<p class="auth-card__subtitle">Enter your email and we'll send you a link to reset your password.</p>

@if (session('status'))
    <div class="alert alert--info" style="margin-bottom:20px;">{{ session('status') }}</div>
@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <div class="form-group">
        <label class="form-label" for="email">Email</label>
        <input class="form-control" type="email" id="email" name="email" autocomplete="username" required autofocus>
    </div>

    <button type="submit" class="btn btn--primary" style="width:100%;">Send Reset Link</button>
</form>

<a href="{{ route('login') }}" class="auth-card__back">← Back to Sign In</a>

@endsection
