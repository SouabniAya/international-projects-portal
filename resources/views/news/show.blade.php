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
    <div class="card__image" style="background:linear-gradient(135deg, var(--color-cerulean), var(--color-deep-space-blue)); border-radius:12px; aspect-ratio:16/7; margin-bottom:32px;"></div>

    <div style="font-family:var(--font-body); line-height:1.8; color:var(--color-ink-black); font-size:15.5px;">
        <p>ESI's International Relations Office is pleased to announce the signature of a new framework
        cooperation agreement with the University of Barcelona. The agreement establishes a foundation for
        student and staff mobility, joint research initiatives, and shared academic events between the two
        institutions over the next five years.</p>

        <p>The signing ceremony took place during an official visit of the Barcelona delegation, which included
        discussions on upcoming Erasmus+ mobility calls and potential joint publications in artificial
        intelligence and data science.</p>

        <p>"This agreement reflects our shared commitment to preparing students for a globally connected research
        and professional environment," said the Director of International Relations at ESI.</p>

        <p>The first mobility exchanges under this agreement are expected to begin in the Spring 2027 semester.
        Interested students and staff can find more information on the <a href="{{ url('/mobility') }}">Mobility</a> page.</p>
    </div>

    <div style="margin-top:40px; padding-top:24px; border-top:1px solid var(--color-neutral-300);">
        <a href="{{ url('/news') }}" class="btn btn--outline btn--sm">← Back to News</a>
    </div>
</section>

@endsection
