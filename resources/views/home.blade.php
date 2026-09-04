{{-- resources/views/home.blade.php — matches Figma "Home Page" (69:2130) + FR-1.1 to FR-1.9 --}}
@extends('layouts.app')

@section('title', 'Home')

@section('content')
<x-home-hero
    :eyebrow="__('pages.home.eyebrow')"
    :title="__('pages.home.title')"
    :subtitle="__('pages.home.subtitle')">
</x-home-hero>

<section class="section">
    <div class="stat-figma-grid">
        <div>
            <div class="stat-figma__value" style="color:var(--viz-amber);">{{ $stats['countries'] }}</div>
            <div class="stat-figma__label">{{ __('Countries') }}</div>
        </div>
        <div>
            <div class="stat-figma__value" style="color:var(--viz-green);">{{ $stats['activeAgreements'] }}</div>
            <div class="stat-figma__label">{{ __('Active Agreements') }}</div>
        </div>
        <div>
            <div class="stat-figma__value" style="color:var(--viz-purple);">{{ $stats['ongoingProjects'] }}</div>
            <div class="stat-figma__label">{{ __('Ongoing Projects') }}</div>
        </div>
        <div>
            <div class="stat-figma__value" style="color:var(--color-cerulean);">{{ $stats['partners'] }}</div>
            <div class="stat-figma__label">{{ __('Partners') }}</div>
        </div>
    </div>
</section>

{{-- About ESI teaser — the presentation page had no discoverability from Home --}}
{{-- News + ESI Presentation Diaporama --}}
<section class="section">
    <div class="diaporama" data-diaporama data-interval="5000" data-i18n-go-to-slide="{{ __('Go to slide') }}">

        <div class="diaporama__track">

            {{-- Slide — School Presentation (static) --}}
            <div class="diaporama__slide">

                <div
                    class="diaporama__image"
                    style="background-image: url('{{ asset('images/esi-campus.jpg') }}');">
                </div>

                <div class="diaporama__content">
                    <span class="card__eyebrow">
                        {{ __('About ESI') }}
                    </span>

                    <h3 class="diaporama__title">
                        {{ __('Discover ESI') }}
                    </h3>

                    <p class="diaporama__text">
                        {{ __("Discover ESI's internationalization strategy, vision, research domains, and opportunities for international collaboration.") }}
                    </p>

                    <a href="{{ url('/international-presentation') }}"
                       class="btn btn--outline btn--sm">
                        {{ __('Discover ESI →') }}
                    </a>
                </div>

            </div>

            {{-- News slides — dynamic from database --}}
            @foreach ($newsItems as $i => $item)
            <div class="diaporama__slide @if($i === 0) is-active @endif">

                <div
                    class="diaporama__image"
                    style="background-image: url('{{ $item['image'] ? asset($item['image']) : asset('images/news/default.jpg') }}');">
                </div>

                <div class="diaporama__content">
                    <span class="card__eyebrow">
                        {{ __('News') }}
                    </span>

                    <h3 class="diaporama__title">
                        {{ $item['title'] }}
                    </h3>

                    <p class="diaporama__text">
                        {{ \Illuminate\Support\Str::limit($item['excerpt'], 160) }}
                    </p>

                    <a href="{{ url('/news') }}"
                       class="btn btn--outline btn--sm">
                        {{ __('Read more →') }}
                    </a>
                </div>

            </div>
            @endforeach

        </div>

        {{-- Small slide indicators --}}
        <div
            class="diaporama__dots"
            role="tablist"
            aria-label="{{ __('Slideshow navigation') }}">
        </div>

    </div>
</section>
<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('[data-diaporama]').forEach(function (root) {

        const slides = root.querySelectorAll('.diaporama__slide');
        const dotsWrap = root.querySelector('.diaporama__dots');

        if (!slides.length || !dotsWrap) return;

        const interval = parseInt(
            root.dataset.interval || '5000',
            10
        );

        // Translated label injected via data-attribute (JS has no access to Laravel __())
        const goToSlideLabel = root.dataset.i18nGoToSlide || 'Go to slide';

        let current = 0;
        let timer;

        /* Create dots */
        slides.forEach(function (_, index) {

            const dot = document.createElement('button');

            dot.type = 'button';
            dot.setAttribute(
                'aria-label',
                goToSlideLabel + ' ' + (index + 1)
            );

            if (index === 0) {
                dot.classList.add('is-active');
            }

            dot.addEventListener('click', function () {
                goTo(index);
                restart();
            });

            dotsWrap.appendChild(dot);
        });

        const dots = dotsWrap.querySelectorAll('button');


        function goTo(index) {

            slides[current].classList.remove('is-active');
            dots[current].classList.remove('is-active');

            current = (index + slides.length) % slides.length;

            slides[current].classList.add('is-active');
            dots[current].classList.add('is-active');
        }


        function next() {
            goTo(current + 1);
        }


        function start() {
            timer = setInterval(next, interval);
        }


        function stop() {
            clearInterval(timer);
        }


        function restart() {
            stop();
            start();
        }


        root.addEventListener('mouseenter', stop);
        root.addEventListener('mouseleave', start);

        start();
    });

});
</script>
{{-- FR-1.9 Quick Actions — matches Figma "Quick Actions" instance --}}
<section class="section section--tight">
    <div class="quick-actions-grid">
        <a href="{{ url('/partnerships') }}" class="quick-action">
            <span class="quick-action__icon"><svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 21s7-6.5 7-12a7 7 0 1 0-14 0c0 5.5 7 12 7 12Z" stroke="currentColor" stroke-width="1.6"/><circle cx="12" cy="9" r="2.5" stroke="currentColor" stroke-width="1.6"/></svg></span>
            <span>
                <p class="quick-action__title">{{ __('Explore our partnerships') }}</p>
                <p class="quick-action__desc">{{ __('Browse our network of academic and research institutions worldwide.') }}</p>
            </span>
        </a>
        <a href="{{ route('funding-programmes.index') }}" class="quick-action">
            <span class="quick-action__icon"><svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/><path d="M12 7v5l3 3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg></span>
            <span>
                <p class="quick-action__title">{{ __('Find a funding opportunity') }}</p>
                <p class="quick-action__desc">{{ __('Browse open calls for proposals across all funding programmes.') }}</p>
            </span>
        </a>
        <a href="{{ url('/mobility') }}" class="quick-action">
            <span class="quick-action__icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12" cy="12" r="8.5"
                        stroke="currentColor"
                        stroke-width="1.6"/>
                    <path d="M3.5 12h17"
                        stroke="currentColor"
                        stroke-width="1.4"
                        stroke-linecap="round"/>
                    <path d="M12 3.5c2.2 2.3 3.3 5.1 3.3 8.5s-1.1 6.2-3.3 8.5"
                        stroke="currentColor"
                        stroke-width="1.4"
                        stroke-linecap="round"/>
                    <path d="M12 3.5c-2.2 2.3-3.3 5.1-3.3 8.5s1.1 6.2 3.3 8.5"
                        stroke="currentColor"
                        stroke-width="1.4"
                        stroke-linecap="round"/>
                </svg>
            </span>
            <span>
                <p class="quick-action__title">{{ __('Apply for mobility') }}</p>
                <p class="quick-action__desc">{{ __('Find student, staff, and research mobility offers currently open.') }}</p>
            </span>
        </a>
        <a href="{{ url('/documents') }}" class="quick-action">
            <span class="quick-action__icon"><svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 3v12m0 0l-4-4m4 4l4-4M5 21h14" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
            <span>
                <p class="quick-action__title">{{ __('Download documents') }}</p>
                <p class="quick-action__desc">{{ __('Access institutional brochures, templates, and application forms.') }}</p>
            </span>
        </a>
        <a href="{{ url('/become-a-partner') }}" class="quick-action">
            <span class="quick-action__icon"><svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2M10 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM19 8v6M22 11h-6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg></span>
            <span>
                <p class="quick-action__title">{{ __('Become a partner') }}</p>
                <p class="quick-action__desc">{{ __('Start a cooperation with ESI Algiers as an institutional partner.') }}</p>
            </span>
        </a>
        <a href="{{ url('/contact') }}" class="quick-action">
            <span class="quick-action__icon"><svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="5" width="18" height="14" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="m3 7 9 6 9-6" stroke="currentColor" stroke-width="1.6"/></svg></span>
            <span>
                <p class="quick-action__title">{{ __('Contact the IR Office') }}</p>
                <p class="quick-action__desc">{{ __('Reach the International Relations Office for any question.') }}</p>
            </span>
        </a>
    </div>
</section>

{{-- FR-1.6 News + Events — matches Figma "News + events section" --}}
<section class="section two-col" style="background:var(--color-neutral-50);">
    <div>
        <div class="section__header section__header--row">
            <h2>{{ __('Latest News') }}</h2>
            <a href="{{ url('/news') }}" class="btn btn--outline btn--sm">{{ __('View all →') }}</a>
        </div>
        <div class="card-grid card-grid--2col">
            @forelse ($newsItems->take(2) as $item)
            <a href="{{ url('/news') }}" class="card__link">
                <div class="card">
                    <div class="card__image" style="background:linear-gradient(135deg, var(--color-cerulean), var(--color-deep-space-blue));"></div>
                    <div class="card__body">
                        <span class="card__eyebrow">{{ __('News') }}</span>
                        <h3 class="card__title">{{ $item['title'] }}</h3>
                        <p class="card__text">{{ \Illuminate\Support\Str::limit($item['excerpt'], 150) }}</p>
                        <div class="card__meta">{{ $item['date'] }}</div>
                    </div>
                </div>
            </a>
            @empty
            <p style="color:var(--color-neutral-500); font-family:var(--font-body);">{{ __('No news at the moment.') }}</p>
            @endforelse
        </div>
    </div>

    <div>
        <div class="section__header section__header--row">
            <h2>{{ __('Upcoming Events') }}</h2>
            <a href="{{ url('/events') }}" class="btn btn--outline btn--sm">{{ __('View all →') }}</a>
        </div>
        @forelse ($eventItems as $item)
        <a href="{{ url('/events') }}" class="event-row" style="text-decoration:none; color:inherit;">
            <div class="event-row__date"><div class="event-row__day">{{ $item['day'] }}</div><div class="event-row__month">{{ $item['month'] }}</div></div>
            <div>
                <p class="event-row__title">{{ $item['title'] }}</p>
                <span class="event-row__location">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 21s7-6.5 7-12a7 7 0 1 0-14 0c0 5.5 7 12 7 12Z" stroke="currentColor" stroke-width="1.8"/></svg>
                    {{ $item['location'] }}
                </span>
            </div>
        </a>
        @empty
        <p style="color:var(--color-neutral-500); font-family:var(--font-body);">{{ __('No upcoming events.') }}</p>
        @endforelse
    </div>
</section>

<section class="section">
    <div class="section__header section__header--row">
        <div>
            <h2>{{ __('Calls for Proposals') }}</h2>
            <p>{{ __('Latest opportunities and calls approaching their deadline.') }}</p>
        </div>
        <a href="{{ url('/calls') }}" class="btn btn--outline btn--sm">{{ __('View all calls') }}</a>
    </div>
    <div class="card-grid">
        @forelse($homeCalls as $call)
        <div class="card"><div class="card__body">
            <span class="badge badge--{{ $call['statusClass'] }}">{{ $call['status'] }}</span>
            <h3 class="card__title">{{ $call['title'] }}</h3>
            <p class="card__text">{{ \Illuminate\Support\Str::limit($call['excerpt'], 120) }}</p>
            <div class="card__meta">{{ __('Deadline: :date', ['date' => $call['deadline']]) }}</div>
        </div></div>
        @empty
        <p>{{ __('No open calls for proposals right now.') }}</p>
        @endforelse
    </div>
</section>

<section class="section section--tight" style="background:var(--color-neutral-50);">
    <div class="section__header section__header--row">
        <div>
            <h2>{{ __('International Projects') }}</h2>
            <p>{{ __('Highlighted cooperation and research projects.') }}</p>
        </div>
        <a href="{{ url('/projects') }}" class="btn btn--outline btn--sm">{{ __('View all projects') }}</a>
    </div>
    <div class="card-grid">
        @forelse($homeProjects as $project)
        <div class="card"><div class="card__body">
            <span class="badge badge--{{ $project['statusClass'] }}">{{ $project['status'] }}</span>
            <h3 class="card__title">{{ $project['title'] }}</h3>
            <p class="card__text">{{ \Illuminate\Support\Str::limit($project['excerpt'], 120) }}</p>
        </div></div>
        @empty
        <p>{{ __('No published projects to show yet.') }}</p>
        @endforelse
    </div>
</section>

{{-- Testimonials preview — the Testimonials page had no discoverability from Home --}}
<section class="section">
    <div class="section__header section__header--row">
        <div>
            <h2>{{ __('Testimonials') }}</h2>
            <p>{{ __('Stories from students and researchers who took part in an international mobility.') }}</p>
        </div>
        <a href="{{ url('/testimonials') }}" class="btn btn--outline btn--sm">{{ __('Read more →') }}</a>
    </div>
    <div class="card-grid" style="grid-template-columns: repeat(2, 1fr);">
        <div class="card"><div class="card__body">
            <p class="card__text" style="font-style:italic;">{{ __("My exchange semester in Turin completely changed how I approach research — the whole process, from application to arrival, was smooth thanks to the IR office.") }}</p>
            <div class="card__meta" style="margin-top:12px;">{{ __('Amine K. — Semester Exchange, Politecnico di Torino') }}</div>
        </div></div>
        <div class="card"><div class="card__body">
            <p class="card__text" style="font-style:italic;">{{ __("The scientific stay at Sorbonne gave me access to resources and collaborations I couldn't have found here alone.") }}</p>
            <div class="card__meta" style="margin-top:12px;">{{ __('Lina B. — Research Stay, Sorbonne Université') }}</div>
        </div></div>
    </div>
</section>

{{-- FAQ callout --}}
<section class="section section--tight" style="background:var(--color-deep-space-blue);">
    <div style="display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap;">
        <div>
            <h2 style="font-family:var(--font-heading); font-weight:700; font-size:20px; color:var(--color-white); margin:0 0 6px;">{{ __('Have a question?') }}</h2>
            <p style="font-family:var(--font-body); font-size:14px; color:var(--color-footer-text); margin:0;">{{ __('Check our FAQ for quick answers about partnerships, mobility, and funding.') }}</p>
        </div>
        <a href="{{ url('/faq') }}" class="btn btn--accent btn--sm">{{ __('Visit the FAQ →') }}</a>
    </div>
</section>

@endsection