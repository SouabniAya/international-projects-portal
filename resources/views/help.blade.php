{{-- resources/views/help.blade.php --}}
@extends('layouts.app')

@section('title', 'Help')

@section('content')

<x-page-hero
    title="Help & Guidance"
    subtitle="Everything you need to find your way around the International Projects Portal."
    breadcrumb="<a href='{{ url('/') }}'>Home</a> / Help">
</x-page-hero>

<section class="section" style="max-width:900px;">

    <div class="card-grid">

        <div class="card"><div class="card__body">
            <h3 class="card__title">Finding a call for proposals</h3>
            <p class="card__text">
                Browse open and upcoming funding calls on the
                <a href="{{ url('/calls') }}">Calls for Proposals</a> page. Use the filters to narrow
                results by programme or status, and check each call's deadline before applying
                through the official link provided.
            </p>
        </div></div>

        <div class="card"><div class="card__body">
            <h3 class="card__title">Applying for a mobility opportunity</h3>
            <p class="card__text">
                Outgoing and incoming mobility opportunities are listed on the
                <a href="{{ url('/mobility') }}">Mobility</a> page. Each listing shows the application
                deadline, eligibility, and how to apply.
            </p>
        </div></div>

        <div class="card"><div class="card__body">
            <h3 class="card__title">Becoming a partner institution</h3>
            <p class="card__text">
                If your institution is interested in a partnership with ESI, submit a request through
                the <a href="{{ url('/become-a-partner') }}">Become a Partner</a> page. Our
                International Relations Office will follow up by email.
            </p>
        </div></div>

        <div class="card"><div class="card__body">
            <h3 class="card__title">Browsing projects and partnerships</h3>
            <p class="card__text">
                The <a href="{{ url('/projects') }}">Projects</a> and
                <a href="{{ url('/partnerships') }}">Partnerships</a> pages list ESI's ongoing and
                completed international collaborations, searchable by keyword and programme.
            </p>
        </div></div>

        <div class="card"><div class="card__body">
            <h3 class="card__title">Frequently asked questions</h3>
            <p class="card__text">
                Common questions about mobility, funding, and partnerships are answered on the
                <a href="{{ url('/faq') }}">FAQ</a> page.
            </p>
        </div></div>

        <div class="card"><div class="card__body">
            <h3 class="card__title">Still need help?</h3>
            <p class="card__text">
                Reach the International Relations Office directly through the
                <a href="{{ url('/contact') }}">Contact</a> page.
            </p>
        </div></div>

    </div>

</section>

@endsection
