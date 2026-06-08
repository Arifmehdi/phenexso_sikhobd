@extends('website.layouts.sikhobd')

@section('title', $queryString ? 'Search: ' . $queryString : 'Search')

@section('content')
<style>
    .transition-hover {
        transition: all 0.3s ease;
    }
    .transition-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .card-img-container {
        position: relative;
        overflow: hidden;
        padding-top: 66.66%; /* 3:2 Aspect Ratio */
    }
    .card-img-container img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .transition-hover:hover .card-img-container img {
        transform: scale(1.08);
    }
    .badge-category {
        position: absolute;
        top: 15px;
        right: 15px;
        z-index: 10;
        backdrop-filter: blur(4px);
        background: rgba(0, 0, 0, 0.5) !important;
    }
    .search-input-group {
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        border-radius: 10px;
        overflow: hidden;
    }
    .search-input-group input {
        border: none;
        padding: 12px 20px;
    }
    .search-input-group button {
        padding: 0 25px;
    }
</style>

<section class="search-results-page py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <h1 class="display-5 fw-bold mb-3">{{ app()->getLocale() == 'bn' ? 'সার্চ ফলাফল' : 'Search results' }}</h1>
                <p class="lead text-muted mb-4">
                    @if($queryString)
                        {{ $products->total() }} {{ app()->getLocale() == 'bn' ? 'টি ফলাফল পাওয়া গেছে' : 'results found for' }} "<strong>{{ $queryString }}</strong>"
                    @else
                        {{ app()->getLocale() == 'bn' ? 'প্রোডাক্ট বা কোর্সের জন্য একটি শব্দ লিখুন।' : 'Enter a term to search products and courses.' }}
                    @endif
                </p>
                
                <form action="{{ route('search') }}" method="get" class="search-input-group d-flex bg-white">
                    <input type="hidden" name="type" value="{{ $type ?? 'all' }}">
                    <input type="search" name="q" value="{{ $queryString }}" class="form-control" placeholder="{{ app()->getLocale() == 'bn' ? 'প্রোডাক্ট বা কোর্স খুঁজুন...' : 'Search products or courses...' }}" required>
                    <button type="submit" class="btn btn-primary">{{ app()->getLocale() == 'bn' ? 'খুঁজুন' : 'Search' }}</button>
                </form>

                @if($queryString)
                    <div class="mt-4">
                        <div class="btn-group rounded-pill p-1 bg-white shadow-sm" role="group">
                            <a href="{{ route('search', ['q' => $queryString, 'type' => 'all']) }}" class="btn btn-sm rounded-pill px-4 {{ $type === 'all' ? 'btn-primary' : 'btn-light text-muted' }}">
                                {{ app()->getLocale() == 'bn' ? 'সব' : 'All' }}
                            </a>
                            <a href="{{ route('search', ['q' => $queryString, 'type' => 'course']) }}" class="btn btn-sm rounded-pill px-4 {{ $type === 'course' ? 'btn-primary' : 'btn-light text-muted' }}">
                                {{ app()->getLocale() == 'bn' ? 'কোর্স' : 'Courses' }}
                            </a>
                            <a href="{{ route('search', ['q' => $queryString, 'type' => 'product']) }}" class="btn btn-sm rounded-pill px-4 {{ $type === 'product' ? 'btn-primary' : 'btn-light text-muted' }}">
                                {{ app()->getLocale() == 'bn' ? 'প্রোডাক্ট' : 'Products' }}
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        @if($products->count())
            <div class="row g-4">
                @foreach($products as $product)
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card h-100 border-0 shadow-sm transition-hover overflow-hidden">
                            <div class="card-img-container">
                                <a href="{{ route($product->type === 'course' ? 'courseDetail' : 'productDetails', $product->slug) }}">
                                    <img src="{{ route('imagecache', ['template' => 'pnimd', 'filename' => $product->fi()]) }}" 
                                         alt="{{ $product->name_en }}">
                                </a>
                                <span class="badge badge-category rounded-pill px-3 py-2">
                                    {{ $product->type === 'course' ? (app()->getLocale() == 'bn' ? 'কোর্স' : 'Course') : (app()->getLocale() == 'bn' ? 'প্রোডাক্ট' : 'Product') }}
                                </span>
                            </div>
                            <div class="card-body d-flex flex-column p-4">
                                <h2 class="h5 fw-bold mb-2">
                                    <a href="{{ route($product->type === 'course' ? 'courseDetail' : 'productDetails', $product->slug) }}" class="text-decoration-none text-dark hover-primary">
                                        {{ app()->getLocale() == 'bn' ? ($product->name_bn ?: $product->name_en) : $product->name_en }}
                                    </a>
                                </h2>
                                <p class="text-muted small mb-4 flex-grow-1">
                                    {{ \Illuminate\Support\Str::limit(app()->getLocale() == 'bn' ? ($product->excerpt_bn ?: $product->description_bn) : ($product->excerpt_en ?: $product->description_en), 100) }}
                                </p>
                                <div class="d-flex align-items-center justify-content-between mt-3">
                                    <div>
                                        <span class="h5 fw-bold text-primary mb-0">{{ number_format($product->selling_price, 0) }} ৳</span>
                                        @if($product->discount_price && $product->discount_price > 0)
                                            <span class="text-muted text-decoration-line-through small ms-2">{{ number_format($product->discount_price, 0) }} ৳</span>
                                        @endif
                                    </div>
                                    <a href="{{ route($product->type === 'course' ? 'courseDetail' : 'productDetails', $product->slug) }}" class="btn btn-outline-primary rounded-pill px-4 btn-sm fw-bold">
                                        {{ app()->getLocale() == 'bn' ? 'বিস্তারিত' : 'Details' }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="d-flex justify-content-center mt-5">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fa-solid fa-magnifying-glass text-muted" style="font-size: 4rem;"></i>
                </div>
                <h3 class="h4 text-muted">{{ app()->getLocale() == 'bn' ? 'কোনো ফলাফল খুঁজে পাওয়া যায়নি' : 'No results found' }}</h3>
                <p class="text-muted">{{ app()->getLocale() == 'bn' ? 'অনুগ্রহ করে অন্য কোনো শব্দ দিয়ে আবার চেষ্টা করুন।' : 'Please try searching with different keywords.' }}</p>
            </div>

            @if($suggestions->count())
                <div class="mt-5">
                    <div class="d-flex align-items-center mb-4">
                        <hr class="flex-grow-1">
                        <h3 class="h5 px-3 mb-0 text-muted">{{ app()->getLocale() == 'bn' ? 'আপনার অনুসন্ধানের জন্য প্রস্তাবিত ফলাফল' : 'Suggested results' }}</h3>
                        <hr class="flex-grow-1">
                    </div>
                    <div class="row g-4">
                        @foreach($suggestions as $product)
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="card h-100 border-0 shadow-sm transition-hover overflow-hidden">
                                    <div class="card-img-container">
                                        <a href="{{ route($product->type === 'course' ? 'courseDetail' : 'productDetails', $product->slug) }}">
                                            <img src="{{ route('imagecache', ['template' => 'pnimd', 'filename' => $product->fi()]) }}" 
                                                 alt="{{ $product->name_en }}">
                                        </a>
                                        <span class="badge badge-category rounded-pill px-3 py-2">
                                            {{ $product->type === 'course' ? (app()->getLocale() == 'bn' ? 'কোর্স' : 'Course') : (app()->getLocale() == 'bn' ? 'প্রোডাক্ট' : 'Product') }}
                                        </span>
                                    </div>
                                    <div class="card-body d-flex flex-column p-4">
                                        <h2 class="h6 fw-bold mb-2">
                                            <a href="{{ route($product->type === 'course' ? 'courseDetail' : 'productDetails', $product->slug) }}" class="text-decoration-none text-dark hover-primary">
                                                {{ app()->getLocale() == 'bn' ? ($product->name_bn ?: $product->name_en) : $product->name_en }}
                                            </a>
                                        </h2>
                                        <p class="text-muted small mb-4 flex-grow-1">
                                            {{ \Illuminate\Support\Str::limit(app()->getLocale() == 'bn' ? ($product->excerpt_bn ?: $product->description_bn) : ($product->excerpt_en ?: $product->description_en), 80) }}
                                        </p>
                                        <div class="d-flex align-items-center justify-content-between mt-3">
                                            <span class="fw-bold text-primary">{{ number_format($product->selling_price, 0) }} ৳</span>
                                            <a href="{{ route($product->type === 'course' ? 'courseDetail' : 'productDetails', $product->slug) }}" class="btn btn-link p-0 text-decoration-none fw-bold small">
                                                {{ app()->getLocale() == 'bn' ? 'বিস্তারিত' : 'Details' }} →
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif
    </div>
</section>
@endsection
