@extends('website.layouts.sikhobd')

@section('title', 'বইয়ের প্রিভিউ — ' . ($ebook->title_bn ?? $ebook->title_en))

@section('content')
<section class="section" style="padding: 40px 0; background: #334155;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4 text-white">
            <div>
                <h2 style="font-weight: 700; margin-bottom: 5px;">{{ $ebook->title_bn ?? $ebook->title_en }} (প্রিভিউ)</h2>
                <p class="mb-0 opacity-75">আপনি বইটির প্রথম কয়েক পাতা পড়ার সুযোগ পাচ্ছেন। সম্পূর্ণ পড়তে বইটি কিনুন।</p>
            </div>
            <a href="{{ route('ebooks.show', $ebook->id) }}" class="btn btn-primary px-4" style="border-radius: 50px;">
                <i class="fa-solid fa-arrow-left mr-2"></i> বিস্তারিত ফিরে যান
            </a>
        </div>

        <div class="preview-container bg-white shadow-lg" style="border-radius: 15px; overflow: hidden; height: 800px;">
            <iframe src="{{ asset('storage/ebook_previews/' . $ebook->preview_path) }}#toolbar=0" width="100%" height="100%" frameborder="0"></iframe>
        </div>

        <div class="mt-5 text-center">
            <a href="{{ route('ebooks.buy', $ebook->id) }}" class="btn btn-primary btn-lg px-5 py-3" style="border-radius: 50px; font-weight: 700;">
                <i class="fa-solid fa-cart-shopping mr-2"></i> সম্পূর্ণ বইটি এখনই কিনুন
            </a>
        </div>
    </div>
</section>
@endsection
