@extends('website.layouts.sikhobd')

@section('title', 'সম্পূর্ণ বইটি পড়ুন — ' . ($ebook->title_bn ?? $ebook->title_en))

@section('content')
<section class="section" style="padding: 40px 0; background: #1e293b;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4 text-white">
            <div>
                <h2 style="font-weight: 700; margin-bottom: 5px;">{{ $ebook->title_bn ?? $ebook->title_en }}</h2>
                <p class="mb-0 opacity-75">আপনি সফলভাবে বইটি কিনেছেন। আপনার পড়ার অভিজ্ঞতা আনন্দদায়ক হোক।</p>
            </div>
            <a href="{{ route('ebooks.show', $ebook->id) }}" class="btn btn-outline-light px-4" style="border-radius: 50px;">
                <i class="fa-solid fa-arrow-left mr-2"></i> বিস্তারিত ফিরে যান
            </a>
        </div>

        <div class="reader-container bg-white shadow-lg" style="border-radius: 15px; overflow: hidden; height: 900px;">
            <iframe src="{{ asset('storage/ebook_files/' . $ebook->file_path) }}" width="100%" height="100%" frameborder="0"></iframe>
        </div>
    </div>
</section>
@endsection
