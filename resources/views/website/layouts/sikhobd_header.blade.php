<header class="site-header">
  <div class="container header-inner">
    <a href="{{ route('home') }}" class="logo">
      <img src="{{ route('imagecache', ['template' => 'original', 'filename' => $ws->logo_alt()]) }}" alt="{{ $ws->name }}" style="max-height: 40px;">
    </a>

    <nav class="nav-desktop">
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
      <div class="nav-item"><a href="{{ route('shop') }}" class="nav-link" data-i18n="nav.shop">Shop</a></div>
    </nav>

    <div class="header-right">
      <div class="lang-switch desktop-only" role="group" aria-label="Language">
        <button data-lang="bn">বাং</button>
        <button data-lang="en">EN</button>
      </div>
      
      @auth
      <div class="nav-item user-dropdown desktop-only">
        <a href="javascript:void(0)" class="icon-btn" aria-label="User Account">
          <i class="fa-solid fa-circle-user"></i>
        </a>
        <ul class="dropdown">
          @if(auth()->user()->hasRole('admin') || auth()->user()->role == 'admin')
            <li><a href="{{ route('admin.dashboard') }}" class="dropdown-link"><i class="fa-solid fa-gauge-high me-2"></i> Admin Panel</a></li>
          @endif
          <li><a href="{{ route('user.dashboard') }}" class="dropdown-link"><i class="fa-solid fa-user me-2"></i> Dashboard</a></li>
          <li>
            <a href="{{ route('logout') }}" class="dropdown-link text-danger">
              <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
            </a>
          </li>
        </ul>
      </div>
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
      @auth
        <li class="m-item">
          <button class="m-toggle">
            <i class="fa-solid fa-circle-user me-2"></i> <span>{{ auth()->user()->name }}</span>
            <svg class="caret" width="12" height="12" viewBox="0 0 10 10" fill="currentColor"><path d="M1 3l4 4 4-4z"/></svg>
          </button>
          <div class="m-children">
            @if(auth()->user()->role == 'admin')
                <a href="{{ route('admin.dashboard') }}" class="m-link">
                    <i class="fa-solid fa-gauge-high me-2"></i> Admin Panel
                </a>

                <a href="{{ route('user.dashboard') }}" class="m-link">
                    <i class="fa-solid fa-user me-2"></i> Dashboard
                </a>
            @else
                <a href="{{ route('user.dashboard') }}" class="m-link">
                    <i class="fa-solid fa-user me-2"></i> Dashboard
                </a>
            @endif
            <a href="{{ route('logout') }}" class="m-link text-danger">
              <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
            </a>
          </div>
        </li>
      @endauth

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
                        <a href="{{ route('courses', ['category' => $child->slug]) }}" class="m-link">
                          {{ app()->getLocale() == 'bn' ? $child->name_bn : $child->name_en }}
                        </a>
                      @endforeach
                    </div>
                  </div>
                @else
                  <a href="{{ route('courses', ['category' => $sub->slug]) }}" class="m-link">
                    {{ app()->getLocale() == 'bn' ? $sub->name_bn : $sub->name_en }}
                  </a>
                @endif
              @endforeach
            </div>
          @else
            <a href="{{ route('courses', ['category' => $cat->slug]) }}" class="m-link">
              {{ app()->getLocale() == 'bn' ? $cat->name_bn : $cat->name_en }}
            </a>
          @endif
        </li>
      @endforeach
      <li class="m-item"><a href="{{ route('shop') }}" class="m-link" data-i18n="nav.shop">Shop</a></li>
      <li class="m-item"><a href="{{ route('about') }}" class="m-link" data-i18n="nav.about">আমাদের সম্পর্কে</a></li>
      <li class="m-item"><a href="{{ route('contact') }}" class="m-link" data-i18n="nav.contact">যোগাযোগ</a></li>
    </ul>
  </div>
  <div class="drawer-footer">
    @guest
      <a href="{{ route('login') }}" class="btn btn-outline" style="width: 100%; justify-content: center; margin-bottom: 10px;" data-i18n="nav.login">লগইন</a>
    @endguest
    <a href="#" class="btn btn-primary" style="width: 100%; justify-content: center;"><i class="fa-solid fa-download"></i> <span data-i18n="nav.download">ডাউনলোড অ্যাপ</span></a>
  </div>
</aside>
