@extends('layouts.admin')

@section('title', $agreement ? __('Edit Agreement') : __('New Agreement'))
@php($active = 'agreements')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1>{{ $agreement ? __('Edit Agreement') : __('New Agreement') }}</h1>
            <p>{{ __('Manage the agreement information stored in the portal.') }}</p>
        </div>
        <a href="{{ route('admin.agreements') }}" class="btn btn-outline-secondary">{{ __('Back') }}</a>
    </div>

    <form method="POST" action="{{ $agreement ? route('admin.agreements.update', $agreement->agreementID) : route('admin.agreements.store') }}">
        @csrf
        @if($agreement) @method('PUT') @endif

        <div class="card p-4">
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">{{ __('Title') }}</label>
                    <input class="form-control" name="translation[title]" required value="{{ old('translation.title', $agreement?->translation()?->title) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">{{ __('Partner') }}</label>
                    <select class="form-select" name="partnerID" required>
                        <option value="">{{ __('Select partner') }}</option>
                        @foreach($partners as $partner)
                            <option value="{{ $partner->partnerID }}" @selected(old('partnerID', $agreement?->partnerID) == $partner->partnerID)>{{ $partner->partnerName }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">{{ __('Agreement Type') }}</label>
                    <input class="form-control" name="agreementType" value="{{ old('agreementType', $agreement?->agreementType) }}" placeholder="Bilateral Agreement">
                </div>
                <div class="col-md-4">
                    <label class="form-label">{{ __('Signature Date') }}</label>
                    <input type="date" class="form-control" name="signatureDate" required value="{{ old('signatureDate', $agreement?->signatureDate?->format('Y-m-d')) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">{{ __('Status') }}</label>
                    <select class="form-select" name="status" required>
                        <option value="active" @selected(old('status', $agreement?->status) === 'active')>{{ __('Active') }}</option>
                        <option value="expired" @selected(old('status', $agreement?->status) === 'expired')>{{ __('Expired') }}</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('Start Date') }}</label>
                    <input type="date" class="form-control" name="startDate" required value="{{ old('startDate', $agreement?->startDate?->format('Y-m-d')) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('End Date') }}</label>
                    <input type="date" class="form-control" name="endDate" required value="{{ old('endDate', $agreement?->endDate?->format('Y-m-d')) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('Publication Status') }}</label>
                    <select class="form-select" name="publicationStatus" required>
                        @foreach(['draft','scheduled','published','archived'] as $status)
                            <option value="{{ $status }}" @selected(old('publicationStatus', $agreement?->publicationStatus ?? 'draft') === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            @if($errors->any())
                <div class="alert alert-danger mt-4"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
            @endif

            <div class="mt-4">
                <button class="btn btn-primary" type="submit">{{ $agreement ? __('Update Agreement') : __('Create Agreement') }}</button>
            </div>
        </div>
    </form>
</div>
@endsection
