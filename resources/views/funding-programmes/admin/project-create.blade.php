@extends('layouts.admin')
@section('title', 'New Project')
@section('content')
<div class="pm-page">
    <a href="{{ route('admin.projects') }}" class="pm-page__back">← Back to Projects</a>
    <div class="pm-page__head"><div><h1>New Project</h1><p>Create a project and its first translation.</p></div></div>
    @if($errors->any())<div class="alert alert--error"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <form method="POST" action="{{ route('admin.projects.store') }}" class="admin-form">
        @csrf
        <div class="form-grid">
            <label>Title<input name="translation[title]" value="{{ old('translation.title') }}" required></label>
            <label>Acronym<input name="acronym" value="{{ old('acronym') }}"></label>
            <label>Project reference<input name="projectReference" value="{{ old('projectReference') }}"></label>
            <label>Coordinator<input name="coordinator" value="{{ old('coordinator') }}" required></label>
            <label>School role<input name="schoolRole" value="{{ old('schoolRole') }}" required></label>
            <label>Programme<select name="programID"><option value="">— None —</option>@foreach($programmes as $p)<option value="{{ $p->programID }}">{{ $p->translation()?->programName ?? 'Programme #'.$p->programID }}</option>@endforeach</select></label>
            <label>Country<select name="countryCode" required><option value="">Select country</option>@foreach($countries as $c)<option value="{{ $c->countryCode }}">{{ $c->translation()?->countryName ?? $c->countryCode }}</option>@endforeach</select></label>
            <label>Status<select name="projectStatus" required><option value="proposed">Proposed</option><option value="ongoing">Ongoing</option><option value="completed">Completed</option></select></label>
            <label>Start date<input type="date" name="startDate" value="{{ old('startDate') }}" required></label>
            <label>End date<input type="date" name="endDate" value="{{ old('endDate') }}" required></label>
            <label>Budget<input type="number" step="0.01" min="0" name="budget" value="{{ old('budget') }}"></label>
            <label>Website<input type="url" name="website" value="{{ old('website') }}"></label>
            <label>Publication<select name="publicationStatus"><option value="draft">Draft</option><option value="scheduled">Scheduled</option><option value="published">Published</option><option value="archived">Archived</option></select></label>
            <label>Featured<select name="featured"><option value="0">No</option><option value="1">Yes</option></select></label>
        </div>
        <label>Abstract<textarea name="translation[abstract]">{{ old('translation.abstract') }}</textarea></label>
        <label>Objectives<textarea name="translation[objectives]">{{ old('translation.objectives') }}</textarea></label>
        <label>Target groups<textarea name="translation[targetGroups]">{{ old('translation.targetGroups') }}</textarea></label>
        <label>Key results<textarea name="translation[keyResults]">{{ old('translation.keyResults') }}</textarea></label>
        <label>Public deliverables<textarea name="translation[publicDeliverables]">{{ old('translation.publicDeliverables') }}</textarea></label>
        <label>Publications<textarea name="translation[publications]">{{ old('translation.publications') }}</textarea></label>
        <button class="pm-page__btn" type="submit">Create Project</button>
    </form>
</div>
@endsection
