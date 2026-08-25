@extends('layouts.admin')

@section('title', 'Partner Management')

@section('content')

<div class="ptm-page">

    <a href="{{ route('admin.dashboard') }}" class="ptm-page__back">
        <svg viewBox="0 0 24 24" fill="none">
            <path d="M15 6l-6 6 6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Back to Dashboard
    </a>

    <div class="ptm-page__head">
        <div>
            <h1>Partner Management</h1>
            <p>Manage institutional partners and international cooperation agreements.</p>
        </div>

        <a href="{{ route('admin.partner-management.create') }}" class="ptm-page__btn">
            <svg viewBox="0 0 24 24" fill="none">
                <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
            </svg>
            Add Partner
        </a>
    </div>

    {{-- FILTERS --}}
    <form method="GET" action="{{ route('admin.partner-management') }}" class="ptm-filters">
        <div class="ptm-filters__top">
            <div class="ptm-filters__search">
                <svg viewBox="0 0 24 24" fill="none">
                    <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/>
                    <path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Search partners...">
            </div>

            <a href="{{ route('admin.partner-management') }}" class="ptm-filters__reset">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M3 12a9 9 0 1 1 3 6.7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                    <path d="M3 8v5h5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Reset Filters
            </a>

            <button type="button" class="ptm-filters__export" onclick="window.print()">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M12 3v12m0 0l-4-4m4 4l4-4M5 21h14" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Export
            </button>
        </div>

        <div class="ptm-filters__row">
            <label class="ptm-filters__field">
                <span>Country / Region</span>
                <select name="country" class="ptm-filters__select">
                    <option value="">All Countries</option>
                    @foreach(($countries ?? []) as $country)
                        <option value="{{ $country }}" @selected(request('country') == $country)>{{ $country }}</option>
                    @endforeach
                </select>
            </label>

            <label class="ptm-filters__field">
                <span>Type of Institution</span>
                <select name="establishmentType" class="ptm-filters__select">
                    <option value="">All Types</option>
                    @foreach(($establishmentTypes ?? []) as $type)
                        <option value="{{ $type }}" @selected(request('establishmentType') == $type)>{{ $type }}</option>
                    @endforeach
                </select>
            </label>

            <label class="ptm-filters__field">
                <span>Domain of Cooperation</span>
                <select name="domain" class="ptm-filters__select">
                    <option value="">All Domains</option>
                    @foreach(($domains ?? []) as $domain)
                        @php
                            $domainValue = is_object($domain) ? ($domain->areaName ?? '') : $domain;
                        @endphp
                        @if($domainValue !== '')
                            <option value="{{ $domainValue }}" @selected(request('domain') == $domainValue)>{{ $domainValue }}</option>
                        @endif
                    @endforeach
                </select>
            </label>

            <label class="ptm-filters__field">
                <span>Partnership Type</span>
                <select name="partnershipType" class="ptm-filters__select">
                    <option value="">All Types</option>
                    @foreach(($partnershipTypes ?? []) as $type)
                        <option value="{{ $type }}" @selected(request('partnershipType') == $type)>{{ $type }}</option>
                    @endforeach
                </select>
            </label>

            <label class="ptm-filters__field">
                <span>Partnership Status</span>
                <select name="partnershipStatus" class="ptm-filters__select">
                    <option value="">All Statuses</option>
                    @foreach(($partnershipStatuses ?? []) as $status)
                        <option value="{{ $status }}" @selected(request('partnershipStatus') == $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </label>
        </div>

        <div class="ptm-filters__actions">
            <button type="submit" class="ptm-page__btn">Apply Filters</button>
        </div>
    </form>

    {{-- TOOLBAR --}}
    <div class="ptm-toolbar">
        <span class="ptm-toolbar__count">{{ $partners->total() ?? $partners->count() }} Partners found</span>

        <div class="ptm-toolbar__right">
            <form method="GET" action="{{ route('admin.partner-management') }}" class="ptm-toolbar__sort">
                <input type="hidden" name="search" value="{{ request('search') }}">
                <input type="hidden" name="country" value="{{ request('country') }}">
                <input type="hidden" name="establishmentType" value="{{ request('establishmentType') }}">
                <input type="hidden" name="domain" value="{{ request('domain') }}">
                <input type="hidden" name="partnershipType" value="{{ request('partnershipType') }}">
                <input type="hidden" name="partnershipStatus" value="{{ request('partnershipStatus') }}">

                <span>Sort by:</span>
                <select name="sort" class="ptm-toolbar__select" onchange="this.form.submit()">
                    <option value="name_asc" @selected(request('sort', 'name_asc') === 'name_asc')>Name A-Z</option>
                    <option value="name_desc" @selected(request('sort') === 'name_desc')>Name Z-A</option>
                    <option value="status" @selected(request('sort') === 'status')>Status</option>
                </select>
            </form>
        </div>
    </div>

    {{-- TABLE --}}
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
                @forelse($partners as $partner)
                    <tr>
                        <td>
                            <div class="ptm-table__partner">
                                @if(!empty($partner->logo))
                                    <img src="{{ asset($partner->logo) }}" alt="{{ $partner->partnerName ?? 'Partner' }}" class="ptm-table__logo">
                                @else
                                    <div class="ptm-table__logo ptm-table__logo--placeholder">
                                        {{ strtoupper(substr($partner->partnerName ?? 'P', 0, 1)) }}
                                    </div>
                                @endif

                                <div>
                                    <strong>{{ $partner->partnerName ?? 'Unnamed Partner' }}</strong>
                                    <span>{{ $partner->presentation ?? '' }}</span>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="ptm-table__location">
                                <div>
                                    <strong>{{ $partner->countryName ?? 'Unknown country' }}</strong>
                                    <span>{{ $partner->city ?? '—' }}</span>
                                </div>
                            </div>
                        </td>

                        <td>{{ $partner->establishmentType ?? '—' }}</td>

                        <td>
                            @if(!empty($partner->domains))
                                @php
                                    $partnerDomains = is_string($partner->domains) ? explode(',', $partner->domains) : [];
                                @endphp
                                @foreach($partnerDomains as $domain)
                                    <span class="ptm-table__tag">{{ trim($domain) }}</span>
                                @endforeach
                            @else
                                <span>—</span>
                            @endif
                        </td>

                        <td>{{ $partner->partnershipType ?? '—' }}</td>

                        <td>
                            @php
                                $status = $partner->partnershipStatus ?? 'Unknown';
                                $statusClass = \Illuminate\Support\Str::slug($status);
                            @endphp
                            <span class="ptm-table__status ptm-table__status--{{ $statusClass }}">{{ ucfirst($status) }}</span>
                        </td>

                        <td>
                            <div class="ptm-table__actions">
                                {{-- VIEW --}}
                                @if(Route::has('admin.partner-management.show'))
                                    <a href="{{ route('admin.partner-management.show', $partner->partnerID) }}" aria-label="View partner" title="View">
                                        <svg viewBox="0 0 24 24" fill="none">
                                            <path d="M1.5 12S5 5 12 5s10.5 7 10.5 7-3.5 7-10.5 7-10.5-7-10.5-7Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                                            <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.6"/>
                                        </svg>
                                    </a>
                                @endif

                                {{-- DELETE --}}
                                @if(Route::has('admin.partner-management.destroy'))
                                    <form method="POST" action="{{ route('admin.partner-management.destroy', $partner->partnerID) }}" onsubmit="return confirm('Are you sure you want to delete this partner?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" aria-label="Delete partner" title="Delete">
                                            <svg viewBox="0 0 24 24" fill="none">
                                                <path d="M4 7h16" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                                                <path d="M9 7V4h6v3" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                                                <path d="M7 7l1 13h8l1-13" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="ptm-table__empty">
                            <div>
                                <strong>No partners found</strong>
                                <span>Try changing your filters or add a new partner.</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if(method_exists($partners, 'links'))
            <div class="ptm-pagination">
                <div class="ptm-pagination__info">
                    Showing {{ $partners->firstItem() ?? 0 }} to {{ $partners->lastItem() ?? 0 }} of {{ $partners->total() }} partners
                </div>
                <div class="ptm-pagination__buttons">
                    {{ $partners->withQueryString()->links() }}
                </div>
            </div>
        @else
            <div class="ptm-pagination">
                <span>Showing {{ $partners->count() }} partners</span>
            </div>
        @endif
    </div>

</div>

@endsection