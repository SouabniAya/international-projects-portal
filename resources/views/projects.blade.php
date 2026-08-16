@extends('layouts.app')

@section('title', 'International Projects')

@section('content')
<section class="projects-hero">
    <div class="projects-hero__inner">
        <h1>{{ __('International Projects') }}</h1>
        <p>{{ __('Discover our international research and cooperation projects, developed in partnership with universities and institutions around the world.') }}</p>
    </div>
</section>

<section class="projects-toolbar-wrap">
    <div class="projects-toolbar">
        <div class="projects-toolbar__search">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/>
                <path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            <input type="search" placeholder="{{ __('Search...') }}">
        </div>

        <div class="projects-toolbar__filter">
            <span>{{ __('Funding Programme') }}</span>
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>

        <div class="projects-toolbar__filter">
            <span>{{ __('Status') }}</span>
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>

        <div class="projects-toolbar__filter">
            <span>{{ __('Thematic Area') }}</span>
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
    </div>
</section>

<section class="projects-grid-wrap">
    <div class="projects-grid">
        @php
        // Placeholder data — replace with a real Project model/query later
        $projects = [
            ['programme' => 'Erasmus+', 'status' => 'Ongoing', 'title' => 'SmartEdu – Smart Education for the Digital Era', 'desc' => 'Enhancing digital education through innovative learning solutions.', 'tag' => 'Erasmus+'],
            ['programme' => 'Horizon Europe', 'status' => 'Proposed', 'title' => 'GreenCampus – Sustainable Universities', 'desc' => 'Promoting sustainable and eco-friendly university campuses.', 'tag' => 'Horizon Europe'],
            ['programme' => 'Erasmus+', 'status' => 'Completed', 'title' => 'ResearchConnect – Global Research Networks', 'desc' => 'Strengthening international research and academic collaboration.', 'tag' => 'Erasmus+'],
            ['programme' => 'PRIMA', 'status' => 'Ongoing', 'title' => 'AgriTech – Smart Agriculture Solutions', 'desc' => 'Supporting smart and sustainable agricultural innovation.', 'tag' => 'PRIMA'],
            ['programme' => 'Erasmus+', 'status' => 'Ongoing', 'title' => 'DigitalHealth – Innovation in Healthcare', 'desc' => 'Developing digital solutions for modern healthcare.', 'tag' => 'Erasmus+'],
            ['programme' => 'Horizon Europe', 'status' => 'Proposed', 'title' => 'GreenCampus – Sustainable Universities', 'desc' => 'Promoting sustainable and eco-friendly university campuses.', 'tag' => 'Horizon Europe'],
        ];
        @endphp

        @foreach($projects as $project)
        <article class="project-card">
            <div class="project-card__top">
                <span class="project-card__logo">{{ substr($project['programme'], 0, 1) }}</span>
                <h3>{{ __($project['programme']) }}</h3>
                <span class="project-card__status project-card__status--{{ strtolower($project['status']) }}">{{ __($project['status']) }}</span>
            </div>
            <h4 class="project-card__title">{{ __($project['title']) }}</h4>
            <p class="project-card__desc">{{ __($project['desc']) }}</p>
            <div class="project-card__bottom">
                <span class="project-card__tag">{{ __($project['tag']) }}</span>
                <a href="#" class="project-card__link">{{ __('View Details') }} →</a>
            </div>
        </article>
        @endforeach
    </div>

    <nav class="projects-pagination" aria-label="Projects pagination">
        <button type="button" aria-label="{{ __('Previous page') }}">‹</button>
        <button type="button" class="is-active">1</button>
        <button type="button">2</button>
        <button type="button">3</button>
        <span>…</span>
        <button type="button">9</button>
        <button type="button" aria-label="{{ __('Next page') }}">›</button>
    </nav>
</section>
@endsection