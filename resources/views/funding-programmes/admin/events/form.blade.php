@php
    $translation = $event?->translations->firstWhere('languageCode', app()->getLocale())
        ?? $event?->translations->firstWhere('languageCode', 'en');
@endphp

@if($errors->any())
<div class="card" style="margin-bottom:20px;"><div class="card__body">
    <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
</div></div>
@endif

<form method="POST" action="{{ $action }}" class="card">
    @csrf
    @if($method !== 'POST') @method($method) @endif
    <div class="card__body" style="display:grid;gap:16px;">
        <label>Title *
            <input name="translation[title]" value="{{ old('translation.title', $translation?->title) }}" required>
        </label>
        <label>Description
            <textarea name="translation[description]" rows="7">{{ old('translation.description', $translation?->description) }}</textarea>
        </label>
        <label>Event type
            <input name="eventType" value="{{ old('eventType', $event?->eventType) }}">
        </label>
        <label>Start date/time *
            <input type="datetime-local" name="startDate" value="{{ old('startDate', $event?->startDate?->format('Y-m-d\\TH:i')) }}" required>
        </label>
        <label>End date/time
            <input type="datetime-local" name="endDate" value="{{ old('endDate', $event?->endDate?->format('Y-m-d\\TH:i')) }}">
        </label>
        <label>Location
            <input name="location" value="{{ old('location', $event?->location) }}">
        </label>
        <label>Related project
            <select name="projectID">
                <option value="">None</option>
                @foreach($projects as $project)
                    <option value="{{ $project->projectID }}" @selected((string) old('projectID', $event?->projectID) === (string) $project->projectID)>
                        {{ $project->acronym ?: 'Project #'.$project->projectID }}
                    </option>
                @endforeach
            </select>
        </label>
        <label>Publication status
            <select name="publicationStatus" required>
                @foreach(['draft','published','archived'] as $status)
                    <option value="{{ $status }}" @selected(old('publicationStatus', $event?->publicationStatus ?? 'draft') === $status)>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </label>
        <label>Published at
            <input type="datetime-local" name="publishedAt" value="{{ old('publishedAt', $event?->publishedAt?->format('Y-m-d\\TH:i')) }}">
        </label>
        <label>Scheduled at
            <input type="datetime-local" name="scheduledAt" value="{{ old('scheduledAt', $event?->scheduledAt?->format('Y-m-d\\TH:i')) }}">
        </label>
        <div>
            <button class="btn btn--primary" type="submit">Save event</button>
            <a class="btn" href="{{ route('admin.events') }}">Cancel</a>
        </div>
    </div>
</form>
