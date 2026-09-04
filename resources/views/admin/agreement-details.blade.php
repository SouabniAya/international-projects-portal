@extends('layouts.admin')
@section('title', __('Agreement Details'))
@php($active = 'agreements')
@section('content')
<div class="container py-4">
    <a href="{{ route('admin.agreements') }}">← {{ __('Back to Agreements') }}</a>
    <div class="card p-4 mt-3">
        <h1>{{ $agreement->translation()?->title ?? __('Untitled agreement') }}</h1>
        <p><strong>{{ __('Partner') }}:</strong> {{ $agreement->partner?->partnerName ?? '—' }}</p>
        <p><strong>{{ __('Type') }}:</strong> {{ $agreement->agreementType ? __($agreement->agreementType) : '—' }}</p>
        <p><strong>{{ __('Status') }}:</strong> {{ __($agreement->status_label) }}</p>
        <p><strong>{{ __('Signature') }}:</strong> {{ $agreement->signatureDate?->translatedFormat('d M Y') ?? '—' }}</p>
        <p><strong>{{ __('Period') }}:</strong> {{ $agreement->startDate?->translatedFormat('d M Y') }} — {{ $agreement->endDate?->translatedFormat('d M Y') }}</p>
        <div class="mt-3">
            <a class="btn btn-primary" href="{{ route('admin.agreements.edit', $agreement->agreementID) }}">{{ __('Edit') }}</a>
            <form method="POST" action="{{ route('admin.agreements.destroy', $agreement->agreementID) }}" style="display:inline" data-confirm-form>
                @csrf @method('DELETE')
                <button class="btn btn-danger" type="submit" data-confirm="{{ __('Delete this agreement?') }}">{{ __('Delete') }}</button>
            </form>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('form[data-confirm-form]').forEach(function (form) {
    form.addEventListener('submit', function (e) {
        var btn = form.querySelector('[data-confirm]');
        var message = btn ? btn.getAttribute('data-confirm') : 'Are you sure?';
        if (!confirm(message)) e.preventDefault();
    });
});
</script>
@endsection