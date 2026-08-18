@extends('layouts.admin')

@section('title', 'Opportunities')

@section('content')
<div class="opportunities-page">

    <h1>Opportunities</h1>
    <p class="opportunities-page__subtitle">Find funding calls and mobility opportunities worldwide.</p>

    <div class="opportunities-tabs">
        <button type="button" class="opportunities-tabs__btn is-active" data-tab="calls">Calls for Proposals</button>
        <button type="button" class="opportunities-tabs__btn" data-tab="mobility">Mobility Opportunities</button>
    </div>

    <div class="opportunities-layout">

        {{-- Filters sidebar --}}
        <aside class="opportunities-filters">
            <div class="opportunities-filters__head">
                <h2>Filters</h2>
                <button type="button" class="opportunities-filters__reset">Reset All</button>
            </div>

            <label class="opportunities-filters__field">
                <span>Search</span>
                <div class="opportunities-filters__search">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/>
                        <path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <input type="search" placeholder="Search opportunities...">
                </div>
            </label>

            @php
                $selects = [
                    'Programme' => 'All programmes',
                    'Country' => 'All countries',
                    'Thematic Area' => 'All areas',
                    'Target Audience' => 'All audiences',
                    'Status' => 'All statuses',
                    'Deadline' => 'Any time',
                ];
            @endphp

            @foreach($selects as $label => $default)
            <label class="opportunities-filters__field">
                <span>{{ $label }}</span>
                <div class="opportunities-filters__select">
                    <span>{{ $default }}</span>
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </label>
            @endforeach

            <button type="button" class="opportunities-filters__apply">Apply Filters</button>
        </aside>

        {{-- Results list --}}
        <div class="opportunities-list">
            @php
            // Placeholder data — replace with a real Call model/query later
            $calls = [
                ['title' => 'Horizon Europe – Research and Innovation Actions', 'tag' => 'Horizon Europe', 'audience' => 'Universities, Research Institutions', 'desc' => 'Support for excellent research and innovation projects addressing global challenges.', 'deadline' => '15 Oct 2024', 'status' => 'Open'],
                ['title' => 'Horizon Europe – Research and Innovation Actions', 'tag' => 'Horizon Europe', 'audience' => 'Universities, Research Institutions', 'desc' => 'Support for excellent research and innovation projects addressing global challenges.', 'deadline' => '15 Oct 2024', 'status' => 'Open'],
                ['title' => 'Horizon Europe – Research and Innovation Actions', 'tag' => 'Horizon Europe', 'audience' => 'Universities, Research Institutions', 'desc' => 'Support for excellent research and innovation projects addressing global challenges.', 'deadline' => '15 Oct 2024', 'status' => 'Open'],
                ['title' => 'Horizon Europe – Research and Innovation Actions', 'tag' => 'Horizon Europe', 'audience' => 'Universities, Research Institutions', 'desc' => 'Support for excellent research and innovation projects addressing global challenges.', 'deadline' => '15 Oct 2024', 'status' => 'Open'],
            ];
            @endphp

            @foreach($calls as $call)
            <article class="opportunity-card">
                <div class="opportunity-card__logo">
                    <img src="{{ asset('images/erasmus-badge.webp') }}" alt="">
                </div>

                <div class="opportunity-card__body">
                    <div class="opportunity-card__head">
                        <h3>{{ $call['title'] }}</h3>
                        <span class="opportunity-card__status">{{ $call['status'] }}</span>
                    </div>

                    <div class="opportunity-card__meta">
                        <span class="opportunity-card__tag">{{ $call['tag'] }}</span>
                        <span class="opportunity-card__audience">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <circle cx="8" cy="8" r="3" stroke="currentColor" stroke-width="1.6"/>
                                <path d="M2 20c0-3 2.7-5 6-5s6 2 6 5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                                <circle cx="17" cy="9" r="2.6" stroke="currentColor" stroke-width="1.6"/>
                                <path d="M15 20c.3-2.4 2.2-4 4.5-4s4.2 1.6 4.5 4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                            </svg>
                            {{ $call['audience'] }}
                        </span>
                    </div>

                    <p class="opportunity-card__desc">{{ $call['desc'] }}</p>

                    <div class="opportunity-card__footer">
                        <span class="opportunity-card__deadline">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <rect x="3" y="5" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.6"/>
                                <path d="M8 3v4M16 3v4M3 10h18" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                            </svg>
                            Deadline: {{ $call['deadline'] }}
                        </span>
                        <a href="#" class="opportunity-card__view">View Details →</a>

                        <div class="opportunity-card__actions">
                            <a href="#" class="opportunity-card__btn opportunity-card__btn--outline">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M10 14l10-10M14 4h6v6M20 14v6a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                Official Link
                            </a>
                            <a href="#" class="opportunity-card__btn opportunity-card__btn--solid">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M12 3v12m0 0l-4-4m4 4l4-4M5 21h14" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                Download Documents
                            </a>
                        </div>
                    </div>
                </div>
            </article>
            @endforeach
        </div>

    </div>
</div>
@endsection