{{-- Partner Card component. Matches Figma card pattern.
     :logoDomain (optional) — institution's web domain, used to pull a real
     logo via a public logo API. Falls back to initials if it 404s or is
     omitted, since your schema's Partner.logo field isn't populated yet. --}}
@props(['name', 'countryFlag' => '', 'country', 'city', 'tags' => [], 'status' => 'Active', 'href' => '#', 'logoDomain' => null])

<a href="{{ $href }}" class="partner-card">
  <div class="partner-card__top">
    @if($logoDomain)
      <span class="partner-card__logo partner-card__logo--img">
        <img src="https://logo.clearbit.com/{{ $logoDomain }}" alt="{{ $name }} logo"
             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
        <span class="partner-card__logo-fallback">{{ collect(explode(' ', $name))->map(fn($w) => strtoupper($w[0]))->take(2)->implode('') }}</span>
      </span>
    @else
      <span class="partner-card__logo">{{ collect(explode(' ', $name))->map(fn($w) => strtoupper($w[0]))->take(2)->implode('') }}</span>
    @endif
    <span class="partner-card__status">{{ $status }}</span>
  </div>
  <h3 class="partner-card__name">{{ $name }}</h3>
  <p class="partner-card__meta">{{ $countryFlag }} {{ $country }} · {{ $city }}</p>
  @if(count($tags))
    <div class="partner-card__tags">
      @foreach ($tags as $tag)
        <span class="partner-card__tag">{{ $tag }}</span>
      @endforeach
    </div>
  @endif
  <span class="partner-card__link">View profile →</span>
</a>
