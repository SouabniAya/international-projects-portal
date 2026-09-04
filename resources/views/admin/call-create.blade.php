@extends('layouts.admin')

@section('title', __('New Call for Proposals'))

@section('content')

<div class="pm-page">

    <a href="{{ route('admin.calls') }}" class="pm-page__back">
        ← {{ __('Back to Calls') }}
    </a>

    <div class="pm-page__head">
        <div>
            <h1>{{ __('New Call for Proposals') }}</h1>
            <p>{{ __('Create a funding opportunity.') }}</p>
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

    <form method="POST"
          action="{{ route('admin.calls.store') }}"
          class="admin-form">

        @csrf

        <div class="form-grid">

            <label>
                {{ __('Title') }}
                <input
                    name="translation[title]"
                    value="{{ old('translation.title') }}"
                    required
                >
            </label>

            <label>
                {{ __('Programme') }}
                <select name="programID" required>
                    <option value="">
                        {{ __('Select') }}
                    </option>

                    @foreach($programmes as $p)
                        <option
                            value="{{ $p->programID }}"
                            @selected(old('programID') == $p->programID)
                        >
                            {{ $p->translation()?->programName ?? __('Programme').' #'.$p->programID }}
                        </option>
                    @endforeach
                </select>
            </label>

            <label>
                {{ __('Financing Organism') }}
                <input
                    name="financingOrganism"
                    value="{{ old('financingOrganism') }}"
                >
            </label>

            <label>
                {{ __('Action Type') }}
                <input
                    name="actionType"
                    value="{{ old('actionType') }}"
                >
            </label>

            <label>
                {{ __('Funding Type') }}
                <input
                    name="fundingType"
                    value="{{ old('fundingType') }}"
                >
            </label>

            <label>
                {{ __('Budget') }}
                <input
                    type="number"
                    step="0.01"
                    min="0"
                    name="budget"
                    value="{{ old('budget') }}"
                >
            </label>

            <label>
                {{ __('Financing Rate') }}
                <input
                    name="financingRate"
                    value="{{ old('financingRate') }}"
                >
            </label>

            <label>
                {{ __('Contact') }}
                <input
                    name="contact"
                    value="{{ old('contact') }}"
                >
            </label>

            <label>
                {{ __('Opening Date') }}
                <input
                    type="date"
                    name="openingDate"
                    value="{{ old('openingDate') }}"
                    required
                >
            </label>

            <label>
                {{ __('Deadline') }}
                <input
                    type="date"
                    name="deadline"
                    value="{{ old('deadline') }}"
                    required
                >
            </label>

            <label>
                {{ __('Official Source') }}
                <input
                    type="url"
                    name="linkToOfficialSource"
                    value="{{ old('linkToOfficialSource') }}"
                >
            </label>

            <label>
                {{ __('Status') }}
                <select name="status" required>

                    <option
                        value="upcoming"
                        @selected(old('status', 'upcoming') === 'upcoming')
                    >
                        {{ __('Upcoming') }}
                    </option>

                    <option
                        value="open"
                        @selected(old('status') === 'open')
                    >
                        {{ __('Open') }}
                    </option>

                    <option
                        value="closing_soon"
                        @selected(old('status') === 'closing_soon')
                    >
                        {{ __('Closing Soon') }}
                    </option>

                    <option
                        value="closed"
                        @selected(old('status') === 'closed')
                    >
                        {{ __('Closed') }}
                    </option>

                </select>
            </label>

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

        <label>
            {{ __('Description') }}
            <textarea name="translation[description]">{{ old('translation.description') }}</textarea>
        </label>

        <label>
            {{ __('Objectives') }}
            <textarea name="translation[objectives]">{{ old('translation.objectives') }}</textarea>
        </label>

        <label>
            {{ __('Eligible Beneficiaries') }}
            <textarea name="translation[eligibleBeneficiaries]">{{ old('translation.eligibleBeneficiaries') }}</textarea>
        </label>

        <button
            class="pm-page__btn"
            type="submit"
        >
            {{ __('Create Call') }}
        </button>

    </form>

</div>

@endsection