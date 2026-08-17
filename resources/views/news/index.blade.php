{{-- resources/views/news/index.blade.php — FR-8 --}}
@extends('layouts.app')

@section('title', 'News')

@section('content')

<x-page-hero
    :title="__('pages.news.title')"
    :subtitle="__('pages.news.subtitle')"
    breadcrumb="<a href='{{ url('/') }}'>{{ __('nav.home') }}</a> / News">
</x-page-hero>

<section class="section">
    <div class="card-grid">
        @foreach ([
            ['title' => 'ESI signs new agreement with University of Barcelona', 'date' => '12 Aug 2026', 'excerpt' => 'A new framework agreement was signed to expand student and staff mobility.'],
            ['title' => 'Erasmus+ mobility results announced', 'date' => '28 Jul 2026', 'excerpt' => 'Selection results for the Spring 2026 outgoing mobility call are now available.'],
            ['title' => 'ESI joins the AI4MED research consortium', 'date' => '10 Jul 2026', 'excerpt' => 'A new Horizon Europe project brings together six institutions across the Mediterranean.'],
            ['title' => 'International Cooperation Info Day — recap', 'date' => '3 Jul 2026', 'excerpt' => 'Highlights from this year\'s info session on calls, mobility offers, and partnerships.'],
            ['title' => 'New PRIMA call opens for applications', 'date' => '20 Jun 2026', 'excerpt' => 'Researchers can now apply for the PRIMA 2026 cooperation call.'],
            ['title' => 'Delegation from TU Munich visits ESI', 'date' => '5 Jun 2026', 'excerpt' => 'A delegation explored opportunities for joint research and exchange.'],
        ] as $item)
        <a href="{{ url('/news/'.\Illuminate\Support\Str::slug($item['title'])) }}" class="card__link">
            <div class="card">
                <div class="card__image" style="background:linear-gradient(135deg, var(--color-cerulean), var(--color-deep-space-blue));"></div>
                <div class="card__body">
                    <span class="card__eyebrow">News</span>
                    <h3 class="card__title">{{ $item['title'] }}</h3>
                    <p class="card__text">{{ $item['excerpt'] }}</p>
                    <div class="card__meta">{{ $item['date'] }}</div>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    <nav class="pagination" aria-label="News pages">
        <a href="#" class="is-disabled">‹</a>
        <a href="#" class="is-active">1</a>
        <a href="#">2</a>
        <a href="#">3</a>
        <a href="#">›</a>
    </nav>
</section>

@endsection
