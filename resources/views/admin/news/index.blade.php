@extends('layouts.admin')

@section('title', 'News')
@php($active = 'cooperation')

@section('content')
<div class="section__header section__header--row" style="margin-bottom:18px;">
    <div>
        <h2 style="margin:0;">{{ __('News Management') }}</h2>
        <p style="margin:4px 0 0;">{{ __('Review and manage public news articles.') }}</p>
    </div>
    <a href="{{ route('admin.news.create') }}" class="btn btn--primary btn--sm">+ {{ __('New News') }}</a>
</div>

@if(session('success'))
    <div class="alert alert--success" style="margin-bottom:18px;">{{ session('success') }}</div>
@endif

<form method="GET" action="{{ route('admin.news') }}" class="filter-bar" style="margin-bottom:20px;">
    <div class="filter-bar__search">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/>
            <path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
        <input type="search" name="search" value="{{ request('search') }}" placeholder="{{ __('Search title or content...') }}">
    </div>
    <button type="submit" class="btn btn--secondary btn--sm">{{ __('Apply') }}</button>
</form>

<div class="card">
    <div class="card__body" style="padding:0; overflow-x:auto;">
        <table class="data-table" style="width:100%;">
            <thead>
                <tr>
                    <th>{{ __('Title') }}</th>
                    <th>{{ __('Date') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($news as $item)
                    @php($translation = $item->translation(app()->getLocale()) ?? $item->translation('en') ?? $item->translations->first())
                    <tr>
                        <td><strong>{{ $translation?->title ?? __('Untitled news') }}</strong></td>
                        <td>{{ $item->publicationDate?->format('d M Y') ?? '—' }}</td>
                        <td>{{ __(ucfirst($item->publicationStatus)) }}</td>
                        <td style="white-space:nowrap;">
                            <a href="{{ route('admin.news.show', $item->newsID) }}" class="btn btn--outline btn--sm">{{ __('View') }}</a>
                            <a href="{{ route('admin.news.edit', $item->newsID) }}" class="btn btn--outline btn--sm">{{ __('Edit') }}</a>
                            <form action="{{ route('admin.news.destroy', $item->newsID) }}" method="POST" style="display:inline;" data-confirm-form>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn--ghost btn--sm" data-confirm="{{ __('Delete this news item?') }}">{{ __('Delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="padding:30px; text-align:center; color:var(--color-neutral-500);">{{ __('No news found.') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($news->hasPages())
    <div style="margin-top:18px;">{{ $news->links() }}</div>
@endif

<script>
document.querySelectorAll('form[data-confirm-form]').forEach(function (form) {
    form.addEventListener('submit', function (e) {
        var btn = form.querySelector('[data-confirm]');
        var message = btn ? btn.getAttribute('data-confirm') : 'Are you sure?';
        if (!confirm(message)) {
            e.preventDefault();
        }
    });
});
</script>
@endsection