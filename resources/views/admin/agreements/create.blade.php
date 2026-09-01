@extends('layouts.admin')

@section('title', $agreement ? __('Edit Agreement') : __('New Agreement'))
@php($active = 'agreements')

@section('content')

<div class="section__header section__header--row" style="margin-bottom:18px;">
    <div>
        <h2 style="margin:0;">{{ $agreement ? __('Edit Agreement') : __('New Agreement') }}</h2>
        <p style="margin:4px 0 0;">{{ __('Manage the agreement information stored in the portal.') }}</p>
    </div>
    <a href="{{ route('admin.agreements') }}" class="btn btn--outline btn--sm">{{ __('Back') }}</a>
</div>

@if($errors->any())
<div class="card" style="margin-bottom:20px;"><div class="card__body">
    <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
</div></div>
@endif

<form method="POST" action="{{ $agreement ? route('admin.agreements.update', $agreement->agreementID) : route('admin.agreements.store') }}" class="card">
    @csrf
    @if($agreement) @method('PUT') @endif

    <div class="card__body">

        <div class="form-group">
            <label class="form-label" for="agreementTitle">{{ __('Title') }}</label>
            <input class="form-control" id="agreementTitle" name="translation[title]" required
                   value="{{ old('translation.title', $agreement?->translation()?->title) }}">
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="agreementPartner">{{ __('Partner') }}</label>
                <select class="form-control" id="agreementPartner" name="partnerID" required>
                    <option value="">{{ __('Select partner') }}</option>
                    @foreach($partners as $partner)
                        <option value="{{ $partner->partnerID }}" @selected(old('partnerID', $agreement?->partnerID) == $partner->partnerID)>{{ $partner->partnerName }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="agreementType">{{ __('Agreement Type') }}</label>
                <input class="form-control" id="agreementType" name="agreementType"
                       value="{{ old('agreementType', $agreement?->agreementType) }}" placeholder="Bilateral Agreement">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="signatureDate">{{ __('Signature Date') }}</label>
                <input class="form-control" type="date" id="signatureDate" name="signatureDate" required
                       value="{{ old('signatureDate', $agreement?->signatureDate?->format('Y-m-d')) }}">
            </div>

            <div class="form-group">
                <label class="form-label" for="agreementStatus">{{ __('Status') }}</label>
                <select class="form-control" id="agreementStatus" name="status" required>
                    <option value="active" @selected(old('status', $agreement?->status) === 'active')>{{ __('Active') }}</option>
                    <option value="expired" @selected(old('status', $agreement?->status) === 'expired')>{{ __('Expired') }}</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="startDate">{{ __('Start Date') }}</label>
                <input class="form-control" type="date" id="startDate" name="startDate" required
                       value="{{ old('startDate', $agreement?->startDate?->format('Y-m-d')) }}">
            </div>

            <div class="form-group">
                <label class="form-label" for="endDate">{{ __('End Date') }}</label>
                <input class="form-control" type="date" id="endDate" name="endDate" required
                       value="{{ old('endDate', $agreement?->endDate?->format('Y-m-d')) }}">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="publicationStatus">{{ __('Publication Status') }}</label>
            <select class="form-control" id="publicationStatus" name="publicationStatus" required style="max-width:260px;">
                @foreach(['draft','scheduled','published','archived'] as $status)
                    <option value="{{ $status }}" @selected(old('publicationStatus', $agreement?->publicationStatus ?? 'draft') === $status)>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </div>

        <div style="margin-top:8px;">
            <button class="btn btn--primary" type="submit">{{ $agreement ? __('Update Agreement') : __('Create Agreement') }}</button>
            <a class="btn btn--outline" href="{{ route('admin.agreements') }}">{{ __('Cancel') }}</a>
        </div>
    </div>
</form>
@endsection