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

            <a href="{{ $project->website ?? '#' }}"
               @if($project->website) target="_blank" rel="noopener" @endif
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

            <img src="{{ asset($project->logo ?? 'images/logoEsi.png') }}"
                 alt="{{ $project->fundingProgramme?->translation()?->programName ?? __('Project') }}"
                 class="project-summary__logo">

            <div>

                <h2>
                    {{ $project->translation()?->title ?? $project->acronym ?? __('Untitled project') }}
                </h2>

                <div class="project-summary__meta">

                    <span class="project-summary__tag">
                        {{ $project->fundingProgramme?->translation()?->programName ?? __('Unclassified') }}
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

                        {{ $project->schoolRole }}

                    </span>

                </div>

                <p class="project-summary__desc">
                    {{ $project->translation()?->abstract ?? __('No description available yet.') }}
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
                    {{ $project->status_label }}
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
                    {{ $project->startDate?->translatedFormat('M Y') }} – {{ $project->endDate?->translatedFormat('M Y') }}
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
                    {{ $project->projectReference ?? '—' }}
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
                    {{ $project->coordinator }}{{ $project->country?->translation()?->countryName ? ', ' . $project->country->translation()->countryName : '' }}
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


        <a href="{{ route('admin.partner-management', ['project' => $id]) }}"
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

                {{--
                    Only rows backed by a real Project column/relation are
                    shown. Pillar / Cluster / Destination / EU Funding Rate /
                    Consortium / Type of Action have no equivalent anywhere
                    on Project (they read as Call-for-Proposal metadata, not
                    project metadata) — rather than show fabricated values,
                    they're omitted. Let me know if you'd rather these live
                    on the related Call/Agreement instead of here.
                --}}
                @php
                $callInfo = collect([
                    ['label' => 'Programme', 'value' => $project->fundingProgramme?->translation()?->programName],
                    ['label' => 'Reference', 'value' => $project->projectReference],
                    ['label' => 'Budget', 'value' => $project->budget !== null ? '€' . number_format((float) $project->budget, 0, ',', ',') : null],
                    ['label' => 'Duration', 'value' => $project->startDate && $project->endDate ? $project->startDate->diffInMonths($project->endDate) . ' months' : null],
                ])->filter(fn ($row) => !empty($row['value']));
                @endphp


                <dl class="project-panel__list">

                    @forelse($callInfo as $row)

                    <div class="project-panel__row">

                        <dt>
                            {{ __($row['label']) }}
                        </dt>

                        <dd>
                            {{ $row['value'] }}
                        </dd>

                    </div>

                    @empty
                    <p style="font-family:var(--font-body); font-size:13px; color:var(--color-neutral-500);">
                        {{ __('No call information recorded for this project yet.') }}
                    </p>
                    @endforelse

                    {{--
                        The original static "Reference" and "Keywords" rows
                        that lived here have been removed: Reference is
                        already included in the $callInfo loop above, and
                        Keywords has no backing column anywhere in the schema.
                    --}}

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
                    {{ $project->translation()?->objectives ?? $project->translation()?->abstract ?? __('No description available yet.') }}
                </p>


                @php
                $keyResults = collect(explode("\n", (string) $project->translation()?->keyResults))
                    ->map(fn ($line) => trim($line))
                    ->filter();
                @endphp

                @if($keyResults->isNotEmpty())
                <h4>
                    {{ __('Expected Impact:') }}
                </h4>

                <ul class="project-panel__checklist">
                    @foreach($keyResults as $line)
                    <li>{{ $line }}</li>
                    @endforeach
                </ul>
                @endif

            </div>


            {{-- At a Glance --}}

            <div class="project-panel">

                <h3>
                    {{ __('At a Glance') }}
                </h3>

                {{--
                    "Projects to be funded", "EU Contribution per project",
                    "Funding Rate" and "TRLs" are Call-level aggregate
                    concepts, not attributes of a single Project — they
                    don't make sense here even if the schema had them.
                    Only Budget and Geographical Scope map to real columns.
                --}}
                @php
                $glance = collect([
                    ['label' => 'Budget', 'value' => $project->budget !== null ? '€' . number_format((float) $project->budget, 0, ',', ',') : null],
                    ['label' => 'Geographical Scope', 'value' => $project->country?->translation()?->countryName],
                ])->filter(fn ($row) => !empty($row['value']));
                @endphp


                <dl class="project-panel__list project-panel__list--compact">

                    @forelse($glance as $row)

                    <div class="project-panel__row">

                        <dt>
                            {{ __($row['label']) }}
                        </dt>

                        <dd>
                            {{ $row['value'] }}
                        </dd>

                    </div>

                    @empty
                    <p style="font-family:var(--font-body); font-size:13px; color:var(--color-neutral-500);">
                        {{ __('No summary data recorded for this project yet.') }}
                    </p>
                    @endforelse

                </dl>

            </div>

        </div>

    </div>

</div>
@endsection
</div>
