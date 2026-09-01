@extends('layouts.admin')
@section('title','New Mobility Opportunity')
@section('content')
<div class="pm-page"><a href="{{ route('admin.mobility') }}" class="pm-page__back">← Back to Mobility</a><div class="pm-page__head"><div><h1>New Mobility Opportunity</h1><p>Create a mobility opportunity.</p></div></div>
@if($errors->any())<div class="alert alert--error"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
<form method="POST" action="{{ route('admin.mobility.store') }}" class="admin-form">@csrf
<div class="form-grid">
<label>Mobility type<select name="mobilityType" required>@foreach(['outgoing_student'=>'Outgoing student','incoming_student'=>'Incoming student','staff'=>'Staff','researcher'=>'Researcher','internship'=>'Internship','summer_school'=>'Summer school','scientific_stay'=>'Scientific stay','scholarship'=>'Scholarship'] as $k=>$v)<option value="{{ $k }}">{{ $v }}</option>@endforeach</select></label>
<label>Programme<select name="programID"><option value="">— None —</option>@foreach($programmes as $p)<option value="{{ $p->programID }}">{{ $p->translation()?->programName ?? 'Programme #'.$p->programID }}</option>@endforeach</select></label>
<label>Hosting establishment<input name="hostingEstablishment"></label><label>City<input name="city"></label><label>Target audience<input name="targetAudience"></label><label>Places available<input type="number" min="0" name="placesAvailable" required></label>
<label>Start date<input type="date" name="startDate" required></label><label>End date<input type="date" name="endDate" required></label><label>Application deadline<input type="date" name="applicationDeadline" required></label>
<label>Language skills<input name="requiredLanguageSkills"></label><label>Funding available<input name="fundingAvailable"></label><label>Contact<input name="contact" required></label><label>Application link<input type="url" name="applicationLink" required></label>
<label>Publication<select name="publicationStatus"><option value="draft">Draft</option><option value="published">Published</option><option value="scheduled">Scheduled</option><option value="archived">Archived</option></select></label>
</div><label>Title<input name="translation[title]" required></label><label>Conditions<textarea name="translation[conditions]"></textarea></label><label>Application process<textarea name="translation[applicationProcess]" required></textarea></label><label>Selection criteria<textarea name="translation[selectionCriteria]"></textarea></label>
<button class="pm-page__btn" type="submit">Create Mobility</button></form></div>
@endsection
