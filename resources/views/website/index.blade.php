@extends('website.layouts.sikhobd')

@section('title', 'Home - '. ($ws->name ?? env('APP_NAME')))

@section('meta')
<meta name="description" content="{{ $ws->meta_description ?? 'SikhoBD is an online learning platform.' }}">
<meta name="keywords" content="{{ $ws->meta_keywords ?? 'education, online courses, learning' }}">
<meta property="og:title" content="Home - {{ $ws->name ?? env('APP_NAME') }}">
<meta property="og:description" content="{{ $ws->meta_description ?? 'Discover quality courses at SikhoBD.' }}">
<meta property="og:image" content="{{ route('imagecache', ['template' => 'original', 'filename' => $ws->logo()]) }}">
<meta property="og:type" content="website">
@endsection

@section('content')
  <section class="hero">
    <div class="container">
      <div class="hero-grid">
        <div>
          <span class="eyebrow" data-i18n="hero.eyebrow">বাংলাদেশের #১ অনলাইন স্কুল</span>
          <h1><span data-i18n="hero.title1">শিখুন</span> <em data-i18n="hero.title2">যেকোনো কিছু</em>,<br><span data-i18n="hero.title3">যেকোনো সময়, যেকোনো জায়গায়</span></h1>
          <p data-i18n="hero.desc">ক্লাস ৬ থেকে ১২, ভর্তি প্রস্তুতি, স্কিল ডেভেলপমেন্ট সহ ১০০০+ কোর্স একসাথে।</p>
          <div class="hero-cta">
            <a href="{{ route('shop') }}" class="btn btn-primary"><span data-i18n="hero.explore">এক্সপ্লোর কোর্স</span> <i class="fa-solid fa-arrow-right"></i></a>
            <a href="#" class="btn btn-outline"><i class="fa-solid fa-play"></i> <span data-i18n="hero.freeclass">ফ্রি ক্লাস দেখুন</span></a>
          </div>
          <div class="hero-stats">
            <div class="stat"><strong>2.4M+</strong><span data-i18n="hero.students">শিক্ষার্থী</span></div>
            <div class="stat"><strong>1000+</strong><span data-i18n="hero.courses">কোর্স</span></div>
            <div class="stat"><strong>500+</strong><span data-i18n="hero.teachers">শিক্ষক</span></div>
          </div>
        </div>
        <div style="position: relative;">
          <div class="hero-card">
            <div>
              <span class="live-badge">LIVE</span>
              <h3>HSC Physics</h3>
              <p style="opacity:.85; margin-top:6px;">Chapter 3 — Motion & Force</p>
            </div>
            <div>
              <div class="progress"><div></div></div>
              <p style="font-size:13px; opacity:.85;">42 min left</p>
            </div>
          </div>
          <div class="floating-card">
            <span>This month</span>
            <strong>2.4M+</strong>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <div class="section-head">
        <h2><span data-i18n="sec.cat">ক্যাটাগরি অনুযায়ী</span> <em data-i18n="sec.cat2">কোর্স</em></h2>
        <p data-i18n="sec.cat.sub">আপনার আগ্রহ অনুযায়ী যেকোনো ক্যাটাগরি বেছে নিন</p>
      </div>
      <div class="categories-grid">
        @foreach($categories->take(4) as $index => $category)
        <a href="{{ route('productCategory', $category->slug) }}" class="category-card" style="--cat-color: {{ $index % 2 == 0 ? 'linear-gradient(135deg, rgba(108,92,231,.12), transparent)' : 'linear-gradient(135deg, rgba(255,40,79,.12), transparent)' }};">
          <div class="cat-icon">
              @if($index == 0) <i class="fa-solid fa-graduation-cap"></i>
              @elseif($index == 1) <i class="fa-solid fa-bolt"></i>
              @elseif($index == 2) <i class="fa-solid fa-language"></i>
              @else <i class="fa-solid fa-user-graduate"></i>
              @endif
          </div>
          <h3>{{ $category->name_en }}</h3>
          <p>{{ $category->products_count ?? $category->products->count() }} Courses</p>
        </a>
        @endforeach
      </div>
    </div>
  </section>

  <section class="section" style="padding-top:0;">
    <div class="container">
      <div class="section-head">
        <h2><span data-i18n="sec.popular">জনপ্রিয়</span> <em data-i18n="sec.popular2">কোর্সসমূহ</em></h2>
        <p data-i18n="sec.popular.sub">হাজারো শিক্ষার্থীর পছন্দের কোর্স</p>
      </div>
      <div class="courses-grid">
        @foreach($feature_products->take(3) as $product)
        <article class="course-card">
          <div class="course-thumb" style="--c1:#6c5ce7; --c2:#a29bfe;">
            @if($product->feature)
            <span class="course-tag">FEATURED</span>
            @endif
            {{ $product->name_en }}
          </div>
          <div class="course-body">
            <h3>{{ $product->name_en }}</h3>
            <div class="course-meta">
              <span><i class="fa-solid fa-star"></i> 4.9</span>
              <span><i class="fa-solid fa-users"></i> {{ $product->click_count ?? '0' }}</span>
              <span><i class="fa-solid fa-clock"></i> 200h</span>
            </div>
            <div class="course-foot">
              <div>
                  <span class="price">৳ {{ number_format($product->selling_price, 0) }}</span>
                  @if($product->price > $product->selling_price)
                  <span class="old-price">৳ {{ number_format($product->price, 0) }}</span>
                  @endif
              </div>
              <a href="{{ route('productDetails', $product->slug) }}" class="btn btn-accent" data-i18n="enroll">এনরোল</a>
            </div>
          </div>
        </article>
        @endforeach
      </div>
    </div>
  </section>

  <section class="section features">
    <div class="container">
      <div class="section-head">
        <h2><span data-i18n="sec.why">কেন</span> <em data-i18n="sec.why2">{{ $ws->name ?? 'SikhoBD' }}?</em></h2>
      </div>
      <div class="features-grid">
        <div class="feature">
          <div class="feature-icon"><i class="fa-solid fa-video"></i></div>
          <h3 data-i18n="nav.live">লাইভ ক্লাস</h3>
          <p>Real-time live classes with the best teachers in the country.</p>
        </div>
        <div class="feature">
          <div class="feature-icon"><i class="fa-solid fa-book-open"></i></div>
          <h3>1000+ Resources</h3>
          <p>Videos, notes, quizzes — all in one place.</p>
        </div>
        <div class="feature">
          <div class="feature-icon"><i class="fa-solid fa-mobile-screen"></i></div>
          <h3>Any Device</h3>
          <p>Learn from mobile, tablet or computer — anywhere.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="section" style="padding-top:0;">
    <div class="container">
      <div class="cta-strip">
        <div>
          <h2 data-i18n="cta.title">আজই অ্যাপ ডাউনলোড করুন</h2>
          <p data-i18n="cta.desc">২ মিলিয়নের বেশি শিক্ষার্থীর সাথে যোগ দিন।</p>
        </div>
        <a href="#" class="btn btn-accent"><i class="fa-solid fa-download"></i> <span data-i18n="cta.btn">এখনই ডাউনলোড</span></a>
      </div>
    </div>
  </section>
@endsection
