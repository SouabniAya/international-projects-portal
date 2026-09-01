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
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:32px; flex-wrap:wrap; gap:16px;">
        <h2 style="margin:0;">Recent Testimonials</h2>
        <a href="{{ route('testimonials.create') }}" class="btn btn--outline btn--sm">{{ __('pages.submit_testimonial.submit_button') }} →</a>
    </div>
    <div class="card-grid">
        @foreach ($testimonials as $t)
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