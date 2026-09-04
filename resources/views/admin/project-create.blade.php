@extends('layouts.admin')
@section('title', 'New Project')
@section('content')
<div class="pm-page">
    <a href="{{ route('admin.projects') }}" class="pm-page__back">← {{ __('Back to Projects') }}</a>
    <div class="pm-page__head"><div><h1>{{ __('New Project') }}</h1><p>{{ __('Create a project and its first translation.') }}</p></div></div>
    @if($errors->any())<div class="alert alert--error"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <form method="POST" action="{{ route('admin.projects.store') }}" class="admin-form">
        @csrf
        <div class="form-grid">
            <label>{{ __('Title') }}<input name="translation[title]" value="{{ old('translation.title') }}" required></label>
            <label>{{ __('Acronym') }}<input name="acronym" value="{{ old('acronym') }}"></label>
            <label>{{ __('Project reference') }}<input name="projectReference" value="{{ old('projectReference') }}"></label>
            <label>{{ __('Coordinator') }}<input name="coordinator" value="{{ old('coordinator') }}" required></label>
            <label>{{ __('School role') }}<input name="schoolRole" value="{{ old('schoolRole') }}" required></label>
            <label>{{ __('Programme') }}<select name="programID"><option value="">{{ __('— None —') }}</option>@foreach($programmes as $p)<option value="{{ $p->programID }}">{{ $p->translation()?->programName ?? __('Programme #').$p->programID }}</option>@endforeach</select></label>
            <label>{{ __('Country') }}<select name="countryCode" required><option value="">{{ __('Select country') }}</option>@foreach($countries as $c)<option value="{{ $c->countryCode }}">{{ $c->translation()?->countryName ?? $c->countryCode }}</option>@endforeach</select></label>
            <label>{{ __('Status') }}<select name="projectStatus" required><option value="proposed">{{ __('Proposed') }}</option><option value="ongoing">{{ __('Ongoing') }}</option><option value="completed">{{ __('Completed') }}</option></select></label>
            <label>{{ __('Start date') }}<input type="date" name="startDate" value="{{ old('startDate') }}" required></label>
            <label>{{ __('End date') }}<input type="date" name="endDate" value="{{ old('endDate') }}" required></label>
            <label>{{ __('Budget') }}<input type="number" step="0.01" min="0" name="budget" value="{{ old('budget') }}"></label>
            <label>{{ __('Website') }}<input type="url" name="website" value="{{ old('website') }}"></label>
            <label>{{ __('Publication') }}<select name="publicationStatus"><option value="draft">{{ __('Draft') }}</option><option value="scheduled">{{ __('Scheduled') }}</option><option value="published">{{ __('Published') }}</option><option value="archived">{{ __('Archived') }}</option></select></label>
            <label>{{ __('Featured') }}<select name="featured"><option value="0">{{ __('No') }}</option><option value="1">{{ __('Yes') }}</option></select></label>
        </div>
        <label>{{ __('Abstract') }}<textarea name="translation[abstract]">{{ old('translation.abstract') }}</textarea></label>
        <label>{{ __('Objectives') }}<textarea name="translation[objectives]">{{ old('translation.objectives') }}</textarea></label>
        <label>{{ __('Target groups') }}<textarea name="translation[targetGroups]">{{ old('translation.targetGroups') }}</textarea></label>
        <label>{{ __('Key results') }}<textarea name="translation[keyResults]">{{ old('translation.keyResults') }}</textarea></label>
        <label>{{ __('Public deliverables') }}<textarea name="translation[publicDeliverables]">{{ old('translation.publicDeliverables') }}</textarea></label>
        <label>{{ __('Publications') }}<textarea name="translation[publications]">{{ old('translation.publications') }}</textarea></label>
        <button class="pm-page__btn" type="submit">{{ __('Create Project') }}</button>
    </form>
</div>
@endsection