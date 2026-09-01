{{-- Home Hero component. Static abstract shape (not a flat rectangle, not animated), used on the Home page only. --}}
@props(['eyebrow' => null, 'title', 'subtitle' => null])

<section class="home-hero">
  <div class="home-hero__shape" aria-hidden="true">
    <svg viewBox="0 0 1440 420" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
      <path class="shape-cerulean" d="M0,260 C360,190 620,340 980,270 C1180,232 1320,290 1440,250 L1440,420 L0,420 Z"/>
      <circle class="shape-sky" cx="1240" cy="70" r="230"/>
      <circle class="shape-sky" cx="120" cy="380" r="160"/>
    </svg>
  </div>

  <div class="home-hero__inner">
    @if($eyebrow)
      <span class="home-hero__eyebrow">{{ $eyebrow }}</span>
    @endif
    <h1>{{ $title }}</h1>
    @if($subtitle)
      <p>{{ $subtitle }}</p>
    @endif
    {{ $slot ?? '' }}
  </div>
</section>
