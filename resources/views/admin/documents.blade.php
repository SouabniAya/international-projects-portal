@extends('layouts.admin')

@section('title', __('Documents'))

@section('content')
<div class="documents-page">

    <a href="{{ url('/admin/projects') }}" class="documents-page__back">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 6l-6 6 6 6"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"/>
        </svg>
        {{ __('Back to Projects') }}
    </a>

    <div class="documents-page__head">
        <div>
            <h1>{{ __('Documents') }}</h1>
            <p>
                {{ __('Access and download all important documents, guidelines, and resources.') }}
            </p>
        </div>

        <button type="button" class="documents-page__btn">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 15V3m0 0l-4 4m4-4l4 4M5 21h14"
                      stroke="currentColor"
                      stroke-width="1.6"
                      stroke-linecap="round"
                      stroke-linejoin="round"/>
            </svg>
            {{ __('Upload Document') }}
        </button>
    </div>


    {{-- Filters --}}
    <div class="documents-filters">

        <div class="documents-filters__top">

            <div class="documents-filters__search">
                <svg viewBox="0 0 24 24" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <circle cx="11" cy="11" r="7"
                            stroke="currentColor"
                            stroke-width="2"/>
                    <path d="M21 21l-4.3-4.3"
                          stroke="currentColor"
                          stroke-width="2"
                          stroke-linecap="round"/>
                </svg>

                <input
                    type="search"
                    placeholder="{{ __('Search documents...') }}"
                >
            </div>

            <button type="button" class="documents-filters__reset">
                <svg viewBox="0 0 24 24" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 12a9 9 0 1 1 3 6.7"
                          stroke="currentColor"
                          stroke-width="1.6"
                          stroke-linecap="round"/>
                    <path d="M3 8v5h5"
                          stroke="currentColor"
                          stroke-width="1.6"
                          stroke-linecap="round"
                          stroke-linejoin="round"/>
                </svg>

                {{ __('Reset Filters') }}
            </button>

        </div>


        <div class="documents-filters__row">

            @php
                $filters = [
                    'Document Type' => 'All Types',
                    'Programme / Category' => 'All Programmes',
                    'Language' => 'All Languages',
                    'Year' => 'All Years',
                ];
            @endphp

            @foreach($filters as $label => $default)

                <label class="documents-filters__field">

                    <span>{{ __($label) }}</span>

                    <div class="documents-filters__select">
                        <span>{{ __($default) }}</span>

                        <svg viewBox="0 0 24 24" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 9l6 6 6-6"
                                  stroke="currentColor"
                                  stroke-width="2"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>
                        </svg>
                    </div>

                </label>

            @endforeach

        </div>

    </div>


    {{-- Toolbar --}}
    <div class="documents-toolbar">

        <span class="documents-toolbar__count">
            {{ __('128 Documents found') }}
        </span>

        <div class="documents-toolbar__right">

            <label class="documents-toolbar__sort">

                <span>{{ __('Sort by:') }}</span>

                <div class="documents-toolbar__select">
                    <span>{{ __('Newest First') }}</span>

                    <svg viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 9l6 6 6-6"
                              stroke="currentColor"
                              stroke-width="2"
                              stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                </div>

            </label>


            <div class="documents-toolbar__view">

                <button type="button" class="is-active">

                    <svg viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 6h16M4 12h16M4 18h16"
                              stroke="currentColor"
                              stroke-width="1.8"
                              stroke-linecap="round"/>
                    </svg>

                    {{ __('List') }}

                </button>


                <button type="button">

                    <svg viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg">

                        <rect x="3" y="3" width="7" height="7"
                              rx="1.5"
                              stroke="currentColor"
                              stroke-width="1.6"/>

                        <rect x="14" y="3" width="7" height="7"
                              rx="1.5"
                              stroke="currentColor"
                              stroke-width="1.6"/>

                        <rect x="3" y="14" width="7" height="7"
                              rx="1.5"
                              stroke="currentColor"
                              stroke-width="1.6"/>

                        <rect x="14" y="14" width="7" height="7"
                              rx="1.5"
                              stroke="currentColor"
                              stroke-width="1.6"/>

                    </svg>

                    {{ __('Grid') }}

                </button>

            </div>

        </div>

    </div>


    {{-- Documents table --}}
    <div class="documents-table-wrap">

        <table class="documents-table">

            <thead>

                <tr>
                    <th>{{ __('Document') }}</th>
                    <th>{{ __('Type') }}</th>
                    <th>{{ __('Programme / Category') }}</th>
                    <th>{{ __('Language') }}</th>
                    <th>{{ __('Date') }}</th>
                    <th>{{ __('Size') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>

            </thead>


            <tbody>

                @php

                // Placeholder data — replace with real Document model/query later
                $documents = [

                    [
                        'title' => 'International Cooperation Strategy 2025-2030',
                        'desc' => 'Strategic plan and objectives for international development.',
                        'type' => 'Strategy',
                        'category' => 'Institutional',
                        'lang' => 'EN',
                        'date' => 'May 10, 2025',
                        'size' => '2.4 MB',
                        'ext' => 'pdf'
                    ],

                    [
                        'title' => 'Partnership Agreement Template',
                        'desc' => 'Template for academic partnership agreements.',
                        'type' => 'Template',
                        'category' => 'Partnerships',
                        'lang' => 'EN',
                        'date' => 'Apr 28, 2025',
                        'size' => '1.1 MB',
                        'ext' => 'pdf'
                    ],

                    [
                        'title' => 'Erasmus+ Programme Guide 2025',
                        'desc' => 'Guide for Erasmus+ opportunities and conditions.',
                        'type' => 'Guide',
                        'category' => 'Erasmus+',
                        'lang' => 'EN',
                        'date' => 'Apr 15, 2025',
                        'size' => '3.7 MB',
                        'ext' => 'doc'
                    ],

                    [
                        'title' => 'Horizon Europe – Work Programme 2025',
                        'desc' => 'Official work programme for Horizon Europe 2025.',
                        'type' => 'Programme',
                        'category' => 'Horizon Europe',
                        'lang' => 'EN',
                        'date' => 'Mar 30, 2025',
                        'size' => '5.2 MB',
                        'ext' => 'pdf'
                    ],

                    [
                        'title' => 'Mobility Application Form',
                        'desc' => 'Application form for student mobility programs.',
                        'type' => 'Form',
                        'category' => 'Mobility',
                        'lang' => 'FR',
                        'date' => 'Mar 22, 2025',
                        'size' => '812 KB',
                        'ext' => 'pdf'
                    ],

                    [
                        'title' => 'Research Laboratories Presentation',
                        'desc' => 'Overview of research laboratories and facilities.',
                        'type' => 'Presentation',
                        'category' => 'Research',
                        'lang' => 'EN',
                        'date' => 'Mar 10, 2025',
                        'size' => '4.6 MB',
                        'ext' => 'ppt'
                    ],

                    [
                        'title' => 'Code of Conduct for International Partners',
                        'desc' => 'Guidelines and ethical standards for partnerships.',
                        'type' => 'Policy',
                        'category' => 'Institutional',
                        'lang' => 'EN',
                        'date' => 'Feb 25, 2025',
                        'size' => '1.3 MB',
                        'ext' => 'pdf'
                    ],

                ];

                @endphp


                @foreach($documents as $doc)

                <tr>

                    <td>

                        <div class="documents-table__doc">

                            <span class="documents-table__icon documents-table__icon--{{ $doc['ext'] }}">

                                <svg viewBox="0 0 24 24" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">

                                    <path d="M6 2h9l5 5v15H6V2Z"
                                          stroke="currentColor"
                                          stroke-width="1.4"
                                          stroke-linejoin="round"/>

                                    <path d="M15 2v5h5"
                                          stroke="currentColor"
                                          stroke-width="1.4"
                                          stroke-linejoin="round"/>

                                </svg>

                            </span>


                            <div>

                                <strong>
                                    {{ __($doc['title']) }}
                                </strong>

                                <span>
                                    {{ __($doc['desc']) }}
                                </span>

                            </div>

                        </div>

                    </td>


                    <td>
                        <span class="documents-table__tag documents-table__tag--type">
                            {{ __($doc['type']) }}
                        </span>
                    </td>


                    <td>
                        <span class="documents-table__tag documents-table__tag--category">
                            {{ __($doc['category']) }}
                        </span>
                    </td>


                    <td>
                        {{ $doc['lang'] }}
                    </td>


                    <td>
                        {{ __($doc['date']) }}
                    </td>


                    <td>
                        {{ $doc['size'] }}
                    </td>


                    <td>

                        <div class="documents-table__actions">

                            <button
                                type="button"
                                aria-label="{{ __('Download') }}"
                            >

                                <svg viewBox="0 0 24 24" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">

                                    <path d="M12 3v12m0 0l-4-4m4 4l4-4M5 21h14"
                                          stroke="currentColor"
                                          stroke-width="1.6"
                                          stroke-linecap="round"
                                          stroke-linejoin="round"/>

                                </svg>

                            </button>


                            <button
                                type="button"
                                aria-label="{{ __('View') }}"
                            >

                                <svg viewBox="0 0 24 24" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">

                                    <path d="M1.5 12S5 5 12 5s10.5 7 10.5 7-3.5 7-10.5 7-10.5-7-10.5-7Z"
                                          stroke="currentColor"
                                          stroke-width="1.6"
                                          stroke-linejoin="round"/>

                                    <circle cx="12" cy="12" r="3"
                                            stroke="currentColor"
                                            stroke-width="1.6"/>

                                </svg>

                            </button>

                        </div>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>


        <nav
            class="documents-pagination"
            aria-label="{{ __('Documents pagination') }}"
        >

            <button
                type="button"
                aria-label="{{ __('Previous page') }}"
            >
                ‹
            </button>

            <button type="button" class="is-active">1</button>
            <button type="button">2</button>
            <button type="button">3</button>
            <button type="button">4</button>
            <button type="button">5</button>

            <span>…</span>

            <button type="button">13</button>

            <button
                type="button"
                aria-label="{{ __('Next page') }}"
            >
                ›
            </button>

        </nav>

    </div>

</div>
@endsection