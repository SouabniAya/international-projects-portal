{{-- resources/views/funding-programmes/show.blade.php --}}
@extends('layouts.app')

@section('title', $programme['name'] ?? 'Funding Programme')

@php($programme = $programme ?? ['name' => 'Erasmus+', 'website' => '#'])

@section('content')

<x-page-hero
    :title="$programme['name']"
    subtitle="Funding programme overview, covered thematic areas, and related calls."
    breadcrumb="<a href='{{ url('/') }}'>{{ __('nav.home') }}</a> / <a href='{{ url('/calls') }}'>Calls</a> / {{ $programme['name'] }}">
</x-page-hero>

<section class="section two-col">
    <div>
        <div class="section__header">
            <h2>About the Programme</h2>
        </div>
        <p style="font-family:var(--font-body); line-height:1.7; color:var(--color-ink-black);">
            Erasmus+ is the European Union's programme supporting education, training, youth, and sport.
            It funds student and staff mobility, capacity-building projects, and strategic partnerships
            between higher education institutions in Europe and around the world.
        </p>

        <div class="section__header" style="margin-top:40px;">
            <h2>Thematic Areas Covered</h2>
        </div>
        <div style="display:flex; gap:10px; flex-wrap:wrap;">
            <span class="badge badge--ongoing">Higher Education</span>
            <span class="badge badge--ongoing">Digital Transformation</span>
            <span class="badge badge--ongoing">Student Mobility</span>
        </div>

        <div class="section__header" style="margin-top:40px;">
            <h2>Open Calls Under This Programme</h2>
        </div>
        <div class="data-table-wrap">
            <table class="data-table">
                <thead><tr><th>Call</th><th>Action Type</th><th>Deadline</th><th>Status</th></tr></thead>
                <tbody>
                    <tr><td>KA171 International Credit Mobility</td><td>Mobility</td><td>30 Sept 2026</td><td><span class="badge badge--open">Open</span></td></tr>
                    <tr><td>KA220 Cooperation Partnerships</td><td>Capacity building</td><td>15 Nov 2026</td><td><span class="badge badge--open">Open</span></td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <aside>
        <div class="card">
            <div class="card__body">
                <h3 class="card__title">Programme Info</h3>
                <p class="card__text">Managed by the European Commission (EACEA).</p>
                <a href="{{ $programme['website'] }}" class="btn btn--outline btn--sm" style="margin-top:8px;">Official website</a>
            </div>
        </div>
    </aside>
</section>

@endsection
