@extends('layouts.app')

@section('title', 'Funding Opportunities')

@section('content')
<x-page-hero
    :title="__('Funding Opportunities')"
    :subtitle="__('Programmes that fund our international cooperation, mobility, and research activities.')"
    breadcrumb="<a href='{{ url('/') }}'>{{ __('nav.home') }}</a> / {{ __('Funding Opportunities') }}">
</x-page-hero>

<section class="section">
    <div class="section__header section__header--row">
        <p style="margin:0; color:var(--color-neutral-500); font-family:var(--font-body); font-size:14px;">
            {{ trans_choice(':count funding programme|:count funding programmes', $programmes->count(), ['count' => $programmes->count()]) }}
        </p>
        <a href="{{ url('/calls') }}" class="btn btn--outline btn--sm">{{ __('Browse all calls for proposals →') }}</a>
    </div>

    <div class="card-grid">
        @forelse ($programmes as $programme)
            <div class="card">
                <div class="card__body">
                    <h3 class="card__title">{{ $programme['name'] }}</h3>

                    <p class="card__text">
                        {{ $programme['description']
                            ? \Illuminate\Support\Str::limit(strip_tags($programme['description']), 160)
                            : __('No description available yet.') }}
                    </p>

                    <div style="display:flex; align-items:center; gap:8px; margin:12px 0;">
                        @if ($programme['openCallsCount'] > 0)
                            <span class="badge badge--open">
                                {{ trans_choice(':count open call|:count open calls', $programme['openCallsCount'], ['count' => $programme['openCallsCount']]) }}
                            </span>
                        @else
                            <span class="badge badge--closed">{{ __('No open calls right now') }}</span>
                        @endif
                    </div>

                    <div style="display:flex; gap:8px; flex-wrap:wrap;">
                        <a href="{{ route('funding-programmes.show', $programme['id']) }}" class="btn btn--primary btn--sm">
                            {{ __('View programme →') }}
                        </a>
                        @if ($programme['website'])
                            <a href="{{ $programme['website'] }}" target="_blank" rel="noopener noreferrer" class="btn btn--outline btn--sm">
                                {{ __('Official website') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <p style="grid-column:1/-1; text-align:center; padding:40px;">
                {{ __('No funding programmes have been added yet.') }}
            </p>
        @endforelse
    </div>
</section>
@endsection
