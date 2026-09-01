@extends('layouts.admin')

@section('title', __('Mobility Opportunity Details'))

@section('content')
<div class="project-details">

    <a href="{{ route('admin.mobility') }}" class="project-details__back">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 6l-6 6 6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        {{ __('Back to Mobility Opportunities') }}
    </a>

    <div class="project-details__head">
        <div>
            <h1>{{ __('Mobility Opportunity Details') }}</h1>
            <p>{{ __('Detailed information about this mobility opportunity.') }}</p>
        </div>

        <div class="project-details__actions">
            <a href="{{ $mobility->applicationLink ?? '#' }}"
               @if($mobility->applicationLink) target="_blank" rel="noopener" @endif
               class="project-details__btn project-details__btn--outline">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 14l10-10M14 4h6v6M20 14v6a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                {{ __('Application Link') }}
            </a>
        </div>
    </div>

    <div class="project-summary">
        <div class="project-summary__main">
            <img src="{{ asset('images/logoEsi.png') }}" alt="{{ __('Mobility') }}" class="project-summary__logo">
            <div>
                <h2>{{ $title }}</h2>
                <div class="project-summary__meta">
                    <span class="project-summary__tag">
                        {{ $mobility->programme?->translation()?->programName ?? __('Unclassified') }}
                    </span>
                    <span class="project-summary__action-type">{{ $direction }}</span>
                </div>
                <p class="project-summary__desc">
                    {{ $mobility->translation()?->conditions ?? __('No description available yet.') }}
                </p>
            </div>
        </div>

        <div class="project-summary__stats">
            <div class="project-summary__stat">
                <span>{{ __('Status') }}</span>
                <strong class="project-summary__status">{{ $status }}</strong>
            </div>
            <div class="project-summary__stat">
                <span>{{ __('Period') }}</span>
                <strong>{{ $mobility->startDate?->format('M j, Y') }} – {{ $mobility->endDate?->format('M j, Y') }}</strong>
            </div>
            <div class="project-summary__stat">
                <span>{{ __('Application Deadline') }}</span>
                <strong>{{ $mobility->applicationDeadline?->format('M j, Y') ?? '—' }}</strong>
            </div>
            <div class="project-summary__stat">
                <span>{{ __('Host Institution') }}</span>
                <strong>{{ $mobility->hostingEstablishment ?? '—' }}{{ $mobility->city ? ', ' . $mobility->city : '' }}</strong>
            </div>
        </div>
    </div>

    <div class="project-overview">
        <div class="project-overview__col">
            <div class="project-panel">
                <h3>{{ __('Mobility Information') }}</h3>
                <dl class="project-panel__list">
                    @foreach($info as $row)
                    <div class="project-panel__row">
                        <dt>{{ __($row['label']) }}</dt>
                        <dd>{{ $row['value'] }}</dd>
                    </div>
                    @endforeach
                </dl>
            </div>
        </div>

        <div class="project-overview__col">
            @if($mobility->translation()?->applicationProcess)
            <div class="project-panel project-panel--highlight">
                <h3>{{ __('Application Process') }}</h3>
                <p>{{ $mobility->translation()->applicationProcess }}</p>
            </div>
            @endif

            @if($mobility->translation()?->selectionCriteria)
            <div class="project-panel">
                <h3>{{ __('Selection Criteria') }}</h3>
                <p>{{ $mobility->translation()->selectionCriteria }}</p>
            </div>
            @endif
        </div>
    </div>

</div>
@endsection
