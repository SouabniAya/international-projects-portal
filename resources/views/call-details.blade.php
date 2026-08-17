@extends('layouts.app')

@section('title', __('Call for Proposals Details'))

@section('content')
<div class="cd-page">

    <a href="{{ url('/admin/calls') }}" class="cd-page__back">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 6l-6 6 6 6"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"/>
        </svg>
        {{ __('Back to Calls') }}
    </a>

    <h1 class="cd-page__title">
        {{ __('Call for Proposals Details') }}
    </h1>

    @php
        // Placeholder data -- replace with real Call model/query later
        $call = [
            'id' => $id ?? 1,

            'title' => 'MSCA Postdoctoral Fellowships 2025',
            'programme_tag' => 'MSCA',
            'category' => 'Marie Skłodowska-Curie Actions',
            'status' => 'Open',
            'call_id' => 'MSCA-PF-2025',

            'description' => [
                'The MSCA Postdoctoral Fellowships support excellent researchers holding a PhD who wish to carry out their research activities abroad, acquire new skills and advance their careers.',

                'This action aims to enhance the creative and innovative potential of researchers and to foster excellence in research through international mobility.',
            ],

            'key_info' => [
                [
                    'label' => 'Programme',
                    'value' => 'Horizon Europe'
                ],
                [
                    'label' => 'Action Type',
                    'value' => 'MSCA Postdoctoral Fellowships'
                ],
                [
                    'label' => 'Call Reference',
                    'value' => 'HORIZON-MSCA-2025-PF-01'
                ],
                [
                    'label' => 'Publication Date',
                    'value' => 'Apr 10, 2025'
                ],
                [
                    'label' => 'Call Status',
                    'value' => 'Open',
                    'badge' => true
                ],
                [
                    'label' => 'Deadline',
                    'value' => 'Sep 10, 2025 17:00 (Brussels time)'
                ],
                [
                    'label' => 'Eligible Countries',
                    'value' => 'All countries'
                ],
                [
                    'label' => 'Type of Action',
                    'value' => 'MSCA-PF'
                ],
                [
                    'label' => 'Domain',
                    'value' => 'All Scientific Domains'
                ],
                [
                    'label' => 'Budget',
                    'value' => '€257,000,000'
                ],
            ],

            'summary' => 'The fellowship supports individual postdoctoral researchers to conduct research in another country, gain new skills and international exposure, and boost their career prospects.',

            'objectives' => [
                'Support researchers in acquiring new knowledge and skills through mobility.',
                'Enhance career development and employability.',
                'Foster international, interdisciplinary and inter-sectoral mobility.',
            ],

            'target_audience' => 'Postdoctoral researchers holding a PhD (or expected to obtain by the deadline).',

            'official_link' => 'https://ec.europa.eu/info/funding-tenders/opportunities/portal/screen/home',

            'documents' => [
                [
                    'name' => 'Call Text',
                    'type' => 'PDF',
                    'lang' => 'EN',
                    'size' => '1.2 MB',
                    'icon' => 'pdf',
                    'file' => 'documents/call-text.pdf'
                ],
                [
                    'name' => 'Guide for Applicants',
                    'type' => 'PDF',
                    'lang' => 'EN',
                    'size' => '2.4 MB',
                    'icon' => 'pdf',
                    'file' => 'documents/guide-for-applicants.pdf'
                ],
                [
                    'name' => 'Annexes',
                    'type' => 'DOCX',
                    'lang' => 'EN',
                    'size' => '1.1 MB',
                    'icon' => 'docx',
                    'file' => 'documents/annexes.docx'
                ],
            ],
        ];
    @endphp


    {{-- Header --}}
    <div class="cd-page__head">

        <div>
            <h2>{{ __($call['title']) }}</h2>
        </div>

        <div class="cd-page__actions">

            <a href="#"
               class="cd-page__btn cd-page__btn--outline">

                <svg viewBox="0 0 24 24"
                     fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 3v12m0 0l-4-4m4 4l4-4M5 21h14"
                          stroke="currentColor"
                          stroke-width="1.6"
                          stroke-linecap="round"
                          stroke-linejoin="round"/>
                </svg>

                {{ __('Download Call Document') }}

            </a>

            <a href="#"
               class="cd-page__btn cd-page__btn--filled">

                {{ __('Apply / Submit') }}

            </a>

        </div>
    </div>


    {{-- Tags --}}
    <div class="cd-tags">

        <span class="cd-tags__pill cd-tags__pill--programme">
            {{ __($call['programme_tag']) }}
        </span>

        <span class="cd-tags__category">
            {{ __($call['category']) }}
        </span>

        <span class="cd-tags__pill cd-tags__pill--status">
            {{ __($call['status']) }}
        </span>

        <span class="cd-tags__id">
            {{ __('Call ID') }}: {{ $call['call_id'] }}
        </span>

    </div>


    {{-- Description --}}
    <div class="cd-card">

        <h3>{{ __('Description') }}</h3>

        @foreach($call['description'] as $paragraph)
            <p>{{ __($paragraph) }}</p>
        @endforeach

        <button type="button"
                class="cd-card__toggle">

            {{ __('Read more') }}

            <svg viewBox="0 0 24 24"
                 fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path d="M6 9l6 6 6-6"
                      stroke="currentColor"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"/>
            </svg>

        </button>

    </div>


    {{-- Key Information --}}
    <div class="cd-card">

        <h3>{{ __('Key Information') }}</h3>

        <div class="cd-info-grid">

            @foreach($call['key_info'] as $info)

                <div class="cd-info-grid__item">

                    <span class="cd-info-grid__label">
                        {{ __($info['label']) }}
                    </span>

                    @if(!empty($info['badge']))

                        <span class="cd-info-grid__badge">
                            {{ __($info['value']) }}
                        </span>

                    @else

                        <span class="cd-info-grid__value">
                            {{ __($info['value']) }}
                        </span>

                    @endif

                </div>

            @endforeach

        </div>

    </div>


    {{-- Summary --}}
    <div class="cd-card">

        <h3>{{ __('Summary') }}</h3>

        <p>
            {{ __($call['summary']) }}
        </p>


        <h4>{{ __('Objectives') }}:</h4>

        <ul class="cd-list">

            @foreach($call['objectives'] as $objective)

                <li>
                    {{ __($objective) }}
                </li>

            @endforeach

        </ul>


        <h4>{{ __('Target Audience') }}</h4>

        <p>
            {{ __($call['target_audience']) }}
        </p>


        <h4>{{ __('Link to Official Source') }}</h4>

        <a href="{{ $call['official_link'] }}"
           target="_blank"
           rel="noopener"
           class="cd-link">

            {{ $call['official_link'] }}

        </a>

    </div>


    {{-- Call Documents --}}
    <div class="cd-card">

        <h3>{{ __('Call Documents') }}</h3>

        <div class="cd-docs-table-wrap">

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

                    @foreach($call['documents'] as $doc)

                        <tr>

                            <td>

                                <div class="cd-docs-table__name">

                                    <span class="cd-docs-table__icon cd-docs-table__icon--{{ $doc['icon'] }}">

                                        <svg viewBox="0 0 24 24"
                                             fill="none"
                                             xmlns="http://www.w3.org/2000/svg">

                                            <path d="M6 2h9l5 5v13a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2Z"
                                                  stroke="currentColor"
                                                  stroke-width="1.6"
                                                  stroke-linejoin="round"/>

                                            <path d="M14 2v6h6"
                                                  stroke="currentColor"
                                                  stroke-width="1.6"
                                                  stroke-linejoin="round"/>

                                        </svg>

                                    </span>

                                    {{ __($doc['name']) }}

                                </div>

                            </td>

                            <td>
                                {{ __($doc['type']) }}
                            </td>

                            <td>
                                {{ __($doc['lang']) }}
                            </td>

                            <td>
                                {{ $doc['size'] }}
                            </td>

                            <td>

                                <a href="{{ asset($doc['file']) }}"
                                   download
                                   aria-label="{{ __('Download') }} {{ __($doc['name']) }}"
                                   class="cd-docs-table__download">

                                    <svg viewBox="0 0 24 24"
                                         fill="none"
                                         xmlns="http://www.w3.org/2000/svg">

                                        <path d="M12 3v12m0 0l-4-4m4 4l4-4M5 21h14"
                                              stroke="currentColor"
                                              stroke-width="1.6"
                                              stroke-linecap="round"
                                              stroke-linejoin="round"/>

                                    </svg>

                                </a>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>
@endsection