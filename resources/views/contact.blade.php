{{-- resources/views/contact.blade.php — FR-9.1, FR-9.2 --}}
@extends('layouts.app')

@section('title', 'Contact')

@section('content')

<x-page-hero
    :title="__('pages.contact.title')"
    :subtitle="__('pages.contact.subtitle')"
    breadcrumb="<a href='{{ url('/') }}'>{{ __('nav.home') }}</a> / Contact">
</x-page-hero>

<section class="section two-col--narrow-first" style="display:grid; gap:48px;">
    <form method="POST" action="{{ route('contact.store') }}" data-demo-submit="Message sent — the International Relations Office will get back to you soon (demo — connect this route to persist).">
        @csrf
        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="name">Full name</label>
                <input class="form-control" type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <input class="form-control" type="email" id="email" name="email" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="phone">Phone (optional)</label>
                <input class="form-control" type="tel" id="phone" name="phone">
            </div>
            <div class="form-group">
                <label class="form-label" for="requesterType">I am a...</label>
                <select class="form-control" id="requesterType" name="requester_type">
                    <option>Prospective student</option>
                    <option>Current ESI student</option>
                    <option>Researcher</option>
                    <option>Partner institution representative</option>
                    <option>Other</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="subject">Subject</label>
            <select class="form-control" id="subject" name="subject">
                <option>Partnership agreement</option>
                <option>Mobility application</option>
                <option>Funding / call for proposals</option>
                <option>Document request</option>
                <option>Other</option>
            </select>
            <p class="form-hint">Your message is automatically routed to the staff member responsible for this topic.</p>
        </div>

        <div class="form-group">
            <label class="form-label" for="message">Message</label>
            <textarea class="form-control" id="message" name="message" rows="6" required></textarea>
        </div>

        <label style="display:flex; align-items:flex-start; gap:8px; font-family:var(--font-body); font-size:12.5px; color:var(--color-neutral-500); margin-bottom:20px;">
            <input type="checkbox" name="consent" required style="margin-top:2px;">
            I agree that my information will be used by the International Relations Office to respond to my request.
        </label>

        <button type="submit" class="btn btn--primary">Send message</button>
    </form>

    <aside>
        <div class="card">
            <div class="card__body">
                <h3 class="card__title">International Relations Office</h3>
                <p class="card__text">École nationale Supérieure d'Informatique (ESI)<br>Oued Smar, Algiers, Algeria</p>
                <p class="card__text">international@esi.dz<br>+213 (0)21 00 00 00</p>
            </div>
        </div>
        <div class="card" style="margin-top:20px;">
            <div class="card__body">
                <h3 class="card__title">Office Hours</h3>
                <p class="card__text">Sunday – Thursday, 9:00 – 16:00</p>
            </div>
        </div>
    </aside>
</section>

@endsection
