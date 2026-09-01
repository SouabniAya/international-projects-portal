@extends('layouts.admin')

@section('title', 'Call for Proposals Management')

@php($active = 'calls')

@section('content')
@php($lastPage = $calls->lastPage())
<div class="cfp-page">

    <a href="{{ route('admin.dashboard') }}" class="cfp-page__back">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 6l-6 6 6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        {{ __('Back to Dashboard') }}
    </a>

    <div class="cfp-page__head">
        <div>
            <h1>{{ __('Call for Proposals Management') }}</h1>
            <p>{{ __('Browse, manage and publish calls for proposals and funding opportunities.') }}</p>
        </div>
        <a href="{{ route('admin.calls.create') }}" class="cfp-page__btn">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
            {{ __('New Call for Proposals') }}
        </a>
    </div>

    {{-- Filters --}}
    <form method="GET" action="{{ route('admin.calls') }}" class="cfp-filters">
        <div class="cfp-filters__top">
            <div class="cfp-filters__search">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                <input type="search" name="search" value="{{ $search }}" placeholder="{{ __('Search calls...') }}">
            </div>
            <a href="{{ route('admin.calls') }}" class="cfp-filters__reset">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 12a9 9 0 1 1 3 6.7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M3 8v5h5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                {{ __('Reset Filters') }}
            </a>
            <a href="{{ route('admin.calls.export') }}" class="cfp-filters__export">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 3v12m0 0l-4-4m4 4l4-4M5 21h14" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                {{ __('Export') }}
            </a>
        </div>

        <div class="cfp-filters__row">
            <label class="cfp-filters__field">
                <span>{{ __('Programme') }}</span>
                <div class="cfp-filters__select">
                    <select name="programID" onchange="this.form.submit()">
                        <option value="">{{ __('All Programmes') }}</option>
                        @foreach($programmes as $p)
                            <option value="{{ $p->programID }}" @selected((string) $programID === (string) $p->programID)>
                                {{ $p->translation()?->programName ?? 'Programme #'.$p->programID }}
                            </option>
                        @endforeach
                    </select>
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </label>

            <label class="cfp-filters__field">
                <span>{{ __('Status') }}</span>
                <div class="cfp-filters__select">
                    <select name="status" onchange="this.form.submit()">
                        <option value="">{{ __('All Statuses') }}</option>
                        <option value="upcoming" @selected($status === 'upcoming')>{{ __('Upcoming') }}</option>
                        <option value="open" @selected($status === 'open')>{{ __('Open') }}</option>
                        <option value="closing_soon" @selected($status === 'closing_soon')>{{ __('Closing Soon') }}</option>
                        <option value="closed" @selected($status === 'closed')>{{ __('Closed') }}</option>
                    </select>
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </label>

            {{--
                "Call Type" / "Thematic Area" / "Opening Year" — kept as
                display-only fields, same as they were before: no backing
                filter exists in the controller for these (CallForProposal
                has no thematic-area concept, and the year filter wasn't
                part of what was rebuilt here). Not a regression — they
                were already non-functional placeholders in the original
                design. Tell me if you want these wired for real too.
            --}}
            <label class="cfp-filters__field">
                <span>{{ __('Call Type') }}</span>
                <div class="cfp-filters__select">
                    <span>{{ __('All Types') }}</span>
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </label>
            <label class="cfp-filters__field">
                <span>{{ __('Thematic Area') }}</span>
                <div class="cfp-filters__select">
                    <span>{{ __('All Areas') }}</span>
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </label>
            <label class="cfp-filters__field">
                <span>{{ __('Opening Year') }}</span>
                <div class="cfp-filters__select">
                    <span>{{ __('All Years') }}</span>
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </label>
        </div>
    </form>

    {{-- Toolbar --}}
    <div class="cfp-toolbar">
        <span class="cfp-toolbar__count">{{ $calls->total() }} {{ __('Calls for Proposals') }}</span>
        <div class="cfp-toolbar__right">
            <form method="GET" action="{{ route('admin.calls') }}">
                <input type="hidden" name="search" value="{{ $search }}">
                <input type="hidden" name="programID" value="{{ $programID }}">
                <input type="hidden" name="status" value="{{ $status }}">
                <label class="cfp-toolbar__sort">
                    <span>{{ __('Sort by:') }}</span>
                    <div class="cfp-toolbar__select">
                        <select name="sort" onchange="this.form.submit()">
                            <option value="newest" @selected($sort === 'newest')>{{ __('Newest First') }}</option>
                            <option value="oldest" @selected($sort === 'oldest')>{{ __('Oldest First') }}</option>
                            <option value="deadline" @selected($sort === 'deadline')>{{ __('Deadline') }}</option>
                            <option value="title" @selected($sort === 'title')>{{ __('ID') }}</option>
                        </select>
                    </div>
                </label>
            </form>
            <div class="cfp-toolbar__view" id="cfpViewToggle">
                <button type="button" class="is-active" data-view="table">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                    {{ __('Table') }}
                </button>
                <button type="button" data-view="board">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="4" width="7" height="16" rx="1.5" stroke="currentColor" stroke-width="1.6"/><rect x="14" y="4" width="7" height="16" rx="1.5" stroke="currentColor" stroke-width="1.6"/></svg>
                    {{ __('Board') }}
                </button>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="cfp-table-wrap" data-cfp-view="table">
        <table class="cfp-table">
            <thead>
                <tr>
                    <th>{{ __('Call Title') }}</th>
                    <th>{{ __('Programme') }}</th>
                    <th>{{ __('Type') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Opening Date') }}</th>
                    <th>{{ __('Deadline') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($calls as $call)
                <tr>
                    <td>
                        <div class="cfp-table__call">
                            <img src="{{ asset($call['flag']) }}" alt="" class="cfp-table__flag">
                            <div>
                                <strong>{{ $call['title'] }}</strong>
                                <span>{{ __('Ref:') }} {{ $call['ref'] }}</span>
                            </div>
                        </div>
                    </td>
                    <td><span class="cfp-table__tag">{{ $call['programme'] }}</span></td>
                    <td>{{ $call['type'] }}</td>
                    <td><span class="cfp-table__status cfp-table__status--{{ \Illuminate\Support\Str::slug($call['status']) }}">{{ $call['status'] }}</span></td>
                    <td>{{ $call['opening'] }}</td>
                    <td class="cfp-table__deadline">{{ $call['deadline'] }}</td>
                    <td>
                        <div class="cfp-table__actions">
                            <a href="{{ route('admin.call-details', $call['id']) }}" aria-label="{{ __('View') }}">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.5 12S5 5 12 5s10.5 7 10.5 7-3.5 7-10.5 7-10.5-7-10.5-7Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.6"/></svg>
                            </a>
                            <button type="button" aria-label="{{ __('More options') }}">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="5" r="1.4" fill="currentColor"/><circle cx="12" cy="12" r="1.4" fill="currentColor"/><circle cx="12" cy="19" r="1.4" fill="currentColor"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" style="text-align:center; padding:32px;">{{ __('No calls found.') }}</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="cfp-pagination">
            <span>{{ __('Showing :from to :to of :total calls', ['from' => $calls->firstItem() ?? 0, 'to' => $calls->lastItem() ?? 0, 'total' => $calls->total()]) }}</span>
            <div class="cfp-pagination__buttons">
                <button type="button" aria-label="{{ __('Previous page') }}" @if(!$calls->onFirstPage()) onclick="window.location='{{ $calls->previousPageUrl() }}'" @else disabled @endif>&lsaquo;</button>
                @for ($p = 1; $p <= min(3, $lastPage); $p++)
                    <button type="button" class="{{ $p === $calls->currentPage() ? 'is-active' : '' }}" onclick="window.location='{{ $calls->url($p) }}'">{{ $p }}</button>
                @endfor
                @if ($lastPage > 4)
                    <span>…</span>
                    <button type="button" class="{{ $lastPage === $calls->currentPage() ? 'is-active' : '' }}" onclick="window.location='{{ $calls->url($lastPage) }}'">{{ $lastPage }}</button>
                @elseif ($lastPage === 4)
                    <button type="button" class="{{ $lastPage === $calls->currentPage() ? 'is-active' : '' }}" onclick="window.location='{{ $calls->url(4) }}'">4</button>
                @endif
                <button type="button" aria-label="{{ __('Next page') }}" @if($calls->hasMorePages()) onclick="window.location='{{ $calls->nextPageUrl() }}'" @else disabled @endif>&rsaquo;</button>
            </div>
        </div>
    </div>

    {{-- Board (card) view --}}
    <div class="cfp-board-wrap" data-cfp-view="board" style="display:none;">
        <div class="cfp-board">
            @forelse ($calls as $call)
            <div class="cfp-board__card">
                <div class="cfp-board__card-head">
                    <img src="{{ asset($call['flag']) }}" alt="">
                    <span class="cfp-table__status cfp-table__status--{{ \Illuminate\Support\Str::slug($call['status']) }}">{{ $call['status'] }}</span>
                </div>
                <strong class="cfp-board__title">{{ $call['title'] }}</strong>
                <span class="cfp-board__ref">{{ __('Ref:') }} {{ $call['ref'] }}</span>
                <span class="cfp-table__tag">{{ $call['programme'] }}</span>
                <dl class="cfp-board__meta">
                    <div><dt>{{ __('Type') }}</dt><dd>{{ $call['type'] }}</dd></div>
                    <div><dt>{{ __('Opening') }}</dt><dd>{{ $call['opening'] }}</dd></div>
                    <div><dt>{{ __('Deadline') }}</dt><dd>{{ $call['deadline'] }}</dd></div>
                </dl>
                <a href="{{ route('admin.call-details', $call['id']) }}" class="cfp-board__link">{{ __('View details') }} →</a>
            </div>
            @empty
            <p style="padding:32px; text-align:center;">{{ __('No calls found.') }}</p>
            @endforelse
        </div>
    </div>

</div>

<script>
(function () {
    var toggle = document.getElementById('cfpViewToggle');
    if (!toggle) return;
    var tableWrap = document.querySelector('.cfp-table-wrap[data-cfp-view="table"]');
    var boardWrap = document.querySelector('.cfp-board-wrap[data-cfp-view="board"]');
    var buttons = toggle.querySelectorAll('button[data-view]');

    function setView(view) {
        buttons.forEach(function (btn) {
            btn.classList.toggle('is-active', btn.dataset.view === view);
        });
        tableWrap.style.display = view === 'table' ? '' : 'none';
        boardWrap.style.display = view === 'board' ? '' : 'none';
        try { localStorage.setItem('cfp-calls-view', view); } catch (e) {}
    }

    buttons.forEach(function (btn) {
        btn.addEventListener('click', function () { setView(btn.dataset.view); });
    });

    var saved = null;
    try { saved = localStorage.getItem('cfp-calls-view'); } catch (e) {}
    if (saved === 'board') setView('board');
})();
</script>
@endsection
