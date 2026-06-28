<header class="site-header">
  <div class="container sh-inner">

    {{-- ① Hamburger — mobile only, always FIRST (leftmost) --}}
    <button class="sh-icon-btn sh-burger sh-mob" id="menuToggle" aria-label="Open menu">
      <i class="fa-solid fa-bars"></i>
    </button>

    {{-- ② Logo --}}
    <a href="{{ route('home') }}" class="sh-logo">
      <img src="{{ route('imagecache', ['template' => 'original', 'filename' => $ws->logo_alt()]) }}"
           alt="{{ $ws->website_title ?? '' }}">
    </a>

    {{-- ③ Desktop search bar (hidden on mobile) --}}
    <div class="sh-search-wrap" id="headerSearchWrap">
      <div class="sh-search-box">
        <i class="fa-solid fa-magnifying-glass sh-search-ico"></i>
        <input type="text" id="headerSearchInput" class="sh-search-inp"
          placeholder="{{ __('frontend.nav.search') }}"
          autocomplete="off" spellcheck="false">
        <button class="sh-search-clr" id="headerSearchClear" style="display:none" aria-label="Clear">
          <i class="fa-solid fa-xmark"></i>
        </button>
        <button class="sh-search-go" id="headerSearchSubmit" type="button" aria-label="Search">
          <i class="fa-solid fa-magnifying-glass"></i>
        </button>
      </div>
      <div class="sh-search-drop" id="headerSearchDropdown"></div>
    </div>

    {{-- ④ Right side actions --}}
    <div class="sh-right">

      {{-- Desktop: Language pill --}}
      <div class="lang-switch sh-lang-pill sh-dsk" role="group" aria-label="Language">
        <button data-lang="bn">বাং</button>
        <button data-lang="en">EN</button>
      </div>

      {{-- Desktop: User dropdown --}}
      @auth
      <div class="nav-item user-dropdown sh-user sh-dsk">
        <button class="sh-icon-btn" aria-label="My account">
          <i class="fa-solid fa-circle-user"></i>
        </button>
        <ul class="dropdown">
          @if(auth()->user()->hasRole('admin') || auth()->user()->role == 'admin')
            <li><a href="{{ route('admin.dashboard') }}" class="dropdown-link"><i class="fa-solid fa-gauge-high me-2"></i> Admin Panel</a></li>
          @endif
          <li><a href="{{ route('user.dashboard') }}" class="dropdown-link"><i class="fa-solid fa-user me-2"></i> Dashboard</a></li>
          <li><a href="{{ route('exams.index') }}" class="dropdown-link"><i class="fa-solid fa-file-pen me-2"></i> My Exams</a></li>
          <li><a href="{{ route('logout') }}" class="dropdown-link text-danger"><i class="fa-solid fa-right-from-bracket me-2"></i> Logout</a></li>
        </ul>
      </div>
      @endauth

      {{-- Desktop: Login pill --}}
      @guest
        <a href="{{ route('login') }}" class="sh-login-btn sh-dsk" data-i18n="nav.login">লগইন</a>
      @endguest

      {{-- Mobile: Search icon --}}
      <button class="sh-icon-btn sh-mob" id="searchToggle" aria-label="Search">
        <i class="fa-solid fa-magnifying-glass"></i>
      </button>

      {{-- Mobile: Login icon (guest) / User icon (auth) --}}
      @auth
      <div class="nav-item user-dropdown sh-user sh-mob">
        <button class="sh-icon-btn" aria-label="My account">
          <i class="fa-solid fa-circle-user"></i>
        </button>
        <ul class="dropdown sh-mob-dd">
          @if(auth()->user()->hasRole('admin') || auth()->user()->role == 'admin')
            <li><a href="{{ route('admin.dashboard') }}" class="dropdown-link"><i class="fa-solid fa-gauge-high me-2"></i> Admin</a></li>
          @endif
          <li><a href="{{ route('user.dashboard') }}" class="dropdown-link"><i class="fa-solid fa-user me-2"></i> Dashboard</a></li>
          <li><a href="{{ route('logout') }}" class="dropdown-link text-danger"><i class="fa-solid fa-right-from-bracket me-2"></i> Logout</a></li>
        </ul>
      </div>
      @endauth
      @guest
        <a href="{{ route('login') }}" class="sh-icon-btn sh-mob" aria-label="Login">
          <i class="fa-solid fa-right-to-bracket"></i>
        </a>
      @endguest

      {{-- Mobile: Language (globe icon + dropdown) --}}
      <div class="sh-globe-wrap sh-mob" id="langMobileWrap">
        <button class="sh-icon-btn" id="langMobileBtn" aria-label="Language">
          <i class="fa-solid fa-globe"></i>
        </button>
        <div class="sh-globe-drop" id="langMobileDrop">
          <a class="sh-globe-opt {{ app()->getLocale() == 'bn' ? 'is-active' : '' }}"
             href="{{ route('welcome.changeLanguage', ['lang' => 'bn']) }}">
            <i class="fa-solid fa-check sh-globe-chk"></i> বাংলা
          </a>
          <a class="sh-globe-opt {{ app()->getLocale() == 'en' ? 'is-active' : '' }}"
             href="{{ route('welcome.changeLanguage', ['lang' => 'en']) }}">
            <i class="fa-solid fa-check sh-globe-chk"></i> English
          </a>
        </div>
      </div>

    </div>{{-- end .sh-right --}}
  </div>
</header>

{{-- ── Desktop navigation bar (hidden on mobile) ── --}}
<div class="header-bottom">
  <div class="container nav-center">
    <nav class="nav-desktop">

      {{-- Category dropdowns --}}
      @foreach($hierarchicalCategories as $cat)
        <div class="nav-item">
          <a href="{{ route('courses', ['category' => $cat->slug]) }}" class="nav-link">
            <span>{{ app()->getLocale() == 'bn' ? $cat->name_bn : $cat->name_en }}</span>
            @if($cat->children->count() > 0)
              <svg class="caret" viewBox="0 0 10 10" fill="currentColor"><path d="M1 3l4 4 4-4z"/></svg>
            @endif
          </a>
          @if($cat->children->count() > 0)
            <ul class="dropdown">
              @foreach($cat->children as $sub)
                <li class="dropdown-item">
                  <a href="{{ route('courses', ['category' => $sub->slug]) }}" class="dropdown-link">
                    <span>{{ app()->getLocale() == 'bn' ? $sub->name_bn : $sub->name_en }}</span>
                    @if($sub->children->count() > 0)
                      <svg class="arrow" viewBox="0 0 10 10" fill="currentColor"><path d="M3 1l4 4-4 4z"/></svg>
                    @endif
                  </a>
                  @if($sub->children->count() > 0)
                    <ul class="dropdown">
                      @foreach($sub->children as $child)
                        <li>
                          <a href="{{ route('courses', ['category' => $child->slug]) }}" class="dropdown-link">
                            {{ app()->getLocale() == 'bn' ? $child->name_bn : $child->name_en }}
                          </a>
                        </li>
                      @endforeach
                    </ul>
                  @endif
                </li>
              @endforeach
            </ul>
          @endif
        </div>
      @endforeach

      {{-- Exam --}}
      <div class="nav-item">
        <a href="{{ route('exams.index') }}" class="nav-link">
          <span>{{ __('frontend.nav.exam') }}</span>
          @if($headerExams->count() > 0)
            <svg class="caret" viewBox="0 0 10 10" fill="currentColor"><path d="M1 3l4 4 4-4z"/></svg>
          @endif
        </a>
        @if($headerExams->count() > 0)
          <ul class="dropdown">
            @foreach($headerExams as $exam)
              <li class="dropdown-item">
                <a href="{{ route('exams.start', $exam->id) }}" class="dropdown-link">
                  <span>{{ $exam->title }}</span>
                </a>
              </li>
            @endforeach
            <li class="dropdown-item border-top">
              <a href="{{ route('exams.index') }}" class="dropdown-link text-primary font-weight-bold">
                <span>{{ app()->getLocale() == 'bn' ? 'সব পরীক্ষা দেখুন' : 'See All Exams' }}</span>
              </a>
            </li>
          </ul>
        @endif
      </div>

      {{-- E-book --}}
      <div class="nav-item">
        <a href="{{ route('ebooks.index') }}" class="nav-link">
          <span>{{ __('frontend.nav.ebook') }}</span>
          <svg class="caret" viewBox="0 0 10 10" fill="currentColor"><path d="M1 3l4 4 4-4z"/></svg>
        </a>
        <ul class="dropdown">
          <li class="dropdown-item">
            <a href="{{ route('ebooks.index') }}" class="dropdown-link">
              <span>{{ __('frontend.nav.all_ebooks') }}</span>
            </a>
          </li>
          <li class="dropdown-item">
            <a href="{{ route('free.ebooks') }}" class="dropdown-link">
              <span>{{ __('frontend.nav.free_ebooks') }}</span>
            </a>
          </li>
        </ul>
      </div>

      {{-- Shop --}}
      <div class="nav-item">
        <a href="{{ route('shop') }}" class="nav-link">
          {{ app()->getLocale() == 'bn' ? 'শপ' : 'Shop' }}
        </a>
      </div>

    </nav>
  </div>
</div>

{{-- Search Drawer backdrop --}}
<div class="search-drawer-backdrop" id="searchDrawerBackdrop"></div>

{{-- Search Drawer (slides right ← left) --}}
<aside class="search-drawer" id="searchDrawer" role="dialog" aria-modal="true" aria-label="Search">
  <div class="sd-head">
    <div class="sd-title"><i class="fa-solid fa-magnifying-glass me-2"></i>{{ __('frontend.nav.search_drawer') }}</div>
    <button class="sh-icon-btn" id="searchDrawerClose" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
  </div>
  <div class="sd-input-wrap">
    <i class="fa-solid fa-magnifying-glass sd-search-icon"></i>
    <input type="text" id="searchDrawerInput" class="sd-input"
      placeholder="{{ __('frontend.nav.type_to_search') }}"
      autocomplete="off" spellcheck="false">
    <button class="sd-clear" id="searchDrawerClear" style="display:none" aria-label="Clear"><i class="fa-solid fa-xmark"></i></button>
  </div>
  <div id="searchDrawerResults" class="sd-results"></div>
  <div class="sd-footer">
    <a href="{{ route('search') }}" class="sd-view-all" id="searchDrawerViewAll" style="display:none;">
      {{ app()->getLocale() == 'bn' ? 'সব ফলাফল দেখুন' : 'View all results' }}
      <i class="fa-solid fa-arrow-right ms-2"></i>
    </a>
  </div>
</aside>

{{-- Nav Drawer overlay + drawer --}}
<div class="drawer-overlay" id="drawerOverlay"></div>
<aside class="drawer" id="drawer">
  <div class="drawer-head">
    <a href="{{ route('home') }}" class="sh-logo">
      <img src="{{ route('imagecache', ['template' => 'original', 'filename' => $ws->logo_alt()]) }}"
           alt="{{ $ws->website_title ?? '' }}" style="max-height:36px;">
    </a>
    <button class="sh-icon-btn" id="drawerClose" aria-label="Close menu"><i class="fa-solid fa-xmark"></i></button>
  </div>

  <div class="drawer-body">

    <ul>
      @auth
        <li class="m-item">
          <button class="m-toggle">
            <i class="fa-solid fa-circle-user me-2"></i>
            <span>{{ auth()->user()->name }}</span>
            <svg class="caret" width="12" height="12" viewBox="0 0 10 10" fill="currentColor"><path d="M1 3l4 4 4-4z"/></svg>
          </button>
          <div class="m-children">
            @if(auth()->user()->role == 'admin')
              <a href="{{ route('admin.dashboard') }}" class="m-link"><i class="fa-solid fa-gauge-high me-2"></i> Admin Panel</a>
            @endif
            <a href="{{ route('user.dashboard') }}" class="m-link"><i class="fa-solid fa-user me-2"></i> Dashboard</a>
            <a href="{{ route('exams.index') }}" class="m-link"><i class="fa-solid fa-file-pen me-2"></i> My Exams</a>
            <a href="{{ route('logout') }}" class="m-link text-danger"><i class="fa-solid fa-right-from-bracket me-2"></i> Logout</a>
          </div>
        </li>
      @endauth

      <li class="m-item">
        @if($headerExams->count() > 0)
          <button class="m-toggle">
            <i class="fa-solid fa-file-pen me-2"></i>
            <span>{{ __('frontend.nav.exam') }}</span>
            <svg class="caret" width="12" height="12" viewBox="0 0 10 10" fill="currentColor"><path d="M1 3l4 4 4-4z"/></svg>
          </button>
          <div class="m-children">
            @foreach($headerExams as $exam)
              <a href="{{ route('exams.start', $exam->id) }}" class="m-link">{{ $exam->title }}</a>
            @endforeach
            <a href="{{ route('exams.index') }}" class="m-link text-primary">{{ __('frontend.nav.see_all') }}</a>
          </div>
        @else
          <a href="{{ route('exams.index') }}" class="m-link"><i class="fa-solid fa-file-pen me-2"></i> {{ __('frontend.nav.exam') }}</a>
        @endif
      </li>

      @foreach($hierarchicalCategories as $cat)
        <li class="m-item">
          @if($cat->children->count() > 0)
            <button class="m-toggle">
              <span>{{ app()->getLocale() == 'bn' ? $cat->name_bn : $cat->name_en }}</span>
              <svg class="caret" width="12" height="12" viewBox="0 0 10 10" fill="currentColor"><path d="M1 3l4 4 4-4z"/></svg>
            </button>
            <div class="m-children">
              @foreach($cat->children as $sub)
                @if($sub->children->count() > 0)
                  <div class="m-item">
                    <button class="m-toggle">
                      <span>{{ app()->getLocale() == 'bn' ? $sub->name_bn : $sub->name_en }}</span>
                      <svg class="caret" width="12" height="12" viewBox="0 0 10 10" fill="currentColor"><path d="M1 3l4 4 4-4z"/></svg>
                    </button>
                    <div class="m-children">
                      @foreach($sub->children as $child)
                        <a href="{{ route('courses', ['category' => $child->slug]) }}" class="m-link">{{ app()->getLocale() == 'bn' ? $child->name_bn : $child->name_en }}</a>
                      @endforeach
                    </div>
                  </div>
                @else
                  <a href="{{ route('courses', ['category' => $sub->slug]) }}" class="m-link">{{ app()->getLocale() == 'bn' ? $sub->name_bn : $sub->name_en }}</a>
                @endif
              @endforeach
            </div>
          @else
            <a href="{{ route('courses', ['category' => $cat->slug]) }}" class="m-link">{{ app()->getLocale() == 'bn' ? $cat->name_bn : $cat->name_en }}</a>
          @endif
        </li>
      @endforeach

      <li class="m-item">
        <button class="m-toggle">
          <span>{{ __('frontend.nav.ebook') }}</span>
          <svg class="caret" width="12" height="12" viewBox="0 0 10 10" fill="currentColor"><path d="M1 3l4 4 4-4z"/></svg>
        </button>
        <div class="m-children">
          <a href="{{ route('ebooks.index') }}" class="m-link">
            <i class="fa-solid fa-books me-2"></i>{{ __('frontend.nav.all_ebooks') }}
          </a>
          <a href="{{ route('free.ebooks') }}" class="m-link">
            <i class="fa-solid fa-gift me-2"></i>{{ __('frontend.nav.free_ebooks') }}
          </a>
        </div>
      </li>
      <li class="m-item"><a href="{{ route('shop') }}" class="m-link">Shop</a></li>
      <li class="m-item"><a href="{{ route('about') }}" class="m-link">আমাদের সম্পর্কে</a></li>
      <li class="m-item"><a href="{{ route('contact') }}" class="m-link">যোগাযোগ</a></li>
    </ul>
  </div>

  {{--<div class="drawer-footer">
    @guest
      <a href="{{ route('login') }}" class="btn btn-outline"
         style="width:100%;justify-content:center;margin-bottom:10px;">লগইন</a>
    @endguest
  </div>--}}
</aside>
