{{-- resources/views/admin/content/create.blade.php — dedicated publishing page (Rym's requested alternative to the modal) --}}
@extends('layouts.admin')

@section('title', 'Publish Content')

@php($active = 'cooperation')

@section('content')

<div class="breadcrumbs" style="margin-bottom:8px;">
    <a href="{{ url('/admin/cooperation') }}">Content Management</a> / Publish Content
</div>
<div class="section__header" style="margin-bottom:24px;">
    <h2 style="margin:0;">Publish Content</h2>
    <p style="margin:4px 0 0;">Choose a content type, fill in its fields, and control when it goes live.</p>
</div>

<div class="two-col--narrow-first" style="display:grid; gap:32px;">
    <div class="card">
        <div class="card__body">
            <form method="POST" action="{{ route('admin.content.store') }}" data-demo-submit="Content saved (demo — connect this route to persist).">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="pageContentType">Content type</label>
                    <select class="form-control" id="pageContentType" name="content_type" data-content-type-select>
                        <option value="News">News</option>
                        <option value="Event">Event</option>
                        <option value="Project">Project</option>
                        <option value="Call for Proposal">Call for Proposal</option>
                        <option value="Mobility Opportunity">Mobility Opportunity</option>
                        <option value="Partnership">Partnership</option>
                    </select>
                    <p class="form-hint">Only the fields relevant to this type will appear below.</p>
                </div>

                <div class="form-group">
                    <label class="form-label" for="pageContentTitle">Title</label>
                    <input class="form-control" type="text" id="pageContentTitle" name="title" required>
                </div>

                <div data-fields-for="News">
                    <div class="form-group">
                        <label class="form-label" for="pgNewsBody">Article body</label>
                        <textarea class="form-control" id="pgNewsBody" name="body" rows="5"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="pgNewsImage">Cover image</label>
                        <input class="form-control" type="file" id="pgNewsImage" name="image" accept="image/*">
                    </div>
                </div>

                <div data-fields-for="Event" style="display:none;">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="pgEventStart">Start date/time</label>
                            <input class="form-control" type="datetime-local" id="pgEventStart" name="start_date">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="pgEventEnd">End date/time</label>
                            <input class="form-control" type="datetime-local" id="pgEventEnd" name="end_date">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="pgEventType">Event type</label>
                        <select class="form-control" id="pgEventType" name="event_type">
                            <option>Workshop</option>
                            <option>Information day</option>
                            <option>Partner visit</option>
                            <option>Project meeting</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="pgEventLocation">Location</label>
                        <input class="form-control" type="text" id="pgEventLocation" name="location">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="pgEventDescription">Description</label>
                        <textarea class="form-control" id="pgEventDescription" name="description" rows="4"></textarea>
                    </div>
                </div>

                <div data-fields-for="Project" style="display:none;">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="pgProjectAcronym">Acronym</label>
                            <input class="form-control" type="text" id="pgProjectAcronym" name="acronym">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="pgProjectRef">Project reference</label>
                            <input class="form-control" type="text" id="pgProjectRef" name="reference">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="pgProjectProgramme">Funding programme</label>
                            <select class="form-control" id="pgProjectProgramme" name="programme">
                                <option>Erasmus+</option>
                                <option>Horizon Europe</option>
                                <option>PRIMA</option>
                                <option>National</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="pgProjectRole">School's role</label>
                            <input class="form-control" type="text" id="pgProjectRole" name="school_role" placeholder="e.g. Coordinator, Partner">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="pgProjectStart">Start date</label>
                            <input class="form-control" type="date" id="pgProjectStart" name="start_date">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="pgProjectEnd">End date</label>
                            <input class="form-control" type="date" id="pgProjectEnd" name="end_date">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="pgProjectAbstract">Abstract</label>
                        <textarea class="form-control" id="pgProjectAbstract" name="abstract" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="pgProjectResults">Key results / deliverables</label>
                        <textarea class="form-control" id="pgProjectResults" name="key_results" rows="3"></textarea>
                    </div>
                </div>

                <div data-fields-for="Call for Proposal" style="display:none;">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="pgCallOrganism">Financing organism</label>
                            <input class="form-control" type="text" id="pgCallOrganism" name="financing_organism">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="pgCallActionType">Action type</label>
                            <input class="form-control" type="text" id="pgCallActionType" name="action_type">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="pgCallOpening">Opening date</label>
                            <input class="form-control" type="date" id="pgCallOpening" name="opening_date">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="pgCallDeadline">Deadline</label>
                            <input class="form-control" type="date" id="pgCallDeadline" name="deadline">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="pgCallBudget">Budget</label>
                            <input class="form-control" type="text" id="pgCallBudget" name="budget">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="pgCallRate">Funding rate</label>
                            <input class="form-control" type="text" id="pgCallRate" name="funding_rate" placeholder="e.g. 80%">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="pgCallBeneficiaries">Eligible beneficiaries</label>
                        <textarea class="form-control" id="pgCallBeneficiaries" name="eligible_beneficiaries" rows="2"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="pgCallDescription">Description &amp; objectives</label>
                        <textarea class="form-control" id="pgCallDescription" name="description" rows="3"></textarea>
                    </div>
                </div>

                <div data-fields-for="Mobility Opportunity" style="display:none;">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="pgMobHost">Hosting establishment</label>
                            <input class="form-control" type="text" id="pgMobHost" name="host">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="pgMobType">Mobility type</label>
                            <select class="form-control" id="pgMobType" name="mobility_type">
                                <option>Outgoing student</option>
                                <option>Incoming student</option>
                                <option>Staff</option>
                                <option>Researcher</option>
                                <option>Internship</option>
                                <option>Summer school</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="pgMobPlaces">Places available</label>
                            <input class="form-control" type="number" id="pgMobPlaces" name="places" min="1">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="pgMobDeadline">Application deadline</label>
                            <input class="form-control" type="date" id="pgMobDeadline" name="application_deadline">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="pgMobConditions">Conditions &amp; selection criteria</label>
                        <textarea class="form-control" id="pgMobConditions" name="conditions" rows="3"></textarea>
                    </div>
                </div>

                <div data-fields-for="Partnership" style="display:none;">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="pgPartnerCountry">Country</label>
                            <input class="form-control" type="text" id="pgPartnerCountry" name="country">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="pgPartnerType">Institution type</label>
                            <select class="form-control" id="pgPartnerType" name="type">
                                <option>University</option>
                                <option>Research center</option>
                                <option>Company</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="pgPartnerPresentation">Presentation</label>
                        <textarea class="form-control" id="pgPartnerPresentation" name="presentation" rows="3"></textarea>
                    </div>
                </div>

                <div class="form-group" style="margin-top:8px;">
                    <label class="form-label" for="pgPublicationStatus">Publication status</label>
                    <select class="form-control" id="pgPublicationStatus" name="publication_status">
                        <option value="draft">Draft — not visible publicly</option>
                        <option value="scheduled">Scheduled — set a publish date</option>
                        <option value="published">Published — live immediately</option>
                    </select>
                </div>
                <div class="form-group" id="scheduledAtGroup" style="display:none;">
                    <label class="form-label" for="pgScheduledAt">Scheduled publish date</label>
                    <input class="form-control" type="datetime-local" id="pgScheduledAt" name="scheduled_at">
                </div>

                <div class="flex-row" style="margin-top:8px;">
                    <button type="submit" class="btn btn--primary">Save</button>
                    <button type="button" class="btn btn--outline" data-toast="Preview isn't wired to real content yet — this will render the actual page template once the backend exists.">Preview</button>
                    <a href="{{ url('/admin/cooperation') }}" class="btn btn--outline">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <aside>
        <div class="card">
            <div class="card__body">
                <h3 class="card__title">Publishing Guide</h3>
                <p class="card__text">Draft content is only visible in this admin area. Scheduled content publishes automatically at the date you set. Published content is immediately live on the public site.</p>
            </div>
        </div>
    </aside>
</div>

<script>
  document.getElementById('pgPublicationStatus')?.addEventListener('change', function () {
    document.getElementById('scheduledAtGroup').style.display = this.value === 'scheduled' ? '' : 'none';
  });
</script>

@endsection
