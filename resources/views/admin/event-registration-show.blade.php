@extends('layouts.admin')

@section('title', 'Event Registration')

@section('content')

<div class="registration-page">

<a href="{{ route('admin.event-registrations') }}" class="back-link">
    <span>←</span>
    Back to registrations
</a>

{{-- Header --}}
<div class="registration-header">
    <div>
        <h1>Event Registration</h1>
        <p class="registration-number">
            Registration #{{ $registration->registrationID }}
        </p>
    </div>
</div>


{{-- ========================================================= --}}
{{-- REGISTRATION INFORMATION --}}
{{-- ========================================================= --}}

<div class="registration-card">

    <div class="registration-card-header">

        <div>
            <h2>Registration information</h2>
            <p class="card-subtitle">
                Details submitted by the participant
            </p>
        </div>

        {{-- Status --}}
        @if($registration->status === 'pending')

            <span class="status-badge status-pending">
                Pending
            </span>

        @elseif($registration->status === 'approved')

            <span class="status-badge status-approved">
                Approved
            </span>

        @else

            <span class="status-badge status-rejected">
                Rejected
            </span>

        @endif

    </div>


    <div class="registration-info">

        {{-- Event --}}
        <div class="info-row">

            <div class="info-label">
                Event
            </div>

            <div class="info-value">
                <strong>
                    {{ $registration->event?->translation(app()->getLocale())?->title
                        ?? $registration->event?->translation('en')?->title
                        ?? '—' }}
                </strong>
            </div>

        </div>


        {{-- Full name --}}
        <div class="info-row">

            <div class="info-label">
                Full name
            </div>

            <div class="info-value">
                {{ $registration->fullName ?: '—' }}
            </div>

        </div>


        {{-- Email --}}
        <div class="info-row">

            <div class="info-label">
                Email
            </div>

            <div class="info-value">

                <a href="mailto:{{ $registration->email }}"
                   class="info-link">

                    {{ $registration->email }}

                </a>

            </div>

        </div>


        {{-- Phone --}}
        <div class="info-row">

            <div class="info-label">
                Phone
            </div>

            <div class="info-value">

                @if($registration->phone)

                    <a href="tel:{{ $registration->phone }}"
                       class="info-link">

                        {{ $registration->phone }}

                    </a>

                @else

                    <span class="empty-value">
                        Not provided
                    </span>

                @endif

            </div>

        </div>


        {{-- Attending as --}}
        @php

            $attendeeTypes = [
                'participant' => 'Participant',
                'speaker' => 'Speaker',
                'partner' => 'Partner institution representative',
                'press' => 'Press / Media',
                'other' => 'Other',
            ];

        @endphp

        <div class="info-row">

            <div class="info-label">
                Attending as
            </div>

            <div class="info-value">

                <span class="attendee-badge">
                    {{ $attendeeTypes[$registration->subjectCode]
                        ?? $registration->subjectCode
                        ?? '—' }}
                </span>

            </div>

        </div>


        {{-- Submitted --}}
        <div class="info-row">

            <div class="info-label">
                Submitted
            </div>

            <div class="info-value">

                {{ $registration->submissionDate?->format('d M Y, H:i')
                    ?? '—' }}

            </div>

        </div>


        {{-- Consent --}}
        <div class="info-row">

            <div class="info-label">
                Consent
            </div>

            <div class="info-value">

                @if($registration->consent)

                    <span class="consent-badge consent-yes">
                        ✓ Yes
                    </span>

                @else

                    <span class="consent-badge consent-no">
                        ✕ No
                    </span>

                @endif

            </div>

        </div>


        {{-- Handled by --}}
        <div class="info-row">

            <div class="info-label">
                Handled by
            </div>

            <div class="info-value">

                @if($registration->handler)

                    {{ $registration->handler->firstName }}

                @else

                    <span class="empty-value">
                        Not handled yet
                    </span>

                @endif

            </div>

        </div>


        {{-- Additional information --}}
        <div class="info-row info-row-message">

            <div class="info-label">
                Additional information
            </div>

            <div class="info-value">

                @if($registration->message)

                    <div class="message-box">
                        {{ $registration->message }}
                    </div>

                @else

                    <div class="message-box message-empty">
                        No additional information provided.
                    </div>

                @endif

            </div>

        </div>

    </div>

</div>



{{-- ========================================================= --}}
{{-- ACTIONS --}}
{{-- ========================================================= --}}

<div class="registration-card actions-card">

    <div class="registration-card-header">

        <div>
            <h2>Actions</h2>

            <p class="card-subtitle">
                Manage this registration
            </p>
        </div>

    </div>


    <div class="registration-actions">

        {{-- APPROVE --}}
        @if($registration->status !== 'approved')

            <form method="POST"
                  action="{{ route(
                      'admin.event-registrations.status',
                      $registration->registrationID
                  ) }}">

                @csrf
                @method('PATCH')

                <input type="hidden"
                       name="status"
                       value="approved">

                <button type="submit"
                        class="btn-approve">

                    <span class="button-icon">✓</span>

                    Approve registration

                </button>

            </form>

        @endif


        {{-- REJECT --}}
        @if($registration->status !== 'rejected')

            <form method="POST"
                  action="{{ route(
                      'admin.event-registrations.status',
                      $registration->registrationID
                  ) }}">

                @csrf
                @method('PATCH')

                <input type="hidden"
                       name="status"
                       value="rejected">

                <button type="submit"
                        class="btn-reject">

                    <span class="button-icon">×</span>

                    Reject registration

                </button>

            </form>

        @endif


        {{-- Already approved --}}
        @if($registration->status === 'approved')

            <div class="action-info action-info-success">
                ✓ This registration has been approved.
            </div>

        @endif


        {{-- Already rejected --}}
        @if($registration->status === 'rejected')

            <div class="action-info action-info-danger">
                ✕ This registration has been rejected.
            </div>

        @endif

    </div>

</div>


</div>

@endsection
