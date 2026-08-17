{{-- resources/views/documents.blade.php — FR-7.1 to FR-7.4 --}}
@extends('layouts.app')

@section('title', 'Document Library')

@section('content')

<x-page-hero
    :title="__('pages.documents.title')"
    :subtitle="__('pages.documents.subtitle')"
    breadcrumb="<a href='{{ url('/') }}'>{{ __('nav.home') }}</a> / Documents">
</x-page-hero>

<div class="page-hero__toolbar">
    <div class="filter-bar" data-filter-scope="#documentsTableWrap">
        <div class="filter-bar__search">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            <input type="search" placeholder="Search documents..." data-filter-search>
        </div>
        <select class="form-control" data-filter-select="category">
            <option value="all">All categories</option>
            <option value="Institutional">Institutional documents</option>
            <option value="Project templates">Project templates</option>
            <option value="Financial / admin">Financial / admin forms</option>
            <option value="Erasmus+">Erasmus+ documents</option>
            <option value="Guides">Guides &amp; FAQ</option>
        </select>
        <select class="form-control" data-filter-select="lang">
            <option value="all">All languages</option>
            <option value="EN">English</option>
            <option value="FR">French</option>
            <option value="AR">Arabic</option>
        </select>
    </div>
</div>

<section class="section">
    <p style="font-family:var(--font-body); font-size:12.5px; color:var(--color-neutral-500); margin-bottom:10px;">Click a column header to sort.</p>
    <div class="data-table-wrap" id="documentsTableWrap">
        <table class="data-table" data-sortable>
            <thead>
                <tr>
                    <th data-sort-key="title">Document</th>
                    <th data-sort-key="category">Category</th>
                    <th data-sort-key="lang">Language</th>
                    <th data-sort-key="version">Version</th>
                    <th data-sort-key="date">Published</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ([
                    ['title' => 'Institutional Brochure 2026', 'category' => 'Institutional', 'lang' => 'EN', 'version' => '3.1', 'date' => '01 Aug 2026'],
                    ['title' => 'Erasmus+ Learning Agreement Template', 'category' => 'Erasmus+', 'lang' => 'EN', 'version' => '2.0', 'date' => '15 Jul 2026'],
                    ['title' => 'Cooperation Agreement Template', 'category' => 'Institutional', 'lang' => 'FR', 'version' => '1.4', 'date' => '02 Jul 2026'],
                    ['title' => 'Project Proposal Template — Horizon Europe', 'category' => 'Project templates', 'lang' => 'EN', 'version' => '1.0', 'date' => '20 Jun 2026'],
                    ['title' => 'Financial Reporting Form', 'category' => 'Financial / admin', 'lang' => 'FR', 'version' => '2.2', 'date' => '10 Jun 2026'],
                    ['title' => 'Incoming Student Guide', 'category' => 'Guides', 'lang' => 'EN', 'version' => '1.3', 'date' => '28 May 2026'],
                ] as $doc)
                <tr data-category="{{ $doc['category'] }}" data-lang="{{ $doc['lang'] }}">
                    <td data-row-title data-cell="title">{{ $doc['title'] }}</td>
                    <td data-cell="category">{{ $doc['category'] }}</td>
                    <td data-cell="lang">{{ $doc['lang'] }}</td>
                    <td data-cell="version">v{{ $doc['version'] }}</td>
                    <td data-cell="date">{{ $doc['date'] }}</td>
                    <td class="data-table__actions">
                        <button type="button" data-toast="Downloading &quot;{{ $doc['title'] }}&quot; (demo — connect real file storage)." aria-label="Download {{ $doc['title'] }}">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 3v12m0 0l-4-4m4 4l4-4M5 21h14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <p data-empty-state style="display:none; text-align:center; padding:32px; color:var(--color-neutral-500); font-family:var(--font-body);">No documents match your filters.</p>

    <nav class="pagination" aria-label="Document pages">
        <a href="#" class="is-disabled">‹</a>
        <a href="#" class="is-active">1</a>
        <a href="#">2</a>
        <a href="#">›</a>
    </nav>
</section>

@endsection
