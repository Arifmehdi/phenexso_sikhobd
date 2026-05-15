@extends('website.layouts.sikhobd')

@section('title', $news->title . ' - ' . ($ws->name ?? env('APP_NAME')))

@section('meta')
<meta name="description" content="{{ Str::limit(strip_tags($news->description), 160) }}">
<meta name="keywords" content="{{ $news->category->name_en ?? 'education, news, learning' }}">
<meta property="og:title" content="{{ $news->title }}">
<meta property="og:description" content="{{ Str::limit(strip_tags($news->description), 160) }}">
<meta property="og:image" content="{{ route('imagecache', ['template' => 'original', 'filename' => $news->fi()]) }}">
<meta property="og:type" content="article">
@endsection

@section('content')
<section class="page-hero">
    <div class="container">
        <span class="eyebrow">{{ $news->category->name_en ?? 'Learning' }}</span>
        <h1>{{ $news->title }}</h1>
        <div class="crumbs">
            <a href="{{ route('home') }}">Home</a>
            <span>/</span>
            <a href="{{ route('news') }}">News & Blog</a>
            <span>/</span>
            <span class="active">Details</span>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="row" style="display: flex; flex-wrap: wrap; gap: 40px;">
            <!-- Main Content -->
            <div style="flex: 1; min-width: 300px;">
                <article class="post-details">
                    <div class="post-thumb mb-4">
                        <img src="{{ route('imagecache', ['template' => 'original', 'filename' => $news->fi()]) }}" 
                             alt="{{ $news->title }}" style="width: 100%; border-radius: var(--radius-lg); box-shadow: var(--shadow-md);">
                    </div>

                    <div class="post-meta mb-4">
                        <span><i class="fa-solid fa-calendar-days"></i> {{ $news->created_at->format('M d, Y') }}</span>
                        <span><i class="fa-solid fa-folder"></i> {{ $news->category->name_en ?? 'General' }}</span>
                        <span><i class="fa-solid fa-eye"></i> {{ $news->view_count ?? 0 }} Views</span>
                    </div>

                    <div class="post-content-wrap">
                        {!! $news->description !!}
                    </div>

                    <div class="post-footer">
                        <div class="post-share">
                            <strong>Share this:</strong>
                            <div class="social-icons">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                                <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}" target="_blank"><i class="fa-brands fa-twitter"></i></a>
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ url()->current() }}" target="_blank"><i class="fa-brands fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>

                    @if($relatedPosts->count() > 0)
                    <div class="related-posts mt-5">
                        <h3 class="mb-4">Related News</h3>
                        <div class="related-grid">
                            @foreach($relatedPosts->take(2) as $relate)
                            <div class="related-card">
                                <a href="{{ route('singleNews', $relate->id) }}" class="rel-thumb">
                                    <img src="{{ route('imagecache', ['template' => 'medium', 'filename' => $relate->fi()]) }}" alt="{{ $relate->title }}">
                                </a>
                                <div class="rel-body">
                                    <h4><a href="{{ route('singleNews', $relate->id) }}">{{ Str::limit($relate->title, 50) }}</a></h4>
                                    <span>{{ $relate->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </article>
            </div>

            <!-- Sidebar -->
            <div style="width: 340px; min-width: 300px;">
                <aside class="sidebar">
                    <div class="widget">
                        <h4 class="widget-title">Search</h4>
                        <form action="{{ route('news') }}" method="GET" class="widget-search">
                            <input type="text" name="search" placeholder="Search news...">
                            <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </form>
                    </div>

                    <div class="widget">
                        <h4 class="widget-title">Latest News</h4>
                        <div class="latest-posts-widget">
                            @foreach($latestPosts->take(4) as $latest)
                            <div class="lp-item">
                                <a href="{{ route('singleNews', $latest->id) }}" class="lp-thumb">
                                    <img src="{{ route('imagecache', ['template' => 'pnism', 'filename' => $latest->fi()]) }}" alt="{{ $latest->title }}">
                                </a>
                                <div class="lp-info">
                                    <h5><a href="{{ route('singleNews', $latest->id) }}">{{ Str::limit($latest->title, 40) }}</a></h5>
                                    <span>{{ $latest->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="widget">
                        <h4 class="widget-title">Categories</h4>
                        <ul class="widget-list">
                            @foreach($newsCategories as $cat)
                            <li>
                                <a href="{{ route('categoryPosts', $cat->id) }}">
                                    {{ $cat->name }}
                                    <span>({{ $cat->posts_count }})</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</section>
@endsection

@push('css')
<style>
    .post-meta { display: flex; gap: 20px; color: var(--text-muted); font-size: 14px; }
    .post-meta i { color: var(--accent); margin-right: 6px; }
    
    .post-content-wrap { color: var(--text-soft); line-height: 1.8; font-size: 16px; }
    .post-content-wrap p { margin-bottom: 20px; }
    .post-content-wrap h2, .post-content-wrap h3 { color: var(--primary); margin: 30px 0 15px; }
    .post-content-wrap img { border-radius: var(--radius); margin: 20px 0; max-width: 100%; height: auto; }

    .post-footer { margin-top: 40px; padding-top: 20px; border-top: 1px solid var(--border); }
    .post-share { display: flex; align-items: center; gap: 20px; }
    .social-icons { display: flex; gap: 10px; }
    .social-icons a { 
        width: 36px; height: 36px; border-radius: 50%; border: 1px solid var(--border); 
        display: flex; align-items: center; justify-content: center; color: var(--text-soft);
        transition: all 0.2s;
    }
    .social-icons a:hover { background: var(--primary); color: #fff; border-color: var(--primary); }

    .related-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }
    .related-card { border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .rel-thumb { aspect-ratio: 16/9; overflow: hidden; display: block; }
    .rel-thumb img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s; }
    .related-card:hover .rel-thumb img { transform: scale(1.05); }
    .rel-body { padding: 15px; }
    .rel-body h4 { font-size: 15px; margin-bottom: 5px; color: var(--primary); }
    .rel-body span { font-size: 12px; color: var(--text-muted); }

    /* Sidebar Widgets */
    .sidebar { background: var(--bg-soft); padding: 30px; border-radius: var(--radius-lg); border: 1px solid var(--border); }
    .widget { margin-bottom: 40px; }
    .widget:last-child { margin-bottom: 0; }
    .widget-title { font-size: 18px; color: var(--primary); margin-bottom: 20px; position: relative; padding-bottom: 10px; }
    .widget-title::after { content: ''; position: absolute; bottom: 0; left: 0; width: 40px; height: 2px; background: var(--accent); }
    
    .widget-search { position: relative; }
    .widget-search input { width: 100%; padding: 12px 15px; border: 1px solid var(--border); border-radius: var(--radius); outline: none; }
    .widget-search button { position: absolute; right: 10px; top: 50%; transform: translateY(-50%); color: var(--text-muted); }

    .lp-item { display: flex; gap: 12px; margin-bottom: 15px; }
    .lp-thumb { width: 70px; height: 70px; border-radius: 8px; overflow: hidden; flex-shrink: 0; }
    .lp-thumb img { width: 100%; height: 100%; object-fit: cover; }
    .lp-info h5 { font-size: 14px; line-height: 1.4; margin-bottom: 4px; }
    .lp-info h5 a { color: var(--primary); }
    .lp-info span { font-size: 12px; color: var(--text-muted); }

    .widget-list { list-style: none; padding: 0; }
    .widget-list li { border-bottom: 1px solid var(--border); }
    .widget-list li:last-child { border-bottom: none; }
    .widget-list li a { display: flex; justify-content: space-between; padding: 12px 0; font-size: 14px; color: var(--text-soft); }
    .widget-list li a:hover { color: var(--accent); padding-left: 5px; transition: all 0.2s; }

    @media (max-width: 991px) {
        .row { flex-direction: column !important; }
        .sidebar { width: 100% !important; margin-top: 40px; }
    }
    @media (max-width: 600px) {
        .related-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush
