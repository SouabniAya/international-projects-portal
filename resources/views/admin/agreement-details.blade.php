@extends('layouts.admin')
@section('title', __('Agreement Details'))
@php($active = 'agreements')
@section('content')
<div class="container py-4">
    <a href="{{ route('admin.agreements') }}">← {{ __('Back to Agreements') }}</a>
    <div class="card p-4 mt-3">
        <h1>{{ $agreement->translation()?->title ?? __('Untitled agreement') }}</h1>
        <p><strong>{{ __('Partner') }}:</strong> {{ $agreement->partner?->partnerName ?? '—' }}</p>
        <p><strong>{{ __('Type') }}:</strong> {{ $agreement->agreementType ?? '—' }}</p>
        <p><strong>{{ __('Status') }}:</strong> {{ $agreement->status_label }}</p>
        <p><strong>{{ __('Signature') }}:</strong> {{ $agreement->signatureDate?->format('M j, Y') ?? '—' }}</p>
        <p><strong>{{ __('Period') }}:</strong> {{ $agreement->startDate?->format('M j, Y') }} — {{ $agreement->endDate?->format('M j, Y') }}</p>
        <div class="mt-3">
            <a class="btn btn-primary" href="{{ route('admin.agreements.edit', $agreement->agreementID) }}">{{ __('Edit') }}</a>
            <form method="POST" action="{{ route('admin.agreements.destroy', $agreement->agreementID) }}" style="display:inline" onsubmit="return confirm('{{ __('Delete this agreement?') }}')">
                @csrf @method('DELETE')
                <button class="btn btn-danger" type="submit">{{ __('Delete') }}</button>
            </form>
        </div>
    </div>
</div>
@endsection
