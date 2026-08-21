@extends('layouts.admin')

@section('title', __('Requests Management'))

@php
    $stats = [
        'total' => 128,
        'pending' => 24,
        'approved' => 72,
        'rejected' => 18,
        'in_progress' => 14,
    ];

    $requests = [
        [
            'id' => 'REQ-2025-0128',
            'type' => 'Partnership Proposal',
            'title' => 'Partnership with University of Barcelona',
            'programme' => 'Erasmus+',
            'user' => 'Ahmed Saidi',
            'role' => 'Researcher',
            'initials' => 'AS',
            'date' => 'May 10, 2025',
            'status' => 'Pending',
        ],
        [
            'id' => 'REQ-2025-0127',
            'type' => 'Project Proposal',
            'title' => 'AI for Sustainable Cities (Horizon Europe)',
            'programme' => 'Horizon Europe',
            'user' => 'Maria Lopez',
            'role' => 'Coordinator',
            'initials' => 'ML',
            'date' => 'May 8, 2025',
            'status' => 'Approved',
        ],
        [
            'id' => 'REQ-2025-0126',
            'type' => 'Mobility Request',
            'title' => 'Staff Mobility to TU Munich',
            'programme' => 'Erasmus+',
            'user' => 'Yacine Belkacem',
            'role' => 'Faculty',
            'initials' => 'YB',
            'date' => 'May 7, 2025',
            'status' => 'In Progress',
        ],
        [
            'id' => 'REQ-2025-0125',
            'type' => 'Document Request',
            'title' => 'Access to Partnership Agreement Template',
            'programme' => 'Institutional',
            'user' => 'Imane Khelifi',
            'role' => 'Administrator',
            'initials' => 'IK',
            'date' => 'May 6, 2025',
            'status' => 'Approved',
        ],
        [
            'id' => 'REQ-2025-0124',
            'type' => 'Funding Request',
            'title' => 'MSCA Postdoctoral Fellowship Support',
            'programme' => 'MSCA',
            'user' => 'Nabil Hamdi',
            'role' => 'Researcher',
            'initials' => 'NH',
            'date' => 'May 5, 2025',
            'status' => 'Rejected',
        ],
        [
            'id' => 'REQ-2025-0123',
            'type' => 'Event Support',
            'title' => 'Support for International Workshop 2025',
            'programme' => 'Institutional',
            'user' => 'Fatima Bouzid',
            'role' => 'Coordinator',
            'initials' => 'FB',
            'date' => 'May 3, 2025',
            'status' => 'Pending',
        ],
    ];
@endphp

@section('content')

<div class="req-page">

    {{-- Back --}}
    <a href="{{ route('admin.dashboard') }}" class="req-page__back">
        <svg viewBox="0 0 24 24" fill="none">
            <path
                d="M15 6l-6 6 6 6"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
            />
        </svg>

        {{ __('Back to Dashboard') }}
    </a>


    {{-- Header --}}
    <div class="req-page__head">

        <div class="req-page__heading">
            <h1>{{ __('Requests Management') }}</h1>

            <p>
                {{ __('Review and manage all requests submitted by users.') }}
            </p>
        </div>

        <a href="#" class="req-page__btn">
            <svg viewBox="0 0 24 24" fill="none">
                <path
                    d="M12 5v14M5 12h14"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                />
            </svg>

            {{ __('New Request') }}
        </a>

    </div>


    {{-- Filters --}}
    <section class="req-filters">

        <div class="req-filters__top">

            {{-- Search --}}
            <div class="req-filters__search">

                <svg viewBox="0 0 24 24" fill="none">
                    <circle
                        cx="11"
                        cy="11"
                        r="7"
                        stroke="currentColor"
                        stroke-width="2"
                    />
                    <path
                        d="M21 21l-4.3-4.3"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                    />
                </svg>

                <input
                    type="search"
                    placeholder="{{ __('Search requests...') }}"
                >

            </div>


            {{-- Reset --}}
            <button type="button" class="req-filters__reset">

                <svg viewBox="0 0 24 24" fill="none">
                    <path
                        d="M3 12a9 9 0 1 1 3 6.7"
                        stroke="currentColor"
                        stroke-width="1.6"
                        stroke-linecap="round"
                    />
                    <path
                        d="M3 8v5h5"
                        stroke="currentColor"
                        stroke-width="1.6"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>

                {{ __('Reset Filters') }}

            </button>


            {{-- Export --}}
            <button type="button" class="req-filters__export">

                <svg viewBox="0 0 24 24" fill="none">
                    <path
                        d="M12 3v12m0 0l-4-4m4 4l4-4M5 21h14"
                        stroke="currentColor"
                        stroke-width="1.6"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>

                {{ __('Export') }}

            </button>

        </div>


        {{-- Filter row --}}
        <div class="req-filters__row">

            <label class="req-filters__field">
                <span>{{ __('Request Type') }}</span>

                <div class="req-filters__select">
                    <span>{{ __('All Types') }}</span>

                    <svg viewBox="0 0 24 24" fill="none">
                        <path
                            d="M6 9l6 6 6-6"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                </div>
            </label>


            <label class="req-filters__field">
                <span>{{ __('Status') }}</span>

                <div class="req-filters__select">
                    <span>{{ __('All Statuses') }}</span>

                    <svg viewBox="0 0 24 24" fill="none">
                        <path
                            d="M6 9l6 6 6-6"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                </div>
            </label>


            <label class="req-filters__field">
                <span>{{ __('Programme / Project') }}</span>

                <div class="req-filters__select">
                    <span>{{ __('All Programmes') }}</span>

                    <svg viewBox="0 0 24 24" fill="none">
                        <path
                            d="M6 9l6 6 6-6"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                </div>
            </label>


            <label class="req-filters__field">
                <span>{{ __('Submitted By') }}</span>

                <div class="req-filters__select">
                    <span>{{ __('All Users') }}</span>

                    <svg viewBox="0 0 24 24" fill="none">
                        <path
                            d="M6 9l6 6 6-6"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                </div>
            </label>


            <label class="req-filters__field">
                <span>{{ __('Date Range') }}</span>

                <div class="req-filters__select">

                    <svg viewBox="0 0 24 24" fill="none">
                        <rect
                            x="3"
                            y="5"
                            width="18"
                            height="16"
                            rx="2"
                            stroke="currentColor"
                            stroke-width="1.6"
                        />
                        <path
                            d="M8 3v4M16 3v4M3 10h18"
                            stroke="currentColor"
                            stroke-width="1.6"
                            stroke-linecap="round"
                        />
                    </svg>

                    <span>{{ __('Select dates') }}</span>

                </div>
            </label>

        </div>

    </section>


    {{-- Stats --}}
    <div class="req-stats">

        <div class="req-stat">
            <span class="req-stat__icon req-stat__icon--blue">
                <svg viewBox="0 0 24 24" fill="none">
                    <path
                        d="M6 2h9l5 5v15H6V2Z"
                        stroke="currentColor"
                        stroke-width="1.6"
                        stroke-linejoin="round"
                    />
                    <path
                        d="M15 2v5h5"
                        stroke="currentColor"
                        stroke-width="1.6"
                    />
                </svg>
            </span>

            <div>
                <strong>{{ $stats['total'] }}</strong>
                <span>{{ __('Total Requests') }}</span>
            </div>
        </div>


        <div class="req-stat">
            <span class="req-stat__icon req-stat__icon--orange">
                <svg viewBox="0 0 24 24" fill="none">
                    <circle
                        cx="12"
                        cy="12"
                        r="9"
                        stroke="currentColor"
                        stroke-width="1.6"
                    />
                    <path
                        d="M12 7v5l3.5 2"
                        stroke="currentColor"
                        stroke-width="1.6"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
            </span>

            <div>
                <strong>{{ $stats['pending'] }}</strong>
                <span>{{ __('Pending') }}</span>
            </div>
        </div>


        <div class="req-stat">
            <span class="req-stat__icon req-stat__icon--green">
                <svg viewBox="0 0 24 24" fill="none">
                    <circle
                        cx="12"
                        cy="12"
                        r="9"
                        stroke="currentColor"
                        stroke-width="1.6"
                    />
                    <path
                        d="M8 12.5l2.5 2.5L16 9.5"
                        stroke="currentColor"
                        stroke-width="1.6"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
            </span>

            <div>
                <strong>{{ $stats['approved'] }}</strong>
                <span>{{ __('Approved') }}</span>
            </div>
        </div>


        <div class="req-stat">
            <span class="req-stat__icon req-stat__icon--red">
                <svg viewBox="0 0 24 24" fill="none">
                    <circle
                        cx="12"
                        cy="12"
                        r="9"
                        stroke="currentColor"
                        stroke-width="1.6"
                    />
                    <path
                        d="M9 9l6 6M15 9l-6 6"
                        stroke="currentColor"
                        stroke-width="1.6"
                        stroke-linecap="round"
                    />
                </svg>
            </span>

            <div>
                <strong>{{ $stats['rejected'] }}</strong>
                <span>{{ __('Rejected') }}</span>
            </div>
        </div>


        <div class="req-stat">
            <span class="req-stat__icon req-stat__icon--purple">
                <svg viewBox="0 0 24 24" fill="none">
                    <path
                        d="M4 12a8 8 0 0 1 13.3-6M20 12a8 8 0 0 1-13.3 6"
                        stroke="currentColor"
                        stroke-width="1.6"
                        stroke-linecap="round"
                    />
                    <path
                        d="M17 3v4h-4M7 21v-4h4"
                        stroke="currentColor"
                        stroke-width="1.6"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
            </span>

            <div>
                <strong>{{ $stats['in_progress'] }}</strong>
                <span>{{ __('In Progress') }}</span>
            </div>
        </div>

    </div>


    {{-- Toolbar --}}
    <div class="req-toolbar">

        <span class="req-toolbar__count">
            {{ $stats['total'] }} {{ __('Requests found') }}
        </span>

        <div class="req-toolbar__right">

            <label class="req-toolbar__sort">

                <span>{{ __('Sort by:') }}</span>

                <div class="req-toolbar__select">
                    <span>{{ __('Newest First') }}</span>

                    <svg viewBox="0 0 24 24" fill="none">
                        <path
                            d="M6 9l6 6 6-6"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                </div>

            </label>


            <div class="req-toolbar__view">

                <button type="button" class="is-active">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path
                            d="M4 6h16M4 12h16M4 18h16"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                        />
                    </svg>

                    {{ __('Table') }}
                </button>

                <button type="button">
                    <svg viewBox="0 0 24 24" fill="none">
                        <rect
                            x="3"
                            y="4"
                            width="7"
                            height="16"
                            rx="1.5"
                            stroke="currentColor"
                            stroke-width="1.6"
                        />
                        <rect
                            x="14"
                            y="4"
                            width="7"
                            height="16"
                            rx="1.5"
                            stroke="currentColor"
                            stroke-width="1.6"
                        />
                    </svg>

                    {{ __('Board') }}
                </button>

            </div>

        </div>

    </div>


    {{-- Table --}}
    <div class="req-table-wrap">

        <table class="req-table">

            <thead>
                <tr>
                    <th>{{ __('Request ID') }}</th>
                    <th>{{ __('Request Type') }}</th>
                    <th>{{ __('Title / Description') }}</th>
                    <th>{{ __('Programme / Project') }}</th>
                    <th>{{ __('Submitted By') }}</th>
                    <th>{{ __('Submitted On') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($requests as $request)

                    @php
                        $typeClass = \Illuminate\Support\Str::slug($request['type']);
                        $statusClass = \Illuminate\Support\Str::slug($request['status']);
                    @endphp

                    <tr>

                        <td>
                            <strong class="req-table__id">
                                {{ $request['id'] }}
                            </strong>
                        </td>


                        <td>
                            <span class="req-table__type req-table__type--{{ $typeClass }}">
                                {{ __($request['type']) }}
                            </span>
                        </td>


                        <td class="req-table__title">
                            {{ __($request['title']) }}
                        </td>


                        <td>
                            {{ __($request['programme']) }}
                        </td>


                        <td>

                            <div class="req-table__user">

                                <span class="req-table__avatar">
                                    {{ $request['initials'] }}
                                </span>

                                <div>
                                    <strong>
                                        {{ $request['user'] }}
                                    </strong>

                                    <span>
                                        {{ __($request['role']) }}
                                    </span>
                                </div>

                            </div>

                        </td>


                        <td>
                            {{ __($request['date']) }}
                        </td>


                        <td>

                            <span class="req-table__status req-table__status--{{ $statusClass }}">
                                {{ __($request['status']) }}
                            </span>

                        </td>


                        <td>

                            <div class="req-table__actions">

                                <a
                                    href="#"
                                    aria-label="{{ __('View') }}"
                                    title="{{ __('View') }}"
                                >
                                    <svg viewBox="0 0 24 24" fill="none">
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
                                    aria-label="{{ __('More') }}"
                                    title="{{ __('More') }}"
                                >
                                    <svg viewBox="0 0 24 24" fill="none">
                                        <circle cx="12" cy="5" r="1.4" fill="currentColor"/>
                                        <circle cx="12" cy="12" r="1.4" fill="currentColor"/>
                                        <circle cx="12" cy="19" r="1.4" fill="currentColor"/>
                                    </svg>
                                </button>

                            </div>

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>


        {{-- Pagination --}}
        <div class="req-pagination">

            <span>
                {{ __('Showing 1 to') }}
                {{ count($requests) }}
                {{ __('of') }}
                {{ $stats['total'] }}
                {{ __('requests') }}
            </span>

            <div class="req-pagination__buttons">

                <button
                    type="button"
                    aria-label="{{ __('Previous page') }}"
                >
                    &lsaquo;
                </button>

                <button type="button" class="is-active">1</button>
                <button type="button">2</button>
                <button type="button">3</button>
                <button type="button">4</button>
                <button type="button">5</button>

                <span>&hellip;</span>

                <button type="button">22</button>

                <button
                    type="button"
                    aria-label="{{ __('Next page') }}"
                >
                    &rsaquo;
                </button>

            </div>

        </div>

    </div>

</div>

@endsection