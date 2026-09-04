@extends('layouts.admin')

@section('title', __('New Mobility Opportunity'))

@section('content')

<div class="pm-page">

    <a href="{{ route('admin.mobility') }}" class="pm-page__back">
        ← {{ __('Back to Mobility') }}
    </a>

    <div class="pm-page__head">
        <div>
            <h1>{{ __('New Mobility Opportunity') }}</h1>
            <p>{{ __('Create a mobility opportunity.') }}</p>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert--error">
            <ul>
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        method="POST"
        action="{{ route('admin.mobility.store') }}"
        class="admin-form"
    >

        @csrf

        <div class="form-grid">

            {{-- MOBILITY TYPE --}}
            <label>
                {{ __('Mobility Type') }}

                <select name="mobilityType" required>

                    @foreach([
                        'outgoing_student' => 'Outgoing Student',
                        'incoming_student' => 'Incoming Student',
                        'staff' => 'Staff',
                        'researcher' => 'Researcher',
                        'internship' => 'Internship',
                        'summer_school' => 'Summer School',
                        'scientific_stay' => 'Scientific Stay',
                        'scholarship' => 'Scholarship'
                    ] as $k => $v)

                        <option
                            value="{{ $k }}"
                            @selected(old('mobilityType') === $k)
                        >
                            {{ __($v) }}
                        </option>

                    @endforeach

                </select>
            </label>


            {{-- PROGRAMME --}}
            <label>
                {{ __('Programme') }}

                <select name="programID">

                    <option value="">
                        {{ __('— None —') }}
                    </option>

                    @foreach($programmes as $p)

                        <option
                            value="{{ $p->programID }}"
                            @selected(old('programID') == $p->programID)
                        >
                            {{ $p->translation()?->programName
                                ?? __('Programme').' #'.$p->programID }}
                        </option>

                    @endforeach

                </select>
            </label>


            {{-- HOSTING ESTABLISHMENT --}}
            <label>
                {{ __('Hosting Establishment') }}
                <input
                    name="hostingEstablishment"
                    value="{{ old('hostingEstablishment') }}"
                >
            </label>


            {{-- CITY --}}
            <label>
                {{ __('City') }}
                <input
                    name="city"
                    value="{{ old('city') }}"
                >
            </label>


            {{-- TARGET AUDIENCE --}}
            <label>
                {{ __('Target Audience') }}
                <input
                    name="targetAudience"
                    value="{{ old('targetAudience') }}"
                >
            </label>


            {{-- PLACES --}}
            <label>
                {{ __('Places Available') }}
                <input
                    type="number"
                    min="0"
                    name="placesAvailable"
                    value="{{ old('placesAvailable') }}"
                    required
                >
            </label>


            {{-- START DATE --}}
            <label>
                {{ __('Start Date') }}
                <input
                    type="date"
                    name="startDate"
                    value="{{ old('startDate') }}"
                    required
                >
            </label>


            {{-- END DATE --}}
            <label>
                {{ __('End Date') }}
                <input
                    type="date"
                    name="endDate"
                    value="{{ old('endDate') }}"
                    required
                >
            </label>


            {{-- APPLICATION DEADLINE --}}
            <label>
                {{ __('Application Deadline') }}
                <input
                    type="date"
                    name="applicationDeadline"
                    value="{{ old('applicationDeadline') }}"
                    required
                >
            </label>


            {{-- LANGUAGE SKILLS --}}
            <label>
                {{ __('Language Skills') }}
                <input
                    name="requiredLanguageSkills"
                    value="{{ old('requiredLanguageSkills') }}"
                >
            </label>


            {{-- FUNDING --}}
            <label>
                {{ __('Funding Available') }}
                <input
                    name="fundingAvailable"
                    value="{{ old('fundingAvailable') }}"
                >
            </label>


            {{-- CONTACT --}}
            <label>
                {{ __('Contact') }}
                <input
                    name="contact"
                    value="{{ old('contact') }}"
                    required
                >
            </label>


            {{-- APPLICATION LINK --}}
            <label>
                {{ __('Application Link') }}
                <input
                    type="url"
                    name="applicationLink"
                    value="{{ old('applicationLink') }}"
                    required
                >
            </label>


            {{-- PUBLICATION --}}
            <label>
                {{ __('Publication') }}

                <select name="publicationStatus">

                    <option
                        value="draft"
                        @selected(old('publicationStatus', 'draft') === 'draft')
                    >
                        {{ __('Draft') }}
                    </option>

                    <option
                        value="published"
                        @selected(old('publicationStatus') === 'published')
                    >
                        {{ __('Published') }}
                    </option>

                    <option
                        value="scheduled"
                        @selected(old('publicationStatus') === 'scheduled')
                    >
                        {{ __('Scheduled') }}
                    </option>

                    <option
                        value="archived"
                        @selected(old('publicationStatus') === 'archived')
                    >
                        {{ __('Archived') }}
                    </option>

                </select>
            </label>

        </div>


        {{-- TITLE --}}
        <label>
            {{ __('Title') }}

            <input
                name="translation[title]"
                value="{{ old('translation.title') }}"
                required
            >
        </label>


        {{-- CONDITIONS --}}
        <label>
            {{ __('Conditions') }}

            <textarea
                name="translation[conditions]"
            >{{ old('translation.conditions') }}</textarea>
        </label>


        {{-- APPLICATION PROCESS --}}
        <label>
            {{ __('Application Process') }}

            <textarea
                name="translation[applicationProcess]"
                required
            >{{ old('translation.applicationProcess') }}</textarea>
        </label>


        {{-- SELECTION CRITERIA --}}
        <label>
            {{ __('Selection Criteria') }}

            <textarea
                name="translation[selectionCriteria]"
            >{{ old('translation.selectionCriteria') }}</textarea>
        </label>


        <button
            class="pm-page__btn"
            type="submit"
        >
            {{ __('Create Mobility') }}
        </button>

    </form>

</div>

@endsection