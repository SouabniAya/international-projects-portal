@extends('layouts.admin')

@section('title', 'News Details')
@php($active = 'cooperation')

@section('content')
<div class="section__header section__header--row" style="margin-bottom:18px;">
    <div>
        <h2 style="margin:0;">{{ $news->translation(app()->getLocale())?->title ?? $news->translation('en')?->title ?? 'News' }}</h2>
        <p style="margin:4px 0 0;">{{ $news->publicationDate?->format('d M Y') ?? '—' }}</p>
    </div>
    <div style="display:flex; gap:10px; flex-wrap:wrap;">
        <a href="{{ route('admin.news.edit', $news->newsID) }}" class="btn btn--primary btn--sm">Edit</a>
        <form method="POST" action="{{ route('admin.news.destroy', $news->newsID) }}" onsubmit="return confirm('Delete this news item?')" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn--outline btn--sm">Delete</button>
        </form>
    </div>
</div>

@if(session('success'))
    <div class="alert alert--success" style="margin-bottom:18px;">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card__body" style="display:grid; gap:18px;">
        <div>
            <strong>Status:</strong> {{ ucfirst($news->publicationStatus) }}
        </div>
        <div>
            <strong>Publication date:</strong> {{ $news->publicationDate?->format('d M Y') ?? '—' }}
        </div>
        <div>
            <strong>Image:</strong> {{ $news->image ?: '—' }}
        </div>
        <div>
            <strong>Content:</strong>
            <div style="margin-top:8px; white-space:pre-wrap;">{{ $news->translation(app()->getLocale())?->content ?? $news->translation('en')?->content ?? 'No content yet.' }}</div>
        </div>
    </div>
</div>
@endsection
