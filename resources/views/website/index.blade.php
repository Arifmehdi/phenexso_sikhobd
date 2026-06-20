@extends('website.layouts.sikhobd')

@section('title', 'Home - '. ($ws->website_title ?? 'Qalam HR'))

@section('meta')
<meta name="keywords" content="{{ $ws->meta_keywords ?? 'education, online courses, learning, training Bangladesh' }}">
<meta property="og:title" content="Home - {{ $ws->website_title ?? 'Qalam HR' }}">
<meta property="og:description" content="{{ $ws->meta_description ?? 'QalamHR is one of the premier training institutes in Bangladesh.' }}">
<meta property="og:image" content="{{ route('imagecache', ['template' => 'original', 'filename' => $ws->logo()]) }}">
<meta property="og:type" content="website">
@endsection

@section('content')
  <section class="hero">
    <div class="container">
      <div class="hero-grid">
        <div>
          <h1>{!! app()->getLocale() == 'bn' ? ($content->title_bn ?? 'শিখুন <em>যেকোনো কিছু</em>,<br>যেকোনো সময়, যেকোনো জায়গায়') : ($content->title_en ?? 'Learn <em>anything</em>,<br>anytime, anywhere') !!}</h1>
          <p>{{ app()->getLocale() == 'bn' ? ($content->description_bn ?? 'ক্লাস ৬ থেকে ১২, ভর্তি প্রস্তুতি, স্কিল ডেভেলপমেন্ট সহ ১০০০+ কোর্স একসাথে।') : ($content->description_en ?? '1000+ courses for Class 6-12, admission prep & skill development — all in one place.') }}</p>
          
          {{--<div class="hero-search">
            <form action="{{ route('shop') }}" method="GET">
              <i class="fa-solid fa-magnifying-glass"></i>
              <input type="text" name="search" placeholder="{{ app()->getLocale() == 'bn' ? 'কী শিখতে চান? সার্চ করুন...' : 'What do you want to learn? Search...' }}" required>
              <button type="submit" class="btn btn-accent">{{ app()->getLocale() == 'bn' ? 'খুঁজুন' : 'Search' }}</button>
            </form>
          </div>--}}

          <div class="hero-cta">
            <a href="{{ route('courses') }}" class="btn btn-primary"><span>{{ app()->getLocale() == 'bn' ? 'আমাদের  কোর্স' : 'Our Courses' }}</span> <i class="fa-solid fa-arrow-right"></i></a>
            <a href="{{ route('shop') }}" class="btn btn-outline"><i class="fa-solid fa-play"></i> <span>{{ app()->getLocale() == 'bn' ? 'শপ' : 'Shop' }}</span></a>
          </div>
          <div class="hero-stats">
            @if(isset($content->meta['hero_stats']))
                @foreach($content->meta['hero_stats'] as $stat)
                    <div class="stat"><strong>{{ $stat['count'] }}</strong><span>{{ app()->getLocale() == 'bn' ? $stat['label_bn'] : $stat['label_en'] }}</span></div>
                @endforeach
            @else
                <div class="stat"><strong>2.4M+</strong><span data-i18n="hero.students">শিক্ষার্থী</span></div>
                <div class="stat"><strong>1000+</strong><span data-i18n="hero.courses">কোর্স</span></div>
                <div class="stat"><strong>500+</strong><span data-i18n="hero.teachers">শিক্ষক</span></div>
            @endif
          </div>
        </div>
        <div class="hero-slider-wrap">
          <div class="swiper hero-slider">
            <div class="swiper-wrapper">
              @forelse($sliders as $slider)
                <div class="swiper-slide">
                  <a href="{{ $slider->link ?? '#' }}" class="slider-item">
                    <img src="{{ route('imagecache', ['template' => 'original', 'filename' => $slider->fi()]) }}" alt="{{ $slider->title }}">
                    @if($slider->title || $slider->description)
                      <div class="slider-overlay">
                        <div class="slider-content">
                          @if($slider->title)<h3>{{ $slider->title }}</h3>@endif
                          @if($slider->description)<p>{{ $slider->description }}</p>@endif
                        </div>
                      </div>
                    @endif
                  </a>
                </div>
              @empty
                <div class="swiper-slide">
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
                </div>
              @endforelse
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
          </div>
        </div>
      </div>
    </div>
  </section>

    <section class="section" >
    <div class="container">
      <div class="section-head">
        <h2><span data-i18n="sec.cat">{{ app()->getLocale() == 'bn' ? 'ক্যাটাগরি অনুযায়ী' : 'Browse by' }}</span> <em data-i18n="sec.cat2">{{ app()->getLocale() == 'bn' ? 'কোর্স' : 'category' }}</em></h2>
        <p data-i18n="sec.cat.sub">{{ app()->getLocale() == 'bn' ? 'আপনার আগ্রহ অনুযায়ী যেকোনো ক্যাটাগরি বেছে নিন' : 'Pick a category that matches your interest' }}</p>
      </div>
      <div class="categories-grid">
        @foreach($categories->take(4) as $index => $category)
        <a href="{{ route('courses', ['category' => $category->slug]) }}" class="category-card" style="--cat-color: {{ $index % 2 == 0 ? 'linear-gradient(135deg, rgba(108,92,231,.12), transparent)' : 'linear-gradient(135deg, rgba(255,40,79,.12), transparent)' }};">
          <div class="cat-icon">
              @if($index == 0) <i class="fa-solid fa-graduation-cap"></i>
              @elseif($index == 1) <i class="fa-solid fa-bolt"></i>
              @elseif($index == 2) <i class="fa-solid fa-language"></i>
              @else <i class="fa-solid fa-user-graduate"></i>
              @endif
          </div>
          <h3>{{ app()->getLocale() == 'bn' ? $category->name_bn : $category->name_en }}</h3>
          <p>{{ $category->products_count ?? $category->products->count() }} {{ app()->getLocale() == 'bn' ? 'টি কোর্স' : 'Courses' }}</p>
        </a>
        @endforeach
      </div>
    </div>
  </section>

  <section class="section how-it-works" style="padding-top:0;">
    <div class="container">
      <div class="section-head">
        @if(isset($content->meta['how_it_works']))
            <h2><span>{{ app()->getLocale() == 'bn' ? $content->meta['how_it_works']['title_bn'] : $content->meta['how_it_works']['title_en'] }}</span></h2>
        @else
            <h2><span data-i18n="how.title">সহজ তিন ধাপে</span> <em data-i18n="how.title2">শেখা শুরু করুন</em></h2>
        @endif
      </div>
      <div class="steps-grid">
        @if(isset($content->meta['how_it_works']['steps']))
            @foreach($content->meta['how_it_works']['steps'] as $step)
                <div class="step">
                  <div class="step-num">{{ $step['num'] }}</div>
                  <h3>{{ app()->getLocale() == 'bn' ? $step['title_bn'] : $step['title_en'] }}</h3>
                  <p>{{ app()->getLocale() == 'bn' ? $step['desc_bn'] : $step['desc_en'] }}</p>
                </div>
            @endforeach
        @else
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
        @endif
      </div>
    </div>
  </section>

  <section class="section" style="padding-top:0;">
    <div class="container">
      <div class="section-head">
        <a href="{{ route('courses') }}" style="text-decoration: none;">
            <h2><span data-i18n="sec.popular">{{ app()->getLocale() == 'bn' ? 'জনপ্রিয়' : 'Popular' }}</span> <em data-i18n="sec.popular2">{{ app()->getLocale() == 'bn' ? 'কোর্সসমূহ' : 'courses' }}</em></h2>
        </a>
        <p data-i18n="sec.popular.sub">{{ app()->getLocale() == 'bn' ? 'হাজারো শিক্ষার্থীর পছন্দের কোর্স' : 'Loved by thousands of students' }}</p>
      </div>
      <div class="courses-grid">
        @foreach($feature_products->take(6) as $product)
        <article class="course-card">
          <a href="{{ route('courseDetail', $product->slug) }}" class="course-thumb" style="--c1:#6c5ce7; --c2:#a29bfe; display: block; overflow: hidden;">
            @if($product->feature)
            <span class="course-tag">FEATURED</span>
            @endif
            @if($product->featured_image)
            <img src="{{ route('imagecache', ['template' => 'medium', 'filename' => $product->featured_image]) }}" alt="{{ app()->getLocale() == 'bn' ? $product->name_bn : $product->name_en }}" style="width:100%; height:100%; object-fit:cover; transition: transform 0.5s;">
            @else
            <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; background:var(--bg-soft); color:var(--primary); font-weight:700;">{{ app()->getLocale() == 'bn' ? $product->name_bn : $product->name_en }}</div>
            @endif
          </a>
          <div class="course-body">
            <h3><a href="{{ route('courseDetail', $product->slug) }}" style="color: inherit; text-decoration: none;">{{ app()->getLocale() == 'bn' ? $product->name_bn : $product->name_en }}</a></h3>
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
              <div style="display: flex; gap: 8px;">
                <button class="btn btn-outline btn-sm add-to-wishlist-ajax" data-id="{{ $product->id }}" title="Add to Wishlist">
                    <i class="fa-regular fa-heart"></i>
                </button>
                <a href="{{ route('courseDetail', $product->slug) }}" class="btn btn-accent">{{ app()->getLocale() == 'bn' ? 'এনরোল' : 'Enroll' }}</a>
              </div>
            </div>
          </div>
        </article>
        @endforeach
      </div>
      <div style="text-align:center; margin-top:40px;">
        <a href="{{ route('courses') }}" class="btn btn-outline">{{ app()->getLocale() == 'bn' ? 'সব কোর্স দেখুন' : 'View All Courses' }}</a>
      </div>
    </div>
  </section>

  <section class="section features">
    <div class="container">
      <div class="section-head">
        @if(isset($content->meta['features']))
            <h2><span>{{ app()->getLocale() == 'bn' ? ($content->meta['features']['title_bn'] ?? 'আমাদের বৈশিষ্ট্য') : ($content->meta['features']['title_en'] ?? 'Our Features') }}</span></h2>
        @else
            <h2><span data-i18n="sec.why">কেন</span> <em data-i18n="sec.why2">{{ $ws->name ?? 'SikhoBD' }}?</em></h2>
        @endif
      </div>
      <div class="features-grid">
        @if(isset($content->meta['features']['items']))
            @foreach($content->meta['features']['items'] as $item)
                <div class="feature">
                  <div class="feature-icon"><i class="{{ $item['icon'] }}"></i></div>
                  <h3>{{ app()->getLocale() == 'bn' ? $item['title_bn'] : $item['title_en'] }}</h3>
                  <p>{{ app()->getLocale() == 'bn' ? $item['desc_bn'] : $item['desc_en'] }}</p>
                </div>
            @endforeach
        @else
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
        @endif
      </div>
    </div>
  </section>

@if(isset($testimonials) && $testimonials->count() > 0)
<section class="section testimonials-section">
    <div class="container">

        <div class="section-head">
            @if(isset($content->meta['testimonials']['title_en']) || isset($content->meta['testimonials']['title_bn']))
                <h2><span>{{ app()->getLocale() == 'bn' ? ($content->meta['testimonials']['title_bn'] ?? 'শিক্ষার্থীদের মতামত') : ($content->meta['testimonials']['title_en'] ?? "Students' Opinions") }}</span></h2>
            @else
                <h2>
                    <span data-i18n="sec.test">শিক্ষার্থীদের</span>
                    <em data-i18n="sec.test2">মতামত</em>
                </h2>
            @endif
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
                                {!! app()->getLocale() == 'bn' ? ($testimonial->text_bn ?? $testimonial->text_en) : ($testimonial->text_en ?? $testimonial->text_bn) !!}
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
        @if(isset($content->meta['news']['title_en']) || isset($content->meta['news']['title_bn']))
            <h2><span>{{ app()->getLocale() == 'bn' ? ($content->meta['news']['title_bn'] ?? 'লেটেস্ট নিউজ ও ব্লগ') : ($content->meta['news']['title_en'] ?? 'Latest News & Blog') }}</span></h2>
        @else
            <h2><span data-i18n="sec.blog">লেটেস্ট</span> <em data-i18n="sec.blog2">নিউজ ও ব্লগ</em></h2>
        @endif
      </div>
      <div class="blog-grid">

        @foreach($newses as $news)
        <article class="blog-card">
          <div class="blog-thumb">
            <img src="{{ route('imagecache', ['template'=>'original','filename' => $news->fi() ?? 'default.png']) }}" alt="{{ $news->title }}">
          </div>
          <div class="blog-body">
            <span class="blog-cat">{{ $news->category->name ?? (app()->getLocale() == 'bn' ? 'নিউজ' : 'News') }}</span>
            <h3><a href="{{ route('singleNews', $news->id) }}">{{ $news->title }}</a></h3>
            <p>{{ Str::limit(strip_tags($news->content), 100) }}</p>
            <div class="blog-foot">
              <span><i class="fa-solid fa-calendar"></i> {{ $news->created_at->format('M d, Y') }}</span>
              <a href="{{ route('singleNews', $news->id) }}">{{ app()->getLocale() == 'bn' ? 'আরও পড়ুন' : 'Read More' }}</a>
            </div>
          </div>
        </article>
        @endforeach
      </div>
      <div style="text-align:center; margin-top:20px;">
        <a href="{{ route('news') }}" class="btn btn-primary">{{ app()->getLocale() == 'bn' ? 'সব নিউজ ও ব্লগ দেখুন' : 'View All News & Blog' }}</a>
      </div>
    </div>
  </section>
  @endif

  <section class="enrollment-section">
    <div class="container">
        <div class="enroll-card">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <div class="enroll-form-wrap">
                        <div class="section-head text-start mb-4">
                            <h2><span>{{ app()->getLocale() == 'bn' ? 'আজই' : 'Enroll' }}</span> <em>{{ app()->getLocale() == 'bn' ? 'এনরোল করুন' : 'Today' }}</em></h2>
                            <p>{{ app()->getLocale() == 'bn' ? '২.৪ মিলিয়নেরও বেশি শিক্ষার্থীর সাথে যোগ দিন এবং আপনার দক্ষতা বৃদ্ধি করুন।' : 'Join 2.4M+ students and start learning the most in-demand skills.' }}</p>
                        </div>
                        <form action="{{ route('addToCart') }}" method="POST" id="home-enroll-form">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ app()->getLocale() == 'bn' ? 'পুরো নাম' : 'Full Name' }}</label>
                                    <input type="text" name="name" class="form-control" placeholder="{{ app()->getLocale() == 'bn' ? 'আপনার নাম লিখুন' : 'Your Name' }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ app()->getLocale() == 'bn' ? 'ফোন নম্বর' : 'Phone Number' }}</label>
                                    <input type="text" name="phone" class="form-control" placeholder="01XXXXXXXXX" required>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">{{ app()->getLocale() == 'bn' ? 'ইমেল ঠিকানা' : 'Email Address' }}</label>
                                    <input type="email" name="email" class="form-control" placeholder="example@mail.com" required>
                                </div>
                                <div class="col-12 mb-4">
                                    <label class="form-label">{{ app()->getLocale() == 'bn' ? 'কোর্স নির্বাচন করুন' : 'Select Course' }}</label>
                                    <select name="product" class="form-select" id="course-select-dropdown" required>
                                        <option value="" selected disabled>{{ app()->getLocale() == 'bn' ? 'আপনার কোর্সটি বেছে নিন' : 'Choose your course' }}</option>
                                        @foreach($feature_products as $product)
                                            <option value="{{ $product->id }}"
                                                    data-slug="{{ $product->slug }}"
                                                    data-name="{{ app()->getLocale() == 'bn' ? ($product->name_bn ?? $product->name_en) : ($product->name_en ?? $product->name_bn) }}"
                                                    data-price="{{ $product->selling_price }}"
                                                    data-image="{{ $product->featured_image ? route('imagecache', ['template' => 'medium', 'filename' => $product->featured_image]) : '' }}"
                                                    data-feature="{{ $product->feature ? 'true' : 'false' }}">
                                                {{ app()->getLocale() == 'bn' ? ($product->name_bn ?? $product->name_en) : ($product->name_en ?? $product->name_bn) }} - ৳ {{ number_format($product->selling_price) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="hidden" name="qty" value="1">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-accent btn-lg w-100 shadow-sm py-3">
                                        <i class="fa-solid fa-graduation-cap mr-2"></i> {{ app()->getLocale() == 'bn' ? 'এখনই এনরোল করুন' : 'Enroll Now' }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-5 d-none d-lg-block">
                    <div class="enroll-image">
                        <img src="https://img.freepik.com/free-vector/learning-concept-illustration_114360-6186.jpg" alt="Enrollment" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
  </section>

@endsection

@push('css')
<style>
  .hero-slider-wrap {
    position: relative;
    width: 100%;
    aspect-ratio: 4 / 3;
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-lg);
  }
  .hero-slider {
    width: 100%;
    height: 100%;
  }
  .slider-item {
    display: block;
    width: 100%;
    height: 100%;
    position: relative;
  }
  .slider-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
  }
  .slider-item:hover img {
    transform: scale(1.05);
  }
  .slider-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, transparent 60%);
    display: flex;
    align-items: flex-end;
    padding: 32px;
    color: #fff;
  }
  .slider-content h3 {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 8px;
  }
  .slider-content p {
    font-size: 14px;
    opacity: 0.9;
    margin: 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
  .hero-slider .swiper-pagination-bullet-active {
    background: var(--accent) !important;
  }
  .hero-slider .swiper-button-next, .hero-slider .swiper-button-prev {
    color: #fff !important;
    background: rgba(0,0,0,0.2);
    width: 40px !important;
    height: 40px !important;
    border-radius: 50%;
    backdrop-filter: blur(4px);
    transition: all 0.3s ease;
  }
  .hero-slider .swiper-button-next:hover, .hero-slider .swiper-button-prev:hover {
    background: var(--accent);
  }
  .hero-slider .swiper-button-next:after, .hero-slider .swiper-button-prev:after {
    font-size: 18px !important;
  }

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

  .enrollment-section {
    padding: 60px 0;
    background: var(--bg-soft);
  }
  .enroll-card {
    background: #fff;
    border-radius: var(--radius-lg);
    padding: 40px;
    box-shadow: var(--shadow-lg);
    border: 1px solid var(--border);
    overflow: hidden;
  }
  .course-selector-wrap {
    margin-top: 20px;
  }
  .course-selector-wrap .form-select {
    border-radius: 12px;
    padding: 16px 20px;
    font-size: 16px;
    border: 2px solid var(--border);
    background: var(--bg-soft);
    transition: all 0.3s;
  }
  .course-selector-wrap .form-select:focus {
    border-color: var(--accent);
    background: #fff;
    box-shadow: 0 0 0 4px rgba(255, 40, 79, 0.1);
    outline: none;
  }
  #courses-grid-selection {
    margin-top: 30px;
  }
  #courses-grid-selection .course-card {
    cursor: pointer;
    transition: all 0.3s;
  }
  #courses-grid-selection .course-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-md);
  }

  /* Selected Course Card Styles */
  #selected-course-card .selected-course-card {
    background: #fff;
    border: 1px solid var(--border);
  }
  #selected-course-card .course-image-preview {
    border-radius: 12px;
    overflow: hidden;
    border: 3px solid var(--bg-soft);
  }
  #selected-course-card .course-meta span {
    color: var(--text-soft);
    font-size: 14px;
  }
  @media (max-width: 992px) {
    .enroll-card { padding: 30px 20px; }
  }
</style>
@endpush

@push('js')
<script>
$(document).ready(function() {
  // Enrollment Form AJAX - Submit to cart and redirect to cart page
  $(document).on('submit', '#home-enroll-form', function(e) {
      e.preventDefault();
      const form = $(this);
      const btn = form.find('button[type="submit"]');
      const originalHtml = btn.html();

      btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> {{ app()->getLocale() == 'bn' ? 'প্রক্রিয়াধীন...' : 'Processing...' }}');

      // Store form data in localStorage for pre-filling checkout form
      localStorage.setItem('enroll_name', form.find('input[name="name"]').val());
      localStorage.setItem('enroll_phone', form.find('input[name="phone"]').val());
      localStorage.setItem('enroll_email', form.find('input[name="email"]').val());

      $.ajax({
          url: form.attr('action'),
          type: "POST",
          data: form.serialize(),
          success: function(response) {
              if (response.status || response.success) {
                  showCartNotification(response.message || 'Course added to cart!', 'success');
                  setTimeout(() => {
                      window.location.href = "{{ route('cart') }}";
                  }, 1000);
              } else {
                  btn.prop('disabled', false).html(originalHtml);
                  showCartNotification(response.message || 'Something went wrong.', 'error');
              }
          },
          error: function() {
              btn.prop('disabled', false).html(originalHtml);
              showCartNotification('Failed to add to cart.', 'error');
          }
      });
  });

  // Initialize Hero Slider
  const heroSwiper = new Swiper('.hero-slider', {
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
  });

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

        if (text.outerHeight() > 120) {
            toggle.show();
            if (container.find('.fade-overlay').length === 0) {
                container.append('<div class="fade-overlay"></div>');
            }
        }

        toggle.on('click', function () {
            card.toggleClass('expanded');
            const isExpanded = card.hasClass('expanded');
            $(this).html(isExpanded ? showLessText : readMoreText);

            setTimeout(() => {
                if (typeof testimonialSwiper !== 'undefined') {
                    testimonialSwiper.update();
                }
            }, 400);
        });
    });

    $(document).on('click', '.add-to-wishlist-ajax', function() {
        const productId = $(this).data('id');
        const btn = $(this);
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

        $.ajax({
            url: "{{ route('wishlist.add') }}",
            type: "POST",
            data: {
                product_id: productId,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                btn.prop('disabled', false).html('<i class="fa-solid fa-heart"></i>');
                showCartNotification(response.message, 'success');
            },
            error: function() {
                btn.prop('disabled', false).html('<i class="fa-regular fa-heart"></i>');
                showCartNotification('Failed to add to wishlist.', 'error');
            }
        });
    });
});
</script>
@endpush
