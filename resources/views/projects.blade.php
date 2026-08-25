@extends('layouts.app')

@section('title', 'International Projects')

@section('content')

<section class="projects-hero">
    <div class="projects-hero__inner">
        <h1>{{ __('International Projects') }}</h1>

        <p>
            {{ __('Discover our international research and cooperation projects, developed in partnership with universities and institutions around the world.') }}
        </p>
    </div>
</section>

<section class="projects-toolbar-wrap">
    <div class="projects-toolbar">

        <div class="projects-toolbar__search">
            <svg viewBox="0 0 24 24" fill="none"
                 xmlns="http://www.w3.org/2000/svg"
                 aria-hidden="true">
                <circle cx="11" cy="11" r="7"
                        stroke="currentColor"
                        stroke-width="2"/>
                <path d="M21 21l-4.3-4.3"
                      stroke="currentColor"
                      stroke-width="2"
                      stroke-linecap="round"/>
            </svg>

            <input
                type="search"
                placeholder="{{ __('Search...') }}"
            >
        </div>

        <div class="projects-toolbar__filter">
            <span>{{ __('Funding Programme') }}</span>

            <svg viewBox="0 0 24 24" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path d="M6 9l6 6 6-6"
                      stroke="currentColor"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"/>
            </svg>
        </div>

        <div class="projects-toolbar__filter">
            <span>{{ __('Status') }}</span>

            <svg viewBox="0 0 24 24" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path d="M6 9l6 6 6-6"
                      stroke="currentColor"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"/>
            </svg>
        </div>

        <div class="projects-toolbar__filter">
            <span>{{ __('Thematic Area') }}</span>

            <svg viewBox="0 0 24 24" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path d="M6 9l6 6 6-6"
                      stroke="currentColor"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"/>
            </svg>
        </div>

    </div>
</section>


@php

$projects = [

    [
        'programme' => 'Erasmus+',
        'status' => 'Ongoing',
        'title' => 'SmartEdu – Smart Education for the Digital Era',
        'desc' => 'Enhancing digital education through innovative learning solutions.',
        'tag' => 'Erasmus+',
        'thematic_area' => 'Digital Education',
        'duration' => '2025 – 2027',
        'coordinator' => 'International University Consortium',
        'countries' => 'Algeria, France, Spain, Italy',
        'partners' => '8 partner institutions',
        'budget' => '€850,000',
        'overview' => 'SmartEdu is an international cooperation project focused on improving digital education through innovative technologies, modern teaching methodologies and collaborative learning environments.',
        'objectives' => [
            'Improve digital learning environments for students and teachers.',
            'Develop innovative educational tools and resources.',
            'Strengthen cooperation between European and international universities.',
            'Promote digital skills and inclusive education.'
        ]
    ],

    [
        'programme' => 'Horizon Europe',
        'status' => 'Proposed',
        'title' => 'GreenCampus – Sustainable Universities',
        'desc' => 'Promoting sustainable and eco-friendly university campuses.',
        'tag' => 'Horizon Europe',
        'thematic_area' => 'Environment & Sustainability',
        'duration' => '2026 – 2029',
        'coordinator' => 'European Sustainable Universities Network',
        'countries' => 'Algeria, Germany, France, Belgium',
        'partners' => '12 partner institutions',
        'budget' => '€1,200,000',
        'overview' => 'GreenCampus aims to support universities in their transition towards more sustainable, energy-efficient and environmentally responsible campuses.',
        'objectives' => [
            'Reduce energy consumption across university campuses.',
            'Develop sustainable campus management strategies.',
            'Promote renewable energy and green technologies.',
            'Encourage environmental awareness among students and staff.'
        ]
    ],

    [
        'programme' => 'Erasmus+',
        'status' => 'Completed',
        'title' => 'ResearchConnect – Global Research Networks',
        'desc' => 'Strengthening international research and academic collaboration.',
        'tag' => 'Erasmus+',
        'thematic_area' => 'Research & Innovation',
        'duration' => '2023 – 2025',
        'coordinator' => 'Global Research Alliance',
        'countries' => 'Algeria, France, Germany, Portugal',
        'partners' => '10 partner institutions',
        'budget' => '€640,000',
        'overview' => 'ResearchConnect strengthened international academic cooperation by creating new research networks, mobility opportunities and collaborative research initiatives.',
        'objectives' => [
            'Create international research networks.',
            'Facilitate academic mobility.',
            'Support collaborative research projects.',
            'Increase knowledge exchange between partner institutions.'
        ]
    ],

    [
        'programme' => 'PRIMA',
        'status' => 'Ongoing',
        'title' => 'AgriTech – Smart Agriculture Solutions',
        'desc' => 'Supporting smart and sustainable agricultural innovation.',
        'tag' => 'PRIMA',
        'thematic_area' => 'Agriculture & Technology',
        'duration' => '2025 – 2028',
        'coordinator' => 'Mediterranean Agricultural Research Network',
        'countries' => 'Algeria, Tunisia, Italy, Spain',
        'partners' => '9 partner institutions',
        'budget' => '€920,000',
        'overview' => 'AgriTech promotes the use of digital technologies and smart agricultural solutions to improve productivity and sustainability in Mediterranean agriculture.',
        'objectives' => [
            'Develop smart agriculture technologies.',
            'Improve water and resource management.',
            'Support sustainable agricultural production.',
            'Promote technology transfer between research institutions and farmers.'
        ]
    ],

    [
        'programme' => 'Erasmus+',
        'status' => 'Ongoing',
        'title' => 'DigitalHealth – Innovation in Healthcare',
        'desc' => 'Developing digital solutions for modern healthcare.',
        'tag' => 'Erasmus+',
        'thematic_area' => 'Digital Health',
        'duration' => '2025 – 2027',
        'coordinator' => 'European Digital Health Consortium',
        'countries' => 'Algeria, France, Belgium, Netherlands',
        'partners' => '7 partner institutions',
        'budget' => '€780,000',
        'overview' => 'DigitalHealth focuses on the development of innovative digital solutions that can improve healthcare education, research and services.',
        'objectives' => [
            'Develop digital healthcare solutions.',
            'Improve digital health education.',
            'Support collaboration between universities and healthcare institutions.',
            'Promote innovation in healthcare services.'
        ]
    ],

    [
        'programme' => 'Horizon Europe',
        'status' => 'Proposed',
        'title' => 'GreenCampus – Sustainable Universities',
        'desc' => 'Promoting sustainable and eco-friendly university campuses.',
        'tag' => 'Horizon Europe',
        'thematic_area' => 'Environment & Sustainability',
        'duration' => '2026 – 2029',
        'coordinator' => 'European Sustainable Universities Network',
        'countries' => 'Algeria, Germany, France, Belgium',
        'partners' => '12 partner institutions',
        'budget' => '€1,200,000',
        'overview' => 'GreenCampus aims to support universities in their transition towards more sustainable, energy-efficient and environmentally responsible campuses.',
        'objectives' => [
            'Reduce energy consumption across university campuses.',
            'Develop sustainable campus management strategies.',
            'Promote renewable energy and green technologies.',
            'Encourage environmental awareness among students and staff.'
        ]
    ],

];

@endphp


<section class="projects-grid-wrap">

    <div class="projects-grid">

        @foreach($projects as $project)

            <article class="project-card">

                <div class="project-card__top">

                    <span class="project-card__logo">
                        {{ substr($project['programme'], 0, 1) }}
                    </span>

                    <h3>
                        {{ __($project['programme']) }}
                    </h3>

                    <span class="project-card__status project-card__status--{{ strtolower($project['status']) }}">
                        {{ __($project['status']) }}
                    </span>

                </div>


                <h4 class="project-card__title">
                    {{ __($project['title']) }}
                </h4>


                <p class="project-card__desc">
                    {{ __($project['desc']) }}
                </p>


                <div class="project-card__bottom">

                    <span class="project-card__tag">
                        {{ __($project['tag']) }}
                    </span>


                    <a
                        href="{{ route('partnerships.project.show', ['project' => \Illuminate\Support\Str::slug($project['title'])]) }}"
                        class="project-card__link"
                    >
                        {{ __('View Details') }} →
                    </a>

                </div>

            </article>

        @endforeach

    </div>


    <nav class="projects-pagination" aria-label="Projects pagination">

        <button type="button" aria-label="{{ __('Previous page') }}">
            ‹
        </button>

        <button type="button" class="is-active">
            1
        </button>

        <button type="button">
            2
        </button>

        <button type="button">
            3
        </button>

        <span>…</span>

        <button type="button">
            9
        </button>

        <button type="button" aria-label="{{ __('Next page') }}">
            ›
        </button>

    </nav>

</section>

@endsection