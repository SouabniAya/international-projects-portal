{{-- resources/views/admin/dashboard.blade.php — matches Figma "Administration Dashboard" (72:3186) --}}
@extends('layouts.admin')

@section('title', 'Dashboard')

@php($active = 'dashboard')

@section('content')

<div class="dash-header">
    <div>
        <h2>{{ __('Overview Dashboard') }}</h2>
        <p class="dash-header__date">{{ now()->format('F j, Y') }}</p>
    </div>

</div>
<div class="section__header" style="margin:-16px 0 20px;">
    <button type="button" class="btn btn--primary btn--sm" data-modal-open="newPartnershipModal">+ {{ __('New Partnership') }}</button>
</div>

{{-- KPI Cards — icon = what the metric is, color/arrow = whether it moved up, down, or held steady --}}
<div class="kpi-grid">
    @foreach ($kpis as $kpi)
        <div class="kpi-card">
            <div class="kpi-card__top">
                <span class="kpi-card__icon-wrap">
                    <svg class="kpi-card__icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">{!! $icons[$kpi['icon']] !!}</svg>
                </span>

                <span class="kpi-card__trend kpi-card__trend--{{ $kpi['direction'] }}">
                    {{ $dirIcon[$kpi['direction']] }} {{ $kpi['trend'] }}
                </span>
            </div>

            <div class="kpi-card__value">{{ $kpi['value'] }}</div>
            <div class="kpi-card__label">{{ $kpi['label'] }}</div>
        </div>
    @endforeach
</div>

{{-- Donut + Bar charts --}}
<div class="chart-row">
<div class="chart-card">
    <h3>{{ __('Partners by Region') }}</h3>
    <div class="donut" style="background: {{ $donutGradient }};"></div>
    <div class="donut-legend">
        @foreach ($donutSegments as $segment)
            <div class="donut-legend__row">
                <span class="donut-legend__dot" style="background:{{ $segment['color'] }};"></span>
                {{ __($segment['name']) }}
                <span class="donut-legend__value">{{ $segment['pct'] }}%</span>
            </div>
        @endforeach
    </div>
</div>

 <div class="chart-card">
    <h3>{{ __('Projects by Status') }}</h3>
    <div class="bar-chart">
        @foreach ($projectBars as $bar)
            <div class="bar-chart__col">
                <span class="bar-chart__value">{{ $bar['value'] }}</span>
                <div class="bar-chart__bar" style="height:{{ $bar['heightPct'] }}%; background:var(--color-cerulean);"></div>
                <span class="bar-chart__label">{{ __($bar['label']) }}</span>
            </div>
        @endforeach
    </div>
</div>
</div>

<div class="list-row">
    <div class="list-card">
        <div class="list-card__header"><h3>{{ __('Recently Added Partners') }}</h3></div>
        @forelse ($recentPartners as $item)
        <div class="activity-item">
            <span class="activity-item__icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.8"/></svg>
            </span>
            <div>
                <p class="activity-item__title">{{ $item['title'] }}</p>
                <p class="activity-item__sub">{{ $item['sub'] }}</p>
            </div>
        </div>
        @empty
        <p class="activity-item__sub">{{ __('No partners yet.') }}</p>
        @endforelse
    </div>

    <div class="list-card">
        <div class="list-card__header"><h3>{{ __('Partners by Type') }}</h3></div>
        @forelse ($partnersByType as $item)
        <div class="pending-item">
            <div>
                <p class="pending-item__title">{{ $item['title'] }}</p>
                <p class="pending-item__sub">{{ $item['sub'] }}</p>
            </div>
        </div>
        @empty
        <p class="pending-item__sub">{{ __('No data yet.') }}</p>
        @endforelse
    </div>
</div>

@endsection

@section('modals')
<dialog id="newPartnershipModal" class="modal">
    <form method="POST" action="{{ route('admin.partnerships.store') }}" data-demo-submit="{{ __('Partnership request created (demo — connect this route to persist).') }}">
        @csrf
        <div class="modal__header">
            <h3>{{ __('New Partnership') }}</h3>
            <button type="button" class="modal__close" data-modal-close aria-label="{{ __('Close') }}">&times;</button>
        </div>
        <div class="modal__body">
            <div class="form-group">
                <label class="form-label" for="partnerName">{{ __('Institution name') }}</label>
                <input class="form-control" type="text" id="partnerName" name="partner_name" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="partnerCountry">{{ __('Country') }}</label>
                    <input class="form-control" type="text" id="partnerCountry" name="country">
                </div>
                <div class="form-group">
                    <label class="form-label" for="partnerType">{{ __('Institution type') }}</label>
                    <select class="form-control" id="partnerType" name="type">
                        <option>{{ __('University') }}</option>
                        <option>{{ __('Research center') }}</option>
                        <option>{{ __('Company') }}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal__footer">
            <button type="button" class="btn btn--outline btn--sm" data-modal-close>{{ __('Cancel') }}</button>
            <button type="submit" class="btn btn--primary btn--sm">{{ __('Create Partnership') }}</button>
        </div>
    </form>
</dialog>
@endsection