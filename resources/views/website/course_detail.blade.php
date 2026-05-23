@extends('website.layouts.sikhobd')

@section('title', (lp($product, 'name') ?? 'Course Details') . ' — ' . ($ws->name ?? env('APP_NAME')))

@section('content')
  <section class="section">
    <div class="container">
      <div class="cd-grid">
        <div>
          <div class="crumbs" style="margin-bottom: 16px;">
            <a href="{{ route('home') }}">Home</a> <span>/</span>
            <a href="{{ route('courses') }}" data-i18n="nav.courses">{{ __('nav.courses') }}</a> <span>/</span>
            <span>{{ lp($product, 'name') }}</span>
          </div>
          <h1 style="color: var(--primary); font-size: 32px; margin-bottom: 12px;">{{ lp($product, 'name') }}</h1>
          <div class="course-meta" style="margin-bottom: 24px;">
            <span><i class="fa-solid fa-star"></i> {{ number_format($product->averageRating(), 1) }} ({{ $product->reviews->count() }} reviews)</span>
            <span><i class="fa-solid fa-users"></i> {{ $product->enrollments->count() }} students</span>
            <span><i class="fa-solid fa-clock"></i> {{ $product->duration ?? 'Self-paced' }}</span>
            <span><i class="fa-solid fa-certificate"></i> Certificate</span>
          </div>

          <div class="cd-hero" style="background-image: url('{{ route('imagecache', ['template' => 'large', 'filename' => $product->fi()]) }}'); background-size: cover; background-position: center; position: relative;">
            <div class="play"><i class="fa-solid fa-play"></i></div>
          </div>

          <div class="cd-tabs">
            <button class="active" data-tab="overview">{{ __('overview') }}</button>
            <button data-tab="curriculum">{{ __('curriculum') }}</button>
            <button data-tab="instructor">{{ __('instructor') }}</button>
            <button data-tab="reviews">{{ __('reviews') }}</button>
          </div>

          <div data-tab-content="overview" style="display:block;">
            <h3 style="color:var(--primary); margin-bottom:12px;">About this course</h3>
            <div style="color:var(--text-soft); margin-bottom:16px;">
                {!! lp($product, 'description') !!}
            </div>
            @if(lp($product, 'excerpt'))
                <h3 style="color:var(--primary); margin:20px 0 12px;">Course Highlights</h3>
                <p style="color:var(--text-soft);">{{ lp($product, 'excerpt') }}</p>
            @endif
          </div>

          <div data-tab-content="curriculum" style="display:none;">
            <h3 style="color:var(--primary); margin-bottom:16px;">Course curriculum</h3>
            @php
                $lessons = \App\Models\CourseLesson::where('product_id', $product->id)->orderBy('priority')->get();
            @endphp
            @forelse($lessons as $index => $lesson)
                <div class="lesson">
                    <div class="num">{{ $index + 1 }}</div>
                    <div>
                        <h4>{{ lp($lesson, 'title') }}</h4>
                        <div class="dur">{{ $lesson->is_free ? 'Free Preview' : 'Premium Content' }}</div>
                    </div>
                    <span class="dur">{{ $lesson->duration }}</span>
                </div>
            @empty
                <p style="color:var(--text-soft);">Curriculum is being updated. Stay tuned!</p>
            @endforelse
          </div>

          <div data-tab-content="instructor" style="display:none;">
            @if($product->instructor)
                <div style="display:flex; gap:20px; align-items:center; padding:24px; background:var(--bg-soft); border-radius:var(--radius-lg);">
                  <div class="avatar" style="margin:0; background-image: url('{{ $product->instructor->image ? asset('storage/user_images/' . $product->instructor->image) : '' }}'); background-size: cover;">
                    @if(!$product->instructor->image)
                        {{ strtoupper(substr($product->instructor->name, 0, 2)) }}
                    @endif
                  </div>
                  <div>
                    <h3 style="color:var(--primary);">{{ $product->instructor->name }}</h3>
                    <p style="color:var(--text-muted); font-size:14px;">{{ $product->instructor->designation ?? 'Professional Instructor' }}</p>
                    <p style="color:var(--text-soft); margin-top:8px; font-size:14px;">{{ $product->instructor->bio ?? 'Expert in the field with years of teaching experience.' }}</p>
                  </div>
                </div>
            @else
                <p style="color:var(--text-soft);">Instructor information not available.</p>
            @endif
          </div>

          <div data-tab-content="reviews" style="display:none;">
            @forelse($product->reviews as $review)
                <div style="margin-bottom: 15px; padding-bottom: 10px; border-bottom: 1px solid var(--bg-soft);">
                    <p style="color:var(--text-soft);">
                        @for($i=1; $i<=5; $i++)
                            <i class="fa-solid fa-star" style="color: {{ $i <= $review->rating ? '#ffc107' : '#e4e5e9' }}"></i>
                        @endfor
                        <strong>{{ $review->user->name ?? 'Student' }}</strong>
                    </p>
                    <p style="color:var(--text-soft); margin-top: 5px;">{{ $review->comment }}</p>
                </div>
            @empty
                <p style="color:var(--text-soft);">No reviews yet. Be the first to review!</p>
            @endforelse
          </div>
        </div>

        <aside class="cd-buy">
          <div>
            @if($product->discount > 0)
                <span class="price">৳ {{ number_format($product->selling_price, 0) }}</span> 
                <span class="old-price">৳ {{ number_format($product->price ?: ($product->selling_price + $product->discount), 0) }}</span>
            @else
                <span class="price">৳ {{ number_format($product->selling_price, 0) }}</span>
            @endif
          </div>
          @if($product->discount > 0)
            <div style="margin-top:6px; color:var(--accent); font-size:13px; font-weight:600;">
                {{ round(($product->discount / ($product->price ?: ($product->selling_price + $product->discount))) * 100) }}% OFF — limited time
            </div>
          @endif

          @php
            $isEnrolled = false;
            if(auth()->check()){
                $isEnrolled = \App\Models\Enrollment::where('user_id', auth()->id())->where('product_id', $product->id)->where('status', 'active')->exists();
            }
          @endphp

          @if($isEnrolled)
            <a href="{{ route('user.dashboard') }}#tab-courses" class="btn btn-primary" style="width:100%; justify-content:center; margin-top:20px;">কন্টিনিউ লার্নিং</a>
          @else
            <a href="{{ route('enroll', $product->slug) }}" class="btn btn-accent" style="width:100%; justify-content:center; margin-top:20px;" data-i18n="enroll">এনরোল</a>
          @endif
          
          <form id="add-to-wishlist-form">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <button type="button" class="btn btn-outline add-to-wishlist-btn" style="width:100%; justify-content:center; margin-top:8px;">Add to Wishlist</button>
          </form>

          <ul>
            <li><i class="fa-solid fa-video"></i> {{ $product->duration ?? 'Lifetime' }} content</li>
            <li><i class="fa-solid fa-file"></i> {{ $product->lessons_count ?? 0 }} Lessons</li>
            <li><i class="fa-solid fa-infinity"></i> Lifetime access</li>
            <li><i class="fa-solid fa-mobile-screen"></i> Mobile & TV access</li>
            <li><i class="fa-solid fa-certificate"></i> Certificate on completion</li>
          </ul>
        </aside>
      </div>
    </div>
  </section>
@endsection

@push('js')
<script>
    document.querySelectorAll('.cd-tabs button').forEach(button => {
        button.addEventListener('click', () => {
            const tab = button.getAttribute('data-tab');
            
            // Update buttons
            document.querySelectorAll('.cd-tabs button').forEach(b => b.classList.remove('active'));
            button.classList.add('active');
            
            // Update content
            document.querySelectorAll('[data-tab-content]').forEach(content => {
                content.style.display = content.getAttribute('data-tab-content') === tab ? 'block' : 'none';
            });
        });
    });

    $(document).on('click', '.add-to-wishlist-btn', function() {
        const productId = $('#add-to-wishlist-form input[name="product_id"]').val();
        const btn = $(this);
        
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');

        $.ajax({
            url: "{{ route('wishlist.add') }}",
            type: "POST",
            data: {
                product_id: productId,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                btn.prop('disabled', false).html('<i class="fa-solid fa-heart"></i> Added!');
                showCartNotification(response.message, 'success');
                setTimeout(() => {
                    btn.html('Add to Wishlist');
                }, 2000);
            },
            error: function() {
                btn.prop('disabled', false).html('Add to Wishlist');
                showCartNotification('Failed to add to wishlist.', 'error');
            }
        });
    });
</script>
@endpush
