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
    <div class="dash-header__actions">
        <button type="button" class="btn btn--outline btn--sm" data-toast="{{ __('Report exported (demo — connect a real export endpoint once the backend exists).') }}">⭳ {{ __('Export Report') }}</button>
        <select class="form-control" style="width:auto;">
            <option>{{ __('Last 30 Days') }}</option>
            <option>{{ __('Last 90 Days') }}</option>
            <option>{{ __('This Year') }}</option>
        </select>
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
        <div class="donut" style="background: conic-gradient(var(--color-deep-space-blue) 0% 33%, var(--color-cerulean) 33% 61%, var(--color-fresh-sky) 61% 82%, var(--color-neutral-300) 82% 100%);"></div>
        <div class="donut-legend">
            <div class="donut-legend__row"><span class="donut-legend__dot" style="background:var(--color-deep-space-blue);"></span> {{ __('Western Europe') }} <span class="donut-legend__value">33%</span></div>
            <div class="donut-legend__row"><span class="donut-legend__dot" style="background:var(--color-cerulean);"></span> {{ __('North Africa') }} <span class="donut-legend__value">28%</span></div>
            <div class="donut-legend__row"><span class="donut-legend__dot" style="background:var(--color-fresh-sky);"></span> {{ __('North America') }} <span class="donut-legend__value">21%</span></div>
            <div class="donut-legend__row"><span class="donut-legend__dot" style="background:var(--color-neutral-300);"></span> {{ __('Other') }} <span class="donut-legend__value">18%</span></div>
        </div>
    </div>

    <div class="chart-card">
        <h3>{{ __('Projects by Status') }}</h3>
        <div class="bar-chart">
            <div class="bar-chart__col">
                <span class="bar-chart__value">18</span>
                <div class="bar-chart__bar" style="height:45%; background:var(--color-neutral-300);"></div>
                <span class="bar-chart__label">{{ __('Proposed') }}</span>
            </div>
            <div class="bar-chart__col">
                <span class="bar-chart__value">62</span>
                <div class="bar-chart__bar" style="height:100%; background:var(--color-cerulean);"></div>
                <span class="bar-chart__label">{{ __('Ongoing') }}</span>
            </div>
            <div class="bar-chart__col">
                <span class="bar-chart__value">20</span>
                <div class="bar-chart__bar" style="height:50%; background:var(--color-deep-space-blue);"></div>
                <span class="bar-chart__label">{{ __('Completed') }}</span>
            </div>
        </div>
    </div>
</div>

{{-- Recent Activity + Pending Actions --}}
<div class="list-row">
    <div class="list-card">
        <div class="list-card__header"><h3>{{ __('Recent Activity') }}</h3><a href="#">{{ __('View All') }}</a></div>
        @foreach ([
            ['title' => 'New partnership request from TU Munich', 'sub' => '2 hours ago · Initiated by Dr. Schmidt'],
            ['title' => 'Agreement updated for INSA Lyon', 'sub' => '5 hours ago · Erasmus+ Annex added'],
            ['title' => 'Project approved: "AI for Green Energy"', 'sub' => 'Yesterday · Joint Research Fund'],
            ['title' => 'Student mobility application submitted', 'sub' => 'Yesterday · Outgoing to Politecnico di Milano'],
        ] as $item)
        <div class="activity-item">
            <span class="activity-item__icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.8"/></svg>
            </span>
            <div>
                <p class="activity-item__title">{{ __($item['title']) }}</p>
                <p class="activity-item__sub">{{ __($item['sub']) }}</p>
            </div>
        </div>
        @endforeach
    </div>

    <div class="list-card">
        <div class="list-card__header"><h3>{{ __('Pending Actions') }}</h3><span class="badge badge--pending">{{ __('3 awaiting review') }}</span></div>
        @foreach ([
            ['title' => 'Partnership request — TU Munich', 'sub' => 'Submitted 2 hours ago'],
            ['title' => 'Agreement renewal — Sorbonne Université', 'sub' => 'Expires in 45 days'],
            ['title' => 'Mobility application — A. Belkacem', 'sub' => 'Submitted yesterday'],
        ] as $item)
        <div class="pending-item">
            <div>
                <p class="pending-item__title">{{ __($item['title']) }}</p>
                <p class="pending-item__sub">{{ __($item['sub']) }}</p>
            </div>
            <button type="button" class="btn btn--outline btn--sm" data-toast="{{ __('Reviewing :title (demo — link this to the real review flow).', ['title' => $item['title']]) }}">{{ __('Review') }}</button>
        </div>
        @endforeach
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