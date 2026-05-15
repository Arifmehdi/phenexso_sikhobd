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
          
          <div class="hero-search">
            <form action="{{ route('shop') }}" method="GET">
              <i class="fa-solid fa-magnifying-glass"></i>
              <input type="text" name="search" placeholder="কী শিখতে চান? সার্চ করুন..." required>
              <button type="submit" class="btn btn-accent">খুঁজুন</button>
            </form>
          </div>

          <div class="hero-cta">
            <a href="{{ route('courses') }}" class="btn btn-primary"><span data-i18n="hero.explore">এক্সপ্লোর কোর্স</span> <i class="fa-solid fa-arrow-right"></i></a>
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

  <section class="section how-it-works">
    <div class="container">
      <div class="section-head">
        <h2><span data-i18n="how.title">সহজ তিন ধাপে</span> <em data-i18n="how.title2">শেখা শুরু করুন</em></h2>
      </div>
      <div class="steps-grid">
        <div class="step">
          <div class="step-num">01</div>
          <h3>কোর্স পছন্দ করুন</h3>
          <p>আমাদের বিশাল ক্যাটাগরি থেকে আপনার পছন্দের কোর্সটি বেছে নিন।</p>
        </div>
        <div class="step">
          <div class="step-num">02</div>
          <h3>এনরোল করুন</h3>
          <p>সহজ পেমেন্ট পদ্ধতিতে কোর্সে ভর্তি হন এবং এক্সেস পান।</p>
        </div>
        <div class="step">
          <div class="step-num">03</div>
          <h3>শেখা শুরু করুন</h3>
          <p>ভিডিও লেসন, কুইজ এবং নোটের মাধ্যমে আপনার দক্ষতা বৃদ্ধি করুন।</p>
        </div>
      </div>
    </div>
  </section>

  <section class="section" style="padding-top:0;">
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
        @foreach($feature_products->take(6) as $product)
        <article class="course-card">
          <div class="course-thumb" style="--c1:#6c5ce7; --c2:#a29bfe;">
            @if($product->feature)
            <span class="course-tag">FEATURED</span>
            @endif
            @if($product->featured_image)
            <img src="{{ route('imagecache', ['template' => 'medium', 'filename' => $product->featured_image]) }}" alt="{{ $product->name_en }}" style="width:100%; height:100%; object-fit:cover;">
            @else
            {{ $product->name_en }}
            @endif
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
      <div style="text-align:center; margin-top:40px;">
        <a href="{{ route('courses') }}" class="btn btn-outline">সব কোর্স দেখুন</a>
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

@if(isset($testimonials) && $testimonials->count() > 0)
<section class="section testimonials-section">
    <div class="container">

        <div class="section-head">
            <h2>
                <span data-i18n="sec.test">শিক্ষার্থীদের</span>
                <em data-i18n="sec.test2">মতামত</em>
            </h2>
        </div>

        <div class="swiper testimonial-slider">
            <div class="swiper-wrapper">

                @foreach($testimonials as $testimonial)
                <div class="swiper-slide">

                    <div class="testimonial-card">

                        <div class="quote-icon">
                            <i class="fa-solid fa-quote-left"></i>
                        </div>

                        <div class="test-text-container">
                            <p class="test-text">
                                {!! $testimonial->text_en !!}
                            </p>
                        </div>

                        <button class="read-more-toggle" style="display:none;">
                            {!! __('আরও পড়ুন') !!}
                        </button>

                        <div class="test-user">

                            @if($testimonial->image)
                                <img
                                    src="{{ route('imagecache', ['template' => 'thumbnail', 'filename' => $testimonial->image]) }}"
                                    alt="{{ $testimonial->name }}"
                                >
                            @else
                                <div class="avatar">
                                    {{ substr($testimonial->name, 0, 1) }}
                                </div>
                            @endif

                            <div>
                                <h4>{{ $testimonial->name }}</h4>
                                <span>{{ $testimonial->designation }}</span>
                            </div>

                        </div>

                    </div>

                </div>
                @endforeach

            </div>

            <!-- Pagination -->
            <div class="swiper-pagination"></div>

            <!-- Navigation -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>

        </div>

    </div>
</section>
@endif
  @if(isset($newses) && $newses->count() > 0)
  <section class="section" style="background: var(--bg-soft);">
    <div class="container">
      <div class="section-head">
        <h2><span data-i18n="sec.blog">লেটেস্ট</span> <em data-i18n="sec.blog2">নিউজ ও ব্লগ</em></h2>
      </div>
      <div class="blog-grid">
        @foreach($newses as $news)
        <article class="blog-card">
          <div class="blog-thumb">
            <img src="{{ route('imagecache', ['template'=>'original','filename' => $news->fi() ?? 'default.png']) }}" alt="{{ $news->title }}">
          </div>
          <div class="blog-body">
            <span class="blog-cat">{{ $news->category->name_en ?? 'News' }}</span>
            <h3><a href="{{ route('singleNews', $news->id) }}">{{ $news->title }}</a></h3>
            <p>{{ Str::limit(strip_tags($news->content), 100) }}</p>
            <div class="blog-foot">
              <span><i class="fa-solid fa-calendar"></i> {{ $news->created_at->format('M d, Y') }}</span>
              <a href="{{ route('singleNews', $news->id) }}">আরও পড়ুন</a>
            </div>
          </div>
        </article>
        @endforeach
      </div>
    </div>
  </section>
  @endif

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

@push('css')
<style>
  .hero-search {
    margin-top: 32px;
    background: #fff;
    padding: 8px;
    border-radius: var(--radius-full);
    box-shadow: var(--shadow-lg);
    max-width: 540px;
    border: 1px solid var(--border);
  }
  .hero-search form {
    display: flex;
    align-items: center;
    gap: 12px;
    padding-left: 16px;
  }
  .hero-search i { color: var(--text-muted); }
  .hero-search input {
    flex: 1;
    border: none;
    outline: none;
    font-size: 15px;
    background: transparent;
  }
  .hero-search .btn { padding: 10px 24px; }

  .steps-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 40px;
    margin-top: 20px;
  }
  .step {
    text-align: center;
    position: relative;
  }
  .step-num {
    font-size: 48px;
    font-weight: 800;
    color: var(--primary);
    opacity: 0.1;
    margin-bottom: -20px;
  }
  .step h3 { color: var(--primary); margin-bottom: 12px; position: relative; }
  .step p { font-size: 14px; color: var(--text-soft); }

  /* Testimonial Slider Styles */
  .testimonials-section { overflow: hidden; }
  .testimonial-slider { padding: 20px 0 60px !important; }
  
  .testimonial-card {
    background: #fff;
    padding: 40px;
    border-radius: var(--radius-lg);
    border: 1px solid var(--border);
    transition: all .3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
    position: relative;
  }
  .testimonial-card:hover { transform: translateY(-5px); box-shadow: var(--shadow-md); border-color: var(--primary); }
  
  .quote-icon { color: var(--accent); font-size: 32px; margin-bottom: 20px; opacity: 0.2; }
  
  .test-text-container {
    flex-grow: 1;
    position: relative;
    max-height: 120px; /* Fixed height for text */
    overflow: hidden;
    transition: max-height 0.4s ease;
    margin-bottom: 15px;
  }
  .testimonial-card.expanded .test-text-container {
    max-height: 1000px; /* Large enough to show all text */
  }
  
  .test-text {
    font-size: 16px;
    color: var(--text-soft);
    line-height: 1.8;
    margin: 0;
  }
  
  .read-more-toggle {
    background: none;
    border: none;
    color: var(--accent);
    font-weight: 700;
    font-size: 13px;
    padding: 0;
    margin-bottom: 20px;
    cursor: pointer;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: flex;
    align-items: center;
    gap: 5px;
  }
  .read-more-toggle:hover { text-decoration: underline; }
  .read-more-toggle::after { content: '\f107'; font-family: 'Font Awesome 6 Free'; font-weight: 900; transition: transform 0.3s; }
  .testimonial-card.expanded .read-more-toggle::after { transform: rotate(180deg); }

  .fade-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 40px;
    background: linear-gradient(transparent, #fff);
    pointer-events: none;
    transition: opacity 0.3s;
  }
  .testimonial-card.expanded .fade-overlay { opacity: 0; }

  .test-user { 
    display: flex; 
    align-items: center; 
    gap: 15px; 
    margin-top: auto;
    padding-top: 20px;
    border-top: 1px solid var(--bg-muted);
  }
  .test-user img, .test-user .avatar { 
    width: 54px; height: 54px; 
    border-radius: 50%; object-fit: cover; 
    border: 3px solid var(--bg-soft);
  }
  .test-user .avatar {
    background: var(--primary);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 20px;
  }
  .test-user h4 { font-size: 17px; color: var(--primary); margin-bottom: 2px; }
  .test-user span { font-size: 13px; color: var(--text-muted); }

  /* Swiper Customization */
  .testimonial-slider .swiper-pagination-bullet-active { background: var(--primary); }
  .testimonial-slider .swiper-button-next,
  .testimonial-slider .swiper-button-prev {
    color: var(--primary);
    width: 44px; height: 44px;
    background: #fff;
    border-radius: 50%;
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border);
  }
  .testimonial-slider .swiper-button-next:after,
  .testimonial-slider .swiper-button-prev:after { font-size: 18px; font-weight: 900; }
  .testimonial-slider .swiper-button-next:hover,
  .testimonial-slider .swiper-button-prev:hover { background: var(--primary); color: #fff; border-color: var(--primary); }

  .blog-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
  }
  .blog-card {
    background: #fff;
    border-radius: var(--radius-lg);
    overflow: hidden;
    border: 1px solid var(--border);
    transition: all .25s;
  }
  .blog-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-md); }
  .blog-thumb { aspect-ratio: 16 / 9; overflow: hidden; }
  .blog-thumb img { width: 100%; height: 100%; object-fit: cover; transition: transform .5s; }
  .blog-card:hover .blog-thumb img { transform: scale(1.05); }
  .blog-body { padding: 20px; }
  .blog-cat { font-size: 12px; font-weight: 700; color: var(--accent); text-transform: uppercase; display: block; margin-bottom: 8px; }
  .blog-body h3 { font-size: 18px; margin-bottom: 12px; line-height: 1.4; color: var(--primary); }
  .blog-body h3 a:hover { color: var(--accent); }
  .blog-body p { font-size: 14px; color: var(--text-soft); margin-bottom: 20px; }
  .blog-foot {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 16px;
    border-top: 1px solid var(--border);
    font-size: 13px;
    color: var(--text-muted);
  }
  .blog-foot a { color: var(--primary); font-weight: 600; }
  .blog-foot a:hover { color: var(--accent); }

  @media (max-width: 992px) {
    .steps-grid, .blog-grid { grid-template-columns: repeat(2, 1fr); }
    .testimonial-slider .swiper-button-next,
    .testimonial-slider .swiper-button-prev { display: none; }
  }
  @media (max-width: 600px) {
    .steps-grid, .blog-grid { grid-template-columns: 1fr; }
    .hero-search form { padding-left: 8px; }
    .hero-search input { font-size: 14px; }
  }
</style>

@endpush

@push('js')
<script>
$(document).ready(function() {
  // Initialize Testimonial Slider
  const testimonialSwiper = new Swiper('.testimonial-slider', {
    slidesPerView: 1,
    spaceBetween: 30,
    loop: true,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false,
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    breakpoints: {
      640: { slidesPerView: 1 },
      768: { slidesPerView: 2 },
      1024: { slidesPerView: 3 },
    }
  });



    const readMoreText = `{!! __('আরও পড়ুন') !!}`;
    const showLessText = `{!! __('সংক্ষেপে দেখুন') !!}`;

    $('.testimonial-card').each(function () {

        const card = $(this);
        const container = card.find('.test-text-container');
        const text = card.find('.test-text');
        const toggle = card.find('.read-more-toggle');

        // Check if content exceeds 120px
        if (text.outerHeight() > 120) {

            toggle.show();

            // Add fade overlay
            if (container.find('.fade-overlay').length === 0) {
                container.append('<div class="fade-overlay"></div>');
            }
        }

        toggle.on('click', function () {

            card.toggleClass('expanded');

            const isExpanded = card.hasClass('expanded');

            $(this).html(
                isExpanded
                    ? showLessText
                    : readMoreText
            );

            // Update swiper height
            setTimeout(() => {
                if (typeof testimonialSwiper !== 'undefined') {
                    testimonialSwiper.update();
                }
            }, 400);

        });

    });


});
</script>
@endpush
