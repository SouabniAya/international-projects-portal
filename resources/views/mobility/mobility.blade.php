@extends('layouts.app')

@section('title', 'Mobility Opportunities')

@section('content')

<section class="mobility-hero">
    <div class="mobility-hero__inner">
        <h1>{{ __('Mobility Opportunities') }}</h1>
        <p>
            {{ __('Explore student and staff mobility opportunities with our international partner universities.') }}
        </p>
    </div>
</section>


{{-- =========================================================
     SEARCH + FILTERS
========================================================= --}}
<section class="mobility-toolbar-wrap">
    <div class="mobility-toolbar">

        {{-- Search --}}
        <div class="mobility-toolbar__search">
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
                id="mobilitySearch"
                placeholder="{{ __('Search...') }}"
                autocomplete="off"
            >
        </div>


        {{-- Type --}}
        <div class="mobility-toolbar__select">
            <select id="mobilityType">
                <option value="">{{ __('Type') }}</option>

                @php
                    $types = collect($opportunities)
                        ->pluck('direction')
                        ->filter()
                        ->unique()
                        ->values();
                @endphp

                @foreach($types as $type)
                    <option value="{{ strtolower($type) }}">
                        {{ __($type) }}
                    </option>
                @endforeach
            </select>

            <svg viewBox="0 0 24 24" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path d="M6 9l6 6 6-6"
                      stroke="currentColor"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"/>
            </svg>
        </div>


        {{-- Programme --}}
        <div class="mobility-toolbar__select">
            <select id="mobilityProgramme">
                <option value="">{{ __('Programme') }}</option>

                @php
                    $programmes = collect($opportunities)
                        ->map(function ($opp) {
                            return $opp['programme']
                                ?? $opp['program']
                                ?? $opp['programme_name']
                                ?? null;
                        })
                        ->filter()
                        ->unique()
                        ->values();
                @endphp

                @foreach($programmes as $programme)
                    <option value="{{ strtolower($programme) }}">
                        {{ __($programme) }}
                    </option>
                @endforeach
            </select>

            <svg viewBox="0 0 24 24" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path d="M6 9l6 6 6-6"
                      stroke="currentColor"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"/>
            </svg>
        </div>


        {{-- Status --}}
        <div class="mobility-toolbar__select">
            <select id="mobilityStatus">
                <option value="">{{ __('Status') }}</option>

                @php
                    $statuses = collect($opportunities)
                        ->pluck('status')
                        ->filter()
                        ->unique()
                        ->values();
                @endphp

                @foreach($statuses as $status)
                    <option value="{{ strtolower($status) }}">
                        {{ __($status) }}
                    </option>
                @endforeach
            </select>

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


{{-- =========================================================
     RESULTS
========================================================= --}}
<section class="mobility-grid-wrap">

    <div class="mobility-grid" id="mobilityGrid">

        @foreach ($opportunities as $opp)

            @php
                $programme = $opp['programme']
                    ?? $opp['program']
                    ?? $opp['programme_name']
                    ?? '';

                $searchText = strtolower(
                    implode(' ', array_filter([
                        $opp['title'] ?? '',
                        $opp['sub'] ?? '',
                        $opp['city'] ?? '',
                        $opp['university'] ?? '',
                        $opp['direction'] ?? '',
                        $opp['status'] ?? '',
                        $programme,
                        isset($opp['tags']) ? implode(' ', $opp['tags']) : ''
                    ]))
                );
            @endphp

            <article
                class="mobility-card"
                data-search="{{ $searchText }}"
                data-type="{{ strtolower($opp['direction'] ?? '') }}"
                data-programme="{{ strtolower($programme) }}"
                data-status="{{ strtolower($opp['status'] ?? '') }}"
            >

                <div class="mobility-card__top">

                    <div class="mobility-card__logo"></div>

                    <div class="mobility-card__badges">

                        <span class="mobility-card__badge mobility-card__badge--direction">
                            {{ __($opp['direction']) }}
                        </span>

                        <span class="mobility-card__badge mobility-card__badge--status mobility-card__badge--{{ \Illuminate\Support\Str::slug($opp['status']) }}">
                            {{ __($opp['status']) }}
                        </span>

                    </div>
                </div>


                <h3 class="mobility-card__title">
                    {{ $opp['title'] }}
                </h3>


                <p class="mobility-card__sub">
                    {{ $opp['sub'] }}
                </p>


                <p class="mobility-card__location">

                    <svg viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg">

                        <path d="M12 21s7-6.5 7-11.5A7 7 0 0 0 5 9.5C5 14.5 12 21 12 21Z"
                              stroke="currentColor"
                              stroke-width="1.6"
                              stroke-linejoin="round"/>

                        <circle cx="12" cy="9.5" r="2.4"
                                stroke="currentColor"
                                stroke-width="1.6"/>

                    </svg>

                    {{ $opp['city'] }} &middot; {{ $opp['university'] }}

                </p>


                {{-- Programme --}}
                @if(!empty($programme))
                    <div class="mobility-card__programme">
                        {{ $programme }}
                    </div>
                @endif


                {{-- Tags --}}
                <div class="mobility-card__tags">

                    @foreach ($opp['tags'] ?? [] as $tag)
                        <span>{{ $tag }}</span>
                    @endforeach

                </div>


                <div class="mobility-card__bottom">

                    <span class="mobility-card__deadline">

                        <svg viewBox="0 0 24 24"
                             fill="none"
                             xmlns="http://www.w3.org/2000/svg">

                            <rect x="3" y="5"
                                  width="18"
                                  height="16"
                                  rx="2"
                                  stroke="currentColor"
                                  stroke-width="1.6"/>

                            <path d="M8 3v4M16 3v4M3 10h18"
                                  stroke="currentColor"
                                  stroke-width="1.6"
                                  stroke-linecap="round"/>

                        </svg>

                        {{ $opp['deadline'] }}

                    </span>


                    <a href="{{ route('mobility.show', $opp['id']) }}"
                       class="mobility-card__link">

                        {{ __('See Details') }} &rarr;

                    </a>

                </div>

            </article>

        @endforeach


        {{-- No results --}}
        <div
            id="mobilityNoResults"
            style="
                display:none;
                grid-column:1 / -1;
                text-align:center;
                padding:60px 20px;
                color:var(--color-neutral-500);
                font-family:var(--font-body);
            "
        >
            <h3 style="margin-bottom:8px;">
                {{ __('No mobility opportunities found') }}
            </h3>

            <p>
                {{ __('Try changing your search or filters.') }}
            </p>
        </div>

    </div>


    {{-- =====================================================
         PAGINATION
    ====================================================== --}}
    <nav
        class="mobility-pagination"
        id="mobilityPagination"
        aria-label="{{ __('Mobility pagination') }}"
    >
    </nav>

</section>


{{-- =========================================================
     JAVASCRIPT
========================================================= --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('mobilitySearch');
    const typeFilter = document.getElementById('mobilityType');
    const programmeFilter = document.getElementById('mobilityProgramme');
    const statusFilter = document.getElementById('mobilityStatus');

    const grid = document.getElementById('mobilityGrid');
    const pagination = document.getElementById('mobilityPagination');
    const noResults = document.getElementById('mobilityNoResults');

    const cards = Array.from(
        grid.querySelectorAll('.mobility-card')
    );

    /*
     * Number of cards per page.
     * Change 6 to 9, 12, etc. if you want.
     */
    const cardsPerPage = 6;

    let currentPage = 1;
    let filteredCards = [...cards];


    function normalize(value) {
        return (value || '')
            .toString()
            .trim()
            .toLowerCase();
    }


    function filterCards() {

        const search = normalize(searchInput.value);
        const type = normalize(typeFilter.value);
        const programme = normalize(programmeFilter.value);
        const status = normalize(statusFilter.value);


        filteredCards = cards.filter(card => {

            const cardSearch = normalize(
                card.dataset.search
            );

            const cardType = normalize(
                card.dataset.type
            );

            const cardProgramme = normalize(
                card.dataset.programme
            );

            const cardStatus = normalize(
                card.dataset.status
            );


            const matchesSearch =
                search === '' ||
                cardSearch.includes(search);


            const matchesType =
                type === '' ||
                cardType === type;


            const matchesProgramme =
                programme === '' ||
                cardProgramme === programme;


            const matchesStatus =
                status === '' ||
                cardStatus === status;


            return (
                matchesSearch &&
                matchesType &&
                matchesProgramme &&
                matchesStatus
            );

        });


        currentPage = 1;

        render();
    }


    function render() {

        /*
         * Hide all cards first.
         */
        cards.forEach(card => {
            card.style.display = 'none';
        });


        /*
         * No results.
         */
        if (filteredCards.length === 0) {

            noResults.style.display = 'block';

            pagination.style.display = 'none';

            return;
        }


        noResults.style.display = 'none';


        /*
         * Calculate pagination.
         */
        const totalPages = Math.ceil(
            filteredCards.length / cardsPerPage
        );


        if (currentPage > totalPages) {
            currentPage = totalPages;
        }


        const start =
            (currentPage - 1) * cardsPerPage;

        const end =
            start + cardsPerPage;


        const visibleCards =
            filteredCards.slice(start, end);


        /*
         * Display current page.
         */
        visibleCards.forEach(card => {
            card.style.display = '';
        });


        renderPagination(totalPages);
    }


    function renderPagination(totalPages) {

        pagination.innerHTML = '';


        /*
         * No pagination needed.
         */
        if (totalPages <= 1) {
            pagination.style.display = 'none';
            return;
        }


        pagination.style.display = 'flex';


        /*
         * Previous button.
         */
        const previousButton =
            document.createElement('button');

        previousButton.type = 'button';
        previousButton.innerHTML = '‹';
        previousButton.setAttribute(
            'aria-label',
            '{{ __("Previous page") }}'
        );

        previousButton.disabled =
            currentPage === 1;


        previousButton.addEventListener(
            'click',
            function () {

                if (currentPage > 1) {

                    currentPage--;

                    render();

                    scrollToResults();
                }

            }
        );


        pagination.appendChild(previousButton);


        /*
         * Page buttons.
         */
        for (
            let page = 1;
            page <= totalPages;
            page++
        ) {

            const button =
                document.createElement('button');

            button.type = 'button';
            button.textContent = page;


            if (page === currentPage) {
                button.classList.add('is-active');
            }


            button.addEventListener(
                'click',
                function () {

                    currentPage = page;

                    render();

                    scrollToResults();

                }
            );


            pagination.appendChild(button);
        }


        /*
         * Next button.
         */
        const nextButton =
            document.createElement('button');

        nextButton.type = 'button';
        nextButton.innerHTML = '›';

        nextButton.setAttribute(
            'aria-label',
            '{{ __("Next page") }}'
        );


        nextButton.disabled =
            currentPage === totalPages;


        nextButton.addEventListener(
            'click',
            function () {

                if (currentPage < totalPages) {

                    currentPage++;

                    render();

                    scrollToResults();
                }

            }
        );


        pagination.appendChild(nextButton);
    }


    function scrollToResults() {

        const resultsPosition =
            grid.getBoundingClientRect().top +
            window.scrollY -
            120;


        window.scrollTo({
            top: resultsPosition,
            behavior: 'smooth'
        });
    }


    /*
     * Search while typing.
     */
    searchInput.addEventListener(
        'input',
        filterCards
    );


    /*
     * Filters.
     */
    typeFilter.addEventListener(
        'change',
        filterCards
    );

    programmeFilter.addEventListener(
        'change',
        filterCards
    );

    statusFilter.addEventListener(
        'change',
        filterCards
    );


    /*
     * Initial render.
     */
    render();

});
</script>

@endsection