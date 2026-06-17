@extends('website.layouts.sikhobd')

@section('title', 'ই-বুক লাইব্রেরি — ' . ($ws->website_title ?? 'Qalam HR'))

@section('content')
<section class="section" style="padding: 60px 0; background: #f8fafc;">
    <div class="container">
        <div class="section-header mb-5">
            <h2 style="font-weight: 800; color: #1e293b; margin-bottom: 10px;">ই-বুক লাইব্রেরি</h2>
            <p class="text-muted">আপনার পছন্দের বই খুঁজে নিন এবং পড়া শুরু করুন</p>
        </div>

        <div class="row">
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-body">
                        <h5 style="font-weight: 700; margin-bottom: 20px;">ক্যাটেগরি</h5>
                        <ul class="list-unstyled mb-0">
                            <li>
                                <a href="{{ route('ebooks.index') }}" class="d-flex justify-content-between align-items-center py-2 {{ !request('category') ? 'text-primary font-weight-bold' : 'text-muted' }}">
                                    সব ই-বুক
                                </a>
                            </li>
                            @foreach($categories as $category)
                            <li>
                                <a href="{{ route('ebooks.index', ['category' => $category->id]) }}" class="d-flex justify-content-between align-items-center py-2 {{ request('category') == $category->id ? 'text-primary font-weight-bold' : 'text-muted' }}">
                                    {{ $category->name_bn ?? $category->name_en }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="row g-4">
                    @forelse($ebooks as $ebook)
                    <div class="col-md-4 col-sm-6">
                        <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; overflow: hidden; transition: transform 0.3s;">
                            <a href="{{ route('ebooks.show', $ebook->id) }}">
                                <img src="{{ asset('storage/ebook_covers/' . $ebook->cover_image) }}" class="card-img-top" style="height: 300px; object-fit: cover;" alt="{{ $ebook->title_en }}">
                            </a>
                            <div class="card-body p-4">
                                <span class="badge bg-primary-soft text-primary mb-2" style="font-size: 11px;">{{ optional($ebook->category)->name_bn ?? optional($ebook->category)->name_en }}</span>
                                <h5 class="card-title" style="font-weight: 700; font-size: 16px; margin-bottom: 10px;">
                                    <a href="{{ route('ebooks.show', $ebook->id) }}" class="text-dark text-decoration-none">{{ $ebook->title_bn ?? $ebook->title_en }}</a>
                                </h5>
                                <p class="text-muted small mb-3">লেখক: {{ $ebook->author_name ?? 'অজানা' }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="price">
                                        <span style="font-weight: 800; color: var(--primary); font-size: 18px;">৳{{ number_format($ebook->price, 2) }}</span>
                                    </div>
                                    <div class="views text-muted small">
                                        <i class="fa-solid fa-eye mr-1"></i> {{ $ebook->view_count }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center py-5">
                        <img src="{{ asset('img/no-data.svg') }}" width="200" alt="">
                        <p class="mt-4 text-muted">কোনো ই-বুক পাওয়া যায়নি</p>
                    </div>
                    @endforelse
                </div>

                <div class="mt-5">
                    {{ $ebooks->links() }}
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .bg-primary-soft { background-color: rgba(var(--primary-rgb), 0.1); }
    .card:hover { transform: translateY(-10px); }
</style>
@endsection
