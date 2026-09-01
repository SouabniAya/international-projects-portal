{{-- resources/views/home.blade.php — matches Figma "Home Page" (69:2130) + FR-1.1 to FR-1.9 --}}
@extends('layouts.app')

@section('title', 'Home')

@section('content')

<x-home-hero
    eyebrow="{{ __('pages.home.eyebrow') }}"
    title="{{ __('pages.home.title') }}"
    subtitle="{{ __('pages.home.subtitle') }}">
</x-home-hero>

{{-- FR-1.2 Key figures, matches Figma "stats" frame — data-viz accent colors, not brand blues --}}
<section class="section">
    <div class="stat-figma-grid">
        <div>
            <div class="stat-figma__value" style="color:var(--viz-amber);">24</div>
            <div class="stat-figma__label">Countries</div>
        </div>
        <div>
            <div class="stat-figma__value" style="color:var(--viz-green);">72</div>
            <div class="stat-figma__label">Active Agreements</div>
        </div>
        <div>
            <div class="stat-figma__value" style="color:var(--viz-purple);">100</div>
            <div class="stat-figma__label">Ongoing Projects</div>
        </div>
        <div>
            <div class="stat-figma__value" style="color:var(--color-cerulean);">72</div>
            <div class="stat-figma__label">Partners</div>
        </div>
    </div>
</section>

{{-- About ESI teaser — the presentation page had no discoverability from Home --}}
{{-- News + ESI Presentation Diaporama --}}
<section class="section">
    <div class="diaporama" data-diaporama data-interval="5000">

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
                        {{ __("Discover ESI's internationalization strategy, vision,
                        research domains, and opportunities for international collaboration.") }}
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

        let current = 0;
        let timer;

        /* Create dots */
        slides.forEach(function (_, index) {

            const dot = document.createElement('button');

            dot.type = 'button';
            dot.setAttribute(
                'aria-label',
                'Go to slide ' + (index + 1)
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
                <p class="quick-action__title">Explore our partnerships</p>
                <p class="quick-action__desc">Browse our network of academic and research institutions worldwide.</p>
            </span>
        </a>
        <a href="{{ url('/calls') }}" class="quick-action">
            <span class="quick-action__icon"><svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/><path d="M12 7v5l3 3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg></span>
            <span>
                <p class="quick-action__title">Find a funding opportunity</p>
                <p class="quick-action__desc">Browse open calls for proposals across all funding programmes.</p>
            </span>
        </a>
        <a href="{{ url('/mobility') }}" class="quick-action">
            <span class="quick-action__icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.5 3.5 3 12l3 1 1.5 3 1-2 4.5 4.5L15.5 21l1.5-8.5L21 9l-8-1.5L11 4l-.5-.5Z" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/><path d="M2 22 13 11" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>
            </span>
            <span>
                <p class="quick-action__title">Apply for mobility</p>
                <p class="quick-action__desc">Find student, staff, and research mobility offers currently open.</p>
            </span>
        </a>
        <a href="{{ url('/documents') }}" class="quick-action">
            <span class="quick-action__icon"><svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 3v12m0 0l-4-4m4 4l4-4M5 21h14" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
            <span>
                <p class="quick-action__title">Download documents</p>
                <p class="quick-action__desc">Access institutional brochures, templates, and application forms.</p>
            </span>
        </a>
        <a href="{{ url('/become-a-partner') }}" class="quick-action">
            <span class="quick-action__icon"><svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2M10 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM19 8v6M22 11h-6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg></span>
            <span>
                <p class="quick-action__title">Become a partner</p>
                <p class="quick-action__desc">Start a cooperation with ESI Algiers as an institutional partner.</p>
            </span>
        </a>
        <a href="{{ url('/contact') }}" class="quick-action">
            <span class="quick-action__icon"><svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="5" width="18" height="14" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="m3 7 9 6 9-6" stroke="currentColor" stroke-width="1.6"/></svg></span>
            <span>
                <p class="quick-action__title">Contact the IR Office</p>
                <p class="quick-action__desc">Reach the International Relations Office for any question.</p>
            </span>
        </a>
    </div>
</section>

{{-- FR-1.6 News + Events — matches Figma "News + events section" --}}
<section class="section two-col" style="background:var(--color-neutral-50);">
    <div>
        <div class="section__header section__header--row">
            <h2>Latest News</h2>
            <a href="{{ url('/news') }}" class="btn btn--outline btn--sm">View all →</a>
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
            <h2>Upcoming Events</h2>
            <a href="{{ url('/events') }}" class="btn btn--outline btn--sm">View all →</a>
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
            <h2>Calls for Proposals</h2>
            <p>Latest opportunities and calls approaching their deadline.</p>
        </div>
        <a href="{{ url('/calls') }}" class="btn btn--outline btn--sm">View all calls</a>
    </div>
    <div class="card-grid">
        <div class="card"><div class="card__body">
            <span class="badge badge--open">Open</span>
            <h3 class="card__title">Erasmus+ KA171 International Credit Mobility</h3>
            <p class="card__text">Student and staff mobility funding for partnerships with non-EU institutions.</p>
            <div class="card__meta">Deadline: 30 Sept 2026</div>
        </div></div>
        <div class="card"><div class="card__body">
            <span class="badge badge--closing-soon">Closing soon</span>
            <h3 class="card__title">Horizon Europe MSCA Staff Exchanges</h3>
            <p class="card__text">Funding for short-term research staff exchanges with international partners.</p>
            <div class="card__meta">Deadline: 5 Sept 2026</div>
        </div></div>
        <div class="card"><div class="card__body">
            <span class="badge badge--open">Open</span>
            <h3 class="card__title">PRIMA Research Cooperation Programme</h3>
            <p class="card__text">Mediterranean-focused research funding for water, energy and food systems.</p>
            <div class="card__meta">Deadline: 20 Oct 2026</div>
        </div></div>
    </div>
</section>

<section class="section section--tight" style="background:var(--color-neutral-50);">
    <div class="section__header section__header--row">
        <div>
            <h2>International Projects</h2>
            <p>Highlighted cooperation and research projects.</p>
        </div>
        <a href="{{ url('/projects') }}" class="btn btn--outline btn--sm">View all projects</a>
    </div>
    <div class="card-grid">
        <div class="card"><div class="card__body">
            <span class="badge badge--ongoing">Ongoing</span>
            <h3 class="card__title">DIGI-COOP — Digital Cooperation Network</h3>
            <p class="card__text">Erasmus+ capacity-building project on digital transformation in higher education.</p>
        </div></div>
        <div class="card"><div class="card__body">
            <span class="badge badge--ongoing">Ongoing</span>
            <h3 class="card__title">AI4MED — AI for Mediterranean Health</h3>
            <p class="card__text">Horizon Europe research consortium applying AI to regional health challenges.</p>
        </div></div>
        <div class="card"><div class="card__body">
            <span class="badge badge--completed">Completed</span>
            <h3 class="card__title">SMART-LAB — Shared Research Infrastructure</h3>
            <p class="card__text">PRIMA-funded initiative establishing a shared lab network across 6 countries.</p>
        </div></div>
    </div>
</section>

{{-- Testimonials preview — the Testimonials page had no discoverability from Home --}}
<section class="section">
    <div class="section__header section__header--row">
        <div>
            <h2>Testimonials</h2>
            <p>Stories from students and researchers who took part in an international mobility.</p>
        </div>
        <a href="{{ url('/testimonials') }}" class="btn btn--outline btn--sm">Read more →</a>
    </div>
    <div class="card-grid" style="grid-template-columns: repeat(2, 1fr);">
        <div class="card"><div class="card__body">
            <p class="card__text" style="font-style:italic;">"My exchange semester in Turin completely changed how I approach research — the whole process, from application to arrival, was smooth thanks to the IR office."</p>
            <div class="card__meta" style="margin-top:12px;">Amine K. — Semester Exchange, Politecnico di Torino</div>
        </div></div>
        <div class="card"><div class="card__body">
            <p class="card__text" style="font-style:italic;">"The scientific stay at Sorbonne gave me access to resources and collaborations I couldn't have found here alone."</p>
            <div class="card__meta" style="margin-top:12px;">Lina B. — Research Stay, Sorbonne Université</div>
        </div></div>
    </div>
</section>

{{-- FAQ callout --}}
<section class="section section--tight" style="background:var(--color-deep-space-blue);">
    <div style="display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap;">
        <div>
            <h2 style="font-family:var(--font-heading); font-weight:700; font-size:20px; color:var(--color-white); margin:0 0 6px;">Have a question?</h2>
            <p style="font-family:var(--font-body); font-size:14px; color:var(--color-footer-text); margin:0;">Check our FAQ for quick answers about partnerships, mobility, and funding.</p>
        </div>
        <a href="{{ url('/faq') }}" class="btn btn--accent btn--sm">Visit the FAQ →</a>
    </div>
</section>

@endsection