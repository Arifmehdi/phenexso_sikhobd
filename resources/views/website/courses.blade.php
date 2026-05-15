@extends('website.layouts.sikhobd')

@section('title', 'কোর্সসমূহ — ' . ($ws->name ?? env('APP_NAME')))

@section('content')
  <section class="page-hero">
    <div class="container">
      <h1 data-i18n="page.courses.title">সকল কোর্স</h1>
      <p data-i18n="page.courses.sub">১০০০+ কোর্স — আপনার পছন্দ অনুযায়ী বেছে নিন</p>
      <div class="crumbs">
        <a href="{{ route('home') }}">Home</a> <span>/</span> <span data-i18n="nav.courses">কোর্সসমূহ</span>
      </div>
    </div>
  </section>

  <section class="section" style="padding-top: 40px;">
    <div class="container">
      <div class="courses-layout">
        <aside class="filter-side">
          <h3 style="color:var(--primary); margin-bottom:16px; font-size:16px;" data-i18n="filter">ফিল্টার</h3>
          <form action="{{ route('courses') }}" method="GET">
            <div class="filter-group">
              <h4 data-i18n="category">ক্যাটাগরি</h4>
              @foreach($categories as $cat)
                <label>
                  <input type="checkbox" name="category[]" value="{{ $cat->slug }}" 
                    {{ (is_array(request('category')) && in_array($cat->slug, request('category'))) || request('category') == $cat->slug ? 'checked' : '' }}> 
                  <span>{{ app()->getLocale() == 'bn' ? $cat->name_bn : $cat->name_en }}</span>
                </label>
              @endforeach
            </div>
            <div class="filter-group">
              <h4 data-i18n="price.range">মূল্য</h4>
              <label><input type="radio" name="price" value="all" {{ request('price') == 'all' || !request('price') ? 'checked' : '' }}> <span data-i18n="all">সব</span></label>
              <label><input type="radio" name="price" value="free" {{ request('price') == 'free' ? 'checked' : '' }}> Free</label>
              <label><input type="radio" name="price" value="1k-5k" {{ request('price') == '1k-5k' ? 'checked' : '' }}> ৳ 1k - 5k</label>
              <label><input type="radio" name="price" value="5k-plus" {{ request('price') == '5k-plus' ? 'checked' : '' }}> ৳ 5k+</label>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;">Apply</button>
          </form>
        </aside>

        <div>
          <div class="courses-grid">
            @forelse($courses as $course)
              <article class="course-card">
                <div class="course-thumb" style="--c1:#6c5ce7;--c2:#a29bfe;">
                  @if($course->feature)
                    <span class="course-tag">FEATURED</span>
                  @endif
                  <img src="{{ route('imagecache', ['template' => 'medium', 'filename' => $course->fi()]) }}" alt="{{ $course->name_en }}" style="width:100%; height:100%; object-fit:cover; border-radius:12px 12px 0 0;">
                </div>
                <div class="course-body">
                  <h3>{{ app()->getLocale() == 'bn' ? $course->name_bn : $course->name_en }}</h3>
                  <div class="course-meta">
                    <span><i class="fa-solid fa-star"></i> {{ number_format($course->averageRating(), 1) }}</span>
                    <span><i class="fa-solid fa-users"></i> {{ $course->click_count }} views</span>
                  </div>
                  <div class="course-foot">
                    <div>
                      @if($course->isFree())
                        <span class="price">Free</span>
                      @else
                        <span class="price">৳ {{ number_format($course->final_price) }}</span>
                      @endif
                    </div>
                    <a href="{{ route('productDetails', $course->slug) }}" class="btn btn-accent btn-sm" data-i18n="enroll">এনরোল</a>
                  </div>
                </div>
              </article>
            @empty
              <p>No courses found.</p>
            @endforelse
          </div>
          <div style="margin-top: 30px;">
            {{ $courses->links() }}
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
