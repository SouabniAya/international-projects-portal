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

    <form method="POST" action="{{ route('contact.store') }}">
        @csrf
        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="name">{{ __('contact.label_name') }}</label>
                <input class="form-control" type="text" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="email">{{ __('contact.label_email') }}</label>
                <input class="form-control" type="email" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="phone">{{ __('contact.label_phone') }}</label>
                <input class="form-control" type="tel" id="phone" name="phone" value="{{ old('phone') }}">
            </div>
            <div class="form-group">
                <label class="form-label" for="requesterType">{{ __('contact.label_iam') }}</label>
                <select class="form-control" id="requesterType" name="requester_type">
                    @foreach ($requesterTypes as $type)
                        <option value="{{ $type['code'] }}" @selected(old('requester_type') == $type['code'])>
                            {{ $type['label'] }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="subject">{{ __('contact.label_subject') }}</label>
            <select class="form-control" id="subject" name="subject">
                @foreach ($subjects as $subject)
                    <option value="{{ $subject['code'] }}" @selected(old('subject') == $subject['code'])>
                        {{ $subject['label'] }}
                    </option>
                @endforeach
            </select>
            <p class="form-hint">{{ __('contact.subject_hint') }}</p>
            @error('subject')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="message">{{ __('contact.label_message') }}</label>
            <textarea class="form-control" id="message" name="message" rows="6" required>{{ old('message') }}</textarea>
            @error('message')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <label style="display:flex; align-items:flex-start; gap:8px; font-family:var(--font-body); font-size:12.5px; color:var(--color-neutral-500); margin-bottom:20px;">
            <input type="checkbox" name="consent" required style="margin-top:2px;">
            {{ __('contact.consent_text') }}
        </label>
        @error('consent')
            <p class="form-error">{{ $message }}</p>
        @enderror

        <button type="submit" class="btn btn--primary">{{ __('contact.btn_send') }}</button>

        @if (session('success'))
            <div class="alert alert--success" style="margin-top:16px; padding:14px 18px; border-radius:8px; background:#E6F4EA; color:#1E7E34; font-family:var(--font-body); font-size:14px;">
                {{ session('success') }}
            </div>
        @endif
    </form>

    <aside>
        <div class="card">
            <div class="card__body">
                <h3 class="card__title">{{ __('pages.contact.office_name') }}</h3>
                <p class="card__text">
                    École nationale Supérieure d'Informatique (ESI)<br>
                    {{ $officeAddress }}, {{ $officeLocation }}
                </p>
                <p class="card__text">{{ $officeEmail }}<br>{{ $officePhone }}</p>
            </div>
        </div>
        <div class="card" style="margin-top:20px;">
            <div class="card__body">
                <h3 class="card__title">{{ __('contact.office_hours_title') }}</h3>
                <p class="card__text">{{ $hoursText }}</p>
            </div>
        </div>
    </aside>
</section>

@endsection