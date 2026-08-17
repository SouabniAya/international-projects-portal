{{-- resources/views/partnerships/show.blade.php — FR-3.2, matches Figma "Partner Presentation Page" (61:1522) --}}
@extends('layouts.app')

@section('title', $partner['name'] ?? 'Partner')

@php($partner = $partner ?? [
    'name' => 'Université de Technologie de Compiègne',
    'country' => 'France',
    'city' => 'Compiègne',
    'type' => 'Public Research University',
    'partnerSince' => '2015',
    'logoDomain' => 'utc.fr',
])

@section('content')

<section class="section" style="padding-bottom:0;">
    <div class="breadcrumbs">
        <a href="{{ url('/') }}">{{ __('nav.home') }}</a> / <a href="{{ url('/partnerships') }}">Partnerships</a> / {{ $partner['name'] }}
    </div>

    <div class="partner-detail__top">
        <div class="partner-detail__identity">
            <div class="partner-detail__logo">
                @if(!empty($partner['logoDomain']))
                    <img src="https://logo.clearbit.com/{{ $partner['logoDomain'] }}" alt="{{ $partner['name'] }} logo"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <span style="display:none; align-items:center; justify-content:center; width:100%; height:100%; font-family:var(--font-heading); font-weight:700; font-size:22px; color:var(--color-deep-space-blue);">
                        {{ collect(explode(' ', $partner['name']))->map(fn($w) => strtoupper($w[0]))->take(2)->implode('') }}
                    </span>
                @else
                    <span style="display:flex; align-items:center; justify-content:center; width:100%; height:100%; font-family:var(--font-heading); font-weight:700; font-size:22px; color:var(--color-deep-space-blue);">
                        {{ collect(explode(' ', $partner['name']))->map(fn($w) => strtoupper($w[0]))->take(2)->implode('') }}
                    </span>
                @endif
            </div>
            <div>
                <div class="partner-detail__badges">
                    <span class="pill pill--outline">Academic Partner</span>
                    <span class="pill pill--filled">✓ Active</span>
                </div>
                <h1 class="partner-detail__title">{{ $partner['name'] }}</h1>
                <div class="partner-detail__meta">
                    <span>
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 21s7-6.5 7-12a7 7 0 1 0-14 0c0 5.5 7 12 7 12Z" stroke="currentColor" stroke-width="1.6"/><circle cx="12" cy="9" r="2.5" stroke="currentColor" stroke-width="1.6"/></svg>
                        {{ $partner['city'] }}, {{ $partner['country'] }}
                    </span>
                    <span>
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="4" y="3" width="16" height="18" stroke="currentColor" stroke-width="1.6"/><path d="M8 8h2M8 12h2M8 16h2M14 8h2M14 12h2M14 16h2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                        {{ $partner['type'] }}
                    </span>
                    <span>
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="5" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M3 9h18M8 3v4M16 3v4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                        Partner since {{ $partner['partnerSince'] }}
                    </span>
                </div>
            </div>
        </div>
        <a href="#" class="btn btn--outline btn--sm">Visit official website ↗</a>
    </div>
</section>

<section class="section two-col" style="padding-top:36px;">
    <div>
        <h2 class="subsection-heading">About the Institution</h2>
        <p style="font-family:var(--font-body); line-height:1.7; color:var(--color-ink-black); font-size:14.5px;">
            The {{ $partner['name'] }} is a French public research university recognized as one of the leading
            engineering schools in France, known for its innovative pedagogical approach that integrates
            engineering sciences with humanities and social sciences. It fosters a strong entrepreneurial
            spirit and maintains extensive international networks.
        </p>
        <p style="font-family:var(--font-body); line-height:1.7; color:var(--color-ink-black); font-size:14.5px; margin-top:12px;">
            Our partnership focuses on advanced research in computer science, specifically in artificial
            intelligence, complex systems modeling, and data science. The collaboration facilitates both
            faculty exchange and joint research initiatives, contributing significantly to bilateral academic
            excellence.
        </p>

        <div style="margin-top:40px;">
            <h2 class="subsection-heading">Agreements &amp; Conventions <span class="subsection-heading__count">3 Records</span></h2>
            <div class="data-table-wrap">
                <table class="data-table">
                    <thead><tr><th>Title</th><th>Type</th><th>Status</th><th>Validity</th></tr></thead>
                    <tbody>
                        <tr>
                            <td><a href="#" style="color:var(--color-cerulean); text-decoration:none; font-weight:600;">Memorandum of Understanding (MoU)</a></td>
                            <td>General Cooperation</td>
                            <td><span class="badge badge--approved">Active</span></td>
                            <td>2023 – 2028</td>
                        </tr>
                        <tr>
                            <td><a href="#" style="color:var(--color-cerulean); text-decoration:none; font-weight:600;">Erasmus+ Inter-Institutional Agreement</a></td>
                            <td>Mobility</td>
                            <td><span class="badge badge--approved">Active</span></td>
                            <td>2021 – 2027</td>
                        </tr>
                        <tr>
                            <td><a href="#" style="color:var(--color-cerulean); text-decoration:none; font-weight:600;">Cotutelle Agreement</a></td>
                            <td>Doctoral Research</td>
                            <td><span class="badge badge--completed">Expired</span></td>
                            <td>2018 – 2022</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div style="margin-top:40px;">
            <h2 class="subsection-heading">Joint Projects</h2>
            <div class="card-grid card-grid--2col">
                <div class="card">
                    <div class="card__body">
                        <span class="pill pill--outline" style="align-self:flex-start;">PHC Tassili</span>
                        <h3 class="card__title">AI for Smart Grids (AISG)</h3>
                        <p class="card__text">Developing distributed artificial intelligence models for optimizing renewable energy systems.</p>
                        <div class="card__meta">2022 – 2025 · ↻ Ongoing</div>
                    </div>
                </div>
                <div class="card">
                    <div class="card__body">
                        <span class="pill pill--outline" style="align-self:flex-start;">Erasmus+ CBHE</span>
                        <h3 class="card__title">INVENT</h3>
                        <p class="card__text">Innovation and Entrepreneurship in Higher Education. Modernizing university curricula.</p>
                        <div class="card__meta">2019 – 2022 · ✓ Completed</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <aside>
        <div class="sidebar-card">
            <h3 class="sidebar-card__heading">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="1.6"/><path d="M4 20c0-3.5 3.5-6 8-6s8 2.5 8 6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                Institutional Contact
            </h3>
            <div class="contact-row">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="1.6"/><path d="M4 20c0-3.5 3.5-6 8-6s8 2.5 8 6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                <span>
                    <strong>Direction des Relations Internationales (DRI)</strong>
                    <span class="contact-row__sub">International Relations Office</span>
                </span>
            </div>
            <div class="contact-row">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="5" width="18" height="14" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="m3 7 9 6 9-6" stroke="currentColor" stroke-width="1.6"/></svg>
                <a href="mailto:international@utc.fr">international@utc.fr</a>
            </div>
            <div class="contact-row">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 3h3l2 5-2.5 1.5a11 11 0 0 0 5 5L15 12l5 2v3a2 2 0 0 1-2 2C10.5 19 5 13.5 5 7a2 2 0 0 1 1-2Z" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/></svg>
                <span>+33 (0)3 44 23 44 23</span>
            </div>
            <div class="contact-row">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 21s7-6.5 7-12a7 7 0 1 0-14 0c0 5.5 7 12 7 12Z" stroke="currentColor" stroke-width="1.6"/><circle cx="12" cy="9" r="2.5" stroke="currentColor" stroke-width="1.6"/></svg>
                <span>Centre Benjamin Franklin<br>Rue Roger Couttolenc<br>CS 60319 - 60203 Compiègne Cedex, France</span>
            </div>
        </div>

        <div class="sidebar-card">
            <h3 class="sidebar-card__heading">Cooperation Domains</h3>
            <div style="display:flex; flex-wrap:wrap; gap:8px;">
                <span class="pill pill--outline">Computer Science</span>
                <span class="pill pill--outline">Artificial Intelligence</span>
                <span class="pill pill--outline">Data Science</span>
                <span class="pill pill--outline">Software Engineering</span>
            </div>
        </div>

        <div class="sidebar-card">
            <h3 class="sidebar-card__heading">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2.5 19.5 21 12 2.5 4.5 5 12l-2.5 7.5Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg>
                Mobility Opportunities
            </h3>
            <div class="mobility-row">
                <div class="mobility-row__top">
                    <p class="mobility-row__title">Student Exchange (S7/S8)</p>
                    <span class="badge badge--ongoing">Fall 2024</span>
                </div>
                <p class="mobility-row__audience">Audience: 2nd Year Eng.</p>
            </div>
            <div class="mobility-row">
                <div class="mobility-row__top">
                    <p class="mobility-row__title">Staff Teaching Mobility (STA)</p>
                    <span class="badge badge--open">Open</span>
                </div>
                <p class="mobility-row__audience">Audience: Faculty</p>
            </div>
            <a href="{{ url('/mobility') }}" class="partner-card__link" style="display:block; margin-top:12px; text-align:center;">View all mobility grants →</a>
        </div>
    </aside>
</section>

@endsection
