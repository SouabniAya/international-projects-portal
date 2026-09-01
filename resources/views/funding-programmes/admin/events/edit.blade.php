@extends('layouts.admin')
@php($active = 'events')
@section('title', 'Edit Event')
@section('content')
<div class="section__header"><h1>Edit event</h1></div>
@include('admin.events.form', ['event' => $event, 'action' => route('admin.events.update', $event->eventID), 'method' => 'PUT'])
@endsection
