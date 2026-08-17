@extends('layouts.admin')

@section('title', __('Partner Management'))

@section('content')
<div class="ptm-page">

    {{-- Back --}}
    <a href="{{ route('admin.partners') }}" class="ptm-page__back">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M15 6l-6 6 6 6"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"/>
        </svg>
        {{ __('Back to Partners') }}
    </a>

    {{-- Header --}}
    <div class="ptm-page__head">
        <div>
            <h1>{{ __('Partner Management') }}</h1>
            <p>{{ __('Manage partner institutions, contacts and collaboration status.') }}</p>
        </div>

        <a href="{{ route('admin.partners') }}" class="ptm-page__btn">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M12 5v14M5 12h14"
                      stroke="currentColor"
                      stroke-width="1.8"
                      stroke-linecap="round"/>
            </svg>
            {{ __('Add Partner') }}
        </a>
    </div>

    {{-- Filters --}}
    <section class="ptm-filters">

        <div class="ptm-filters__top">

            <div class="ptm-filters__search">
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
                    id="partnerSearch"
                    placeholder="{{ __('Search partners...') }}"
                    aria-label="{{ __('Search partners') }}"
                >
            </div>

            <button type="button" class="ptm-filters__reset" id="resetPartnerFilters">
                <svg viewBox="0 0 24 24" fill="none"
                     xmlns="http://www.w3.org/2000/svg"
                     aria-hidden="true">
                    <path d="M3 12a9 9 0 1 0 3-6.7"
                          stroke="currentColor"
                          stroke-width="1.8"
                          stroke-linecap="round"/>
                    <path d="M3 5v5h5"
                          stroke="currentColor"
                          stroke-width="1.8"
                          stroke-linecap="round"
                          stroke-linejoin="round"/>
                </svg>
                {{ __('Reset All') }}
            </button>

            <button type="button" class="ptm-filters__export">
                <svg viewBox="0 0 24 24" fill="none"
                     xmlns="http://www.w3.org/2000/svg"
                     aria-hidden="true">
                    <path d="M12 3v11"
                          stroke="currentColor"
                          stroke-width="1.7"
                          stroke-linecap="round"/>
                    <path d="M8 10l4 4 4-4"
                          stroke="currentColor"
                          stroke-width="1.7"
                          stroke-linecap="round"
                          stroke-linejoin="round"/>
                    <path d="M5 21h14"
                          stroke="currentColor"
                          stroke-width="1.7"
                          stroke-linecap="round"/>
                </svg>
                {{ __('Export') }}
            </button>

        </div>

        @php
            $filters = [
                'Country' => __('All countries'),
                'Type' => __('All types'),
                'Status' => __('All statuses'),
                'Programme' => __('All programmes'),
                'Project' => __('All projects'),
            ];
        @endphp

        <div class="ptm-filters__row">

            @foreach($filters as $label => $default)
                <label class="ptm-filters__field">
                    <span>{{ __($label) }}</span>

                    <div class="ptm-filters__select">
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

    </section>

    {{-- Toolbar --}}
    <div class="ptm-toolbar">

        @php
            $partners = [
                [
                    'name' => 'University of Bologna',
                    'short' => 'UNIBO',
                    'country' => 'Italy',
                    'country_code' => 'it',
                    'type' => 'University',
                    'programme' => 'Erasmus+',
                    'project' => 'International Mobility',
                    'status' => 'Active',
                ],
                [
                    'name' => 'University of Barcelona',
                    'short' => 'UB',
                    'country' => 'Spain',
                    'country_code' => 'es',
                    'type' => 'University',
                    'programme' => 'Erasmus+',
                    'project' => 'Student Exchange',
                    'status' => 'Active',
                ],
                [
                    'name' => 'University of Porto',
                    'short' => 'UP',
                    'country' => 'Portugal',
                    'country_code' => 'pt',
                    'type' => 'University',
                    'programme' => 'Erasmus+',
                    'project' => 'Academic Cooperation',
                    'status' => 'Active',
                ],
                [
                    'name' => 'University of Lyon',
                    'short' => 'UL',
                    'country' => 'France',
                    'country_code' => 'fr',
                    'type' => 'University',
                    'programme' => 'Horizon Europe',
                    'project' => 'Research Cooperation',
                    'status' => 'Pending',
                ],
                [
                    'name' => 'Cairo University',
                    'short' => 'CU',
                    'country' => 'Egypt',
                    'country_code' => 'eg',
                    'type' => 'University',
                    'programme' => 'Erasmus+',
                    'project' => 'International Mobility',
                    'status' => 'Active',
                ],
                [
                    'name' => 'University of Tunis',
                    'short' => 'UT',
                    'country' => 'Tunisia',
                    'country_code' => 'tn',
                    'type' => 'University',
                    'programme' => 'Erasmus+',
                    'project' => 'Student Exchange',
                    'status' => 'Pending',
                ],
            ];
        @endphp

        <span class="ptm-toolbar__count">
            {{ count($partners) }} {{ __('partners') }}
        </span>

        <div class="ptm-toolbar__right">

            <div class="ptm-toolbar__sort">
                <span>{{ __('Sort by') }}</span>

                <div class="ptm-toolbar__select">
                    <span>{{ __('Recently added') }}</span>

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
            </div>

            <div class="ptm-toolbar__view">

                <button type="button" class="is-active">
                    <svg viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg"
                         aria-hidden="true">
                        <path d="M4 5h16M4 12h16M4 19h16"
                              stroke="currentColor"
                              stroke-width="1.8"
                              stroke-linecap="round"/>
                    </svg>
                    {{ __('List') }}
                </button>

                <button type="button">
                    <svg viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg"
                         aria-hidden="true">
                        <rect x="4" y="4" width="6" height="6"
                              stroke="currentColor"
                              stroke-width="1.6"/>
                        <rect x="14" y="4" width="6" height="6"
                              stroke="currentColor"
                              stroke-width="1.6"/>
                        <rect x="4" y="14" width="6" height="6"
                              stroke="currentColor"
                              stroke-width="1.6"/>
                        <rect x="14" y="14" width="6" height="6"
                              stroke="currentColor"
                              stroke-width="1.6"/>
                    </svg>
                    {{ __('Grid') }}
                </button>

            </div>

        </div>
    </div>

    {{-- Table --}}
    <div class="ptm-table-wrap">

        <table class="ptm-table">

            <thead>
                <tr>
                    <th>{{ __('Partner') }}</th>
                    <th>{{ __('Location') }}</th>
                    <th>{{ __('Type') }}</th>
                    <th>{{ __('Programme') }}</th>
                    <th>{{ __('Project') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>

            <tbody>

                @foreach($partners as $index => $partner)

                    <tr class="ptm-partner-row">

                        {{-- Partner --}}
                        <td>
                            <div class="ptm-table__partner">

                                <img
                                    class="ptm-table__logo"
                                    src="{{ asset('images/erasmus-badge.webp') }}"
                                    alt=""
                                >

                                <div>
                                    <strong>{{ $partner['name'] }}</strong>
                                    <span>{{ $partner['short'] }}</span>
                                </div>

                            </div>
                        </td>

                        {{-- Location --}}
                        <td>
                            <div class="ptm-table__location">

                                <img
                                    class="ptm-table__flag"
                                    src="https://flagcdn.com/w40/{{ $partner['country_code'] }}.png"
                                    alt="{{ $partner['country'] }}"
                                >

                                <div>
                                    <strong>{{ $partner['country'] }}</strong>
                                    <span>{{ __('International Partner') }}</span>
                                </div>

                            </div>
                        </td>

                        {{-- Type --}}
                        <td>
                            <span class="ptm-table__tag">
                                {{ __($partner['type']) }}
                            </span>
                        </td>

                        {{-- Programme --}}
                        <td>
                            {{ $partner['programme'] }}
                        </td>

                        {{-- Project --}}
                        <td>
                            {{ $partner['project'] }}
                        </td>

                        {{-- Status --}}
                        <td>
                            <span class="ptm-table__status
                                {{ $partner['status'] === 'Active'
                                    ? 'ptm-table__status--active'
                                    : 'ptm-table__status--pending' }}">
                                {{ __($partner['status']) }}
                            </span>
                        </td>

                        {{-- Actions --}}
                        <td>
                            <div class="ptm-table__actions">

                                <a
                                    href="{{ route('admin.partners', ['project' => $index + 1]) }}"
                                    title="{{ __('View') }}"
                                    aria-label="{{ __('View') }}"
                                >
                                    <svg viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z"
                                              stroke="currentColor"
                                              stroke-width="1.7"/>
                                        <circle cx="12" cy="12" r="2.5"
                                                stroke="currentColor"
                                                stroke-width="1.7"/>
                                    </svg>
                                </a>

                                <a
                                    href="{{ route('admin.partners', ['project' => $index + 1]) }}"
                                    title="{{ __('Edit') }}"
                                    aria-label="{{ __('Edit') }}"
                                >
                                    <svg viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4 20h4l10.5-10.5a2.12 2.12 0 0 0-3-3L5 17v3Z"
                                              stroke="currentColor"
                                              stroke-width="1.7"
                                              stroke-linecap="round"
                                              stroke-linejoin="round"/>
                                        <path d="M14.5 7.5l2 2"
                                              stroke="currentColor"
                                              stroke-width="1.7"
                                              stroke-linecap="round"/>
                                    </svg>
                                </a>

                                <button
                                    type="button"
                                    title="{{ __('Delete') }}"
                                    aria-label="{{ __('Delete') }}"
                                    onclick="return confirm('{{ __('Are you sure you want to delete this partner?') }}')"
                                >
                                    <svg viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4 7h16"
                                              stroke="currentColor"
                                              stroke-width="1.7"
                                              stroke-linecap="round"/>
                                        <path d="M9 7V4h6v3M7 7l1 13h8l1-13"
                                              stroke="currentColor"
                                              stroke-width="1.7"
                                              stroke-linecap="round"
                                              stroke-linejoin="round"/>
                                    </svg>
                                </button>

                            </div>
                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

        {{-- Pagination --}}
        <div class="ptm-pagination">

            <span>
                {{ __('Showing') }} 1–{{ count($partners) }}
                {{ __('of') }} {{ count($partners) }}
                {{ __('partners') }}
            </span>

            <div class="ptm-pagination__buttons">

                <button type="button" disabled aria-label="{{ __('Previous page') }}">
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
                    8
                </button>

                <button type="button" aria-label="{{ __('Next page') }}">
                    ›
                </button>

            </div>

        </div>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('partnerSearch');
    const resetButton = document.getElementById('resetPartnerFilters');

    if (searchInput) {
        searchInput.addEventListener('input', function () {

            const query = this.value.toLowerCase().trim();
            const rows = document.querySelectorAll('.ptm-partner-row');

            rows.forEach(function (row) {
                const text = row.textContent.toLowerCase();

                row.style.display = text.includes(query) ? '' : 'none';
            });
        });
    }

    if (resetButton) {
        resetButton.addEventListener('click', function () {

            if (searchInput) {
                searchInput.value = '';
            }

            document.querySelectorAll('.ptm-partner-row').forEach(function (row) {
                row.style.display = '';
            });
        });
    }

});
</script>

@endsection