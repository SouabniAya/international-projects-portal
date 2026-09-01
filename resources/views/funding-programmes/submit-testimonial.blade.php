{{-- resources/views/submit-testimonial.blade.php — Public form for testimonial submission --}}
@extends('layouts.app')

@section('title', 'Submit a Testimonial')

@section('content')

<x-page-hero
    :title="__('pages.submit_testimonial.title')"
    :subtitle="__('pages.submit_testimonial.subtitle')"
    breadcrumb="<a href='{{ url('/') }}'>{{ __('nav.home') }}</a> / <a href='{{ url('/testimonials') }}'>Testimonials</a> / Submit">
</x-page-hero>

<section class="section" style="max-width:760px;">
    <div class="alert alert--info" style="margin-bottom:32px;">
        {{ __('pages.submit_testimonial.notice') }}
    </div>

    <form method="POST" action="{{ route('testimonials.store') }}" enctype="multipart/form-data">
        @csrf

        <p class="form-hint" style="text-transform:uppercase; font-weight:700; letter-spacing:.03em; color:var(--color-ink-black); margin-bottom:12px;">{{ __('pages.submit_testimonial.your_information') }}</p>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="authorName">{{ __('common.full_name') }}</label>
                <input class="form-control" type="text" id="authorName" name="author_name" value="{{ old('author_name') }}" required>
                @error('author_name')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="authorRole">{{ __('pages.submit_testimonial.your_role') }}</label>
                <input class="form-control" type="text" id="authorRole" name="author_role" value="{{ old('author_role') }}" placeholder="e.g. Student, Researcher, Partner">
                @error('author_role')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="email">{{ __('common.email') }}</label>
                <input class="form-control" type="email" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="phone">{{ __('common.phone') }}</label>
                <input class="form-control" type="tel" id="phone" name="phone" value="{{ old('phone') }}">
                @error('phone')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <p class="form-hint" style="text-transform:uppercase; font-weight:700; letter-spacing:.03em; color:var(--color-ink-black); margin:24px 0 12px;">{{ __('pages.submit_testimonial.about_your_experience') }}</p>
        
        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="mobilityType">{{ __('pages.submit_testimonial.mobility_type') }}</label>
                <select class="form-control" id="mobilityType" name="mobility_type">
                    <option value="" disabled selected>{{ __('pages.submit_testimonial.select_type') }}</option>
                    <option value="Student Mobility">{{ __('pages.submit_testimonial.student_mobility') }}</option>
                    <option value="Staff Mobility">{{ __('pages.submit_testimonial.staff_mobility') }}</option>
                    <option value="Research">{{ __('pages.submit_testimonial.research') }}</option>
                    <option value="Partnership">{{ __('pages.submit_testimonial.partnership') }}</option>
                    <option value="Other">{{ __('pages.submit_testimonial.other') }}</option>
                </select>
                @error('mobility_type')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="country">{{ __('common.country') }}</label>
                <select class="form-control" id="country" name="country">
                    <option value="" disabled selected>{{ __('pages.submit_testimonial.select_country') }}</option>
                    @foreach ($countries as $c)
                    <option value="{{ $c->countryCode }}" {{ old('country') == $c->countryCode ? 'selected' : '' }}>{{ $c->translation()?->countryName ?? $c->countryCode }}</option>
                    @endforeach
                </select>
                @error('country')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="project_id">{{ __('pages.submit_testimonial.related_project') }}</label>
                <select class="form-control" id="project_id" name="project_id">
                    <option value="">{{ __('pages.submit_testimonial.select_project') }}</option>
                    @foreach ($projects as $p)
                    <option value="{{ $p['id'] }}" {{ old('project_id') == $p['id'] ? 'selected' : '' }}>{{ $p['title'] }}</option>
                    @endforeach
                </select>
                @error('project_id')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="mobility_id">{{ __('pages.submit_testimonial.related_mobility') }}</label>
                <select class="form-control" id="mobility_id" name="mobility_id">
                    <option value="">{{ __('pages.submit_testimonial.select_mobility') }}</option>
                    @foreach ($mobilities as $m)
                    <option value="{{ $m['id'] }}" {{ old('mobility_id') == $m['id'] ? 'selected' : '' }}>{{ $m['title'] }}</option>
                    @endforeach
                </select>
                @error('mobility_id')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="content">{{ __('pages.submit_testimonial.your_testimonial') }}</label>
            <textarea class="form-control" id="content" name="content" rows="6" required placeholder="{{ __('pages.submit_testimonial.testimonial_placeholder') }}">{{ old('content') }}</textarea>
            <p class="form-hint">{{ __('pages.submit_testimonial.character_limit') }}</p>
            @error('content')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="photo">{{ __('pages.submit_testimonial.photo') }}</label>
            <input class="form-control" type="file" id="photo" name="photo" accept="image/*">
            <p class="form-hint">{{ __('pages.submit_testimonial.photo_hint') }}</p>
            @error('photo')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group" style="margin-top:24px;">
            <label style="display:flex; align-items:center; gap:8px; font-family:var(--font-body); font-size:13.5px; color:var(--color-ink-black);">
                <input type="checkbox" name="agree_terms" value="1" required>
                {{ __('pages.submit_testimonial.agree_terms') }}
            </label>
            @error('agree_terms')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn--primary" style="margin-top:24px;">{{ __('pages.submit_testimonial.submit_button') }}</button>
    </form>
</section>

@endsection
