@extends('website.layouts.mncofee')

@section('title', $news->title . ' - ' . ($ws->name ?? env('APP_NAME')))

@section('meta')
<meta name="description" content="{{ Str::limit(strip_tags($news->description), 160) }}">
<meta name="keywords" content="{{ $news->category->name_en ?? 'blog, coffee, news' }}">
<meta property="og:title" content="{{ $news->title }}">
<meta property="og:description" content="{{ Str::limit(strip_tags($news->description), 160) }}">
<meta property="og:image" content="{{ route('imagecache', ['template' => 'original', 'filename' => $news->fi()]) }}">
<meta property="og:type" content="article">
@endsection

@push('css')
<style>
    .ad-blog-banner {
        background-image: url("{{ asset('mncofee/assets/img/aida-images/menu-banner.png') }}") !important;
        background-size: cover;
        background-position: center;
        height: 300px;
    }
    .ad-blog-banner-overlay {
        background: rgba(0, 0, 0, 0.5);
        height: 100%;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
    }
    .ad-blog-banner-overlay a {
        color: #fff;
        text-decoration: none;
        margin: 0 5px;
    }
    .ad-blog-banner-overlay .selected-page {
        color: #A45517;
    }
    .blog-details-content img {
        width: 100%;
        border-radius: 15px;
        margin-bottom: 25px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .blog-meta-single {
        margin-right: 20px;
        font-size: 14px;
        color: #666;
    }
    .blog-meta-single i {
        color: #A45517;
        margin-right: 5px;
    }
    .sidebar-title {
        position: relative;
        padding-bottom: 15px;
        margin-bottom: 25px;
        font-size: 20px;
        border-bottom: 2px solid #f1f1f1;
    }
    .sidebar-title::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 50px;
        height: 2px;
        background: #A45517;
    }
    .sidebar-post-single {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
    }
    .sidebar-post-img img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
    }
    .sidebar-post-title {
        font-size: 14px;
        line-height: 1.4;
        margin-bottom: 5px;
    }
    .sidebar-post-title a {
        color: #333;
        font-weight: 600;
    }
    .sidebar-post-title a:hover {
        color: #A45517;
    }
    .sidebar-post-date {
        font-size: 12px;
        color: #999;
    }
    .category-list li {
        margin-bottom: 12px;
    }
    .category-list li a {
        display: flex;
        justify-content: space-between;
        color: #555;
        transition: 0.3s;
    }
    .category-list li a:hover {
        color: #A45517;
        padding-left: 5px;
    }
    .tag-list a {
        display: inline-block;
        padding: 6px 15px;
        background: #f8f9fa;
        color: #666;
        border-radius: 5px;
        margin: 0 5px 10px 0;
        font-size: 13px;
        transition: 0.3s;
    }
    .tag-list a:hover {
        background: #A45517;
        color: #fff;
    }
    .related-post-card {
        border: none;
        transition: 0.3s;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    .related-post-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    .blog-content-area {
        line-height: 1.8;
        color: #444;
        font-size: 16px;
    }
    .blog-content-area p {
        margin-bottom: 20px;
    }
</style>
@endpush

@section('content')
<!--------------- 
    Banner 
---------------->
<section>
    <div class="ad-blog-banner position-relative">
        <div class="ad-blog-banner-overlay text-center">
            <div>
                <h1 class="text-white mb-3" style="font-family: 'Oswald', sans-serif;">Blog Details</h1>
                <div class="d-flex justify-content-center align-items-center">
                    <a href="{{ route('home') }}">Home</a>
                    <span class="text-white">/</span>
                    <a class="selected-page" href="{{ route('news') }}"> Blog</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-5">
            <!-- Left Content Area -->
            <div class="col-lg-8">
                <article class="blog-details-wrap">
                    <div class="blog-img mb-4" data-aos="fade-up">
                        <img src="{{ route('imagecache', ['template' => 'original', 'filename' => $news->fi()]) }}" 
                             alt="{{ $news->title }}" class="img-fluid rounded-4 shadow-sm w-100">
                    </div>

                    <div class="blog-meta mb-3" data-aos="fade-up">
                        <span class="blog-meta-single"><i class="far fa-calendar-alt"></i> {{ $news->created_at->format('d M, Y') }}</span>
                        <span class="blog-meta-single"><i class="far fa-folder"></i> {{ $news->category->name_en ?? 'General' }}</span>
                        <span class="blog-meta-single"><i class="far fa-user"></i> Admin</span>
                    </div>

                    <h2 class="mb-4" style="font-family: 'Oswald', sans-serif; font-size: 32px;" data-aos="fade-up">
                        {{ $news->title }}
                    </h2>

                    <div class="blog-content-area mb-5" data-aos="fade-up">
                        {!! $news->description !!}
                    </div>

                    <!-- Tags and Share -->
                    <div class="d-flex flex-wrap justify-content-between align-items-center py-4 border-top border-bottom mb-5" data-aos="fade-up">
                        <div class="tag-list">
                            <span class="fw-bold me-2">Tags:</span>
                            <a href="#">Coffee</a>
                            <a href="#">Hill Farmers</a>
                            <a href="#">Specialty</a>
                        </div>
                        <div class="social-share d-flex align-items-center gap-3">
                            <span class="fw-bold">Share:</span>
                            <a href="#" class="text-dark"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="text-dark"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="text-dark"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>

                    <!-- Related Posts -->
                    <div class="related-posts mb-5" data-aos="fade-up">
                        <h4 class="mb-4" style="font-family: 'Oswald', sans-serif;">Related Posts</h4>
                        <div class="row g-4">
                            @forelse($relatedPosts->take(2) as $relate)
                                <div class="col-md-6">
                                    <div class="card related-post-card h-100">
                                        <a href="{{ route('singleNews', ['id' => $relate->id]) }}">
                                            <img src="{{ route('imagecache', ['template' => 'cpmd', 'filename' => $relate->fi()]) }}" 
                                                 class="card-img-top" alt="{{ $relate->title }}" style="height: 200px; object-fit: cover;">
                                        </a>
                                        <div class="card-body">
                                            <small class="text-muted d-block mb-2">{{ $relate->created_at->format('M d, Y') }}</small>
                                            <h5 class="card-title" style="font-size: 16px;">
                                                <a href="{{ route('singleNews', ['id' => $relate->id]) }}" class="text-dark text-decoration-none">
                                                    {{ Str::limit($relate->title, 50) }}
                                                </a>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <p class="text-muted small italic">No related posts found.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </article>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <aside class="ps-lg-4">
                    <!-- Search Widget -->
                    <div class="mb-5" data-aos="fade-up">
                        <h4 class="sidebar-title">Search</h4>
                        <form action="#" class="position-relative">
                            <input type="text" class="form-control py-2 ps-3 pe-5 rounded-pill" placeholder="Search news...">
                            <button class="btn position-absolute top-50 end-0 translate-middle-y text-primary border-0 bg-transparent pe-3">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>

                    <!-- Latest Posts -->
                    <div class="mb-5" data-aos="fade-up">
                        <h4 class="sidebar-title">Latest Posts</h4>
                        @foreach($latestPosts->take(4) as $latest)
                            <div class="sidebar-post-single">
                                <div class="sidebar-post-img">
                                    <a href="{{ route('singleNews', ['id' => $latest->id]) }}">
                                        <img src="{{ route('imagecache', ['template' => 'pnism', 'filename' => $latest->fi()]) }}" alt="{{ $latest->title }}">
                                    </a>
                                </div>
                                <div class="sidebar-post-content">
                                    <h5 class="sidebar-post-title">
                                        <a href="{{ route('singleNews', ['id' => $latest->id]) }}" class="text-decoration-none">
                                            {{ Str::limit($latest->title, 40) }}
                                        </a>
                                    </h5>
                                    <span class="sidebar-post-date">{{ $latest->created_at->format('d M, Y') }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Categories -->
                    <div class="mb-5" data-aos="fade-up">
                        <h4 class="sidebar-title">Categories</h4>
                        <ul class="category-list ps-0">
                            @foreach($newsCategories as $cat)
                                <li>
                                    <a href="#" class="text-decoration-none">
                                        <span>{{ $cat->name }}</span>
                                        <span class="text-muted small">({{ $cat->news_count ?? 0 }})</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Tags -->
                    <div class="mb-5" data-aos="fade-up">
                        <h4 class="sidebar-title">Popular Tags</h4>
                        <div class="tag-list">
                            <a href="#">Coffee</a>
                            <a href="#">Hill Tracts</a>
                            <a href="#">Farming</a>
                            <a href="#">Specialty</a>
                            <a href="#">Brewing</a>
                            <a href="#">Roasting</a>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</section>
@endsection
