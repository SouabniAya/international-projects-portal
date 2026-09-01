@extends('layouts.admin')

@section('title', 'Mobility Management')

@php($active = 'mobility')

@section('content')
@php($lastPage = $opportunities->lastPage())
<div class="admmob-page">

    {{-- Back --}}
    <a href="{{ url('/admin/dashboard') }}" class="admmob-page__back">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 6l-6 6 6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Back to Dashboard
    </a>

    {{-- Header --}}
    <div class="admmob-page__head">
        <div>
            <h1>Mobility Management</h1>
            <p>Browse, manage and publish student and staff mobility opportunities.</p>
        </div>

        <a href="{{ route('admin.mobility.create') }}" class="admmob-page__btn">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
            </svg>
            New Mobility Opportunity
        </a>
    </div>

    {{-- Filters --}}
    <form method="GET" action="{{ route('admin.mobility') }}" class="admmob-filters">

        <div class="admmob-filters__top">

            <div class="admmob-filters__search">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/>
                    <path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
                <input type="search" name="search" value="{{ $search }}" placeholder="Search mobility opportunities...">
            </div>

            <a href="{{ route('admin.mobility') }}" class="admmob-filters__reset">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 12a9 9 0 1 1 3 6.7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                    <path d="M3 8v5h5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Reset Filters
            </a>

            <a href="{{ route('admin.mobility.export') }}" class="admmob-filters__export">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 3v12m0 0l-4-4m4 4l4-4M5 21h14" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                </svg>
                Export
            </a>

        </div>

        <div class="admmob-filters__row">

            {{-- Programme --}}
            <div class="admmob-filters__field">
                <label>Programme</label>
                <div class="admmob-filters__select">
                    <select name="programID" onchange="this.form.submit()">
                        <option value="">All Programmes</option>
                        @foreach($programmes as $p)
                            <option value="{{ $p->programID }}" @selected((string) $programID === (string) $p->programID)>
                                {{ $p->translation()?->programName ?? 'Programme #'.$p->programID }}
                            </option>
                        @endforeach
                    </select>
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </div>

            {{-- Direction --}}
            <div class="admmob-filters__field">
                <label>Direction</label>
                <div class="admmob-filters__select">
                    <select name="direction" onchange="this.form.submit()">
                        <option value="">All Directions</option>
                        <option value="Outgoing" @selected($direction === 'Outgoing')>Outgoing</option>
                        <option value="Incoming" @selected($direction === 'Incoming')>Incoming</option>
                    </select>
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </div>

            {{-- Status --}}
            <div class="admmob-filters__field">
                <label>Status</label>
                <div class="admmob-filters__select">
                    <select name="status" onchange="this.form.submit()">
                        <option value="">All Statuses</option>
                        <option value="open" @selected($status === 'open')>Open</option>
                        <option value="closed" @selected($status === 'closed')>Closed</option>
                    </select>
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </div>

            {{-- Type --}}
            <div class="admmob-filters__field">
                <label>Type</label>
                <div class="admmob-filters__select">
                    <select name="type" onchange="this.form.submit()">
                        <option value="">All Types</option>
                        <option value="outgoing_student" @selected($type === 'outgoing_student')>Outgoing Student Mobility</option>
                        <option value="incoming_student" @selected($type === 'incoming_student')>Incoming Student Mobility</option>
                        <option value="staff" @selected($type === 'staff')>Staff Mobility</option>
                        <option value="researcher" @selected($type === 'researcher')>Researcher Mobility</option>
                        <option value="internship" @selected($type === 'internship')>Internship</option>
                        <option value="summer_school" @selected($type === 'summer_school')>Summer School</option>
                        <option value="scientific_stay" @selected($type === 'scientific_stay')>Scientific Stay</option>
                        <option value="scholarship" @selected($type === 'scholarship')>Scholarship</option>
                    </select>
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </div>

            {{-- Opening Year --}}
            <div class="admmob-filters__field">
                <label>Opening Year</label>
                <div class="admmob-filters__select">
                    <select name="year" onchange="this.form.submit()">
                        <option value="">All Years</option>
                        @foreach($years as $y)
                            <option value="{{ $y }}" @selected((string) $year === (string) $y)>{{ $y }}</option>
                        @endforeach
                    </select>
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </div>

        </div>
    </form>

    {{-- Toolbar --}}
    <div class="admmob-toolbar">

        <span class="admmob-toolbar__count">
            {{ $opportunities->total() }} Mobility Opportunities
        </span>

        <div class="admmob-toolbar__right">

            <form method="GET" action="{{ route('admin.mobility') }}">
                <input type="hidden" name="search" value="{{ $search }}">
                <input type="hidden" name="programID" value="{{ $programID }}">
                <input type="hidden" name="direction" value="{{ $direction }}">
                <input type="hidden" name="status" value="{{ $status }}">
                <input type="hidden" name="type" value="{{ $type }}">
                <input type="hidden" name="year" value="{{ $year }}">
                <label class="admmob-toolbar__sort">
                    <span>Sort by:</span>
                    <div class="admmob-toolbar__select">
                        <select name="sort" onchange="this.form.submit()">
                            <option value="newest" @selected($sort === 'newest')>Newest First</option>
                            <option value="oldest" @selected($sort === 'oldest')>Oldest First</option>
                            <option value="deadline" @selected($sort === 'deadline')>Deadline</option>
                        </select>
                    </div>
                </label>
            </form>

            <div class="admmob-toolbar__view" id="admmobViewToggle">

                <button type="button" class="is-active" data-view="table">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                    Table
                </button>

                <button type="button" data-view="board">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="3" y="3" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="1.6"/>
                        <rect x="14" y="3" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="1.6"/>
                        <rect x="3" y="14" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="1.6"/>
                        <rect x="14" y="14" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="1.6"/>
                    </svg>
                    Board
                </button>

            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="admmob-table-wrap" data-admmob-view="table">

        <table class="admmob-table">

            <thead>
                <tr>
                    <th>Opportunity Title</th>
                    <th>Programme</th>
                    <th>Direction</th>
                    <th>Status</th>
                    <th>Opening Date</th>
                    <th>Deadline</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse($opportunities as $opp)

                    <tr>

                        <td>
                            <div class="admmob-table__title">
                                <img src="{{ asset('images/placeholder-thumb.png') }}" alt="">
                                <div>
                                    <strong>{{ $opp['title'] }}</strong>
                                    <span>Ref: {{ $opp['ref'] }}</span>
                                </div>
                            </div>
                        </td>

                        <td>
                            <span class="admmob-table__tag">
                                {{ $opp['programme'] }}
                            </span>
                        </td>

                        <td>
                            {{ $opp['direction'] }}
                        </td>

                        <td>
                            <span class="admmob-table__status admmob-table__status--{{ \Illuminate\Support\Str::slug($opp['status']) }}">
                                {{ $opp['status'] }}
                            </span>
                        </td>

                        <td>
                            {{ $opp['opening'] }}
                        </td>

                        <td>
                            {{ $opp['deadline'] }}
                        </td>

                        <td>
                            <div class="admmob-table__actions">
                                <a href="{{ route('admin.mobility-details', $opp['id']) }}" aria-label="View">
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1.5 12S5 5 12 5s10.5 7 10.5 7-3.5 7-10.5 7-10.5-7-10.5-7Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                                        <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.6"/>
                                    </svg>
                                </a>
                                <button type="button" aria-label="More options">
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="5" r="1.4" fill="currentColor"/>
                                        <circle cx="12" cy="12" r="1.4" fill="currentColor"/>
                                        <circle cx="12" cy="19" r="1.4" fill="currentColor"/>
                                    </svg>
                                </button>
                            </div>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px;">
                            No mobility opportunities found.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

        {{-- Pagination --}}
        <div class="admmob-pagination">

            <span>
                Showing {{ $opportunities->firstItem() ?? 0 }} to {{ $opportunities->lastItem() ?? 0 }} of {{ $opportunities->total() }} mobility opportunities
            </span>

            <div class="admmob-pagination__buttons">
                <button type="button" aria-label="Previous page" @if(!$opportunities->onFirstPage()) onclick="window.location='{{ $opportunities->previousPageUrl() }}'" @else disabled @endif>‹</button>
                @for ($p = 1; $p <= min(3, $lastPage); $p++)
                    <button type="button" class="{{ $p === $opportunities->currentPage() ? 'is-active' : '' }}" onclick="window.location='{{ $opportunities->url($p) }}'">{{ $p }}</button>
                @endfor
                @if ($lastPage > 4)
                    <span>…</span>
                    <button type="button" class="{{ $lastPage === $opportunities->currentPage() ? 'is-active' : '' }}" onclick="window.location='{{ $opportunities->url($lastPage) }}'">{{ $lastPage }}</button>
                @elseif ($lastPage === 4)
                    <button type="button" class="{{ $lastPage === $opportunities->currentPage() ? 'is-active' : '' }}" onclick="window.location='{{ $opportunities->url(4) }}'">4</button>
                @endif
                <button type="button" aria-label="Next page" @if($opportunities->hasMorePages()) onclick="window.location='{{ $opportunities->nextPageUrl() }}'" @else disabled @endif>›</button>
            </div>

        </div>

    </div>

    {{-- Board (card) view --}}
    <div class="admmob-board-wrap" data-admmob-view="board" style="display:none;">
        <div class="admmob-board">
            @forelse($opportunities as $opp)
            <div class="admmob-board__card">
                <div class="admmob-board__card-head">
                    <img src="{{ asset('images/placeholder-thumb.png') }}" alt="">
                    <span class="admmob-table__status admmob-table__status--{{ \Illuminate\Support\Str::slug($opp['status']) }}">{{ $opp['status'] }}</span>
                </div>
                <strong class="admmob-board__title">{{ $opp['title'] }}</strong>
                <span class="admmob-board__ref">Ref: {{ $opp['ref'] }}</span>
                <span class="admmob-table__tag">{{ $opp['programme'] }}</span>
                <dl class="admmob-board__meta">
                    <div><dt>Direction</dt><dd>{{ $opp['direction'] }}</dd></div>
                    <div><dt>Opening</dt><dd>{{ $opp['opening'] }}</dd></div>
                    <div><dt>Deadline</dt><dd>{{ $opp['deadline'] }}</dd></div>
                </dl>
                <a href="{{ route('admin.mobility-details', $opp['id']) }}" class="admmob-board__link">View details →</a>
            </div>
            @empty
            <p style="padding:32px; text-align:center;">No mobility opportunities found.</p>
            @endforelse
        </div>
    </div>

</div>

<script>
(function () {
    var toggle = document.getElementById('admmobViewToggle');
    if (!toggle) return;
    var tableWrap = document.querySelector('.admmob-table-wrap[data-admmob-view="table"]');
    var boardWrap = document.querySelector('.admmob-board-wrap[data-admmob-view="board"]');
    var buttons = toggle.querySelectorAll('button[data-view]');

    function setView(view) {
        buttons.forEach(function (btn) {
            btn.classList.toggle('is-active', btn.dataset.view === view);
        });
        tableWrap.style.display = view === 'table' ? '' : 'none';
        boardWrap.style.display = view === 'board' ? '' : 'none';
        try { localStorage.setItem('admmob-view', view); } catch (e) {}
    }

    buttons.forEach(function (btn) {
        btn.addEventListener('click', function () { setView(btn.dataset.view); });
    });

    var saved = null;
    try { saved = localStorage.getItem('admmob-view'); } catch (e) {}
    if (saved === 'board') setView('board');
})();
</script>
@endsection
