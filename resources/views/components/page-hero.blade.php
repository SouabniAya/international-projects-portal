{{-- Page Hero component. Props: title, subtitle, breadcrumb. --}}
@props(['title', 'subtitle' => null, 'breadcrumb' => null])

<section class="page-hero">
  <div class="page-hero__inner">
    @if($breadcrumb)
      <nav class="breadcrumbs" style="color:#CEE6F2;" aria-label="Breadcrumb">{!! $breadcrumb !!}</nav>
    @endif
    <h1>{{ $title }}</h1>
    <span class="page-hero__accent"></span>
    @if($subtitle)
      <p>{{ $subtitle }}</p>
    @endif
    {{ $slot ?? '' }}
  </div>
</section>
