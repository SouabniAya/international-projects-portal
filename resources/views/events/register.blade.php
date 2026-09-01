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
            <label class="form-label" for="name">Full name</label>
            <input class="form-control" id="name" name="name" value="{{ old('name') }}" required>
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
            <label class="form-label" for="subject">Reason</label>
            <select class="form-control" id="subject" name="subject" required>
                <option value="" disabled {{ old('subject') ? '' : 'selected' }}>Select a reason</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject['code'] }}" @selected(old('subject') == $subject['code'])>{{ $subject['label'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="form-label" for="message">Additional information</label>
            <textarea class="form-control" id="message" name="message" rows="5">{{ old('message') }}</textarea>
        </div>
        <input type="hidden" name="event_registration" value="1">
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
