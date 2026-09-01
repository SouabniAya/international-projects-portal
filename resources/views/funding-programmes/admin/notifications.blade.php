@extends('layouts.admin')

@section('title', __('Notifications'))
@php($active = 'requests')

@section('content')
<div class="notif-page">

    <a href="{{ route('admin.dashboard') }}" class="notif-page__back">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 6l-6 6 6 6"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"/>
        </svg>
        {{ __('Back to Dashboard') }}
    </a>

    <div class="notif-page__head">
        <div>
            <h1>{{ __('Notifications') }}</h1>
            <p>{{ __('Review the latest messages sent through the portal contact form.') }}</p>
        </div>
    </div>

    <div class="notif-table-wrap">
        <table class="notif-table">
            <thead>
                <tr>
                    <th>{{ __('Sender') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Received') }}</th>
                </tr>
            </thead>

            <tbody>
                @forelse($notifications as $n)
                <tr>
                    <td>
                        <a href="{{ route('admin.notification-details', $n['id']) }}" class="notif-table__title">
                            <strong>{{ $n['title'] }}</strong>
                        </a>
                    </td>
                    <td>
                        <span class="notif-table__status notif-table__status--{{ $n['status'] }}">{{ $n['status_label'] }}</span>
                    </td>
                    <td class="notif-table__datetime">
                        <span>{{ $n['datetime'] }}</span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="notif-table__empty">{{ __('No notifications yet.') }}</td></tr>
                @endforelse
            </tbody>
        </table>

        @if($notifications->hasPages())
        <div class="notif-pagination">
            {{ $notifications->links() }}
        </div>
        @endif
    </div>

</div>
@endsection