@extends('layouts.admin')

@section('title', __('Event Registrations'))
@php($active = 'event-registrations')

@section('content')
<div class="section__header section__header--row" style="margin-bottom:18px;">
    <div>
        <h1 style="margin:0;">{{ __('Event Registrations') }}</h1>
        <p style="margin:4px 0 0;">{{ __('Review and manage registration requests submitted for events.') }}</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert--success" style="margin-bottom:18px;">{{ session('success') }}</div>
@endif

<form method="GET" action="{{ route('admin.event-registrations') }}" class="filter-bar" style="margin-bottom:20px;">
    <div class="filter-bar__search">
        <label class="sr-only" for="registrationSearch">{{ __('Search registrations') }}</label>
        <input id="registrationSearch" type="search" name="search" value="{{ request('search') }}" placeholder="{{ __('Search name, email or event...') }}">
    </div>
    <select class="form-control" name="status" aria-label="{{ __('Status') }}">
        <option value="">{{ __('All statuses') }}</option>
        @foreach(['pending','approved','rejected'] as $status)
            <option value="{{ $status }}" @selected(request('status') === $status)>{{ __(ucfirst($status)) }}</option>
        @endforeach
    </select>
    <button class="btn btn--secondary btn--sm" type="submit">{{ __('Apply') }}</button>
</form>

<div class="card">
    <div class="card__body" style="padding:0;overflow-x:auto;">
        <table class="data-table" style="width:100%;">
            <thead><tr><th>{{ __('Name') }}</th><th>{{ __('Email') }}</th><th>{{ __('Event') }}</th><th>{{ __('Date') }}</th><th>{{ __('Status') }}</th><th>{{ __('Actions') }}</th></tr></thead>
            <tbody>
            @forelse($registrations as $registration)
                @php($eventTitle = $registration->event?->translation(app()->getLocale())?->title ?? $registration->event?->translation('en')?->title ?? __('Event'))
                <tr>
                    <td>{{ $registration->fullName }}</td>
                    <td>{{ $registration->email }}</td>
                    <td>{{ $eventTitle }}</td>
                    <td>{{ $registration->submissionDate?->format('d M Y H:i') }}</td>
                    <td>{{ __(ucfirst($registration->status)) }}</td>
                    <td style="white-space:nowrap;">
                        @if($registration->status !== 'approved')
                            <form method="POST" action="{{ route('admin.event-registrations.status', $registration->registrationID) }}" style="display:inline;">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="approved">
                                <button class="btn btn--outline btn--sm" type="submit">{{ __('Approve') }}</button>
                            </form>
                        @endif
                        @if($registration->status !== 'rejected')
                            <form method="POST" action="{{ route('admin.event-registrations.status', $registration->registrationID) }}" style="display:inline;">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="rejected">
                                <button class="btn btn--outline btn--sm" type="submit">{{ __('Reject') }}</button>
                            </form>
                        @endif
                        <form method="POST" action="{{ route('admin.event-registrations.destroy', $registration->registrationID) }}" style="display:inline;" onsubmit="return confirm('{{ __('Delete this registration?') }}')">
                            @csrf @method('DELETE')
                            <button class="btn btn--outline btn--sm" type="submit">{{ __('Delete') }}</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" style="padding:30px;text-align:center;">{{ __('No registrations found.') }}</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($registrations->hasPages())<div style="margin-top:18px;">{{ $registrations->links() }}</div>@endif
</div>
@endsection
