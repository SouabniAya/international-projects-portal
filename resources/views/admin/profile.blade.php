{{-- resources/views/admin/profile.blade.php — view-only profile, distinct from Account Settings --}}
@extends('layouts.admin')

@section('title', 'My Profile')

@php($active = 'settings')

@section('content')

<div class="section__header section__header--row" style="margin-bottom:24px;">
    <div>
        <h2 style="margin:0;">My Profile</h2>
        <p style="margin:4px 0 0;">Your account at a glance.</p>
    </div>
    <a href="{{ url('/admin/settings') }}" class="btn btn--outline btn--sm">Edit in Account Settings →</a>
</div>

<div class="two-col--narrow-first" style="display:grid; gap:32px;">
    <div>
        <div class="card">
            <div class="card__body" style="display:flex; gap:20px; align-items:center;">
                <span class="admin-header__avatar" style="width:64px; height:64px; font-size:22px;">
                    {{ auth()->check() ? strtoupper(substr(auth()->user()->firstName ?? 'A', 0, 1) . substr(auth()->user()->lastName ?? 'U', 0, 1)) : 'AU' }}
                </span>
                <div>
                    <h3 class="card__title" style="margin-bottom:4px;">{{ auth()->user()->firstName ?? 'Admin' }} {{ auth()->user()->lastName ?? 'User' }}</h3>
                    <p class="card__text">{{ auth()->user()?->role?->roleName ?? 'Administrator' }}</p>
                </div>
            </div>
        </div>

        <div class="card" style="margin-top:20px;">
            <div class="card__body">
                <h3 class="card__title">Contact Information</h3>
                <div class="contact-row" style="margin-top:14px;">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="5" width="18" height="14" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="m3 7 9 6 9-6" stroke="currentColor" stroke-width="1.6"/></svg>
                    <span>{{ auth()->user()->email ?? 'admin@esi.dz' }}</span>
                </div>
                <div class="contact-row">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 3h3l2 5-2.5 1.5a11 11 0 0 0 5 5L15 12l5 2v3a2 2 0 0 1-2 2C10.5 19 5 13.5 5 7a2 2 0 0 1 1-2Z" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/></svg>
                    <span>{{ auth()->user()->phoneNumber ?? 'Not provided' }}</span>
                </div>
            </div>
        </div>

        <div class="card" style="margin-top:20px;">
            <div class="card__body">
                <h3 class="card__title">My Recent Activity</h3>
                <div style="margin-top:8px;">
                    <div class="activity-item" style="padding-left:0; padding-right:0;">
                        <span class="activity-item__icon"><svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.8"/></svg></span>
                        <div><p class="activity-item__title">Published "Erasmus+ mobility results announced"</p><p class="activity-item__sub">Yesterday</p></div>
                    </div>
                    <div class="activity-item" style="padding-left:0; padding-right:0;">
                        <span class="activity-item__icon"><svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.8"/></svg></span>
                        <div><p class="activity-item__title">Updated the Partner Details page for INSA Lyon</p><p class="activity-item__sub">3 days ago</p></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <aside>
        <div class="card">
            <div class="card__body">
                <h3 class="card__title">Account Status</h3>
                <span class="badge badge--approved" style="margin-top:8px;">Active</span>
                <p class="card__text" style="margin-top:12px;">Two-factor authentication: <strong>Not enabled</strong></p>
                <a href="{{ url('/admin/settings') }}" class="btn btn--outline btn--sm" style="margin-top:8px;">Manage in Settings</a>
            </div>
        </div>
    </aside>
</div>

@endsection
