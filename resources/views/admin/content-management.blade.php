{{-- resources/views/admin/content-management.blade.php — UC3, FR-13.1 to FR-13.5 --}}
@extends('layouts.admin')

@section('title', 'Content Management')

@php($active = 'cooperation')

@section('content')

<div class="section__header section__header--row" style="margin-bottom:8px;">
    <div>
        <h2 style="margin:0;">Content Management</h2>
        <p style="margin:4px 0 0;">Create, edit, and publish content across the portal.</p>
    </div>
    <button type="button" class="btn btn--primary btn--sm" data-modal-open="newContentModal">+ New Content</button>
</div>
<p style="margin:0 0 20px; font-family:var(--font-body); font-size:12.5px;">
    Prefer a full page? <a href="{{ url('/admin/content/create') }}" style="color:var(--color-cerulean);">Use the dedicated Publish Content page →</a>
</p>

{{-- Content type tabs (client-side only for now — each should filter by content_type once backend exists) --}}
<div class="flex-row" style="margin-bottom:20px; border-bottom:1px solid var(--color-neutral-300); padding-bottom:12px;">
    @foreach (['Homepage', 'Partnerships', 'Projects', 'Funding', 'Mobility', 'News', 'Events', 'Documents', 'FAQ', 'Contact'] as $i => $tab)
    <a href="#" class="btn {{ $i === 0 ? 'btn--primary' : 'btn--outline' }} btn--sm">{{ $tab }}</a>
    @endforeach
</div>

{{-- Filter bar — works today (client-side), same markup swaps to server filtering later --}}
<div class="filter-bar" style="margin-bottom:20px;" data-filter-scope="#contentTableWrap">
    <div class="filter-bar__search">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
        <input type="search" placeholder="Search content..." data-filter-search>
    </div>
    <select class="form-control" data-filter-select="status">
        <option value="all">All statuses</option>
        <option value="approved">Published</option>
        <option value="pending">Draft / Scheduled</option>
        <option value="rejected">Archived</option>
    </select>
    <select class="form-control" data-filter-select="type">
        <option value="all">All types</option>
        <option value="News">News</option>
        <option value="Event">Event</option>
        <option value="Project">Project</option>
        <option value="Call for Proposal">Call for Proposal</option>
    </select>
    <button type="button" class="btn btn--outline btn--sm" data-export-csv="#contentTableWrap" data-export-filename="content-management">⭳ Export CSV</button>
</div>

<div class="data-table-wrap" id="contentTableWrap">
    <table class="data-table">
        <thead>
            <tr><th>Title</th><th>Type</th><th>Status</th><th>Author</th><th>Last Modified</th><th></th></tr>
        </thead>
        <tbody>
            @foreach ([
                ['title' => 'ESI signs new agreement with University of Barcelona', 'type' => 'News', 'status' => 'approved', 'label' => 'Published', 'author' => 'A. Souabni', 'date' => '12 Aug 2026'],
                ['title' => 'Erasmus+ mobility results announced', 'type' => 'News', 'status' => 'approved', 'label' => 'Published', 'author' => 'R. Labed', 'date' => '28 Jul 2026'],
                ['title' => 'International Cooperation Info Day', 'type' => 'Event', 'status' => 'pending', 'label' => 'Scheduled', 'author' => 'A. Souabni', 'date' => '25 Jul 2026'],
                ['title' => 'New PRIMA call — draft', 'type' => 'Call for Proposal', 'status' => 'pending', 'label' => 'Draft', 'author' => 'R. Labed', 'date' => '20 Jul 2026'],
                ['title' => 'DIGI-COOP — Digital Cooperation Network', 'type' => 'Project', 'status' => 'approved', 'label' => 'Published', 'author' => 'R. Labed', 'date' => '15 Jul 2026'],
                ['title' => 'Delegation visit recap — archived', 'type' => 'News', 'status' => 'rejected', 'label' => 'Archived', 'author' => 'A. Souabni', 'date' => '2 Jun 2026'],
            ] as $item)
            <tr data-status="{{ $item['status'] }}" data-type="{{ $item['type'] }}">
                <td data-row-title>{{ $item['title'] }}</td>
                <td><span class="pill pill--outline">{{ $item['type'] }}</span></td>
                <td><span class="badge badge--{{ $item['status'] }}">{{ $item['label'] }}</span></td>
                <td>{{ $item['author'] }}</td>
                <td>{{ $item['date'] }}</td>
                <td class="data-table__actions">
                    <button type="button" data-action="preview" aria-label="Preview">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7-10-7-10-7Z" stroke="currentColor" stroke-width="1.6"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.6"/></svg>
                    </button>
                    <button type="button" data-action="edit" aria-label="Edit">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 20h4L18.5 9.5a2.1 2.1 0 0 0-3-3L5 17v3Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                    </button>
                    <button type="button" data-action="archive" aria-label="Archive">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="4" width="18" height="4" rx="1" stroke="currentColor" stroke-width="1.6"/><path d="M5 8v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V8M10 12h4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                    </button>
                    <button type="button" data-action="delete" aria-label="Delete">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 7h16M9 7V4h6v3M6 7l1 13a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1l1-13" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<p data-empty-state style="display:none; text-align:center; padding:32px; color:var(--color-neutral-500); font-family:var(--font-body);">No content matches your filters.</p>

<nav class="pagination" aria-label="Content pages">
    <a href="#" class="is-disabled">‹</a>
    <a href="#" class="is-active">1</a>
    <a href="#">2</a>
    <a href="#">›</a>
</nav>

@endsection

@section('modals')
<dialog id="newContentModal" class="modal" style="max-width:560px;">
    <form method="POST" action="{{ route('admin.content.store') }}" data-demo-submit="New content saved as draft (demo — connect this route to persist).">
        @csrf
        <div class="modal__header">
            <h3>New Content</h3>
            <button type="button" class="modal__close" data-modal-close aria-label="Close">&times;</button>
        </div>
        <div class="modal__body">
            <div class="form-group">
                <label class="form-label" for="newContentType">Content type</label>
                <select class="form-control" id="newContentType" name="content_type" data-content-type-select>
                    <option value="News">News</option>
                    <option value="Event">Event</option>
                    <option value="Project">Project</option>
                    <option value="Call for Proposal">Call for Proposal</option>
                    <option value="Mobility Opportunity">Mobility Opportunity</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="newContentTitle">Title</label>
                <input class="form-control" type="text" id="newContentTitle" name="title" required>
            </div>

            {{-- News fields --}}
            <div data-fields-for="News">
                <div class="form-group">
                    <label class="form-label" for="newsBody">Article body</label>
                    <textarea class="form-control" id="newsBody" name="body" rows="4"></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label" for="newsImage">Cover image</label>
                    <input class="form-control" type="file" id="newsImage" name="image" accept="image/*">
                </div>
            </div>

            {{-- Event fields --}}
            <div data-fields-for="Event" style="display:none;">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="eventStart">Start date/time</label>
                        <input class="form-control" type="datetime-local" id="eventStart" name="start_date">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="eventEnd">End date/time</label>
                        <input class="form-control" type="datetime-local" id="eventEnd" name="end_date">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="eventLocation">Location</label>
                    <input class="form-control" type="text" id="eventLocation" name="location">
                </div>
                <div class="form-group">
                    <label class="form-label" for="eventDescription">Description</label>
                    <textarea class="form-control" id="eventDescription" name="description" rows="3"></textarea>
                </div>
            </div>

            {{-- Project fields --}}
            <div data-fields-for="Project" style="display:none;">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="projectAcronym">Acronym</label>
                        <input class="form-control" type="text" id="projectAcronym" name="acronym">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="projectProgramme">Funding programme</label>
                        <select class="form-control" id="projectProgramme" name="programme">
                            <option>Erasmus+</option>
                            <option>Horizon Europe</option>
                            <option>PRIMA</option>
                            <option>National</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="projectStart">Start date</label>
                        <input class="form-control" type="date" id="projectStart" name="start_date">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="projectEnd">End date</label>
                        <input class="form-control" type="date" id="projectEnd" name="end_date">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="projectAbstract">Abstract</label>
                    <textarea class="form-control" id="projectAbstract" name="abstract" rows="3"></textarea>
                </div>
            </div>

            {{-- Call for Proposal fields --}}
            <div data-fields-for="Call for Proposal" style="display:none;">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="callOpening">Opening date</label>
                        <input class="form-control" type="date" id="callOpening" name="opening_date">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="callDeadline">Deadline</label>
                        <input class="form-control" type="date" id="callDeadline" name="deadline">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="callBudget">Budget</label>
                    <input class="form-control" type="text" id="callBudget" name="budget" placeholder="e.g. €50,000">
                </div>
                <div class="form-group">
                    <label class="form-label" for="callDescription">Description</label>
                    <textarea class="form-control" id="callDescription" name="description" rows="3"></textarea>
                </div>
            </div>

            {{-- Mobility Opportunity fields --}}
            <div data-fields-for="Mobility Opportunity" style="display:none;">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="mobilityHost">Hosting establishment</label>
                        <input class="form-control" type="text" id="mobilityHost" name="host">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="mobilityPlaces">Places available</label>
                        <input class="form-control" type="number" id="mobilityPlaces" name="places" min="1">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="mobilityDeadline">Application deadline</label>
                    <input class="form-control" type="date" id="mobilityDeadline" name="application_deadline">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="newContentStatus">Publication status</label>
                <select class="form-control" id="newContentStatus" name="publication_status">
                    <option value="draft">Save as draft</option>
                    <option value="scheduled">Schedule for later</option>
                    <option value="published">Publish now</option>
                </select>
            </div>
        </div>
        <div class="modal__footer">
            <button type="button" class="btn btn--outline btn--sm" data-modal-close>Cancel</button>
            <button type="submit" class="btn btn--primary btn--sm">Save</button>
        </div>
    </form>
</dialog>
@endsection
