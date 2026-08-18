@extends('layouts.admin')

@section('title', 'Notifications')

@section('content')
<div class="notif-page">

    <a href="{{ url('/admin/dashboard') }}" class="notif-page__back">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 6l-6 6 6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        Back to Dashboard
    </a>

    <div class="notif-page__head">
        <div>
            <h1>Notifications</h1>
            <p>View, manage and send notifications to users.</p>
        </div>
        <a href="#" class="notif-page__btn">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
            New Notification
        </a>
    </div>

    <div class="notif-table-wrap">
        <table class="notif-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Audience</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Scheduled / Sent</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @php
                // Placeholder data -- replace with real Notification model/query later
                $notifications = [
                    ['id' => 1, 'icon' => 'megaphone', 'color' => 'purple', 'title' => 'MSCA Doctoral Networks 2025 – Call Open', 'desc' => 'The MSCA Doctoral Networks 2025 call is now open. Deadline: May 28, 2025.', 'type' => 'Call for Proposals', 'audience' => 'Researchers', 'priority' => 'High', 'status' => 'Sent', 'datetime' => ['Apr 15, 2025', '10:30 AM']],
                    ['id' => 2, 'icon' => 'calendar', 'color' => 'orange', 'title' => 'Erasmus+ KA220 Partnerships – Call Open', 'desc' => 'The Erasmus+ KA220 Partnerships call is open. Submit your proposal before the deadline.', 'type' => 'Call for Proposals', 'audience' => 'Academics', 'priority' => 'Medium', 'status' => 'Scheduled', 'datetime' => ['May 10, 2025', '09:00 AM']],
                    ['id' => 3, 'icon' => 'plane', 'color' => 'green', 'title' => 'Mobility Opportunities – Spring 2025', 'desc' => 'New mobility opportunities are available for students and staff.', 'type' => 'Mobility', 'audience' => 'Students, Staff', 'priority' => 'Low', 'status' => 'Sent', 'datetime' => ['Apr 10, 2025', '03:15 PM']],
                    ['id' => 4, 'icon' => 'document', 'color' => 'blue', 'title' => 'Horizon Europe Info Day', 'desc' => 'Join our Horizon Europe Info Day on May 5, 2025 to learn more about the programme.', 'type' => 'Event', 'audience' => 'Researchers', 'priority' => 'Medium', 'status' => 'Scheduled', 'datetime' => ['May 5, 2025', '11:00 AM']],
                    ['id' => 5, 'icon' => 'envelope', 'color' => 'gray', 'title' => 'New Guidelines Published', 'desc' => 'The new guidelines for project proposals have been published in the document center.', 'type' => 'Information', 'audience' => 'All Users', 'priority' => 'Low', 'status' => 'Draft', 'datetime' => null],
                    ['id' => 6, 'icon' => 'bell', 'color' => 'pink', 'title' => 'PRIMA Call 2025 – Deadline Reminder', 'desc' => 'Reminder: The PRIMA 2025 call deadline is June 1, 2025.', 'type' => 'Reminder', 'audience' => 'Researchers', 'priority' => 'High', 'status' => 'Scheduled', 'datetime' => ['May 30, 2025', '10:00 AM']],
                ];
                @endphp

                @foreach($notifications as $n)
                <tr>
                    <td>
                        <div class="notif-table__title">
                            <span class="notif-table__icon notif-table__icon--{{ $n['color'] }}">
                                @switch($n['icon'])
                                    @case('megaphone')
                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 11v2a2 2 0 0 0 2 2h1l3 5V4L6 9H5a2 2 0 0 0-2 2Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M14 8a4 4 0 0 1 0 8M17 5a8 8 0 0 1 0 14" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                                        @break
                                    @case('calendar')
                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="5" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M8 3v4M16 3v4M3 10h18" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                                        @break
                                    @case('plane')
                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2 12l9-3 6-7 2 1-4 7 5 2-1 2-5-1-4 5-2-1 2-5-8-1v-2Z" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/></svg>
                                        @break
                                    @case('document')
                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 2h9l5 5v13a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M14 2v6h6" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M8 13h8M8 17h5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>
                                        @break
                                    @case('envelope')
                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="2" y="5" width="20" height="14" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M3 6l9 7 9-7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        @break
                                    @case('bell')
                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18 8a6 6 0 1 0-12 0c0 7-3 9-3 9h18s-3-2-3-9Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M13.7 21a2 2 0 0 1-3.4 0" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                                        @break
                                @endswitch
                            </span>
                            <div>
                                <strong>{{ $n['title'] }}</strong>
                                <span>{{ $n['desc'] }}</span>
                            </div>
                        </div>
                    </td>
                    <td><span class="notif-table__tag notif-table__tag--{{ \Illuminate\Support\Str::slug($n['type']) }}">{{ $n['type'] }}</span></td>
                    <td>{{ $n['audience'] }}</td>
                    <td><span class="notif-table__priority notif-table__priority--{{ strtolower($n['priority']) }}">{{ $n['priority'] }}</span></td>
                    <td><span class="notif-table__status notif-table__status--{{ strtolower($n['status']) }}">{{ $n['status'] }}</span></td>
                    <td>
                        @if($n['datetime'])
                            <div class="notif-table__datetime">
                                <span>{{ $n['datetime'][0] }}</span>
                                <span>{{ $n['datetime'][1] }}</span>
                            </div>
                        @else
                            <span class="notif-table__dash">—</span>
                        @endif
                    </td>
                    <td>
                        <div class="notif-table__actions">
                            <a href="{{ route('admin.notification-details', $n['id']) }}" aria-label="View">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.5 12S5 5 12 5s10.5 7 10.5 7-3.5 7-10.5 7-10.5-7-10.5-7Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.6"/></svg>
                            </a>
                            <button type="button" aria-label="More options">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="5" r="1.4" fill="currentColor"/><circle cx="12" cy="12" r="1.4" fill="currentColor"/><circle cx="12" cy="19" r="1.4" fill="currentColor"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="notif-pagination">
            <span>Showing 1 to 6 of 24 notifications</span>
            <div class="notif-pagination__buttons">
                <button type="button" aria-label="Previous page">‹</button>
                <button type="button" class="is-active">1</button>
                <button type="button">2</button>
                <button type="button">3</button>
                <button type="button">4</button>
                <span>…</span>
                <button type="button">5</button>
                <button type="button" aria-label="Next page">›</button>
            </div>
        </div>
    </div>

</div>
@endsection
