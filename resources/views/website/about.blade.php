@extends('website.layouts.sikhobd')

@section('title', ($content->title ?? 'আমাদের সম্পর্কে') . ' — ' . ($ws->website_title ?? 'Qalam HR'))

@section('meta')
<meta name="description" content="{{ $ws->meta_description ?? 'QalamHR is one of the premier training institutes in Bangladesh.' }}">
<meta name="keywords" content="{{ $ws->meta_keywords ?? 'about, education, learning, Qalam HR' }}">
@endsection

@section('content')
<main>
  <!-- Modern Hero Section -->
  <section class="about-hero">
    <div class="container">
      <div class="about-hero-content">
        <span class="eyebrow">{{ app()->getLocale() == 'bn' ? 'আমাদের সম্পর্কে জানুন' : 'Discover Our Journey' }}</span>
        <h1>{{ app()->getLocale() == 'bn' ? ($content->title_bn ?? $content->title ?? 'আমাদের সম্পর্কে') : ($content->title_en ?? $content->title ?? 'About Us') }}</h1>
        <p>{{ app()->getLocale() == 'bn' ? ($content->subtitle_bn ?? $content->subtitle ?? 'শিক্ষা সবার জন্য — এই বিশ্বাস থেকেই আমাদের যাত্রা শুরু') : ($content->subtitle_en ?? $content->subtitle ?? 'Education for all — our journey started with this belief') }}</p>
      </div>
    </div>
    <div class="hero-shape"></div>
  </section>

  <!-- Story & Mission Section -->
  <section class="section about-story">
    <div class="container">
      <div class="row align-items-center g-5">
        <div class="col-lg-7">
          <div class="story-content">
            <h2 class="section-title-alt">{{ app()->getLocale() == 'bn' ? ($content->meta['story_title_bn'] ?? 'আমাদের গল্প') : ($content->meta['story_title_en'] ?? 'Our Story') }}</h2>
            <div class="story-text">
                {!! app()->getLocale() == 'bn' ? ($content->description_bn ?? $content->description ?? '<p>শিখবে বিডি ২০১৫ সালে একটি সহজ লক্ষ্য নিয়ে যাত্রা শুরু করেছিল — বাংলাদেশের প্রত্যেকের জন্য গুণগত শিক্ষা সহজলভ্য করা।</p>') : ($content->description_en ?? $content->description ?? '<p>SikhoBD started in 2015 with a simple goal — make quality education accessible to everyone in Bangladesh.</p>') !!}
            </div>
            <div class="mt-4">
              <a href="{{ route('contact') }}" class="btn btn-primary btn-lg">{{ app()->getLocale() == 'bn' ? 'যোগাযোগ করুন' : 'Get in touch' }}</a>
            </div>
          </div>
        </div>
        <div class="col-lg-5">
          <div class="mission-card-wrapper">
            <div class="mission-card">
              <div class="mission-icon">
                <i class="fa-solid fa-bullseye"></i>
              </div>
              <h3>{{ app()->getLocale() == 'bn' ? ($content->meta['mission_title_bn'] ?? 'মিশন') : ($content->meta['mission_title_en'] ?? 'Mission') }}</h3>
              <p>{{ app()->getLocale() == 'bn' ? ($content->meta['mission_description_bn'] ?? 'বাংলাদেশের প্রতিটি শিক্ষার্থীকে বিশ্বমানের শেখার সরঞ্জামের মাধ্যমে ক্ষমতায়িত করা।') : ($content->meta['mission_description_en'] ?? 'Empower every student in Bangladesh with world-class learning tools.') }}</p>
            </div>
            <div class="mission-decoration"></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Impact Section -->
  <section class="section impact-section">
    <div class="container">
      <div class="section-head text-center">
        <h2 class="section-title">
            @if(isset($content->meta['impact']['title_en']) || isset($content->meta['impact']['title_bn']))
                {{ app()->getLocale() == 'bn' ? ($content->meta['impact']['title_bn'] ?? 'আমাদের প্রভাব') : ($content->meta['impact']['title_en'] ?? 'Our Impact') }}
            @else
                Our <em>impact</em>
            @endif
        </h2>
        <p class="section-subtitle">{{ app()->getLocale() == 'bn' ? 'আমরা গর্বের সাথে আমাদের অর্জনগুলো তুলে ধরছি' : 'We take pride in sharing our milestones with you' }}</p>
      </div>
      
      <div class="impact-grid">
        @if(isset($content->meta['impact']['items']))
            @foreach($content->meta['impact']['items'] as $item)
                <div class="impact-item">
                    <div class="impact-icon"><i class="{{ $item['icon'] ?? 'fa-solid fa-users' }}"></i></div>
                    <div class="impact-body">
                        <h3>{{ app()->getLocale() == 'bn' ? ($item['title_bn'] ?? $item['title_en']) : ($item['title_en'] ?? $item['title_bn']) }}</h3>
                        <p>{{ app()->getLocale() == 'bn' ? ($item['desc_bn'] ?? $item['desc_en']) : ($item['desc_en'] ?? $item['desc_bn']) }}</p>
                    </div>
                </div>
            @endforeach
        @else
            <div class="impact-item">
                <div class="impact-icon"><i class="fa-solid fa-users"></i></div>
                <div class="impact-body">
                    <h3>2.4M+ Students</h3>
                    <p>Across 64 districts of Bangladesh.</p>
                </div>
            </div>
            <div class="impact-item">
                <div class="impact-icon"><i class="fa-solid fa-graduation-cap"></i></div>
                <div class="impact-body">
                    <h3>1000+ Courses</h3>
                    <p>From Class 6 to professional skills.</p>
                </div>
            </div>
            <div class="impact-item">
                <div class="impact-icon"><i class="fa-solid fa-trophy"></i></div>
                <div class="impact-body">
                    <h3>15 Awards</h3>
                    <p>National & international recognition.</p>
                </div>
            </div>
        @endif
      </div>
    </div>
  </section>

  <!-- Testimonials Section -->
  @if(isset($testimonials) && $testimonials->count() > 0)
  <section class="section about-testimonials">
    <div class="container">
        <div class="section-head text-center">
            <h2 class="section-title">{{ app()->getLocale() == 'bn' ? 'শিক্ষার্থীদের' : 'What our' }} <em>{{ app()->getLocale() == 'bn' ? 'মতামত' : 'students say' }}</em></h2>
        </div>
        <div class="testimonials-grid-modern">
            @foreach($testimonials->take(3) as $testimonial)
            @php
                $rawText = strip_tags(app()->getLocale() == 'bn' ? ($testimonial->text_bn ?? $testimonial->text_en) : ($testimonial->text_en ?? $testimonial->text_bn));
                $charLimit = 160;
                $isLong = mb_strlen($rawText) > $charLimit;
            @endphp
            <div class="testimonial-card-modern">
                <div class="quote-mark"><i class="fa-solid fa-quote-right"></i></div>
                <p class="test-content">
                    @if($isLong)
                        <span class="text-short">"{!! mb_substr($rawText, 0, $charLimit) !!}..."</span>
                        <span class="text-full" style="display:none;">"{!! $rawText !!}"</span>
                        <a href="javascript:void(0)" class="read-more-toggle text-primary" style="font-weight: 700; font-size: 13px; display: inline-block; margin-left: 5px;">
                            {{ app()->getLocale() == 'bn' ? 'আরও পড়ুন' : 'Read More' }}
                        </a>
                    @else
                        "{!! $rawText !!}"
                    @endif
                </p>
                <div class="test-author">
                    <img src="{{ asset('storage/' . ($testimonial->image ?? 'default.png')) }}" alt="{{ $testimonial->name }}">
                    <div class="author-info">
                        <h4>{{ $testimonial->name }}</h4>
                        <span>{{ $testimonial->designation }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
  </section>
  @endif

  <!-- Team Section -->
  <section class="section team-section bg-soft">
    <div class="container">
      <div class="section-head text-center">
        <h2 class="section-title">{{ app()->getLocale() == 'bn' ? 'আমাদের টিম' : 'Meet our' }} <em>{{ app()->getLocale() == 'bn' ? '' : 'team' }}</em></h2>
        <p class="section-subtitle">{{ app()->getLocale() == 'bn' ? 'যাদের কঠোর পরিশ্রমে আমরা এগিয়ে চলছি' : 'The visionary minds driving our mission forward' }}</p>
      </div>
      
      <div class="team-grid">
        <div class="modern-team-card">
          <div class="team-img-wrapper">
            <div class="team-avatar-placeholder">AS</div>
            <div class="social-overlay">
              <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
              <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
            </div>
          </div>
          <div class="team-info">
            <h3>Ayman Sadiq</h3>
            <p>Founder & CEO</p>
          </div>
        </div>

        <div class="modern-team-card">
          <div class="team-img-wrapper">
            <div class="team-avatar-placeholder">SR</div>
            <div class="social-overlay">
              <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
              <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
            </div>
          </div>
          <div class="team-info">
            <h3>Sajid Rahman</h3>
            <p>CTO</p>
          </div>
        </div>

        <div class="modern-team-card">
          <div class="team-img-wrapper">
            <div class="team-avatar-placeholder">NK</div>
            <div class="social-overlay">
              <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
              <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
            </div>
          </div>
          <div class="team-info">
            <h3>Nayeem Khan</h3>
            <p>Head of Content</p>
          </div>
        </div>

        <div class="modern-team-card">
          <div class="team-img-wrapper">
            <div class="team-avatar-placeholder">FH</div>
            <div class="social-overlay">
              <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
              <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
            </div>
          </div>
          <div class="team-info">
            <h3>Faria Hossain</h3>
            <p>Head of Design</p>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection

@push('css')
<style>
  /* About Hero */
  .about-hero {
    background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
    padding: 120px 0 160px;
    position: relative;
    overflow: hidden;
    color: #fff;
    text-align: center;
  }
  .about-hero-content {
    max-width: 800px;
    margin: 0 auto;
    position: relative;
    z-index: 2;
  }
  .about-hero .eyebrow {
    display: inline-block;
    background: rgba(255,255,255,0.1);
    padding: 6px 18px;
    border-radius: 50px;
    font-size: 14px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 20px;
    border: 1px solid rgba(255,255,255,0.2);
  }
  .about-hero h1 {
    font-size: clamp(2.5rem, 6vw, 4rem);
    font-weight: 800;
    line-height: 1.1;
    margin-bottom: 24px;
  }
  .about-hero p {
    font-size: 1.2rem;
    opacity: 0.9;
    max-width: 600px;
    margin: 0 auto;
  }
  .hero-shape {
    position: absolute;
    bottom: -1px;
    left: 0;
    width: 100%;
    height: 100px;
    background: #fff;
    clip-path: polygon(0 100%, 100% 100%, 100% 0);
    z-index: 1;
  }

  /* Story Section */
  .about-story { padding: 100px 0; }
  .section-title-alt {
    font-size: 36px;
    font-weight: 800;
    color: var(--primary);
    margin-bottom: 25px;
    position: relative;
  }
  .section-title-alt::after {
    content: '';
    display: block;
    width: 60px;
    height: 4px;
    background: var(--accent);
    margin-top: 15px;
    border-radius: 2px;
  }
  .story-text {
    font-size: 17px;
    line-height: 1.8;
    color: var(--text-soft);
  }
  .story-text p { margin-bottom: 20px; }

  /* Mission Card */
  .mission-card-wrapper {
    position: relative;
    padding: 20px;
  }
  .mission-card {
    background: #fff;
    padding: 50px 40px;
    border-radius: 24px;
    box-shadow: 0 25px 50px -12px rgba(0,0,0,0.1);
    position: relative;
    z-index: 2;
    text-align: center;
    border: 1px solid var(--border);
  }
  .mission-icon {
    width: 80px;
    height: 80px;
    background: var(--accent-light);
    color: var(--accent);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    border-radius: 20px;
    margin: 0 auto 30px;
  }
  .mission-card h3 {
    font-size: 24px;
    font-weight: 800;
    margin-bottom: 15px;
    color: var(--primary);
  }
  .mission-card p {
    color: var(--text-soft);
    line-height: 1.7;
    margin: 0;
  }
  .mission-decoration {
    position: absolute;
    top: -10px;
    right: -10px;
    width: 100px;
    height: 100px;
    background: var(--accent);
    opacity: 0.1;
    border-radius: 24px;
    z-index: 1;
  }

  /* Impact Section */
  .impact-section { background: var(--bg-soft); }
  .section-subtitle {
    color: var(--text-muted);
    font-size: 16px;
    margin-top: -15px;
    margin-bottom: 50px;
  }
  .impact-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
  }
  .impact-item {
    background: #fff;
    padding: 40px;
    border-radius: 20px;
    display: flex;
    align-items: flex-start;
    gap: 20px;
    transition: all 0.3s;
    border: 1px solid transparent;
  }
  .impact-item:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.05);
    border-color: var(--accent-light);
  }
  .impact-icon {
    font-size: 36px;
    color: var(--accent);
    opacity: 0.8;
  }
  .impact-body h3 {
    font-size: 28px;
    font-weight: 800;
    color: var(--primary);
    margin-bottom: 5px;
  }
  .impact-body p {
    font-size: 15px;
    color: var(--text-soft);
    margin: 0;
  }

  /* Modern Testimonials */
  .about-testimonials { padding-bottom: 80px; }
  .testimonials-grid-modern {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
  }
  .testimonial-card-modern {
    background: #fff;
    padding: 40px;
    border-radius: 24px;
    position: relative;
    box-shadow: 0 10px 30px rgba(0,0,0,0.03);
    border: 1px solid var(--border);
    transition: all 0.3s;
  }
  .testimonial-card-modern:hover {
    transform: translateY(-5px);
    border-color: var(--accent);
  }
  .quote-mark {
    position: absolute;
    top: 20px;
    right: 30px;
    font-size: 40px;
    color: var(--accent);
    opacity: 0.1;
  }
  .test-content {
    font-size: 15px;
    line-height: 1.8;
    color: var(--text-soft);
    font-style: italic;
    margin-bottom: 25px;
  }
  .test-author {
    display: flex;
    align-items: center;
    gap: 15px;
    border-top: 1px solid var(--bg-soft);
    padding-top: 20px;
  }
  .test-author img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
  }
  .author-info h4 {
    font-size: 16px;
    color: var(--primary);
    margin: 0;
    font-weight: 700;
  }
  .author-info span {
    font-size: 12px;
    color: var(--text-muted);
  }

  /* Modern Team Cards */
  .team-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 30px;
  }
  .modern-team-card {
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.3s;
    text-align: center;
    border: 1px solid var(--border);
  }
  .modern-team-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.08);
  }
  .team-img-wrapper {
    position: relative;
    background: var(--bg-muted);
    aspect-ratio: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
  }
  .team-avatar-placeholder {
    font-size: 64px;
    font-weight: 800;
    color: var(--primary);
    opacity: 0.15;
  }
  .social-overlay {
    position: absolute;
    bottom: -50px;
    left: 0;
    width: 100%;
    padding: 15px;
    background: linear-gradient(to top, rgba(0,0,0,0.6), transparent);
    display: flex;
    justify-content: center;
    gap: 15px;
    transition: all 0.3s;
  }
  .modern-team-card:hover .social-overlay { bottom: 0; }
  .social-overlay a {
    width: 36px;
    height: 36px;
    background: #fff;
    color: var(--primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    transition: all 0.2s;
  }
  .social-overlay a:hover {
    background: var(--accent);
    color: #fff;
    transform: scale(1.1);
  }
  .team-info { padding: 25px 20px; }
  .team-info h3 {
    font-size: 18px;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 5px;
  }
  .team-info p {
    font-size: 14px;
    color: var(--text-muted);
    margin: 0;
  }

  @media (max-width: 992px) {
    .team-grid { grid-template-columns: repeat(2, 1fr); }
    .impact-grid { grid-template-columns: 1fr; }
    .about-hero { padding: 80px 0 120px; }
    .testimonials-grid-modern { grid-template-columns: repeat(2, 1fr); }
  }
  @media (max-width: 768px) {
    .testimonials-grid-modern { grid-template-columns: 1fr; }
  }
  @media (max-width: 576px) {
    .team-grid { grid-template-columns: 1fr; }
    .about-hero h1 { font-size: 2.5rem; }
  }
</style>
@endpush

@push('js')
<script>
$(document).ready(function() {
    $('.read-more-toggle').on('click', function() {
        const $container = $(this).closest('.test-content');
        const $shortText = $container.find('.text-short');
        const $fullText = $container.find('.text-full');
        const isExpanded = $fullText.is(':visible');

        if (isExpanded) {
            $fullText.hide();
            $shortText.show();
            $(this).text("{{ app()->getLocale() == 'bn' ? 'আরও পড়ুন' : 'Read More' }}");
        } else {
            $shortText.hide();
            $fullText.show();
            $(this).text("{{ app()->getLocale() == 'bn' ? 'সংক্ষেপ করুন' : 'Read Less' }}");
        }
    });
});
</script>
@endpush
