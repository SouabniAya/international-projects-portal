{{-- Example: resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('title', 'Dashboard')

{{-- $active tells x-admin-sidebar which nav item to highlight --}}
@php($active = 'dashboard')

@section('content')
    <h1>Admin dashboard content goes here.</h1>
    <p>Placeholder — replace with the reporting widgets from UC5 (partners by country, agreement status, etc.).</p>
@endsection
