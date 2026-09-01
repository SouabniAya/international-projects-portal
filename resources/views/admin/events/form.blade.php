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
    <div class="card__body">

        <div class="form-group">
            <label class="form-label" for="eventTitle">Title *</label>
            <input class="form-control" id="eventTitle" name="translation[title]"
                   value="{{ old('translation.title', $translation?->title) }}" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="eventDescription">Description</label>
            <textarea class="form-control" id="eventDescription" name="translation[description]" rows="7">{{ old('translation.description', $translation?->description) }}</textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="eventType">Event type</label>
                <input class="form-control" id="eventType" name="eventType"
                       value="{{ old('eventType', $event?->eventType) }}">
            </div>

            <div class="form-group">
                <label class="form-label" for="eventLocation">Location</label>
                <input class="form-control" id="eventLocation" name="location"
                       value="{{ old('location', $event?->location) }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="eventStartDate">Start date/time *</label>
                <input class="form-control" type="datetime-local" id="eventStartDate" name="startDate"
                       value="{{ old('startDate', $event?->startDate?->format('Y-m-d\\TH:i')) }}" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="eventEndDate">End date/time</label>
                <input class="form-control" type="datetime-local" id="eventEndDate" name="endDate"
                       value="{{ old('endDate', $event?->endDate?->format('Y-m-d\\TH:i')) }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="eventProject">Related project</label>
                <select class="form-control" id="eventProject" name="projectID">
                    <option value="">None</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->projectID }}" @selected((string) old('projectID', $event?->projectID) === (string) $project->projectID)>
                            {{ $project->acronym ?: 'Project #'.$project->projectID }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="eventStatus">Publication status</label>
                <select class="form-control" id="eventStatus" name="publicationStatus" required>
                    @foreach(['draft','published','archived'] as $status)
                        <option value="{{ $status }}" @selected(old('publicationStatus', $event?->publicationStatus ?? 'draft') === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="eventPublishedAt">Published at</label>
                <input class="form-control" type="datetime-local" id="eventPublishedAt" name="publishedAt"
                       value="{{ old('publishedAt', $event?->publishedAt?->format('Y-m-d\\TH:i')) }}">
            </div>

            <div class="form-group">
                <label class="form-label" for="eventScheduledAt">Scheduled at</label>
                <input class="form-control" type="datetime-local" id="eventScheduledAt" name="scheduledAt"
                       value="{{ old('scheduledAt', $event?->scheduledAt?->format('Y-m-d\\TH:i')) }}">
            </div>
        </div>

        <div style="margin-top:8px;">
            <button class="btn btn--primary" type="submit">Save event</button>
            <a class="btn btn--outline" href="{{ route('admin.events') }}">Cancel</a>
        </div>
    </div>
</form>