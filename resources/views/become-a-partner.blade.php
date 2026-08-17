{{-- resources/views/become-a-partner.blade.php — based on Figma "BECOME A PARTNER" (59:4234) --}}
@extends('layouts.app')

@section('title', 'Become a Partner')

@section('content')

<x-page-hero
    :title="__('pages.become_a_partner.title')"
    :subtitle="__('pages.become_a_partner.subtitle')"
    breadcrumb="<a href='{{ url('/') }}'>{{ __('nav.home') }}</a> / <a href='{{ url('/partnerships') }}'>Partnerships</a> / Become a Partner">
</x-page-hero>

<section class="section" style="max-width:760px;">
    <div class="alert alert--info" style="margin-bottom:32px;">
        Applications are reviewed by the International Relations Office within two weeks. You'll be contacted
        by email once a decision has been made.
    </div>

    <form method="POST" action="{{ route('become-a-partner.store') }}" data-demo-submit="Application submitted — you'll hear back within two weeks (demo — connect this route to persist).">
        @csrf

        <p class="form-hint" style="text-transform:uppercase; font-weight:700; letter-spacing:.03em; color:var(--color-ink-black); margin-bottom:12px;">Your contact information</p>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="requesterName">Your full name</label>
                <input class="form-control" type="text" id="requesterName" name="requester_name" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="requesterRole">Your role / position</label>
                <input class="form-control" type="text" id="requesterRole" name="requester_role" placeholder="e.g. International Relations Officer">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <input class="form-control" type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="phone">Phone</label>
                <input class="form-control" type="tel" id="phone" name="phone">
            </div>
        </div>

        <p class="form-hint" style="text-transform:uppercase; font-weight:700; letter-spacing:.03em; color:var(--color-ink-black); margin:24px 0 12px;">Institution details</p>
        <div class="form-group">
            <label class="form-label" for="organizationName">Organization name</label>
            <input class="form-control" type="text" id="organizationName" name="organization_name" required>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="institutionType">Institution type</label>
                <select class="form-control" id="institutionType" name="institution_type">
                    <option>University</option>
                    <option>Research center</option>
                    <option>Company</option>
                    <option>Government agency</option>
                    <option>Other</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label" for="website">Institution website</label>
                <input class="form-control" type="url" id="website" name="website" placeholder="https://">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="country">Country</label>
                <select class="form-control" id="country" name="country">
                    <option>France</option>
                    <option>Italy</option>
                    <option>Germany</option>
                    <option>Spain</option>
                    <option>Other</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label" for="city">City</label>
                <input class="form-control" type="text" id="city" name="city">
            </div>
        </div>

        <p class="form-hint" style="text-transform:uppercase; font-weight:700; letter-spacing:.03em; color:var(--color-ink-black); margin:24px 0 12px;">Proposed cooperation</p>
        <div class="form-group">
            <label class="form-label">Areas of interest</label>
            <div class="flex-row" style="gap:16px;">
                @foreach (['Student mobility', 'Staff mobility', 'Joint research', 'Joint projects', 'Academic events'] as $area)
                <label style="display:flex; align-items:center; gap:6px; font-family:var(--font-body); font-size:13.5px; color:var(--color-ink-black);">
                    <input type="checkbox" name="areas_of_interest[]" value="{{ $area }}">
                    {{ $area }}
                </label>
                @endforeach
            </div>
        </div>
        <div class="form-group">
            <label class="form-label" for="message">Tell us about your institution and proposed cooperation</label>
            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
        </div>
        <div class="form-group">
            <label class="form-label" for="supportingDoc">Supporting document (optional)</label>
            <input class="form-control" type="file" id="supportingDoc" name="supporting_document">
            <p class="form-hint">Institutional brochure, MoU draft, or letter of intent — PDF preferred.</p>
        </div>

        <button type="submit" class="btn btn--primary">Submit application</button>
    </form>
</section>

@endsection
