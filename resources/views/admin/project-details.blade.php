@extends('layouts.admin')

@section('title', __('Project Details'))

@section('content')
<div class="project-details">

    <a href="{{ route('admin.projects') }}" class="project-details__back">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 6l-6 6 6 6"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"/>
        </svg>
        {{ __('Back to Projects') }}
    </a>

    <div class="project-details__head">
        <div>
            <h1>{{ __('Project Details') }}</h1>
            <p>{{ __('Detailed information about the international project.') }}</p>
        </div>

        <div class="project-details__actions">

            <a href="#"
               class="project-details__btn project-details__btn--outline">
                <svg viewBox="0 0 24 24"
                     fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 14l10-10M14 4h6v6M20 14v6a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h6"
                          stroke="currentColor"
                          stroke-width="1.6"
                          stroke-linecap="round"
                          stroke-linejoin="round"/>
                </svg>
                {{ __('Official Website') }}
            </a>

            <a href="#"
               class="project-details__btn project-details__btn--solid">
                <svg viewBox="0 0 24 24"
                     fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 3v12m0 0l-4-4m4 4l4-4M5 21h14"
                          stroke="currentColor"
                          stroke-width="1.6"
                          stroke-linecap="round"
                          stroke-linejoin="round"/>
                </svg>
                {{ __('Download Documents') }}
            </a>

        </div>
    </div>


    {{-- ================================================================
         Summary
         ================================================================ --}}

    <div class="project-summary">

        <div class="project-summary__main">

            <img src="{{ asset('images/horizon-europe-badge.png') }}"
                 alt="{{ __('Horizon Europe') }}"
                 class="project-summary__logo">

            <div>

                <h2>
                    {{ __('GreenCampus – Sustainable Universities') }}
                </h2>

                <div class="project-summary__meta">

                    <span class="project-summary__tag">
                        {{ __('Horizon Europe') }}
                    </span>

                    <span class="project-summary__action-type">

                        <svg viewBox="0 0 24 24"
                             fill="none"
                             xmlns="http://www.w3.org/2000/svg">

                            <circle cx="9"
                                    cy="8"
                                    r="3.2"
                                    stroke="currentColor"
                                    stroke-width="1.6"/>

                            <path d="M2.5 19c0-3.2 3-5 6.5-5s6.5 1.8 6.5 5"
                                  stroke="currentColor"
                                  stroke-width="1.6"
                                  stroke-linecap="round"/>

                            <circle cx="17"
                                    cy="8.5"
                                    r="2.6"
                                    stroke="currentColor"
                                    stroke-width="1.6"/>

                            <path d="M14.8 19c.3-2.6 2.3-4 4.7-4s4.4 1.4 4.7 4"
                                  stroke="currentColor"
                                  stroke-width="1.6"
                                  stroke-linecap="round"/>

                        </svg>

                        {{ __('Research and Innovation Actions') }}

                    </span>

                </div>

                <p class="project-summary__desc">
                    {{ __('Promoting sustainable and eco-friendly university campuses through innovative solutions in energy, mobility, and resource management.') }}
                </p>

            </div>

        </div>


        {{-- Project facts --}}

        <div class="project-summary__facts">

            <div>

                <svg viewBox="0 0 24 24"
                     fill="none"
                     xmlns="http://www.w3.org/2000/svg">

                    <circle cx="12"
                            cy="12"
                            r="9"
                            stroke="currentColor"
                            stroke-width="1.6"/>

                    <path d="M12 8v4l2.5 1.5"
                          stroke="currentColor"
                          stroke-width="1.6"
                          stroke-linecap="round"/>

                </svg>

                <span>{{ __('Status') }}</span>

                <strong class="project-summary__status">
                    {{ __('Proposed') }}
                </strong>

            </div>


            <div>

                <svg viewBox="0 0 24 24"
                     fill="none"
                     xmlns="http://www.w3.org/2000/svg">

                    <circle cx="12"
                            cy="12"
                            r="9"
                            stroke="currentColor"
                            stroke-width="1.6"/>

                    <path d="M12 7v5l3.5 2"
                          stroke="currentColor"
                          stroke-width="1.6"
                          stroke-linecap="round"/>

                </svg>

                <span>{{ __('Duration') }}</span>

                <strong>
                    {{ __('Jan 2025 – Dec 2027') }}
                </strong>

            </div>


            <div>

                <svg viewBox="0 0 24 24"
                     fill="none"
                     xmlns="http://www.w3.org/2000/svg">

                    <path d="M6 4h12M6 4v16M18 4v16M9 8h6M9 12h6M9 16h6"
                          stroke="currentColor"
                          stroke-width="1.6"
                          stroke-linecap="round"/>

                </svg>

                <span>{{ __('Reference') }}</span>

                <strong>
                    HE-2024-GREEN-01
                </strong>

            </div>


            <div>

                <svg viewBox="0 0 24 24"
                     fill="none"
                     xmlns="http://www.w3.org/2000/svg">

                    <circle cx="12"
                            cy="8"
                            r="3.4"
                            stroke="currentColor"
                            stroke-width="1.6"/>

                    <path d="M5 20c0-3.6 3.1-5.6 7-5.6s7 2 7 5.6"
                          stroke="currentColor"
                          stroke-width="1.6"
                          stroke-linecap="round"/>

                </svg>

                <span>{{ __('Coordinator') }}</span>

                <strong>
                    {{ __('University of Barcelona, Spain') }}
                </strong>

            </div>

        </div>

    </div>


    {{-- ================================================================
         Tabs
         ================================================================ --}}

    <div class="project-tabs">

        <button type="button"
                class="project-tabs__btn is-active">

            <svg viewBox="0 0 24 24"
                 fill="none"
                 xmlns="http://www.w3.org/2000/svg">

                <path d="M6 2h9l5 5v15H6V2Z"
                      stroke="currentColor"
                      stroke-width="1.6"
                      stroke-linejoin="round"/>

                <path d="M15 2v5h5"
                      stroke="currentColor"
                      stroke-width="1.6"/>

            </svg>

            {{ __('Overview') }}

        </button>


        <a href="{{ route('admin.partners', ['project' => $id]) }}"
           class="project-tabs__btn">

            <svg viewBox="0 0 24 24"
                 fill="none"
                 xmlns="http://www.w3.org/2000/svg">

                <circle cx="9"
                        cy="8"
                        r="3.2"
                        stroke="currentColor"
                        stroke-width="1.6"/>

                <path d="M2.5 19c0-3.2 3-5 6.5-5s6.5 1.8 6.5 5"
                      stroke="currentColor"
                      stroke-width="1.6"
                      stroke-linecap="round"/>

                <circle cx="17"
                        cy="8.5"
                        r="2.6"
                        stroke="currentColor"
                        stroke-width="1.6"/>

                <path d="M14.8 19c.3-2.6 2.3-4 4.7-4s4.4 1.4 4.7 4"
                      stroke="currentColor"
                      stroke-width="1.6"
                      stroke-linecap="round"/>

            </svg>

            {{ __('Partners') }}

        </a>


        <button type="button"
                class="project-tabs__btn">

            <svg viewBox="0 0 24 24"
                 fill="none"
                 xmlns="http://www.w3.org/2000/svg">

                <path d="M6 2h9l5 5v15H6V2Z"
                      stroke="currentColor"
                      stroke-width="1.6"
                      stroke-linejoin="round"/>

                <path d="M15 2v5h5"
                      stroke="currentColor"
                      stroke-width="1.6"/>

            </svg>

            {{ __('Documents') }}

        </button>

    </div>


    {{-- ================================================================
         Overview
         ================================================================ --}}

    <div class="project-overview">


        {{-- Left column --}}

        <div class="project-overview__col">

            <div class="project-panel">

                <h3>
                    {{ __('Call Information') }}
                </h3>

                @php

                $callInfo = [

                    [
                        'label' => 'Programme',
                        'value' => 'Horizon Europe (2021-2027)'
                    ],

                    [
                        'label' => 'Pillar',
                        'value' => 'Pillar II – Global Challenges & European Industrial Competitiveness'
                    ],

                    [
                        'label' => 'Cluster',
                        'value' => 'Cluster 6 – Food, Bioeconomy, Natural Resources, Agriculture and Environment'
                    ],

                    [
                        'label' => 'Destination',
                        'value' => 'Biodiversity and Ecosystem Services'
                    ],

                    [
                        'label' => 'Call Reference',
                        'value' => 'HORIZON-CL6-2024-01-BIODIV-01'
                    ],

                    [
                        'label' => 'Type of Action',
                        'value' => 'Research and Innovation Actions (RIA)'
                    ],

                    [
                        'label' => 'Budget',
                        'value' => '€120,000,000'
                    ],

                    [
                        'label' => 'EU Funding Rate',
                        'value' => '100% of eligible costs'
                    ],

                    [
                        'label' => 'Project Duration',
                        'value' => '36 – 48 months'
                    ],

                    [
                        'label' => 'Consortium',
                        'value' => 'Minimum 3 independent legal entities from 3 different eligible countries'
                    ],

                ];

                @endphp


                <dl class="project-panel__list">

                    @foreach($callInfo as $row)

                    <div class="project-panel__row">

                        <dt>
                            {{ __($row['label']) }}
                        </dt>

                        <dd>
                            {{ __($row['value']) }}
                        </dd>

                    </div>

                    @endforeach


                    <div class="project-panel__row">

                        <dt>
                            {{ __('Keywords') }}
                        </dt>

                        <dd>

                            <div class="project-panel__keywords">

                                @foreach([
                                    'Biodiversity',
                                    'Ecosystems',
                                    'Nature-based Solutions',
                                    'Climate Change',
                                    'Sustainability'
                                ] as $kw)

                                    <span>
                                        {{ __($kw) }}
                                    </span>

                                @endforeach

                            </div>

                        </dd>

                    </div>

                </dl>

            </div>

        </div>


        {{-- Right column --}}

        <div class="project-overview__col">


            {{-- Description --}}

            <div class="project-panel project-panel--highlight">

                <h3>
                    {{ __('Description') }}
                </h3>

                <p>
                    {{ __('This call aims to fund research and innovation projects that help to halt and reverse biodiversity loss, enhance ecosystem services, and support the transition towards a sustainable and resilient society.') }}
                </p>


                <h4>
                    {{ __('Expected Impact:') }}
                </h4>

                <ul class="project-panel__checklist">

                    <li>
                        {{ __('Protect and restore biodiversity') }}
                    </li>

                    <li>
                        {{ __('Sustainable management of natural resources') }}
                    </li>

                    <li>
                        {{ __('Innovative solutions for environmental challenges') }}
                    </li>

                    <li>
                        {{ __('Strengthened knowledge and data for decision making') }}
                    </li>

                    <li>
                        {{ __('Contribution to the European Green Deal objectives') }}
                    </li>

                </ul>

            </div>


            {{-- At a Glance --}}

            <div class="project-panel">

                <h3>
                    {{ __('At a Glance') }}
                </h3>

                @php

                $glance = [

                    [
                        'label' => 'Budget',
                        'value' => '€120,000,000'
                    ],

                    [
                        'label' => 'Projects to be funded',
                        'value' => '~ 25'
                    ],

                    [
                        'label' => 'EU Contribution per project',
                        'value' => '€2M – €8M'
                    ],

                    [
                        'label' => 'Funding Rate',
                        'value' => '100%'
                    ],

                    [
                        'label' => 'Type of Action',
                        'value' => 'RIA'
                    ],

                    [
                        'label' => 'TRLs',
                        'value' => '1 – 6'
                    ],

                    [
                        'label' => 'Geographical Scope',
                        'value' => 'EU + Associated Countries'
                    ],

                ];

                @endphp


                <dl class="project-panel__list project-panel__list--compact">

                    @foreach($glance as $row)

                    <div class="project-panel__row">

                        <dt>
                            {{ __($row['label']) }}
                        </dt>

                        <dd>
                            {{ __($row['value']) }}
                        </dd>

                    </div>

                    @endforeach

                </dl>

            </div>

        </div>

    </div>

</div>
@endsection