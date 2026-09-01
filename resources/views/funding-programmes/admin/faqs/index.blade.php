@extends('layouts.admin')

@section('title', 'FAQ Management')
@php($active = 'cooperation')

@section('content')
<div class="section__header section__header--row" style="margin-bottom:18px;">
    <div>
        <h2 style="margin:0;">FAQ Management</h2>
        <p style="margin:4px 0 0;">Manage frequently asked questions for the public portal.</p>
    </div>
    <a href="{{ route('admin.faqs.create') }}" class="btn btn--primary btn--sm">+ New FAQ</a>
</div>

@if(session('success'))
    <div class="alert alert--success" style="margin-bottom:18px;">{{ session('success') }}</div>
@endif

<form method="GET" action="{{ route('admin.faqs') }}" class="filter-bar" style="margin-bottom:20px;">
    <div class="filter-bar__search">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/>
            <path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
        <input type="search" name="search" value="{{ $filters['search'] }}" placeholder="Search question or answer...">
    </div>
    <button type="submit" class="btn btn--secondary btn--sm">Apply</button>
    @if($filters['search'] !== '')
        <a href="{{ route('admin.faqs') }}" class="btn btn--outline btn--sm">Clear</a>
    @endif
</form>

<div class="card">
    <div class="card__body" style="padding:0; overflow-x:auto;">
        <table class="data-table" style="width:100%;">
            <thead>
                <tr>
                    <th>Question</th>
                    <th>Answer</th>
                    <th>Order</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($faqs as $faq)
                    @php($translation = $faq->translation(app()->getLocale()) ?? $faq->translation('en') ?? $faq->translations->first())
                    <tr>
                        <td><strong>{{ $translation?->question ?? 'Untitled FAQ' }}</strong></td>
                        <td>{{ Str::limit(strip_tags($translation?->answer ?? ''), 120) }}</td>
                        <td>{{ $faq->displayOrder }}</td>
                        <td style="white-space:nowrap;">
                            <a href="{{ route('admin.faqs.edit', $faq->faqID) }}" class="btn btn--outline btn--sm">Edit</a>
                            <form action="{{ route('admin.faqs.destroy', $faq->faqID) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this FAQ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn--ghost btn--sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="padding:30px; text-align:center; color:var(--color-neutral-500);">No FAQs found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($faqs->hasPages())
    <div style="margin-top:18px;">{{ $faqs->links() }}</div>
@endif
@endsection
