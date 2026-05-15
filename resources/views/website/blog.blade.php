@extends('website.layouts.sikhobd')

@section('title', 'News & Blog - '. ($ws->name ?? env('APP_NAME')))

@section('meta')
<meta name="description" content="Stay updated with the latest news, articles, and educational tips from SikhoBD.">
<meta name="keywords" content="elearning blog, education news, learning tips, SikhoBD articles">
<meta property="og:title" content="News & Blog - SikhoBD">
<meta property="og:description" content="Latest updates and insights from the world of e-learning.">
<meta property="og:type" content="website">
@endsection

@section('content')
<section class="page-hero">
    <div class="container">
        <h1 data-i18n="page.blog.title">ব্লগ ও আর্টিকেল</h1>
        <p data-i18n="page.blog.sub">শিক্ষা, ক্যারিয়ার ও দক্ষতা বিষয়ক সর্বশেষ লেখা</p>
        <div class="crumbs">
            <a href="{{ route('home') }}">Home</a>
            <span>/</span>
            <span class="active">Blog</span>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="row" style="display: flex; flex-wrap: wrap; gap: 40px;">
            <div style="flex: 1; min-width: 300px;">
                <div class="blog-list">
                    @forelse($news as $post)
                    <article class="blog-item-large">
                        <div class="bil-thumb">
                            <a href="{{ route('singleNews', $post->id) }}">
                                <img src="{{ route('imagecache', ['template'=>'medium','filename' => $post->fi()]) }}" alt="{{$post->title}}">
                            </a>
                            <span class="bil-cat">{{ $post->category->name_en ?? 'News' }}</span>
                        </div>
                        <div class="bil-body">
                            <div class="bil-meta">
                                <span><i class="fa-solid fa-calendar"></i> {{ $post->created_at->format('M d, Y') }}</span>
                                <span><i class="fa-solid fa-eye"></i> {{ $post->view_count ?? 0 }} Views</span>
                            </div>
                            <h3><a href="{{ route('singleNews', $post->id) }}">{{ $post->title }}</a></h3>
                            <p>{{ Str::limit(strip_tags($post->description), 180) }}</p>
                            <a href="{{ route('singleNews', $post->id) }}" class="read-more-btn">আরও পড়ুন <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </article>
                    @empty
                    <div class="empty-state">
                        <i class="fa-solid fa-blog"></i>
                        <p>No articles found.</p>
                    </div>
                    @endforelse
                </div>

                <div class="pagination-wrap">
                    {{ $news->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>

            <!-- Sidebar -->
            <div style="width: 340px; min-width: 300px;">
                <aside class="sidebar">
                    <div class="widget">
                        <h4 class="widget-title">Search</h4>
                        <form action="{{ route('news') }}" method="GET" class="widget-search">
                            <input type="text" name="search" placeholder="Search blog...">
                            <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </form>
                    </div>

                    <div class="widget">
                        <h4 class="widget-title">Latest Articles</h4>
                        <div class="latest-posts-widget">
                            @foreach($news->take(4) as $latest)
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
                            @php
                                $categories = \App\Models\BlogCategory::withCount('posts')->get();
                            @endphp
                            @foreach($categories as $cat)
                            <li>
                                <a href="#">
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
    .blog-item-large { 
        background: #fff; border: 1px solid var(--border); border-radius: var(--radius-lg); 
        overflow: hidden; margin-bottom: 40px; transition: all 0.3s;
    }
    .blog-item-large:hover { box-shadow: var(--shadow-md); transform: translateY(-4px); }
    .bil-thumb { position: relative; aspect-ratio: 21/9; overflow: hidden; }
    .bil-thumb img { width: 100%; height: 100%; object-fit: cover; }
    .bil-cat { 
        position: absolute; top: 20px; left: 20px; background: var(--accent); color: #fff;
        padding: 4px 12px; border-radius: var(--radius-full); font-size: 12px; font-weight: 700;
    }
    .bil-body { padding: 30px; }
    .bil-meta { display: flex; gap: 20px; color: var(--text-muted); font-size: 13px; margin-bottom: 15px; }
    .bil-meta i { color: var(--accent); margin-right: 5px; }
    .bil-body h3 { font-size: 24px; color: var(--primary); margin-bottom: 15px; }
    .bil-body h3 a:hover { color: var(--accent); }
    .bil-body p { color: var(--text-soft); line-height: 1.7; margin-bottom: 25px; }
    .read-more-btn { font-weight: 700; color: var(--primary); display: inline-flex; align-items: center; gap: 8px; }
    .read-more-btn:hover { color: var(--accent); }

    .empty-state { text-align: center; padding: 60px 0; color: var(--text-muted); }
    .empty-state i { font-size: 48px; margin-bottom: 20px; opacity: 0.3; }

    /* Reusing Sidebar styles from details page */
    .sidebar { background: var(--bg-soft); padding: 30px; border-radius: var(--radius-lg); border: 1px solid var(--border); }
    .widget { margin-bottom: 40px; }
    .widget-title { font-size: 18px; color: var(--primary); margin-bottom: 20px; position: relative; padding-bottom: 10px; }
    .widget-title::after { content: ''; position: absolute; bottom: 0; left: 0; width: 40px; height: 2px; background: var(--accent); }
    .widget-search { position: relative; }
    .widget-search input { width: 100%; padding: 12px 15px; border: 1px solid var(--border); border-radius: var(--radius); outline: none; }
    .widget-search button { position: absolute; right: 10px; top: 50%; transform: translateY(-50%); color: var(--text-muted); border: none; background: none; cursor: pointer; }
    .lp-item { display: flex; gap: 12px; margin-bottom: 15px; }
    .lp-thumb { width: 60px; height: 60px; border-radius: 8px; overflow: hidden; flex-shrink: 0; }
    .lp-thumb img { width: 100%; height: 100%; object-fit: cover; }
    .lp-info h5 { font-size: 13px; line-height: 1.4; margin-bottom: 4px; }
    .lp-info h5 a { color: var(--primary); }
    .lp-info span { font-size: 11px; color: var(--text-muted); }
    .widget-list { list-style: none; padding: 0; }
    .widget-list li { border-bottom: 1px solid var(--border); }
    .widget-list li a { display: flex; justify-content: space-between; padding: 12px 0; font-size: 14px; color: var(--text-soft); }
    .widget-list li a:hover { color: var(--accent); padding-left: 5px; transition: all 0.2s; }

    @media (max-width: 991px) {
        .row { flex-direction: column !important; }
        .sidebar { width: 100% !important; margin-top: 40px; }
        .bil-thumb { aspect-ratio: 16/9; }
    }
</style>
@endpush
