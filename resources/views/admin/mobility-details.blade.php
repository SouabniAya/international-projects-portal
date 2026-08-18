@extends('layouts.admin')



@section('title', 'Partner Management')

@php
    // Placeholder data -- replace with real Mobility model/query later (lookup by $id)
    $mobility = [
        'direction' => 'Outgoing',
        'status' => 'Open',
        'institution' => 'Université de Barcelona',
        'institution_logo' => 'images/partners/barcelona.png',
        'title' => 'Erasmus+ Student Mobility',
        'subtitle' => 'Fall Semester 2025',
        'location' => 'Barcelona, Spain',
        'host' => 'University of Barcelona',
        'tags' => ['Erasmus+', 'Academic Mobility', 'Students'],
        'overview' => 'This mobility opportunity is offered within the Erasmus+ Programme. Selected students will have the chance to study at the University of Barcelona for one semester and gain international academic experience.',
        'about' => "The University of Barcelona is one of Spain's leading research universities, offering a wide range of academic programs and a vibrant international environment.",
        'website' => '#',
    ];

    $keyInfoLeft = [
        ['label' => 'Mobility Type', 'value' => 'Study'],
        ['label' => 'Programme', 'value' => 'Erasmus+'],
        ['label' => 'Host Institution', 'value' => 'University of Barcelona'],
        ['label' => 'Country / City', 'value' => 'Spain, Barcelona'],
        ['label' => 'Target Audience', 'value' => 'Undergraduate & Master Students'],
        ['label' => 'Number of Places', 'value' => '4'],
        ['label' => 'Duration', 'value' => '5 Months'],
        ['label' => 'Period', 'value' => 'Sep 2025 – Jan 2026'],
    ];

    $keyInfoRight = [
        ['label' => 'Application Deadline', 'value' => 'May 31, 2025', 'highlight' => true],
        ['label' => 'Language of Instruction', 'value' => 'English'],
        ['label' => 'Language Requirements', 'value' => 'B2 English'],
        ['label' => 'Financial Support', 'value' => 'Erasmus+ Grant'],
        ['label' => 'Documents Required', 'value' => 'See below'],
        ['label' => 'Application Procedure', 'value' => 'Online'],
        ['label' => 'Selection Criteria', 'value' => 'Academic merit, Motivation'],
        ['label' => 'Contact', 'value' => 'international@esi.dz', 'link' => true],
    ];

    $importantDates = [
        ['label' => 'Opening Date', 'value' => 'Mar 15, 2025'],
        ['label' => 'Application Deadline', 'value' => 'May 31, 2025', 'highlight' => true],
        ['label' => 'Selection Results', 'value' => 'Jun 20, 2025'],
        ['label' => 'Nomination Deadline', 'value' => 'Jun 30, 2025'],
        ['label' => 'Start of Mobility', 'value' => 'Sep 15, 2025'],
        ['label' => 'End of Mobility', 'value' => 'Jan 31, 2026'],
    ];

    $requiredDocuments = [
        'Application Form',
        'Learning Agreement',
        'Transcript of Records',
        'Motivation Letter',
        'Language Certificate',
        'Copy of Passport',
    ];
@endphp

@section('content')
<div class="mob-page">

    <a href="{{ route('admin.mobility') }}" class="mob-page__back">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 6l-6 6 6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        Back to Mobility Opportunities
    </a>

    <div class="mob-page__head">
        <div>
            <h1>Mobility Opportunity Details</h1>
            <div class="mob-page__badges">
                <span class="mob-badge mob-badge--{{ \Illuminate\Support\Str::slug($mobility['direction']) }}">{{ $mobility['direction'] }}</span>
                <span class="mob-badge mob-badge--{{ \Illuminate\Support\Str::slug($mobility['status']) }}">{{ $mobility['status'] }}</span>
            </div>
        </div>
        <div class="mob-page__actions">
            <a href="{{ $mobility['website'] }}" class="mob-page__btn mob-page__btn--primary">
                Apply Now
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7 17L17 7M9 7h8v8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </a>
            <button type="button" class="mob-page__btn mob-page__btn--secondary">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 3h12v18l-6-4-6 4V3Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                Save Opportunity
            </button>
        </div>
    </div>

    <div class="mob-layout">

        {{-- Main column --}}
        <div class="mob-main">

            <div class="mob-card mob-card--intro">
                <div class="mob-intro">
                    <img src="{{ asset($mobility['institution_logo']) }}" alt="" class="mob-intro__logo">
                    <div>
                        <span class="mob-intro__institution">{{ $mobility['institution'] }}</span>
                        <h2>{{ $mobility['title'] }}</h2>
                        <p class="mob-intro__subtitle">{{ $mobility['subtitle'] }}</p>
                        <div class="mob-intro__meta">
                            <span>
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 21s7-6.5 7-12a7 7 0 1 0-14 0c0 5.5 7 12 7 12Z" stroke="currentColor" stroke-width="1.6"/><circle cx="12" cy="9" r="2.5" stroke="currentColor" stroke-width="1.6"/></svg>
                                {{ $mobility['location'] }}
                            </span>
                            <span class="mob-intro__divider">|</span>
                            <span>{{ $mobility['host'] }}</span>
                        </div>
                        <div class="mob-intro__tags">
                            @foreach ($mobility['tags'] as $tag)
                            <span class="mob-tag">{{ $tag }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="mob-section">
                    <h3>Overview</h3>
                    <p>{{ $mobility['overview'] }}</p>
                </div>

                <div class="mob-section">
                    <h3>Key Information</h3>
                    <div class="mob-keyinfo">
                        <ul class="mob-keyinfo__col">
                            @foreach ($keyInfoLeft as $item)
                            <li>
                                <span class="mob-keyinfo__label">{{ $item['label'] }}</span>
                                <span class="mob-keyinfo__value">{{ $item['value'] }}</span>
                            </li>
                            @endforeach
                        </ul>
                        <ul class="mob-keyinfo__col">
                            @foreach ($keyInfoRight as $item)
                            <li>
                                <span class="mob-keyinfo__label">{{ $item['label'] }}</span>
                                @if(!empty($item['link']))
                                    <a href="mailto:{{ $item['value'] }}" class="mob-keyinfo__value mob-keyinfo__value--link">{{ $item['value'] }}</a>
                                @else
                                    <span class="mob-keyinfo__value @if(!empty($item['highlight'])) mob-keyinfo__value--highlight @endif">{{ $item['value'] }}</span>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="mob-section">
                    <h3>About the Host Institution</h3>
                    <p>{{ $mobility['about'] }}</p>
                    <a href="{{ $mobility['website'] }}" class="mob-link">
                        Visit institution website
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7 17L17 7M9 7h8v8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                </div>
            </div>
        </div>

        {{-- Sidebar column --}}
        <aside class="mob-side">

            <div class="mob-card">
                <h3>Important Dates</h3>
                <ul class="mob-datelist">
                    @foreach ($importantDates as $date)
                    <li>
                        <span class="mob-datelist__label">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="5" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M8 3v4M16 3v4M3 10h18" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                            {{ $date['label'] }}
                        </span>
                        <span class="mob-datelist__value @if(!empty($date['highlight'])) mob-datelist__value--highlight @endif">{{ $date['value'] }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>

            <div class="mob-card">
                <h3>Required Documents</h3>
                <ul class="mob-doclist">
                    @foreach ($requiredDocuments as $doc)
                    <li>
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 2h9l5 5v15H6V2Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M15 2v5h5" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                        {{ $doc }}
                    </li>
                    @endforeach
                </ul>
            </div>

            <div class="mob-card">
                <h3>Share Opportunity</h3>
                <div class="mob-share">
                    <a href="#" aria-label="Share on LinkedIn" class="mob-share__btn mob-share__btn--linkedin">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 3A2 2 0 0 1 21 5v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14ZM8.34 18.34V10.1H5.67v8.24h2.67ZM7 8.94a1.55 1.55 0 1 0 0-3.1 1.55 1.55 0 0 0 0 3.1ZM18.34 18.34v-4.52c0-2.42-1.29-3.55-3.02-3.55-1.39 0-2.01.77-2.36 1.3v-1.11h-2.67c.04.75 0 8.24 0 8.24h2.67v-4.6c0-.25.02-.5.1-.68.2-.5.68-1.03 1.47-1.03 1.04 0 1.46.79 1.46 1.94v4.37h2.67Z"/></svg>
                    </a>
                    <a href="#" aria-label="Share on Facebook" class="mob-share__btn mob-share__btn--facebook">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M22 12a10 10 0 1 0-11.56 9.88v-6.99H7.9V12h2.54V9.8c0-2.5 1.49-3.89 3.77-3.89 1.09 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.63.77-1.63 1.56V12h2.78l-.44 2.89h-2.34v6.99A10 10 0 0 0 22 12Z"/></svg>
                    </a>
                    <a href="#" aria-label="Share on X" class="mob-share__btn mob-share__btn--x">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.24 3H21l-6.5 7.43L22 21h-6.19l-4.84-6.32L5.4 21H2.62l6.96-7.95L2 3h6.34l4.38 5.78L18.24 3Zm-1.08 16.17h1.53L7.9 4.74H6.26l10.9 14.43Z"/></svg>
                    </a>
                    <a href="#" aria-label="Share via Email" class="mob-share__btn mob-share__btn--email">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="5" width="18" height="14" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M3 7l9 6 9-6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                </div>
            </div>

        </aside>

    </div>

</div>
@endsection
