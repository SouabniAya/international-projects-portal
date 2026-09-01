@extends('layouts.app')

@section('title', $title)

@php
    $t = $m->translation();
    $countryLabel = trim(($m->city ?? '') . ($m->city && $m->country?->translation()?->countryName ? ', ' : '') . ($m->country?->translation()?->countryName ?? ''));
@endphp

@section('content')
<div class="mobility-details">

    <div class="mobility-details__inner">

        <a href="{{ route('mobility.index') }}" class="mobility-details__back">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 6l-6 6 6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            {{ __('Back to Mobility Opportunities') }}
        </a>

        <div class="mobility-details__head">
            <div>
                <h1>{{ $title }}</h1>
                <div class="mobility-details__badges">
                    <span class="mobility-details__badge mobility-details__badge--direction">{{ __($direction) }}</span>
                    <span class="mobility-details__badge mobility-details__badge--open">{{ __($status) }}</span>
                </div>
            </div>
            <div class="mobility-details__actions">
                <a href="{{ $m->applicationLink }}" target="_blank" rel="noopener" class="mobility-details__btn mobility-details__btn--solid">
                    {{ __('Apply Now') }}
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7 17L17 7M9 7h8v8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a>
                <a href="#" class="mobility-details__btn mobility-details__btn--outline">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 3h12v18l-6-4-6 4V3Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                    {{ __('Save Opportunity') }}
                </a>
            </div>
        </div>

        <div class="mobility-details__layout">

            <div class="mobility-details__main">

                <div class="mobility-details__card">
                    <div class="mobility-details__card-top">
                        <div class="mobility-details__logo"></div>
                        <div>
                            <span class="mobility-details__university">{{ $m->hostingEstablishment }}</span>
                            <h2>{{ $title }}</h2>
                            <p class="mobility-details__sub">{{ \Carbon\Carbon::parse($m->startDate)->translatedFormat('F Y') }}</p>
                            <p class="mobility-details__location">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 21s7-6.5 7-11.5A7 7 0 0 0 5 9.5C5 14.5 12 21 12 21Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><circle cx="12" cy="9.5" r="2.4" stroke="currentColor" stroke-width="1.6"/></svg>
                                {{ $countryLabel ?: '—' }}
                            </p>
                            <div class="mobility-details__tags">
                                @if($programmeName)<span>{{ $programmeName }}</span>@endif
                                <span>{{ $title }}</span>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <h3>{{ __('Overview') }}</h3>
                    <p>{{ $t?->conditions ?? __('No additional overview provided for this opportunity.') }}</p>

                    <h3>{{ __('Key Information') }}</h3>
                    <div class="mobility-details__info-grid">
                        <div>
                            <div class="mobility-details__info-row"><span>{{ __('Mobility Type') }}</span><strong>{{ $title }}</strong></div>
                            <div class="mobility-details__info-row"><span>{{ __('Programme') }}</span><strong>{{ $programmeName ?? '—' }}</strong></div>
                            <div class="mobility-details__info-row"><span>{{ __('Host Institution') }}</span><strong>{{ $m->hostingEstablishment ?? '—' }}</strong></div>
                            <div class="mobility-details__info-row"><span>{{ __('Country / City') }}</span><strong>{{ $countryLabel ?: '—' }}</strong></div>
                            <div class="mobility-details__info-row"><span>{{ __('Target Audience') }}</span><strong>{{ $m->targetAudience ?? '—' }}</strong></div>
                            <div class="mobility-details__info-row"><span>{{ __('Number of Places') }}</span><strong>{{ $m->placesAvailable ?? '—' }}</strong></div>
                            <div class="mobility-details__info-row"><span>{{ __('Period') }}</span><strong>{{ optional($m->startDate)->format('M Y') }} – {{ optional($m->endDate)->format('M Y') }}</strong></div>
                        </div>
                        <div>
                            <div class="mobility-details__info-row"><span>{{ __('Application Deadline') }}</span><strong class="mobility-details__deadline">{{ optional($m->applicationDeadline)->format('M j, Y') }}</strong></div>
                            <div class="mobility-details__info-row"><span>{{ __('Language Requirements') }}</span><strong>{{ $m->requiredLanguageSkills ?? '—' }}</strong></div>
                            <div class="mobility-details__info-row"><span>{{ __('Financial Support') }}</span><strong>{{ $m->fundingAvailable ?? '—' }}</strong></div>
                            <div class="mobility-details__info-row"><span>{{ __('Application Procedure') }}</span><strong>{{ $t?->applicationProcess ?? __('See application link') }}</strong></div>
                            <div class="mobility-details__info-row"><span>{{ __('Selection Criteria') }}</span><strong>{{ $t?->selectionCriteria ?? '—' }}</strong></div>
                            <div class="mobility-details__info-row"><span>{{ __('Contact') }}</span><strong><a href="mailto:{{ $m->contact }}">{{ $m->contact }}</a></strong></div>
                        </div>
                    </div>

                    @if($m->hostPartner)
                        <h3>{{ __('About the Host Institution') }}</h3>
                        <p>{{ $m->hostPartner->translation()?->presentation ?? '' }}</p>
                        @if($m->hostPartner->website)
                            <a href="{{ $m->hostPartner->website }}" target="_blank" rel="noopener" class="mobility-details__external-link">{{ __('Visit institution website') }} ↗</a>
                        @endif
                    @endif
                </div>

            </div>

            <aside class="mobility-details__sidebar">

                <div class="mobility-details__panel">
                    <h3>{{ __('Important Dates') }}</h3>
                    <ul class="mobility-details__dates">
                        <li><span>{{ __('Application Deadline') }}</span><strong class="mobility-details__deadline">{{ optional($m->applicationDeadline)->format('M j, Y') }}</strong></li>
                        <li><span>{{ __('Start of Mobility') }}</span><strong>{{ optional($m->startDate)->format('M j, Y') }}</strong></li>
                        <li><span>{{ __('End of Mobility') }}</span><strong>{{ optional($m->endDate)->format('M j, Y') }}</strong></li>
                    </ul>
                </div>

                @if($m->documents->isNotEmpty())
                    <div class="mobility-details__panel">
                        <h3>{{ __('Related Documents') }}</h3>
                        <ul class="mobility-details__docs">
                            @foreach($m->documents as $md)
                                <li>{{ $md->document->title ?? __('Document') }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mobility-details__panel">
                    <h3>{{ __('Share Opportunity') }}</h3>
                    <div class="mobility-details__share">
                        <a href="#" aria-label="LinkedIn">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><rect width="24" height="24" rx="4" fill="#0A66C2"/><path d="M7.2 9.5H4.6V19h2.6V9.5ZM5.9 8.3a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3ZM19.4 19h-2.6v-5.1c0-1.2-.4-2-1.5-2-.8 0-1.3.6-1.5 1.1-.1.2-.1.5-.1.8V19h-2.6s.03-8.6 0-9.5h2.6v1.3c.3-.5 1-1.3 2.5-1.3 1.8 0 3.2 1.2 3.2 3.8V19Z" fill="#fff"/></svg>
                        </a>
                        <a href="#" aria-label="Facebook">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><rect width="24" height="24" rx="4" fill="#1877F2"/><path d="M15.5 8.5h1.5V6h-2c-1.7 0-3 1.3-3 3v1.5H10V13h2v6h2.5v-6H16l.5-2.5h-2v-1c0-.5.4-1 1-1Z" fill="#fff"/></svg>
                        </a>
                        <a href="#" aria-label="X">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><rect width="24" height="24" rx="4" fill="#000"/><path d="M6 6l12 12M18 6L6 18" stroke="#fff" stroke-width="1.8" stroke-linecap="round"/></svg>
                        </a>
                        <a href="mailto:?subject=Mobility Opportunity" aria-label="Email">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="2" y="4" width="20" height="16" rx="2" stroke="var(--color-neutral-500)" stroke-width="1.8"/><path d="M3 6l9 7 9-7" stroke="var(--color-neutral-500)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </a>
                    </div>
                </div>

            </aside>

        </div>

    </div>

</div>
@endsection
