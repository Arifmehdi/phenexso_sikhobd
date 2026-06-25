@extends('website.layouts.sikhobd')

@section('title', ($instructor->name ?? 'Instructor') . ' — ' . ($ws->website_title ?? 'Qalam HR'))

@push('css')
<style>
    .inst-hero { background: linear-gradient(135deg, var(--primary) 0%, #4338ca 100%); color:#fff; padding: 50px 0; }
    .inst-hero-inner { display:flex; align-items:center; gap:24px; flex-wrap:wrap; }
    .inst-avatar {
        width: 120px; height: 120px; border-radius: 50%; flex-shrink:0;
        background:#fff; color:var(--primary); display:flex; align-items:center; justify-content:center;
        font-size:42px; font-weight:800; overflow:hidden; background-size:cover; background-position:center;
        border: 4px solid rgba(255,255,255,0.3);
    }
    .inst-name { font-size: 28px; font-weight: 800; margin:0; }
    .inst-desg { opacity:.9; font-size:15px; margin-top:4px; }
    .inst-stats { display:flex; gap:24px; margin-top:14px; flex-wrap:wrap; }
    .inst-stat { background: rgba(255,255,255,0.12); border-radius:12px; padding:8px 16px; font-size:14px; }
    .inst-stat strong { font-size:18px; display:block; }

    .inst-courses-grid { display:grid; grid-template-columns: repeat(3, 1fr); gap:24px; margin-top:30px; }
    @media (max-width:991px){ .inst-courses-grid { grid-template-columns: repeat(2,1fr); } }
    @media (max-width:600px){ .inst-courses-grid { grid-template-columns: 1fr; } }
    .ic-card { background:#fff; border:1px solid var(--border); border-radius:14px; overflow:hidden; transition: all .3s; display:flex; flex-direction:column; }
    .ic-card:hover { transform: translateY(-5px); box-shadow: 0 14px 30px rgba(0,0,0,.08); }
    .ic-thumb { aspect-ratio: 14/15; overflow:hidden; background:#eef2f7; }
    .ic-thumb img { width:100%; height:100%; object-fit:cover; }
    .ic-body { padding:14px; display:flex; flex-direction:column; flex:1; }
    .ic-body h4 { font-size:15px; font-weight:700; margin:0 0 8px; line-height:1.4; }
    .ic-body h4 a { color:inherit; text-decoration:none; }
    .ic-meta { font-size:13px; color:var(--text-muted); margin-top:auto; }
    .ic-meta i { color:var(--accent); }
</style>
@endpush

@section('content')
<section class="inst-hero">
    <div class="container">
        <div class="inst-hero-inner">
            <div class="inst-avatar" style="{{ $instructor->image ? "background-image:url('".asset('storage/users/'.$instructor->image)."');" : '' }}">
                @if(!$instructor->image){{ strtoupper(substr($instructor->name, 0, 2)) }}@endif
            </div>
            <div>
                <h1 class="inst-name">{{ $instructor->name }}</h1>
                <div class="inst-desg"><i class="fa-solid fa-chalkboard-user mr-1"></i> {{ $instructor->designation ?? (app()->getLocale()=='bn' ? 'ইনস্ট্রাকটর' : 'Instructor') }}</div>
                <div class="inst-stats">
                    <div class="inst-stat"><strong>{{ $courses->count() }}</strong> {{ app()->getLocale()=='bn' ? 'কোর্স' : 'Courses' }}</div>
                    <div class="inst-stat"><strong>{{ $courses->sum('lessons_count') }}</strong> {{ app()->getLocale()=='bn' ? 'লেসন' : 'Lessons' }}</div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section" style="padding: 50px 0; background:#f8fafc;">
    <div class="container">
        @if(!empty($instructor->short_bio))
        <div style="background:#fff; border:1px solid var(--border); border-radius:14px; padding:24px; margin-bottom:10px;">
            <h3 style="font-weight:800; color:var(--primary); font-size:18px; margin-bottom:10px;">
                {{ app()->getLocale()=='bn' ? 'পরিচিতি' : 'About' }}
            </h3>
            <p style="color:var(--text-soft); margin:0; line-height:1.7;">{{ $instructor->short_bio }}</p>
        </div>
        @endif

        <h3 style="font-weight:800; color:#1e293b; margin-top:24px;">
            {{ app()->getLocale()=='bn' ? 'এই ইনস্ট্রাকটরের কোর্সসমূহ' : 'Courses by this Instructor' }}
        </h3>

        <div class="inst-courses-grid">
            @forelse($courses as $course)
            <article class="ic-card">
                <a href="{{ route('courseDetail', $course->slug) }}" class="ic-thumb" style="display:block;">
                    <img src="{{ route('imagecache', ['template' => 'medium', 'filename' => $course->fi()]) }}" alt="{{ $course->name_en }}">
                </a>
                <div class="ic-body">
                    <h4><a href="{{ route('courseDetail', $course->slug) }}">{{ app()->getLocale()=='bn' ? ($course->name_bn ?? $course->name_en) : $course->name_en }}</a></h4>
                    <div class="ic-meta"><i class="fa-solid fa-book-open"></i> {{ $course->lessons_count }} {{ app()->getLocale()=='bn' ? 'টি লেসন' : 'Lessons' }}</div>
                </div>
            </article>
            @empty
            <p class="text-muted">{{ app()->getLocale()=='bn' ? 'কোনো কোর্স পাওয়া যায়নি।' : 'No courses found.' }}</p>
            @endforelse
        </div>
    </div>
</section>
@endsection
