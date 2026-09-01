@extends('layouts.admin')

@section('title', __('Opportunities'))
@php($active = 'opportunities')

@section('content')
<div class="section__header section__header--row" style="margin-bottom:20px;">
    <div>
        <h2 style="margin:0;">{{ __('Opportunities') }}</h2>
        <p style="margin:5px 0 0;">{{ __('Browse published funding calls and mobility opportunities.') }}</p>
    </div>
</div>

<div class="opportunities-tabs" style="margin-bottom:20px;">
    <a href="{{ url('/admin/opportunities') }}" class="opportunities-tabs__btn is-active">{{ __('Calls for Proposals') }}</a>
    <a href="{{ url('/admin/mobility') }}" class="opportunities-tabs__btn">{{ __('Mobility Opportunities') }}</a>
</div>

<form method="GET" action="{{ url('/admin/opportunities') }}" class="filter-bar" style="margin-bottom:20px;align-items:end;">
    <div class="filter-bar__search">
        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
        <input type="search" name="search" value="{{ $search }}" placeholder="{{ __('Search opportunities...') }}">
    </div>

    <select class="form-control" name="programID">
        <option value="">{{ __('All programmes') }}</option>
        @foreach($programmes as $programme)
            <option value="{{ $programme->programID }}" @selected((string)$programID === (string)$programme->programID)>
                {{ $programme->translation()?->programName ?? __('Unnamed programme') }}
            </option>
        @endforeach
    </select>

    <select class="form-control" name="status">
        <option value="">{{ __('All statuses') }}</option>
        @foreach($statuses as $value => $label)
            <option value="{{ $value }}" @selected($status === $value)>{{ __($label) }}</option>
        @endforeach
    </select>

    <select class="form-control" name="deadline">
        <option value="">{{ __('Any deadline') }}</option>
        <option value="7" @selected($deadline === '7')>{{ __('Next 7 days') }}</option>
        <option value="30" @selected($deadline === '30')>{{ __('Next 30 days') }}</option>
        <option value="open" @selected($deadline === 'open')>{{ __('Still open') }}</option>
    </select>

    <button class="btn btn--primary btn--sm" type="submit">{{ __('Apply Filters') }}</button>
    <a class="btn btn--outline btn--sm" href="{{ url('/admin/opportunities') }}">{{ __('Reset') }}</a>
</form>

<div class="data-table-wrap">
    <table class="data-table">
        <thead><tr><th>{{ __('Opportunity') }}</th><th>{{ __('Programme') }}</th><th>{{ __('Status') }}</th><th>{{ __('Deadline') }}</th><th></th></tr></thead>
        <tbody>
        @forelse($calls as $call)
            <tr>
                <td>
                    <strong>{{ $call['title'] }}</strong>
                    @if($call['audience'] !== '—')<div style="font-size:12px;margin-top:4px;">{{ $call['audience'] }}</div>@endif
                </td>
                <td>{{ $call['tag'] }}</td>
                <td><span class="badge">{{ $call['status'] }}</span></td>
                <td>{{ $call['deadline'] ?? '—' }}</td>
                <td class="data-table__actions">
                    <a href="{{ route('admin.call-details', $call['id']) }}" aria-label="{{ __('View details') }}">{{ __('View') }}</a>
                    @if($call['officialLink'])
                        <a href="{{ $call['officialLink'] }}" target="_blank" rel="noopener noreferrer">{{ __('Official link') }}</a>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="5">{{ __('No opportunities match your filters.') }}</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

@if($calls->hasPages())
<div style="margin-top:20px;">{{ $calls->links() }}</div>
@endif
@endsection
