{{-- resources/views/faq.blade.php — FR-9.3 --}}
@extends('layouts.app')

@section('title', 'FAQ')

@section('content')

<x-page-hero
    :title="__('pages.faq.title')"
    :subtitle="__('pages.faq.subtitle')"
    breadcrumb="<a href='{{ url('/') }}'>{{ __('nav.home') }}</a> / FAQ">
</x-page-hero>

<div class="page-hero__toolbar">
    <div class="filter-bar" data-filter-scope="#faqList" style="max-width:820px; margin:0 auto;">
        <div class="filter-bar__search" style="flex:1;">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            <input type="search" placeholder="Search a question or topic..." data-filter-search>
        </div>
    </div>
</div>

<section class="section" style="max-width:820px;">
    <div id="faqList">
        @foreach ([
            ['q' => 'How do I apply for a mobility opportunity?', 'a' => 'Browse the Mobility page, select an opportunity matching your profile, and follow the application link before the listed deadline.'],
            ['q' => 'Can my institution become a partner of ESI?', 'a' => 'Yes — use the "Become a Partner" form to submit your institution\'s details. The International Relations Office will follow up within two weeks.'],
            ['q' => 'Where can I find current calls for proposals?', 'a' => 'All open and upcoming calls are listed on the Calls for Proposals page, with filters by programme and thematic area.'],
            ['q' => 'What documents do I need for an outgoing exchange?', 'a' => 'Typically a learning agreement, transcript of records, and a motivation letter. Exact requirements vary by programme — check the specific mobility listing.'],
            ['q' => 'Who do I contact for partnership agreements?', 'a' => 'Reach out through the Contact page and select "Partnership Agreement" as the subject — your message will be routed to the right staff member.'],
            ['q' => 'How long does mobility application review take?', 'a' => 'Most applications are reviewed within two to three weeks of the deadline. You will be notified by email either way.'],
            ['q' => 'Can I apply for more than one mobility opportunity at a time?', 'a' => 'Yes, but you can only be selected for one active mobility per academic year unless stated otherwise in the call.'],
        ] as $i => $item)
        <details data-filter-item style="border-bottom:1px solid var(--color-neutral-300); padding:18px 0;" @if($i === 0) open @endif>
            <summary style="cursor:pointer; font-family:var(--font-body); font-weight:600; font-size:15.5px; color:var(--color-ink-black); list-style:none;">
                {{ $item['q'] }}
            </summary>
            <p style="font-family:var(--font-body); font-size:14.5px; line-height:1.6; color:var(--color-neutral-500); margin:12px 0 0;">
                {{ $item['a'] }}
            </p>
        </details>
        @endforeach
    </div>
    <p data-empty-state style="display:none; text-align:center; padding:32px; color:var(--color-neutral-500); font-family:var(--font-body);">No questions match your search.</p>
</section>

@endsection
