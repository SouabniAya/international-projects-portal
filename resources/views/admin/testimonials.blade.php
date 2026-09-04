@extends('layouts.admin')

@section('title', 'Testimonials')
@php($active = 'testimonials')

@section('content')
<div class="testimonial-admin-page">
    <div class="section__header section__header--row" style="margin-bottom:18px;">
        <div>
            <h2 style="margin:0;">{{ __('Testimonials') }}</h2>
            <p style="margin:4px 0 0;">{{ __('Review and moderate customer feedback submitted through the public portal.') }}</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert--success" style="margin-bottom:18px;">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('admin.testimonials') }}" class="filter-bar" style="margin-bottom:20px;">
        <div class="filter-bar__search">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/>
                <path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            <input type="search" name="search" value="{{ $filters['search'] }}" placeholder="{{ __('Search author or feedback...') }}">
        </div>

        <select class="form-control" name="status" aria-label="{{ __('Status') }}" onchange="this.form.submit()">
            <option value="all" @selected($filters['status'] === 'all')>{{ __('All statuses') }}</option>
            <option value="approved" @selected($filters['status'] === 'approved')>{{ __('Published') }}</option>
            <option value="pending" @selected($filters['status'] === 'pending')>{{ __('Pending') }}</option>
            <option value="rejected" @selected($filters['status'] === 'rejected')>{{ __('Rejected') }}</option>
        </select>

        <button type="submit" class="btn btn--secondary btn--sm">{{ __('Apply') }}</button>
        @if($filters['search'] !== '' || $filters['status'] !== 'all')
            <a href="{{ route('admin.testimonials') }}" class="btn btn--outline btn--sm">{{ __('Clear') }}</a>
        @endif
    </form>

    <div class="card">
        <div class="card__body" style="padding:0; overflow-x:auto;">
            <table class="data-table" style="width:100%;">
                <thead>
                    <tr>
                        <th>{{ __('Author') }}</th>
                        <th>{{ __('Role') }}</th>
                        <th>{{ __('Feedback') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Date') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($testimonials as $testimonial)
                        <tr>
                            <td><strong>{{ $testimonial['author'] }}</strong></td>
                            <td>{{ $testimonial['role'] }}</td>
                            <td>{{ Str::limit(strip_tags($testimonial['content']), 120) }}</td>
                            <td>
                                <span class="badge badge--{{ $testimonial['status'] === 'approved' ? 'approved' : ($testimonial['status'] === 'rejected' ? 'rejected' : 'pending') }}">
                                    {{ __($testimonial['status_label']) }}
                                </span>
                            </td>
                            <td>{{ $testimonial['date'] }}</td>
                            <td style="white-space:nowrap;">
                                @if($testimonial['status'] !== 'approved')
                                    <form action="{{ route('admin.testimonials.status', $testimonial['id']) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="btn btn--secondary btn--sm">{{ __('Publish') }}</button>
                                    </form>
                                @endif

                                @if($testimonial['status'] !== 'pending')
                                    <form action="{{ route('admin.testimonials.status', $testimonial['id']) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="status" value="pending">
                                        <button type="submit" class="btn btn--outline btn--sm">{{ __('Pending') }}</button>
                                    </form>
                                @endif

                                @if($testimonial['status'] !== 'rejected')
                                    <form action="{{ route('admin.testimonials.status', $testimonial['id']) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="btn btn--ghost btn--sm">{{ __('Reject') }}</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center; padding:30px; color:var(--color-neutral-500);">{{ __('No testimonials found.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($testimonials->hasPages())
        <div style="margin-top:18px;">{{ $testimonials->links() }}</div>
    @endif
</div>
@endsection