@extends('website.layouts.sikhobd')

@section('title', 'কোর্সসমূহ — ' . ($ws->website_title ?? 'Qalam HR'))

@section('meta')
<meta name="description" content="Explore quality e-learning courses at {{ $ws->website_title ?? 'Qalam HR' }}.">
<meta name="keywords" content="Courses, {{ $ws->website_title ?? 'Qalam HR' }}, E-learning, Education">
@endsection

@push('css')
<style>
    .courses-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
    @media (max-width: 1100px) { .courses-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 600px)  { .courses-grid { grid-template-columns: 1fr; } }

    /* ---- Enrollment-style e-learning card ---- */
    .elearn-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        position: relative;
        transition: transform .3s ease, box-shadow .3s ease;
    }
    .elearn-card:hover { transform: translateY(-6px); box-shadow: 0 16px 34px rgba(0,0,0,0.10); border-color: transparent; }

    .elearn-thumb { aspect-ratio: 14 / 15; background: #eef2f7; position: relative; overflow: hidden; }
    .elearn-thumb img { width: 100%; height: 100%; object-fit: cover; transition: transform .35s ease; }
    .elearn-card:hover .elearn-thumb img { transform: scale(1.06); }

    .elearn-tag {
        position: absolute; top: 12px; left: 12px;
        background: var(--primary); color: #fff;
        font-size: 10px; font-weight: 700; letter-spacing: .5px; text-transform: uppercase;
        padding: 4px 10px; border-radius: 20px; z-index: 5;
        max-width: 65%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .elearn-tag.featured { background: var(--accent); }

    .elearn-actions {
        position: absolute; top: 12px; right: 12px;
        display: flex; flex-direction: column; gap: 8px; z-index: 6;
        opacity: 0; transform: translateX(8px); transition: all .3s ease;
    }
    .elearn-card:hover .elearn-actions { opacity: 1; transform: translateX(0); }
    .elearn-icon-btn {
        width: 36px; height: 36px; border-radius: 50%;
        background: #fff; color: var(--primary); border: 1px solid var(--border);
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,.08); transition: all .2s ease;
        text-decoration: none;
    }
    .elearn-icon-btn:hover { background: var(--accent); color: #fff; border-color: var(--accent); }

    .elearn-body { padding: 16px; display: flex; flex-direction: column; flex: 1; }
    .elearn-cat { font-size: 11px; color: var(--accent); font-weight: 700; text-transform: uppercase; letter-spacing: .5px; }
    .elearn-body h3 { margin: 6px 0 8px; font-size: 15px; font-weight: 700; line-height: 1.4; }
    .elearn-body h3 a { color: inherit; text-decoration: none; }
    .elearn-body h3 a:hover { color: var(--accent); }
    .elearn-meta { display: flex; flex-wrap: wrap; gap: 14px; font-size: 12px; color: var(--text-muted); margin-bottom: 10px; }
    .elearn-meta i { color: var(--accent); margin-right: 3px; }

    .elearn-foot { display: flex; align-items: center; justify-content: space-between; gap: 8px; margin-top: auto; padding-top: 12px; border-top: 1px solid var(--border); }
    .elearn-price { font-size: 19px; font-weight: 800; color: var(--accent); }
    .elearn-price.free { color: #16a34a; }
    .elearn-enroll-btn {
        height: 38px; padding: 0 16px; border: none; border-radius: 9px;
        background: var(--accent); color: #fff; font-weight: 700; font-size: 13px;
        display: inline-flex; align-items: center; justify-content: center; gap: 6px;
        cursor: pointer; text-decoration: none; white-space: nowrap; transition: all .25s ease;
    }
    .elearn-enroll-btn:hover { background: var(--primary); color: #fff; transform: translateY(-2px); box-shadow: 0 6px 16px rgba(0,0,0,.15); }
</style>
@endpush

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
              <h4 data-i18n="category">{{ __('category') }}</h4>
              @foreach($categories as $cat)
                <div class="category-filter-item" style="margin-bottom: 8px;">
                    <label style="font-weight: 600; display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="checkbox" name="category[]" value="{{ $cat->slug }}" 
                            {{ in_array($cat->slug, (array)request('category')) ? 'checked' : '' }}
                            onchange="document.getElementById('filter-form').submit()"> 
                        <span>{{ lp($cat, 'name') }}</span>
                    </label>
                    
                    @if($cat->children->count() > 0)
                        <div class="subcategories" style="margin-left: 20px; margin-top: 4px; display: flex; flex-direction: column; gap: 4px;">
                            @foreach($cat->children as $subcat)
                                <label style="font-weight: 400; font-size: 13px; display: flex; align-items: center; gap: 8px; cursor: pointer; color: var(--text-soft);">
                                    <input type="checkbox" name="category[]" value="{{ $subcat->slug }}" 
                                        {{ in_array($subcat->slug, (array)request('category')) ? 'checked' : '' }}
                                        onchange="document.getElementById('filter-form').submit()"> 
                                    <span>{{ lp($subcat, 'name') }}</span>
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
              @php $courseCat = optional($course->categories->first()); @endphp
              <article class="elearn-card">
                <div class="elearn-thumb">
                  @if($course->feature)
                    <span class="elearn-tag featured">FEATURED</span>
                  @elseif($courseCat->id)
                    <span class="elearn-tag">{{ lp($courseCat, 'name') }}</span>
                  @endif

                  <div class="elearn-actions">
                    <button class="elearn-icon-btn add-to-wishlist-ajax" data-id="{{ $course->id }}" title="উইশলিস্টে যোগ করুন">
                      <i class="fa-regular fa-heart"></i>
                    </button>
                    <a href="{{ route('courseDetail', $course->slug) }}" class="elearn-icon-btn" title="বিস্তারিত দেখুন">
                      <i class="fa-regular fa-eye"></i>
                    </a>
                  </div>

                  <a href="{{ route('courseDetail', $course->slug) }}" style="display:block; width:100%; height:100%;">
                    <img src="{{ route('imagecache', ['template' => 'medium', 'filename' => $course->fi()]) }}" alt="{{ $course->name_en }}">
                  </a>
                </div>

                <div class="elearn-body">
                  @if($courseCat->id)
                    <span class="elearn-cat">{{ lp($courseCat, 'name') }}</span>
                  @endif
                  <h3>
                    <a href="{{ route('courseDetail', $course->slug) }}">{{ app()->getLocale() == 'bn' ? ($course->name_bn ?? $course->name_en) : $course->name_en }}</a>
                  </h3>
                  <div class="elearn-meta">
                    <span><i class="fa-solid fa-star"></i> {{ number_format($course->averageRating(), 1) }}</span>
                    <span><i class="fa-solid fa-users"></i> {{ $course->click_count }}</span>
                    @if($course->instructor)
                      <span><i class="fa-solid fa-chalkboard-user"></i> {{ Str::limit($course->instructor->name, 14) }}</span>
                    @elseif($course->duration)
                      <span><i class="fa-regular fa-clock"></i> {{ $course->duration }}</span>
                    @endif
                  </div>

                  <div class="elearn-foot">
                    @if($course->isFree())
                      <span class="elearn-price free">Free</span>
                    @else
                      <span class="elearn-price">৳ {{ number_format($course->selling_price) }}</span>
                    @endif
                    @if(in_array($course->id, $enrolledCourseIds ?? []))
                      <a href="{{ route('course.play', $course->slug) }}" class="elearn-enroll-btn" style="background:#16a34a;">
                        <i class="fa-solid fa-play"></i> কোর্স শুরু করুন
                      </a>
                    @elseif(in_array($course->id, $cartCourseIds ?? []))
                      <a href="{{ route('cart') }}" class="elearn-enroll-btn" style="background:#0ea5e9;">
                        <i class="fa-solid fa-cart-shopping"></i> কার্টে আছে
                      </a>
                    @else
                      <a href="#" class="elearn-enroll-btn enroll-now-btn" data-id="{{ $course->id }}">
                        <i class="fa-solid fa-graduation-cap"></i> এনরোল করুন
                      </a>
                    @endif
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

@push('js')
<script>
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

    // Enroll Now — add course to cart and go to checkout (same flow as the home enroll form)
    $(document).on('click', '.enroll-now-btn', function(e) {
        e.preventDefault();
        var btn = $(this);
        var id = btn.data('id');
        if (btn.hasClass('disabled')) return;
        var original = btn.html();
        btn.addClass('disabled').html('<i class="fa-solid fa-spinner fa-spin"></i>');

        $.ajax({
            url: "{{ route('addToCart') }}",
            type: "POST",
            data: { product: id, qty: 1, _token: "{{ csrf_token() }}" },
            success: function(res) {
                if (res && (res.status || res.success)) {
                    if (typeof res.cartCount !== 'undefined') $('.cartCount').text(res.cartCount);
                    showCartNotification(res.message || 'Course added to cart!', 'success');
                    setTimeout(function(){ window.location.href = "{{ route('cart') }}"; }, 700);
                } else {
                    btn.removeClass('disabled').html(original);
                    showCartNotification((res && res.message) || 'Something went wrong.', 'error');
                }
            },
            error: function() {
                btn.removeClass('disabled').html(original);
                showCartNotification('Failed to enroll. Please try again.', 'error');
            }
        });
    });
</script>
@endpush
