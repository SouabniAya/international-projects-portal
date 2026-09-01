@extends('layouts.admin')

@section('title', __('Notification Details'))
@php($active = 'requests')

@section('content')
<div class="notif-detail">

    <a href="{{ route('admin.notifications') }}" class="notif-detail__back">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 6l-6 6 6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        {{ __('Back to Notifications') }}
    </a>

    <div class="notif-detail__header">
        <div>
            <p class="notif-detail__eyebrow">{{ __('Contact request') }}</p>
            <h1>{{ $notification['title'] }}</h1>
            <p class="notif-detail__meta">{{ $notification['datetime'] }}</p>
        </div>

        <div class="notif-detail__actions">
            <a href="mailto:{{ $notification['email'] }}" class="notif-detail__button">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 6h16v12H4z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                    <path d="M4 7l8 6 8-6" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                </svg>
                {{ __('Reply by Email') }}
            </a>
        </div>
    </div>

    <div class="notif-detail__layout">
        <div class="notif-detail__message">
            <div class="notif-detail__subject">{{ $notification['subject'] }}</div>
            <h2>{{ $notification['fullName'] }}</h2>
            <p>{{ nl2br(e($notification['message'])) }}</p>
        </div>

        <aside class="notif-detail__sidebar">
            <div class="notif-detail__stat">
                <span>{{ __('Status') }}</span>
                <strong class="notif-table__status notif-table__status--{{ $notification['status'] }}">{{ $notification['status_label'] }}</strong>
            </div>
            <div class="notif-detail__stat">
                <span>{{ __('Email') }}</span>
                <strong>{{ $notification['email'] }}</strong>
            </div>
            <div class="notif-detail__stat">
                <span>{{ __('Phone') }}</span>
                <strong>{{ $notification['phone'] ?? '—' }}</strong>
            </div>
            <div class="notif-detail__stat">
                <span>{{ __('Received') }}</span>
                <strong>{{ $notification['datetime'] }}</strong>
            </div>
        </aside>
    </div>

</div>
@endsection
