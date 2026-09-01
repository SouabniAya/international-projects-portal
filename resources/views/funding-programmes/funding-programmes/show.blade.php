@extends('layouts.app')

@section('title', $programme['name'])

@section('content')
<x-page-hero
    :title="$programme['name']"
    subtitle="Funding programme overview and related calls."
    breadcrumb="<a href='{{ url('/') }}'>{{ __('nav.home') }}</a> / <a href='{{ url('/calls') }}'>Calls</a> / {{ $programme['name'] }}">
</x-page-hero>

<section class="section two-col">
    <div>
        <div class="section__header"><h2>About the Programme</h2></div>
        @if($programme['description'])
            <div style="font-family:var(--font-body);line-height:1.7;color:var(--color-ink-black);">
                {!! $programme['description'] !!}
            </div>
        @else
            <p>{{ __('No description available yet.') }}</p>
        @endif

        <div class="section__header" style="margin-top:40px;"><h2>Open Calls Under This Programme</h2></div>
        <div class="data-table-wrap">
            <table class="data-table">
                <thead><tr><th>Call</th><th>Action Type</th><th>Deadline</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse($programme['calls'] as $call)
                        <tr>
                            <td>{{ $call['title'] }}</td>
                            <td>{{ $call['type'] }}</td>
                            <td>{{ $call['deadline'] }}</td>
                            <td><span class="badge badge--{{ \Illuminate\Support\Str::slug($call['status']) }}">{{ $call['status'] }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="4">{{ __('No open calls under this programme right now.') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <aside>
        <div class="card">
            <div class="card__body">
                <h3 class="card__title">Programme Info</h3>
                @if($programme['website'])
                    <a href="{{ $programme['website'] }}" target="_blank" rel="noopener noreferrer" class="btn btn--outline btn--sm" style="margin-top:8px;">Official website</a>
                @endif
            </div>
        </div>
    </aside>
</section>
@endsection
