@extends('layouts.admin')

@section('title', __('Funding Programme Management'))

@php
    // Placeholder data -- replace with real Programme model/query later
    $programmes = [
        ['id' => 1, 'name' => 'Erasmus+', 'subname' => 'European Union Programme for Education and Training', 'flag' => 'images/flags/eu.png', 'body' => 'European Commission', 'type' => 'EU Programme', 'active_calls' => 28, 'budget' => '€26,200,000', 'years' => '2021 - 2027', 'status' => 'Active'],
        ['id' => 2, 'name' => 'Horizon Europe', 'subname' => 'EU Research & Innovation Programme', 'flag' => 'images/flags/horizon.png', 'body' => 'European Commission', 'type' => 'EU Programme', 'active_calls' => 35, 'budget' => '€95,500,000', 'years' => '2021 - 2027', 'status' => 'Active'],
        ['id' => 3, 'name' => 'Marie Skłodowska-Curie Actions (MSCA)', 'subname' => 'Research and Innovation Staff Exchange', 'flag' => 'images/flags/msca.png', 'body' => 'European Commission', 'type' => 'EU Programme', 'active_calls' => 12, 'budget' => '€6,600,000', 'years' => '2021 - 2027', 'status' => 'Active'],
        ['id' => 4, 'name' => 'PRIMA Programme', 'subname' => 'Partnership for Research and Innovation in the Mediterranean Area', 'flag' => 'images/flags/prima.png', 'body' => 'PRIMA Foundation', 'type' => 'Multilateral', 'active_calls' => 8, 'budget' => '€2,800,000', 'years' => '2021 - 2027', 'status' => 'Active'],
        ['id' => 5, 'name' => 'World Bank Research Grants', 'subname' => 'Research and Innovation Support', 'flag' => 'images/flags/worldbank.png', 'body' => 'World Bank', 'type' => 'International', 'active_calls' => 5, 'budget' => '€1,200,000', 'years' => '2023 - 2028', 'status' => 'Upcoming'],
        ['id' => 6, 'name' => 'AUF Funding Programme', 'subname' => 'Francophonie University Agency Support', 'flag' => 'images/flags/auf.png', 'body' => 'AUF', 'type' => 'Institutional', 'active_calls' => 6, 'budget' => '€950,000', 'years' => '2024 - 2026', 'status' => 'Active'],
    ];

    $summary = [
        'total' => 12,
        'active' => 9,
        'upcoming' => 2,
        'closed' => 1,
        'total_budget' => '€133,250,000',
    ];

    $topFundingBodies = [
        ['name' => 'European Commission', 'count' => 4],
        ['name' => 'PRIMA Foundation', 'count' => 1],
        ['name' => 'World Bank', 'count' => 1],
        ['name' => 'AUF', 'count' => 1],
        ['name' => 'Other', 'count' => 5],
    ];
@endphp

@section('content')
<div class="fpm-page">

    <a href="{{ route('admin.dashboard') }}" class="fpm-page__back">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 6l-6 6 6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        {{ __('Back to Dashboard') }}
    </a>

    <div class="fpm-page__head">
        <div>
            <h1>{{ __('Funding Programme Management') }}</h1>
            <p>{{ __('Manage funding programmes, their details, budgets, and associated calls.') }}</p>
        </div>

        <a href="#" class="fpm-page__btn">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
            </svg>
            {{ __('New Programme') }}
        </a>
    </div>

    {{-- Filters --}}
    <div class="fpm-filters">
        <div class="fpm-filters__top">

            <div class="fpm-filters__search">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/>
                    <path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>

                <input type="search" placeholder="{{ __('Search programmes...') }}">
            </div>

            <button type="button" class="fpm-filters__reset">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 12a9 9 0 1 1 3 6.7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                    <path d="M3 8v5h5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                {{ __('Reset Filters') }}
            </button>

            <button type="button" class="fpm-filters__export">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 3v12m0 0l-4-4m4 4l4-4M5 21h14" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                {{ __('Export') }}
            </button>
        </div>

        <div class="fpm-filters__row">

            <label class="fpm-filters__field">
                <span>{{ __('Status') }}</span>
                <div class="fpm-filters__select">
                    <span>{{ __('All Statuses') }}</span>
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </label>

            <label class="fpm-filters__field">
                <span>{{ __('Programme Type') }}</span>
                <div class="fpm-filters__select">
                    <span>{{ __('All Types') }}</span>
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </label>

            <label class="fpm-filters__field">
                <span>{{ __('Funding Body') }}</span>
                <div class="fpm-filters__select">
                    <span>{{ __('All Funding Bodies') }}</span>
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </label>

            <label class="fpm-filters__field">
                <span>{{ __('Region') }}</span>
                <div class="fpm-filters__select">
                    <span>{{ __('All Regions') }}</span>
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </label>

            <label class="fpm-filters__field">
                <span>{{ __('Year') }}</span>
                <div class="fpm-filters__select">
                    <span>{{ __('All Years') }}</span>
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </label>

        </div>
    </div>

    <div class="fpm-layout">

        {{-- Main column --}}
        <div class="fpm-main">

            <div class="fpm-toolbar">
                <span class="fpm-toolbar__count">
                    {{ count($programmes) }} {{ __('Programmes') }}
                </span>

                <div class="fpm-toolbar__right">

                    <label class="fpm-toolbar__sort">
                        <span>{{ __('Sort by:') }}</span>

                        <div class="fpm-toolbar__select">
                            <span>{{ __('Newest First') }}</span>
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </label>

                    <div class="fpm-toolbar__view">
                        <button type="button" class="is-active">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                            </svg>
                            {{ __('Table') }}
                        </button>
                    </div>

                </div>
            </div>

            {{-- Table --}}
            <div class="fpm-table-wrap">
                <table class="fpm-table">

                    <thead>
                        <tr>
                            <th>{{ __('Programme') }}</th>
                            <th>{{ __('Funding Body') }}</th>
                            <th>{{ __('Type') }}</th>
                            <th>{{ __('Active Calls') }}</th>
                            <th>{{ __('Total Budget') }}</th>
                            <th>{{ __('Year') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($programmes as $programme)
                        <tr>
                            <td>
                                <div class="fpm-table__programme">
                                    <img
                                        src="{{ asset($programme['flag']) }}"
                                        alt=""
                                        class="fpm-table__flag"
                                    >

                                    <div>
                                        <strong>{{ __($programme['name']) }}</strong>
                                        <span>{{ __($programme['subname']) }}</span>
                                    </div>
                                </div>
                            </td>

                            <td>{{ __($programme['body']) }}</td>

                            <td>
                                <span class="fpm-table__tag">
                                    {{ __($programme['type']) }}
                                </span>
                            </td>

                            <td>{{ $programme['active_calls'] }}</td>
                            <td>{{ $programme['budget'] }}</td>
                            <td>{{ $programme['years'] }}</td>

                            <td>
                                <span class="fpm-table__status fpm-table__status--{{ \Illuminate\Support\Str::slug($programme['status']) }}">
                                    {{ __($programme['status']) }}
                                </span>
                            </td>

                            <td>
                                <div class="fpm-table__actions">
                                    <button type="button" aria-label="{{ __('More options') }}">
                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
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

                <div class="fpm-pagination">
                    <span>
                        {{ __('Showing 1 to :count of :total programmes', [
                            'count' => count($programmes),
                            'total' => $summary['total']
                        ]) }}
                    </span>

                    <div class="fpm-pagination__buttons">
                        <button type="button" aria-label="{{ __('Previous page') }}">&lsaquo;</button>
                        <button type="button" class="is-active">1</button>
                        <button type="button">2</button>
                        <button type="button" aria-label="{{ __('Next page') }}">&rsaquo;</button>
                    </div>
                </div>

            </div>
        </div>

        {{-- Sidebar --}}
        <aside class="fpm-side">

            <div class="fpm-card">
                <h3>{{ __('Programme Summary') }}</h3>

                <ul class="fpm-card__list">
                    <li>
                        <span>{{ __('Total Programmes') }}</span>
                        <strong>{{ $summary['total'] }}</strong>
                    </li>

                    <li>
                        <span>{{ __('Active Programmes') }}</span>
                        <strong>{{ $summary['active'] }}</strong>
                    </li>

                    <li>
                        <span>{{ __('Upcoming Programmes') }}</span>
                        <strong>{{ $summary['upcoming'] }}</strong>
                    </li>

                    <li>
                        <span>{{ __('Closed Programmes') }}</span>
                        <strong>{{ $summary['closed'] }}</strong>
                    </li>

                    <li class="fpm-card__list-total">
                        <span>{{ __('Total Budget') }}</span>
                        <strong>{{ $summary['total_budget'] }}</strong>
                    </li>
                </ul>
            </div>

            <div class="fpm-card">
                <h3>{{ __('Top Funding Bodies') }}</h3>

                <ul class="fpm-card__list">
                    @foreach ($topFundingBodies as $body)
                    <li>
                        <span>{{ __($body['name']) }}</span>
                        <strong>{{ $body['count'] }}</strong>
                    </li>
                    @endforeach
                </ul>
            </div>

            <div class="fpm-card">
                <h3>{{ __('Quick Actions') }}</h3>

                <ul class="fpm-card__actions">
                    <li><a href="#">{{ __('Add New Programme') }}</a></li>
                    <li><a href="{{ route('admin.calls') }}">{{ __('Manage Calls') }}</a></li>
                    <li><a href="#">{{ __('Manage Funding Bodies') }}</a></li>
                    <li><a href="#">{{ __('Programme Categories') }}</a></li>
                    <li><a href="#">{{ __('Export Programmes Data') }}</a></li>
                </ul>
            </div>

        </aside>

    </div>

</div>
@endsection