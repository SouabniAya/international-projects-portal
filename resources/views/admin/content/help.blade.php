@extends('layouts.admin')

@section('title', __('Admin Help'))

@php($active = 'help')

@section('content')
<div class="section__header" style="margin-bottom:24px;">
    <h2 style="margin:0;">{{ __('Admin Help') }}</h2>
    <p style="margin:6px 0 0;">{{ __('Quick guidance for managing the International Projects Portal.') }}</p>
</div>

<div class="grid" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:16px;">
    <section class="panel">
        <h3>{{ __('Content management') }}</h3>
        <p>{{ __('Use Cooperation to manage portal content. Projects, calls, mobility, partners, agreements and funding programmes have dedicated management pages.') }}</p>
    </section>
    <section class="panel">
        <h3>{{ __('Publication workflow') }}</h3>
        <p>{{ __('Content can be saved as draft, scheduled, published or archived where the underlying module supports those states.') }}</p>
    </section>
    <section class="panel">
        <h3>{{ __('Users & permissions') }}</h3>
        <p>{{ __('Super administrators manage users, roles and platform settings. Functional administrators focus on operational content.') }}</p>
    </section>
    <section class="panel">
        <h3>{{ __('Need assistance?') }}</h3>
        <p>{{ __('For portal or International Relations Office questions, use the public Contact page.') }}</p>
        <a class="btn btn--outline btn--sm" href="{{ url('/contact') }}">{{ __('Contact the office') }}</a>
    </section>
</div>
@endsection
