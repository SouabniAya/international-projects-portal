@extends('layouts.admin')

@section('title', __('Partners'))

@section('content')
<div class="partners-page">

    <a href="{{ $projectId ? route('admin.project-details', $projectId) : url('/admin/projects') }}"
       class="partners-page__back">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M15 6l-6 6 6 6"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"/>
        </svg>

        {{ $projectId ? __('Back to Project') : __('Back to Projects') }}
    </a>

    {{-- Header --}}
    <div class="partners-page__head">
        <div>
            <h1>{{ __('Partners') }}</h1>
            <p>{{ __('Discover our international partners and explore collaboration opportunities.') }}</p>
        </div>

        <div class="partners-page__actions">

            <a href="#" class="partners-page__btn partners-page__btn--outline">
                <svg viewBox="0 0 24 24" fill="none"
                     xmlns="http://www.w3.org/2000/svg"
                     aria-hidden="true">
                    <path d="M12 3v12m0 0l-4-4m4 4l4-4M5 21h14"
                          stroke="currentColor"
                          stroke-width="1.6"
                          stroke-linecap="round"
                          stroke-linejoin="round"/>
                </svg>
                {{ __('Export') }}
            </a>

            <a href="#" class="partners-page__btn partners-page__btn--solid">
                <svg viewBox="0 0 24 24" fill="none"
                     xmlns="http://www.w3.org/2000/svg"
                     aria-hidden="true">
                    <path d="M3 8l9-5 9 5-9 5-9-5Z"
                          stroke="currentColor"
                          stroke-width="1.6"
                          stroke-linejoin="round"/>
                    <path d="M3 8v8l9 5 9-5V8M12 13v8"
                          stroke="currentColor"
                          stroke-width="1.6"
                          stroke-linejoin="round"/>
                </svg>
                {{ __('View on Map') }}
            </a>

        </div>
    </div>

    {{-- Filters --}}
    <div class="partners-filters">

        <div class="partners-filters__top">

            <div class="partners-filters__search">
                <svg viewBox="0 0 24 24" fill="none"
                     xmlns="http://www.w3.org/2000/svg"
                     aria-hidden="true">
                    <circle cx="11"
                            cy="11"
                            r="7"
                            stroke="currentColor"
                            stroke-width="2"/>
                    <path d="M21 21l-4.3-4.3"
                          stroke="currentColor"
                          stroke-width="2"
                          stroke-linecap="round"/>
                </svg>

                <input
                    type="search"
                    placeholder="{{ __('Search partners...') }}"
                    aria-label="{{ __('Search partners...') }}"
                >
            </div>

            <button type="button" class="partners-filters__reset">

                <svg viewBox="0 0 24 24" fill="none"
                     xmlns="http://www.w3.org/2000/svg"
                     aria-hidden="true">
                    <path d="M3 12a9 9 0 1 1 3 6.7"
                          stroke="currentColor"
                          stroke-width="1.6"
                          stroke-linecap="round"/>
                    <path d="M3 8v5h5"
                          stroke="currentColor"
                          stroke-width="1.6"
                          stroke-linecap="round"
                          stroke-linejoin="round"/>
                </svg>

                {{ __('Reset Filters') }}

            </button>

        </div>

        <div class="partners-filters__row">

            @php
                $filters = [
                    __('Country / Region') => __('All Countries'),
                    __('Type of Institution') => __('All Types'),
                    __('Area of Cooperation') => __('All Areas'),
                    __('Partnership Status') => __('All Statuses'),
                ];
            @endphp

            @foreach($filters as $label => $default)

                <label class="partners-filters__field">

                    <span>{{ $label }}</span>

                    <div class="partners-filters__select">

                        <span>{{ $default }}</span>

                        <svg viewBox="0 0 24 24" fill="none"
                             xmlns="http://www.w3.org/2000/svg"
                             aria-hidden="true">
                            <path d="M6 9l6 6 6-6"
                                  stroke="currentColor"
                                  stroke-width="2"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>
                        </svg>

                    </div>

                </label>

            @endforeach

        </div>

    </div>

    {{-- Results toolbar --}}
    <div class="partners-toolbar">

        <span class="partners-toolbar__count">
            {{ __('25 Partners found') }}
        </span>

        <div class="partners-toolbar__right">

            <label class="partners-toolbar__sort">

                <span>{{ __('Sort by:') }}</span>

                <div class="partners-toolbar__select">
                    <span>{{ __('Name (A-Z)') }}</span>

                    <svg viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg"
                         aria-hidden="true">
                        <path d="M6 9l6 6 6-6"
                              stroke="currentColor"
                              stroke-width="2"
                              stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                </div>

            </label>

            <div class="partners-toolbar__view">

                <button type="button" class="is-active">

                    <svg viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg"
                         aria-hidden="true">
                        <rect x="3" y="3"
                              width="7"
                              height="7"
                              rx="1.5"
                              stroke="currentColor"
                              stroke-width="1.6"/>
                        <rect x="14" y="3"
                              width="7"
                              height="7"
                              rx="1.5"
                              stroke="currentColor"
                              stroke-width="1.6"/>
                        <rect x="3" y="14"
                              width="7"
                              height="7"
                              rx="1.5"
                              stroke="currentColor"
                              stroke-width="1.6"/>
                        <rect x="14" y="14"
                              width="7"
                              height="7"
                              rx="1.5"
                              stroke="currentColor"
                              stroke-width="1.6"/>
                    </svg>

                    {{ __('Grid') }}

                </button>

                <button type="button">

                    <svg viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg"
                         aria-hidden="true">
                        <path d="M4 6h16M4 12h16M4 18h16"
                              stroke="currentColor"
                              stroke-width="1.8"
                              stroke-linecap="round"/>
                    </svg>

                    {{ __('List') }}

                </button>

            </div>

        </div>

    </div>

    {{-- Partners grid --}}
    <div class="partners-grid">

        @php
            $partners = [
                [
                    'name' => 'University of Barcelona',
                    'city' => 'Barcelona, Spain',
                    'type' => 'Public University',
                    'tags' => ['Research', 'Mobility', 'Innovation', 'Education'],
                    'logo' => 'images/partners/barcelona.png'
                ],
                [
                    'name' => 'Technical University of Munich',
                    'city' => 'Munich, Germany',
                    'type' => 'Public University',
                    'tags' => ['Engineering', 'Research', 'Technology', 'Innovation'],
                    'logo' => 'images/partners/tum.png'
                ],
                [
                    'name' => 'Université Paris-Saclay',
                    'city' => 'Paris, France',
                    'type' => 'Public University',
                    'tags' => ['Research', 'Science', 'Innovation', 'Education'],
                    'logo' => 'images/partners/paris-saclay.png'
                ],
                [
                    'name' => 'The University of Edinburgh',
                    'city' => 'Edinburgh, United Kingdom',
                    'type' => 'Public University',
                    'tags' => ['Research', 'Mobility', 'Health', 'Data Science'],
                    'logo' => 'images/partners/edinburgh.png'
                ],
                [
                    'name' => 'Politecnico di Milano',
                    'city' => 'Milan, Italy',
                    'type' => 'Public University',
                    'tags' => ['Engineering', 'Design', 'Technology', 'Innovation'],
                    'logo' => 'images/partners/milano.png'
                ],
                [
                    'name' => 'École Polytechnique Fédérale de Lausanne',
                    'city' => 'Lausanne, Switzerland',
                    'type' => 'Public University',
                    'tags' => ['Engineering', 'Research', 'AI', 'Technology'],
                    'logo' => 'images/partners/epfl.png'
                ],
                [
                    'name' => 'The University of Melbourne',
                    'city' => 'Melbourne, Australia',
                    'type' => 'Public University',
                    'tags' => ['Research', 'Mobility', 'Environment', 'Health'],
                    'logo' => 'images/partners/melbourne.png'
                ],
                [
                    'name' => 'Aalborg University',
                    'city' => 'Aalborg, Denmark',
                    'type' => 'Public University',
                    'tags' => ['Engineering', 'Energy', 'Sustainability', 'Innovation'],
                    'logo' => 'images/partners/aalborg.png'
                ],
            ];
        @endphp

        @foreach($partners as $partner)

            <article class="partner-card">

                <div class="partner-card__top">

                    <img
                        src="{{ asset($partner['logo']) }}"
                        alt="{{ $partner['name'] }}"
                        class="partner-card__logo"
                    >

                    <span class="partner-card__status">
                        {{ __('Active') }}
                    </span>

                </div>

                <h3 class="partner-card__name">
                    {{ $partner['name'] }}
                </h3>

                <p class="partner-card__location">

                    <svg viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg"
                         aria-hidden="true">
                        <path d="M12 21s7-6.5 7-11.5A7 7 0 0 0 5 9.5C5 14.5 12 21 12 21Z"
                              stroke="currentColor"
                              stroke-width="1.6"
                              stroke-linejoin="round"/>
                        <circle cx="12"
                                cy="9.5"
                                r="2.4"
                                stroke="currentColor"
                                stroke-width="1.6"/>
                    </svg>

                    {{ $partner['city'] }}

                </p>

                <p class="partner-card__type">

                    <svg viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg"
                         aria-hidden="true">
                        <path d="M12 3l9 5-9 5-9-5 9-5Z"
                              stroke="currentColor"
                              stroke-width="1.6"
                              stroke-linejoin="round"/>
                        <path d="M5 11v5c0 1.7 3.1 3 7 3s7-1.3 7-3v-5"
                              stroke="currentColor"
                              stroke-width="1.6"
                              stroke-linejoin="round"/>
                    </svg>

                    {{ __($partner['type']) }}

                </p>

                <div class="partner-card__tags">

                    @foreach($partner['tags'] as $tag)
                        <span>{{ __($tag) }}</span>
                    @endforeach

                </div>

                <a href="#" class="partner-card__link">
                    {{ __('View Details') }} →
                </a>

            </article>

        @endforeach

    </div>

    {{-- Pagination --}}
    <nav class="partners-pagination" aria-label="{{ __('Partners pagination') }}">

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
            6
        </button>

        <button type="button" aria-label="{{ __('Next page') }}">
            ›
        </button>

    </nav>

</div>
@endsection