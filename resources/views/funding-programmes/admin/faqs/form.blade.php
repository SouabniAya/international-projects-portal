@extends('layouts.admin')

@section('title', isset($faq) ? 'Edit FAQ' : 'Create FAQ')
@php($active = 'cooperation')

@section('content')
<div class="section__header" style="margin-bottom:20px;">
    <h2 style="margin:0;">{{ isset($faq) ? 'Edit FAQ' : 'Create FAQ' }}</h2>
    <p style="margin:6px 0 0;">Add or update a public FAQ item.</p>
</div>

@if($errors->any())
    <div class="alert alert--error" style="margin-bottom:18px;">
        <ul style="margin:0; padding-left:20px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ isset($faq) ? route('admin.faqs.update', $faq->faqID) : route('admin.faqs.store') }}" class="card">
    @csrf
    @if(isset($faq))
        @method('PUT')
    @endif

    <div class="card__body" style="display:grid; gap:18px;">
        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="language">Language</label>
                <select class="form-control" id="language" name="language" required>
                    @foreach(['en' => 'English', 'fr' => 'French', 'ar' => 'Arabic'] as $code => $label)
                        <option value="{{ $code }}" {{ old('language', $faq?->translation($locale)?->languageCode ?? $locale) == $code ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label" for="display_order">Display order</label>
                <input class="form-control" id="display_order" type="number" min="0" name="display_order" value="{{ old('display_order', $faq?->displayOrder ?? 0) }}">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="question">Question</label>
            <input class="form-control" id="question" type="text" name="question" value="{{ old('question', $faq?->translation($locale)?->question) }}" maxlength="500" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="answer">Answer</label>
            <textarea class="form-control" id="answer" name="answer" rows="8" required>{{ old('answer', $faq?->translation($locale)?->answer) }}</textarea>
        </div>

        <div style="display:flex; gap:10px; flex-wrap:wrap;">
            <button type="submit" class="btn btn--primary">{{ isset($faq) ? 'Update FAQ' : 'Create FAQ' }}</button>
            <a href="{{ route('admin.faqs') }}" class="btn btn--outline">Cancel</a>
        </div>
    </div>
</form>
@endsection
