@extends('layouts.app')

@section('title', __('Call for Proposals Details'))

@section('content')

<div class="cd-page">

    <a href="{{ route('calls.index') }}" class="cd-page__back">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 6l-6 6 6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        {{ __('Back to Calls') }}
    </a>

    <h1 class="cd-page__title">{{ __('Call for Proposals Details') }}</h1>

    @php
        $t = $call->translation();
        $programme = $call->fundingProgramme;
        $programmeT = $programme?->translation();

        // On ne garde que les infos qui existent vraiment en base
        $keyInfo = collect([
            ['label' => __('Programme'), 'value' => $programmeT?->programName],
            ['label' => __('Action Type'), 'value' => $t?->actionType],
            ['label' => __('Financing Organism'), 'value' => $t?->financingOrganism],
            ['label' => __('Funding Type'), 'value' => $t?->fundingType],
            ['label' => __('Opening Date'), 'value' => $call->openingDate?->translatedFormat('d M Y')],
            ['label' => __('Call Status'), 'value' => __($call->status_label), 'badge' => true],
            ['label' => __('Deadline'), 'value' => $call->deadline?->translatedFormat('d M Y')],
            [
                'label' => __('Eligible Countries'),
                'value' => $call->eligibleCountries->isEmpty()
                    ? __('All countries')
                    : $call->eligibleCountries->map(fn ($c) => $c->translation()?->countryName)->filter()->join(', '),
            ],
            [
                'label' => __('Financing Rate'),
                'value' => $call->financingRate !== null ? number_format((float) $call->financingRate, 0) . '%' : null,
            ],
            ['label' => __('Budget'), 'value' => $call->budget_label],
        ])->filter(fn ($info) => filled($info['value']));
    @endphp


    {{-- HEADER --}}
    <div class="cd-page__head">
        <h2>{{ $t?->title ?? __('Untitled call') }}</h2>

        <div class="cd-page__actions">
            @if($call->documents->isNotEmpty())
                <a href="{{ $call->documents->first()->url }}" class="cd-page__btn cd-page__btn--outline" target="_blank" rel="noopener">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 3v12m0 0l-4-4m4 4l4-4M5 21h14" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    {{ __('Download Call Document') }}
                </a>
            @endif

            @if($call->linkToOfficialSource)
                <a href="{{ $call->linkToOfficialSource }}" class="cd-page__btn cd-page__btn--filled" target="_blank" rel="noopener">
                    {{ __('Apply / Submit') }}
                </a>
            @endif
        </div>
    </div>


    {{-- TAGS --}}
    <div class="cd-tags">
        @if($programmeT)
            <span class="cd-tags__pill cd-tags__pill--programme">{{ $programmeT->programName }}</span>
        @endif

        <span class="cd-tags__pill cd-tags__pill--status">{{ __($call->status_label) }}</span>

        <span class="cd-tags__id">{{ __('Call ID') }}: {{ $call->proposalID }}</span>
    </div>


    {{-- DESCRIPTION --}}
    @if($t?->description)
        <div class="cd-card">
            <h3>{{ __('Description') }}</h3>
            @foreach(explode("\n", trim($t->description)) as $paragraph)
                @continue(trim($paragraph) === '')
                <p>{{ $paragraph }}</p>
            @endforeach
        </div>
    @endif


    {{-- KEY INFORMATION --}}
    @if($keyInfo->isNotEmpty())
        <div class="cd-card">
            <h3>{{ __('Key Information') }}</h3>
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
    @endif


    {{-- SUMMARY --}}
    @if($t && ($t->objectives || $t->eligibleBeneficiaries || $call->linkToOfficialSource))
        <div class="cd-card">
            <h3>{{ __('Summary') }}</h3>

            @if($t->objectives)
                <h4>{{ __('Objectives') }}:</h4>
                <ul class="cd-list">
                    @foreach(explode("\n", trim($t->objectives)) as $objective)
                        @continue(trim($objective) === '')
                        <li>{{ $objective }}</li>
                    @endforeach
                </ul>
            @endif

            @if($t->eligibleBeneficiaries)
                <h4>{{ __('Target Audience') }}</h4>
                <p>{{ $t->eligibleBeneficiaries }}</p>
            @endif

            @if($call->linkToOfficialSource)
                <h4>{{ __('Link to Official Source') }}</h4>
                <a href="{{ $call->linkToOfficialSource }}" target="_blank" rel="noopener" class="cd-link">
                    {{ $call->linkToOfficialSource }}
                </a>
            @endif
        </div>
    @endif


    {{-- CALL DOCUMENTS --}}
    @if($call->documents->isNotEmpty())
        <div class="cd-card">
            <h3>{{ __('Call Documents') }}</h3>
            <table class="cd-docs-table">
                <thead>
                    <tr>
                        <th>{{ __('Document Name') }}</th>
                        <th>{{ __('Type') }}</th>
                        <th>{{ __('Language') }}</th>
                        <th>{{ __('Size') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($call->documents as $doc)
                        <tr>
                            <td>
                                <div class="cd-docs-table__name">
                                    <span class="cd-docs-table__icon cd-docs-table__icon--{{ $doc->icon }}">
                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M6 2h9l5 5v13a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                                            <path d="M14 2v6h6" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                                        </svg>
                                    </span>
                                    {{ $doc->title }}
                                </div>
                            </td>
                            <td>{{ strtoupper($doc->format) }}</td>
                            <td>{{ strtoupper($doc->languageCode) }}</td>
                            <td>{{ $doc->size_label }}</td>
                            <td>
                                <a href="{{ $doc->url }}" download aria-label="{{ __('Download') }} {{ $doc->title }}" class="cd-docs-table__download" target="_blank" rel="noopener">
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