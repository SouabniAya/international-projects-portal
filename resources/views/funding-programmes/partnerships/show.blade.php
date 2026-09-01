@extends('layouts.app')

@section('title', $partner['name'])

@section('content')
<section class="section" style="padding-bottom:0;">
    <div class="breadcrumbs">
        <a href="{{ url('/') }}">{{ __('nav.home') }}</a> / <a href="{{ route('partnerships.index') }}">{{ __('Partnerships') }}</a> / {{ $partner['name'] }}
    </div>

    <div class="partner-detail__top">
        <div class="partner-detail__identity">
            <div class="partner-detail__logo">
                @if($partner['logo'])
                    <img src="{{ asset('storage/'.$partner['logo']) }}" alt="{{ $partner['name'] }} logo">
                @else
                    <span style="display:flex;align-items:center;justify-content:center;width:100%;height:100%;font-family:var(--font-heading);font-weight:700;font-size:22px;color:var(--color-deep-space-blue);">
                        {{ collect(explode(' ', $partner['name']))->map(fn($w) => strtoupper($w[0] ?? ''))->take(2)->implode('') }}
                    </span>
                @endif
            </div>
            <div>
                <div class="partner-detail__badges">
                    @if($partner['partnershipType']) <span class="pill pill--outline">{{ $partner['partnershipType'] }}</span> @endif
                    <span class="pill pill--filled">{{ ucfirst($partner['status']) }}</span>
                </div>
                <h1 class="partner-detail__title">{{ $partner['name'] }}</h1>
                <div class="partner-detail__meta">
                    <span>{{ $partner['city'] }}, {{ $partner['country'] }}</span>
                    <span>{{ $partner['type'] }}</span>
                    <span>{{ __('Partner since') }} {{ $partner['partnerSince'] }}</span>
                </div>
            </div>
        </div>
        @if($partner['website'])
            <a href="{{ $partner['website'] }}" target="_blank" rel="noopener" class="btn btn--outline btn--sm">{{ __('Visit official website') }} ↗</a>
        @endif
    </div>
</section>

<section class="section two-col" style="padding-top:36px;">
    <main>
        <section>
            <h2 class="subsection-heading">{{ __('About the Institution') }}</h2>
            <p style="font-family:var(--font-body);line-height:1.7;color:var(--color-ink-black);font-size:14.5px;">
                {{ $partner['presentation'] ?: __('No presentation is currently available for this partner.') }}
            </p>
        </section>

        <section style="margin-top:40px;">
            <h2 class="subsection-heading">{{ __('Projects') }} <span class="subsection-heading__count">{{ $partner['projects']->count() }}</span></h2>
            @forelse($partner['projects'] as $project)
                @php($translation = $project->translation())
                <div class="data-table-wrap" style="margin-bottom:12px;">
                    <table class="data-table"><tbody><tr>
                        <td><a href="{{ route('projects.show', $project->projectID) }}" style="color:var(--color-cerulean);text-decoration:none;font-weight:600;">{{ $translation?->title ?? $project->acronym }}</a></td>
                        <td>{{ $project->status_label }}</td>
                        <td>{{ $project->startDate?->format('Y') }} – {{ $project->endDate?->format('Y') }}</td>
                    </tr></tbody></table>
                </div>
            @empty
                <p>{{ __('No published projects are associated with this partner.') }}</p>
            @endforelse
        </section>

        <section style="margin-top:40px;">
            <h2 class="subsection-heading">{{ __('Agreements & Conventions') }} <span class="subsection-heading__count">{{ $partner['agreements']->count() }}</span></h2>
            <div class="data-table-wrap">
                <table class="data-table">
                    <thead><tr><th>{{ __('Title') }}</th><th>{{ __('Type') }}</th><th>{{ __('Status') }}</th><th>{{ __('Validity') }}</th></tr></thead>
                    <tbody>
                    @forelse($partner['agreements'] as $agreement)
                        <tr>
                            <td>{{ $agreement->translation()?->title ?? __('Agreement') }}</td>
                            <td>{{ $agreement->agreementType }}</td>
                            <td>{{ $agreement->status_label }}</td>
                            <td>{{ $agreement->startDate?->format('Y-m-d') ?? '—' }} – {{ $agreement->endDate?->format('Y-m-d') ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4">{{ __('No published agreements are associated with this partner.') }}</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <aside>
        <div class="project-info-card">
            <h3>{{ __('Partner Information') }}</h3>
            <div class="project-info-item"><span class="project-info-item__label">{{ __('Country') }}</span><strong>{{ $partner['country'] }}</strong></div>
            <div class="project-info-item"><span class="project-info-item__label">{{ __('City') }}</span><strong>{{ $partner['city'] }}</strong></div>
            <div class="project-info-item"><span class="project-info-item__label">{{ __('Institution type') }}</span><strong>{{ $partner['type'] }}</strong></div>
            <div class="project-info-item"><span class="project-info-item__label">{{ __('Partnership type') }}</span><strong>{{ $partner['partnershipType'] ?: '—' }}</strong></div>
            <div class="project-info-item"><span class="project-info-item__label">{{ __('Status') }}</span><strong>{{ ucfirst($partner['status']) }}</strong></div>
        </div>
    </aside>
</section>
@endsection
