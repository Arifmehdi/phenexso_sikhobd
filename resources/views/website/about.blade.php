@extends('website.layouts.sikhobd')

@section('title', ($content->title ?? 'আমাদের সম্পর্কে') . ' — ' . ($ws->name ?? env('APP_NAME')))

@section('meta')
<meta name="description" content="{{ $content->meta_description ?? ($ws->meta_description ?? 'Learn more about ' . ($ws->name ?? env('APP_NAME'))) }}">
<meta name="keywords" content="{{ $content->meta_keywords ?? ($ws->meta_keywords ?? 'about, education, learning') }}">
@endsection

@section('content')
<main>
  <section class="page-hero">
    <div class="container">
      <h1 data-i18n="page.about.title">{{ $content->title ?? 'আমাদের সম্পর্কে' }}</h1>
      <p data-i18n="page.about.sub">{{ $content->subtitle ?? 'শিক্ষা সবার জন্য — এই বিশ্বাস থেকেই আমাদের যাত্রা শুরু' }}</p>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <div class="about-grid">
        <div>
          <h2>{{ $content->meta['story_title'] ?? 'Our Story' }}</h2>
          <div class="mb-4">
              {!! $content->description ?? '<p>10 Minute School started in 2015 with a simple goal — make quality education accessible to everyone in Bangladesh, regardless of where they live or how much they can afford.</p><p>Today we are the largest online learning platform in the country, with over 2.4 million students and 1000+ courses spanning academic subjects, skills, languages and admission preparation.</p>' !!}
          </div>
          <a href="{{ route('contact') }}" class="btn btn-primary" style="margin-top:16px;">Get in touch</a>
        </div>
        <div class="hero-card" style="aspect-ratio: 1;">
          <h3>{{ $content->meta['mission_title'] ?? 'Mission' }}</h3>
          <p style="opacity:.85;">{{ $content->meta['mission_description'] ?? 'Empower every student in Bangladesh with world-class learning tools.' }}</p>
        </div>
      </div>
    </div>
  </section>

  <section class="section features">
    <div class="container">
      <div class="section-head"><h2>Our <em>impact</em></h2></div>
      <div class="features-grid">
        <div class="feature">
            <div class="feature-icon"><i class="fa-solid fa-users"></i></div>
            <h3>2.4M+ Students</h3>
            <p>Across 64 districts of Bangladesh.</p>
        </div>
        <div class="feature">
            <div class="feature-icon"><i class="fa-solid fa-graduation-cap"></i></div>
            <h3>1000+ Courses</h3>
            <p>From Class 6 to professional skills.</p>
        </div>
        <div class="feature">
            <div class="feature-icon"><i class="fa-solid fa-trophy"></i></div>
            <h3>15 Awards</h3>
            <p>National & international recognition.</p>
        </div>
      </div>
    </div>
  </section>

  @if(isset($testimonials) && $testimonials->count() > 0)
  <section class="section">
    <div class="container">
        <div class="section-head"><h2>What our <em>students</em> say</h2></div>
        <div class="courses-grid" style="grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));">
            @foreach($testimonials as $testimonial)
            <div class="course-card" style="padding: 24px;">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <img src="{{ asset('storage/' . ($testimonial->image ?? 'default.png')) }}" alt="{{ $testimonial->name }}" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                    <div>
                        <h4 style="font-size: 16px; margin: 0; color: var(--primary);">{{ $testimonial->name }}</h4>
                        <span style="font-size: 12px; color: var(--text-muted);">{{ $testimonial->designation }}</span>
                    </div>
                </div>
                <p style="font-size: 14px; color: var(--text-soft); font-style: italic;">
                    "{!! strip_tags($testimonial->text_en) !!}"
                </p>
            </div>
            @endforeach
        </div>
    </div>
  </section>
  @endif

  <section class="section bg-soft">
    <div class="container">
      <div class="section-head"><h2>Meet our <em>team</em></h2></div>
      <div class="team-grid">
        <div class="team-card"><div class="avatar">AS</div><h3>Ayman Sadiq</h3><p>Founder & CEO</p></div>
        <div class="team-card"><div class="avatar">SR</div><h3>Sajid Rahman</h3><p>CTO</p></div>
        <div class="team-card"><div class="avatar">NK</div><h3>Nayeem Khan</h3><p>Head of Content</p></div>
        <div class="team-card"><div class="avatar">FH</div><h3>Faria Hossain</h3><p>Head of Design</p></div>
      </div>
    </div>
  </section>
</main>
@endsection

@push('js')
{{-- Add any page-specific JS here --}}
@endpush
