@extends('layouts.app')

@section('title', 'International Partnerships')

@section('content')
<x-page-hero
    :title="__('pages.partnerships.title')"
    :subtitle="__('pages.partnerships.subtitle')"
    breadcrumb="<a href='{{ url('/') }}'>{{ __('nav.home') }}</a> / Partnerships">
</x-page-hero>

<div class="page-hero__toolbar">
    <form class="filter-bar" method="GET" action="{{ route('partnerships.index') }}">
        <div class="filter-bar__search">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            <input type="search" name="search" value="{{ $search }}" placeholder="{{ __('Search partners...') }}">
        </div>
        <select class="form-control" name="country">
            <option value="">{{ __('Country / Region') }}</option>
            @foreach($countries as $item)
                <option value="{{ $item->countryCode }}" @selected($country === $item->countryCode)>{{ $item->translation()?->countryName ?? $item->countryCode }}</option>
            @endforeach
        </select>
        <select class="form-control" name="type">
            <option value="">{{ __('Institution type') }}</option>
            @foreach($types as $item)
                <option value="{{ $item }}" @selected($type === $item)>{{ $item }}</option>
            @endforeach
        </select>
        <button class="btn btn--primary btn--sm" type="submit">{{ __('Search') }}</button>
        @if($search || $country || $type || $status)
            <a class="btn btn--outline btn--sm" href="{{ route('partnerships.index') }}">{{ __('Reset') }}</a>
        @endif
    </form>
</div>

<section class="section">
    <div class="section__header section__header--row">
        <p style="margin:0; color:var(--color-neutral-500); font-family:var(--font-body); font-size:14px;">{{ trans_choice(':count partner|:count partners', $partners->total(), ['count' => $partners->total()]) }}</p>
        <a href="{{ url('/become-a-partner') }}" class="btn btn--primary btn--sm">{{ __('Become a partner') }}</a>
    </div>

    <div class="card-grid">
        @forelse($partners as $partner)
            @php($countryModel = $partner->country)
            <div>
                <x-partner-card
                    :name="$partner->partnerName"
                    :countryFlag="''"
                    :country="$countryModel?->translation()?->countryName ?? $partner->countryCode"
                    :city="$partner->city ?? '—'"
                    :tags="array_filter([$partner->establishmentType, $partner->partnershipType])"
                    :logoDomain="''"
                    :href="route('partnerships.show', ['slug' => \Illuminate\Support\Str::slug($partner->partnerName)])" />
            </div>
        @empty
            <p style="grid-column:1/-1; text-align:center; padding:40px;">{{ __('No partners match your filters.') }}</p>
        @endforelse
    </div>

    {{ $partners->onEachSide(1)->links() }}
</section>
@endsection
