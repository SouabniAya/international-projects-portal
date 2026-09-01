@extends('layouts.admin')

@section('title', 'Events')
@php($active = 'events')

@section('content')
<div class="section__header section__header--row" style="margin-bottom:18px;">
    <div>
        <h2 style="margin:0;">Events Management</h2>
        <p style="margin:4px 0 0;">Manage published, scheduled, and draft international events.</p>
    </div>
    <a href="{{ route('admin.events.create') }}" class="btn btn--primary btn--sm">+ New Event</a>
</div>

@if(session('success'))
    <div class="alert alert--success" style="margin-bottom:18px;">{{ session('success') }}</div>
@endif

<form method="GET" action="{{ route('admin.events') }}" class="filter-bar" style="margin-bottom:20px;">
    <div class="filter-bar__search">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/>
            <path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
        <input type="search" name="search" value="{{ request('search') }}" placeholder="Search title, type or location...">
    </div>
    <button type="submit" class="btn btn--secondary btn--sm">Apply</button>
</form>

<div class="card">
    <div class="card__body" style="padding:0; overflow-x:auto;">
        <table class="data-table" style="width:100%;">
            <thead>
                <tr>
                    <th>Event</th>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($events as $event)
                @php($title = $event->translation(app()->getLocale())?->title ?? $event->translation('en')?->title ?? 'Untitled event')
                <tr>
                    <td><strong>{{ $title }}</strong></td>
                    <td>{{ $event->eventType ?: '—' }}</td>
                    <td>{{ $event->startDate?->format('d M Y H:i') ?: '—' }}</td>
                    <td>{{ $event->location ?: '—' }}</td>
                    <td>{{ ucfirst($event->publicationStatus) }}</td>
                    <td style="white-space:nowrap;">
                        <a href="{{ route('admin.events.show', $event->eventID) }}" class="btn btn--outline btn--sm">View</a>
                        <a href="{{ route('admin.events.edit', $event->eventID) }}" class="btn btn--outline btn--sm">Edit</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="padding:30px; text-align:center; color:var(--color-neutral-500);">No events found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($events->hasPages())
        <div style="margin-top:18px;">{{ $events->links() }}</div>
    @endif
</div>
@endsection
