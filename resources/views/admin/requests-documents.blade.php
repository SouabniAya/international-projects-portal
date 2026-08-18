@extends('layouts.admin')

@section('title', 'Requests & Documents Management')

@section('content')
<div class="reqdocs-page">

    <div class="reqdocs-page__head">
        <h1>Requests & Documents Management</h1>
        <p>Manage incoming requests and the document library in one centralized place.</p>
    </div>

    {{-- Contact Requests --}}
    <section class="reqdocs-panel">
        <div class="reqdocs-panel__head">
            <h2>Contact Requests</h2>
            <a href="#" class="reqdocs-panel__view-all">View All</a>
        </div>

        <div class="reqdocs-table-wrap">
            <table class="reqdocs-table">
                <thead>
                    <tr>
                        <th>Requester</th>
                        <th>Subject</th>
                        <th>Reason</th>
                        <th>Submitted On</th>
                        <th>Status</th>
                        <th>Assigned To</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $contactRequests = collect(range(1, 3))->map(fn() => [
                        'name' => 'Mohamed Salah',
                        'email' => 'm.salah@email.com',
                        'subject' => 'Information about funding opportunities',
                        'reason' => 'Request for information',
                        'date' => '15 May 2024 10:23 AM',
                        'status' => 'New',
                        'assigned' => 'Unassigned',
                    ]);
                    @endphp

                    @foreach($contactRequests as $r)
                    <tr>
                        <td>
                            <div class="reqdocs-table__requester">
                                <span class="reqdocs-table__dot"></span>
                                <div>
                                    <strong>{{ $r['name'] }}</strong>
                                    <span>{{ $r['email'] }}</span>
                                </div>
                            </div>
                        </td>
                        <td>{{ $r['subject'] }}</td>
                        <td>{{ $r['reason'] }}</td>
                        <td>{{ $r['date'] }}</td>
                        <td><span class="reqdocs-table__status reqdocs-table__status--new">{{ $r['status'] }}</span></td>
                        <td><span class="reqdocs-table__unassigned">{{ $r['assigned'] }}</span></td>
                        <td>
                            <div class="reqdocs-table__actions">
                                <button type="button" aria-label="Assign">
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="8" r="3.4" stroke="currentColor" stroke-width="1.6"/><path d="M5 20c0-3.6 3.1-5.6 7-5.6s7 2 7 5.6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                                </button>
                                <button type="button" aria-label="View">
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.5 12S5 5 12 5s10.5 7 10.5 7-3.5 7-10.5 7-10.5-7-10.5-7Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.6"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    {{-- Partnership Requests --}}
    <section class="reqdocs-panel">
        <div class="reqdocs-panel__head">
            <h2>Partnership Requests</h2>
            <a href="#" class="reqdocs-panel__view-all">View All</a>
        </div>

        <div class="reqdocs-table-wrap">
            <table class="reqdocs-table">
                <thead>
                    <tr>
                        <th>Requester</th>
                        <th>Organization</th>
                        <th>Country</th>
                        <th>Contact</th>
                        <th>Documents</th>
                        <th>Status</th>
                        <th>Assigned to</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $partnerRequests = collect(range(1, 3))->map(fn() => [
                        'name' => 'Nadia H.',
                        'email' => 'nadia.h@eust.edu',
                        'org' => 'European University of Science',
                        'country_flag' => 'images/flags/fr.png',
                        'phone' => '+33 1 23 45 67 89',
                        'docs' => 2,
                        'status' => 'Pending',
                        'assigned' => 'Unassigned',
                    ]);
                    @endphp

                    @foreach($partnerRequests as $r)
                    <tr>
                        <td>
                            <div class="reqdocs-table__requester">
                                <span class="reqdocs-table__dot"></span>
                                <div>
                                    <strong>{{ $r['name'] }}</strong>
                                    <span>{{ $r['email'] }}</span>
                                </div>
                            </div>
                        </td>
                        <td>{{ $r['org'] }}</td>
                        <td><img src="{{ asset($r['country_flag']) }}" alt="" class="reqdocs-table__flag"></td>
                        <td>{{ $r['phone'] }}</td>
                        <td class="reqdocs-table__center">{{ $r['docs'] }}</td>
                        <td><span class="reqdocs-table__status reqdocs-table__status--pending">{{ $r['status'] }}</span></td>
                        <td><span class="reqdocs-table__unassigned">{{ $r['assigned'] }}</span></td>
                        <td>
                            <div class="reqdocs-table__actions">
                                <button type="button" class="reqdocs-table__icon-btn reqdocs-table__icon-btn--approve" aria-label="Approve">
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 13l4 4 10-10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </button>
                                <button type="button" class="reqdocs-table__icon-btn reqdocs-table__icon-btn--reject" aria-label="Reject">
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                                </button>
                                <button type="button" aria-label="View">
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.5 12S5 5 12 5s10.5 7 10.5 7-3.5 7-10.5 7-10.5-7-10.5-7Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.6"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    {{-- Document Library --}}
    <section class="reqdocs-panel">
        <div class="reqdocs-panel__head">
            <h2>Document Library</h2>
            <button type="button" class="reqdocs-panel__add">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                Add Document
            </button>
        </div>

        <div class="reqdocs-table-wrap">
            <table class="reqdocs-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Publication Date</th>
                        <th>Visibility</th>
                        <th>File / Link</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $documents = [
                        ['title' => 'Guide to Horizon Europe Programme', 'category' => 'Funding Programmes', 'date' => '10 Apr 2024', 'visibility' => 'Public', 'size' => '2.3 MB'],
                    ];
                    @endphp

                    @foreach($documents as $doc)
                    <tr>
                        <td>
                            <div class="reqdocs-table__doc">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="reqdocs-table__doc-icon"><path d="M6 2h9l5 5v15H6V2Z" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round" fill="#FDEBEC"/><path d="M15 2v5h5" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/></svg>
                                <span>{{ $doc['title'] }}</span>
                            </div>
                        </td>
                        <td>{{ $doc['category'] }}</td>
                        <td>{{ $doc['date'] }}</td>
                        <td>{{ $doc['visibility'] }}</td>
                        <td><a href="#" class="reqdocs-table__filelink">PDF ({{ $doc['size'] }})</a></td>
                        <td>
                            <div class="reqdocs-table__actions">
                                <button type="button" aria-label="Download">
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 3v12m0 0l-4-4m4 4l4-4M5 21h14" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </button>
                                <button type="button" aria-label="Edit">
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 20l1-4L16 5l3 3L8 19l-4 1Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                                </button>
                                <button type="button" aria-label="More">
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="5" cy="12" r="1.4" fill="currentColor"/><circle cx="12" cy="12" r="1.4" fill="currentColor"/><circle cx="19" cy="12" r="1.4" fill="currentColor"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

</div>
@endsection