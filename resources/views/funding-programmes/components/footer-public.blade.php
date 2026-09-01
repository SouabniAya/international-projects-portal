{{--
    Public Footer component
    Usage: <x-footer-public />
--}}
<footer class="footer-public">
  <div class="footer-public__inner">

    <div class="footer-public__brand">
      <div class="footer-public__brand-top">
        <img src="{{ asset('images/logoEsi.png') }}" alt="ESI logo" width="34" height="34">
        <strong>{{ __('Higher School of Computer Science') }}</strong>
      </div>
      <p class="footer-public__office">{{ __('International Cooperation & Projects Office') }}</p>
      <p class="footer-public__desc">{{ __('Building bridges through international collaboration, research and academic excellence.') }}</p>
      <div class="footer-public__socials">
        <a href="mailto:international@esi.dz" aria-label="{{ __('Email') }}">
          <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="2" y="4" width="20" height="16" rx="2" stroke="#EA4335" stroke-width="2"/><path d="M3 6l9 7 9-7" stroke="#EA4335" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </a>
        <a href="#" aria-label="LinkedIn">
          <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><rect width="24" height="24" rx="4" fill="#0A66C2"/><path d="M7.2 9.5H4.6V19h2.6V9.5ZM5.9 8.3a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3ZM19.4 19h-2.6v-5.1c0-1.2-.4-2-1.5-2-.8 0-1.3.6-1.5 1.1-.1.2-.1.5-.1.8V19h-2.6s.03-8.6 0-9.5h2.6v1.3c.3-.5 1-1.3 2.5-1.3 1.8 0 3.2 1.2 3.2 3.8V19Z" fill="#fff"/></svg>
        </a>
        <a href="#" aria-label="Facebook">
          <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><rect width="24" height="24" rx="4" fill="#1877F2"/><path d="M15.5 8.5h1.5V6h-2c-1.7 0-3 1.3-3 3v1.5H10V13h2v6h2.5v-6H16l.5-2.5h-2v-1c0-.5.4-1 1-1Z" fill="#fff"/></svg>
        </a>
      </div>
    </div>

    <div class="footer-public__col">
      <h4>{{ __('Quick Links') }}</h4>
      <ul>
        <li><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
        <li><a href="{{ url('/cooperation') }}">{{ __('Cooperation') }}</a></li>
        <li><a href="{{ url('/projects') }}">{{ __('Projects') }}</a></li>
        <li><a href="{{ url('/calls') }}">{{ __('Calls') }}</a></li>
        <li><a href="{{ url('/mobility') }}">{{ __('Mobility') }}</a></li>
        <li><a href="{{ url('/testimonials') }}">{{ __('Testimonials') }}</a></li>
      </ul>
    </div>

    <div class="footer-public__col">
      <h4>{{ __('Resources') }}</h4>
      <ul>
        <li><a href="{{ url('/documents') }}">{{ __('Documents') }}</a></li>
        <li><a href="{{ url('/funding-programmes') }}">{{ __('Research Funding Programmes') }}</a></li>
        <li><a href="{{ url('/partnerships') }}">{{ __('Partner Institutions') }}</a></li>
        <li><a href="{{ url('/faq') }}">{{ __('FAQs') }}</a></li>
        <li><a href="{{ url('/help') }}">{{ __('Help') }}</a></li>
      </ul>
    </div>

    <div class="footer-public__col footer-public__contact">
      <h4>{{ __('Contact') }}</h4>
      <p>{{ __('Algiers, Algeria') }}</p>
      <p><a href="mailto:international@esi.dz">international@esi.dz</a></p>
    </div>

  </div>

  <div class="footer-public__bottom">
    <p>&copy; {{ date('Y') }} {{ __("École Supérieure d'Informatique. All rights reserved.") }}</p>
  </div>
</footer>