@extends('layouts.app')

@section('title', 'Mobility Opportunities')

@section('content')
<section class="mobility-hero">
    <div class="mobility-hero__inner">
        <h1>{{ __('Mobility Opportunities') }}</h1>
        <p>{{ __('Explore student and staff mobility opportunities with our international partner universities.') }}</p>
    </div>
</section>

<section class="mobility-toolbar-wrap">
    <div class="mobility-toolbar">
        <div class="mobility-toolbar__search">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/>
                <path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            <input type="search" placeholder="{{ __('Search...') }}">
        </div>

        <div class="mobility-toolbar__filter">
            <span>{{ __('Type') }}</span>
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
        <div class="mobility-toolbar__filter">
            <span>{{ __('Programme') }}</span>
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
        <div class="mobility-toolbar__filter">
            <span>{{ __('Status') }}</span>
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
    </div>
</section>

<section class="mobility-grid-wrap">
    <div class="mobility-grid">
        @php
        // Placeholder data — replace with a real MobilityOpportunity model/query later
        $opportunities = [
            ['id' => 1, 'title' => 'Erasmus+ Student Mobility', 'sub' => 'Fall Semester 2025', 'university' => 'Université de Barcelona', 'city' => 'Barcelona, Spain', 'direction' => 'Outgoing', 'status' => 'Open', 'tags' => ['Erasmus+', 'Academic Mobility', 'Students'], 'deadline' => 'May 31, 2025'],
            ['id' => 2, 'title' => 'Staff Training Mobility', 'sub' => 'Spring 2025', 'university' => 'Technische Universität München', 'city' => 'Munich, Germany', 'direction' => 'Outgoing', 'status' => 'Open', 'tags' => ['Erasmus+', 'Staff Training'], 'deadline' => 'Apr 20, 2025'],
            ['id' => 3, 'title' => 'Incoming Research Mobility', 'sub' => 'Full Year 2025-2026', 'university' => 'Université Paris-Saclay', 'city' => 'Paris, France', 'direction' => 'Incoming', 'status' => 'Open Soon', 'tags' => ['Horizon Europe', 'Research'], 'deadline' => 'Jun 15, 2025'],
            ['id' => 4, 'title' => 'PhD Exchange Programme', 'sub' => 'Fall 2025', 'university' => 'Politecnico di Milano', 'city' => 'Milan, Italy', 'direction' => 'Outgoing', 'status' => 'Closed', 'tags' => ['MSCA', 'Doctoral'], 'deadline' => 'Mar 10, 2025'],
            ['id' => 5, 'title' => 'Short-Term Student Mobility', 'sub' => 'Summer School 2025', 'university' => 'University of Cambridge', 'city' => 'Cambridge, UK', 'direction' => 'Outgoing', 'status' => 'Open', 'tags' => ['Academic Mobility', 'Students'], 'deadline' => 'May 5, 2025'],
            ['id' => 6, 'title' => 'Faculty Exchange Programme', 'sub' => 'Academic Year 2025-2026', 'university' => 'Eindhoven University of Technology', 'city' => 'Eindhoven, Netherlands', 'direction' => 'Incoming', 'status' => 'Open', 'tags' => ['Erasmus+', 'Staff Training'], 'deadline' => 'Jun 30, 2025'],
        ];
        @endphp

        @foreach($opportunities as $opp)
        <article class="mobility-card">
            <div class="mobility-card__top">
                <div class="mobility-card__logo"></div>
                <div class="mobility-card__badges">
                    <span class="mobility-card__badge mobility-card__badge--direction">{{ __($opp['direction']) }}</span>
                    <span class="mobility-card__badge mobility-card__badge--status mobility-card__badge--{{ \Illuminate\Support\Str::slug($opp['status']) }}">{{ __($opp['status']) }}</span>
                </div>
            </div>

            <h3 class="mobility-card__title">{{ $opp['title'] }}</h3>
            <p class="mobility-card__sub">{{ $opp['sub'] }}</p>

            <p class="mobility-card__location">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 21s7-6.5 7-11.5A7 7 0 0 0 5 9.5C5 14.5 12 21 12 21Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><circle cx="12" cy="9.5" r="2.4" stroke="currentColor" stroke-width="1.6"/></svg>
                {{ $opp['city'] }} &middot; {{ $opp['university'] }}
            </p>

            <div class="mobility-card__tags">
                @foreach($opp['tags'] as $tag)
                <span>{{ __($tag) }}</span>
                @endforeach
            </div>

            <div class="mobility-card__bottom">
                <span class="mobility-card__deadline">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="5" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M8 3v4M16 3v4M3 10h18" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                    {{ $opp['deadline'] }}
                </span>
                <a href="{{ route('mobility.show', $opp['id']) }}" class="mobility-card__link">{{ __('See Details') }} →</a>
            </div>
        </article>
        @endforeach
    </div>

    <nav class="mobility-pagination" aria-label="Mobility pagination">
        <button type="button" aria-label="{{ __('Previous page') }}">‹</button>
        <button type="button" class="is-active">1</button>
        <button type="button">2</button>
        <button type="button">3</button>
        <span>…</span>
        <button type="button">6</button>
        <button type="button" aria-label="{{ __('Next page') }}">›</button>
    </nav>
</section>
@endsection