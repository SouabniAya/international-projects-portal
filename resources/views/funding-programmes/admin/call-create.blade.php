@extends('layouts.admin')
@section('title','New Call for Proposals')
@section('content')
<div class="pm-page"><a href="{{ route('admin.calls') }}" class="pm-page__back">← Back to Calls</a><div class="pm-page__head"><div><h1>New Call for Proposals</h1><p>Create a funding opportunity.</p></div></div>
@if($errors->any())<div class="alert alert--error"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
<form method="POST" action="{{ route('admin.calls.store') }}" class="admin-form">@csrf
<div class="form-grid">
<label>Title<input name="translation[title]" required value="{{ old('translation.title') }}"></label>
<label>Programme<select name="programID" required><option value="">Select</option>@foreach($programmes as $p)<option value="{{ $p->programID }}">{{ $p->translation()?->programName ?? 'Programme #'.$p->programID }}</option>@endforeach</select></label>
<label>Financing organism<input name="financingOrganism" value="{{ old('financingOrganism') }}"></label><label>Action type<input name="actionType" value="{{ old('actionType') }}"></label>
<label>Funding type<input name="fundingType" value="{{ old('fundingType') }}"></label><label>Budget<input type="number" step="0.01" min="0" name="budget" value="{{ old('budget') }}"></label>
<label>Financing rate<input name="financingRate" value="{{ old('financingRate') }}"></label><label>Contact<input name="contact" value="{{ old('contact') }}"></label>
<label>Opening date<input type="date" name="openingDate" required value="{{ old('openingDate') }}"></label><label>Deadline<input type="date" name="deadline" required value="{{ old('deadline') }}"></label>
<label>Official source<input type="url" name="linkToOfficialSource" value="{{ old('linkToOfficialSource') }}"></label>
<label>Status<select name="status" required><option value="upcoming">Upcoming</option><option value="open">Open</option><option value="closing_soon">Closing soon</option><option value="closed">Closed</option></select></label>
<label>Publication<select name="publicationStatus"><option value="draft">Draft</option><option value="published">Published</option><option value="scheduled">Scheduled</option><option value="archived">Archived</option></select></label>
</div>
<label>Description<textarea name="translation[description]"></textarea></label><label>Objectives<textarea name="translation[objectives]"></textarea></label><label>Eligible beneficiaries<textarea name="translation[eligibleBeneficiaries]"></textarea></label>
<button class="pm-page__btn" type="submit">Create Call</button></form></div>
@endsection
