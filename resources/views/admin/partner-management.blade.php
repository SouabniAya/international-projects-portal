@extends('layouts.admin')



@section('title', 'Partner Management')

@php
    // Placeholder data -- replace with real Partner model/query later
    $partners = [
        ['id' => 1, 'name' => 'KU Leuven', 'subname' => 'Katholieke Universiteit Leuven', 'flag' => 'images/flags/be.png', 'country' => 'Belgium', 'city' => 'Leuven', 'type' => 'University', 'domain' => 'Engineering', 'ptype' => 'Bilateral Agreement', 'status' => 'Active', 'logo' => 'images/partners/kuleuven.png'],
        ['id' => 2, 'name' => 'Technische Universitat Munchen', 'subname' => 'TUM', 'flag' => 'images/flags/de.png', 'country' => 'Germany', 'city' => 'Munich', 'type' => 'University', 'domain' => 'Engineering', 'ptype' => 'Bilateral Agreement', 'status' => 'Active', 'logo' => 'images/partners/tum.png'],
        ['id' => 3, 'name' => 'Universite Paris-Saclay', 'subname' => 'Paris-Saclay University', 'flag' => 'images/flags/fr.png', 'country' => 'France', 'city' => 'Paris', 'type' => 'University', 'domain' => 'Sciences', 'ptype' => 'Framework Agreement', 'status' => 'Active', 'logo' => 'images/partners/paris-saclay.png'],
        ['id' => 4, 'name' => 'Polytechnic University of Milan', 'subname' => 'Politecnico di Milano', 'flag' => 'images/flags/it.png', 'country' => 'Italy', 'city' => 'Milan', 'type' => 'University', 'domain' => 'Engineering', 'ptype' => 'Bilateral Agreement', 'status' => 'Active', 'logo' => 'images/partners/milano.png'],
        ['id' => 5, 'name' => 'University of Cambridge', 'subname' => 'Cambridge', 'flag' => 'images/flags/gb.png', 'country' => 'United Kingdom', 'city' => 'Cambridge', 'type' => 'University', 'domain' => 'Sciences', 'ptype' => 'Bilateral Agreement', 'status' => 'Active', 'logo' => 'images/partners/cambridge.png'],
        ['id' => 6, 'name' => 'Eindhoven University of Technology', 'subname' => 'TU/e', 'flag' => 'images/flags/nl.png', 'country' => 'Netherlands', 'city' => 'Eindhoven', 'type' => 'University', 'domain' => 'Engineering', 'ptype' => 'Bilateral Agreement', 'status' => 'Pending', 'logo' => 'images/partners/eindhoven.png'],
    ];
@endphp

@section('content')
<div class="ptm-page">

    <a href="{{ route('admin.dashboard') }}" class="ptm-page__back">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 6l-6 6 6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        Back to Dashboard
    </a>

    <div class="ptm-page__head">
        <div>
            <h1>Partner Management</h1>
            <p>Manage institutional partners and international cooperation agreements.</p>
        </div>
        <a href="#" class="ptm-page__btn">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
            Add Partner
        </a>
    </div>

    {{-- Filters --}}
    <div class="ptm-filters">
        <div class="ptm-filters__top">
            <div class="ptm-filters__search">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                <input type="search" placeholder="Search partners...">
            </div>
            <button type="button" class="ptm-filters__reset">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 12a9 9 0 1 1 3 6.7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M3 8v5h5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Reset Filters
            </button>
            <button type="button" class="ptm-filters__export">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 3v12m0 0l-4-4m4 4l4-4M5 21h14" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Export
            </button>
        </div>

        <div class="ptm-filters__row">
            <label class="ptm-filters__field">
                <span>Country / Region</span>
                <div class="ptm-filters__select">
                    <span>All Countries</span>
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </label>

            <label class="ptm-filters__field">
                <span>Type of Institution</span>
                <div class="ptm-filters__select">
                    <span>All Types</span>
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </label>

            <label class="ptm-filters__field">
                <span>Domain of Cooperation</span>
                <div class="ptm-filters__select">
                    <span>All Domains</span>
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </label>

            <label class="ptm-filters__field">
                <span>Partnership Type</span>
                <div class="ptm-filters__select">
                    <span>All Types</span>
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </label>

            <label class="ptm-filters__field">
                <span>Partnership Status</span>
                <div class="ptm-filters__select">
                    <span>All Statuses</span>
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </label>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="ptm-toolbar">
        <span class="ptm-toolbar__count">{{ count($partners) }} Partners found</span>
        <div class="ptm-toolbar__right">
            <label class="ptm-toolbar__sort">
                <span>Sort by:</span>
                <div class="ptm-toolbar__select">
                    <span>Name A-Z</span>
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </label>
            <div class="ptm-toolbar__view">
                <button type="button" class="is-active">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                    Table
                </button>
                <button type="button">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="3" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="1.6"/><rect x="14" y="3" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="1.6"/><rect x="3" y="14" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="1.6"/><rect x="14" y="14" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="1.6"/></svg>
                    Map
                </button>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="ptm-table-wrap">
        <table class="ptm-table">
            <thead>
                <tr>
                    <th>Partner</th>
                    <th>Country / City</th>
                    <th>Type of Institution</th>
                    <th>Domain of Cooperation</th>
                    <th>Partnership Type</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($partners as $partner)
                <tr>
                    <td>
                        <div class="ptm-table__partner">
                            <img src="{{ asset($partner['logo']) }}" alt="" class="ptm-table__logo">
                            <div>
                                <strong>{{ $partner['name'] }}</strong>
                                <span>{{ $partner['subname'] }}</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="ptm-table__location">
                            <img src="{{ asset($partner['flag']) }}" alt="" class="ptm-table__flag">
                            <div>
                                <strong>{{ $partner['country'] }}</strong>
                                <span>{{ $partner['city'] }}</span>
                            </div>
                        </div>
                    </td>
                    <td>{{ $partner['type'] }}</td>
                    <td><span class="ptm-table__tag">{{ $partner['domain'] }}</span></td>
                    <td>{{ $partner['ptype'] }}</td>
                    <td><span class="ptm-table__status ptm-table__status--{{ \Illuminate\Support\Str::slug($partner['status']) }}">{{ $partner['status'] }}</span></td>
                    <td>
                        <div class="ptm-table__actions">
                            <a href="#" aria-label="View">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.5 12S5 5 12 5s10.5 7 10.5 7-3.5 7-10.5 7-10.5-7-10.5-7Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.6"/></svg>
                            </a>
                            <button type="button" aria-label="More options">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="5" r="1.4" fill="currentColor"/><circle cx="12" cy="12" r="1.4" fill="currentColor"/><circle cx="12" cy="19" r="1.4" fill="currentColor"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="ptm-pagination">
            <span>Showing 1 to {{ count($partners) }} of 86 partners</span>
            <div class="ptm-pagination__buttons">
                <button type="button" aria-label="Previous page">&lsaquo;</button>
                <button type="button" class="is-active">1</button>
                <button type="button">2</button>
                <button type="button">3</button>
                <button type="button">4</button>
                <button type="button">5</button>
                <span>&hellip;</span>
                <button type="button">15</button>
                <button type="button" aria-label="Next page">&rsaquo;</button>
            </div>
        </div>
    </div>

</div>
@endsection