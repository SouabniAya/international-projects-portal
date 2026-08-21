@extends('layouts.app')

@section('title', $project['title'])

@section('content')

<section class="project-details-hero">

    <div class="project-details-hero__inner">

        <a
            href="{{ route('projects') }}"
            class="project-details-back"
        >
            ← {{ __('Back to International Projects') }}
        </a>


        <div class="project-details-programme">

            <span class="project-details-programme__logo">
                {{ substr($project['programme'], 0, 1) }}
            </span>

            <span>
                {{ __($project['programme']) }}
            </span>

        </div>


        <div class="project-details-heading">

            <div>

                <span class="project-details-status project-details-status--{{ strtolower($project['status']) }}">
                    {{ __($project['status']) }}
                </span>

                <h1>
                    {{ __($project['title']) }}
                </h1>

                <p>
                    {{ __($project['desc']) }}
                </p>

            </div>

        </div>

    </div>

</section>


<section class="project-details-content">

    <div class="project-details-layout">


        {{-- MAIN CONTENT --}}
        <main class="project-details-main">

            <section class="project-details-section">

                <h2>
                    {{ __('About the Project') }}
                </h2>

                <div class="project-details-line"></div>

                <p>
                    {{ __($project['overview']) }}
                </p>

            </section>


            <section class="project-details-section">

                <h2>
                    {{ __('Project Objectives') }}
                </h2>

                <div class="project-details-line"></div>

                <div class="project-objectives">

                    @foreach($project['objectives'] as $objective)

                        <div class="project-objective">

                            <span class="project-objective__number">
                                {{ sprintf('%02d', $loop->iteration) }}
                            </span>

                            <p>
                                {{ __($objective) }}
                            </p>

                        </div>

                    @endforeach

                </div>

            </section>


            <section class="project-details-section">

                <h2>
                    {{ __('Expected Impact') }}
                </h2>

                <div class="project-details-line"></div>

                <p>
                    {{ __('The project aims to create long-term impact through international cooperation, knowledge exchange, innovation and the development of sustainable solutions that can benefit students, researchers and partner institutions.') }}
                </p>

            </section>


            <section class="project-details-section">

                <h2>
                    {{ __('International Cooperation') }}
                </h2>

                <div class="project-details-line"></div>

                <p>
                    {{ __('This project brings together universities, research institutions and international partners to exchange expertise and develop collaborative initiatives across borders.') }}
                </p>

            </section>

        </main>


        {{-- SIDEBAR --}}
        <aside class="project-details-sidebar">


            <div class="project-info-card">

                <h3>
                    {{ __('Project Information') }}
                </h3>


                <div class="project-info-item">

                    <span class="project-info-item__label">
                        {{ __('Funding Programme') }}
                    </span>

                    <strong>
                        {{ __($project['programme']) }}
                    </strong>

                </div>


                <div class="project-info-item">

                    <span class="project-info-item__label">
                        {{ __('Status') }}
                    </span>

                    <strong>
                        {{ __($project['status']) }}
                    </strong>

                </div>


                <div class="project-info-item">

                    <span class="project-info-item__label">
                        {{ __('Thematic Area') }}
                    </span>

                    <strong>
                        {{ __($project['thematic_area']) }}
                    </strong>

                </div>


                <div class="project-info-item">

                    <span class="project-info-item__label">
                        {{ __('Duration') }}
                    </span>

                    <strong>
                        {{ $project['duration'] }}
                    </strong>

                </div>


                <div class="project-info-item">

                    <span class="project-info-item__label">
                        {{ __('Coordinator') }}
                    </span>

                    <strong>
                        {{ $project['coordinator'] }}
                    </strong>

                </div>


                <div class="project-info-item">

                    <span class="project-info-item__label">
                        {{ __('Partners') }}
                    </span>

                    <strong>
                        {{ $project['partners'] }}
                    </strong>

                </div>


                <div class="project-info-item">

                    <span class="project-info-item__label">
                        {{ __('Countries') }}
                    </span>

                    <strong>
                        {{ $project['countries'] }}
                    </strong>

                </div>


                <div class="project-info-item">

                    <span class="project-info-item__label">
                        {{ __('Estimated Budget') }}
                    </span>

                    <strong>
                        {{ $project['budget'] }}
                    </strong>

                </div>

            </div>


            <div class="project-contact-card">

                <div class="project-contact-card__icon">
                    ✦
                </div>

                <h3>
                    {{ __('Interested in this project?') }}
                </h3>

                <p>
                    {{ __('Contact our international cooperation team to learn more about this project and partnership opportunities.') }}
                </p>

                <a href="{{ url('/contact') }}">
                    {{ __('Contact Us') }} →
                </a>

            </div>


        </aside>

    </div>

</section>

@endsection


