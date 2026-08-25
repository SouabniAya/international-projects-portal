{{-- resources/views/admin/content-management.blade.php --}}
@extends('layouts.admin')

@section('title', 'Content Management')

@php($active = 'cooperation')

@section('content')

<div class="section__header section__header--row" style="margin-bottom:8px;">
    <div>
        <h2 style="margin:0;">{{ __('Content Management') }}</h2>
        <p style="margin:4px 0 0;">
            {{ __('Create, edit, and publish content across the portal.') }}
        </p>
    </div>

    <button
        type="button"
        class="btn btn--primary btn--sm"
        data-modal-open="newContentModal"
    >
        + {{ __('New Content') }}
    </button>
</div>

<p style="margin:0 0 20px; font-family:var(--font-body); font-size:12.5px;">
    {{ __('Prefer a full page?') }}
    <a
        href="{{ url('/admin/content/create') }}"
        style="color:var(--color-cerulean);"
    >
        {{ __('Use the dedicated Publish Content page →') }}
    </a>
</p>

{{-- ================================================================ --}}
{{-- CONTENT TYPE TABS --}}
{{-- ================================================================ --}}

<div
    class="flex-row"
    style="
        margin-bottom:20px;
        border-bottom:1px solid var(--color-neutral-300);
        padding-bottom:12px;
        flex-wrap:wrap;
        gap:8px;
    "
>
    @foreach ([
        'Homepage',
        'School Presentation',
        'News',
        'Events',
        'Projects',
        'Calls',
        'Mobility',
        'Partnerships',
        'Partner Institutions',
        'Funding Programmes',
        'Documents',
        'Testimonials',
        'FAQ',
        'Contact',
        'Partnership Page'
    ] as $i => $tab)

        <a
            href="#"
            class="btn {{ $i === 0 ? 'btn--primary' : 'btn--outline' }} btn--sm"
        >
            {{ __($tab) }}
        </a>

    @endforeach
</div>

{{-- ================================================================ --}}
{{-- FILTER BAR --}}
{{-- ================================================================ --}}

<div
    class="filter-bar"
    style="margin-bottom:20px;"
    data-filter-scope="#contentTableWrap"
>

    <div class="filter-bar__search">

        <svg
            viewBox="0 0 24 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
        >
            <circle
                cx="11"
                cy="11"
                r="7"
                stroke="currentColor"
                stroke-width="2"
            />

            <path
                d="M21 21l-4.3-4.3"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
            />
        </svg>

        <input
            type="search"
            placeholder="{{ __('Search content...') }}"
            data-filter-search
        >

    </div>

    <select
        class="form-control"
        data-filter-select="status"
    >
        <option value="all">{{ __('All statuses') }}</option>
        <option value="approved">{{ __('Published') }}</option>
        <option value="pending">{{ __('Draft / Scheduled') }}</option>
        <option value="rejected">{{ __('Archived') }}</option>
    </select>

    <select
        class="form-control"
        data-filter-select="type"
    >
        <option value="all">{{ __('All types') }}</option>
        <option value="Homepage">{{ __('Homepage') }}</option>
        <option value="School Presentation">{{ __('School Presentation') }}</option>
        <option value="News">{{ __('News') }}</option>
        <option value="Event">{{ __('Event') }}</option>
        <option value="Project">{{ __('Project') }}</option>
        <option value="Call for Proposal">{{ __('Call for Proposal') }}</option>
        <option value="Mobility Opportunity">{{ __('Mobility Opportunity') }}</option>
        <option value="Partnership">{{ __('Partnership') }}</option>
        <option value="Partner Institution">{{ __('Partner Institution') }}</option>
        <option value="Funding Programme">{{ __('Funding Programme') }}</option>
        <option value="Document">{{ __('Document') }}</option>
        <option value="Testimonial">{{ __('Testimonial') }}</option>
        <option value="FAQ">{{ __('FAQ') }}</option>
        <option value="Contact">{{ __('Contact') }}</option>
        <option value="Partnership Page">{{ __('Partnership Page') }}</option>
    </select>

    <button
        type="button"
        class="btn btn--outline btn--sm"
        data-export-csv="#contentTableWrap"
        data-export-filename="content-management"
    >
        ⭳ {{ __('Export CSV') }}
    </button>

</div>

{{-- ================================================================ --}}
{{-- CONTENT TABLE --}}
{{-- ================================================================ --}}

<div class="data-table-wrap" id="contentTableWrap">

    <table class="data-table">

        <thead>
            <tr>
                <th>{{ __('Title') }}</th>
                <th>{{ __('Type') }}</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Author') }}</th>
                <th>{{ __('Last Modified') }}</th>
                <th></th>
            </tr>
        </thead>

        <tbody>

            @foreach ([

                [
                    'title' => 'ESI Beyond Borders',
                    'type' => 'Homepage',
                    'status' => 'approved',
                    'label' => 'Published',
                    'author' => 'A. Souabni',
                    'date' => '21 Aug 2026'
                ],

                [
                    'title' => 'School Presentation',
                    'type' => 'School Presentation',
                    'status' => 'approved',
                    'label' => 'Published',
                    'author' => 'A. Souabni',
                    'date' => '21 Aug 2026'
                ],

                [
                    'title' => 'ESI signs new agreement with University of Barcelona',
                    'type' => 'News',
                    'status' => 'approved',
                    'label' => 'Published',
                    'author' => 'A. Souabni',
                    'date' => '12 Aug 2026'
                ],

                [
                    'title' => 'Erasmus+ mobility results announced',
                    'type' => 'News',
                    'status' => 'approved',
                    'label' => 'Published',
                    'author' => 'R. Labed',
                    'date' => '28 Jul 2026'
                ],

                [
                    'title' => 'International Cooperation Info Day',
                    'type' => 'Event',
                    'status' => 'pending',
                    'label' => 'Scheduled',
                    'author' => 'A. Souabni',
                    'date' => '25 Jul 2026'
                ],

                [
                    'title' => 'New PRIMA call — draft',
                    'type' => 'Call for Proposal',
                    'status' => 'pending',
                    'label' => 'Draft',
                    'author' => 'R. Labed',
                    'date' => '20 Jul 2026'
                ],

                [
                    'title' => 'DIGI-COOP — Digital Cooperation Network',
                    'type' => 'Project',
                    'status' => 'approved',
                    'label' => 'Published',
                    'author' => 'R. Labed',
                    'date' => '15 Jul 2026'
                ],

                [
                    'title' => 'University of Barcelona',
                    'type' => 'Partner Institution',
                    'status' => 'approved',
                    'label' => 'Published',
                    'author' => 'A. Souabni',
                    'date' => '10 Jul 2026'
                ],

                [
                    'title' => 'Horizon Europe',
                    'type' => 'Funding Programme',
                    'status' => 'approved',
                    'label' => 'Published',
                    'author' => 'R. Labed',
                    'date' => '8 Jul 2026'
                ],

                [
                    'title' => 'Student Mobility Experience — Amine K.',
                    'type' => 'Testimonial',
                    'status' => 'approved',
                    'label' => 'Published',
                    'author' => 'A. Souabni',
                    'date' => '5 Jul 2026'
                ],

                [
                    'title' => 'How can I apply for Erasmus+ mobility?',
                    'type' => 'FAQ',
                    'status' => 'approved',
                    'label' => 'Published',
                    'author' => 'A. Souabni',
                    'date' => '3 Jul 2026'
                ],

                [
                    'title' => 'International Mobility Application Guide',
                    'type' => 'Document',
                    'status' => 'approved',
                    'label' => 'Published',
                    'author' => 'R. Labed',
                    'date' => '1 Jul 2026'
                ],

                [
                    'title' => 'Become a Partner',
                    'type' => 'Partnership Page',
                    'status' => 'approved',
                    'label' => 'Published',
                    'author' => 'A. Souabni',
                    'date' => '28 Jun 2026'
                ],

                [
                    'title' => 'International Relations Office',
                    'type' => 'Contact',
                    'status' => 'approved',
                    'label' => 'Published',
                    'author' => 'A. Souabni',
                    'date' => '25 Jun 2026'
                ],

                [
                    'title' => 'Delegation visit recap — archived',
                    'type' => 'News',
                    'status' => 'rejected',
                    'label' => 'Archived',
                    'author' => 'A. Souabni',
                    'date' => '2 Jun 2026'
                ],

            ] as $item)

                <tr
                    data-status="{{ $item['status'] }}"
                    data-type="{{ $item['type'] }}"
                >

                    <td data-row-title>
                        {{ __($item['title']) }}
                    </td>

                    <td>
                        <span class="pill pill--outline">
                            {{ __($item['type']) }}
                        </span>
                    </td>

                    <td>
                        <span class="badge badge--{{ $item['status'] }}">
                            {{ __($item['label']) }}
                        </span>
                    </td>

                    <td>
                        {{ $item['author'] }}
                    </td>

                    <td>
                        {{ $item['date'] }}
                    </td>

                    <td class="data-table__actions">

                        {{-- Preview --}}
                        <button
                            type="button"
                            data-action="preview"
                            aria-label="{{ __('Preview') }}"
                        >
                            <svg viewBox="0 0 24 24" fill="none">
                                <path
                                    d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7-10-7-10-7Z"
                                    stroke="currentColor"
                                    stroke-width="1.6"
                                />

                                <circle
                                    cx="12"
                                    cy="12"
                                    r="3"
                                    stroke="currentColor"
                                    stroke-width="1.6"
                                />
                            </svg>
                        </button>

                        {{-- Edit --}}
                        <button
                            type="button"
                            data-action="edit"
                            aria-label="{{ __('Edit') }}"
                        >
                            <svg viewBox="0 0 24 24" fill="none">
                                <path
                                    d="M4 20h4L18.5 9.5a2.1 2.1 0 0 0-3-3L5 17v3Z"
                                    stroke="currentColor"
                                    stroke-width="1.6"
                                    stroke-linejoin="round"
                                />
                            </svg>
                        </button>

                        {{-- Archive --}}
                        <button
                            type="button"
                            data-action="archive"
                            aria-label="{{ __('Archive') }}"
                        >
                            <svg viewBox="0 0 24 24" fill="none">
                                <rect
                                    x="3"
                                    y="4"
                                    width="18"
                                    height="4"
                                    rx="1"
                                    stroke="currentColor"
                                    stroke-width="1.6"
                                />

                                <path
                                    d="M5 8v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V8M10 12h4"
                                    stroke="currentColor"
                                    stroke-width="1.6"
                                    stroke-linecap="round"
                                />
                            </svg>
                        </button>

                        {{-- Delete --}}
                        <button
                            type="button"
                            data-action="delete"
                            aria-label="{{ __('Delete') }}"
                        >
                            <svg viewBox="0 0 24 24" fill="none">
                                <path
                                    d="M4 7h16M9 7V4h6v3M6 7l1 13a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1l1-13"
                                    stroke="currentColor"
                                    stroke-width="1.6"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />
                            </svg>
                        </button>

                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>

</div>

<p
    data-empty-state
    style="
        display:none;
        text-align:center;
        padding:32px;
        color:var(--color-neutral-500);
        font-family:var(--font-body);
    "
>
    {{ __('No content matches your filters.') }}
</p>

<nav
    class="pagination"
    aria-label="{{ __('Content pages') }}"
>
    <a href="#" class="is-disabled">‹</a>
    <a href="#" class="is-active">1</a>
    <a href="#">2</a>
    <a href="#">›</a>
</nav>

@endsection


@section('modals')

<dialog
    id="newContentModal"
    class="modal"
    style="max-width:720px;"
>

    <form
        method="POST"
        action="{{ route('admin.content.store') }}"
        enctype="multipart/form-data"
        data-demo-submit="{{ __('New content saved as draft (demo — connect this route to persist).') }}"
    >

        @csrf

        {{-- ============================================================ --}}
        {{-- HEADER --}}
        {{-- ============================================================ --}}

        <div class="modal__header">

            <h3>
                {{ __('New Content') }}
            </h3>

            <button
                type="button"
                class="modal__close"
                data-modal-close
                aria-label="{{ __('Close') }}"
            >
                &times;
            </button>

        </div>


        <div class="modal__body">

            {{-- ======================================================== --}}
            {{-- CONTENT TYPE --}}
            {{-- ======================================================== --}}

            <div class="form-group">

                <label
                    class="form-label"
                    for="newContentType"
                >
                    {{ __('Content type') }}
                </label>

                <select
                    class="form-control"
                    id="newContentType"
                    name="content_type"
                    data-content-type-select
                >

                    <option value="Homepage">{{ __('Homepage') }}</option>

                    <option value="School Presentation">
                        {{ __('School Presentation') }}
                    </option>

                    <option value="News">{{ __('News') }}</option>

                    <option value="Event">{{ __('Event') }}</option>

                    <option value="Project">{{ __('Project') }}</option>

                    <option value="Call for Proposal">
                        {{ __('Call for Proposal') }}
                    </option>

                    <option value="Mobility Opportunity">
                        {{ __('Mobility Opportunity') }}
                    </option>

                    <option value="Partnership">
                        {{ __('Partnership') }}
                    </option>

                    <option value="Partner Institution">
                        {{ __('Partner Institution') }}
                    </option>

                    <option value="Funding Programme">
                        {{ __('Funding Programme') }}
                    </option>

                    <option value="Document">
                        {{ __('Document') }}
                    </option>

                    <option value="Testimonial">
                        {{ __('Testimonial') }}
                    </option>

                    <option value="FAQ">{{ __('FAQ') }}</option>

                    <option value="Contact">{{ __('Contact') }}</option>

                    <option value="Partnership Page">
                        {{ __('Partnership Page') }}
                    </option>

                </select>

            </div>


            {{-- ======================================================== --}}
            {{-- MULTILINGUAL TITLE --}}
            {{-- ======================================================== --}}

            <div class="form-group">

                <label class="form-label">
                    {{ __('Title') }}
                </label>

                <input
                    class="form-control"
                    type="text"
                    name="title"
                    id="newContentTitle"
                    required
                    placeholder="{{ __('Default / English title') }}"
                >

            </div>

            <div
                style="
                    display:grid;
                    grid-template-columns:repeat(3,1fr);
                    gap:10px;
                    margin-bottom:18px;
                "
            >

                <div class="form-group" style="margin:0;">

                    <label class="form-label">
                        {{ __('English') }}
                    </label>

                    <input
                        class="form-control"
                        type="text"
                        name="title_en"
                    >

                </div>

                <div class="form-group" style="margin:0;">

                    <label class="form-label">
                        {{ __('Français') }}
                    </label>

                    <input
                        class="form-control"
                        type="text"
                        name="title_fr"
                    >

                </div>

                <div class="form-group" style="margin:0;">

                    <label class="form-label">
                        {{ __('العربية') }}
                    </label>

                    <input
                        class="form-control"
                        type="text"
                        name="title_ar"
                        dir="rtl"
                    >

                </div>

            </div>


            {{-- ======================================================== --}}
            {{-- HOMEPAGE --}}
            {{-- ======================================================== --}}

            <div
                data-fields-for="Homepage"
                style="display:none;"
            >

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Hero title') }}
                    </label>

                    <input
                        class="form-control"
                        type="text"
                        name="hero_title"
                    >

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Hero subtitle') }}
                    </label>

                    <textarea
                        class="form-control"
                        name="hero_subtitle"
                        rows="3"
                    ></textarea>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Hero background image') }}
                    </label>

                    <input
                        class="form-control"
                        type="file"
                        name="hero_image"
                        accept="image/*"
                    >

                </div>

                <div class="form-row">

                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Primary CTA text') }}
                        </label>

                        <input
                            class="form-control"
                            type="text"
                            name="primary_cta_text"
                        >

                    </div>

                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Primary CTA URL') }}
                        </label>

                        <input
                            class="form-control"
                            type="url"
                            name="primary_cta_url"
                        >

                    </div>

                </div>

                <div
                    style="
                        padding:14px;
                        border:1px solid var(--color-neutral-300);
                        border-radius:8px;
                        margin-bottom:16px;
                    "
                >

                    <strong style="display:block;margin-bottom:10px;">
                        {{ __('Homepage statistics') }}
                    </strong>

                    <p
                        style="
                            margin:0 0 12px;
                            font-size:12px;
                            color:var(--color-neutral-500);
                        "
                    >
                        {{ __('Leave these values automatic when they should be calculated from partners, projects, and agreements.') }}
                    </p>

                    <div class="form-row">

                        <div class="form-group">

                            <label class="form-label">
                                {{ __('Countries') }}
                            </label>

                            <input
                                class="form-control"
                                type="number"
                                name="countries_count"
                                min="0"
                            >

                        </div>

                        <div class="form-group">

                            <label class="form-label">
                                {{ __('Active agreements') }}
                            </label>

                            <input
                                class="form-control"
                                type="number"
                                name="agreements_count"
                                min="0"
                            >

                        </div>

                    </div>

                    <div class="form-row">

                        <div class="form-group">

                            <label class="form-label">
                                {{ __('Ongoing projects') }}
                            </label>

                            <input
                                class="form-control"
                                type="number"
                                name="projects_count"
                                min="0"
                            >

                        </div>

                        <div class="form-group">

                            <label class="form-label">
                                {{ __('Partners') }}
                            </label>

                            <input
                                class="form-control"
                                type="number"
                                name="partners_count"
                                min="0"
                            >

                        </div>

                    </div>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Homepage image') }}
                    </label>

                    <input
                        class="form-control"
                        type="file"
                        name="homepage_image"
                        accept="image/*"
                    >

                </div>

            </div>


            {{-- ======================================================== --}}
            {{-- SCHOOL PRESENTATION --}}
            {{-- ======================================================== --}}

            <div
                data-fields-for="School Presentation"
                style="display:none;"
            >

                <div class="form-group">

                    <label class="form-label">
                        {{ __('School introduction') }}
                    </label>

                    <textarea
                        class="form-control"
                        name="school_introduction"
                        rows="5"
                    ></textarea>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('History') }}
                    </label>

                    <textarea
                        class="form-control"
                        name="school_history"
                        rows="4"
                    ></textarea>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Vision') }}
                    </label>

                    <textarea
                        class="form-control"
                        name="vision"
                        rows="3"
                    ></textarea>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Mission') }}
                    </label>

                    <textarea
                        class="form-control"
                        name="mission"
                        rows="3"
                    ></textarea>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Internationalization strategy') }}
                    </label>

                    <textarea
                        class="form-control"
                        name="internationalization_strategy"
                        rows="4"
                    ></textarea>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Research domains') }}
                    </label>

                    <textarea
                        class="form-control"
                        name="research_domains"
                        rows="4"
                    ></textarea>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Why partner with ESI') }}
                    </label>

                    <textarea
                        class="form-control"
                        name="why_partner"
                        rows="4"
                    ></textarea>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Presentation document') }}
                    </label>

                    <input
                        class="form-control"
                        type="file"
                        name="school_presentation_document"
                        accept=".pdf,.doc,.docx,.txt"
                    >

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Presentation image') }}
                    </label>

                    <input
                        class="form-control"
                        type="file"
                        name="school_presentation_image"
                        accept="image/*"
                    >

                </div>

            </div>


            {{-- ======================================================== --}}
            {{-- NEWS --}}
            {{-- ======================================================== --}}

            <div
                data-fields-for="News"
                style="display:none;"
            >

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Article body') }}
                    </label>

                    <textarea
                        class="form-control"
                        name="body"
                        rows="6"
                    ></textarea>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Cover image') }}
                    </label>

                    <input
                        class="form-control"
                        type="file"
                        name="image"
                        accept="image/*"
                    >

                </div>

                <div class="form-row">

                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Category') }}
                        </label>

                        <input
                            class="form-control"
                            type="text"
                            name="category"
                        >

                    </div>

                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Author') }}
                        </label>

                        <input
                            class="form-control"
                            type="text"
                            name="author"
                        >

                    </div>

                </div>

            </div>


            {{-- ======================================================== --}}
            {{-- EVENTS --}}
            {{-- ======================================================== --}}

            <div
                data-fields-for="Event"
                style="display:none;"
            >

                <div class="form-row">

                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Start date/time') }}
                        </label>

                        <input
                            class="form-control"
                            type="datetime-local"
                            name="start_date"
                        >

                    </div>

                    <div class="form-group">

                        <label class="form-label">
                            {{ __('End date/time') }}
                        </label>

                        <input
                            class="form-control"
                            type="datetime-local"
                            name="end_date"
                        >

                    </div>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Location') }}
                    </label>

                    <input
                        class="form-control"
                        type="text"
                        name="location"
                    >

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Description') }}
                    </label>

                    <textarea
                        class="form-control"
                        name="description"
                        rows="4"
                    ></textarea>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Registration URL') }}
                    </label>

                    <input
                        class="form-control"
                        type="url"
                        name="registration_url"
                    >

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Cover image') }}
                    </label>

                    <input
                        class="form-control"
                        type="file"
                        name="event_image"
                        accept="image/*"
                    >

                </div>

            </div>


            {{-- ======================================================== --}}
            {{-- PROJECT --}}
            {{-- ======================================================== --}}

            <div
                data-fields-for="Project"
                style="display:none;"
            >

                <div class="form-row">

                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Acronym') }}
                        </label>

                        <input
                            class="form-control"
                            type="text"
                            name="acronym"
                        >

                    </div>

                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Funding programme') }}
                        </label>

                        <select
                            class="form-control"
                            name="programme"
                        >

                            <option value="Erasmus+">
                                {{ __('Erasmus+') }}
                            </option>

                            <option value="Horizon Europe">
                                {{ __('Horizon Europe') }}
                            </option>

                            <option value="PRIMA">
                                {{ __('PRIMA') }}
                            </option>

                            <option value="National">
                                {{ __('National') }}
                            </option>

                        </select>

                    </div>

                </div>

                <div class="form-row">

                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Start date') }}
                        </label>

                        <input
                            class="form-control"
                            type="date"
                            name="start_date"
                        >

                    </div>

                    <div class="form-group">

                        <label class="form-label">
                            {{ __('End date') }}
                        </label>

                        <input
                            class="form-control"
                            type="date"
                            name="end_date"
                        >

                    </div>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Abstract') }}
                    </label>

                    <textarea
                        class="form-control"
                        name="abstract"
                        rows="4"
                    ></textarea>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Project website') }}
                    </label>

                    <input
                        class="form-control"
                        type="url"
                        name="project_url"
                    >

                </div>

            </div>


            {{-- ======================================================== --}}
            {{-- CALL --}}
            {{-- ======================================================== --}}

            <div
                data-fields-for="Call for Proposal"
                style="display:none;"
            >

                <div class="form-row">

                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Opening date') }}
                        </label>

                        <input
                            class="form-control"
                            type="date"
                            name="opening_date"
                        >

                    </div>

                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Deadline') }}
                        </label>

                        <input
                            class="form-control"
                            type="date"
                            name="deadline"
                        >

                    </div>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Funding programme') }}
                    </label>

                    <input
                        class="form-control"
                        type="text"
                        name="funding_programme"
                        placeholder="{{ __('Erasmus+, Horizon Europe, PRIMA...') }}"
                    >

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Budget') }}
                    </label>

                    <input
                        class="form-control"
                        type="text"
                        name="budget"
                        placeholder="{{ __('e.g. €50,000') }}"
                    >

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Description') }}
                    </label>

                    <textarea
                        class="form-control"
                        name="description"
                        rows="4"
                    ></textarea>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Application URL') }}
                    </label>

                    <input
                        class="form-control"
                        type="url"
                        name="application_url"
                    >

                </div>

            </div>


            {{-- ======================================================== --}}
            {{-- MOBILITY --}}
            {{-- ======================================================== --}}

            <div
                data-fields-for="Mobility Opportunity"
                style="display:none;"
            >

                <div class="form-row">

                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Hosting establishment') }}
                        </label>

                        <input
                            class="form-control"
                            type="text"
                            name="host"
                        >

                    </div>

                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Country') }}
                        </label>

                        <input
                            class="form-control"
                            type="text"
                            name="country"
                        >

                    </div>

                </div>

                <div class="form-row">

                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Mobility type') }}
                        </label>

                        <select
                            class="form-control"
                            name="mobility_type"
                        >

                            <option>{{ __('Semester Exchange') }}</option>
                            <option>{{ __('Internship') }}</option>
                            <option>{{ __('Research Mobility') }}</option>
                            <option>{{ __('Staff Mobility') }}</option>
                            <option>{{ __('Other') }}</option>

                        </select>

                    </div>

                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Places available') }}
                        </label>

                        <input
                            class="form-control"
                            type="number"
                            name="places"
                            min="1"
                        >

                    </div>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Application deadline') }}
                    </label>

                    <input
                        class="form-control"
                        type="date"
                        name="application_deadline"
                    >

                </div>

            </div>


            {{-- ======================================================== --}}
            {{-- PARTNERSHIP --}}
            {{-- ======================================================== --}}

            <div
                data-fields-for="Partnership"
                style="display:none;"
            >

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Introduction') }}
                    </label>

                    <textarea
                        class="form-control"
                        name="partnership_introduction"
                        rows="4"
                    ></textarea>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Why partner with ESI') }}
                    </label>

                    <textarea
                        class="form-control"
                        name="partnership_benefits"
                        rows="4"
                    ></textarea>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Cooperation areas') }}
                    </label>

                    <textarea
                        class="form-control"
                        name="cooperation_areas"
                        rows="4"
                        placeholder="{{ __('Education, research, mobility, innovation...') }}"
                    ></textarea>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Cooperation process') }}
                    </label>

                    <textarea
                        class="form-control"
                        name="cooperation_process"
                        rows="4"
                    ></textarea>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Required documents') }}
                    </label>

                    <textarea
                        class="form-control"
                        name="required_documents"
                        rows="4"
                    ></textarea>

                </div>

            </div>


            {{-- ======================================================== --}}
            {{-- PARTNER INSTITUTION --}}
            {{-- ======================================================== --}}

            <div
                data-fields-for="Partner Institution"
                style="display:none;"
            >

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Institution name') }}
                    </label>

                    <input
                        class="form-control"
                        type="text"
                        name="institution_name"
                    >

                </div>

                <div class="form-row">

                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Country') }}
                        </label>

                        <input
                            class="form-control"
                            type="text"
                            name="institution_country"
                        >

                    </div>

                    <div class="form-group">

                        <label class="form-label">
                            {{ __('City') }}
                        </label>

                        <input
                            class="form-control"
                            type="text"
                            name="institution_city"
                        >

                    </div>

                </div>

                <div class="form-row">

                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Institution type') }}
                        </label>

                        <select
                            class="form-control"
                            name="institution_type"
                        >

                            <option>{{ __('University') }}</option>
                            <option>{{ __('Research Institution') }}</option>
                            <option>{{ __('Company') }}</option>
                            <option>{{ __('Government Institution') }}</option>
                            <option>{{ __('Other') }}</option>

                        </select>

                    </div>

                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Cooperation type') }}
                        </label>

                        <input
                            class="form-control"
                            type="text"
                            name="cooperation_type"
                            placeholder="{{ __('Erasmus+, Research, MoU...') }}"
                        >

                    </div>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Website') }}
                    </label>

                    <input
                        class="form-control"
                        type="url"
                        name="institution_website"
                    >

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Institution logo') }}
                    </label>

                    <input
                        class="form-control"
                        type="file"
                        name="institution_logo"
                        accept="image/*"
                    >

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Description') }}
                    </label>

                    <textarea
                        class="form-control"
                        name="institution_description"
                        rows="4"
                    ></textarea>

                </div>

                <div class="form-row">

                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Agreement date') }}
                        </label>

                        <input
                            class="form-control"
                            type="date"
                            name="agreement_date"
                        >

                    </div>

                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Agreement expiration') }}
                        </label>

                        <input
                            class="form-control"
                            type="date"
                            name="agreement_expiration"
                        >

                    </div>

                </div>

            </div>


            {{-- ======================================================== --}}
            {{-- FUNDING PROGRAMME --}}
            {{-- ======================================================== --}}

            <div
                data-fields-for="Funding Programme"
                style="display:none;"
            >

                <div class="form-row">

                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Programme name') }}
                        </label>

                        <input
                            class="form-control"
                            type="text"
                            name="programme_name"
                        >

                    </div>

                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Acronym') }}
                        </label>

                        <input
                            class="form-control"
                            type="text"
                            name="programme_acronym"
                        >

                    </div>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Description') }}
                    </label>

                    <textarea
                        class="form-control"
                        name="programme_description"
                        rows="4"
                    ></textarea>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Programme website') }}
                    </label>

                    <input
                        class="form-control"
                        type="url"
                        name="programme_website"
                    >

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Eligibility') }}
                    </label>

                    <textarea
                        class="form-control"
                        name="eligibility"
                        rows="3"
                    ></textarea>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Funding information') }}
                    </label>

                    <textarea
                        class="form-control"
                        name="funding_information"
                        rows="3"
                    ></textarea>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Programme logo') }}
                    </label>

                    <input
                        class="form-control"
                        type="file"
                        name="programme_logo"
                        accept="image/*"
                    >

                </div>

            </div>


            {{-- ======================================================== --}}
            {{-- DOCUMENT --}}
            {{-- ======================================================== --}}

            <div
                data-fields-for="Document"
                style="display:none;"
            >

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Document description') }}
                    </label>

                    <textarea
                        class="form-control"
                        name="document_description"
                        rows="3"
                    ></textarea>

                </div>

                <div class="form-row">

                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Category') }}
                        </label>

                        <select
                            class="form-control"
                            name="document_category"
                        >

                            <option>{{ __('Institutional') }}</option>
                            <option>{{ __('Mobility') }}</option>
                            <option>{{ __('Partnerships') }}</option>
                            <option>{{ __('Funding') }}</option>
                            <option>{{ __('Applications') }}</option>
                            <option>{{ __('Forms') }}</option>
                            <option>{{ __('Guidelines') }}</option>
                            <option>{{ __('Brochures') }}</option>
                            <option>{{ __('Reports') }}</option>
                            <option>{{ __('Other') }}</option>

                        </select>

                    </div>

                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Language') }}
                        </label>

                        <select
                            class="form-control"
                            name="document_language"
                        >

                            <option value="en">{{ __('English') }}</option>
                            <option value="fr">{{ __('French') }}</option>
                            <option value="ar">{{ __('Arabic') }}</option>

                        </select>

                    </div>

                </div>

                <div class="form-row">

                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Version') }}
                        </label>

                        <input
                            class="form-control"
                            type="text"
                            name="document_version"
                            placeholder="1.0"
                        >

                    </div>

                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Publication date') }}
                        </label>

                        <input
                            class="form-control"
                            type="date"
                            name="document_publication_date"
                        >

                    </div>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Upload document') }}
                    </label>

                    <input
                        class="form-control"
                        type="file"
                        name="document_file"
                        accept=".pdf,.doc,.docx,.xls,.xlsx,.txt"
                    >

                    <small
                        style="
                            display:block;
                            margin-top:6px;
                            color:var(--color-neutral-500);
                        "
                    >
                        {{ __('PDF, DOC, DOCX, XLS, XLSX and TXT files are supported.') }}
                    </small>

                </div>

            </div>


            {{-- ======================================================== --}}
            {{-- TESTIMONIAL --}}
            {{-- ======================================================== --}}

            <div
                data-fields-for="Testimonial"
                style="display:none;"
            >

                <div class="form-row">

                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Person name') }}
                        </label>

                        <input
                            class="form-control"
                            type="text"
                            name="testimonial_person"
                        >

                    </div>

                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Role / status') }}
                        </label>

                        <input
                            class="form-control"
                            type="text"
                            name="testimonial_role"
                            placeholder="{{ __('Student, researcher, staff...') }}"
                        >

                    </div>

                </div>

                <div class="form-row">

                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Mobility type') }}
                        </label>

                        <input
                            class="form-control"
                            type="text"
                            name="testimonial_mobility_type"
                        >

                    </div>

                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Host institution') }}
                        </label>

                        <input
                            class="form-control"
                            type="text"
                            name="testimonial_host"
                        >

                    </div>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Country') }}
                    </label>

                    <input
                        class="form-control"
                        type="text"
                        name="testimonial_country"
                    >

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Testimonial') }}
                    </label>

                    <textarea
                        class="form-control"
                        name="testimonial_text"
                        rows="6"
                    ></textarea>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Photo') }}
                    </label>

                    <input
                        class="form-control"
                        type="file"
                        name="testimonial_photo"
                        accept="image/*"
                    >

                </div>

            </div>


            {{-- ======================================================== --}}
            {{-- FAQ --}}
            {{-- ======================================================== --}}

            <div
                data-fields-for="FAQ"
                style="display:none;"
            >

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Question') }}
                    </label>

                    <input
                        class="form-control"
                        type="text"
                        name="faq_question"
                    >

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Answer') }}
                    </label>

                    <textarea
                        class="form-control"
                        name="faq_answer"
                        rows="6"
                    ></textarea>

                </div>

                <div class="form-row">

                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Category') }}
                        </label>

                        <input
                            class="form-control"
                            type="text"
                            name="faq_category"
                        >

                    </div>

                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Display order') }}
                        </label>

                        <input
                            class="form-control"
                            type="number"
                            name="faq_order"
                            min="0"
                            value="0"
                        >

                    </div>

                </div>

            </div>


            {{-- ======================================================== --}}
            {{-- CONTACT --}}
            {{-- ======================================================== --}}

            <div
                data-fields-for="Contact"
                style="display:none;"
            >

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Office name') }}
                    </label>

                    <input
                        class="form-control"
                        type="text"
                        name="office_name"
                        value="{{ __('International Relations Office') }}"
                    >

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Address') }}
                    </label>

                    <textarea
                        class="form-control"
                        name="office_address"
                        rows="3"
                    ></textarea>

                </div>

                <div class="form-row">

                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Email') }}
                        </label>

                        <input
                            class="form-control"
                            type="email"
                            name="office_email"
                        >

                    </div>

                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Phone') }}
                        </label>

                        <input
                            class="form-control"
                            type="text"
                            name="office_phone"
                        >

                    </div>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Opening hours') }}
                    </label>

                    <input
                        class="form-control"
                        type="text"
                        name="opening_hours"
                    >

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Google Maps / location URL') }}
                    </label>

                    <input
                        class="form-control"
                        type="url"
                        name="location_url"
                    >

                </div>

                <div class="form-row">

                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Facebook') }}
                        </label>

                        <input
                            class="form-control"
                            type="url"
                            name="facebook_url"
                        >

                    </div>

                    <div class="form-group">

                        <label class="form-label">
                            {{ __('LinkedIn') }}
                        </label>

                        <input
                            class="form-control"
                            type="url"
                            name="linkedin_url"
                        >

                    </div>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Contact form recipient') }}
                    </label>

                    <input
                        class="form-control"
                        type="email"
                        name="contact_form_recipient"
                    >

                </div>

            </div>


            {{-- ======================================================== --}}
            {{-- PARTNERSHIP PAGE --}}
            {{-- ======================================================== --}}

            <div
                data-fields-for="Partnership Page"
                style="display:none;"
            >

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Introduction') }}
                    </label>

                    <textarea
                        class="form-control"
                        name="partner_page_introduction"
                        rows="4"
                    ></textarea>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Why partner with ESI') }}
                    </label>

                    <textarea
                        class="form-control"
                        name="partner_page_benefits"
                        rows="4"
                    ></textarea>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Cooperation areas') }}
                    </label>

                    <textarea
                        class="form-control"
                        name="partner_page_areas"
                        rows="4"
                    ></textarea>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Steps / process') }}
                    </label>

                    <textarea
                        class="form-control"
                        name="partner_page_process"
                        rows="5"
                        placeholder="{{ __('1. Contact the office&#10;2. Define cooperation areas&#10;3. Prepare agreement&#10;4. Sign agreement') }}"
                    ></textarea>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Required documents') }}
                    </label>

                    <textarea
                        class="form-control"
                        name="partner_page_documents"
                        rows="4"
                    ></textarea>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Partner application form') }}
                    </label>

                    <input
                        class="form-control"
                        type="file"
                        name="partner_application_form"
                        accept=".pdf,.doc,.docx"
                    >

                </div>

                <div class="form-row">

                    <div class="form-group">

                        <label class="form-label">
                            {{ __('CTA text') }}
                        </label>

                        <input
                            class="form-control"
                            type="text"
                            name="partner_cta_text"
                            value="{{ __('Become a partner') }}"
                        >

                    </div>

                    <div class="form-group">

                        <label class="form-label">
                            {{ __('CTA URL') }}
                        </label>

                        <input
                            class="form-control"
                            type="url"
                            name="partner_cta_url"
                        >

                    </div>

                </div>

            </div>


            {{-- ======================================================== --}}
            {{-- COMMON MEDIA --}}
            {{-- ======================================================== --}}

            <div
                style="
                    margin-top:20px;
                    padding-top:18px;
                    border-top:1px solid var(--color-neutral-300);
                "
            >

                <div class="form-row">

                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Publication language') }}
                        </label>

                        <select
                            class="form-control"
                            name="language"
                        >

                            <option value="en">
                                {{ __('English') }}
                            </option>

                            <option value="fr">
                                {{ __('French') }}
                            </option>

                            <option value="ar">
                                {{ __('Arabic') }}
                            </option>

                        </select>

                    </div>

                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Publication date') }}
                        </label>

                        <input
                            class="form-control"
                            type="date"
                            name="publication_date"
                        >

                    </div>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        {{ __('Attachment') }}
                    </label>

                    <input
                        class="form-control"
                        type="file"
                        name="attachment"
                        accept=".pdf,.doc,.docx,.xls,.xlsx,.txt"
                    >

                </div>

                <div
                    style="
                        display:flex;
                        flex-wrap:wrap;
                        gap:16px;
                        margin-top:12px;
                    "
                >

                    <label
                        style="
                            display:flex;
                            align-items:center;
                            gap:8px;
                            font-size:13px;
                        "
                    >
                        <input
                            type="checkbox"
                            name="featured"
                            value="1"
                        >
                        {{ __('Featured') }}
                    </label>

                    <label
                        style="
                            display:flex;
                            align-items:center;
                            gap:8px;
                            font-size:13px;
                        "
                    >
                        <input
                            type="checkbox"
                            name="show_on_homepage"
                            value="1"
                        >
                        {{ __('Show on homepage') }}
                    </label>

                </div>

            </div>


            {{-- ======================================================== --}}
            {{-- PUBLICATION STATUS --}}
            {{-- ======================================================== --}}

            <div class="form-group" style="margin-top:20px;">

                <label
                    class="form-label"
                    for="newContentStatus"
                >
                    {{ __('Publication status') }}
                </label>

                <select
                    class="form-control"
                    id="newContentStatus"
                    name="publication_status"
                >

                    <option value="draft">
                        {{ __('Save as draft') }}
                    </option>

                    <option value="scheduled">
                        {{ __('Schedule for later') }}
                    </option>

                    <option value="published">
                        {{ __('Publish now') }}
                    </option>

                </select>

            </div>

        </div>


        {{-- ============================================================ --}}
        {{-- FOOTER --}}
        {{-- ============================================================ --}}

        <div class="modal__footer">

            <button
                type="button"
                class="btn btn--outline btn--sm"
                data-modal-close
            >
                {{ __('Cancel') }}
            </button>

            <button
                type="submit"
                class="btn btn--primary btn--sm"
            >
                {{ __('Save') }}
            </button>

        </div>

    </form>

</dialog>

@endsection