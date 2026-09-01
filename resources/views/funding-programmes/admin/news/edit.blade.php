@extends('layouts.admin')

@section('title', 'Edit News')
@php($active = 'cooperation')

@section('content')
<div class="section__header" style="margin-bottom:20px;">
    <h2 style="margin:0;">Edit News Item</h2>
    <p style="margin:6px 0 0;">Update the current public-facing article.</p>
</div>

@include('admin.news.form', ['news' => $news, 'action' => route('admin.news.update', $news->newsID), 'method' => 'PUT'])
@endsection
