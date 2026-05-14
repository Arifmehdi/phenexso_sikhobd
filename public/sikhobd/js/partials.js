/* Shared header & footer partials — injected on page load.
   Add <div data-include="header"></div> and <div data-include="footer"></div>
   on each page. Then load /js/partials.js BEFORE /js/main.js. */

const HEADER_HTML = `
<header class="site-header">
  <div class="container header-inner">
    <a href="index.html" class="logo">
      <span class="logo-mark">10</span>
      Minute <span>School</span>
    </a>

    <nav class="nav-desktop">
      <!-- COURSES — 4 nested levels -->
      <div class="nav-item">
        <a href="courses.html" class="nav-link"><span data-i18n="nav.courses">কোর্সসমূহ</span>
          <svg class="caret" viewBox="0 0 10 10" fill="currentColor"><path d="M1 3l4 4 4-4z"/></svg>
        </a>
        <ul class="dropdown">
          <li class="dropdown-item">
            <a href="#" class="dropdown-link"><span data-i18n="nav.academic">একাডেমিক</span>
              <svg class="arrow" viewBox="0 0 10 10" fill="currentColor"><path d="M3 1l4 4-4 4z"/></svg>
            </a>
            <ul class="dropdown">
              <li><a href="courses.html" class="dropdown-link" data-i18n="nav.class6">ক্লাস ৬-৮</a></li>
              <li><a href="courses.html" class="dropdown-link" data-i18n="nav.class9">ক্লাস ৯-১০ (SSC)</a></li>
              <li><a href="courses.html" class="dropdown-link" data-i18n="nav.class11">ক্লাস ১১-১২ (HSC)</a></li>
              <li class="dropdown-item">
                <a href="#" class="dropdown-link"><span data-i18n="nav.admission">ভর্তি প্রস্তুতি</span>
                  <svg class="arrow" viewBox="0 0 10 10" fill="currentColor"><path d="M3 1l4 4-4 4z"/></svg>
                </a>
                <!-- Level 4 -->
                <ul class="dropdown">
                  <li><a href="courses.html" class="dropdown-link" data-i18n="nav.medical">মেডিকেল</a></li>
                  <li class="dropdown-item">
                    <a href="#" class="dropdown-link"><span data-i18n="nav.engineering">ইঞ্জিনিয়ারিং</span>
                      <svg class="arrow" viewBox="0 0 10 10" fill="currentColor"><path d="M3 1l4 4-4 4z"/></svg>
                    </a>
                    <ul class="dropdown">
                      <li><a href="courses.html" class="dropdown-link" data-i18n="nav.buet">BUET</a></li>
                      <li><a href="courses.html" class="dropdown-link" data-i18n="nav.ku">KUET</a></li>
                      <li><a href="courses.html" class="dropdown-link" data-i18n="nav.cu">CUET</a></li>
                    </ul>
                  </li>
                  <li><a href="courses.html" class="dropdown-link" data-i18n="nav.varsity">ভার্সিটি</a></li>
                </ul>
              </li>
            </ul>
          </li>
          <li class="dropdown-item">
            <a href="#" class="dropdown-link"><span data-i18n="nav.skills">স্কিলস</span>
              <svg class="arrow" viewBox="0 0 10 10" fill="currentColor"><path d="M3 1l4 4-4 4z"/></svg>
            </a>
            <ul class="dropdown">
              <li><a href="courses.html" class="dropdown-link" data-i18n="nav.freelancing">ফ্রিল্যান্সিং</a></li>
              <li><a href="courses.html" class="dropdown-link" data-i18n="nav.design">ডিজাইন</a></li>
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
                      <li><a href="course-detail.html" class="dropdown-link" data-i18n="nav.frontend">ফ্রন্টএন্ড</a></li>
                      <li><a href="course-detail.html" class="dropdown-link" data-i18n="nav.backend">ব্যাকএন্ড</a></li>
                      <li><a href="course-detail.html" class="dropdown-link" data-i18n="nav.fullstack">ফুল স্ট্যাক</a></li>
                    </ul>
                  </li>
                  <li><a href="courses.html" class="dropdown-link" data-i18n="nav.mobile">মোবাইল অ্যাপ</a></li>
                </ul>
              </li>
            </ul>
          </li>
          <li class="dropdown-item">
            <a href="#" class="dropdown-link"><span data-i18n="nav.language">ভাষা শিক্ষা</span>
              <svg class="arrow" viewBox="0 0 10 10" fill="currentColor"><path d="M3 1l4 4-4 4z"/></svg>
            </a>
            <ul class="dropdown">
              <li><a href="courses.html" class="dropdown-link" data-i18n="nav.spoken">Spoken English</a></li>
              <li><a href="courses.html" class="dropdown-link" data-i18n="nav.ielts">IELTS</a></li>
              <li><a href="courses.html" class="dropdown-link" data-i18n="nav.arabic">Arabic</a></li>
            </ul>
          </li>
        </ul>
      </div>

      <div class="nav-item">
        <a href="#" class="nav-link"><span data-i18n="nav.study">পড়ালেখা</span>
          <svg class="caret" viewBox="0 0 10 10" fill="currentColor"><path d="M1 3l4 4 4-4z"/></svg>
        </a>
        <ul class="dropdown">
          <li><a href="blog.html" class="dropdown-link" data-i18n="nav.blog">ব্লগ</a></li>
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

      <div class="nav-item"><a href="pricing.html" class="nav-link" data-i18n="nav.pricing">প্রাইসিং</a></div>
      <div class="nav-item"><a href="about.html" class="nav-link" data-i18n="nav.about">আমাদের সম্পর্কে</a></div>
      <div class="nav-item"><a href="contact.html" class="nav-link" data-i18n="nav.contact">যোগাযোগ</a></div>
    </nav>

    <div class="header-right">
      <div class="lang-switch desktop-only" role="group" aria-label="Language">
        <button data-lang="bn">বাং</button>
        <button data-lang="en">EN</button>
      </div>
      <a href="dashboard.html" class="icon-btn desktop-only" aria-label="Dashboard"><i class="fa-solid fa-user"></i></a>
      <a href="login.html" class="btn btn-outline btn-sm desktop-only" data-i18n="nav.login">লগইন</a>
      <a href="#" class="btn btn-primary desktop-only"><i class="fa-solid fa-download"></i> <span data-i18n="nav.download">ডাউনলোড অ্যাপ</span></a>
      <button class="menu-toggle" id="menuToggle" aria-label="Menu"><i class="fa-solid fa-bars"></i></button>
    </div>
  </div>
</header>

<div class="drawer-overlay" id="drawerOverlay"></div>
<aside class="drawer" id="drawer">
  <div class="drawer-head">
    <a href="index.html" class="logo"><span class="logo-mark">10</span> Minute <span>School</span></a>
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
              <a href="courses.html" class="m-link" data-i18n="nav.class6">ক্লাস ৬-৮</a>
              <a href="courses.html" class="m-link" data-i18n="nav.class9">ক্লাস ৯-১০ (SSC)</a>
              <a href="courses.html" class="m-link" data-i18n="nav.class11">ক্লাস ১১-১২ (HSC)</a>
              <div class="m-item">
                <button class="m-toggle"><span data-i18n="nav.admission">ভর্তি প্রস্তুতি</span> <svg class="caret" width="12" height="12" viewBox="0 0 10 10" fill="currentColor"><path d="M1 3l4 4 4-4z"/></svg></button>
                <div class="m-children">
                  <a href="courses.html" class="m-link" data-i18n="nav.medical">মেডিকেল</a>
                  <div class="m-item">
                    <button class="m-toggle"><span data-i18n="nav.engineering">ইঞ্জিনিয়ারিং</span> <svg class="caret" width="12" height="12" viewBox="0 0 10 10" fill="currentColor"><path d="M1 3l4 4 4-4z"/></svg></button>
                    <div class="m-children">
                      <a href="courses.html" class="m-link" data-i18n="nav.buet">BUET</a>
                      <a href="courses.html" class="m-link" data-i18n="nav.ku">KUET</a>
                      <a href="courses.html" class="m-link" data-i18n="nav.cu">CUET</a>
                    </div>
                  </div>
                  <a href="courses.html" class="m-link" data-i18n="nav.varsity">ভার্সিটি</a>
                </div>
              </div>
            </div>
          </div>
          <div class="m-item">
            <button class="m-toggle"><span data-i18n="nav.skills">স্কিলস</span> <svg class="caret" width="12" height="12" viewBox="0 0 10 10" fill="currentColor"><path d="M1 3l4 4 4-4z"/></svg></button>
            <div class="m-children">
              <a href="courses.html" class="m-link" data-i18n="nav.freelancing">ফ্রিল্যান্সিং</a>
              <a href="courses.html" class="m-link" data-i18n="nav.design">ডিজাইন</a>
              <div class="m-item">
                <button class="m-toggle"><span data-i18n="nav.development">ডেভেলপমেন্ট</span> <svg class="caret" width="12" height="12" viewBox="0 0 10 10" fill="currentColor"><path d="M1 3l4 4 4-4z"/></svg></button>
                <div class="m-children">
                  <a href="courses.html" class="m-link" data-i18n="nav.web">ওয়েব ডেভেলপমেন্ট</a>
                  <a href="courses.html" class="m-link" data-i18n="nav.mobile">মোবাইল অ্যাপ</a>
                </div>
              </div>
            </div>
          </div>
          <a href="courses.html" class="m-link" data-i18n="nav.language">ভাষা শিক্ষা</a>
        </div>
      </li>
      <li class="m-item">
        <button class="m-toggle"><span data-i18n="nav.study">পড়ালেখা</span> <svg class="caret" width="12" height="12" viewBox="0 0 10 10" fill="currentColor"><path d="M1 3l4 4 4-4z"/></svg></button>
        <div class="m-children">
          <a href="blog.html" class="m-link" data-i18n="nav.blog">ব্লগ</a>
          <a href="#" class="m-link" data-i18n="nav.notes">ফ্রি নোটস</a>
          <a href="#" class="m-link" data-i18n="nav.test">মডেল টেস্ট</a>
        </div>
      </li>
      <li class="m-item"><a href="pricing.html" class="m-link" data-i18n="nav.pricing">প্রাইসিং</a></li>
      <li class="m-item"><a href="dashboard.html" class="m-link" data-i18n="nav.dashboard">ড্যাশবোর্ড</a></li>
      <li class="m-item"><a href="about.html" class="m-link" data-i18n="nav.about">আমাদের সম্পর্কে</a></li>
      <li class="m-item"><a href="contact.html" class="m-link" data-i18n="nav.contact">যোগাযোগ</a></li>
    </ul>
  </div>
  <div class="drawer-footer">
    <a href="login.html" class="btn btn-outline" data-i18n="nav.login">লগইন</a>
    <a href="#" class="btn btn-primary"><i class="fa-solid fa-download"></i> <span data-i18n="nav.download">ডাউনলোড অ্যাপ</span></a>
  </div>
</aside>
`;

const FOOTER_HTML = `
<footer class="site-footer">
  <div class="container">
    <div class="footer-grid">
      <div>
        <a href="index.html" class="logo"><span class="logo-mark">10</span> Minute <span>School</span></a>
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
          <li><a href="about.html" data-i18n="nav.about">আমাদের সম্পর্কে</a></li>
          <li><a href="#" data-i18n="footer.career">ক্যারিয়ার</a></li>
          <li><a href="#" data-i18n="footer.partner">পার্টনার</a></li>
          <li><a href="contact.html" data-i18n="nav.contact">যোগাযোগ</a></li>
        </ul>
      </div>
      <div>
        <h4 data-i18n="nav.courses">কোর্স</h4>
        <ul>
          <li><a href="courses.html" data-i18n="nav.academic">একাডেমিক</a></li>
          <li><a href="courses.html" data-i18n="nav.skills">স্কিলস</a></li>
          <li><a href="courses.html" data-i18n="nav.language">ভাষা শিক্ষা</a></li>
          <li><a href="pricing.html" data-i18n="nav.pricing">প্রাইসিং</a></li>
        </ul>
      </div>
      <div>
        <h4 data-i18n="footer.support">সাপোর্ট</h4>
        <ul>
          <li><a href="#" data-i18n="footer.help">হেল্প সেন্টার</a></li>
          <li><a href="#" data-i18n="footer.privacy">গোপনীয়তা</a></li>
          <li><a href="#" data-i18n="footer.terms">শর্তাবলী</a></li>
          <li><a href="contact.html">FAQ</a></li>
        </ul>
      </div>
    </div>
    <div class="copy" data-i18n="footer.copy">© 2025 10 Minute School.</div>
  </div>
</footer>
`;

document.querySelectorAll('[data-include="header"]').forEach((el) => { el.outerHTML = HEADER_HTML; });
document.querySelectorAll('[data-include="footer"]').forEach((el) => { el.outerHTML = FOOTER_HTML; });
