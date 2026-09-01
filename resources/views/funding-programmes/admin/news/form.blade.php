@php
    $translation = $news?->translations->firstWhere('languageCode', app()->getLocale())
        ?? $news?->translations->firstWhere('languageCode', 'en');
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

        <label>Content
            <textarea name="translation[content]" rows="9">{{ old('translation.content', $translation?->content) }}</textarea>
        </label>

        <label>Image URL
            <input name="image" value="{{ old('image', $news?->image) }}">
        </label>

        <label>Publication date *
            <input type="date" name="publicationDate" value="{{ old('publicationDate', $news?->publicationDate?->format('Y-m-d')) }}" required>
        </label>

        <label>Related project
            <select name="projectID">
                <option value="">None</option>
                @foreach($projects as $project)
                    <option value="{{ $project->projectID }}" @selected((string) old('projectID', $news?->projectID) === (string) $project->projectID)>
                        {{ $project->acronym ?: 'Project #'.$project->projectID }}
                    </option>
                @endforeach
            </select>
        </label>

        <label>Publication status
            <select name="publicationStatus" required>
                @foreach(['draft','published','archived'] as $status)
                    <option value="{{ $status }}" @selected(old('publicationStatus', $news?->publicationStatus ?? 'draft') === $status)>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </label>

        <label>Published at
            <input type="datetime-local" name="publishedAt" value="{{ old('publishedAt', $news?->publishedAt?->format('Y-m-d\\TH:i')) }}">
        </label>

        <label>Scheduled at
            <input type="datetime-local" name="scheduledAt" value="{{ old('scheduledAt', $news?->scheduledAt?->format('Y-m-d\\TH:i')) }}">
        </label>

        <div>
            <button class="btn btn--primary" type="submit">Save news</button>
            <a class="btn btn--outline" href="{{ route('admin.news') }}">Cancel</a>
        </div>
    </div>
</form>
