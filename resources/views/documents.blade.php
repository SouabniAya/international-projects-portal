{{-- resources/views/documents.blade.php — FR-7.1 to FR-7.4 --}}
@extends('layouts.app')

@section('title', 'Document Library')

@section('content')

<x-page-hero
    :title="__('pages.documents.title')"
    :subtitle="__('pages.documents.subtitle')"
    breadcrumb="<a href='{{ url('/') }}'>{{ __('nav.home') }}</a> / Documents">
</x-page-hero>

<form method="GET" action="{{ route('documents.index') }}" class="page-hero__toolbar">
    <div class="filter-bar" data-filter-scope="#documentsTableWrap">
        <div class="filter-bar__search">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            <input type="search" name="search" value="{{ request('search') }}" placeholder="{{ __('documents.search_placeholder') }}" data-filter-search>
        </div>
        <select class="form-control" name="category" data-filter-select="category" onchange="this.form.submit()">
            <option value="">{{ __('documents.all_categories') }}</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat['id'] }}" @selected(request('category') == $cat['id'])>{{ $cat['name'] }}</option>
            @endforeach
        </select>
        <select class="form-control" name="lang" data-filter-select="lang" onchange="this.form.submit()">
            <option value="">{{ __('documents.all_languages') }}</option>
            <option value="en" @selected(request('lang') == 'en')>{{ __('documents.lang_en') }}</option>
            <option value="fr" @selected(request('lang') == 'fr')>{{ __('documents.lang_fr') }}</option>
            <option value="ar" @selected(request('lang') == 'ar')>{{ __('documents.lang_ar') }}</option>
        </select>
    </div>
</form>

<section class="section">
    <p style="font-family:var(--font-body); font-size:12.5px; color:var(--color-neutral-500); margin-bottom:10px;">{{ __('documents.sort_hint') }}</p>
    <div class="data-table-wrap" id="documentsTableWrap">
        <table class="data-table" data-sortable>
            <thead>
                <tr>
                    <th data-sort-key="title">{{ __('documents.col_document') }}</th>
                    <th data-sort-key="category">{{ __('documents.col_category') }}</th>
                    <th data-sort-key="lang">{{ __('documents.col_language') }}</th>
                    <th data-sort-key="version">{{ __('documents.col_version') }}</th>
                    <th data-sort-key="date">{{ __('documents.col_published') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($documents as $doc)
                @php
                    $categoryName = optional(
                        $doc->category?->translations->firstWhere('languageCode', app()->getLocale())
                    )->categoryName ?? '';
                @endphp
                <tr data-category="{{ $doc->categoryID }}" data-lang="{{ strtoupper($doc->languageCode) }}">
                    <td data-row-title data-cell="title">{{ $doc->title }}</td>
                    <td data-cell="category">{{ $categoryName }}</td>
                    <td data-cell="lang">{{ strtoupper($doc->languageCode) }}</td>
                    <td data-cell="version">v{{ $doc->version }}</td>
                    <td data-cell="date">{{ $doc->publicationDate->translatedFormat('d M Y') }}</td>
                    <td class="data-table__actions">
                        <a href="{{ route('documents.download', $doc->documentID) }}" aria-label="{{ __('documents.download_label', ['title' => $doc->title]) }}">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 3v12m0 0l-4-4m4 4l4-4M5 21h14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center; padding:32px; color:var(--color-neutral-500); font-family:var(--font-body);">
                        {{ __('documents.empty_state') }}
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <nav class="pagination" aria-label="Document pages">
        <a href="{{ $documents->previousPageUrl() ?? '#' }}" class="{{ $documents->onFirstPage() ? 'is-disabled' : '' }}">‹</a>
        @foreach ($documents->getUrlRange(1, $documents->lastPage()) as $page => $url)
            <a href="{{ $url }}" class="{{ $page == $documents->currentPage() ? 'is-active' : '' }}">{{ $page }}</a>
        @endforeach
        <a href="{{ $documents->nextPageUrl() ?? '#' }}" class="{{ !$documents->hasMorePages() ? 'is-disabled' : '' }}">›</a>
    </nav>
</section>

@endsection