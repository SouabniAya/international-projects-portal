{{-- resources/views/admin/content/create.blade.php --}}

@extends('layouts.admin')

@section('title', 'Publish Content')

@php($active = 'cooperation')

@section('content')

<div class="breadcrumbs" style="margin-bottom:8px;">
    <a href="{{ url('/admin/cooperation') }}">
        {{ __('Content Management') }}
    </a>
    /
    {{ __('Publish Content') }}
</div>

<div class="section__header" style="margin-bottom:24px;">
    <h2 style="margin:0;">
        {{ __('Publish Content') }}
    </h2>

    <p style="margin:4px 0 0;">
        {{ __('Create, manage, translate, and publish content across the international portal.') }}
    </p>
</div>


<div
    class="two-col--narrow-first"
    style="display:grid; gap:32px;"
>

    {{-- ================================================================ --}}
    {{-- MAIN FORM                                                        --}}
    {{-- ================================================================ --}}

    <div class="card">

        <div class="card__body">

            <form
                method="POST"
                action="{{ route('admin.content.store') }}"
                enctype="multipart/form-data"
            >

                @csrf


                {{-- ==================================================== --}}
                {{-- CONTENT TYPE                                           --}}
                {{-- ==================================================== --}}

                <div class="form-group">

                    <label
                        class="form-label"
                        for="pageContentType"
                    >
                        {{ __('Content type') }}
                    </label>

                    <select
                        class="form-control"
                        id="pageContentType"
                        name="content_type"
                        data-content-type-select
                    >

                        <option value="Homepage">
                            {{ __('Homepage') }}
                        </option>

                        <option value="School Presentation">
                            {{ __('School Presentation') }}
                        </option>

                        <option value="News" selected>
                            {{ __('News') }}
                        </option>

                        <option value="Event">
                            {{ __('Event') }}
                        </option>

                        <option value="Project">
                            {{ __('Project') }}
                        </option>

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

                        <option value="FAQ">
                            {{ __('FAQ') }}
                        </option>

                        <option value="Contact Information">
                            {{ __('Contact Information') }}
                        </option>

                        <option value="Partnership Page">
                            {{ __('Partnership Page') }}
                        </option>

                    </select>

                    <p class="form-hint">
                        {{ __('Only the fields relevant to the selected content type will appear below.') }}
                    </p>

                </div>


                {{-- ==================================================== --}}
                {{-- COMMON INFORMATION                                     --}}
                {{-- ==================================================== --}}

                <div
                    style="
                        margin:20px 0 24px;
                        padding:16px;
                        background:var(--color-neutral-100);
                        border:1px solid var(--color-neutral-300);
                        border-radius:8px;
                    "
                >

                    <h3
                        style="
                            margin:0 0 14px;
                            font-size:15px;
                        "
                    >
                        {{ __('General information') }}
                    </h3>


                    {{-- Title --}}

                    <div class="form-group">

                        <label
                            class="form-label"
                            for="pageContentTitle"
                        >
                            {{ __('Title') }}
                        </label>

                        <input
                            class="form-control"
                            type="text"
                            id="pageContentTitle"
                            name="title"
                            required
                            placeholder="{{ __('Enter the content title') }}"
                        >

                    </div>


                    {{-- Language --}}

                    <div class="form-row">

                        <div class="form-group">

                            <label
                                class="form-label"
                                for="contentLanguage"
                            >
                                {{ __('Primary language') }}
                            </label>

                            <select
                                class="form-control"
                                id="contentLanguage"
                                name="language"
                            >

                                <option value="en">
                                    🇬🇧 {{ __('English') }}
                                </option>

                                <option value="fr">
                                    🇫🇷 {{ __('French') }}
                                </option>

                                <option value="ar">
                                    🇩🇿 {{ __('Arabic') }}
                                </option>

                            </select>

                        </div>


                        {{-- Category --}}

                        <div class="form-group">

                            <label
                                class="form-label"
                                for="contentCategory"
                            >
                                {{ __('Category') }}
                            </label>

                            <input
                                class="form-control"
                                type="text"
                                id="contentCategory"
                                name="category"
                                placeholder="{{ __('Optional category') }}"
                            >

                        </div>

                    </div>


                    {{-- Author --}}

                    <div class="form-group">

                        <label
                            class="form-label"
                            for="contentAuthor"
                        >
                            {{ __('Author / Responsible person') }}
                        </label>

                        <input
                            class="form-control"
                            type="text"
                            id="contentAuthor"
                            name="author"
                            placeholder="{{ __('e.g. International Relations Office') }}"
                        >

                    </div>


                    {{-- Image --}}

                    <div class="form-group">

                        <label
                            class="form-label"
                            for="contentImage"
                        >
                            {{ __('Cover / Main image') }}
                        </label>

                        <input
                            class="form-control"
                            type="file"
                            id="contentImage"
                            name="image"
                            accept="image/*"
                        >

                    </div>

                </div>


                {{-- ==================================================== --}}
                {{-- HOMEPAGE                                               --}}
                {{-- ==================================================== --}}

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


                    <h4 style="margin:22px 0 12px;">
                        {{ __('Homepage statistics') }}
                    </h4>

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


                    <div class="form-group">

                        <label class="form-label">
                            {{ __('About ESI') }}
                        </label>

                        <textarea
                            class="form-control"
                            name="about_text"
                            rows="5"
                        ></textarea>

                    </div>

                </div>


                {{-- ==================================================== --}}
                {{-- SCHOOL PRESENTATION                                    --}}
                {{-- ==================================================== --}}

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
                            name="history"
                            rows="5"
                        ></textarea>

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Vision') }}
                        </label>

                        <textarea
                            class="form-control"
                            name="vision"
                            rows="4"
                        ></textarea>

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Mission') }}
                        </label>

                        <textarea
                            class="form-control"
                            name="mission"
                            rows="4"
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
                            placeholder="{{ __('List the main research domains...') }}"
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
                            name="presentation_document"
                            accept=".pdf,.doc,.docx"
                        >

                        <p class="form-hint">
                            {{ __('PDF, DOC or DOCX.') }}
                        </p>

                    </div>

                </div>


                {{-- ==================================================== --}}
                {{-- NEWS                                                    --}}
                {{-- ==================================================== --}}

                <div
                    data-fields-for="News"
                >

                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Article body') }}
                        </label>

                        <textarea
                            class="form-control"
                            name="body"
                            rows="7"
                        ></textarea>

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Related project') }}
                        </label>

                        <input
                            class="form-control"
                            type="text"
                            name="related_project"
                        >

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Related partner') }}
                        </label>

                        <input
                            class="form-control"
                            type="text"
                            name="related_partner"
                        >

                    </div>

                </div>


                {{-- ==================================================== --}}
                {{-- EVENT                                                   --}}
                {{-- ==================================================== --}}

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
                                name="event_start_date"
                            >

                        </div>

                        <div class="form-group">

                            <label class="form-label">
                                {{ __('End date/time') }}
                            </label>

                            <input
                                class="form-control"
                                type="datetime-local"
                                name="event_end_date"
                            >

                        </div>

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Event type') }}
                        </label>

                        <select
                            class="form-control"
                            name="event_type"
                        >

                            <option>{{ __('Workshop') }}</option>
                            <option>{{ __('Information day') }}</option>
                            <option>{{ __('Partner visit') }}</option>
                            <option>{{ __('Project meeting') }}</option>
                            <option>{{ __('Conference') }}</option>
                            <option>{{ __('Training') }}</option>
                            <option>{{ __('Other') }}</option>

                        </select>

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Location') }}
                        </label>

                        <input
                            class="form-control"
                            type="text"
                            name="event_location"
                        >

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Organizer') }}
                        </label>

                        <input
                            class="form-control"
                            type="text"
                            name="event_organizer"
                        >

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Registration link') }}
                        </label>

                        <input
                            class="form-control"
                            type="url"
                            name="registration_link"
                            placeholder="https://..."
                        >

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Description') }}
                        </label>

                        <textarea
                            class="form-control"
                            name="event_description"
                            rows="5"
                        ></textarea>

                    </div>

                </div>


                {{-- ==================================================== --}}
                {{-- PROJECT                                                 --}}
                {{-- ==================================================== --}}

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
                                name="project_acronym"
                            >

                        </div>

                        <div class="form-group">

                            <label class="form-label">
                                {{ __('Project reference') }}
                            </label>

                            <input
                                class="form-control"
                                type="text"
                                name="project_reference"
                            >

                        </div>

                    </div>


                    <div class="form-row">

                        <div class="form-group">

                            <label class="form-label">
                                {{ __('Funding programme') }}
                            </label>

                            <select
                                class="form-control"
                                name="project_programme"
                            >

                                <option>{{ __('Erasmus+') }}</option>
                                <option>{{ __('Horizon Europe') }}</option>
                                <option>{{ __('PRIMA') }}</option>
                                <option>{{ __('National') }}</option>
                                <option>{{ __('Other') }}</option>

                            </select>

                        </div>

                        <div class="form-group">

                            <label class="form-label">
                                {{ __("School's role") }}
                            </label>

                            <input
                                class="form-control"
                                type="text"
                                name="school_role"
                                placeholder="{{ __('Coordinator / Partner') }}"
                            >

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
                                name="project_start"
                            >

                        </div>

                        <div class="form-group">

                            <label class="form-label">
                                {{ __('End date') }}
                            </label>

                            <input
                                class="form-control"
                                type="date"
                                name="project_end"
                            >

                        </div>

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Project abstract') }}
                        </label>

                        <textarea
                            class="form-control"
                            name="project_abstract"
                            rows="5"
                        ></textarea>

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Key results / deliverables') }}
                        </label>

                        <textarea
                            class="form-control"
                            name="key_results"
                            rows="4"
                        ></textarea>

                    </div>

                </div>


                {{-- ==================================================== --}}
                {{-- CALL                                                     --}}
                {{-- ==================================================== --}}

                <div
                    data-fields-for="Call for Proposal"
                    style="display:none;"
                >

                    <div class="form-row">

                        <div class="form-group">

                            <label class="form-label">
                                {{ __('Financing organism') }}
                            </label>

                            <input
                                class="form-control"
                                type="text"
                                name="financing_organism"
                            >

                        </div>

                        <div class="form-group">

                            <label class="form-label">
                                {{ __('Action type') }}
                            </label>

                            <input
                                class="form-control"
                                type="text"
                                name="action_type"
                            >

                        </div>

                    </div>


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


                    <div class="form-row">

                        <div class="form-group">

                            <label class="form-label">
                                {{ __('Budget') }}
                            </label>

                            <input
                                class="form-control"
                                type="text"
                                name="budget"
                            >

                        </div>

                        <div class="form-group">

                            <label class="form-label">
                                {{ __('Funding rate') }}
                            </label>

                            <input
                                class="form-control"
                                type="text"
                                name="funding_rate"
                                placeholder="{{ __('e.g. 80%') }}"
                            >

                        </div>

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Eligible beneficiaries') }}
                        </label>

                        <textarea
                            class="form-control"
                            name="eligible_beneficiaries"
                            rows="3"
                        ></textarea>

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Description & objectives') }}
                        </label>

                        <textarea
                            class="form-control"
                            name="call_description"
                            rows="5"
                        ></textarea>

                    </div>

                </div>


                {{-- ==================================================== --}}
                {{-- MOBILITY                                                --}}
                {{-- ==================================================== --}}

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
                                name="mobility_host"
                            >

                        </div>

                        <div class="form-group">

                            <label class="form-label">
                                {{ __('Mobility type') }}
                            </label>

                            <select
                                class="form-control"
                                name="mobility_type"
                            >

                                <option>{{ __('Outgoing student') }}</option>
                                <option>{{ __('Incoming student') }}</option>
                                <option>{{ __('Staff') }}</option>
                                <option>{{ __('Researcher') }}</option>
                                <option>{{ __('Internship') }}</option>
                                <option>{{ __('Summer school') }}</option>

                            </select>

                        </div>

                    </div>


                    <div class="form-row">

                        <div class="form-group">

                            <label class="form-label">
                                {{ __('Country') }}
                            </label>

                            <input
                                class="form-control"
                                type="text"
                                name="mobility_country"
                            >

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


                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Conditions & selection criteria') }}
                        </label>

                        <textarea
                            class="form-control"
                            name="conditions"
                            rows="5"
                        ></textarea>

                    </div>

                </div>


                {{-- ==================================================== --}}
                {{-- PARTNERSHIP PAGE                                      --}}
                {{-- ==================================================== --}}

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
                            rows="5"
                        ></textarea>

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Why partner with ESI') }}
                        </label>

                        <textarea
                            class="form-control"
                            name="partnership_benefits"
                            rows="5"
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
                        ></textarea>

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Partnership process / steps') }}
                        </label>

                        <textarea
                            class="form-control"
                            name="partnership_process"
                            rows="5"
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

                </div>


                {{-- ==================================================== --}}
                {{-- PARTNER INSTITUTION                                    --}}
                {{-- ==================================================== --}}

                <div
                    data-fields-for="Partner Institution"
                    style="display:none;"
                >

                    <div class="form-row">

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

                        <div class="form-group">

                            <label class="form-label">
                                {{ __('Institution type') }}
                            </label>

                            <select
                                class="form-control"
                                name="institution_type"
                            >

                                <option>{{ __('University') }}</option>
                                <option>{{ __('Research centre') }}</option>
                                <option>{{ __('Company') }}</option>
                                <option>{{ __('Government institution') }}</option>
                                <option>{{ __('NGO') }}</option>
                                <option>{{ __('Other') }}</option>

                            </select>

                        </div>

                    </div>


                    <div class="form-row">

                        <div class="form-group">

                            <label class="form-label">
                                {{ __('Country') }}
                            </label>

                            <input
                                class="form-control"
                                type="text"
                                name="partner_country"
                            >

                        </div>

                        <div class="form-group">

                            <label class="form-label">
                                {{ __('City') }}
                            </label>

                            <input
                                class="form-control"
                                type="text"
                                name="partner_city"
                            >

                        </div>

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Logo') }}
                        </label>

                        <input
                            class="form-control"
                            type="file"
                            name="partner_logo"
                            accept="image/*"
                        >

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Website') }}
                        </label>

                        <input
                            class="form-control"
                            type="url"
                            name="partner_website"
                            placeholder="https://..."
                        >

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Description') }}
                        </label>

                        <textarea
                            class="form-control"
                            name="partner_description"
                            rows="4"
                        ></textarea>

                    </div>


                    <div class="form-row">

                        <div class="form-group">

                            <label class="form-label">
                                {{ __('Cooperation type') }}
                            </label>

                            <input
                                class="form-control"
                                type="text"
                                name="cooperation_type"
                                placeholder="{{ __('Erasmus+, research, exchange...') }}"
                            >

                        </div>

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


                {{-- ==================================================== --}}
                {{-- FUNDING PROGRAMME                                     --}}
                {{-- ==================================================== --}}

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
                                name="funding_name"
                                placeholder="{{ __('Horizon Europe') }}"
                            >

                        </div>

                        <div class="form-group">

                            <label class="form-label">
                                {{ __('Acronym') }}
                            </label>

                            <input
                                class="form-control"
                                type="text"
                                name="funding_acronym"
                            >

                        </div>

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Description') }}
                        </label>

                        <textarea
                            class="form-control"
                            name="funding_description"
                            rows="5"
                        ></textarea>

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Programme website') }}
                        </label>

                        <input
                            class="form-control"
                            type="url"
                            name="funding_website"
                            placeholder="https://..."
                        >

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Eligibility') }}
                        </label>

                        <textarea
                            class="form-control"
                            name="funding_eligibility"
                            rows="4"
                        ></textarea>

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Funding information') }}
                        </label>

                        <textarea
                            class="form-control"
                            name="funding_information"
                            rows="4"
                        ></textarea>

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Programme logo') }}
                        </label>

                        <input
                            class="form-control"
                            type="file"
                            name="funding_logo"
                            accept="image/*"
                        >

                    </div>

                </div>


                {{-- ==================================================== --}}
                {{-- DOCUMENT                                               --}}
                {{-- ==================================================== --}}

                <div
                    data-fields-for="Document"
                    style="display:none;"
                >

                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Document title') }}
                        </label>

                        <input
                            class="form-control"
                            type="text"
                            name="document_title"
                        >

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Document category') }}
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
                            {{ __('Description') }}
                        </label>

                        <textarea
                            class="form-control"
                            name="document_description"
                            rows="4"
                        ></textarea>

                    </div>


                    <div class="form-row">

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

                        <div class="form-group">

                            <label class="form-label">
                                {{ __('Version') }}
                            </label>

                            <input
                                class="form-control"
                                type="text"
                                name="document_version"
                                placeholder="{{ __('e.g. 1.0') }}"
                            >

                        </div>

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            {{ __('File') }}
                        </label>

                        <input
                            class="form-control"
                            type="file"
                            name="document_file"
                            accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx"
                            required
                        >

                    </div>

                </div>


                {{-- ==================================================== --}}
                {{-- TESTIMONIAL                                            --}}
                {{-- ==================================================== --}}

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
                                placeholder="{{ __('Student / Researcher / Staff') }}"
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
                            {{ __('Person photo') }}
                        </label>

                        <input
                            class="form-control"
                            type="file"
                            name="testimonial_photo"
                            accept="image/*"
                        >

                    </div>

                </div>


                {{-- ==================================================== --}}
                {{-- FAQ                                                      --}}
                {{-- ==================================================== --}}

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
                            rows="7"
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
                                placeholder="{{ __('Student Mobility') }}"
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


                {{-- ==================================================== --}}
                {{-- CONTACT INFORMATION                                    --}}
                {{-- ==================================================== --}}

                <div
                    data-fields-for="Contact Information"
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
                            placeholder="{{ __('International Relations Office') }}"
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

                        <textarea
                            class="form-control"
                            name="opening_hours"
                            rows="3"
                        ></textarea>

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Google Maps / Location link') }}
                        </label>

                        <input
                            class="form-control"
                            type="url"
                            name="maps_link"
                            placeholder="https://..."
                        >

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


                {{-- ==================================================== --}}
                {{-- PARTNERSHIP PAGE                                      --}}
                {{-- ==================================================== --}}

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
                            rows="5"
                        ></textarea>

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Why partner with ESI') }}
                        </label>

                        <textarea
                            class="form-control"
                            name="partner_page_benefits"
                            rows="5"
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
                            {{ __('Partnership process') }}
                        </label>

                        <textarea
                            class="form-control"
                            name="partner_page_process"
                            rows="5"
                        ></textarea>

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            {{ __('CTA button text') }}
                        </label>

                        <input
                            class="form-control"
                            type="text"
                            name="partner_page_cta"
                            value="{{ __('Become a partner') }}"
                        >

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            {{ __('Partner application form') }}
                        </label>

                        <input
                            class="form-control"
                            type="file"
                            name="partner_page_form"
                            accept=".pdf,.doc,.docx"
                        >

                    </div>

                </div>


                {{-- ==================================================== --}}
                {{-- COMMON PUBLISHING OPTIONS                              --}}
                {{-- ==================================================== --}}

                <div
                    style="
                        margin-top:24px;
                        padding-top:20px;
                        border-top:1px solid var(--color-neutral-300);
                    "
                >

                    <h3
                        style="
                            margin:0 0 16px;
                            font-size:15px;
                        "
                    >
                        {{ __('Publishing & visibility') }}
                    </h3>


                    {{-- Status --}}

                    <div class="form-group">

                        <label
                            class="form-label"
                            for="pgPublicationStatus"
                        >
                            {{ __('Publication status') }}
                        </label>

                        <select
                            class="form-control"
                            id="pgPublicationStatus"
                            name="publication_status"
                        >

                            <option value="draft">
                                {{ __('Draft — not visible publicly') }}
                            </option>

                            <option value="scheduled">
                                {{ __('Scheduled — publish automatically') }}
                            </option>

                            <option value="published">
                                {{ __('Published — live immediately') }}
                            </option>

                        </select>

                    </div>


                    {{-- Scheduled date --}}

                    <div
                        class="form-group"
                        id="scheduledAtGroup"
                        style="display:none;"
                    >

                        <label
                            class="form-label"
                            for="pgScheduledAt"
                        >
                            {{ __('Scheduled publish date') }}
                        </label>

                        <input
                            class="form-control"
                            type="datetime-local"
                            id="pgScheduledAt"
                            name="scheduled_at"
                        >

                    </div>


                    {{-- Publication date --}}

                    <div class="form-group">

                        <label
                            class="form-label"
                            for="publicationDate"
                        >
                            {{ __('Publication date') }}
                        </label>

                        <input
                            class="form-control"
                            type="date"
                            id="publicationDate"
                            name="publication_date"
                        >

                    </div>


                    {{-- Featured --}}

                    <div
                        style="
                            display:flex;
                            gap:20px;
                            flex-wrap:wrap;
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

                            {{ __('Featured content') }}

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


                {{-- ==================================================== --}}
                {{-- TRANSLATIONS                                           --}}
                {{-- ==================================================== --}}

                <div
                    style="
                        margin-top:24px;
                        padding:16px;
                        border:1px solid var(--color-neutral-300);
                        border-radius:8px;
                    "
                >

                    <h3
                        style="
                            margin:0 0 6px;
                            font-size:15px;
                        "
                    >
                        {{ __('Translations') }}
                    </h3>

                    <p
                        style="
                            margin:0 0 16px;
                            color:var(--color-neutral-500);
                            font-size:12px;
                        "
                    >
                        {{ __('Add translated versions of the title and summary for the EN / FR / AR portal.') }}
                    </p>


                    <div class="form-group">

                        <label class="form-label">
                            🇬🇧 {{ __('English title') }}
                        </label>

                        <input
                            class="form-control"
                            type="text"
                            name="title_en"
                        >

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            🇫🇷 {{ __('French title') }}
                        </label>

                        <input
                            class="form-control"
                            type="text"
                            name="title_fr"
                        >

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            🇩🇿 {{ __('Arabic title') }}
                        </label>

                        <input
                            class="form-control"
                            type="text"
                            name="title_ar"
                            dir="rtl"
                        >

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            🇬🇧 {{ __('English summary') }}
                        </label>

                        <textarea
                            class="form-control"
                            name="summary_en"
                            rows="3"
                        ></textarea>

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            🇫🇷 {{ __('French summary') }}
                        </label>

                        <textarea
                            class="form-control"
                            name="summary_fr"
                            rows="3"
                        ></textarea>

                    </div>


                    <div class="form-group">

                        <label class="form-label">
                            🇩🇿 {{ __('Arabic summary') }}
                        </label>

                        <textarea
                            class="form-control"
                            name="summary_ar"
                            rows="3"
                            dir="rtl"
                        ></textarea>

                    </div>

                </div>


                {{-- ==================================================== --}}
                {{-- BUTTONS                                                 --}}
                {{-- ==================================================== --}}

                <div
                    class="flex-row"
                    style="margin-top:24px;"
                >

                    <button
                        type="submit"
                        class="btn btn--primary"
                    >
                        {{ __('Save') }}
                    </button>

                    <button
                        type="button"
                        class="btn btn--outline"
                        id="contentPreviewButton"
                    >
                        {{ __('Preview') }}
                    </button>

                    <a
                        href="{{ url('/admin/cooperation') }}"
                        class="btn btn--outline"
                    >
                        {{ __('Cancel') }}
                    </a>

                </div>

            </form>

        </div>

    </div>


    {{-- ================================================================ --}}
    {{-- SIDEBAR                                                          --}}
    {{-- ================================================================ --}}

    <aside>

        <div class="card">

            <div class="card__body">

                <h3 class="card__title">
                    {{ __('Publishing Guide') }}
                </h3>

                <p class="card__text">
                    {{ __('Draft content is only visible in the administration area.') }}
                </p>

                <p class="card__text">
                    {{ __('Scheduled content becomes public automatically at the selected date and time.') }}
                </p>

                <p class="card__text">
                    {{ __('Published content is immediately available on the public portal.') }}
                </p>

            </div>

        </div>


        <div
            class="card"
            style="margin-top:16px;"
        >

            <div class="card__body">

                <h3 class="card__title">
                    {{ __('Content checklist') }}
                </h3>

                <ul
                    style="
                        margin:12px 0 0;
                        padding-left:18px;
                        font-size:12.5px;
                        line-height:1.8;
                    "
                >

                    <li>{{ __('Choose the correct content type') }}</li>

                    <li>{{ __('Complete the required information') }}</li>

                    <li>{{ __('Add images or documents if necessary') }}</li>

                    <li>{{ __('Add translations') }}</li>

                    <li>{{ __('Choose publication status') }}</li>

                    <li>{{ __('Mark as featured if needed') }}</li>

                    <li>{{ __('Preview before publishing') }}</li>

                </ul>

            </div>

        </div>

    </aside>

</div>


{{-- ================================================================ --}}
{{-- CONTENT TYPE SWITCHING                                            --}}
{{-- ================================================================ --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const typeSelect = document.getElementById('pageContentType');
    const sections = document.querySelectorAll('[data-fields-for]');

    function updateContentFields() {

        const selectedType = typeSelect.value;

        sections.forEach(function (section) {

            const isActive =
                section.getAttribute('data-fields-for') === selectedType;

            section.style.display = isActive ? '' : 'none';

            /*
             * Disable inputs inside inactive sections.
             *
             * This prevents fields belonging to another content type
             * from accidentally being submitted to the backend.
             */
            section.querySelectorAll('input, textarea, select').forEach(function (field) {
                field.disabled = !isActive;
            });

        });

    }


    typeSelect?.addEventListener('change', updateContentFields);

    updateContentFields();


    // ---------------------------------------------------------------
    // Publication status
    // ---------------------------------------------------------------

    const publicationStatus =
        document.getElementById('pgPublicationStatus');

    const scheduledGroup =
        document.getElementById('scheduledAtGroup');

    function updateScheduleField() {

        const scheduled =
            publicationStatus?.value === 'scheduled';

        if (scheduledGroup) {
            scheduledGroup.style.display = scheduled ? '' : 'none';
        }

        const scheduledInput =
            document.getElementById('pgScheduledAt');

        if (scheduledInput) {
            scheduledInput.disabled = !scheduled;
        }

    }


    publicationStatus?.addEventListener(
        'change',
        updateScheduleField
    );

    updateScheduleField();


    // ---------------------------------------------------------------
    // Preview
    // ---------------------------------------------------------------

    document
        .getElementById('contentPreviewButton')
        ?.addEventListener('click', function () {

            /*
             * Keep this compatible with the existing admin demo system.
             * Replace this later with the real preview route.
             */

            if (typeof window.showToast === 'function') {

                window.showToast(
                    '{{ __("Preview will render the selected content using the public page template once the backend preview route is connected.") }}'
                );

            } else {

                alert(
                    '{{ __("Preview will render the selected content using the public page template once the backend preview route is connected.") }}'
                );

            }

        });

});

</script>

@endsection