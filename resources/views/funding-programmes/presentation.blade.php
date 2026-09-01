{{-- resources/views/presentation.blade.php — FR-2.1 to FR-2.4 --}}
@extends('layouts.app')

@section('title', 'International Presentation')

@section('content')

<x-page-hero
    :title="__('pages.presentation.title')"
    :subtitle="__('pages.presentation.subtitle')"
    breadcrumb="<a href='{{ url('/') }}'>{{ __('nav.home') }}</a> / International Presentation">
</x-page-hero>

<section class="section two-col">
    <div>
        <div class="section__header">
            <h2>{{ __('presentation.section_vision') }}</h2>
        </div>
        <p style="font-family:var(--font-body); line-height:1.7; color:var(--color-ink-black);">
            {{ $vision ?: __('No vision statement has been added yet.') }}
        </p>

        <div class="section__header" style="margin-top:40px;">
            <h2>{{ __('presentation.section_strategy') }}</h2>
        </div>
        <p style="font-family:var(--font-body); line-height:1.7; color:var(--color-ink-black);">
            {{ $internationalizationStrategy ?: __('No internationalization strategy has been added yet.') }}
        </p>

        <div class="section__header" style="margin-top:40px;">
            <h2>{{ __('presentation.section_missions') }}</h2>
        </div>
        @if ($missions)
            <ul style="font-family:var(--font-body); line-height:1.9; color:var(--color-ink-black); padding-left:20px;">
                @foreach (array_filter(preg_split('/\r\n|\r|\n/', $missions)) as $line)
                    <li>{{ trim($line) }}</li>
                @endforeach
            </ul>
        @endif
        @if ($objectives)
            <ul style="font-family:var(--font-body); line-height:1.9; color:var(--color-ink-black); padding-left:20px;">
                @foreach (array_filter(preg_split('/\r\n|\r|\n/', $objectives)) as $line)
                    <li>{{ trim($line) }}</li>
                @endforeach
            </ul>
        @endif
        @if (!$missions && !$objectives)
            <p style="font-family:var(--font-body); color:var(--color-neutral-500);">
                {{ __('No missions or objectives have been added yet.') }}
            </p>
        @endif

        <div class="section__header" style="margin-top:40px;">
            <h2>{{ __('presentation.section_domains') }}</h2>
        </div>

        @php
            // The DB field is a free-text sentence (e.g. "AI, Data Science, ...,
            // and HCI — supported by dedicated research teams..."), not a clean
            // comma-separated list. Keep only the actual list portion (before
            // any em/en-dash trailing clause), then split on line breaks /
            // commas, and strip leading conjunctions ("and", "et", a bare
            // Arabic "و" prefix) left over from natural-language lists.
            $domains = [];
            if (!empty($teachingResearchDomains)) {
                $listPart = preg_split('/\s[—–]\s|\s-\s{2,}|—|–/u', $teachingResearchDomains)[0] ?? $teachingResearchDomains;
                $parts = preg_split('/\r\n|\r|\n|,|،|\s+(?:and|et)\s+/iu', $listPart);
                foreach ($parts as $part) {
                    $part = trim($part);
                    $part = preg_replace('/^و(?=\S)/u', '', $part);
                    $part = trim($part, " \t\n\r\0\x0B.");
                    if ($part !== '') {
                        $domains[] = $part;
                    }
                }
            }
        @endphp
        @if ($researchTeams->isNotEmpty())
        <div class="card-grid" style="margin-top:20px;">
            @foreach ($researchTeams as $team)
                <div class="card">
                    <div class="card__body">
                        <h3 class="card__title">{{ $team['name'] }}</h3>
                        <p class="card__text">{{ $team['description'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        @else
        <p style="font-family:var(--font-body); color:var(--color-neutral-500); margin-top:12px;">
            {{ __('No research teams listed yet.') }}
        </p>
        @endif
    </div>

    <aside>
        <div class="card">
            <div class="card__body">
                <h3 class="card__title">{{ __('presentation.section_benefits') }}</h3>
                <p class="card__text">{{ $partnershipBenefits ?: __('No partnership benefits documented yet.') }}</p>
            </div>
        </div>
        <div class="card" style="margin-top:20px;">
            <div class="card__body">
                <h3 class="card__title">{{ __('presentation.section_calendar') }}</h3>
                <p class="card__text">{{ $academicCalendar ?: __('No academic calendar information available yet.') }}</p>
            </div>
        </div>
        <div class="card" style="margin-top:20px;">
            <div class="card__body">
                <h3 class="card__title">{{ __('presentation.section_registration') }}</h3>
                <p class="card__text">{{ $registrationProcedure ?: __('No registration procedure documented yet.') }}</p>
                <a href="{{ url('/contact') }}" class="btn btn--outline btn--sm" style="margin-top:8px;">
                    {{ __('presentation.btn_contact_office') }}
                </a>
            </div>
        </div>
        <a href="{{ url('/documents') }}" class="btn btn--primary" style="margin-top:20px; width:100%;">
            {{ __('presentation.btn_brochure') }}
        </a>
    </aside>
</section>

@endsection