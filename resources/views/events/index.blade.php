{{-- resources/views/events/index.blade.php — FR-8 --}}
@extends('layouts.app')

@section('title', 'Events')

@section('content')

<x-page-hero
    :title="__('pages.events.title')"
    :subtitle="__('pages.events.subtitle')"
    breadcrumb="<a href='{{ url('/') }}'>{{ __('nav.home') }}</a> / Events">
</x-page-hero>

<section class="section">
    <div class="card-grid">
        @foreach ([
            ['title' => 'International Cooperation Info Day', 'date' => '2 Sept 2026', 'location' => 'Amphitheater A', 'type' => 'Info day'],
            ['title' => 'DIGI-COOP Consortium Meeting', 'date' => '18 Sept 2026', 'location' => 'Online', 'type' => 'Project meeting'],
            ['title' => 'Partner Visit — TU Munich Delegation', 'date' => '25 Sept 2026', 'location' => 'Meeting Room 3', 'type' => 'Partner visit'],
            ['title' => 'Erasmus+ Application Workshop', 'date' => '8 Oct 2026', 'location' => 'Room B12', 'type' => 'Workshop'],
        ] as $event)
        <a href="{{ url('/events/'.\Illuminate\Support\Str::slug($event['title'])) }}" class="card__link">
            <div class="card">
                <div class="card__body">
                    <span class="card__eyebrow">{{ $event['type'] }}</span>
                    <h3 class="card__title">{{ $event['title'] }}</h3>
                    <div class="card__meta">{{ $event['date'] }} · {{ $event['location'] }}</div>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</section>

@endsection
