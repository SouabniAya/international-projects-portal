@extends('layouts.app')

@section('title', 'Call for Proposals Details')

@section('content')
<div class="cd-page">

    <a href="{{ route('calls.index') }}" class="cd-page__back">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 6l-6 6 6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        Back to Calls
    </a>

    <h1 class="cd-page__title">Call for Proposals Details</h1>

    @php
        $t = $call->translation();
        $programme = $call->fundingProgramme;
        $programmeT = $programme?->translation();

        $keyInfo = [
            ['label' => 'Programme', 'value' => $programmeT->programName ?? '—'],
            ['label' => 'Action Type', 'value' => $call->actionType ?? '—'],
            ['label' => 'Financing Organism', 'value' => $call->financingOrganism ?? '—'],
            ['label' => 'Funding Type', 'value' => $call->fundingType ?? '—'],
            ['label' => 'Opening Date', 'value' => $call->openingDate->format('M d, Y')],
            ['label' => 'Call Status', 'value' => $call->status_label, 'badge' => true],
            ['label' => 'Deadline', 'value' => $call->deadline->format('M d, Y')],
            ['label' => 'Eligible Countries', 'value' => $call->eligibleCountries->isEmpty()
                ? 'All countries'
                : $call->eligibleCountries->map(fn ($c) => $c->translation()?->countryName)->filter()->join(', ')],
            ['label' => 'Financing Rate', 'value' => $call->financingRate ?? '—'],
            ['label' => 'Budget', 'value' => $call->budget_label ?? '—'],
        ];
    @endphp

    <div class="cd-page__head">
        <h2>{{ $t->title ?? 'Untitled call' }}</h2>
        <div class="cd-page__actions">
            @if($call->documents->isNotEmpty())
                <a href="{{ $call->documents->first()->url }}" class="cd-page__btn cd-page__btn--outline" target="_blank" rel="noopener">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 3v12m0 0l-4-4m4 4l4-4M5 21h14" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Download Call Document
                </a>
            @endif
            @if($call->linkToOfficialSource)
                <a href="{{ $call->linkToOfficialSource }}" class="cd-page__btn cd-page__btn--filled" target="_blank" rel="noopener">Apply / Submit</a>
            @endif
        </div>
    </div>

    <div class="cd-tags">
        @if($programmeT)
            <span class="cd-tags__pill cd-tags__pill--programme">{{ $programmeT->programName }}</span>
        @endif
        <span class="cd-tags__pill cd-tags__pill--status">{{ $call->status_label }}</span>
        <span class="cd-tags__id">Call ID: {{ $call->proposalID }}</span>
    </div>

    {{-- Description --}}
    @if($t?->description)
    <div class="cd-card">
        <h3>Description</h3>
        @foreach(explode("\n", trim($t->description)) as $paragraph)
            @continue(trim($paragraph) === '')
            <p>{{ $paragraph }}</p>
        @endforeach
    </div>
    @endif

    {{-- Key Information --}}
    <div class="cd-card">
        <h3>Key Information</h3>
        <div class="cd-info-grid">
            @foreach($keyInfo as $info)
            <div class="cd-info-grid__item">
                <span class="cd-info-grid__label">{{ $info['label'] }}</span>
                @if(!empty($info['badge']))
                    <span class="cd-info-grid__badge">{{ $info['value'] }}</span>
                @else
                    <span class="cd-info-grid__value">{{ $info['value'] }}</span>
                @endif
            </div>
            @endforeach
        </div>
    </div>

    {{-- Summary --}}
    @if($t && ($t->objectives || $t->eligibleBeneficiaries))
    <div class="cd-card">
        <h3>Summary</h3>

        @if($t->objectives)
        <h4>Objectives:</h4>
        <ul class="cd-list">
            @foreach(explode("\n", trim($t->objectives)) as $objective)
                @continue(trim($objective) === '')
                <li>{{ $objective }}</li>
            @endforeach
        </ul>
        @endif

        @if($t->eligibleBeneficiaries)
        <h4>Target Audience</h4>
        <p>{{ $t->eligibleBeneficiaries }}</p>
        @endif

        @if($call->linkToOfficialSource)
        <h4>Link to Official Source</h4>
        <a href="{{ $call->linkToOfficialSource }}" target="_blank" rel="noopener" class="cd-link">{{ $call->linkToOfficialSource }}</a>
        @endif
    </div>
    @endif

    {{-- Call Documents --}}
    @if($call->documents->isNotEmpty())
    <div class="cd-card">
        <h3>Call Documents</h3>
        <table class="cd-docs-table">
            <thead>
                <tr>
                    <th>Document Name</th>
                    <th>Type</th>
                    <th>Language</th>
                    <th>Size</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($call->documents as $doc)
                <tr>
                    <td>
                        <div class="cd-docs-table__name">
                            <span class="cd-docs-table__icon cd-docs-table__icon--{{ $doc->icon }}">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 2h9l5 5v13a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M14 2v6h6" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                            </span>
                            {{ $doc->title }}
                        </div>
                    </td>
                    <td>{{ strtoupper($doc->format) }}</td>
                    <td>{{ strtoupper($doc->languageCode) }}</td>
                    <td>{{ $doc->size_label }}</td>
                    <td>
                        <a href="{{ $doc->url }}" download aria-label="Download {{ $doc->title }}" class="cd-docs-table__download" target="_blank" rel="noopener">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 3v12m0 0l-4-4m4 4l4-4M5 21h14" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
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