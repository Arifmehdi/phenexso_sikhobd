<footer class="site-footer">
  <div class="container">
    <div class="footer-grid">
      <div>
        <a href="{{ route('home') }}" class="logo">
          <img src="{{ route('imagecache', ['template' => 'original', 'filename' => $ws->logo()]) }}" alt="{{ $ws->name }}" style="max-height: 70px;">
        </a>
        <p class="footer-about" data-i18n="footer.about">QalamHR বাংলাদেশের অন্যতম শীর্ষস্থানীয় ট্রেনিং ইনস্টিটিউট। আমরা দক্ষ ও পেশাদার জনবল তৈরি করি। আমাদের উচ্চমানের কোর্সগুলো আপনার পেশাগত জ্ঞান, দক্ষতা এবং মানসিকতা উন্নত করার জন্য ডিজাইন করা হয়েছে। সব প্রশিক্ষণ প্রোগ্রাম ইন্ডাস্ট্রির অভিজ্ঞ বিশেষজ্ঞদের দ্বারা তৈরি করা হয়।</p>
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
          <li><a href="{{ route('about') }}" data-i18n="nav.about">আমাদের সম্পর্কে</a></li>
          <li><a href="#" data-i18n="footer.career">ক্যারিয়ার</a></li>
          <li><a href="#" data-i18n="footer.partner">পার্টনার</a></li>
          <li><a href="{{ route('contact') }}" data-i18n="nav.contact">যোগাযোগ</a></li>
        </ul>
      </div>
      <div>
        <h4 data-i18n="nav.courses">কোর্স</h4>
        <ul>
          <li><a href="{{ route('courses') }}" data-i18n="nav.academic">একাডেমিক</a></li>
          <li><a href="{{ route('courses') }}" data-i18n="nav.skills">স্কিলস</a></li>
          <li><a href="{{ route('courses') }}" data-i18n="nav.language">ভাষা শিক্ষা</a></li>
          <li><a href="#" data-i18n="nav.pricing">প্রাইসিং</a></li>
        </ul>
      </div>
      <div>
        <h4 data-i18n="footer.support">সাপোর্ট</h4>
        <ul>
          <li><a href="{{ route('wishlist.index') }}">Wishlist</a></li>
          <li><a href="#" data-i18n="footer.help">হেল্প সেন্টার</a></li>
          <li><a href="#" data-i18n="footer.privacy">গোপনীয়তা</a></li>
          <li><a href="#" data-i18n="footer.terms">শর্তাবলী</a></li>
          <li><a href="{{ route('contact') }}">FAQ</a></li>
        </ul>
      </div>
    </div>
    <div class="copy" >
        © {{ date('Y') }} {{ $ws->website_title }}. All Rights Reserved.
        | Developed by
        <a href="https://phenexsoft.com/" target="_blank" rel="noopener noreferrer">
            Phenexsoft IT
        </a>
    </div>
  </div>
</footer>
