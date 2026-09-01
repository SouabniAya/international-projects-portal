@extends('layouts.app')

@section('title', 'Register interest')

@section('content')
<x-page-hero
    title="Register interest"
    :subtitle="$event['title']"
    breadcrumb="<a href='{{ url('/') }}'>{{ __('nav.home') }}</a> / <a href='{{ route('events.index') }}'>Events</a> / Register">
</x-page-hero>

<section class="section" style="max-width:760px;">
    <div class="alert alert--info" style="margin-bottom:28px;">
        Your registration request will be sent to the International Relations Office.
    </div>

    <form method="POST" action="{{ route('events.register.store', $event['id']) }}">
        @csrf

        <div class="form-group">
            <label class="form-label" for="fullName">Full name</label>
            <input class="form-control" id="fullName" name="fullName" value="{{ old('fullName') }}" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <input class="form-control" type="email" id="email" name="email" value="{{ old('email') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="phone">Phone</label>
                <input class="form-control" type="tel" id="phone" name="phone" value="{{ old('phone') }}">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="attendeeType">Attending as</label>
            <select class="form-control" id="attendeeType" name="attendeeType" required>
                <option value="" disabled {{ old('attendeeType') ? '' : 'selected' }}>Select an option</option>
                <option value="participant" @selected(old('attendeeType') == 'participant')>Participant</option>
                <option value="speaker" @selected(old('attendeeType') == 'speaker')>Speaker</option>
                <option value="partner" @selected(old('attendeeType') == 'partner')>Partner institution representative</option>
                <option value="press" @selected(old('attendeeType') == 'press')>Press / Media</option>
                <option value="other" @selected(old('attendeeType') == 'other')>Other</option>
            </select>
        </div>

        <div class="form-group">
            <label class="form-label" for="message">Additional information</label>
            <textarea class="form-control" id="message" name="message" rows="5">{{ old('message') }}</textarea>
        </div>

        <div class="form-group" style="margin-top:16px;">
            <label style="display:flex;align-items:center;gap:8px;">
                <input type="checkbox" name="consent" value="1" required @checked(old('consent'))>
                I agree to the processing of my information for this registration request.
            </label>
        </div>

        <button type="submit" class="btn btn--primary">Submit registration</button>
    </form>
</section>
@endsection