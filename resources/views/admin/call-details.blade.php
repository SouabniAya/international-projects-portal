@extends('layouts.admin')

@section('title', __('Call for Proposals Details'))

@section('content')
<div class="cd-page">

    <a href="{{ route('admin.calls') }}" class="cd-page__back">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 6l-6 6 6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        {{ __('Back to Calls') }}
    </a>

    <h1 class="cd-page__title">{{ $call->translation()?->title ?? __('Untitled call') }}</h1>

    <div class="cd-page__head">
        <h2>{{ __('Call Overview') }}</h2>
        <div class="cd-page__actions">
            <a href="{{ $call->linkToOfficialSource ?? '#' }}"
               @if($call->linkToOfficialSource) target="_blank" rel="noopener" @endif
               class="cd-page__btn cd-page__btn--outline">
                {{ __('Official Source') }}
            </a>
        </div>
    </div>

    <div class="cd-tags">
        <span class="cd-tags__pill cd-tags__pill--programme">
            {{ $call->fundingProgramme?->translation()?->programName ?? __('Unclassified') }}
        </span>
        <span class="cd-tags__pill cd-tags__pill--status">{{ $call->status_label }}</span>
        @if($call->actionType)
            <span class="cd-tags__category">{{ $call->actionType }}</span>
        @endif
        <span class="cd-tags__id">#{{ $call->proposalID }}</span>
    </div>

    <div class="cd-card">
        <h3>{{ __('Key Information') }}</h3>
        <div class="cd-info-grid">
            <div class="cd-info-grid__item">
                <span class="cd-info-grid__label">{{ __('Status') }}</span>
                <span class="cd-info-grid__badge">{{ $call->status_label }}</span>
            </div>
            <div class="cd-info-grid__item">
                <span class="cd-info-grid__label">{{ __('Opening Date') }}</span>
                <span class="cd-info-grid__value">{{ $call->openingDate?->format('M j, Y') ?? '—' }}</span>
            </div>
            <div class="cd-info-grid__item">
                <span class="cd-info-grid__label">{{ __('Deadline') }}</span>
                <span class="cd-info-grid__value">{{ $call->deadline?->format('M j, Y') ?? '—' }}</span>
            </div>
            <div class="cd-info-grid__item">
                <span class="cd-info-grid__label">{{ __('Budget') }}</span>
                <span class="cd-info-grid__value">{{ $call->budget_label ?? '—' }}</span>
            </div>
            <div class="cd-info-grid__item">
                <span class="cd-info-grid__label">{{ __('Financing Organism') }}</span>
                <span class="cd-info-grid__value">{{ $call->financingOrganism ?? '—' }}</span>
            </div>
            <div class="cd-info-grid__item">
                <span class="cd-info-grid__label">{{ __('Funding Type') }}</span>
                <span class="cd-info-grid__value">{{ $call->fundingType ?? '—' }}</span>
            </div>
            <div class="cd-info-grid__item">
                <span class="cd-info-grid__label">{{ __('Financing Rate') }}</span>
                <span class="cd-info-grid__value">{{ $call->financingRate ?? '—' }}</span>
            </div>
            <div class="cd-info-grid__item">
                <span class="cd-info-grid__label">{{ __('Contact') }}</span>
                <span class="cd-info-grid__value">{{ $call->contact ?? '—' }}</span>
            </div>
        </div>
    </div>

    @if($call->translation()?->description)
    <div class="cd-card">
        <h3>{{ __('Description') }}</h3>
        <p>{{ $call->translation()->description }}</p>
    </div>
    @endif

    @if($call->translation()?->objectives)
    <div class="cd-card">
        <h3>{{ __('Objectives') }}</h3>
        <ul class="cd-list">
            @foreach(explode("\n", $call->translation()->objectives) as $line)
                @continue(trim($line) === '')
                <li>{{ trim($line) }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if($call->translation()?->eligibleBeneficiaries)
    <div class="cd-card">
        <h3>{{ __('Eligible Beneficiaries') }}</h3>
        <p>{{ $call->translation()->eligibleBeneficiaries }}</p>
    </div>
    @endif

    @if($call->documents->isNotEmpty())
    <div class="cd-card">
        <h3>{{ __('Documents') }}</h3>
        <table class="cd-docs-table">
            <thead>
                <tr>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Format') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($call->documents as $document)
                <tr>
                    <td>
                        <span class="cd-docs-table__name">
                            <span class="cd-docs-table__icon cd-docs-table__icon--{{ strtolower($document->format) === 'pdf' ? 'pdf' : 'docx' }}">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" stroke="currentColor" stroke-width="1.6"/>
                                    <path d="M14 2v6h6" stroke="currentColor" stroke-width="1.6"/>
                                </svg>
                            </span>
                            {{ $document->title }}
                        </span>
                    </td>
                    <td>{{ strtoupper($document->format) }}</td>
                    <td>
                        <a href="{{ $document->file ? asset('storage/'.$document->file) : $document->externalLink }}"
                           target="_blank" rel="noopener" class="cd-docs-table__download">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 3v12m0 0l-4-4m4 4l4-4M5 21h14" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

</div>
@endsection