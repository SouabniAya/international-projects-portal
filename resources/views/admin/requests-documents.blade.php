@extends('layouts.admin')

@section('title', __('Requests & Documents Management'))

@section('content')
<div class="reqdocs-page">

    <div class="reqdocs-page__head">
        <h1>{{ __('Requests & Documents Management') }}</h1>
        <p>{{ __('Manage incoming requests and the document library in one centralized place.') }}</p>
    </div>

    @if (session('success'))
        <div class="alert alert--success" style="margin-bottom:16px; padding:12px 16px; border-radius:8px; background:#E6F4EA; color:#1E7E34;">
            {{ session('success') }}
        </div>
    @endif

    {{-- Contact Requests --}}
    <section class="reqdocs-panel">
        <div class="reqdocs-panel__head">
            <h2>{{ __('Contact Requests') }}</h2>
            <a href="#" class="reqdocs-panel__view-all">
                {{ __('View All') }}
            </a>
        </div>

        <div class="reqdocs-table-wrap">
            <table class="reqdocs-table">
                <thead>
                    <tr>
                        <th>Requester</th>
                        <th>Subject</th>
                        <th>Submitted On</th>
                        <th>Status</th>
                        <th>Assigned To</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($contactRequests as $r)
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
                        <td>{{ $r['date']->format('d M Y h:i A') }}</td>
                        <td><span class="reqdocs-table__status reqdocs-table__status--{{ strtolower($r['status']) }}">{{ ucfirst($r['status']) }}</span></td>
                        <td>
                            @if ($r['assigned'])
                                {{ $r['assigned'] }}
                            @else
                                <span class="reqdocs-table__unassigned">Unassigned</span>
                            @endif
                        </td>
                        <td>
                            <div class="reqdocs-table__actions">
                                <button type="button" aria-label="Assign">
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="8" r="3.4" stroke="currentColor" stroke-width="1.6"/><path d="M5 20c0-3.6 3.1-5.6 7-5.6s7 2 7 5.6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                                </button>
                                <a href="{{ route('admin.requests.contact.show', $r['id']) }}" aria-label="View">
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.5 12S5 5 12 5s10.5 7 10.5 7-3.5 7-10.5 7-10.5-7-10.5-7Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.6"/></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" style="text-align:center; padding:24px;">No contact requests yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>


    {{-- Partnership Requests --}}
    <section class="reqdocs-panel">

        <div class="reqdocs-panel__head">
            <h2>{{ __('Partnership Requests') }}</h2>

            <a href="#" class="reqdocs-panel__view-all">
                {{ __('View All') }}
            </a>
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
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($partnerRequests as $r)
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
                        <td><img src="{{ asset('images/flags/' . $r['country'] . '.png') }}" alt="" class="reqdocs-table__flag"></td>
                        <td>{{ $r['phone'] }}</td>
                        <td class="reqdocs-table__center">{{ $r['docs'] }}</td>
                        <td><span class="reqdocs-table__status reqdocs-table__status--{{ strtolower($r['status']) }}">{{ ucfirst($r['status']) }}</span></td>
                        <td>
                            <div class="reqdocs-table__actions">
                                <form method="POST" action="{{ route('admin.partnership.approve', $r['id']) }}" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="reqdocs-table__icon-btn reqdocs-table__icon-btn--approve" aria-label="Approve">
                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 13l4 4 10-10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.partnership.reject', $r['id']) }}" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="reqdocs-table__icon-btn reqdocs-table__icon-btn--reject" aria-label="Reject">
                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                                    </button>
                                </form>
                                <a href="{{ route('admin.requests.partnership.show', $r['id']) }}" aria-label="View">
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.5 12S5 5 12 5s10.5 7 10.5 7-3.5 7-10.5 7-10.5-7-10.5-7Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.6"/></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" style="text-align:center; padding:24px;">No partnership requests yet.</td></tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </section>


    {{-- Document Library --}}
    <section class="reqdocs-panel">

        <div class="reqdocs-panel__head">
            <h2>Document Library</h2>
        </div>

        <div class="reqdocs-table-wrap">

            <table class="reqdocs-table">

                <thead>
                    <tr>
                        <th>{{ __('Title') }}</th>
                        <th>{{ __('Category') }}</th>
                        <th>{{ __('Publication Date') }}</th>
                        <th>{{ __('Visibility') }}</th>
                        <th>{{ __('File / Link') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($documents as $doc)
                    <tr>
                        <td>
                            <div class="reqdocs-table__doc">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="reqdocs-table__doc-icon"><path d="M6 2h9l5 5v15H6V2Z" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round" fill="#FDEBEC"/><path d="M15 2v5h5" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/></svg>
                                <span>{{ $doc['title'] }}</span>
                            </div>
                        </td>
                        <td>{{ $doc['category'] }}</td>
                        <td>{{ $doc['date']->format('d M Y') }}</td>
                        <td>{{ $doc['visibility'] }}</td>
                        <td><a href="{{ route('documents.download', $doc['id']) }}" class="reqdocs-table__filelink">{{ $doc['format'] }} ({{ $doc['size'] }})</a></td>
                        <td>
                            <div class="reqdocs-table__actions">
                                <a href="{{ route('documents.download', $doc['id']) }}" aria-label="Download">
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 3v12m0 0l-4-4m4 4l4-4M5 21h14" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </a>
                                <form method="POST" action="{{ route('admin.document.approve', $doc['id']) }}" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="reqdocs-table__icon-btn reqdocs-table__icon-btn--approve" aria-label="Approve">
                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 13l4 4 10-10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.document.reject', $doc['id']) }}" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="reqdocs-table__icon-btn reqdocs-table__icon-btn--reject" aria-label="Reject">
                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" style="text-align:center; padding:24px;">No documents yet.</td></tr>
                    @endforelse
                </tbody>

            </table>

        </div>

    </section>

</div>
@endsection