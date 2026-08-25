@extends('layouts.admin')

@section('title', $partner->partnerName ?? 'Partner Details')

@section('content')

<div class="ptm-page">

    <a href="{{ route('admin.partner-management') }}" class="ptm-page__back">
        <svg viewBox="0 0 24 24" fill="none">
            <path d="M15 6l-6 6 6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Back to Partners
    </a>

    <div class="ptm-page__head">
        <div>
            <h1>{{ $partner->partnerName ?? 'Unnamed Partner' }}</h1>
            <p>Partner profile and cooperation details.</p>
        </div>

        @if(Route::has('admin.partner-management.edit'))
            <a href="{{ route('admin.partner-management.edit', $partner->partnerID) }}" class="ptm-page__btn ptm-page__btn--outline">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M4 20h4l10.5-10.5a2.1 2.1 0 0 0-3-3L5 17v3Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                    <path d="M13.5 7.5l3 3" stroke="currentColor" stroke-width="1.6"/>
                </svg>
                Edit Partner
            </a>
        @endif
    </div>

    <div class="ptm-form-card">
        <div class="ptm-form-card__header">
            <h2>Partner Information</h2>
        </div>

        <div class="ptm-form-grid">
            <div class="ptm-form-field">
                <label>Partner Name</label>
                <p>{{ $partner->partnerName ?? '—' }}</p>
            </div>

            <div class="ptm-form-field">
                <label>Country</label>
                <p>{{ $partner->country?->translations?->firstWhere('languageCode', app()->getLocale())?->countryName ?? '—' }}</p>
            </div>

            <div class="ptm-form-field">
                <label>City</label>
                <p>{{ $partner->city ?? '—' }}</p>
            </div>

            <div class="ptm-form-field">
                <label>Type of Institution</label>
                <p>{{ $partner->establishmentType ?? '—' }}</p>
            </div>

            <div class="ptm-form-field">
                <label>Partnership Type</label>
                <p>{{ $partner->partnershipType ?? '—' }}</p>
            </div>

            <div class="ptm-form-field">
                <label>Partnership Status</label>
                <p>
                    @php
                        $status = $partner->partnershipStatus ?? 'Unknown';
                        $statusClass = \Illuminate\Support\Str::slug($status);
                    @endphp
                    <span class="ptm-table__status ptm-table__status--{{ $statusClass }}">{{ ucfirst($status) }}</span>
                </p>
            </div>

            @if($partner->website)
            <div class="ptm-form-field">
                <label>Website</label>
                <p><a href="{{ $partner->website }}" target="_blank" rel="noopener">{{ $partner->website }}</a></p>
            </div>
            @endif
        </div>
    </div>

    @if($partner->logo)
    <div class="ptm-form-card">
        <div class="ptm-form-card__header">
            <h2>Logo</h2>
        </div>
        <img src="{{ asset($partner->logo) }}" alt="{{ $partner->partnerName }}" style="max-width: 160px; border-radius: 8px;">
    </div>
    @endif

    @if($partner->thematicAreas && $partner->thematicAreas->count())
    <div class="ptm-form-card">
        <div class="ptm-form-card__header">
            <h2>Domains of Cooperation</h2>
        </div>
        <div class="ptm-form-field--full">
            @foreach($partner->thematicAreas as $area)
                <span class="ptm-table__tag">{{ $area->translations->firstWhere('languageCode', app()->getLocale())?->areaName ?? '—' }}</span>
            @endforeach
        </div>
    </div>
    @endif

    @php
        $presentation = $partner->translations->firstWhere('languageCode', app()->getLocale())?->presentation ?? null;
    @endphp
    @if($presentation)
    <div class="ptm-form-card">
        <div class="ptm-form-card__header">
            <h2>Presentation</h2>
        </div>
        <p>{{ $presentation }}</p>
    </div>
    @endif

</div>

@endsection