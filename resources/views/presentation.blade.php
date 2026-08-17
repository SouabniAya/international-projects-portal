{{-- resources/views/presentation.blade.php — FR-2.1 to FR-2.4 --}}
@extends('layouts.app')

@section('title', 'International Presentation')

@section('content')

<x-page-hero
    :title="__('pages.presentation.title')"
    :subtitle="__('pages.presentation.subtitle')"
    breadcrumb="<a href='{{ url('/') }}'>{{ __('nav.home') }}</a> / International Presentation">
</x-page-hero>

<section class="section two-col">
    <div>
        <div class="section__header">
            <h2>Our Vision</h2>
        </div>
        <p style="font-family:var(--font-body); line-height:1.7; color:var(--color-ink-black);">
            ESI aims to be a recognized regional hub for excellence in computer science education and research,
            connected to leading international institutions through active cooperation, joint research, and
            student and staff mobility programmes.
        </p>

        <div class="section__header" style="margin-top:40px;">
            <h2>Internationalization Strategy</h2>
        </div>
        <p style="font-family:var(--font-body); line-height:1.7; color:var(--color-ink-black);">
            Our strategy focuses on three pillars: expanding academic mobility for students and researchers,
            deepening joint research initiatives with partner institutions, and strengthening our participation
            in international funding programmes such as Erasmus+, Horizon Europe, and PRIMA.
        </p>

        <div class="section__header" style="margin-top:40px;">
            <h2>Missions &amp; Objectives</h2>
        </div>
        <ul style="font-family:var(--font-body); line-height:1.9; color:var(--color-ink-black); padding-left:20px;">
            <li>Facilitate international academic mobility for students, researchers, and staff.</li>
            <li>Build and maintain long-term partnerships with universities and research institutions.</li>
            <li>Support participation in international research and funding programmes.</li>
            <li>Promote ESI's visibility and reputation on the international stage.</li>
        </ul>

        <div class="section__header" style="margin-top:40px;">
            <h2>Teaching &amp; Research Domains</h2>
        </div>
        <p style="font-family:var(--font-body); line-height:1.7; color:var(--color-ink-black);">
            Artificial Intelligence, Data Science, Software Engineering, Cybersecurity, Embedded Systems, and
            Human-Computer Interaction — supported by dedicated research teams and training programmes.
        </p>
        <div class="card-grid" style="margin-top:20px;">
            <div class="card"><div class="card__body">
                <h3 class="card__title">AI &amp; Data Science Lab</h3>
                <p class="card__text">Research team focused on machine learning and applied data science.</p>
            </div></div>
            <div class="card"><div class="card__body">
                <h3 class="card__title">Cybersecurity Research Group</h3>
                <p class="card__text">Research team working on network security and cryptography.</p>
            </div></div>
        </div>
    </div>

    <aside>
        <div class="card">
            <div class="card__body">
                <h3 class="card__title">Partnership Benefits</h3>
                <p class="card__text">Access to joint research funding, shared infrastructure, student exchange pipelines, and co-supervised theses.</p>
            </div>
        </div>
        <div class="card" style="margin-top:20px;">
            <div class="card__body">
                <h3 class="card__title">Academic Calendar</h3>
                <p class="card__text">Semester 1: mid-September – late January.<br>Semester 2: mid-February – late June.</p>
            </div>
        </div>
        <div class="card" style="margin-top:20px;">
            <div class="card__body">
                <h3 class="card__title">Registration Procedure</h3>
                <p class="card__text">Incoming students should contact the International Relations Office at least 8 weeks before the semester start.</p>
                <a href="{{ url('/contact') }}" class="btn btn--outline btn--sm" style="margin-top:8px;">Contact the office</a>
            </div>
        </div>
        <a href="{{ url('/documents') }}" class="btn btn--primary" style="margin-top:20px; width:100%;">Download institutional brochure</a>
    </aside>
</section>

@endsection
