@extends('layouts.admin')

@section('title', 'Dashboard')

@php($active = 'dashboard')

@section('content')
    <h1>{{ __('Dashboard') }}</h1>
    <p>{{ __('Admin dashboard content goes here.') }}</p>
    <p>{{ __('Placeholder — replace with the reporting widgets from UC5 (partners by country, agreement status, etc.).') }}</p>
@endsection