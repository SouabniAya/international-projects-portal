@extends('layouts.admin')

@section('title', $programme ? __('Edit Funding Programme') : __('New Funding Programme'))
@php($active = 'funding-programmes')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1>{{ $programme ? __('Edit Funding Programme') : __('New Funding Programme') }}</h1>
            <p>{{ __('Only fields represented by the database are managed here.') }}</p>
        </div>
        <a href="{{ route('admin.funding-programmes') }}" class="btn btn-outline-secondary">{{ __('Back') }}</a>
    </div>

    <form method="POST" action="{{ $programme ? route('admin.funding-programmes.update', $programme->programID) : route('admin.funding-programmes.store') }}">
        @csrf
        @if($programme) @method('PUT') @endif
        <div class="card p-4">
            <div class="mb-3">
                <label class="form-label">{{ __('Programme Name') }}</label>
                <input class="form-control" name="translation[programName]" required maxlength="150" value="{{ old('translation.programName', $programme?->translation()?->programName) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('Description') }}</label>
                <textarea class="form-control" name="translation[description]" rows="5">{{ old('translation.description', $programme?->translation()?->description) }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('Official Website') }}</label>
                <input type="url" class="form-control" name="officialWebsite" value="{{ old('officialWebsite', $programme?->officialWebsite) }}">
            </div>
            @if($errors->any())
                <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
            @endif
            <button class="btn btn-primary" type="submit">{{ $programme ? __('Update Programme') : __('Create Programme') }}</button>
        </div>
    </form>
</div>
@endsection
