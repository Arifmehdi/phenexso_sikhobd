<footer class="site-footer">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <a href="{{ route('home') }}" class="logo">
          <img src="{{ route('imagecache', ['template' => 'original', 'filename' => $ws->logo()]) }}" alt="{{ $ws->website_title ?? 'Qalam HR' }}" style="max-height: 70px;">
        </a>
        <p class="footer-about">{{ __('frontend.footer.about') }}</p>
        <div class="social-links">
          <a href="#" class="social-icon"><i class="fa-brands fa-facebook-f"></i></a>
          <a href="#" class="social-icon"><i class="fa-brands fa-youtube"></i></a>
          <a href="#" class="social-icon"><i class="fa-brands fa-instagram"></i></a>
          <a href="#" class="social-icon"><i class="fa-brands fa-linkedin-in"></i></a>
        </div>
      </div>

      <div class="footer-links-col">
        <h4>{{ __('frontend.footer.additional_links') }}</h4>
        <ul class="footer-list">
          <li><a href="{{ route('about') }}">{{ __('frontend.footer.about_us') }}</a></li>
          <li><a href="{{ route('contact') }}">{{ __('frontend.footer.contact') }}</a></li>
          <li><a href="{{ route('news') }}">{{ __('frontend.footer.blog') }}</a></li>
          <li><a href="#">{{ __('frontend.footer.instructors') }}</a></li>
          <li><a href="#">{{ __('frontend.footer.certificate') }}</a></li>
          <li><a href="#">{{ __('frontend.footer.subscription') }}</a></li>
        </ul>
      </div>

      <div class="footer-links-col double">
        <h4>{{ __('frontend.footer.explore_policy') }}</h4>
        <ul class="footer-list grid-2">
          <li><a href="{{ route('wishlist.index') }}">{{ __('frontend.footer.wishlist') }}</a></li>
          <li><a href="{{ route('home') }}">{{ __('frontend.footer.page') }}</a></li>
          <li><a href="{{ route('shop') }}">{{ __('frontend.footer.store') }}</a></li>
          <li><a href="#">{{ __('frontend.footer.forum') }}</a></li>
          <li><a href="{{ route('courses') }}">{{ __('frontend.footer.courses_link') }}</a></li>
          <li><a href="#">{{ __('frontend.footer.student_success') }}</a></li>
          <li><a href="{{ route('terms') }}">{{ __('frontend.footer.terms') }}</a></li>
          <li><a href="{{ route('return-policy') }}">{{ __('frontend.footer.refund') }}</a></li>
          <li><a href="#">{{ __('frontend.footer.privacy') }}</a></li>
        </ul>
      </div>
    </div>

    <div class="footer-bottom">
      <div class="copy" style="width: 100%; text-align: center;">
        {{ __('frontend.footer.copyright') }} | {{ __('frontend.footer.developed_by') }} <a href="https://phenexsoft.com/" target="_blank">Phenexsoft IT</a>
      </div>
    </div>
  </div>
</footer>

<style>
  .site-footer {
    background: var(--primary-dark);
    color: rgba(255,255,255,0.75);
    padding: 64px 0 24px;
    font-family: 'Hind Siliguri', 'Inter', sans-serif;
  }
  .footer-grid {
    display: grid;
    grid-template-columns: 1.2fr 1fr 1.8fr;
    gap: 40px;
    margin-bottom: 40px;
  }
  .footer-brand .logo { display: block; margin-bottom: 20px; }
  .footer-brand .logo img { filter: brightness(0) invert(1); }
  .footer-about { color: rgba(255,255,255,0.6); line-height: 1.7; font-size: 14px; margin-bottom: 20px; }

  .social-links { display: flex; gap: 10px; }
  .social-icon {
    width: 36px; height: 36px;
    background: rgba(255,255,255,0.1);
    color: #fff;
    display: flex; align-items: center; justify-content: center;
    border-radius: 50%;
    transition: all 0.3s;
    font-size: 14px;
    text-decoration: none;
  }
  .social-icon:hover { background: var(--accent); transform: translateY(-3px); color: #fff; }

  .footer-links-col h4 {
    color: #fff;
    font-size: 16px;
    font-weight: 700;
    margin-bottom: 20px;
    position: relative;
    padding-bottom: 10px;
  }
  .footer-links-col h4::after {
    content: '';
    position: absolute;
    left: 0; bottom: 0;
    width: 24px; height: 2px;
    background: var(--accent);
  }

  .footer-list { list-style: none; padding: 0; margin: 0; }
  .footer-list li { margin-bottom: 10px; }
  .footer-list a {
    color: rgba(255,255,255,0.65);
    text-decoration: none;
    font-size: 14px;
    transition: all 0.3s;
    display: inline-block;
  }
  .footer-list a:hover { color: var(--accent-light); padding-left: 4px; }

  .footer-list.grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0 20px;
  }

  .footer-bottom {
    padding-top: 24px;
    text-align: center;
    color: rgba(255,255,255,0.5);
    font-size: 13px;
  }
  .footer-bottom a { color: rgba(255,255,255,0.7); text-decoration: none; transition: color 0.3s; }
  .footer-bottom a:hover { color: #fff; }

  @media (max-width: 992px) {
    .footer-grid { grid-template-columns: 1fr 1fr; }
    .footer-links-col.double { grid-column: span 2; }
  }
  @media (max-width: 768px) {
    .footer-list:not(.grid-2) {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 0 20px;
    }
    .footer-links-col.double { grid-column: span 1; }
    .footer-grid { grid-template-columns: 1fr; }
  }
  @media (max-width: 576px) {
    .footer-bottom { flex-direction: column; gap: 10px; text-align: center; }
  }
</style>
