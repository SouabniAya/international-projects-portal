@extends('layouts.admin')

@section('title', 'Project Management')

@section('content')
@php($lastPage = $projects->lastPage())
<div class="pm-page">

    <a href="{{ url('/admin/dashboard') }}" class="pm-page__back">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 6l-6 6 6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        {{ __('Back to Dashboard') }}
    </a>

    <div class="pm-page__head">
        <div>
            <h1>{{ __('Project Management') }}</h1>
            <p>{{ __('Oversee all projects, track progress, manage tasks, budgets, and deliver results.') }}</p>
        </div>
        <a href="{{ route('admin.projects.create') }}" class="pm-page__btn">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
            {{ __('New Project') }}
        </a>
    </div>

    {{-- Filters --}}
    <form method="GET" action="{{ route('admin.projects') }}" class="pm-filters">
        <div class="pm-filters__top">
            <div class="pm-filters__search">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                <input type="search" name="search" value="{{ $search }}" placeholder="{{ __('Search projects...') }}">
            </div>

            <label class="pm-filters__select">
                <select name="programID" onchange="this.form.submit()">
                    <option value="">{{ __('All Programmes') }}</option>
                    @foreach($programmes as $p)
                        <option value="{{ $p->programID }}" @selected((string) $programID === (string) $p->programID)>
                            {{ $p->translation()?->programName ?? __('Programme #').$p->programID }}
                        </option>
                    @endforeach
                </select>
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </label>

            <label class="pm-filters__select">
                <select name="status" onchange="this.form.submit()">
                    <option value="">{{ __('All Statuses') }}</option>
                    <option value="proposed" @selected($status === 'proposed')>{{ __('Proposed') }}</option>
                    <option value="ongoing" @selected($status === 'ongoing')>{{ __('Ongoing') }}</option>
                    <option value="completed" @selected($status === 'completed')>{{ __('Completed') }}</option>
                </select>
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </label>

            <label class="pm-filters__select">
                <select name="year" onchange="this.form.submit()">
                    <option value="">{{ __('All Years') }}</option>
                    @foreach($years as $y)
                        <option value="{{ $y }}" @selected((string) $year === (string) $y)>{{ $y }}</option>
                    @endforeach
                </select>
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </label>

            <a href="{{ route('admin.projects') }}" class="pm-filters__reset">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 12a9 9 0 1 1 3 6.7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M3 8v5h5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                {{ __('Reset Filters') }}
            </a>
            <a href="{{ route('admin.projects.export') }}" class="pm-filters__export">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 3v12m0 0l-4-4m4 4l4-4M5 21h14" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                {{ __('Export') }}
            </a>
        </div>
    </form>

    {{-- Toolbar --}}
    <div class="pm-toolbar">
        <span class="pm-toolbar__count">{{ __('Projects (:count)', ['count' => $projects->total()]) }}</span>
        <div class="pm-toolbar__right">
            <form method="GET" action="{{ route('admin.projects') }}">
                <input type="hidden" name="search" value="{{ $search }}">
                <input type="hidden" name="programID" value="{{ $programID }}">
                <input type="hidden" name="status" value="{{ $status }}">
                <input type="hidden" name="year" value="{{ $year }}">
                <label class="pm-toolbar__sort">
                    <span>{{ __('Sort by:') }}</span>
                    <div class="pm-toolbar__select">
                        <select name="sort" onchange="this.form.submit()">
                            <option value="newest" @selected($sort === 'newest')>{{ __('Newest First') }}</option>
                            <option value="oldest" @selected($sort === 'oldest')>{{ __('Oldest First') }}</option>
                            <option value="deadline" @selected($sort === 'deadline')>{{ __('End Date') }}</option>
                            <option value="title" @selected($sort === 'title')>{{ __('Title') }}</option>
                        </select>
                    </div>
                </label>
            </form>
            <div class="pm-toolbar__view" id="pmViewToggle">
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

    {{-- Layout: table/board + sidebar --}}
    <div class="pm-layout">

        <div class="pm-table-wrap" data-pm-view="table">
            <table class="pm-table">
                <thead>
                    <tr>
                        <th>{{ __('Project') }}</th>
                        <th>{{ __('Programme') }}</th>
                        <th>{{ __('Partners') }}</th>
                        <th>{{ __('Coordinator') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Start Date') }}</th>
                        <th>{{ __('End Date') }}</th>
                        <th>{{ __('Budget') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($projects as $project)
                    <tr>
                        <td>
                            <div class="pm-table__project">
                                <img src="{{ asset($project['logo']) }}" alt="">
                                <div>
                                    <strong>{{ $project['title'] }}</strong>
                                    <span>{{ $project['ref'] }}</span>
                                </div>
                            </div>
                        </td>
                        <td><span class="pm-table__tag pm-table__tag--{{ \Illuminate\Support\Str::slug($project['programme']) }}">{{ $project['programme'] }}</span></td>
                        <td>{{ $project['partners'] }}</td>
                        <td>{{ $project['coordinator'] }}</td>
                        <td><span class="pm-table__status pm-table__status--{{ \Illuminate\Support\Str::slug($project['status']) }}">{{ __($project['status']) }}</span></td>
                        <td>{{ $project['start'] }}</td>
                        <td>{{ $project['end'] }}</td>
                        <td>{{ $project['budget'] }}</td>
                        <td>
                            <div class="pm-table__actions">
                                <a href="{{ route('admin.project-details', $project['projectID']) }}" aria-label="{{ __('View') }}">
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.5 12S5 5 12 5s10.5 7 10.5 7-3.5 7-10.5 7-10.5-7-10.5-7Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.6"/></svg>
                                </a>
                                <button type="button" aria-label="{{ __('More options') }}">
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="5" r="1.4" fill="currentColor"/><circle cx="12" cy="12" r="1.4" fill="currentColor"/><circle cx="12" cy="19" r="1.4" fill="currentColor"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" style="text-align:center; padding:32px;">{{ __('No projects yet.') }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="pm-pagination">
                <span>{{ __('Showing :from to :to of :total projects', ['from' => $projects->firstItem() ?? 0, 'to' => $projects->lastItem() ?? 0, 'total' => $projects->total()]) }}</span>
                <div class="pm-pagination__buttons">
                    <button type="button" aria-label="{{ __('Previous page') }}" @if(!$projects->onFirstPage()) onclick="window.location='{{ $projects->previousPageUrl() }}'" @else disabled @endif>‹</button>
                    @for ($p = 1; $p <= min(3, $lastPage); $p++)
                        <button type="button" class="{{ $p === $projects->currentPage() ? 'is-active' : '' }}" onclick="window.location='{{ $projects->url($p) }}'">{{ $p }}</button>
                    @endfor
                    @if ($lastPage > 4)
                        <span>…</span>
                        <button type="button" class="{{ $lastPage === $projects->currentPage() ? 'is-active' : '' }}" onclick="window.location='{{ $projects->url($lastPage) }}'">{{ $lastPage }}</button>
                    @elseif ($lastPage === 4)
                        <button type="button" class="{{ $lastPage === $projects->currentPage() ? 'is-active' : '' }}" onclick="window.location='{{ $projects->url(4) }}'">4</button>
                    @endif
                    <button type="button" aria-label="{{ __('Next page') }}" @if($projects->hasMorePages()) onclick="window.location='{{ $projects->nextPageUrl() }}'" @else disabled @endif>›</button>
                </div>
            </div>
        </div>

        {{-- Board (card) view --}}
        <div class="pm-board-wrap" data-pm-view="board" style="display:none;">
            <div class="pm-board">
                @forelse($projects as $project)
                <div class="pm-board__card">
                    <div class="pm-board__card-head">
                        <img src="{{ asset($project['logo']) }}" alt="">
                        <span class="pm-table__status pm-table__status--{{ \Illuminate\Support\Str::slug($project['status']) }}">{{ __($project['status']) }}</span>
                    </div>
                    <strong class="pm-board__title">{{ $project['title'] }}</strong>
                    <span class="pm-board__ref">{{ $project['ref'] }}</span>
                    <span class="pm-table__tag pm-table__tag--{{ \Illuminate\Support\Str::slug($project['programme']) }}">{{ $project['programme'] }}</span>
                    <dl class="pm-board__meta">
                        <div><dt>{{ __('Coordinator') }}</dt><dd>{{ $project['coordinator'] }}</dd></div>
                        <div><dt>{{ __('Partners') }}</dt><dd>{{ $project['partners'] }}</dd></div>
                        <div><dt>{{ __('Period') }}</dt><dd>{{ $project['start'] }} – {{ $project['end'] }}</dd></div>
                        <div><dt>{{ __('Budget') }}</dt><dd>{{ $project['budget'] }}</dd></div>
                    </dl>
                    <a href="{{ route('admin.project-details', $project['projectID']) }}" class="pm-board__link">{{ __('View details') }} →</a>
                </div>
                @empty
                <p style="padding:32px; text-align:center;">{{ __('No projects yet.') }}</p>
                @endforelse
            </div>

            <div class="pm-pagination">
                <span>{{ __('Showing :from to :to of :total projects', ['from' => $projects->firstItem() ?? 0, 'to' => $projects->lastItem() ?? 0, 'total' => $projects->total()]) }}</span>
                <div class="pm-pagination__buttons">
                    <button type="button" aria-label="{{ __('Previous page') }}" @if(!$projects->onFirstPage()) onclick="window.location='{{ $projects->previousPageUrl() }}'" @else disabled @endif>‹</button>
                    @for ($p = 1; $p <= min(3, $lastPage); $p++)
                        <button type="button" class="{{ $p === $projects->currentPage() ? 'is-active' : '' }}" onclick="window.location='{{ $projects->url($p) }}'">{{ $p }}</button>
                    @endfor
                    @if ($lastPage > 4)
                        <span>…</span>
                        <button type="button" class="{{ $lastPage === $projects->currentPage() ? 'is-active' : '' }}" onclick="window.location='{{ $projects->url($lastPage) }}'">{{ $lastPage }}</button>
                    @elseif ($lastPage === 4)
                        <button type="button" class="{{ $lastPage === $projects->currentPage() ? 'is-active' : '' }}" onclick="window.location='{{ $projects->url(4) }}'">4</button>
                    @endif
                    <button type="button" aria-label="{{ __('Next page') }}" @if($projects->hasMorePages()) onclick="window.location='{{ $projects->nextPageUrl() }}'" @else disabled @endif>›</button>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <aside class="pm-sidebar">

            <div class="pm-sidebar__panel">
                <h3>{{ __('Upcoming Deadlines') }}</h3>
                <p style="font-family:var(--font-body); font-size:13px; color:var(--color-neutral-500); padding:8px 0;">
                    {{ __('Deadline tracking isn\'t set up yet — no deliverable/milestone data exists in the system.') }}
                </p>
            </div>

            <div class="pm-sidebar__panel">
                <h3>{{ __('Quick Actions') }}</h3>
                <ul class="pm-sidebar__actions">
                    <li>
                        <a href="{{ route('admin.projects.create') }}">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                            {{ __('Create New Project') }}
                        </a>
                    </li>
                </ul>
            </div>

            <div class="pm-sidebar__panel">
                <h3>{{ __('Reports & Analysis') }}</h3>
                <ul class="pm-sidebar__actions">
                    <li>
                        <a href="{{ route('admin.projects.export') }}">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 19V5a2 2 0 0 1 2-2h9l5 5v11a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/><path d="M8 13h8M8 17h5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                            {{ __('Export Projects Data') }}
                        </a>
                    </li>
                </ul>
            </div>

        </aside>

    </div>

</div>

<script>
(function () {
    var toggle = document.getElementById('pmViewToggle');
    if (!toggle) return;
    var tableWrap = document.querySelector('.pm-table-wrap[data-pm-view="table"]');
    var boardWrap = document.querySelector('.pm-board-wrap[data-pm-view="board"]');
    var buttons = toggle.querySelectorAll('button[data-view]');

    function setView(view) {
        buttons.forEach(function (btn) {
            btn.classList.toggle('is-active', btn.dataset.view === view);
        });
        tableWrap.style.display = view === 'table' ? '' : 'none';
        boardWrap.style.display = view === 'board' ? '' : 'none';
        try { localStorage.setItem('pm-projects-view', view); } catch (e) {}
    }

    buttons.forEach(function (btn) {
        btn.addEventListener('click', function () { setView(btn.dataset.view); });
    });

    var saved = null;
    try { saved = localStorage.getItem('pm-projects-view'); } catch (e) {}
    if (saved === 'board') setView('board');
})();
</script>
@endsection