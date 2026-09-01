{{-- resources/views/admin/reports.blade.php
     Was a blank page in the original design with no defined purpose
     (docx remark: "reports: is empty should we remove it or what is
     this page supposed to represent?"). Built as a requests/activity
     report since that's the data the portal actually accumulates over
     time that isn't shown anywhere else. Flag if a different purpose
     was intended — this is isolated and easy to replace. --}}
@extends('layouts.admin')

@section('title', __('Reports'))
@php($active = 'reports')

@section('content')

<div class="dash-header">
    <div>
        <h2>{{ __('Reports') }}</h2>
        <p class="dash-header__date">{{ __('Requests and activity overview') }}</p>
    </div>
    <a href="{{ route('admin.requests-documents') }}" class="btn btn--outline btn--sm">
        {{ __('View all requests') }}
    </a>
</div>

<div class="kpi-grid">
    @foreach ($kpis as $kpi)
        <div class="kpi-card">
            <div class="kpi-card__value">{{ $kpi['value'] }}</div>
            <div class="kpi-card__label">{{ __($kpi['label']) }}</div>
            <div class="kpi-card__trend kpi-card__trend--flat" style="margin-top:6px;">{{ $kpi['sub'] }}</div>
        </div>
    @endforeach
</div>

<div class="chart-row">
    <div class="chart-card">
        <h3>{{ __('Requests received (last 6 months)') }}</h3>
        <div class="bar-chart">
            @foreach ($monthBars as $bar)
                <div class="bar-chart__col">
                    <span class="bar-chart__value">{{ $bar['total'] }}</span>
                    <div class="bar-chart__bar" style="height:{{ $bar['heightPct'] }}%; background:var(--color-cerulean);"
                         title="{{ __('Contact') }}: {{ $bar['contact'] }} · {{ __('Partnership') }}: {{ $bar['partner'] }}"></div>
                    <span class="bar-chart__label">{{ $bar['label'] }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="chart-card">
        <h3>{{ __('Request status breakdown') }}</h3>
        <div class="donut-legend">
            <p style="font-weight:600; margin:4px 0;">{{ __('Contact requests') }}</p>
            @forelse ($contactStatus as $status => $count)
                <div class="donut-legend__row">
                    {{ ucfirst($status) }}
                    <span class="donut-legend__value">{{ $count }}</span>
                </div>
            @empty
                <p class="activity-item__sub">{{ __('No contact requests yet.') }}</p>
            @endforelse

            <p style="font-weight:600; margin:16px 0 4px;">{{ __('Partnership requests') }}</p>
            @forelse ($partnerStatus as $status => $count)
                <div class="donut-legend__row">
                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                    <span class="donut-legend__value">{{ $count }}</span>
                </div>
            @empty
                <p class="activity-item__sub">{{ __('No partnership requests yet.') }}</p>
            @endforelse
        </div>
    </div>
</div>

<div class="list-row">
    <div class="list-card">
        <div class="list-card__header"><h3>{{ __('Recent admin logins') }}</h3></div>
        @forelse ($recentLogins as $item)
        <div class="activity-item">
            <span class="activity-item__icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.8"/></svg>
            </span>
            <div>
                <p class="activity-item__title">
                    {{ $item['user'] }}
                    @if(!$item['successful'])
                        <span class="badge badge--rejected" style="margin-left:6px;">{{ __('Failed') }}</span>
                    @endif
                </p>
                <p class="activity-item__sub">
                    {{ $item['time']?->format('M j, Y H:i') }}
                    @if($item['ip']) &middot; {{ $item['ip'] }} @endif
                    @if($item['reason']) &middot; {{ $item['reason'] }} @endif
                </p>
            </div>
        </div>
        @empty
        <p class="activity-item__sub">{{ __('No login activity yet.') }}</p>
        @endforelse
    </div>

    <div class="list-card">
        <div class="list-card__header"><h3>{{ __('Login activity (30 days)') }}</h3></div>
        <div class="pending-item">
            <div>
                <p class="pending-item__title">{{ __('Successful logins') }}</p>
            </div>
            <span class="donut-legend__value">{{ $loginSuccess }}</span>
        </div>
        <div class="pending-item">
            <div>
                <p class="pending-item__title">{{ __('Failed logins') }}</p>
            </div>
            <span class="donut-legend__value">{{ $loginFailed }}</span>
        </div>
        <p class="activity-item__sub" style="padding:8px 16px;">
            {{ __('Detailed login history is available under Users → Login History.') }}
        </p>
        <a href="{{ route('admin.users.login-history') }}" class="btn btn--outline btn--sm" style="margin:8px 16px;">
            {{ __('View full login history') }}
        </a>
    </div>
</div>

@endsection
