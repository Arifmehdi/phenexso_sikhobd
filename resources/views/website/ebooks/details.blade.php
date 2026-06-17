@extends('website.layouts.sikhobd')

@section('title', ($ebook->title_bn ?? $ebook->title_en) . ' — ' . ($ws->website_title ?? 'Qalam HR'))

@section('content')
<section class="section" style="padding: 60px 0; background: #f8fafc;">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb bg-transparent p-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">হোম</a></li>
                <li class="breadcrumb-item"><a href="{{ route('ebooks.index') }}">ই-বুক</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $ebook->title_bn ?? $ebook->title_en }}</li>
            </ol>
        </nav>

        <div class="row g-5">
            <div class="col-lg-4">
                <div class="card border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
                    <img src="{{ asset('storage/ebook_covers/' . $ebook->cover_image) }}" class="img-fluid" alt="{{ $ebook->title_en }}">
                </div>
            </div>

            <div class="col-lg-8">
                <div class="ebook-info">
                    <span class="badge bg-primary text-white mb-3" style="padding: 8px 15px; border-radius: 30px;">{{ optional($ebook->category)->name_bn ?? optional($ebook->category)->name_en }}</span>
                    <h1 style="font-weight: 800; color: #1e293b; margin-bottom: 15px;">{{ $ebook->title_bn ?? $ebook->title_en }}</h1>
                    <p class="text-muted mb-4" style="font-size: 18px;">লেখক: <strong>{{ $ebook->author_name ?? 'অজানা' }}</strong></p>
                    
                    <div class="price-box mb-5 p-4" style="background: white; border-radius: 15px; border-left: 5px solid var(--primary);">
                        <h4 style="font-weight: 700; margin-bottom: 5px;">ই-বুক মূল্য: ৳{{ number_format($ebook->price, 2) }}</h4>
                        <p class="text-muted mb-0 small">একবার কিনুন এবং আজীবন এক্সেস করুন</p>
                    </div>

                    <div class="d-flex flex-wrap gap-3 mb-5">
                        <a href="{{ route('ebooks.preview', $ebook->id) }}" class="btn btn-outline-primary px-5 py-3" style="border-radius: 50px; font-weight: 700;">
                            <i class="fa-solid fa-book-open mr-2"></i> বইটি কিছু অংশ পড়ুন
                        </a>
                        
                        @if($isEnrolled)
                            <a href="{{ route('ebooks.read', $ebook->id) }}" class="btn btn-success px-5 py-3" style="border-radius: 50px; font-weight: 700;">
                                <i class="fa-solid fa-book-reader mr-2"></i> সম্পূর্ণ বইটি পড়ুন
                            </a>
                        @else
                            <a href="{{ route('ebooks.buy', $ebook->id) }}" class="btn btn-primary px-5 py-3" style="border-radius: 50px; font-weight: 700;">
                                <i class="fa-solid fa-cart-shopping mr-2"></i> সম্পূর্ণ বইটি কিনুন
                            </a>
                        @endif
                    </div>

                    <div class="description mt-5">
                        <h4 style="font-weight: 700; border-bottom: 2px solid #e2e8f0; padding-bottom: 15px; margin-bottom: 20px;">বই সম্পর্কে তথ্য</h4>
                        <div class="text-muted" style="line-height: 1.8; font-size: 16px;">
                            {!! nl2br(e($ebook->description_bn ?? $ebook->description_en)) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
