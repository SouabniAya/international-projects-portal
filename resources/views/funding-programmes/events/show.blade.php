@extends('layouts.app')

@section('title', $event['title'])

@section('content')
<x-page-hero
    :title="$event['title']"
    :subtitle="$event['date'].' · '.$event['location']"
    breadcrumb="<a href='{{ url('/') }}'>{{ __('nav.home') }}</a> / <a href='{{ route('events.index') }}'>Events</a> / Event">
</x-page-hero>

<section class="section two-col">
    <div>
        <div class="section__header"><h2>About this Event</h2></div>
        @if($event['description'])
            <div style="font-family:var(--font-body);line-height:1.7;color:var(--color-ink-black);">
                {!! $event['description'] !!}
            </div>
        @else
            <p style="font-family:var(--font-body);line-height:1.7;color:var(--color-ink-black);">
                {{ __('No description is available for this event yet.') }}
            </p>
        @endif

        @if(!empty($event['project']))
            <div class="section__header" style="margin-top:32px;"><h2>Related Project</h2></div>
            <div class="card">
                <div class="card__body">
                    <span class="badge badge--{{ \Illuminate\Support\Str::slug($event['project']['status']) }}">{{ $event['project']['status'] }}</span>
                    <h3 class="card__title">{{ $event['project']['title'] }}</h3>
                </div>
            </div>
        @endif
    </div>

    <aside>
        <div class="card">
            <div class="card__body">
                <h3 class="card__title">Event Details</h3>
                <p class="card__text"><strong>Date:</strong> {{ $event['date'] }}</p>
                @if($event['startTime'])
                    <p class="card__text"><strong>Time:</strong> {{ $event['startTime'] }}@if($event['endTime']) – {{ $event['endTime'] }}@endif</p>
                @endif
                <p class="card__text"><strong>Location:</strong> {{ $event['location'] }}</p>
                <p class="card__text"><strong>Type:</strong> {{ $event['type'] }}</p>
            </div>
        </div>

        <a href="{{ route('events.register', $event['id']) }}" class="btn btn--primary" style="margin-top:20px;width:100%;">
            Register interest
        </a>
    </aside>
</section>
@endsection
