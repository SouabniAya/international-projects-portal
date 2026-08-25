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
            <p>View incoming contact requests.</p>
        </div>
    </div>

    <div class="notif-table-wrap">
        <table class="notif-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Received</th>
                </tr>
            </thead>
            <tbody>
                @forelse($notifications as $n)
                <tr>
                    <td>
                        <div class="notif-table__title">
                            <div>
                                <strong>{{ $n['title'] }}</strong>
                                @if($n['desc'])<span>{{ Str::limit($n['desc'], 80) }}</span>@endif
                            </div>
                        </div>
                    </td>
                    <td><span class="notif-table__status notif-table__status--{{ strtolower($n['status']) }}">{{ $n['status'] }}</span></td>
                    <td>{{ $n['datetime'] }}</td>
                </tr>
                @empty
                <tr><td colspan="3">No notifications yet.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="notif-pagination">
            {{ $notifications->links() }}
        </div>
    </div>

</div>
@endsection