@extends('layouts.app')

@section('title', $project['title'])

@section('content')
<section class="project-details-hero">
    <div class="project-details-hero__inner">
        <a href="{{ route('projects') }}" class="project-details-back">← {{ __('Back to International Projects') }}</a>
        <div class="project-details-programme"><span class="project-details-programme__logo">{{ substr($project['programme'], 0, 1) }}</span><span>{{ $project['programme'] }}</span></div>
        <div class="project-details-heading">
            <div>
                <span class="project-details-status project-details-status--{{ strtolower($project['status']) }}">{{ $project['status'] }}</span>
                <h1>{{ $project['title'] }}</h1>
                @if($project['desc'])<p>{{ $project['desc'] }}</p>@endif
            </div>
        </div>
    </div>
</section>

<section class="project-details-content">
    <div class="project-details-layout">
        <main class="project-details-main">
            <section class="project-details-section">
                <h2>{{ __('About the Project') }}</h2><div class="project-details-line"></div>
                <p>{{ $project['overview'] ?: __('No project description is currently available.') }}</p>
            </section>

            @if(count($project['objectives']))
            <section class="project-details-section">
                <h2>{{ __('Project Objectives') }}</h2><div class="project-details-line"></div>
                <div class="project-objectives">
                    @foreach($project['objectives'] as $objective)
                        <div class="project-objective"><span class="project-objective__number">{{ sprintf('%02d', $loop->iteration) }}</span><p>{{ $objective }}</p></div>
                    @endforeach
                </div>
            </section>
            @endif

            @if($project['project']?->translation()?->targetGroups)
            <section class="project-details-section"><h2>{{ __('Target Groups') }}</h2><div class="project-details-line"></div><p>{{ $project['project']->translation()->targetGroups }}</p></section>
            @endif

            @if($project['project']?->translation()?->keyResults)
            <section class="project-details-section"><h2>{{ __('Key Results') }}</h2><div class="project-details-line"></div><p>{{ $project['project']->translation()->keyResults }}</p></section>
            @endif

            @if($project['project']?->partners?->count())
            <section class="project-details-section"><h2>{{ __('Partners') }}</h2><div class="project-details-line"></div>
                <ul>
                    @foreach($project['project']->partners as $partner)<li>{{ $partner->partnerName }} ({{ $partner->pivot->partnerRole }})</li>@endforeach
                </ul>
            </section>
            @endif
        </main>

        <aside class="project-details-sidebar">
            <div class="project-info-card">
                <h3>{{ __('Project Information') }}</h3>
                <div class="project-info-item"><span class="project-info-item__label">{{ __('Funding Programme') }}</span><strong>{{ $project['programme'] }}</strong></div>
                <div class="project-info-item"><span class="project-info-item__label">{{ __('Status') }}</span><strong>{{ $project['status'] }}</strong></div>
                <div class="project-info-item"><span class="project-info-item__label">{{ __('Duration') }}</span><strong>{{ $project['duration'] }}</strong></div>
                <div class="project-info-item"><span class="project-info-item__label">{{ __('Coordinator') }}</span><strong>{{ $project['coordinator'] }}</strong></div>
                <div class="project-info-item"><span class="project-info-item__label">{{ __('Country') }}</span><strong>{{ $project['countries'] }}</strong></div>
                <div class="project-info-item"><span class="project-info-item__label">{{ __('Partners') }}</span><strong>{{ $project['partners'] }}</strong></div>
                <div class="project-info-item"><span class="project-info-item__label">{{ __('Estimated Budget') }}</span><strong>{{ $project['budget'] }}</strong></div>
            </div>
            @if($project['website'])<a href="{{ $project['website'] }}" target="_blank" rel="noopener" class="btn btn--primary" style="width:100%;margin-top:16px;">{{ __('Official project website') }} ↗</a>@endif
        </aside>
    </div>
</section>
@endsection
