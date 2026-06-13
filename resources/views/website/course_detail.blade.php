@extends('website.layouts.sikhobd')

@section('title', (lp($product, 'name') ?? 'Course Details') . ' — ' . ($ws->name ?? env('APP_NAME')))

@push('css')
<style>
    .courses-grid, .shop-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
    }
    @media (max-width: 1200px) {
        .courses-grid, .shop-grid { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 991px) {
        .courses-grid, .shop-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 575px) {
        .courses-grid, .shop-grid { grid-template-columns: 1fr; }
    }

    .shop-product-thumb {
        aspect-ratio: 1 / 1;
        background: #fff;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border-bottom: 1px solid var(--border);
    }
    .shop-product-thumb img {
        max-width: 80%;
        max-height: 80%;
        object-fit: contain;
        transition: transform 0.3s ease;
    }
    .course-card:hover .shop-product-thumb img {
        transform: scale(1.1);
    }
    .shop-actions {
        position: absolute;
        bottom: 10px;
        left: 0;
        right: 0;
        display: flex;
        justify-content: center;
        gap: 8px;
        opacity: 0;
        transform: translateY(10px);
        transition: all 0.3s ease;
    }
    .course-card:hover .shop-actions {
        opacity: 1;
        transform: translateY(0);
    }
    .shop-action-btn {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #fff;
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border);
        transition: all 0.2s;
    }
    .shop-action-btn:hover {
        background: var(--accent);
        color: #fff;
        border-color: var(--accent);
    }
</style>
@endpush

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

          @php
            $isEnrolled = false;
            if(auth()->check()){
                $isEnrolled = \App\Models\Enrollment::where('user_id', auth()->id())->where('product_id', $product->id)->where('status', 'active')->exists();
            }
          @endphp

          <div id="lesson-player-container" style="{{ $isEnrolled ? 'display:block;' : 'display:none;' }} margin-bottom: 30px; background: #000; border-radius: 12px; overflow: hidden; min-height: 400px; position: relative;">
                <div id="player-content" style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #fff; flex-direction: column; padding: 40px;">
                    <i class="fa-solid fa-play-circle" style="font-size: 64px; margin-bottom: 20px; color: var(--accent);"></i>
                    <h3>সিলেক্ট করুন যেকোনো লেসন পড়া শুরু করতে</h3>
                </div>
          </div>

          @if(!$isEnrolled)
          <div class="cd-hero" style="background-image: url('{{ route('imagecache', ['template' => 'large', 'filename' => $product->fi()]) }}'); background-size: cover; background-position: center; position: relative; margin-bottom: 30px;">
            <div class="play"><i class="fa-solid fa-play"></i></div>
          </div>
          @endif

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
            <div style="display:flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 style="color:var(--primary); margin-bottom:0;">Course curriculum</h3>
                @if($isEnrolled && $lessons->count() > 0)
                    <div style="font-size: 14px; color: var(--text-soft); background: var(--bg-soft); padding: 5px 12px; border-radius: 20px; border: 1px solid var(--border);">
                        কোর্স প্রোগ্রেস: <span id="progress-percent" style="font-weight: 700; color: var(--primary);">{{ count($completions) > 0 ? round((count($completions) / $lessons->count()) * 100) : 0 }}</span>%
                    </div>
                @endif
            </div>

            @forelse($sections as $section)
                <div class="course-section" style="margin-bottom: 25px;">
                    <h4 style="background: var(--bg-muted); padding: 12px 18px; border-radius: 8px; color: var(--primary); font-size: 17px; margin-bottom: 12px; border-left: 4px solid var(--accent); display: flex; justify-content: space-between; align-items: center;">
                        <span>{{ lp($section, 'title') }}</span>
                        <span style="font-size: 12px; color: var(--text-soft); font-weight: 400;">{{ $section->lessons->count() }} লেসন</span>
                    </h4>
                    
                    <div class="section-lessons" style="padding-left: 10px;">
                        @foreach($section->lessons as $lesson)
                            <div class="lesson {{ ($isEnrolled || $lesson->is_free) ? 'lesson-clickable' : '' }}" 
                                 data-lesson-id="{{ $lesson->id }}"
                                 data-title="{{ lp($lesson, 'title') }}"
                                 data-video-url="{{ $lesson->video_url }}"
                                 data-video-file="{{ $lesson->video_file ? asset('storage/'.$lesson->video_file) : '' }}"
                                 data-pdf-url="{{ $lesson->pdf_url ? asset('storage/'.$lesson->pdf_url) : '' }}"
                                 data-audio-url="{{ $lesson->audio_url ? asset('storage/'.$lesson->audio_url) : '' }}"
                                 data-provider="{{ $lesson->video_provider }}"
                                 style="display: flex; align-items: center; gap: 15px; padding: 12px 15px; border-radius: 10px; border: 1px solid var(--border); margin-bottom: 8px; transition: all 0.2s; cursor: pointer; background: #fff;">
                                
                                @if($isEnrolled)
                                <div class="lesson-check">
                                    <input type="checkbox" class="lesson-complete-toggle" data-id="{{ $lesson->id }}" {{ in_array($lesson->id, $completions) ? 'checked' : '' }} onclick="event.stopPropagation();">
                                </div>
                                @else
                                <div class="num" style="width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; background: var(--bg-soft); border-radius: 50%; font-size: 12px; color: var(--text-soft);">{{ $loop->iteration }}</div>
                                @endif

                                <div style="flex-grow: 1;">
                                    <h5 style="margin: 0; font-size: 15px; color: var(--text); font-weight: 500;">
                                        {{ lp($lesson, 'title') }}
                                        @if($lesson->is_free && !$isEnrolled)
                                            <span style="font-size: 9px; background: var(--accent); color: #fff; padding: 1px 5px; border-radius: 3px; margin-left: 5px; vertical-align: middle;">FREE PREVIEW</span>
                                        @endif
                                    </h5>
                                    <div style="display: flex; gap: 12px; margin-top: 4px; font-size: 11px; color: var(--text-muted);">
                                        @if($lesson->video_url || $lesson->video_file) <span><i class="fa-solid fa-video"></i> Video</span> @endif
                                        @if($lesson->pdf_url) <span><i class="fa-solid fa-file-pdf"></i> PDF</span> @endif
                                        @if($lesson->audio_url) <span><i class="fa-solid fa-volume-high"></i> Audio</span> @endif
                                        @if($lesson->duration) <span><i class="fa-solid fa-clock"></i> {{ $lesson->duration }}</span> @endif
                                    </div>
                                </div>

                                @if(!$isEnrolled && !$lesson->is_free)
                                    <i class="fa-solid fa-lock" style="color: var(--border); font-size: 14px;"></i>
                                @else
                                    <i class="fa-solid fa-circle-play" style="color: var(--primary); font-size: 18px; opacity: 0.7;"></i>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                @if($lessons->whereNull('course_section_id')->count() > 0)
                    {{-- Fallback for lessons without sections --}}
                    @foreach($lessons->whereNull('course_section_id') as $index => $lesson)
                        <div class="lesson {{ ($isEnrolled || $lesson->is_free) ? 'lesson-clickable' : '' }}" 
                             data-lesson-id="{{ $lesson->id }}"
                             data-title="{{ lp($lesson, 'title') }}"
                             data-video-url="{{ $lesson->video_url }}"
                             data-video-file="{{ $lesson->video_file ? asset('storage/'.$lesson->video_file) : '' }}"
                             data-pdf-url="{{ $lesson->pdf_url ? asset('storage/'.$lesson->pdf_url) : '' }}"
                             data-audio-url="{{ $lesson->audio_url ? asset('storage/'.$lesson->audio_url) : '' }}"
                             data-provider="{{ $lesson->video_provider }}"
                             style="display: flex; align-items: center; gap: 15px; padding: 15px; border-radius: 10px; border: 1px solid var(--border); margin-bottom: 10px; transition: all 0.2s; cursor: pointer; background: #fff;">
                            
                            @if($isEnrolled)
                            <div class="lesson-check">
                                <input type="checkbox" class="lesson-complete-toggle" data-id="{{ $lesson->id }}" {{ in_array($lesson->id, $completions) ? 'checked' : '' }} onclick="event.stopPropagation();">
                            </div>
                            @else
                            <div class="num">{{ $index + 1 }}</div>
                            @endif

                            <div style="flex-grow: 1;">
                                <h4 style="margin: 0; font-size: 16px; color: var(--text);">
                                    {{ lp($lesson, 'title') }}
                                    @if($lesson->is_free && !$isEnrolled)
                                        <span style="font-size: 10px; background: var(--accent); color: #fff; padding: 2px 6px; border-radius: 4px; margin-left: 8px;">FREE</span>
                                    @endif
                                </h4>
                                <div style="display: flex; gap: 10px; margin-top: 4px; font-size: 12px; color: var(--text-muted);">
                                    @if($lesson->video_url || $lesson->video_file) <span><i class="fa-solid fa-video"></i> Video</span> @endif
                                    @if($lesson->pdf_url) <span><i class="fa-solid fa-file-pdf"></i> PDF</span> @endif
                                    @if($lesson->audio_url) <span><i class="fa-solid fa-volume-high"></i> Audio</span> @endif
                                    <span><i class="fa-solid fa-clock"></i> {{ $lesson->duration }}</span>
                                </div>
                            </div>

                            @if(!$isEnrolled && !$lesson->is_free)
                                <i class="fa-solid fa-lock" style="color: var(--border);"></i>
                            @else
                                <i class="fa-solid fa-circle-play" style="color: var(--primary); font-size: 20px;"></i>
                            @endif
                        </div>
                    @endforeach
                @else
                    <p style="color:var(--text-soft);">Curriculum is being updated. Stay tuned!</p>
                @endif
            @endforelse
          </div>

          <div data-tab-content="instructor" style="display:none;">
            @if($product->instructor)
                <div style="display:flex; gap:20px; align-items:center; padding:24px; background:var(--bg-soft); border-radius:var(--radius-lg);">
                  <div class="avatar" style="margin:0; background-image: url('{{ $product->instructor->image ? asset('storage/users/' . $product->instructor->image) : '' }}'); background-size: cover;">
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

          @if($isEnrolled)
            <div style="background: #f0fdf4; border: 1px solid #bbf7d0; padding: 15px; border-radius: 10px; text-align: center; margin-top: 20px;">
                <p style="color: #166534; font-weight: 700; margin-bottom: 10px;"><i class="fa-solid fa-circle-check"></i> আপনি এই কোর্সে এনরোলড আছেন</p>
                <a href="{{ route('course.play', $product->slug) }}" class="btn btn-primary btn-sm" style="width: 100%; justify-content: center;">পড়া শুরু করুন</a>
            </div>
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
            <li><i class="fa-solid fa-file"></i> {{ $lessons->count() }} Lessons</li>
            <li><i class="fa-solid fa-infinity"></i> Lifetime access</li>
            <li><i class="fa-solid fa-mobile-screen"></i> Mobile & TV access</li>
            <li><i class="fa-solid fa-certificate"></i> Certificate on completion</li>
          </ul>
        </aside>
      </div>
    </div>
  </section>

  {{-- Related Courses Section --}}
  @if($relatedCourses->count() > 0)
  <section class="section" style="padding: 60px 0; border-top: 1px solid var(--border); background: var(--bg-soft);">
    <div class="container">
      <div class="section-head" style="margin-bottom: 32px; display: flex; justify-content: space-between; align-items: flex-end;">
        <div>
            <h2 style="color: var(--primary); margin: 0 0 8px 0; font-size: 28px; font-weight: 700;">Related Courses</h2>
            <p style="color: var(--text-soft); margin: 0; font-size: 15px;">Explore more courses from the same category</p>
        </div>
        <a href="{{ route('courses') }}" class="btn btn-outline btn-sm">View All Courses</a>
      </div>
      
      <div class="courses-grid">
        @foreach($relatedCourses as $course)
          <article class="course-card">
            <div class="course-thumb" style="--c1:#6c5ce7;--c2:#a29bfe;">
              @if($course->feature)
                <span class="course-tag">FEATURED</span>
              @endif
              <img src="{{ route('imagecache', ['template' => 'medium', 'filename' => $course->fi()]) }}" alt="{{ lp($course, 'name') }}" style="width:100%; height:100%; object-fit:cover; border-radius:12px 12px 0 0;">
            </div>
            <div class="course-body">
              <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 12px;">{{ lp($course, 'name') }}</h3>
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
                <a href="{{ route('courseDetail', $course->slug) }}" class="btn btn-accent btn-sm">Enroll</a>
              </div>
            </div>
          </article>
        @endforeach
      </div>
    </div>
  </section>
  @endif

  {{-- Related Products Section --}}
  @if($relatedProducts->count() > 0)
  <section class="section" style="padding: 60px 0;">
    <div class="container">
      <div class="section-head" style="margin-bottom: 32px; display: flex; justify-content: space-between; align-items: flex-end;">
        <div>
            <h2 style="color: var(--primary); margin: 0 0 8px 0; font-size: 28px; font-weight: 700;">Recommended Products</h2>
            <p style="color: var(--text-soft); margin: 0; font-size: 15px;">Essential tools and materials for your learning journey</p>
        </div>
        <a href="{{ route('shop') }}" class="btn btn-outline btn-sm">Visit Shop</a>
      </div>
      
      <div class="shop-grid">
        @foreach($relatedProducts as $p)
        <article class="course-card">
            <div class="shop-product-thumb">
              @if($p->discount > 0)
                <span class="course-tag">{{ $p->discount }}% OFF</span>
              @elseif($p->feature)
                <span class="course-tag">HOT</span>
              @endif
              
              <img src="{{ route('imagecache', ['template' => 'pnimd', 'filename' => $p->fi()]) }}" alt="{{ lp($p, 'name') }}">
              
              <div class="shop-actions">
                  <button class="shop-action-btn addToCart" data-url="{{ route('addToCart') }}" data-product="{{ $p->id }}" title="Add to Cart"><i class="fa-solid fa-cart-shopping"></i></button>
              </div>
            </div>
            <div class="course-body">
              <span style="font-size: 11px; color: var(--accent); font-weight: 700; text-transform: uppercase;">{{ $p->categories->first()->name_en ?? 'Product' }}</span>
              <h3 style="margin-top: 5px; font-size: 16px; font-weight: 700;"><a href="{{ route('productDetails', $p->slug) }}" style="text-decoration: none; color: inherit;">{{ Str::limit(lp($p, 'name'), 40) }}</a></h3>
              
              <div class="course-foot" style="border: none; padding-top: 10px;">
                <div style="display: flex; align-items: center; gap: 8px;">
                  <span class="price">৳{{ number_format($p->selling_price) }}</span>
                  @if($p->discount > 0)
                    <span style="font-size: 13px; color: var(--text-muted); text-decoration: line-through;">৳{{ number_format($p->price) }}</span>
                  @endif
                </div>
                <button class="btn btn-accent btn-sm addToCart" data-url="{{ route('addToCart') }}" data-product="{{ $p->id }}">Buy Now</button>
              </div>
            </div>
          </article>
        @endforeach
      </div>
    </div>
  </section>
  @endif
@endsection

@push('js')
<script>
    // Global State
    window.allLessons = @json($lessons);
    window.currentLessonIndex = -1;
    window.storageBase = "{{ asset('storage') }}";

    // Tab Switching Logic
    window.switchTab = function(tab) {
        // Update buttons
        document.querySelectorAll('.cd-tabs button').forEach(b => {
            b.classList.remove('active');
            if(b.getAttribute('data-tab') === tab) b.classList.add('active');
        });
        
        // Update content
        document.querySelectorAll('[data-tab-content]').forEach(content => {
            content.style.display = content.getAttribute('data-tab-content') === tab ? 'block' : 'none';
        });
    }

    // Attach Tab Click Handlers
    document.querySelectorAll('.cd-tabs button').forEach(button => {
        button.addEventListener('click', () => {
            window.switchTab(button.getAttribute('data-tab'));
        });
    });

    // Start Learning Logic
    window.startLearning = function() {
        window.switchTab('curriculum');
        
        const completions = @json($completions);
        let targetLesson = window.allLessons.find(l => !completions.includes(l.id));
        
        if (!targetLesson && window.allLessons.length > 0) {
            targetLesson = window.allLessons[0];
        }
        
        if (targetLesson) {
            window.renderLesson(targetLesson.id);
        }
    }

    // Lesson Rendering Logic
    window.renderLesson = function(lessonId) {
        const lessonIndex = window.allLessons.findIndex(l => l.id == lessonId);
        if (lessonIndex === -1) return;
        
        window.currentLessonIndex = lessonIndex;
        const lesson = window.allLessons[lessonIndex];
        const container = $('#player-content');
        
        // Visual updates
        $('.lesson').css('background', '#fff').css('border-color', 'var(--border)');
        $(`.lesson[data-lesson-id="${lessonId}"]`).css('background', 'rgba(43, 37, 83, 0.03)').css('border-color', 'var(--primary)');

        // Scroll to player
        $('html, body').animate({
            scrollTop: $("#lesson-player-container").offset().top - 100
        }, 500);

        // Build HTML
        let html = `
            <div style="width:100%; display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; border-bottom:1px solid #333; padding-bottom:10px;">
                <h2 style="margin:0; font-size:22px; color:#fff;">${lesson.title_en || lesson.title_bn}</h2>
                <div style="display:flex; gap:10px;">
                    <button class="btn btn-outline btn-sm" style="color:#fff; border-color:#555;" ${lessonIndex === 0 ? 'disabled' : ''} onclick="window.prevLesson()"><i class="fa-solid fa-chevron-left"></i> Previous</button>
                    <button class="btn btn-accent btn-sm" ${lessonIndex === window.allLessons.length - 1 ? 'disabled' : ''} onclick="window.nextLesson()">Next <i class="fa-solid fa-chevron-right"></i></button>
                </div>
            </div>
        `;

        if (lesson.video_file) {
            html += `<video controls style="width: 100%; border-radius: 8px; margin-bottom: 25px; background:#000;">
                        <source src="${window.storageBase}/${lesson.video_file}" type="video/mp4">
                    </video>`;
        } else if (lesson.video_url) {
            const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
            const match = lesson.video_url.match(regExp);
            const id = (match && match[2].length == 11) ? match[2] : null;
            if(id && lesson.video_provider === 'youtube') {
                html += `<iframe width="100%" height="500" src="https://www.youtube.com/embed/${id}" frameborder="0" allowfullscreen style="border-radius: 8px; margin-bottom: 25px; background:#000;"></iframe>`;
            } else {
                html += `<div style="padding:20px; background:#111; border-radius:8px; margin-bottom:25px; text-align:center;">
                            <a href="${lesson.video_url}" target="_blank" class="btn btn-primary">Watch External Video</a>
                         </div>`;
            }
        }

        if (lesson.audio_url) {
            html += `<div style="width: 100%; background: #1a1a1a; padding: 20px; border-radius: 8px; margin-bottom: 25px; border-left:4px solid var(--accent);">
                        <p style="margin-bottom: 12px; color: #eee; font-weight:600;"><i class="fa-solid fa-volume-high"></i> Audio Lesson:</p>
                        <audio controls style="width: 100%;"><source src="${window.storageBase}/${lesson.audio_url}" type="audio/mpeg"></audio>
                    </div>`;
        }

        if (lesson.description) {
            html += `<div style="width:100%; background:#fff; color:#333; padding:25px; border-radius:8px; margin-bottom:25px;">
                        <h3 style="color:var(--primary); margin-top:0; border-bottom:1px solid var(--border); padding-bottom:10px; margin-bottom:15px;">Tutorial</h3>
                        <div style="line-height:1.7;">${lesson.description}</div>
                     </div>`;
        }

        if (lesson.pdf_url) {
            html += `<div style="display: flex; gap: 15px; margin-bottom:25px;">
                        <a href="${window.storageBase}/${lesson.pdf_url}" target="_blank" class="btn btn-accent">View PDF</a>
                        <a href="${window.storageBase}/${lesson.pdf_url}" download class="btn btn-outline" style="color:#fff; border-color:#555;">Download</a>
                    </div>`;
        }

        container.html(html).css('align-items', 'flex-start');
        $('#lesson-player-container').show();
    }

    // Navigation
    window.nextLesson = function() {
        if (window.currentLessonIndex < window.allLessons.length - 1) {
            window.renderLesson(window.allLessons[window.currentLessonIndex + 1].id);
        }
    }
    window.prevLesson = function() {
        if (window.currentLessonIndex > 0) {
            window.renderLesson(window.allLessons[window.currentLessonIndex - 1].id);
        }
    }

    // List Click
    $(document).on('click', '.lesson-clickable', function() {
        window.renderLesson($(this).data('lesson-id'));
    });

    // Completion Toggle
    $(document).on('change', '.lesson-complete-toggle', function() {
        const lessonId = $(this).data('id');
        const totalLessons = {{ $lessons->count() }};
        $.ajax({
            url: "{{ route('lesson.toggleCompletion') }}",
            type: "POST",
            data: { lesson_id: lessonId, _token: "{{ csrf_token() }}" },
            success: function() {
                const checkedCount = $('.lesson-complete-toggle:checked').length;
                $('#progress-percent').text(Math.round((checkedCount / totalLessons) * 100));
                showCartNotification('Progress Updated', 'success');
            }
        });
    });

    // Wishlist
    $(document).on('click', '.add-to-wishlist-btn', function() {
        const productId = $('#add-to-wishlist-form input[name="product_id"]').val();
        const btn = $(this);
        btn.prop('disabled', true).html('...');
        $.ajax({
            url: "{{ route('wishlist.add') }}",
            type: "POST",
            data: { product_id: productId, _token: "{{ csrf_token() }}" },
            success: function(response) {
                btn.prop('disabled', false).html('Added!');
                showCartNotification(response.message, 'success');
                setTimeout(() => btn.html('Add to Wishlist'), 2000);
            }
        });
    });

    // Add to Cart AJAX (for related products)
    $(document).on('click', '.addToCart', function(e) {
        e.preventDefault();
        let btn = $(this);
        let product_id = btn.data('product');
        let url = btn.data('url');

        $.ajax({
            url: url,
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                product: product_id,
                qty: 1
            },
            success: function(res) {
                if(res.status) {
                    showCartNotification(res.message);
                    $('.cartCount').text(res.cartCount);
                }
            }
        });
    });
</script>
@endpush
