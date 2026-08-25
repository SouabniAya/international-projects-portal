@extends('layouts.admin')

@section('title', 'Mobility Management')

@php($active = 'mobility')

@section('content')
<div class="admmob-page">

    {{-- Back --}}
    <a href="{{ url('/admin/dashboard') }}" class="admmob-page__back">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 6l-6 6 6 6"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"/>
        </svg>
        Back to Dashboard
    </a>

    {{-- Header --}}
    <div class="admmob-page__head">
        <div>
            <h1>Mobility Management</h1>
            <p>Browse, manage and publish student and staff mobility opportunities.</p>
        </div>

        <a href="#" class="admmob-page__btn">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 5v14M5 12h14"
                      stroke="currentColor"
                      stroke-width="1.8"
                      stroke-linecap="round"/>
            </svg>
            New Mobility Opportunity
        </a>
    </div>

    {{-- Filters --}}
    <div class="admmob-filters">

        <div class="admmob-filters__top">

            <div class="admmob-filters__search">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                    placeholder="Search mobility opportunities..."
                >
            </div>

            <button type="button" class="admmob-filters__reset">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                Reset Filters
            </button>

            <button type="button" class="admmob-filters__export">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 3v12m0 0l-4-4m4 4l4-4M5 21h14"
                          stroke="currentColor"
                          stroke-width="1.6"
                          stroke-linecap="round"/>
                </svg>
                Export
            </button>

        </div>

        <div class="admmob-filters__row">

            {{-- Programme --}}
            <div class="admmob-filters__field">
                <label>Programme</label>

                <div class="admmob-filters__select">
                    <span>All Programmes</span>

                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 9l6 6 6-6"
                              stroke="currentColor"
                              stroke-width="2"
                              stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>

            {{-- Direction --}}
            <div class="admmob-filters__field">
                <label>Direction</label>

                <div class="admmob-filters__select">
                    <span>All Directions</span>

                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 9l6 6 6-6"
                              stroke="currentColor"
                              stroke-width="2"
                              stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>

            {{-- Status --}}
            <div class="admmob-filters__field">
                <label>Status</label>

                <div class="admmob-filters__select">
                    <span>All Statuses</span>

                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 9l6 6 6-6"
                              stroke="currentColor"
                              stroke-width="2"
                              stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>

            {{-- Type --}}
            <div class="admmob-filters__field">
                <label>Type</label>

                <div class="admmob-filters__select">
                    <span>All Types</span>

                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 9l6 6 6-6"
                              stroke="currentColor"
                              stroke-width="2"
                              stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>

            {{-- Opening Year --}}
            <div class="admmob-filters__field">
                <label>Opening Year</label>

                <div class="admmob-filters__select">
                    <span>All Years</span>

                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 9l6 6 6-6"
                              stroke="currentColor"
                              stroke-width="2"
                              stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>

        </div>
    </div>

    {{-- Toolbar --}}
    <div class="admmob-toolbar">

        <span class="admmob-toolbar__count">
            {{ count($opportunities) }} Mobility Opportunities
        </span>

        <div class="admmob-toolbar__right">

            <label class="admmob-toolbar__sort">
                <span>Sort by:</span>

                <div class="admmob-toolbar__select">
                    <span>Newest First</span>

                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 9l6 6 6-6"
                              stroke="currentColor"
                              stroke-width="2"
                              stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                </div>
            </label>

            <div class="admmob-toolbar__view">

                <button type="button" class="is-active">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 6h16M4 12h16M4 18h16"
                              stroke="currentColor"
                              stroke-width="1.8"
                              stroke-linecap="round"/>
                    </svg>
                    Table
                </button>

                <button type="button">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="3" y="3" width="7" height="7" rx="1.5"
                              stroke="currentColor"
                              stroke-width="1.6"/>
                        <rect x="14" y="3" width="7" height="7" rx="1.5"
                              stroke="currentColor"
                              stroke-width="1.6"/>
                        <rect x="3" y="14" width="7" height="7" rx="1.5"
                              stroke="currentColor"
                              stroke-width="1.6"/>
                        <rect x="14" y="14" width="7" height="7" rx="1.5"
                              stroke="currentColor"
                              stroke-width="1.6"/>
                    </svg>
                    Board
                </button>

            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="admmob-table-wrap">

        <table class="admmob-table">

            <thead>
                <tr>
                    <th>Opportunity Title</th>
                    <th>Programme</th>
                    <th>Direction</th>
                    <th>Status</th>
                    <th>Opening Date</th>
                    <th>Deadline</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse($opportunities as $opp)

                    <tr>

                        {{-- Opportunity --}}
                        <td>
                            <div class="admmob-table__title">

                                <img
                                    src="{{ asset('images/placeholder-thumb.png') }}"
                                    alt=""
                                >

                                <div>
                                    <strong>{{ $opp['title'] }}</strong>
                                    <span>Ref: {{ $opp['ref'] }}</span>
                                </div>

                            </div>
                        </td>

                        {{-- Programme --}}
                        <td>
                            <span class="admmob-table__tag">
                                {{ $opp['programme'] }}
                            </span>
                        </td>

                        {{-- Direction --}}
                        <td>
                            {{ $opp['direction'] }}
                        </td>

                        {{-- Status --}}
                        <td>
                            <span class="admmob-table__status admmob-table__status--{{ \Illuminate\Support\Str::slug($opp['status']) }}">
                                {{ $opp['status'] }}
                            </span>
                        </td>

                        {{-- Opening --}}
                        <td>
                            {{ $opp['opening'] }}
                        </td>

                        {{-- Deadline --}}
                        <td>
                            {{ $opp['deadline'] }}
                        </td>

                        {{-- Actions --}}
                        <td>

                            <div class="admmob-table__actions">

                                <a
                                    href="{{ route('admin.mobility-details', $opp['id']) }}"
                                    aria-label="View"
                                >
                                    <svg
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            d="M1.5 12S5 5 12 5s10.5 7 10.5 7-3.5 7-10.5 7-10.5-7-10.5-7Z"
                                            stroke="currentColor"
                                            stroke-width="1.6"
                                            stroke-linejoin="round"
                                        />
                                        <circle
                                            cx="12"
                                            cy="12"
                                            r="3"
                                            stroke="currentColor"
                                            stroke-width="1.6"
                                        />
                                    </svg>
                                </a>

                                <button
                                    type="button"
                                    aria-label="More options"
                                >
                                    <svg
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <circle cx="12" cy="5" r="1.4" fill="currentColor"/>
                                        <circle cx="12" cy="12" r="1.4" fill="currentColor"/>
                                        <circle cx="12" cy="19" r="1.4" fill="currentColor"/>
                                    </svg>
                                </button>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px;">
                            No mobility opportunities found.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

        {{-- Pagination --}}
        <div class="admmob-pagination">

            <span>
                Showing
                {{ count($opportunities) > 0 ? 1 : 0 }}
                to
                {{ count($opportunities) }}
                of
                {{ count($opportunities) }}
                mobility opportunities
            </span>

            <div class="admmob-pagination__buttons">

                <button
                    type="button"
                    aria-label="Previous page"
                >
                    ‹
                </button>

                <button
                    type="button"
                    class="is-active"
                >
                    1
                </button>

                <button
                    type="button"
                    aria-label="Next page"
                >
                    ›
                </button>

            </div>

        </div>

    </div>

</div>
@endsection