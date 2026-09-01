{{-- resources/views/news/show.blade.php --}}
@extends('layouts.app')

@section('title', $news['title'] ?? 'News Article')

@php($news = $news ?? ['title' => 'ESI signs new agreement with University of Barcelona', 'date' => '12 Aug 2026'])

@section('content')

<x-page-hero
    :title="$news['title']"
    :subtitle="$news['date']"
    breadcrumb="<a href='{{ url('/') }}'>{{ __('nav.home') }}</a> / <a href='{{ url('/news') }}'>News</a> / Article">
</x-page-hero>

<section class="section" style="max-width:820px;">
    <div class="card__image" style="background:linear-gradient(135deg, var(--color-cerulean), var(--color-deep-space-blue)); border-radius:12px; aspect-ratio:16/7; margin-bottom:32px;">
        @if(!empty($news['image']))
        <img src="{{ asset($news['image']) }}" alt="{{ $news['title'] }}" style="width:100%; height:100%; object-fit:cover; border-radius:12px;">
        @endif
    </div>

    <div style="font-family:var(--font-body); line-height:1.8; color:var(--color-ink-black); font-size:15.5px;">
        {!! $news['content'] ?? '' !!}
    </div>

    <div style="margin-top:40px; padding-top:24px; border-top:1px solid var(--color-neutral-300);">
        <a href="{{ url('/news') }}" class="btn btn--outline btn--sm">← Back to News</a>
    </div>
</section>

@endsection
