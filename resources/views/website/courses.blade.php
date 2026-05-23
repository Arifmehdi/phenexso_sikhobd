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
                        <span class="price">৳ {{ number_format($course->selling_price) }}</span>
                      @endif
                    </div>
                    <div style="display: flex; gap: 8px;">
                        <button class="btn btn-outline btn-sm add-to-wishlist-ajax" data-id="{{ $course->id }}" title="Add to Wishlist">
                            <i class="fa-regular fa-heart"></i>
                        </button>
                        <a href="{{ route('courseDetail', $course->slug) }}" class="btn btn-accent btn-sm" data-i18n="enroll">এনরোল</a>
                    </div>
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
</script>
@endpush
