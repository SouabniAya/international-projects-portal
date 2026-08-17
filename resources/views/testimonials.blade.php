{{-- resources/views/testimonials.blade.php — FR-1.7 --}}
@extends('layouts.app')

@section('title', 'Testimonials')

@section('content')

<x-page-hero
    :title="__('pages.testimonials.title')"
    :subtitle="__('pages.testimonials.subtitle')"
    breadcrumb="<a href='{{ url('/') }}'>{{ __('nav.home') }}</a> / Testimonials">
</x-page-hero>

<section class="section">
    <div class="card-grid">
        @foreach ([
            ['name' => 'Amine K.', 'role' => 'Semester Exchange, Politecnico di Torino', 'text' => 'My exchange semester in Turin completely changed how I approach research — the whole process, from application to arrival, was smooth thanks to the IR office.'],
            ['name' => 'Lina B.', 'role' => 'Research Stay, Sorbonne Université', 'text' => 'The scientific stay at Sorbonne gave me access to resources and collaborations I couldn\'t have found here alone.'],
            ['name' => 'Yacine M.', 'role' => 'Summer School, TU Munich', 'text' => 'Two intense weeks that pushed me way outside my comfort zone, in the best way possible. Highly recommend applying early.'],
            ['name' => 'Sarah T.', 'role' => 'Staff Mobility, University of Barcelona', 'text' => 'As a staff member, the training week in Barcelona gave me practical ideas I brought straight back to our own programmes.'],
        ] as $t)
        <div class="card">
            <div class="card__body">
                <p class="card__text" style="font-style:italic;">"{{ $t['text'] }}"</p>
                <div class="card__meta" style="margin-top:12px;">
                    <strong style="color:var(--color-ink-black);">{{ $t['name'] }}</strong> — {{ $t['role'] }}
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

@endsection
