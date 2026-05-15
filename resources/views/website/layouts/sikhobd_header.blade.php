<header class="site-header">
  <div class="container header-inner">
    <a href="{{ route('home') }}" class="logo">
      <img src="{{ route('imagecache', ['template' => 'original', 'filename' => $ws->logo_alt()]) }}" alt="{{ $ws->name }}" style="max-height: 40px;">
    </a>

    <nav class="nav-desktop">
      <!-- COURSES — 4 nested levels -->
      <div class="nav-item">
        <a href="{{ route('courses') }}" class="nav-link"><span data-i18n="nav.courses">কোর্সসমূহ</span>
          <svg class="caret" viewBox="0 0 10 10" fill="currentColor"><path d="M1 3l4 4 4-4z"/></svg>
        </a>
        <ul class="dropdown">
          <li class="dropdown-item">
            <a href="#" class="dropdown-link"><span data-i18n="nav.academic">একাডেমিক</span>
              <svg class="arrow" viewBox="0 0 10 10" fill="currentColor"><path d="M3 1l4 4-4 4z"/></svg>
            </a>
            <ul class="dropdown">
              <li><a href="{{ route('courses') }}" class="dropdown-link" data-i18n="nav.class6">ক্লাস ৬-৮</a></li>
              <li><a href="{{ route('courses') }}" class="dropdown-link" data-i18n="nav.class9">ক্লাস ৯-১০ (SSC)</a></li>
              <li><a href="{{ route('courses') }}" class="dropdown-link" data-i18n="nav.class11">ক্লাস ১১-১২ (HSC)</a></li>
              <li class="dropdown-item">
                <a href="#" class="dropdown-link"><span data-i18n="nav.admission">ভর্তি প্রস্তুতি</span>
                  <svg class="arrow" viewBox="0 0 10 10" fill="currentColor"><path d="M3 1l4 4-4 4z"/></svg>
                </a>
                <!-- Level 4 -->
                <ul class="dropdown">
                  <li><a href="{{ route('courses') }}" class="dropdown-link" data-i18n="nav.medical">মেডিকেল</a></li>
                  <li class="dropdown-item">
                    <a href="#" class="dropdown-link"><span data-i18n="nav.engineering">ইঞ্জিনিয়ারিং</span>
                      <svg class="arrow" viewBox="0 0 10 10" fill="currentColor"><path d="M3 1l4 4-4 4z"/></svg>
                    </a>
                    <ul class="dropdown">
                      <li><a href="{{ route('courses') }}" class="dropdown-link" data-i18n="nav.buet">BUET</a></li>
                      <li><a href="{{ route('courses') }}" class="dropdown-link" data-i18n="nav.ku">KUET</a></li>
                      <li><a href="{{ route('courses') }}" class="dropdown-link" data-i18n="nav.cu">CUET</a></li>
                    </ul>
                  </li>
                  <li><a href="{{ route('courses') }}" class="dropdown-link" data-i18n="nav.varsity">ভার্সিটি</a></li>
                </ul>
              </li>
            </ul>
          </li>
          <li class="dropdown-item">
            <a href="#" class="dropdown-link"><span data-i18n="nav.skills">স্কিলস</span>
              <svg class="arrow" viewBox="0 0 10 10" fill="currentColor"><path d="M3 1l4 4-4 4z"/></svg>
            </a>
            <ul class="dropdown">
              <li><a href="{{ route('courses') }}" class="dropdown-link" data-i18n="nav.freelancing">ফ্রিল্যান্সিং</a></li>
              <li><a href="{{ route('courses') }}" class="dropdown-link" data-i18n="nav.design">ডিজাইন</a></li>
              <li class="dropdown-item">
                <a href="#" class="dropdown-link"><span data-i18n="nav.development">ডেভেলপমেন্ট</span>
                  <svg class="arrow" viewBox="0 0 10 10" fill="currentColor"><path d="M3 1l4 4-4 4z"/></svg>
                </a>
                <ul class="dropdown">
                  <li class="dropdown-item">
                    <a href="#" class="dropdown-link"><span data-i18n="nav.web">ওয়েব ডেভেলপমেন্ট</span>
                      <svg class="arrow" viewBox="0 0 10 10" fill="currentColor"><path d="M3 1l4 4-4 4z"/></svg>
                    </a>
                    <ul class="dropdown">
                      <li><a href="{{ route('courses') }}" class="dropdown-link" data-i18n="nav.frontend">ফ্রন্টএন্ড</a></li>
                      <li><a href="{{ route('courses') }}" class="dropdown-link" data-i18n="nav.backend">ব্যাকএন্ড</a></li>
                      <li><a href="{{ route('courses') }}" class="dropdown-link" data-i18n="nav.fullstack">ফুল স্ট্যাক</a></li>
                    </ul>
                  </li>
                  <li><a href="{{ route('courses') }}" class="dropdown-link" data-i18n="nav.mobile">মোবাইল অ্যাপ</a></li>
                </ul>
              </li>
            </ul>
          </li>
          <li class="dropdown-item">
            <a href="#" class="dropdown-link"><span data-i18n="nav.language">ভাষা শিক্ষা</span>
              <svg class="arrow" viewBox="0 0 10 10" fill="currentColor"><path d="M3 1l4 4-4 4z"/></svg>
            </a>
            <ul class="dropdown">
              <li><a href="{{ route('courses') }}" class="dropdown-link" data-i18n="nav.spoken">Spoken English</a></li>
              <li><a href="{{ route('courses') }}" class="dropdown-link" data-i18n="nav.ielts">IELTS</a></li>
              <li><a href="{{ route('courses') }}" class="dropdown-link" data-i18n="nav.arabic">Arabic</a></li>
            </ul>
          </li>
        </ul>
      </div>

      <div class="nav-item">
        <a href="#" class="nav-link"><span data-i18n="nav.study">পড়ালেখা</span>
          <svg class="caret" viewBox="0 0 10 10" fill="currentColor"><path d="M1 3l4 4 4-4z"/></svg>
        </a>
        <ul class="dropdown">
          <li><a href="{{ route('news') }}" class="dropdown-link" data-i18n="nav.blog">ব্লগ</a></li>
          <li><a href="#" class="dropdown-link" data-i18n="nav.notes">ফ্রি নোটস</a></li>
          <li><a href="#" class="dropdown-link" data-i18n="nav.test">মডেল টেস্ট</a></li>
          <li><a href="#" class="dropdown-link" data-i18n="nav.live">লাইভ ক্লাস</a></li>
        </ul>
      </div>

      <div class="nav-item">
        <a href="#" class="nav-link"><span data-i18n="nav.career">দক্ষতা</span>
          <svg class="caret" viewBox="0 0 10 10" fill="currentColor"><path d="M1 3l4 4 4-4z"/></svg>
        </a>
        <ul class="dropdown">
          <li><a href="#" class="dropdown-link" data-i18n="nav.job">জব প্রস্তুতি</a></li>
          <li><a href="#" class="dropdown-link" data-i18n="nav.bcs">BCS প্রিলি</a></li>
          <li><a href="#" class="dropdown-link" data-i18n="nav.bank">ব্যাংক জব</a></li>
        </ul>
      </div>

      <div class="nav-item"><a href="#" class="nav-link" data-i18n="nav.pricing">প্রাইসিং</a></div>
      <div class="nav-item"><a href="{{ route('shop') }}" class="nav-link" data-i18n="nav.shop">Shop</a></div>
    </nav>

    <div class="header-right">
      <div class="lang-switch desktop-only" role="group" aria-label="Language">
        <button data-lang="bn">বাং</button>
        <button data-lang="en">EN</button>
      </div>
      @auth
      <a href="{{ route('user.dashboard') }}" class="icon-btn desktop-only" aria-label="Dashboard"><i class="fa-solid fa-user"></i></a>
      @else
      <a href="{{ route('login') }}" class="btn btn-outline btn-sm desktop-only" data-i18n="nav.login">লগইন</a>
      @endauth
      <a href="#" class="btn btn-primary desktop-only"><i class="fa-solid fa-download"></i> <span data-i18n="nav.download">ডাউনলোড অ্যাপ</span></a>
      <button class="menu-toggle" id="menuToggle" aria-label="Menu"><i class="fa-solid fa-bars"></i></button>
    </div>
  </div>
</header>

<div class="drawer-overlay" id="drawerOverlay"></div>
<aside class="drawer" id="drawer">
  <div class="drawer-head">
    <a href="{{ route('home') }}" class="logo">
      <img src="{{ route('imagecache', ['template' => 'original', 'filename' => $ws->logo_alt()]) }}" alt="{{ $ws->name }}" style="max-height: 40px;">
    </a>
    <button class="icon-btn" id="drawerClose"><i class="fa-solid fa-xmark"></i></button>
  </div>
  <div class="drawer-body">
    <div class="lang-switch" style="margin: 0 8px 12px;">
      <button data-lang="bn">বাংলা</button>
      <button data-lang="en">English</button>
    </div>
    <ul>
      <li class="m-item">
        <button class="m-toggle"><span data-i18n="nav.courses">কোর্সসমূহ</span> <svg class="caret" width="12" height="12" viewBox="0 0 10 10" fill="currentColor"><path d="M1 3l4 4 4-4z"/></svg></button>
        <div class="m-children">
          <div class="m-item">
            <button class="m-toggle"><span data-i18n="nav.academic">একাডেমিক</span> <svg class="caret" width="12" height="12" viewBox="0 0 10 10" fill="currentColor"><path d="M1 3l4 4 4-4z"/></svg></button>
            <div class="m-children">
              <a href="{{ route('courses') }}" class="m-link" data-i18n="nav.class6">ক্লাস ৬-৮</a>
              <a href="{{ route('courses') }}" class="m-link" data-i18n="nav.class9">ক্লাস ৯-১০ (SSC)</a>
              <a href="{{ route('courses') }}" class="m-link" data-i18n="nav.class11">ক্লাস ১১-১২ (HSC)</a>
              <div class="m-item">
                <button class="m-toggle"><span data-i18n="nav.admission">ভর্তি প্রস্তুতি</span> <svg class="caret" width="12" height="12" viewBox="0 0 10 10" fill="currentColor"><path d="M1 3l4 4 4-4z"/></svg></button>
                <div class="m-children">
                  <a href="{{ route('courses') }}" class="m-link" data-i18n="nav.medical">মেডিকেল</a>
                  <div class="m-item">
                    <button class="m-toggle"><span data-i18n="nav.engineering">ইঞ্জিনিয়ারিং</span> <svg class="caret" width="12" height="12" viewBox="0 0 10 10" fill="currentColor"><path d="M1 3l4 4 4-4z"/></svg></button>
                    <div class="m-children">
                      <a href="{{ route('courses') }}" class="m-link" data-i18n="nav.buet">BUET</a>
                      <a href="{{ route('courses') }}" class="m-link" data-i18n="nav.ku">KUET</a>
                      <a href="{{ route('courses') }}" class="m-link" data-i18n="nav.cu">CUET</a>
                    </div>
                  </div>
                  <a href="{{ route('courses') }}" class="m-link" data-i18n="nav.varsity">ভার্সিটি</a>
                </div>
              </div>
            </div>
          </div>
          <div class="m-item">
            <button class="m-toggle"><span data-i18n="nav.skills">স্কিলস</span> <svg class="caret" width="12" height="12" viewBox="0 0 10 10" fill="currentColor"><path d="M1 3l4 4 4-4z"/></svg></button>
            <div class="m-children">
              <a href="{{ route('courses') }}" class="m-link" data-i18n="nav.freelancing">ফ্রিল্যান্সিং</a>
              <a href="{{ route('courses') }}" class="m-link" data-i18n="nav.design">ডিজাইন</a>
              <div class="m-item">
                <button class="m-toggle"><span data-i18n="nav.development">ডেভেলপমেন্ট</span> <svg class="caret" width="12" height="12" viewBox="0 0 10 10" fill="currentColor"><path d="M1 3l4 4 4-4z"/></svg></button>
                <div class="m-children">
                  <a href="{{ route('courses') }}" class="m-link" data-i18n="nav.web">ওয়েব ডেভেলপমেন্ট</a>
                  <a href="{{ route('courses') }}" class="m-link" data-i18n="nav.mobile">মোবাইল অ্যাপ</a>
                </div>
              </div>
            </div>
          </div>
          <a href="{{ route('courses') }}" class="m-link" data-i18n="nav.language">ভাষা শিক্ষা</a>
        </div>
      </li>
      <li class="m-item">
        <button class="m-toggle"><span data-i18n="nav.study">পড়ালেখা</span> <svg class="caret" width="12" height="12" viewBox="0 0 10 10" fill="currentColor"><path d="M1 3l4 4 4-4z"/></svg></button>
        <div class="m-children">
          <a href="{{ route('news') }}" class="m-link" data-i18n="nav.blog">ব্লগ</a>
          <a href="#" class="m-link" data-i18n="nav.notes">ফ্রি নোটস</a>
          <a href="#" class="m-link" data-i18n="nav.test">মডেল টেস্ট</a>
        </div>
      </li>
      <li class="m-item"><a href="#" class="m-link" data-i18n="nav.pricing">প্রাইসিং</a></li>
      <li class="m-item"><a href="{{ route('user.dashboard') }}" class="m-link" data-i18n="nav.dashboard">ড্যাশবোর্ড</a></li>
      <li class="m-item"><a href="{{ route('about') }}" class="m-link" data-i18n="nav.about">আমাদের সম্পর্কে</a></li>
      <li class="m-item"><a href="{{ route('contact') }}" class="m-link" data-i18n="nav.contact">যোগাযোগ</a></li>
    </ul>
  </div>
  <div class="drawer-footer">
    @auth
    <a href="{{ route('user.dashboard') }}" class="btn btn-outline" data-i18n="nav.dashboard">ড্যাশবোর্ড</a>
    @else
    <a href="{{ route('login') }}" class="btn btn-outline" data-i18n="nav.login">লগইন</a>
    @endauth
    <a href="#" class="btn btn-primary"><i class="fa-solid fa-download"></i> <span data-i18n="nav.download">ডাউনলোড অ্যাপ</span></a>
  </div>
</aside>
