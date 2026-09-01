@extends('layouts.app')

@section('title', __('Calls for Proposals'))

@section('content')

<section class="calls-hero">
    <div class="calls-hero__inner">
        <h1>{{ __('Calls for Proposals') }}</h1>
        <p>{{ __('Explore current funding calls and opportunities for international projects.') }}</p>
    </div>
</section>

<section class="calls-toolbar-wrap">
    <form method="GET" action="{{ route('calls.index') }}" class="calls-toolbar">
        <div class="calls-toolbar__search">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/>
                <path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            <input type="search" name="search" value="{{ request('search') }}" placeholder="{{ __('Search...') }}" autocomplete="off">
        </div>

        <div class="calls-toolbar__select">
            <select name="programID" onchange="this.form.submit()">
                <option value="">{{ __('Programme') }}</option>
                @foreach($programmes as $programme)
                    @if($programme->translation())
                        <option value="{{ $programme->programID }}" @selected((int) request('programID') === (int) $programme->programID)>
                            {{ $programme->translation()->programName }}
                        </option>
                    @endif
                @endforeach
            </select>
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>

        <div class="calls-toolbar__select">
            <select name="status" onchange="this.form.submit()">
                <option value="">{{ __('Status') }}</option>
                @foreach(['open' => __('Open'), 'upcoming' => __('Upcoming'), 'closing_soon' => __('Closing Soon'), 'closed' => __('Closed')] as $value => $label)
                    <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>

        <button type="submit" class="calls-toolbar__button">{{ __('Search') }}</button>
    </form>
</section>

<section class="calls-grid-wrap">
    <div class="calls-grid">
        @forelse($calls as $call)
            @php
                $t = $call->translation();
                $programme = $call->fundingProgramme?->translation()?->programName;
            @endphp

            @continue(!$t)

            <article class="calls-card">
                <div class="calls-card__top">
                    <div class="calls-card__logo">CF</div>
                    <div class="calls-card__badges">
                        @if($programme)
                            <span class="calls-card__badge calls-card__badge--programme">{{ $programme }}</span>
                        @endif
                        <span class="calls-card__badge calls-card__badge--{{ \Illuminate\Support\Str::slug($call->status) }}">
                            {{ __($call->status_label) }}
                        </span>
                    </div>
                </div>

                <h3 class="calls-card__title">{{ $t->title }}</h3>

                @if($t->description)
                    <p class="calls-card__desc">{{ Str::limit(strip_tags($t->description), 150) }}</p>
                @else
                    <p class="calls-card__desc">{{ __('No description available for this call.') }}</p>
                @endif

                <div class="calls-card__meta">
                    @if($call->actionType)
                        <span>{{ $call->actionType }}</span>
                    @endif
                    @if($call->financingOrganism)
                        <span>{{ $call->financingOrganism }}</span>
                    @endif
                </div>

                <div class="calls-card__bottom">
                    <span class="calls-card__deadline">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <rect x="3" y="5" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.6"/>
                            <path d="M8 3v4M16 3v4M3 10h18" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                        </svg>
                        {{ __('Deadline') }}: {{ optional($call->deadline)->format('M j, Y') }}
                    </span>

                    <a href="{{ route('calls.show', $call) }}" class="calls-card__link">
                        {{ __('See Details') }} &rarr;
                    </a>
                </div>
            </article>
        @empty
            <div class="calls-empty">
                <h3>{{ __('No calls for proposals found') }}</h3>
                <p>{{ __('Try changing your search or filters.') }}</p>
            </div>
        @endforelse
    </div>

    @if($calls->hasPages())
        <nav class="calls-pagination" aria-label="{{ __('Calls pagination') }}">
            {{ $calls->links() }}
        </nav>
    @endif
</section>

@endsection
