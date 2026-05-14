<footer class="site-footer">
  <div class="container">
    <div class="footer-grid">
      <div>
        <a href="{{ route('home') }}" class="logo"><span class="logo-mark">10</span> Minute <span>School</span></a>
        <p class="footer-about" data-i18n="footer.about">বাংলাদেশের সবচেয়ে বড় অনলাইন শিক্ষাপ্ল্যাটফর্ম।</p>
        <div class="social">
          <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
          <a href="#"><i class="fa-brands fa-youtube"></i></a>
          <a href="#"><i class="fa-brands fa-instagram"></i></a>
          <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
        </div>
      </div>
      <div>
        <h4 data-i18n="footer.company">কোম্পানি</h4>
        <ul>
          <li><a href="{{ route('about-us') }}" data-i18n="nav.about">আমাদের সম্পর্কে</a></li>
          <li><a href="#" data-i18n="footer.career">ক্যারিয়ার</a></li>
          <li><a href="#" data-i18n="footer.partner">পার্টনার</a></li>
          <li><a href="{{ route('contact') }}" data-i18n="nav.contact">যোগাযোগ</a></li>
        </ul>
      </div>
      <div>
        <h4 data-i18n="nav.courses">কোর্স</h4>
        <ul>
          <li><a href="{{ route('shop') }}" data-i18n="nav.academic">একাডেমিক</a></li>
          <li><a href="{{ route('shop') }}" data-i18n="nav.skills">স্কিলস</a></li>
          <li><a href="{{ route('shop') }}" data-i18n="nav.language">ভাষা শিক্ষা</a></li>
          <li><a href="#" data-i18n="nav.pricing">প্রাইসিং</a></li>
        </ul>
      </div>
      <div>
        <h4 data-i18n="footer.support">সাপোর্ট</h4>
        <ul>
          <li><a href="#" data-i18n="footer.help">হেল্প সেন্টার</a></li>
          <li><a href="#" data-i18n="footer.privacy">গোপনীয়তা</a></li>
          <li><a href="#" data-i18n="footer.terms">শর্তাবলী</a></li>
          <li><a href="{{ route('contact') }}">FAQ</a></li>
        </ul>
      </div>
    </div>
    <div class="copy" data-i18n="footer.copy">© {{ date('Y') }} 10 Minute School.</div>
  </div>
</footer>
