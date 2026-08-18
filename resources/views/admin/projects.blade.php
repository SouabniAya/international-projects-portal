@extends('layouts.admin')

@section('title', 'Project Management')

@section('content')
<div class="pm-page">

    <a href="{{ url('/admin/dashboard') }}" class="pm-page__back">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 6l-6 6 6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        Back to Dashboard
    </a>

    <div class="pm-page__head">
        <div>
            <h1>Project Management</h1>
            <p>Oversee all projects, track progress, manage tasks, budgets, and deliver results.</p>
        </div>
        <a href="#" class="pm-page__btn">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
            New Project
        </a>
    </div>

    {{-- Filters --}}
    <div class="pm-filters">
        <div class="pm-filters__top">
            <div class="pm-filters__search">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                <input type="search" placeholder="Search projects...">
            </div>

            @php
            $filters = ['All Programmes', 'All Statuses', 'All Years'];
            @endphp
            @foreach($filters as $default)
            <div class="pm-filters__select">
                <span>{{ $default }}</span>
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            @endforeach

            <button type="button" class="pm-filters__reset">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 12a9 9 0 1 1 3 6.7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M3 8v5h5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Reset Filters
            </button>
            <button type="button" class="pm-filters__export">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 3v12m0 0l-4-4m4 4l4-4M5 21h14" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Export
            </button>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="pm-toolbar">
        <span class="pm-toolbar__count">Projects (36)</span>
        <div class="pm-toolbar__right">
            <label class="pm-toolbar__sort">
                <span>Sort by:</span>
                <div class="pm-toolbar__select">
                    <span>Newest First</span>
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </label>
            <div class="pm-toolbar__view">
                <button type="button" class="is-active">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="4" width="18" height="4" rx="1" stroke="currentColor" stroke-width="1.6"/><rect x="3" y="10" width="18" height="4" rx="1" stroke="currentColor" stroke-width="1.6"/><rect x="3" y="16" width="18" height="4" rx="1" stroke="currentColor" stroke-width="1.6"/></svg>
                    Table
                </button>
                <button type="button">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="3" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="1.6"/><rect x="14" y="3" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="1.6"/><rect x="3" y="14" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="1.6"/><rect x="14" y="14" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="1.6"/></svg>
                    Board
                </button>
            </div>
        </div>
    </div>

    {{-- Layout: table + sidebar --}}
    <div class="pm-layout">

        <div class="pm-table-wrap">
            <table class="pm-table">
                <thead>
                    <tr>
                        <th>Project</th>
                        <th>Programme</th>
                        <th>Partners</th>
                        <th>Coordinator</th>
                        <th>Status</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Budget</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    // Placeholder data — replace with real Project model/query later
                    $projects = [
                        ['id' => 1, 'title' => 'GreenCampus – Sustainable Universities', 'ref' => 'HE-2024-GREEN-01', 'programme' => 'Horizon Europe', 'partners' => 12, 'coordinator' => 'University of Barcelona', 'status' => 'Active', 'start' => 'Jan 1, 2025', 'end' => 'Dec 31, 2027', 'budget' => '€6,200,000', 'logo' => 'images/horizon-europe-badge.png'],
                        ['id' => 2, 'title' => 'Digital Skills for the Future', 'ref' => '2024-1-FR01-KA220-HED-000123456', 'programme' => 'Erasmus+', 'partners' => 6, 'coordinator' => 'Université Paris-Saclay', 'status' => 'In Progress', 'start' => 'Sep 1, 2024', 'end' => 'Aug 31, 2026', 'budget' => '€1,250,000', 'logo' => 'images/erasmus-badge.png'],
                        ['id' => 3, 'title' => 'AI for Sustainable Cities', 'ref' => 'MSCA-2024-PF-01', 'programme' => 'MSCA', 'partners' => 3, 'coordinator' => 'Politecnico di Milano', 'status' => 'In Progress', 'start' => 'Apr 1, 2024', 'end' => 'Mar 31, 2026', 'budget' => '€750,000', 'logo' => 'images/msca-badge.png'],
                        ['id' => 4, 'title' => 'Water Innovation Partnership', 'ref' => 'PRIMA-2023-SEC-01', 'programme' => 'PRIMA', 'partners' => 9, 'coordinator' => 'University of Melbourne', 'status' => 'Active', 'start' => 'Jul 1, 2023', 'end' => 'Jun 30, 2026', 'budget' => '€2,800,000', 'logo' => 'images/prima-badge.png'],
                        ['id' => 5, 'title' => 'Smart Mobility Solutions', 'ref' => 'NATIONAL-2024-05', 'programme' => 'National', 'partners' => 5, 'coordinator' => 'Université de Lyon', 'status' => 'Planned', 'start' => 'Jan 1, 2026', 'end' => 'Dec 31, 2028', 'budget' => '€960,000', 'logo' => 'images/national-badge.png'],
                    ];
                    @endphp

                    @foreach($projects as $project)
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
                        <td><span class="pm-table__status pm-table__status--{{ \Illuminate\Support\Str::slug($project['status']) }}">{{ $project['status'] }}</span></td>
                        <td>{{ $project['start'] }}</td>
                        <td>{{ $project['end'] }}</td>
                        <td>{{ $project['budget'] }}</td>
                        <td>
                            <div class="pm-table__actions">
                                <a href="{{ route('admin.project-details', $project['id']) }}" aria-label="View">
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.5 12S5 5 12 5s10.5 7 10.5 7-3.5 7-10.5 7-10.5-7-10.5-7Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.6"/></svg>
                                </a>
                                <button type="button" aria-label="More options">
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="5" r="1.4" fill="currentColor"/><circle cx="12" cy="12" r="1.4" fill="currentColor"/><circle cx="12" cy="19" r="1.4" fill="currentColor"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="pm-pagination">
                <span>Showing 1 to 5 of 36 projects</span>
                <div class="pm-pagination__buttons">
                    <button type="button" aria-label="Previous page">‹</button>
                    <button type="button" class="is-active">1</button>
                    <button type="button">2</button>
                    <button type="button">3</button>
                    <span>…</span>
                    <button type="button">8</button>
                    <button type="button" aria-label="Next page">›</button>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <aside class="pm-sidebar">

            <div class="pm-sidebar__panel">
                <h3>Upcoming Deadlines</h3>
                @php
                $deadlines = [
                    ['icon' => 'red', 'title' => 'GreenCampus – Deliverable D2.1', 'date' => 'May 20, 2025', 'badge' => 'In 10 days', 'badge_class' => 'urgent'],
                    ['icon' => 'orange', 'title' => 'Digital Skills – Interim Report', 'date' => 'May 30, 2025', 'badge' => 'In 20 days', 'badge_class' => 'warning'],
                    ['icon' => 'yellow', 'title' => 'AI for Sustainable Cities – Review Meeting', 'date' => 'Jun 15, 2025', 'badge' => 'In 36 days', 'badge_class' => 'ok'],
                ];
                @endphp
                <ul class="pm-sidebar__deadlines">
                    @foreach($deadlines as $d)
                    <li>
                        <span class="pm-sidebar__deadline-icon pm-sidebar__deadline-icon--{{ $d['icon'] }}">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="5" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M8 3v4M16 3v4M3 10h18" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                        </span>
                        <div>
                            <strong>{{ $d['title'] }}</strong>
                            <div class="pm-sidebar__deadline-meta">
                                <span>{{ $d['date'] }}</span>
                                <em class="pm-sidebar__badge pm-sidebar__badge--{{ $d['badge_class'] }}">{{ $d['badge'] }}</em>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
                <a href="#" class="pm-sidebar__view-all">View all deadlines →</a>
            </div>

            <div class="pm-sidebar__panel">
                <h3>Quick Actions</h3>
                @php
                $quickActions = [
                    ['icon' => 'plus', 'label' => 'Create New Project'],
                    ['icon' => 'template', 'label' => 'Project Templates'],
                    ['icon' => 'import', 'label' => 'Import Project'],
                    ['icon' => 'users', 'label' => 'Manage Templates'],
                    ['icon' => 'folder', 'label' => 'Project Categories'],
                ];
                @endphp
                <ul class="pm-sidebar__actions">
                    @foreach($quickActions as $a)
                    <li>
                        <a href="#">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                            {{ $a['label'] }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            <div class="pm-sidebar__panel">
                <h3>Reports & Analysis</h3>
                @php
                $reports = ['Project Performance Report', 'Financial Overview', 'Export Projects Data'];
                @endphp
                <ul class="pm-sidebar__actions">
                    @foreach($reports as $r)
                    <li>
                        <a href="#">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 19V5a2 2 0 0 1 2-2h9l5 5v11a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/><path d="M8 13h8M8 17h5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                            {{ $r }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

        </aside>

    </div>

</div>
@endsection