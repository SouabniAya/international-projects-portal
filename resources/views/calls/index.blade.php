@extends('layouts.app')

@section('title', 'Calls for Proposals')

@section('content')
<div class="cd-page">

    <h1 class="cd-page__title">Calls for Proposals</h1>

    {{-- Filters --}}
    <form method="GET" action="{{ route('calls.index') }}" class="cd-filters">
        <div class="cd-filters__search">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Search a call by title...">
        </div>

        <select name="status" onchange="this.form.submit()">
            <option value="">All statuses</option>
            @foreach(['open' => 'Open', 'upcoming' => 'Upcoming', 'closing_soon' => 'Closing Soon', 'closed' => 'Closed'] as $value => $label)
                <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
            @endforeach
        </select>

        <select name="programID" onchange="this.form.submit()">
            <option value="">All programmes</option>
            @foreach($programmes as $programme)
                @continue(!$programme->translation())
                <option value="{{ $programme->programID }}" @selected((int) request('programID') === $programme->programID)>
                    {{ $programme->translation()->programName }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="cd-page__btn cd-page__btn--outline">Filter</button>
    </form>

    {{-- Results --}}
    <div class="cd-calls-grid">
        @forelse($calls as $call)
            @php($t = $call->translation())
            @continue(!$t)
            <a href="{{ route('calls.show', $call) }}" class="cd-call-card">
                <div class="cd-tags">
                    @if($call->fundingProgramme && $call->fundingProgramme->translation())
                        <span class="cd-tags__pill cd-tags__pill--programme">{{ $call->fundingProgramme->translation()->programName }}</span>
                    @endif
                    <span class="cd-tags__pill cd-tags__pill--status">{{ $call->status_label }}</span>
                </div>

                <h3 class="cd-call-card__title">{{ $t->title }}</h3>

                @if($t->description)
                    <p class="cd-call-card__excerpt">{{ Str::limit(strip_tags($t->description), 140) }}</p>
                @endif

                <div class="cd-call-card__meta">
                    <span>Deadline: {{ $call->deadline->format('M d, Y') }}</span>
                    @if($call->budget_label)
                        <span>Budget: {{ $call->budget_label }}</span>
                    @endif
                </div>
            </a>
        @empty
            <p class="cd-empty-state">No calls for proposals match your search.</p>
        @endforelse
    </div>

    <div class="cd-pagination">
        {{ $calls->links() }}
    </div>

</div>
@endsection