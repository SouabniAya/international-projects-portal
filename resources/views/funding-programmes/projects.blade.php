@extends('layouts.app')

@section('title', 'International Projects')

@section('content')
<x-page-hero
    :title="__('International Projects')"
    :subtitle="__('Discover our international research and cooperation projects, developed in partnership with universities and institutions around the world.')"
    breadcrumb="<a href='{{ url('/') }}'>{{ __('nav.home') }}</a> / International Projects">
</x-page-hero>

<div class="page-hero__toolbar">
    <form class="filter-bar" method="GET" action="{{ route('projects') }}">
        <div class="filter-bar__search">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            <input type="search" name="search" value="{{ $search }}" placeholder="{{ __('Search projects...') }}">
        </div>
        <select class="form-control" name="programID">
            <option value="">{{ __('Funding Programme') }}</option>
            @foreach($programmes as $programme)
                <option value="{{ $programme->programID }}" @selected((string)$programID === (string)$programme->programID)>{{ $programme->translation()?->programName ?? __('Programme') }}</option>
            @endforeach
        </select>
        <select class="form-control" name="status">
            <option value="">{{ __('Status') }}</option>
            @foreach(['proposed','ongoing','completed'] as $value)
                <option value="{{ $value }}" @selected($status === $value)>{{ __(ucfirst($value)) }}</option>
            @endforeach
        </select>
        <button class="btn btn--primary btn--sm" type="submit">{{ __('Search') }}</button>
        @if($search || $programID || $status)
            <a class="btn btn--outline btn--sm" href="{{ route('projects') }}">{{ __('Reset') }}</a>
        @endif
    </form>
</div>

<section class="section">
    <div class="section__header section__header--row">
        <p style="margin:0; color:var(--color-neutral-500); font-family:var(--font-body); font-size:14px;">
            {{ trans_choice(':count project|:count projects', $projects->total(), ['count' => $projects->total()]) }}
        </p>
    </div>

    <div class="card-grid">
        @forelse($projects as $project)
            <article class="project-card">
                <div class="project-card__top">
                    @if($project['logo'])
                        <img class="project-card__logo" src="{{ asset('storage/'.$project['logo']) }}" alt="">
                    @else
                        <span class="project-card__logo">{{ substr($project['programme'], 0, 1) }}</span>
                    @endif
                    <h3>{{ $project['programme'] }}</h3>
                    <span class="project-card__status project-card__status--{{ strtolower($project['status']) }}">{{ __($project['status']) }}</span>
                </div>
                <h4 class="project-card__title">{{ $project['title'] }}</h4>
                <p class="project-card__desc">{{ $project['description'] }}</p>
                <div class="project-card__bottom">
                    <span class="project-card__tag">{{ $project['country'] }}</span>
                    <a href="{{ route('projects.show', $project['id']) }}" class="project-card__link">{{ __('View project') }} →</a>
                </div>
            </article>
        @empty
            <p style="grid-column:1/-1; text-align:center; padding:40px;">{{ __('No projects match your filters.') }}</p>
        @endforelse
    </div>

    {{ $projects->onEachSide(1)->links() }}
</section>
@endsection
