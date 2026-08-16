@extends('layouts.admin')

<h1 style="color:red">TESTABC</h1>

@section('title', 'Call for Proposals Management')

@php($active = 'calls')

@php
    // Placeholder data -- replace with real Call model/query later
    $calls = [
        ['id' => 1, 'title' => 'Erasmus+ KA220 – Cooperation Partnerships in Higher Education', 'ref' => 'ERASMUS-EDU-2025-CP-HE', 'flag' => 'images/flags/eu.png', 'programme' => 'Erasmus+', 'type' => 'Partnership', 'status' => 'Open', 'opening' => 'Apr 15, 2025', 'deadline' => 'Jun 30, 2025'],
        ['id' => 2, 'title' => 'Horizon Europe – Research and Innovation Actions (RIA)', 'ref' => 'HORIZON-CL4-2025-01-RIA', 'flag' => 'images/flags/horizon.png', 'programme' => 'Horizon Europe', 'type' => 'Research & Innovation', 'status' => 'Open Soon', 'opening' => 'May 22, 2025', 'deadline' => 'Sep 18, 2025'],
        ['id' => 3, 'title' => 'MSCA Doctoral Networks 2025', 'ref' => 'HORIZON-MSCA-2025-DN-01', 'flag' => 'images/flags/msca.png', 'programme' => 'MSCA', 'type' => 'Research Training', 'status' => 'Open', 'opening' => 'Apr 8, 2025', 'deadline' => 'May 28, 2025'],
        ['id' => 4, 'title' => 'PRIMA Section 2 – Multi-topic 2025', 'ref' => 'PRIMA-S2-2025', 'flag' => 'images/flags/prima.png', 'programme' => 'PRIMA', 'type' => 'Research & Innovation', 'status' => 'Upcoming', 'opening' => 'Jun 1, 2025', 'deadline' => 'Aug 28, 2025'],
        ['id' => 5, 'title' => 'ERC Starting Grants 2025', 'ref' => 'ERC-2025-StG', 'flag' => 'images/flags/eu.png', 'programme' => 'European Commission', 'type' => 'Research', 'status' => 'Closed', 'opening' => 'Jul 11, 2024', 'deadline' => 'Oct 17, 2024'],
        ['id' => 6, 'title' => 'World Bank – Research Grants Program', 'ref' => 'WBG-RGP-2025', 'flag' => 'images/flags/worldbank.png', 'programme' => 'World Bank', 'type' => 'Grant', 'status' => 'Closed', 'opening' => 'Jan 10, 2025', 'deadline' => 'Mar 10, 2025'],
    ];
@endphp

@section('content')
<div class="cfp-page">

    <a href="{{ route('admin.dashboard') }}" class="cfp-page__back">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 6l-6 6 6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        {{ __('Back to Dashboard') }}
    </a>

    <div class="cfp-page__head">
        <div>
            <h1>{{ __('Call for Proposals Management') }}</h1>
            <p>{{ __('Browse, manage and publish calls for proposals and funding opportunities.') }}</p>
        </div>
        <a href="#" class="cfp-page__btn">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
            {{ __('New Call for Proposals') }}
        </a>
    </div>

    {{-- Filters --}}
    <div class="cfp-filters">
        <div class="cfp-filters__top">
            <div class="cfp-filters__search">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                <input type="search" placeholder="{{ __('Search calls...') }}">
            </div>
            <button type="button" class="cfp-filters__reset">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 12a9 9 0 1 1 3 6.7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M3 8v5h5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                {{ __('Reset Filters') }}
            </button>
            <button type="button" class="cfp-filters__export">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 3v12m0 0l-4-4m4 4l4-4M5 21h14" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                {{ __('Export') }}
            </button>
        </div>

        <div class="cfp-filters__row">
            @php
                $filterGroups = [
                    ['label' => 'Programme', 'default' => 'All Programmes'],
                    ['label' => 'Status', 'default' => 'All Statuses'],
                    ['label' => 'Call Type', 'default' => 'All Types'],
                    ['label' => 'Thematic Area', 'default' => 'All Areas'],
                    ['label' => 'Opening Year', 'default' => 'All Years'],
                ];
            @endphp

            @foreach ($filterGroups as $group)
            <label class="cfp-filters__field">
                <span>{{ __($group['label']) }}</span>
                <div class="cfp-filters__select">
                    <span>{{ __($group['default']) }}</span>
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </label>
            @endforeach
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="cfp-toolbar">
        <span class="cfp-toolbar__count">{{ count($calls) }} {{ __('Calls for Proposals') }}</span>
        <div class="cfp-toolbar__right">
            <label class="cfp-toolbar__sort">
                <span>{{ __('Sort by:') }}</span>
                <div class="cfp-toolbar__select">
                    <span>{{ __('Newest First') }}</span>
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </label>
            <div class="cfp-toolbar__view">
                <button type="button" class="is-active">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                    {{ __('Table') }}
                </button>
                <button type="button">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="4" width="7" height="16" rx="1.5" stroke="currentColor" stroke-width="1.6"/><rect x="14" y="4" width="7" height="16" rx="1.5" stroke="currentColor" stroke-width="1.6"/></svg>
                    {{ __('Board') }}
                </button>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="cfp-table-wrap">
        <table class="cfp-table">
            <thead>
                <tr>
                    <th>{{ __('Call Title') }}</th>
                    <th>{{ __('Programme') }}</th>
                    <th>{{ __('Type') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Opening Date') }}</th>
                    <th>{{ __('Deadline') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($calls as $call)
                <tr>
                    <td>
                        <div class="cfp-table__call">
                            <img src="{{ asset($call['flag']) }}" alt="" class="cfp-table__flag">
                            <div>
                                <strong>{{ __($call['title']) }}</strong>
                                <span>{{ __('Ref:') }} {{ $call['ref'] }}</span>
                            </div>
                        </div>
                    </td>
                    <td><span class="cfp-table__tag">{{ __($call['programme']) }}</span></td>
                    <td>{{ __($call['type']) }}</td>
                    <td><span class="cfp-table__status cfp-table__status--{{ \Illuminate\Support\Str::slug($call['status']) }}">{{ __($call['status']) }}</span></td>
                    <td>{{ $call['opening'] }}</td>
                    <td class="cfp-table__deadline">{{ $call['deadline'] }}</td>
                    <td>
                        <div class="cfp-table__actions">
                            <a href="#" aria-label="{{ __('View') }}">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.5 12S5 5 12 5s10.5 7 10.5 7-3.5 7-10.5 7-10.5-7-10.5-7Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.6"/></svg>
                            </a>
                            <button type="button" aria-label="{{ __('More options') }}">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="5" r="1.4" fill="currentColor"/><circle cx="12" cy="12" r="1.4" fill="currentColor"/><circle cx="12" cy="19" r="1.4" fill="currentColor"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="cfp-pagination">
            <span>{{ __('Showing 1 to :count of 18 calls', ['count' => count($calls)]) }}</span>
            <div class="cfp-pagination__buttons">
                <button type="button" aria-label="{{ __('Previous page') }}">&lsaquo;</button>
                <button type="button" class="is-active">1</button>
                <button type="button">2</button>
                <button type="button">3</button>
                <button type="button" aria-label="{{ __('Next page') }}">&rsaquo;</button>
            </div>
        </div>
    </div>

</div>
@endsection