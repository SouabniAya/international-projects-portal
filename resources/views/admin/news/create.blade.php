@extends('layouts.admin')

@section('title', 'Create News')
@php($active = 'cooperation')

@section('content')
<div class="section__header" style="margin-bottom:20px;">
    <h2 style="margin:0;">{{ __('Create News Item') }}</h2>
    <p style="margin:6px 0 0;">{{ __('Publish a new article for the public portal.') }}</p>
</div>

@include('admin.news.form', ['news' => null, 'action' => route('admin.news.store'), 'method' => 'POST'])
@endsection