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
            {{ $vision }}
        </p>

        <div class="section__header" style="margin-top:40px;">
            <h2>{{ __('presentation.section_strategy') }}</h2>
        </div>
        <p style="font-family:var(--font-body); line-height:1.7; color:var(--color-ink-black);">
            {{ $internationalizationStrategy }}
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

        <div class="section__header" style="margin-top:40px;">
            <h2>{{ __('presentation.section_domains') }}</h2>
        </div>
        <p style="font-family:var(--font-body); line-height:1.7; color:var(--color-ink-black);">
            {{ $teachingResearchDomains }}
        </p>
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
    </div>

    <aside>
        <div class="card">
            <div class="card__body">
                <h3 class="card__title">{{ __('presentation.section_benefits') }}</h3>
                <p class="card__text">{{ $partnershipBenefits }}</p>
            </div>
        </div>
        <div class="card" style="margin-top:20px;">
            <div class="card__body">
                <h3 class="card__title">{{ __('presentation.section_calendar') }}</h3>
                <p class="card__text">{{ $academicCalendar }}</p>
            </div>
        </div>
        <div class="card" style="margin-top:20px;">
            <div class="card__body">
                <h3 class="card__title">{{ __('presentation.section_registration') }}</h3>
                <p class="card__text">{{ $registrationProcedure }}</p>
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