@extends('website.layouts.sikhobd')

@section('title', 'কোর্স ডিটেলস — ' . ($ws->name ?? env('APP_NAME')))

@section('content')
  <section class="section">
    <div class="container">
      <div class="cd-grid">
        <div>
          <div class="crumbs" style="margin-bottom: 16px;">
            <a href="{{ route('home') }}">Home</a> <span>/</span>
            <a href="{{ route('courses') }}" data-i18n="nav.courses">কোর্সসমূহ</a> <span>/</span>
            <span>HSC 2026</span>
          </div>
          <h1 style="color: var(--primary); font-size: 32px; margin-bottom: 12px;">HSC 2026 Online Batch — Science</h1>
          <div class="course-meta" style="margin-bottom: 24px;">
            <span><i class="fa-solid fa-star"></i> 4.9 (1.2k reviews)</span>
            <span><i class="fa-solid fa-users"></i> 12,400 students</span>
            <span><i class="fa-solid fa-clock"></i> 200 hours</span>
            <span><i class="fa-solid fa-certificate"></i> Certificate</span>
          </div>

          <div class="cd-hero">
            <div class="play"><i class="fa-solid fa-play"></i></div>
          </div>

          <div class="cd-tabs">
            <button class="active" data-tab="overview">Overview</button>
            <button data-tab="curriculum">Curriculum</button>
            <button data-tab="instructor">Instructor</button>
            <button data-tab="reviews">Reviews</button>
          </div>

          <div data-tab-content="overview" style="display:block;">
            <h3 style="color:var(--primary); margin-bottom:12px;">About this course</h3>
            <p style="color:var(--text-soft); margin-bottom:16px;">A complete HSC 2026 preparation course covering Physics, Chemistry, Math and Biology. Live classes, recorded videos, weekly model tests and one-to-one doubt clearing.</p>
            <h3 style="color:var(--primary); margin:20px 0 12px;">What you'll learn</h3>
            <ul style="display:grid; grid-template-columns:1fr 1fr; gap:8px; color:var(--text-soft); font-size:14px;">
              <li><i class="fa-solid fa-check" style="color:var(--success);"></i> Full HSC syllabus</li>
              <li><i class="fa-solid fa-check" style="color:var(--success);"></i> 500+ practice problems</li>
              <li><i class="fa-solid fa-check" style="color:var(--success);"></i> Weekly mock exams</li>
              <li><i class="fa-solid fa-check" style="color:var(--success);"></i> Doubt support 24/7</li>
              <li><i class="fa-solid fa-check" style="color:var(--success);"></i> Printed lecture sheets</li>
              <li><i class="fa-solid fa-check" style="color:var(--success);"></i> Admission test prep bonus</li>
            </ul>
          </div>

          <div data-tab-content="curriculum" style="display:none;">
            <h3 style="color:var(--primary); margin-bottom:16px;">Course curriculum</h3>
            <div class="lesson"><div class="num">1</div><div><h4>Introduction to Physics</h4><div class="dur">12 lessons</div></div><span class="dur">2h 30m</span></div>
            <div class="lesson"><div class="num">2</div><div><h4>Motion & Force</h4><div class="dur">18 lessons</div></div><span class="dur">4h 10m</span></div>
            <div class="lesson"><div class="num">3</div><div><h4>Work, Energy & Power</h4><div class="dur">15 lessons</div></div><span class="dur">3h 20m</span></div>
            <div class="lesson"><div class="num">4</div><div><h4>Heat & Thermodynamics</h4><div class="dur">14 lessons</div></div><span class="dur">3h 45m</span></div>
            <div class="lesson"><div class="num">5</div><div><h4>Electricity & Magnetism</h4><div class="dur">22 lessons</div></div><span class="dur">5h 30m</span></div>
          </div>

          <div data-tab-content="instructor" style="display:none;">
            <div style="display:flex; gap:20px; align-items:center; padding:24px; background:var(--bg-soft); border-radius:var(--radius-lg);">
              <div class="avatar" style="margin:0;">AR</div>
              <div>
                <h3 style="color:var(--primary);">Dr. Ayman Sadiq</h3>
                <p style="color:var(--text-muted); font-size:14px;">Founder & Lead Instructor</p>
                <p style="color:var(--text-soft); margin-top:8px; font-size:14px;">15+ years of teaching experience. Has taught over 1M students across Bangladesh.</p>
              </div>
            </div>
          </div>

          <div data-tab-content="reviews" style="display:none;">
            <p style="color:var(--text-soft);">★★★★★ Excellent course! Cleared all my doubts. — Rakib H.</p>
          </div>
        </div>

        <aside class="cd-buy">
          <div><span class="price">৳ 6,500</span> <span class="old-price">৳ 9,000</span></div>
          <div style="margin-top:6px; color:var(--accent); font-size:13px; font-weight:600;">28% OFF — limited time</div>
          <a href="#" class="btn btn-accent" style="width:100%; justify-content:center; margin-top:20px;" data-i18n="enroll">এনরোল</a>
          <a href="#" class="btn btn-outline" style="width:100%; justify-content:center; margin-top:8px;">Add to Wishlist</a>
          <ul>
            <li><i class="fa-solid fa-video"></i> 200 hours of video</li>
            <li><i class="fa-solid fa-file"></i> 80 PDF resources</li>
            <li><i class="fa-solid fa-infinity"></i> Lifetime access</li>
            <li><i class="fa-solid fa-mobile-screen"></i> Mobile & TV access</li>
            <li><i class="fa-solid fa-certificate"></i> Certificate on completion</li>
          </ul>
        </aside>
      </div>
    </div>
  </section>
@endsection
