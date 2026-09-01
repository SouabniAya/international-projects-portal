@extends('layouts.admin')



@section('title', 'Agreement Management')

@php($active = 'agreements')

@section('content')
@php($lastPage = $agreements->lastPage())
<div class="agr-page">

    <a href="{{ url('/admin/dashboard') }}" class="agr-page__back">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 6l-6 6 6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        {{ __('Back to Dashboard') }}
    </a>

    <div class="agr-page__head">
        <div>
            <h1>{{ __('Agreement Management') }}</h1>
            <p>{{ __('Manage institutional agreements and cooperation frameworks.') }}</p>
        </div>
        <a href="{{ route('admin.agreements.create') }}" class="agr-page__btn">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
            {{ __('New Agreement') }}
        </a>
    </div>

    {{-- Filters — wired to AgreementController@index's real query params
         (search, partnerID, type, status, sort). "Country/Region" and
         "Domain of Cooperation" were decorative fields with no backend
         support behind them (agreements aren't classified by domain, only
         partners are) — dropped rather than left as dead selects. Tell me
         if you want those added; they'd filter through the partner's
         country/CooperatesIn like partner-management.blade.php does. --}}
    <form method="GET" action="{{ route('admin.agreements') }}" class="agr-filters">
        <div class="agr-filters__search">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            <input type="search" name="search" value="{{ request('search') }}" placeholder="{{ __('Search agreements...') }}">
        </div>

        <div class="agr-filters__row">
            <div class="agr-filters__field">
                <label>{{ __('Partner') }}</label>
                <div class="agr-filters__select">
                    <select name="partnerID" onchange="this.form.submit()">
                        <option value="">{{ __('All Partners') }}</option>
                        @foreach($partners as $p)
                            <option value="{{ $p->partnerID }}" @selected((string) request('partnerID') === (string) $p->partnerID)>
                                {{ $p->partnerName }}
                            </option>
                        @endforeach
                    </select>
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </div>

            <div class="agr-filters__field">
                <label>{{ __('Type of Agreement') }}</label>
                <div class="agr-filters__select">
                    <select name="type" onchange="this.form.submit()">
                        <option value="">{{ __('All Types') }}</option>
                        @foreach($types as $t)
                            <option value="{{ $t }}" @selected(request('type') === $t)>{{ $t }}</option>
                        @endforeach
                    </select>
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </div>

            <div class="agr-filters__field">
                <label>{{ __('Status') }}</label>
                <div class="agr-filters__select">
                    <select name="status" onchange="this.form.submit()">
                        <option value="">{{ __('All Statuses') }}</option>
                        <option value="active" @selected(request('status') === 'active')>{{ __('Active') }}</option>
                        <option value="expired" @selected(request('status') === 'expired')>{{ __('Expired') }}</option>
                    </select>
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </div>

            <div class="agr-filters__field">
                <label>{{ __('Sort by') }}</label>
                <div class="agr-filters__select">
                    <select name="sort" onchange="this.form.submit()">
                        <option value="" @selected(!request('sort'))>{{ __('Newest start date') }}</option>
                        <option value="oldest" @selected(request('sort') === 'oldest')>{{ __('Oldest start date') }}</option>
                        <option value="end_asc" @selected(request('sort') === 'end_asc')>{{ __('End date (soonest)') }}</option>
                        <option value="end_desc" @selected(request('sort') === 'end_desc')>{{ __('End date (latest)') }}</option>
                    </select>
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </div>

            <div class="agr-filters__actions">
                <a href="{{ route('admin.agreements') }}" class="agr-filters__reset">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 12a9 9 0 1 1 3 6.7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M3 8v5h5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    {{ __('Reset Filters') }}
                </a>
                <a href="{{ route('admin.agreements.export') }}" class="agr-filters__export">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 3v12m0 0l-4-4m4 4l4-4M5 21h14" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    {{ __('Export') }}
                </a>
            </div>
        </div>
    </form>


    {{-- Stat cards --}}
    <div class="agr-stats">
        @foreach($stats as $stat)
        <div class="agr-stat-card">
            <span class="agr-stat-card__icon agr-stat-card__icon--{{ $stat['color'] }}">
                @switch($stat['icon'])
                    @case('doc')
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 2h9l5 5v13a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M14 2v6h6" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                        @break
                    @case('handshake')
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2 12l5-5 4 3 3-3 5 5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M6 14l3 3 2-2M14 15l2 2 3-3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        @break
                    @case('clock')
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/><path d="M12 7v5l3 3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        @break
                    @case('calendar-check')
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="5" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M8 3v4M16 3v4M3 10h18" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M9 15l2 2 4-4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        @break
                    @case('pencil')
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="5" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M8 3v4M16 3v4M3 10h18" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M13.5 14.5l2 2L20 12l-2-2-4.5 4.5Z" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/></svg>
                        @break
                @endswitch
            </span>
            <div class="agr-stat-card__body">
                <strong>{{ $stat['value'] }}</strong>
                <span>{{ __($stat['label']) }} @if(isset($stat['sub']))<em>{{ __($stat['sub']) }}</em>@endif</span>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Toolbar --}}
    <div class="agr-toolbar">
        <span class="agr-toolbar__count">{{ __(':count Agreements found', ['count' => $agreements->total()]) }}</span>
        <div class="agr-toolbar__right">
            <label class="agr-toolbar__sort">
                <span>{{ __('Sort by:') }}</span>
                <div class="agr-toolbar__select">
                    <span>{{ __('Newest First') }}</span>
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </label>
            <div class="agr-toolbar__view" id="agrViewToggle">
                <button type="button" class="is-active" data-view="table">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="4" width="18" height="4" rx="1" stroke="currentColor" stroke-width="1.6"/><rect x="3" y="10" width="18" height="4" rx="1" stroke="currentColor" stroke-width="1.6"/><rect x="3" y="16" width="18" height="4" rx="1" stroke="currentColor" stroke-width="1.6"/></svg>
                    {{ __('Table') }}
                </button>
                <button type="button" data-view="board">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="3" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="1.6"/><rect x="14" y="3" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="1.6"/><rect x="3" y="14" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="1.6"/><rect x="14" y="14" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="1.6"/></svg>
                    {{ __('Board') }}
                </button>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="agr-table-wrap" data-agr-view="table">
        <table class="agr-table">
            <thead>
                <tr>
                    <th>{{ __('Agreement Title') }}</th>
                    <th>{{ __('Partner') }}</th>
                    <th>{{ __('Country') }}</th>
                    <th>{{ __('Type') }}</th>
                    <th>{{ __('Domain of Cooperation') }}</th>
                    <th>{{ __('Start Date') }}</th>
                    <th>{{ __('End Date') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($agreements as $agreement)
                <tr>
                    <td>
                        <div class="agr-table__title">
                            <strong>{{ __($agreement['title']) }}</strong>
                            <span>{{ __('Ref:') }} {{ $agreement['ref'] }}</span>
                        </div>
                    </td>
                    <td>
                        <div class="agr-table__partner">
                            <img src="{{ asset($agreement['logo']) }}" alt="">
                            <span>{{ $agreement['partner'] }}</span>
                        </div>
                    </td>
                    <td>
                        <div class="agr-table__country">
                            <img src="{{ asset($agreement['flag']) }}" alt="">
                            <span>{{ __($agreement['country']) }}</span>
                        </div>
                    </td>
                    <td><span class="agr-table__tag agr-table__tag--{{ \Illuminate\Support\Str::slug($agreement['type']) }}">{{ __($agreement['type']) }}</span></td>
                    <td>{{ __($agreement['domain']) }}</td>
                    <td>{{ $agreement['start'] }}</td>
                    <td>{{ $agreement['end'] }}</td>
                    <td><span class="agr-table__status agr-table__status--{{ \Illuminate\Support\Str::slug($agreement['status']) }}">{{ __($agreement['status']) }}</span></td>
                    <td>
                        <div class="agr-table__actions">
                            <a href="{{ route('admin.agreement-details', $agreement['id']) }}" aria-label="{{ __('View') }}">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.5 12S5 5 12 5s10.5 7 10.5 7-3.5 7-10.5 7-10.5-7-10.5-7Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.6"/></svg>
                            </a>
                            <button type="button" aria-label="{{ __('More options') }}">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="5" r="1.4" fill="currentColor"/><circle cx="12" cy="19" r="1.4" fill="currentColor"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="text-align:center; padding:32px;">No agreements yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="agr-pagination">
            <span>{{ __('Showing :from to :to of :total agreements', ['from' => $agreements->firstItem() ?? 0, 'to' => $agreements->lastItem() ?? 0, 'total' => $agreements->total()]) }}</span>
            <div class="agr-pagination__buttons">
                <button type="button" aria-label="{{ __('Previous page') }}" @if(!$agreements->onFirstPage()) onclick="window.location='{{ $agreements->previousPageUrl() }}'" @else disabled @endif>‹</button>
                @for ($p = 1; $p <= min(5, $lastPage); $p++)
                    <button type="button" class="{{ $p === $agreements->currentPage() ? 'is-active' : '' }}" onclick="window.location='{{ $agreements->url($p) }}'">{{ $p }}</button>
                @endfor
                @if ($lastPage > 6)
                    <span>…</span>
                    <button type="button" class="{{ $lastPage === $agreements->currentPage() ? 'is-active' : '' }}" onclick="window.location='{{ $agreements->url($lastPage) }}'">{{ $lastPage }}</button>
                @elseif ($lastPage === 6)
                    <button type="button" class="{{ $lastPage === $agreements->currentPage() ? 'is-active' : '' }}" onclick="window.location='{{ $agreements->url(6) }}'">6</button>
                @endif
                <button type="button" aria-label="{{ __('Next page') }}" @if($agreements->hasMorePages()) onclick="window.location='{{ $agreements->nextPageUrl() }}'" @else disabled @endif>›</button>
            </div>
        </div>
    </div>

    {{-- Board (card) view — same $agreements collection, alternate layout.
         The toggle button above still says "Calendar" (kept as-is, not my
         call to rename it), but what it switches to is a card/board view —
         same pattern as Projects/Calls/Mobility. A literal calendar/date
         grid would be a different, bigger build; say the word if that's
         actually what's wanted instead. --}}
    <div class="agr-board-wrap" data-agr-view="board" style="display:none;">
        <div class="agr-board">
            @forelse($agreements as $agreement)
            <div class="agr-board__card">
                <div class="agr-board__card-head">
                    <img src="{{ asset($agreement['logo']) }}" alt="">
                    <span class="agr-table__status agr-table__status--{{ \Illuminate\Support\Str::slug($agreement['status']) }}">{{ __($agreement['status']) }}</span>
                </div>
                <strong class="agr-board__title">{{ __($agreement['title']) }}</strong>
                <span class="agr-board__ref">{{ __('Ref:') }} {{ $agreement['ref'] }}</span>
                <span class="agr-table__tag agr-table__tag--{{ \Illuminate\Support\Str::slug($agreement['type']) }}">{{ __($agreement['type']) }}</span>
                <dl class="agr-board__meta">
                    <div>
                        <dt>{{ __('Partner') }}</dt>
                        <dd>
                            <img src="{{ asset($agreement['flag']) }}" alt="" style="width:16px;height:12px;vertical-align:middle;margin-right:4px;">
                            {{ $agreement['partner'] }}
                        </dd>
                    </div>
                    <div><dt>{{ __('Country') }}</dt><dd>{{ __($agreement['country']) }}</dd></div>
                    <div><dt>{{ __('Period') }}</dt><dd>{{ $agreement['start'] }} – {{ $agreement['end'] }}</dd></div>
                </dl>
                <a href="{{ route('admin.agreement-details', $agreement['id']) }}" class="agr-board__link">{{ __('View details') }} →</a>
            </div>
            @empty
            <p style="padding:32px; text-align:center;">{{ __('No agreements found.') }}</p>
            @endforelse
        </div>
    </div>

</div>

<script>
(function () {
    var toggle = document.getElementById('agrViewToggle');
    if (!toggle) return;
    var tableWrap = document.querySelector('.agr-table-wrap[data-agr-view="table"]');
    var boardWrap = document.querySelector('.agr-board-wrap[data-agr-view="board"]');
    var buttons = toggle.querySelectorAll('button[data-view]');

    function setView(view) {
        buttons.forEach(function (btn) {
            btn.classList.toggle('is-active', btn.dataset.view === view);
        });
        tableWrap.style.display = view === 'table' ? '' : 'none';
        boardWrap.style.display = view === 'board' ? '' : 'none';
        try { localStorage.setItem('agr-view', view); } catch (e) {}
    }

    buttons.forEach(function (btn) {
        btn.addEventListener('click', function () { setView(btn.dataset.view); });
    });

    var saved = null;
    try { saved = localStorage.getItem('agr-view'); } catch (e) {}
    if (saved === 'board') setView('board');
})();
</script>
@endsection