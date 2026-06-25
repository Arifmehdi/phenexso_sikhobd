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
                         <button type="button" class="btn btn-outline-primary px-5 py-3 ebook-detail-preview-btn" data-eid="{{ $ebook->id }}" style="border-radius: 50px; font-weight: 700;">
                             <i class="fa-solid fa-book-open mr-2"></i> বইটি কিছু অংশ পড়ুন
                         </button>
                        
                         @if($ebook->isFree())
                             <a href="{{ route('ebooks.read', $ebook->id) }}" class="btn btn-success px-5 py-3" style="border-radius: 50px; font-weight: 700;">
                                 <i class="fa-solid fa-book-reader mr-2"></i> পড়ুন
                             </a>
                             <a href="{{ route('ebooks.download', $ebook->id) }}" class="btn btn-outline-success px-4 py-3" style="border-radius: 50px; font-weight: 700;">
                                 <i class="fa-solid fa-download mr-2"></i> ডাউনলোড
                             </a>
                         @elseif($isEnrolled)
                             <a href="{{ route('ebooks.read', $ebook->id) }}" class="btn btn-success px-5 py-3" style="border-radius: 50px; font-weight: 700;">
                                 <i class="fa-solid fa-book-reader mr-2"></i> সম্পূর্ণ বইটি পড়ুন
                             </a>
                         @else
                             <button type="button" id="ebookMainBuyBtn" data-url="{{ route('ebooks.buy', $ebook->id) }}" class="btn btn-primary px-5 py-3" style="border-radius: 50px; font-weight: 700;">
                                 <i class="fa-solid fa-cart-shopping mr-2"></i> এখনই কিনুন
                             </button>
                             <a href="{{ route('ebooks.read', $ebook->id) }}" class="btn btn-outline-primary px-4 py-3" style="border-radius: 50px; font-weight: 700;">
                                 <i class="fa-solid fa-eye mr-2"></i> প্রিভিউ ({{ $ebook->preview_pages ?? 3 }} পৃষ্ঠা)
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

<!-- Preview Modal -->
<div class="modal fade" id="ebookPreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 850px; margin-top: 70px;">
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.3); overflow: hidden; height: 500px;">
            <div class="modal-body p-0 position-relative" style="display: flex; height: 100%;">
                <div id="ebookPreviewPdfContainer" style="flex: 1; background: #1e293b; position: relative;">
                    <div id="ebookPreviewLoader" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50); text-align: center; color: #fff;">
                        <i class="fa-solid fa-spinner fa-spin fa-2x mb-3"></i>
                        <p>প্রিভিউ লোড হচ্ছে...</p>
                    </div>
                    <iframe id="ebookPreviewFrame" src="" width="100%" height="100%" frameborder="0" style="display: none;"></iframe>
                </div>
                <div id="ebookPreviewSidebar" style="width: 260px; background: #fff; border-left: 1px solid var(--border); padding: 20px; display: flex; flex-direction: column; gap: 12px; overflow-y: auto; flex-shrink: 0;">
                    <button type="button" data-bs-dismiss="modal" aria-label="Close" style="position: absolute; top: 10px; right: 10px; z-index: 20; width: 30px; height: 30px; border-radius: 50%; background: #f1f5f9; border: none; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                        <i class="fa-solid fa-xmark" style="font-size: 13px;"></i>
                    </button>
                    <div style="margin-top: 16px;">
                        <img id="ebookPreviewCover" src="{{ asset('storage/ebook_covers/' . $ebook->cover_image) }}" alt="{{ $ebook->title_en }}" style="width: 100%; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                    </div>
                    <div>
                        <span id="ebookPreviewCategory" style="font-size: 10px; font-weight: 700; color: var(--accent); text-transform: uppercase; letter-spacing: 0.5px;">{{ optional($ebook->category)->name_bn ?? optional($ebook->category)->name_en }}</span>
                        <h3 id="ebookPreviewTitle" style="font-size: 15px; font-weight: 800; color: var(--primary); margin: 4px 0 2px; line-height: 1.3;">{{ $ebook->title_bn ?? $ebook->title_en }}</h3>
                        <p id="ebookPreviewAuthor" style="font-size: 12px; color: var(--text-muted); margin: 0;">
                            <i class="fa-solid fa-pen-nib me-1"></i> {{ $ebook->author_name ?? 'অজানা' }}
                        </p>
                    </div>
                    <div style="background: var(--bg-soft); padding: 10px 14px; border-radius: 8px;">
                        <div class="d-flex align-items-baseline gap-2">
                            <span id="ebookPreviewPrice" style="font-size: 20px; font-weight: 900; color: var(--primary);">৳{{ number_format($ebook->final_price, 2) }}</span>
                            @if($ebook->discount > 0)
                            <span id="ebookPreviewOriginalPrice" style="font-size: 13px; color: var(--text-muted); text-decoration: line-through;">৳{{ number_format($ebook->price, 2) }}</span>
                            @endif
                        </div>
                    </div>
                    <p id="ebookPreviewDescription" style="font-size: 12px; color: var(--text-soft); line-height: 1.5; margin: 0;">{{ Str::limit(strip_tags($ebook->description_bn ?? $ebook->description_en), 120) }}</p>
                    <div style="margin-top: auto; display: flex; flex-direction: column; gap: 6px;">
                         <button type="button" id="ebookDetailBuyBtn" data-url="{{ route('ebooks.buy', $ebook->id) }}" class="btn btn-primary" style="width: 100%; height: 40px; justify-content: center; border-radius: 8px; font-weight: 700; font-size: 13px;" {{ $isEnrolled ? 'disabled' : '' }}>
                             <i class="fa-solid fa-cart-shopping me-2"></i> {{ $isEnrolled ? 'কেনা হয়েছে' : 'এখনই কিনুন' }}
                         </button>
                        <button type="button" data-bs-dismiss="modal" class="btn btn-outline" style="width: 100%; height: 40px; justify-content: center; border-radius: 8px; font-size: 13px;">
                            বন্ধ করুন
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        $('.ebook-detail-preview-btn').on('click', function(e) {
            e.preventDefault();
            let ebookId = $(this).data('eid');

            $('#ebookPreviewFrame').hide().attr('src', '');
            $('#ebookPreviewLoader').show();
            $('#ebookPreviewModal').modal('show');

            $.get("{{ route('ebooks.preview') }}", {id: ebookId}, function(res) {
                if (res.pdf_url) {
                    $('#ebookPreviewFrame').on('load', function() {
                        $('#ebookPreviewLoader').hide();
                        $(this).show();
                    }).attr('src', res.pdf_url);
                }
            });
        });

        $('#ebookPreviewModal').on('hidden.bs.modal', function() {
            $('#ebookPreviewFrame').attr('src', '').hide();
            $('#ebookPreviewLoader').show();
        });

        // Main Buy button AJAX
        $('#ebookMainBuyBtn').on('click', function(e) {
            e.preventDefault();
            let btn = $(this);
            let url = btn.data('url');

            let originalText = btn.html();
            btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin me-2"></i> Adding...');

            $.ajax({
                url: url,
                method: "GET",
                dataType: "json",
                success: function(res) {
                    if (res.login_required) {
                        btn.prop('disabled', false).html(originalText);
                        showDetailLoginToast();
                        return;
                    }
                    if (res.status) {
                        window.location.href = "{{ route('new.checkout') }}";
                    }
                },
                error: function(xhr) {
                    btn.prop('disabled', false).html(originalText);
                    if (xhr.status === 401) {
                        showDetailLoginToast();
                    }
                }
            });
        });
            e.preventDefault();
            let btn = $(this);
            let url = btn.data('url');

            if (btn.prop('disabled')) return;

            let originalText = btn.html();
            btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin me-2"></i> Adding...');

            $.ajax({
                url: url,
                method: "GET",
                dataType: "json",
                success: function(res) {
                    if (res.login_required) {
                        btn.prop('disabled', false).html(originalText);
                        showDetailLoginToast();
                        return;
                    }
                    if (res.status) {
                        window.location.href = "{{ route('new.checkout') }}";
                    }
                },
                error: function(xhr) {
                    btn.prop('disabled', false).html(originalText);
                    if (xhr.status === 401) {
                        showDetailLoginToast();
                    }
                }
            });
        });

        function showDetailLoginToast() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: 'warning',
                title: 'কার্টে যোগ করতে প্রথমে লগইন করুন।',
                showCloseButton: true,
            });
        }
    });
</script>
@endpush
