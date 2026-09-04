@php
    $translation = $news?->translations->firstWhere('languageCode', app()->getLocale())
        ?? $news?->translations->firstWhere('languageCode', 'en');
@endphp

@if($errors->any())
<div class="card" style="margin-bottom:20px;"><div class="card__body">
    <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
</div></div>
@endif

<form method="POST" action="{{ $action }}" class="card" enctype="multipart/form-data">
    @csrf
    @if($method !== 'POST') @method($method) @endif
    <div class="card__body">

        <div class="form-group">
            <label class="form-label" for="newsTitle">{{ __('Title') }} *</label>
            <input class="form-control" id="newsTitle" name="translation[title]"
                   value="{{ old('translation.title', $translation?->title) }}" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="newsContent">{{ __('Content') }}</label>
            <textarea class="form-control" id="newsContent" name="translation[content]" rows="9">{{ old('translation.content', $translation?->content) }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label">{{ __('Image') }}</label>

            @if($news?->image)
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:10px;">
                    <img src="{{ asset($news->image) }}" alt="{{ __('Current image') }}"
                         style="width:96px; height:64px; object-fit:cover; border-radius:8px; border:1px solid var(--color-neutral-300);">
                    <span class="form-hint" style="margin-top:0;">{{ __('Current image — upload a file below to replace it.') }}</span>
                </div>
            @endif

            <input class="form-control" type="file" name="image_upload" accept="image/*">
            @error('image_upload')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="newsPublicationDate">{{ __('Publication date') }} *</label>
                <input class="form-control" type="date" id="newsPublicationDate" name="publicationDate"
                       value="{{ old('publicationDate', $news?->publicationDate?->format('Y-m-d')) }}" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="newsProject">{{ __('Related project') }}</label>
                <select class="form-control" id="newsProject" name="projectID">
                    <option value="">{{ __('None') }}</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->projectID }}" @selected((string) old('projectID', $news?->projectID) === (string) $project->projectID)>
                            {{ $project->acronym ?: __('Project #').$project->projectID }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="newsStatus">{{ __('Publication status') }}</label>
                <select class="form-control" id="newsStatus" name="publicationStatus" required>
                    @foreach(['draft','published','archived'] as $status)
                        <option value="{{ $status }}" @selected(old('publicationStatus', $news?->publicationStatus ?? 'draft') === $status)>{{ __(ucfirst($status)) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="newsPublishedAt">{{ __('Published at') }}</label>
                <input class="form-control" type="datetime-local" id="newsPublishedAt" name="publishedAt"
                       value="{{ old('publishedAt', $news?->publishedAt?->format('Y-m-d\\TH:i')) }}">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="newsScheduledAt">{{ __('Scheduled at') }}</label>
            <input class="form-control" type="datetime-local" id="newsScheduledAt" name="scheduledAt"
                   value="{{ old('scheduledAt', $news?->scheduledAt?->format('Y-m-d\\TH:i')) }}"
                   style="max-width: 260px;">
        </div>

        <div style="margin-top:8px;">
            <button class="btn btn--primary" type="submit">{{ __('Save news') }}</button>
            <a class="btn btn--outline" href="{{ route('admin.news') }}">{{ __('Cancel') }}</a>
        </div>
    </div>
</form>