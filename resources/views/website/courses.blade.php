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
          <form action="{{ route('courses') }}" method="GET" id="filter-form">
            <h3 style="color:var(--primary); margin-bottom:16px; font-size:16px;" data-i18n="filter">ফিল্টার</h3>
            
            <div class="filter-group">
              <h4 data-i18n="category">ক্যাটাগরি</h4>
              @foreach($categories as $cat)
                <div class="category-filter-item" style="margin-bottom: 8px;">
                    <label style="font-weight: 600; display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="checkbox" name="category[]" value="{{ $cat->slug }}" 
                            {{ in_array($cat->slug, (array)request('category')) ? 'checked' : '' }}
                            onchange="document.getElementById('filter-form').submit()"> 
                        <span>{{ $cat->name_en }}</span>
                    </label>
                    
                    @if($cat->children->count() > 0)
                        <div class="subcategories" style="margin-left: 20px; margin-top: 4px; display: flex; flex-direction: column; gap: 4px;">
                            @foreach($cat->children as $subcat)
                                <label style="font-weight: 400; font-size: 13px; display: flex; align-items: center; gap: 8px; cursor: pointer; color: var(--text-soft);">
                                    <input type="checkbox" name="category[]" value="{{ $subcat->slug }}" 
                                        {{ in_array($subcat->slug, (array)request('category')) ? 'checked' : '' }}
                                        onchange="document.getElementById('filter-form').submit()"> 
                                    <span>{{ $subcat->name_en }}</span>
                                </label>
                            @endforeach
                        </div>
                    @endif
                </div>
              @endforeach
            </div>

            <div class="filter-group">
              <h4 data-i18n="price.range">মূল্য</h4>
              <label>
                <input type="radio" name="price" value="" {{ !request('price') ? 'checked' : '' }} onchange="document.getElementById('filter-form').submit()"> 
                <span data-i18n="all">সব</span>
              </label>
              <label>
                <input type="radio" name="price" value="free" {{ request('price') == 'free' ? 'checked' : '' }} onchange="document.getElementById('filter-form').submit()"> 
                <span>Free</span>
              </label>
              <label>
                <input type="radio" name="price" value="1k-5k" {{ request('price') == '1k-5k' ? 'checked' : '' }} onchange="document.getElementById('filter-form').submit()"> 
                <span>৳ 1k - 5k</span>
              </label>
              <label>
                <input type="radio" name="price" value="5k-plus" {{ request('price') == '5k-plus' ? 'checked' : '' }} onchange="document.getElementById('filter-form').submit()"> 
                <span>৳ 5k+</span>
              </label>
            </div>
            
            <a href="{{ route('courses') }}" class="btn btn-outline" style="width:100%; margin-top:10px; text-align:center; display:block;">Clear All</a>
          </form>
        </aside>

        <div>
          <div class="courses-grid">
            @forelse($courses as $course)
                <article class="course-card">
                    <div class="course-thumb" style="background-image: url('{{ route('imagecache', ['template' => 'medium', 'filename' => $course->fi()]) }}'); background-size: cover; background-position: center;">
                        @if($course->feature)
                            <span class="course-tag">BESTSELLER</span>
                        @endif
                    </div>
                    <div class="course-body">
                        <h3>{{ $course->name_en }}</h3>
                        <div class="course-meta">
                            <span><i class="fa-solid fa-star"></i> {{ number_format($course->averageRating(), 1) }}</span>
                            <span><i class="fa-solid fa-users"></i> {{ $course->enrollments->count() }}</span>
                        </div>
                        <div class="course-foot">
                            <div>
                                @if($course->selling_price > 0)
                                    <span class="price">৳ {{ number_format($course->selling_price, 0) }}</span>
                                @else
                                    <span class="price">Free</span>
                                @endif
                            </div>
                            <a href="{{ route('courseDetail', $course->slug) }}" class="btn btn-accent btn-sm" data-i18n="enroll">বিস্তারিত</a>
                        </div>
                    </div>
                </article>
            @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 50px;">
                    <i class="fa-solid fa-graduation-cap" style="font-size: 48px; color: var(--bg-soft); margin-bottom: 20px;"></i>
                    <h3 style="color: var(--text-soft);">কোন কোর্স পাওয়া যায়নি</h3>
                </div>
            @endforelse
          </div>
          
          <div style="margin-top: 40px;">
            {{ $courses->links() }}
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
