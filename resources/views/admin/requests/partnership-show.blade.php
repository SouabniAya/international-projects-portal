@extends('layouts.admin')

@section('title', 'Partnership Request Details')
@php($active = 'requests-documents')

@section('content')
<div class="section__header section__header--row" style="margin-bottom:18px;">
    <div>
        <h2 style="margin:0;">{{ $r->requesterName }}</h2>
        <p style="margin:4px 0 0;">{{ $r->submissionDate?->format('d M Y h:i A') ?? '—' }}</p>
    </div>
    <div style="display:flex; gap:10px; flex-wrap:wrap;">
        <form method="POST" action="{{ route('admin.partnership.approve', $r->requestID) }}" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn--primary btn--sm">Approve</button>
        </form>
        <form method="POST" action="{{ route('admin.partnership.reject', $r->requestID) }}" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn--outline btn--sm">Reject</button>
        </form>
        <a href="{{ route('admin.requests-documents') }}" class="btn btn--outline btn--sm">Back</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert--success" style="margin-bottom:18px;">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card__body" style="display:grid; gap:18px;">
        <div>
            <strong>Status:</strong>
            <span class="reqdocs-table__status reqdocs-table__status--{{ strtolower($r->status) }}">{{ ucfirst($r->status) }}</span>
        </div>
        <div>
            <strong>Organization:</strong> {{ $r->organizationName ?: '—' }}
        </div>
        <div>
            <strong>Email:</strong> {{ $r->email }}
        </div>
        <div>
            <strong>Phone:</strong> {{ $r->phone ?: '—' }}
        </div>
        <div>
            <strong>Country:</strong> {{ $r->countryModel?->countryName ?? $r->country ?? '—' }}
        </div>
        <div>
            <strong>Assigned to:</strong> {{ $r->handler->firstName ?? 'Unassigned' }}
        </div>
        <div>
            <strong>Message:</strong>
            <div style="margin-top:8px; white-space:pre-wrap;">{{ $r->message ?: 'No message provided.' }}</div>
        </div>
        <div>
            <strong>Attached documents:</strong>
            @if($r->documents->isEmpty())
                <p style="margin-top:8px;">No documents attached.</p>
            @else
                <ul style="margin-top:8px;">
                    @foreach($r->documents as $doc)
                        <li>
                            <a href="{{ route('documents.download', $doc->documentID) }}">{{ $doc->title }}</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection