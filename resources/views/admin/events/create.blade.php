@extends('layouts.admin')
@php($active = 'events')
@section('title', 'New Event')
@section('content')
<div class="section__header"><h1>{{ __('New event') }}</h1></div>
@include('admin.events.form', ['event' => null, 'action' => route('admin.events.store'), 'method' => 'POST'])
@endsection