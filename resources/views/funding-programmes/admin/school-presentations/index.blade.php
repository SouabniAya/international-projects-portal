@extends('layouts.admin')

@section('title', 'School Presentation')
@php($active = 'cooperation')

@section('content')
<div class="section__header section__header--row" style="margin-bottom:18px;">
    <div>
        <h2 style="margin:0;">School Presentation</h2>
        <p style="margin:4px 0 0;">Manage the public presentation content and office information.</p>
    </div>
    <a href="{{ route('admin.school-presentation.edit') }}" class="btn btn--primary btn--sm">Edit content</a>
</div>

@if(session('success'))
    <div class="alert alert--success" style="margin-bottom:18px;">{{ session('success') }}</div>
@endif

<div class="card" style="margin-bottom:20px;">
    <div class="card__body">
        @php($translation = $presentation?->translations->firstWhere('languageCode', app()->getLocale()) ?? $presentation?->translations->firstWhere('languageCode', 'en') ?? $presentation?->translations->first())

        <h3 style="margin-top:0;">Overview</h3>
        <p style="line-height:1.7; margin:0;">{{ $translation?->description ?: 'No description has been added yet.' }}</p>
    </div>
</div>

<div class="card">
    <div class="card__body" style="display:grid; gap:18px;">
        <div>
            <h3 style="margin:0 0 8px;">Vision</h3>
            <p style="margin:0; line-height:1.7;">{{ $translation?->vision ?: 'No vision statement has been added yet.' }}</p>
        </div>
        <div>
            <h3 style="margin:0 0 8px;">Internationalization Strategy</h3>
            <p style="margin:0; line-height:1.7;">{{ $translation?->internationalizationStrategy ?: 'No strategy information has been added yet.' }}</p>
        </div>
        <div>
            <h3 style="margin:0 0 8px;">Mission & Objectives</h3>
            <p style="margin:0; line-height:1.7;">{{ $translation?->missions ?: 'No mission information has been added yet.' }}</p>
            <p style="margin:8px 0 0; line-height:1.7;">{{ $translation?->objectives ?: 'No objectives information has been added yet.' }}</p>
        </div>
        <div>
            <h3 style="margin:0 0 8px;">Office Contact</h3>
            <p style="margin:0; line-height:1.7;">Email: {{ $presentation?->officeEmail ?: 'Not set' }}</p>
            <p style="margin:6px 0 0; line-height:1.7;">Phone: {{ $presentation?->officePhone ?: 'Not set' }}</p>
            <p style="margin:6px 0 0; line-height:1.7;">Address: {{ $translation?->officeAddress ?: 'Not set' }}</p>
            <p style="margin:6px 0 0; line-height:1.7;">Location: {{ $translation?->officeLocation ?: 'Not set' }}</p>
        </div>
    </div>
</div>
@endsection
