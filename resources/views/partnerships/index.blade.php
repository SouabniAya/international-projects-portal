{{-- resources/views/partnerships/index.blade.php — FR-3.1 to FR-3.4 --}}
@extends('layouts.app')

@section('title', 'International Partnerships')

@section('content')

<x-page-hero
    :title="__('pages.partnerships.title')"
    :subtitle="__('pages.partnerships.subtitle')"
    breadcrumb="<a href='{{ url('/') }}'>{{ __('nav.home') }}</a> / Partnerships">
</x-page-hero>

<div class="page-hero__toolbar">
    <div class="filter-bar" data-filter-scope="#partnersGrid">
        <div class="filter-bar__search">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            <input type="search" placeholder="Search partners..." data-filter-search>
        </div>
        <select class="form-control" data-filter-select="country">
            <option value="all">Country / Region</option>
            <option value="France">France</option>
            <option value="Italy">Italy</option>
            <option value="Germany">Germany</option>
            <option value="Spain">Spain</option>
        </select>
        <select class="form-control" data-filter-select="type">
            <option value="all">Institution type</option>
            <option value="University">University</option>
            <option value="Research center">Research center</option>
        </select>
    </div>
</div>

<section class="section">
    <div class="section__header section__header--row">
        <p style="margin:0; color:var(--color-neutral-500); font-family:var(--font-body); font-size:14px;">42 partners found</p>
        <a href="{{ url('/become-a-partner') }}" class="btn btn--primary btn--sm">Become a partner</a>
    </div>

    <div class="card-grid" id="partnersGrid">
        @foreach ([
            ['name' => 'INSA Lyon', 'flag' => '🇫🇷', 'country' => 'France', 'city' => 'Lyon', 'type' => 'University', 'domain' => 'insa-lyon.fr', 'tags' => ['University', 'Research', 'Mobility']],
            ['name' => 'Université de Technologie de Compiègne', 'flag' => '🇫🇷', 'country' => 'France', 'city' => 'Compiègne', 'type' => 'University', 'domain' => 'utc.fr', 'tags' => ['University', 'Research']],
            ['name' => 'Politecnico di Torino', 'flag' => '🇮🇹', 'country' => 'Italy', 'city' => 'Turin', 'type' => 'University', 'domain' => 'polito.it', 'tags' => ['University', 'Mobility']],
            ['name' => 'TU Munich', 'flag' => '🇩🇪', 'country' => 'Germany', 'city' => 'Munich', 'type' => 'University', 'domain' => 'tum.de', 'tags' => ['University', 'Research']],
            ['name' => 'University of Barcelona', 'flag' => '🇪🇸', 'country' => 'Spain', 'city' => 'Barcelona', 'type' => 'University', 'domain' => 'ub.edu', 'tags' => ['University', 'Mobility']],
            ['name' => 'Fraunhofer Institute', 'flag' => '🇩🇪', 'country' => 'Germany', 'city' => 'Munich', 'type' => 'Research center', 'domain' => 'fraunhofer.de', 'tags' => ['Research center']],
        ] as $partner)
            <div data-filter-item data-country="{{ $partner['country'] }}" data-type="{{ $partner['type'] }}">
                <x-partner-card
                    :name="$partner['name']"
                    :countryFlag="$partner['flag']"
                    :country="$partner['country']"
                    :city="$partner['city']"
                    :tags="$partner['tags']"
                    :logoDomain="$partner['domain']"
                    :href="url('/partnerships/'.\Illuminate\Support\Str::slug($partner['name']))" />
            </div>
        @endforeach
    </div>
    <p data-empty-state style="display:none; text-align:center; padding:32px; color:var(--color-neutral-500); font-family:var(--font-body);">No partners match your filters.</p>

    <nav class="pagination" aria-label="Partner list pages">
        <a href="#" class="is-disabled">‹</a>
        <a href="#" class="is-active">1</a>
        <a href="#">2</a>
        <a href="#">3</a>
        <span>…</span>
        <a href="#">7</a>
        <a href="#">›</a>
    </nav>
</section>

@endsection
