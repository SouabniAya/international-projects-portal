@extends('layouts.admin')

@section('title', __('School Presentation'))
@php($active = 'cooperation')

@section('content')
<div class="section__header section__header--row" style="margin-bottom:18px;">
    <div>
        <h2 style="margin:0;">{{ __('School Presentation') }}</h2>
        <p style="margin:4px 0 0;">{{ __('Manage the public presentation content and office information.') }}</p>
    </div>
    <a href="{{ route('admin.school-presentation.edit') }}" class="btn btn--primary btn--sm">{{ __('Edit content') }}</a>
</div>

@if(session('success'))
    <div class="alert alert--success" style="margin-bottom:18px;">{{ session('success') }}</div>
@endif

<div class="card" style="margin-bottom:20px;">
    <div class="card__body">
        @php($translation = $presentation?->translations->firstWhere('languageCode', app()->getLocale()) ?? $presentation?->translations->firstWhere('languageCode', 'en') ?? $presentation?->translations->first())

        <h3 style="margin-top:0;">{{ __('Overview') }}</h3>
        <p style="line-height:1.7; margin:0;">{{ $translation?->description ?: __('No description has been added yet.') }}</p>
    </div>
</div>

<div class="card">
    <div class="card__body" style="display:grid; gap:18px;">
        <div>
            <h3 style="margin:0 0 8px;">{{ __('Vision') }}</h3>
            <p style="margin:0; line-height:1.7;">{{ $translation?->vision ?: __('No vision statement has been added yet.') }}</p>
        </div>
        <div>
            <h3 style="margin:0 0 8px;">{{ __('Internationalization Strategy') }}</h3>
            <p style="margin:0; line-height:1.7;">{{ $translation?->internationalizationStrategy ?: __('No strategy information has been added yet.') }}</p>
        </div>
        <div>
            <h3 style="margin:0 0 8px;">{{ __('Mission & Objectives') }}</h3>
            <p style="margin:0; line-height:1.7;">{{ $translation?->missions ?: __('No mission information has been added yet.') }}</p>
            <p style="margin:8px 0 0; line-height:1.7;">{{ $translation?->objectives ?: __('No objectives information has been added yet.') }}</p>
        </div>
        <div>
            <h3 style="margin:0 0 8px;">{{ __('Office Contact') }}</h3>
            <p style="margin:0; line-height:1.7;">{{ __('Email') }}: {{ $presentation?->officeEmail ?: __('Not set') }}</p>
            <p style="margin:6px 0 0; line-height:1.7;">{{ __('Phone') }}: {{ $presentation?->officePhone ?: __('Not set') }}</p>
            <p style="margin:6px 0 0; line-height:1.7;">{{ __('Address') }}: {{ $translation?->officeAddress ?: __('Not set') }}</p>
            <p style="margin:6px 0 0; line-height:1.7;">{{ __('Location') }}: {{ $translation?->officeLocation ?: __('Not set') }}</p>
        </div>
    </div>
</div>
@endsection