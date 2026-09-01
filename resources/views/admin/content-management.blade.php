@extends('layouts.admin')

@section('title', 'Content Management')

@php($active = 'cooperation')

@section('content')
<div class="section__header section__header--row" style="margin-bottom:8px;">
    <div>
        <h2 style="margin:0;">{{ __('Content Management') }}</h2>
        <p style="margin:4px 0 0;">
            {{ __('Search, filter and review content stored in the portal.') }}
        </p>
    </div>

    <a class="btn btn--primary btn--sm" href="{{ route('admin.content.create') }}">
        + {{ __('Publish Content') }}
    </a>
</div>

@if(session('success'))
    <div class="alert alert--success" style="margin-bottom:18px;">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert--error" style="margin-bottom:18px;">
        <ul style="margin:0;padding-left:20px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- Content type tabs — quick links into the real search/filter below.
     These were purely decorative (href="#") in the original design; wired
     here to the real $filters['type'] since the logic already supports it
     and it's a strict improvement over dead links, not a redesign. --}}
<div class="flex-row" style="margin-bottom:20px; border-bottom:1px solid var(--color-neutral-300); padding-bottom:12px; flex-wrap:wrap; gap:8px;">
    <a href="{{ route('admin.content-management', array_filter(['search' => $filters['search'] ?: null, 'status' => $filters['status'] !== 'all' ? $filters['status'] : null])) }}"
       class="btn {{ $filters['type'] === 'all' ? 'btn--primary' : 'btn--outline' }} btn--sm">
        {{ __('All') }}
    </a>
    @foreach($contentTypes as $contentType)
        <a href="{{ route('admin.content-management', array_filter(['type' => $contentType, 'search' => $filters['search'] ?: null, 'status' => $filters['status'] !== 'all' ? $filters['status'] : null])) }}"
           class="btn {{ $filters['type'] === $contentType ? 'btn--primary' : 'btn--outline' }} btn--sm">
            {{ __($contentType) }}
        </a>
    @endforeach
</div>

{{-- ================================================================ --}}
{{-- FILTER BAR --}}
{{-- ================================================================ --}}

<form method="GET" action="{{ route('admin.content-management') }}" class="filter-bar" style="margin-bottom:20px;">

    <div class="filter-bar__search">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/>
            <path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
        <label class="sr-only" for="contentSearch">{{ __('Search content') }}</label>
        <input
            id="contentSearch"
            type="search"
            name="search"
            value="{{ $filters['search'] }}"
            placeholder="{{ __('Search content...') }}"
        >
    </div>

    <select class="form-control" name="status" aria-label="{{ __('Status') }}" onchange="this.form.submit()">
        <option value="all" @selected($filters['status'] === 'all')>{{ __('All statuses') }}</option>
        <option value="approved" @selected($filters['status'] === 'approved')>{{ __('Published') }}</option>
        <option value="pending" @selected($filters['status'] === 'pending')>{{ __('Draft / Scheduled') }}</option>
        <option value="rejected" @selected($filters['status'] === 'rejected')>{{ __('Archived') }}</option>
    </select>

    <select class="form-control" name="type" aria-label="{{ __('Content type') }}" onchange="this.form.submit()">
        <option value="all" @selected($filters['type'] === 'all')>{{ __('All types') }}</option>
        @foreach($contentTypes as $contentType)
            <option value="{{ $contentType }}" @selected($filters['type'] === $contentType)>
                {{ __($contentType) }}
            </option>
        @endforeach
    </select>

    <button type="submit" class="btn btn--secondary btn--sm">{{ __('Apply') }}</button>

   <a class="btn btn--outline btn--sm"
   href="{{ route('admin.content-management.export', array_filter([
        'search' => $filters['search'] ?: null,
        'status' => $filters['status'] !== 'all' ? $filters['status'] : null,
        'type'   => $filters['type'] !== 'all' ? $filters['type'] : null,
   ])) }}">
    ⭳ {{ __('Export CSV') }}
</a>

    {{--
        Note: since results are now server-side paginated (10 per page),
        this client-side export only captures the currently visible page,
        not every matching row across all pages — a side effect of adding
        real pagination that didn't exist when this button was first built.
        Tell me if a full server-side export (like Projects/Calls/Mobility
        now have) is wanted here instead.
    --}}

    @if($filters['search'] !== '' || $filters['status'] !== 'all' || $filters['type'] !== 'all')
        <a class="btn btn--ghost btn--sm" href="{{ route('admin.content-management') }}">{{ __('Clear') }}</a>
    @endif

</form>

<div class="card">
    <div class="card__body" style="padding:0;">
        <div style="overflow-x:auto;">
            <table class="data-table" style="width:100%;">
                <thead>
                    <tr>
                        <th>{{ __('Content') }}</th>
                        <th>{{ __('Type') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Author') }}</th>
                        <th>{{ __('Date') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contentItems as $item)
                        <tr>
                            <td>
                                <strong>{{ $item['title'] }}</strong>
                            </td>
                            <td>{{ $item['type'] }}</td>
                            <td>
                                <span class="badge badge--{{ $item['status'] }}">{{ $item['label'] }}</span>
                            </td>
                            <td>{{ $item['author'] }}</td>
                            <td>{{ $item['date'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center;padding:36px;">
                                {{ __('No content matches your filters.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if($contentItems->hasPages())
    <div style="margin-top:18px;">
        {{ $contentItems->onEachSide(1)->links() }}
    </div>
@endif

<div class="card" style="margin-top:24px;">
    <div class="card__body">
        <h3 style="margin-top:0;">{{ __('Create content') }}</h3>
        <p style="margin:4px 0 18px;">
            {{ __('Use this page for editorial content. Projects, calls, mobility, agreements, programmes and partners keep their dedicated management pages.') }}
        </p>

        <div style="display:flex;gap:10px;flex-wrap:wrap;">
            <a class="btn btn--secondary btn--sm" href="{{ route('admin.projects') }}">{{ __('Projects') }}</a>
            <a class="btn btn--secondary btn--sm" href="{{ route('admin.calls') }}">{{ __('Calls') }}</a>
            <a class="btn btn--secondary btn--sm" href="{{ route('admin.mobility') }}">{{ __('Mobility') }}</a>
            <a class="btn btn--secondary btn--sm" href="{{ route('admin.agreements') }}">{{ __('Agreements') }}</a>
            <a class="btn btn--secondary btn--sm" href="{{ route('admin.funding-programmes') }}">{{ __('Funding programmes') }}</a>
            <a class="btn btn--secondary btn--sm" href="{{ route('admin.documents.create-options') }}">{{ __('Documents') }}</a>
        </div>
    </div>
</div>
@endsection