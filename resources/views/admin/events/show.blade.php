@extends('layouts.admin')
@php($active = 'events')
@section('title', 'Event Details')
@section('content')
@php($title = $event->translation(app()->getLocale())?->title ?? $event->translation('en')?->title ?? 'Untitled event')
<div class="section__header" style="display:flex;justify-content:space-between;align-items:center;gap:16px;">
    <div><h1>{{ $title }}</h1><p class="card__text">Event details</p></div>
    <div>
        <a class="btn" href="{{ route('admin.events.edit', $event->eventID) }}">Edit</a>
        <form method="POST" action="{{ route('admin.events.destroy', $event->eventID) }}" style="display:inline" onsubmit="return confirm('Delete this event?')">
            @csrf @method('DELETE')
            <button class="btn" type="submit">Delete</button>
        </form>
    </div>
</div>
@if(session('success'))<div class="card" style="margin:20px 0"><div class="card__body">{{ session('success') }}</div></div>@endif
<div class="two-col">
    <div class="card"><div class="card__body">
        <h2>Description</h2>
        <div>{!! nl2br(e($event->translation(app()->getLocale())?->description ?? $event->translation('en')?->description ?? '')) !!}</div>
    </div></div>
    <aside class="card"><div class="card__body">
        <p><strong>Type:</strong> {{ $event->eventType ?: '—' }}</p>
        <p><strong>Start:</strong> {{ $event->startDate?->format('d M Y H:i') ?: '—' }}</p>
        <p><strong>End:</strong> {{ $event->endDate?->format('d M Y H:i') ?: '—' }}</p>
        <p><strong>Location:</strong> {{ $event->location ?: '—' }}</p>
        <p><strong>Status:</strong> {{ ucfirst($event->publicationStatus) }}</p>
        @if($event->project)
            <p><strong>Project:</strong> {{ $event->project->acronym ?: '#'.$event->project->projectID }}</p>
        @endif
    </div></aside>
</div>
@endsection
