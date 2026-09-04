@extends('layouts.admin')
@php($active = 'events')
@section('title', 'Event Details')
@section('content')
@php($title = $event->translation(app()->getLocale())?->title ?? $event->translation('en')?->title ?? __('Untitled event'))
<div class="section__header" style="display:flex;justify-content:space-between;align-items:center;gap:16px;">
    <div><h1>{{ $title }}</h1><p class="card__text">{{ __('Event details') }}</p></div>
    <div>
        <a class="btn" href="{{ route('admin.events.edit', $event->eventID) }}">{{ __('Edit') }}</a>
        <form method="POST" action="{{ route('admin.events.destroy', $event->eventID) }}" style="display:inline" data-confirm-form>
            @csrf @method('DELETE')
            <button class="btn" type="submit" data-confirm="{{ __('Delete this event?') }}">{{ __('Delete') }}</button>
        </form>
    </div>
</div>
@if(session('success'))<div class="card" style="margin:20px 0"><div class="card__body">{{ session('success') }}</div></div>@endif
<div class="two-col">
    <div class="card"><div class="card__body">
        <h2>{{ __('Description') }}</h2>
        <div>{!! nl2br(e($event->translation(app()->getLocale())?->description ?? $event->translation('en')?->description ?? '')) !!}</div>
    </div></div>
    <aside class="card"><div class="card__body">
        <p><strong>{{ __('Type') }}:</strong> {{ $event->eventType ? __($event->eventType) : '—' }}</p>
        <p><strong>{{ __('Start') }}:</strong> {{ $event->startDate?->format('d M Y H:i') ?: '—' }}</p>
        <p><strong>{{ __('End') }}:</strong> {{ $event->endDate?->format('d M Y H:i') ?: '—' }}</p>
        <p><strong>{{ __('Location') }}:</strong> {{ $event->location ?: '—' }}</p>
        <p><strong>{{ __('Status') }}:</strong> {{ __(ucfirst($event->publicationStatus)) }}</p>
        @if($event->project)
            <p><strong>{{ __('Project') }}:</strong> {{ $event->project->acronym ?: '#'.$event->project->projectID }}</p>
        @endif
    </div></aside>
</div>

<script>
document.querySelectorAll('form[data-confirm-form]').forEach(function (form) {
    form.addEventListener('submit', function (e) {
        var btn = form.querySelector('[data-confirm]');
        var message = btn ? btn.getAttribute('data-confirm') : 'Are you sure?';
        if (!confirm(message)) e.preventDefault();
    });
});
</script>
@endsection