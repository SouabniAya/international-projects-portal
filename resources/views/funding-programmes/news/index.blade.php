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
        @forelse ($news as $newsItem)
            <a href="{{ route('news.show', $newsItem['id']) }}" class="card__link">
                <div class="card">
                    <div class="card__image" style="background:linear-gradient(135deg, var(--color-cerulean), var(--color-deep-space-blue));">
                        @if (!empty($newsItem['image']))
                            <img src="{{ asset($newsItem['image']) }}" alt="{{ $newsItem['title'] }}" style="width:100%;height:100%;object-fit:cover;">
                        @endif
                    </div>
                    <div class="card__body">
                        <span class="card__eyebrow">News</span>
                        <h3 class="card__title">{{ $newsItem['title'] }}</h3>
                        <p class="card__text">{{ $newsItem['excerpt'] }}</p>
                        <div class="card__meta">{{ $newsItem['date'] }}</div>
                    </div>
                </div>
            </a>
        @empty
            <p>{{ __('No news articles yet.') }}</p>
        @endforelse
    </div>

    @if ($news->hasPages())
        <div style="margin-top:32px;">
            {{ $news->links() }}
        </div>
    @endif
</section>
@endsection
