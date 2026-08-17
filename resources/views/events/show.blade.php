{{-- resources/views/events/show.blade.php --}}
@extends('layouts.app')

@section('title', $event['title'] ?? 'Event')

@php($event = $event ?? ['title' => 'International Cooperation Info Day', 'date' => '2 Sept 2026', 'location' => 'Amphitheater A'])

@section('content')

<x-page-hero
    :title="$event['title']"
    :subtitle="$event['date'].' · '.$event['location']"
    breadcrumb="<a href='{{ url('/') }}'>{{ __('nav.home') }}</a> / <a href='{{ url('/events') }}'>Events</a> / Event">
</x-page-hero>

<section class="section two-col">
    <div>
        <div class="section__header"><h2>About this Event</h2></div>
        <p style="font-family:var(--font-body); line-height:1.7; color:var(--color-ink-black);">
            Join the International Relations Office for an open session presenting this year's calls for
            proposals, mobility opportunities, and partner programmes. The event includes a Q&amp;A session
            with staff and returning exchange students.
        </p>

        <div class="section__header" style="margin-top:32px;"><h2>Related Project</h2></div>
        <div class="card"><div class="card__body">
            <span class="badge badge--ongoing">Ongoing</span>
            <h3 class="card__title">DIGI-COOP — Digital Cooperation Network</h3>
        </div></div>
    </div>

    <aside>
        <div class="card">
            <div class="card__body">
                <h3 class="card__title">Event Details</h3>
                <p class="card__text"><strong>Date:</strong> {{ $event['date'] }}</p>
                <p class="card__text"><strong>Location:</strong> {{ $event['location'] }}</p>
            </div>
        </div>
        <a href="{{ url('/contact') }}" class="btn btn--primary" style="margin-top:20px; width:100%;">Register interest</a>
    </aside>
</section>

@endsection
