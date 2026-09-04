@extends('layouts.admin')

@section('title', __('Edit School Presentation'))
@php($active = 'cooperation')

@section('content')
<div class="section__header" style="margin-bottom:20px;">
    <h2 style="margin:0;">{{ __('Edit School Presentation') }}</h2>
    <p style="margin:6px 0 0;">{{ __('Update the public presentation and office information.') }}</p>
</div>

@if($errors->any())
    <div class="alert alert--error" style="margin-bottom:18px;">
        <ul style="margin:0; padding-left:20px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.school-presentation.update') }}" class="card">
    @csrf
    @method('PUT')

    <div class="card__body" style="display:grid; gap:18px;">
        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="language">{{ __('Language') }}</label>
                <select class="form-control" id="language" name="language" required>
                    @foreach(['en' => __('English'), 'fr' => __('French'), 'ar' => __('Arabic')] as $code => $label)
                        <option value="{{ $code }}" {{ old('language', $presentation?->translations->first()?->languageCode ?? $locale) == $code ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="description">{{ __('Description') }}</label>
            <textarea class="form-control" id="description" name="description" rows="5">{{ old('description', $presentation?->translations->firstWhere('languageCode', old('language', $locale))?->description ?? $presentation?->translations->first()?->description) }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label" for="vision">{{ __('Vision') }}</label>
            <textarea class="form-control" id="vision" name="vision" rows="4">{{ old('vision', $presentation?->translations->firstWhere('languageCode', old('language', $locale))?->vision ?? $presentation?->translations->first()?->vision) }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label" for="internationalizationStrategy">{{ __('Internationalization Strategy') }}</label>
            <textarea class="form-control" id="internationalizationStrategy" name="internationalizationStrategy" rows="4">{{ old('internationalizationStrategy', $presentation?->translations->firstWhere('languageCode', old('language', $locale))?->internationalizationStrategy ?? $presentation?->translations->first()?->internationalizationStrategy) }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label" for="missions">{{ __('Missions') }}</label>
            <textarea class="form-control" id="missions" name="missions" rows="4">{{ old('missions', $presentation?->translations->firstWhere('languageCode', old('language', $locale))?->missions ?? $presentation?->translations->first()?->missions) }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label" for="objectives">{{ __('Objectives') }}</label>
            <textarea class="form-control" id="objectives" name="objectives" rows="4">{{ old('objectives', $presentation?->translations->firstWhere('languageCode', old('language', $locale))?->objectives ?? $presentation?->translations->first()?->objectives) }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label" for="teachingResearchDomains">{{ __('Teaching & Research Domains') }}</label>
            <textarea class="form-control" id="teachingResearchDomains" name="teachingResearchDomains" rows="4">{{ old('teachingResearchDomains', $presentation?->translations->firstWhere('languageCode', old('language', $locale))?->teachingResearchDomains ?? $presentation?->translations->first()?->teachingResearchDomains) }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label" for="partnershipBenefits">{{ __('Partnership Benefits') }}</label>
            <textarea class="form-control" id="partnershipBenefits" name="partnershipBenefits" rows="4">{{ old('partnershipBenefits', $presentation?->translations->firstWhere('languageCode', old('language', $locale))?->partnershipBenefits ?? $presentation?->translations->first()?->partnershipBenefits) }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label" for="academicCalendar">{{ __('Academic Calendar') }}</label>
            <textarea class="form-control" id="academicCalendar" name="academicCalendar" rows="4">{{ old('academicCalendar', $presentation?->translations->firstWhere('languageCode', old('language', $locale))?->academicCalendar ?? $presentation?->translations->first()?->academicCalendar) }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label" for="registrationProcedure">{{ __('Registration Procedure') }}</label>
            <textarea class="form-control" id="registrationProcedure" name="registrationProcedure" rows="4">{{ old('registrationProcedure', $presentation?->translations->firstWhere('languageCode', old('language', $locale))?->registrationProcedure ?? $presentation?->translations->first()?->registrationProcedure) }}</textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="officeEmail">{{ __('Office Email') }}</label>
                <input class="form-control" id="officeEmail" type="email" name="officeEmail" value="{{ old('officeEmail', $presentation?->officeEmail) }}">
            </div>
            <div class="form-group">
                <label class="form-label" for="officePhone">{{ __('Office Phone') }}</label>
                <input class="form-control" id="officePhone" type="text" name="officePhone" value="{{ old('officePhone', $presentation?->officePhone) }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="officeAddress">{{ __('Office Address') }}</label>
                <input class="form-control" id="officeAddress" type="text" name="officeAddress" value="{{ old('officeAddress', $presentation?->translations->firstWhere('languageCode', old('language', $locale))?->officeAddress ?? $presentation?->translations->first()?->officeAddress) }}">
            </div>
            <div class="form-group">
                <label class="form-label" for="officeLocation">{{ __('Office Location') }}</label>
                <input class="form-control" id="officeLocation" type="text" name="officeLocation" value="{{ old('officeLocation', $presentation?->translations->firstWhere('languageCode', old('language', $locale))?->officeLocation ?? $presentation?->translations->first()?->officeLocation) }}">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="officeHoursText">{{ __('Office Hours') }}</label>
            <textarea class="form-control" id="officeHoursText" name="officeHoursText" rows="3">{{ old('officeHoursText', $presentation?->officeHours?->translations->firstWhere('languageCode', old('language', $locale))?->hoursText ?? $presentation?->officeHours?->translations->first()?->hoursText) }}</textarea>
        </div>

        <div style="display:flex; gap:10px; flex-wrap:wrap;">
            <button type="submit" class="btn btn--primary">{{ __('Save School Presentation') }}</button>
            <a href="{{ route('admin.school-presentation') }}" class="btn btn--outline">{{ __('Cancel') }}</a>
        </div>
    </div>
</form>
@endsection