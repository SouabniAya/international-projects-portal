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
        @forelse ($events as $event)
            <a href="{{ route('events.show', $event['id']) }}" class="card__link">
                <div class="card">
                    <div class="card__body">
                        <span class="card__eyebrow">{{ $event['type'] }}</span>
                        <h3 class="card__title">{{ $event['title'] }}</h3>
                        <div class="card__meta">
                            {{ $event['date'] }}@if($event['time']) · {{ $event['time'] }}@endif · {{ $event['location'] }}
                        </div>
                    </div>
                </div>
            </a>
        @empty
            <p>{{ __('No upcoming events yet.') }}</p>
        @endforelse
    </div>
</section>
@endsection
