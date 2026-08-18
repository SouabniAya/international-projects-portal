@extends('layouts.admin')



@section('title', 'Agreement Management')

@section('content')
<div class="agr-page">

    <a href="{{ url('/admin/dashboard') }}" class="agr-page__back">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 6l-6 6 6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        {{ __('Back to Dashboard') }}
    </a>

    <div class="agr-page__head">
        <div>
            <h1>{{ __('Agreement Management') }}</h1>
            <p>{{ __('Manage institutional agreements and cooperation frameworks.') }}</p>
        </div>
        <a href="#" class="agr-page__btn">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
            {{ __('New Agreement') }}
        </a>
    </div>

    {{-- Filters --}}
    <div class="agr-filters">
        <div class="agr-filters__search">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            <input type="search" placeholder="{{ __('Search agreements...') }}">
        </div>

        <div class="agr-filters__row">
            @php
            $filterGroups = [
                ['label' => 'Partner', 'default' => 'All Partners'],
                ['label' => 'Country / Region', 'default' => 'All Countries'],
                ['label' => 'Type of Agreement', 'default' => 'All Types'],
                ['label' => 'Domain of Cooperation', 'default' => 'All Domains'],
                ['label' => 'Status', 'default' => 'All Statuses'],
            ];
            @endphp

            @foreach($filterGroups as $group)
            <div class="agr-filters__field">
                <label>{{ __($group['label']) }}</label>
                <div class="agr-filters__select">
                    <span>{{ __($group['default']) }}</span>
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </div>
            @endforeach

            <div class="agr-filters__actions">
                <button type="button" class="agr-filters__reset">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 12a9 9 0 1 1 3 6.7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M3 8v5h5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    {{ __('Reset Filters') }}
                </button>
                <button type="button" class="agr-filters__export">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 3v12m0 0l-4-4m4 4l4-4M5 21h14" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    {{ __('Export') }}
                </button>
            </div>
        </div>
    </div>

    {{-- Stat cards --}}
    <div class="agr-stats">
        @php
        // Placeholder data -- replace with real Agreement model/query later
        $stats = [
            ['value' => 78, 'label' => 'Total Agreements', 'icon' => 'doc', 'color' => 'blue'],
            ['value' => 52, 'label' => 'Active Agreements', 'icon' => 'handshake', 'color' => 'green'],
            ['value' => 14, 'label' => 'Expiring Soon', 'sub' => '(Next 6 months)', 'icon' => 'clock', 'color' => 'orange'],
            ['value' => 8, 'label' => 'Expired', 'icon' => 'calendar-check', 'color' => 'purple'],
            ['value' => 4, 'label' => 'Under Renewal', 'icon' => 'pencil', 'color' => 'sky'],
        ];
        @endphp

        @foreach($stats as $stat)
        <div class="agr-stat-card">
            <span class="agr-stat-card__icon agr-stat-card__icon--{{ $stat['color'] }}">
                @switch($stat['icon'])
                    @case('doc')
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 2h9l5 5v13a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M14 2v6h6" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                        @break
                    @case('handshake')
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2 12l5-5 4 3 3-3 5 5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M6 14l3 3 2-2M14 15l2 2 3-3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        @break
                    @case('clock')
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/><path d="M12 7v5l3 3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        @break
                    @case('calendar-check')
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="5" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M8 3v4M16 3v4M3 10h18" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M9 15l2 2 4-4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        @break
                    @case('pencil')
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="5" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M8 3v4M16 3v4M3 10h18" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M13.5 14.5l2 2L20 12l-2-2-4.5 4.5Z" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/></svg>
                        @break
                @endswitch
            </span>
            <div class="agr-stat-card__body">
                <strong>{{ $stat['value'] }}</strong>
                <span>{{ __($stat['label']) }} @if(isset($stat['sub']))<em>{{ __($stat['sub']) }}</em>@endif</span>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Toolbar --}}
    <div class="agr-toolbar">
        <span class="agr-toolbar__count">{{ __('78 Agreements found') }}</span>
        <div class="agr-toolbar__right">
            <label class="agr-toolbar__sort">
                <span>{{ __('Sort by:') }}</span>
                <div class="agr-toolbar__select">
                    <span>{{ __('Newest First') }}</span>
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </label>
            <div class="agr-toolbar__view">
                <button type="button" class="is-active">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="4" width="18" height="4" rx="1" stroke="currentColor" stroke-width="1.6"/><rect x="3" y="10" width="18" height="4" rx="1" stroke="currentColor" stroke-width="1.6"/><rect x="3" y="16" width="18" height="4" rx="1" stroke="currentColor" stroke-width="1.6"/></svg>
                    {{ __('Table') }}
                </button>
                <button type="button">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="4" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M3 10h18M9 4v16" stroke="currentColor" stroke-width="1.6"/></svg>
                    {{ __('Calendar') }}
                </button>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="agr-table-wrap">
        <table class="agr-table">
            <thead>
                <tr>
                    <th>{{ __('Agreement Title') }}</th>
                    <th>{{ __('Partner') }}</th>
                    <th>{{ __('Country') }}</th>
                    <th>{{ __('Type') }}</th>
                    <th>{{ __('Domain of Cooperation') }}</th>
                    <th>{{ __('Start Date') }}</th>
                    <th>{{ __('End Date') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @php
                // Placeholder data -- replace with real Agreement model/query later
                $agreements = [
                    ['id' => 1, 'title' => 'General Cooperation Agreement', 'ref' => 'GCA-2025-001', 'partner' => 'KU Leuven', 'logo' => 'images/partners/kuleuven.png', 'country' => 'Belgium', 'flag' => 'images/flags/be.png', 'type' => 'Framework Agreement', 'domain' => 'Engineering', 'start' => 'Jan 15, 2025', 'end' => 'Jan 14, 2030', 'status' => 'Active'],
                    ['id' => 2, 'title' => 'Erasmus+ Inter-Institutional Agreement', 'ref' => 'ERASMUS-2024-045', 'partner' => 'Technische Universität München', 'logo' => 'images/partners/tum.png', 'country' => 'Germany', 'flag' => 'images/flags/de.png', 'type' => 'Academic Agreement', 'domain' => 'Engineering, Sciences', 'start' => 'Sep 1, 2024', 'end' => 'Aug 31, 2029', 'status' => 'Active'],
                    ['id' => 3, 'title' => 'Research Collaboration Agreement', 'ref' => 'RCA-2024-032', 'partner' => 'Université Paris-Saclay', 'logo' => 'images/partners/paris-saclay.png', 'country' => 'France', 'flag' => 'images/flags/fr.png', 'type' => 'Research Agreement', 'domain' => 'Sciences', 'start' => 'Mar 10, 2024', 'end' => 'Mar 9, 2027', 'status' => 'Active'],
                    ['id' => 4, 'title' => 'Student Exchange Agreement', 'ref' => 'SEA-2024-018', 'partner' => 'Politecnico di Milano', 'logo' => 'images/partners/polimi.png', 'country' => 'Italy', 'flag' => 'images/flags/it.png', 'type' => 'Exchange Agreement', 'domain' => 'Engineering, Design', 'start' => 'Feb 1, 2024', 'end' => 'Jan 31, 2027', 'status' => 'Expiring Soon'],
                    ['id' => 5, 'title' => 'Double Degree Agreement', 'ref' => 'DDA-2023-011', 'partner' => 'University of Cambridge', 'logo' => 'images/partners/cambridge.png', 'country' => 'United Kingdom', 'flag' => 'images/flags/gb.png', 'type' => 'Academic Agreement', 'domain' => 'Sciences', 'start' => 'Oct 1, 2023', 'end' => 'Sep 30, 2026', 'status' => 'Active'],
                    ['id' => 6, 'title' => 'Memorandum of Understanding', 'ref' => 'MOU-2023-007', 'partner' => 'Eindhoven University of Technology', 'logo' => 'images/partners/tue.png', 'country' => 'Netherlands', 'flag' => 'images/flags/nl.png', 'type' => 'MoU', 'domain' => 'Engineering', 'start' => 'Jul 15, 2023', 'end' => 'Jul 14, 2026', 'status' => 'Expired'],
                ];
                @endphp

                @foreach($agreements as $agreement)
                <tr>
                    <td>
                        <div class="agr-table__title">
                            <strong>{{ __($agreement['title']) }}</strong>
                            <span>{{ __('Ref:') }} {{ $agreement['ref'] }}</span>
                        </div>
                    </td>
                    <td>
                        <div class="agr-table__partner">
                            <img src="{{ asset($agreement['logo']) }}" alt="">
                            <span>{{ $agreement['partner'] }}</span>
                        </div>
                    </td>
                    <td>
                        <div class="agr-table__country">
                            <img src="{{ asset($agreement['flag']) }}" alt="">
                            <span>{{ __($agreement['country']) }}</span>
                        </div>
                    </td>
                    <td><span class="agr-table__tag agr-table__tag--{{ \Illuminate\Support\Str::slug($agreement['type']) }}">{{ __($agreement['type']) }}</span></td>
                    <td>{{ __($agreement['domain']) }}</td>
                    <td>{{ $agreement['start'] }}</td>
                    <td>{{ $agreement['end'] }}</td>
                    <td><span class="agr-table__status agr-table__status--{{ \Illuminate\Support\Str::slug($agreement['status']) }}">{{ __($agreement['status']) }}</span></td>
                    <td>
                        <div class="agr-table__actions">
                            <a href="{{ route('admin.agreement-details', $agreement['id']) }}" aria-label="{{ __('View') }}">
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

        <div class="agr-pagination">
            <span>{{ __('Showing 1 to 6 of 78 agreements') }}</span>
            <div class="agr-pagination__buttons">
                <button type="button" aria-label="{{ __('Previous page') }}">‹</button>
                <button type="button" class="is-active">1</button>
                <button type="button">2</button>
                <button type="button">3</button>
                <button type="button">4</button>
                <button type="button">5</button>
                <span>…</span>
                <button type="button">13</button>
                <button type="button" aria-label="{{ __('Next page') }}">›</button>
            </div>
        </div>
    </div>

</div>
@endsection