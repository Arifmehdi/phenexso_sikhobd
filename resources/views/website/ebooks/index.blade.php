@extends('website.layouts.sikhobd')

@section('title', 'ই-বুক লাইব্রেরি — ' . ($ws->website_title ?? 'Qalam HR'))

@push('css')
<style>
    .ebook-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
    }
    @media (max-width: 991px) {
        .ebook-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 575px) {
        .ebook-grid { grid-template-columns: 1fr; }
    }

    .ebook-thumb {
        aspect-ratio: 260 / 372;
        background: #f8fafc;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border-bottom: 1px solid var(--border);
    }
    .ebook-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .ebook-card:hover .ebook-thumb img {
        transform: scale(1.05);
    }
    .ebook-preview-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(255,255,255,0.95);
        color: var(--primary);
        font-size: 11px;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 20px;
        z-index: 15;
        display: flex;
        align-items: center;
        gap: 4px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .ebook-preview-badge:hover {
        background: var(--accent);
        color: #fff;
    }
    .ebook-card .shop-actions {
        position: absolute;
        bottom: 10px;
        left: 0;
        right: 0;
        display: flex;
        justify-content: center;
        gap: 8px;
        opacity: 0;
        transform: translateY(10px);
        transition: all 0.3s ease;
        z-index: 10;
        pointer-events: none;
    }
    .ebook-card:hover .shop-actions {
        opacity: 1;
        transform: translateY(0);
        pointer-events: auto;
    }
    .ebook-card .shop-action-btn {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #fff;
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border);
        transition: all 0.2s;
        cursor: pointer;
    }
    .ebook-card .shop-action-btn:hover {
        background: var(--accent);
        color: #fff;
        border-color: var(--accent);
    }
    .ebook-card .shop-action-btn.ebook-preview-btn {
        background: #fef3c7;
        color: #d97706;
        border-color: #fbbf24;
    }
    .ebook-card .shop-action-btn.ebook-preview-btn:hover {
        background: #d97706;
        color: #fff;
        border-color: #d97706;
    }
    .ebook-card .in-cart-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: #28a745;
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 20px;
        z-index: 5;
        display: flex;
        align-items: center;
        gap: 4px;
        box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .ebook-card .in-cart-overlay {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(255,255,255,0.08);
        pointer-events: none;
        z-index: 1;
    }
    .ebook-card.in-cart-card {
        border-color: #28a745;
        box-shadow: 0 0 0 1px #28a745, var(--shadow-md);
    }
    .ebook-card.in-cart-card .ebook-thumb {
        background: #f0fff4;
    }
    .ebook-card .shop-cart-btn.in-cart-state,
    .ebook-card .shop-buy-btn.in-cart-state {
        background: #e8f5e9;
        color: #28a745;
        border-color: #28a745;
        cursor: default;
    }
    .ebook-card .shop-action-btn.in-cart-state {
        background: #28a745;
        color: #fff;
        border-color: #28a745;
        cursor: default;
    }
    .ebook-card .go-to-cart-link {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        padding: 6px 12px;
        background: #28a745;
        color: #fff;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
        flex: 1;
    }
    .ebook-card .go-to-cart-link:hover {
        background: #218838;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(40,167,69,0.3);
    }
    .ebook-card .shop-cart-btn,
    .ebook-card .shop-buy-btn {
        padding: 8px 12px;
        border: none;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        text-transform: capitalize;
        letter-spacing: 0.3px;
        flex: 1;
    }
    .ebook-card .shop-cart-btn {
        background: #f0f0f0;
        color: var(--primary);
        border: 1px solid var(--border);
    }
    .ebook-card .shop-cart-btn:hover {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .ebook-card .shop-buy-btn {
        background: var(--accent);
        color: #fff;
    }
    .ebook-card .shop-buy-btn:hover {
        background: var(--primary);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.15);
    }
    .ebook-card .shop-buy-btn:disabled,
    .ebook-card .shop-buy-btn.disabled {
        background: #ccc;
        color: #666;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }
</style>
@endpush

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
                <div class="ebook-grid">
                    @forelse($ebooks as $ebook)
                    @php $isInCart = in_array($ebook->id, $cartEbookIds ?? []); @endphp
                    <article class="card ebook-card {{ $isInCart ? 'in-cart-card' : '' }}" data-eid="{{ $ebook->id }}" style="border-radius: var(--radius-lg); overflow: hidden; border: 1px solid var(--border); transition: all 0.3s ease;">
                        <div class="ebook-thumb">
                            @if($isInCart)
                            <span class="in-cart-badge"><i class="fa-solid fa-check-circle"></i> In Cart</span>
                            @endif

                            @if($isInCart)<div class="in-cart-overlay"></div>@endif

                            <a href="{{ route('ebooks.show', $ebook->id) }}" style="display:block; width:100%; height:100%;">
                                <img src="{{ asset('storage/ebook_covers/' . $ebook->cover_image) }}" alt="{{ $ebook->title_en }}">
                            </a>

                            <span class="ebook-preview-badge"><i class="fa-solid fa-book-open-reader"></i> বইটি কিছু অংশ পড়ুন</span>

                            <div class="shop-actions">
                                <button class="shop-action-btn quick-view-btn" data-id="{{ $ebook->id }}" title="View Details"><i class="fa-regular fa-eye"></i></button>
                                @if($isInCart)
                                <button class="shop-action-btn in-cart-state" title="Already in Cart"><i class="fa-solid fa-check"></i></button>
                                @else
                                <button class="shop-action-btn addToEbookCart" data-url="{{ route('ebooks.buy', $ebook->id) }}" data-ebook="{{ $ebook->id }}" title="Add to Cart"><i class="fa-solid fa-cart-shopping"></i></button>
                                @endif
                               {{-- @if($ebook->preview_path)
                                <button class="shop-action-btn ebook-preview-btn" data-eid="{{ $ebook->id }}" title="বইটি কিছু অংশ পড়ুন"><i class="fa-solid fa-book-open-reader"></i></button>
                                @endif--}}
                                <a href="{{ route('ebooks.show', $ebook->id) }}" class="shop-action-btn" title="View Full Details"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <span style="font-size: 11px; color: var(--accent); font-weight: 700; text-transform: uppercase;">{{ optional($ebook->category)->name_bn ?? optional($ebook->category)->name_en }}</span>
                            <h3 style="margin-top: 5px; font-size: 15px; font-weight: 700; line-height: 1.4;">
                                <a href="{{ route('ebooks.show', $ebook->id) }}" style="text-decoration: none; color: inherit;">{{ Str::limit($ebook->title_bn ?? $ebook->title_en, 40) }}</a>
                            </h3>
                            <p style="font-size: 12px; color: var(--text-muted); margin: 4px 0 10px;"><i class="fa-solid fa-pen-nib me-1"></i> {{ $ebook->author_name ?? 'অজানা' }}</p>

                            <div style="display: flex; flex-direction: column; gap: 6px;">
                                <div class="shop-price-box" style="margin-bottom: 0;">
                                    <span style="font-size: 12px; color: var(--text-muted); font-weight: 600;">Price :</span>
                                    <span class="price" style="font-size: 16px; font-weight: 700; color: var(--accent);">৳{{ number_format($ebook->price, 2) }}</span>
                                </div>
                                <div style="display: flex; flex-direction: row; gap: 8px; width: 100%;">
                                    @if($isInCart)
                                    <a href="{{ route('cart') }}" class="go-to-cart-link">
                                        <i class="fa-solid fa-cart-shopping"></i> Go to Cart
                                    </a>
                                    <button class="shop-buy-btn in-cart-state" disabled>
                                        <i class="fa-solid fa-check"></i> In Cart
                                    </button>
                                    @else
                                    <button class="shop-cart-btn addToEbookCart" data-url="{{ route('ebooks.buy', $ebook->id) }}" data-ebook="{{ $ebook->id }}" title="Add to Cart">
                                        <i class="fa-solid fa-cart-plus"></i> Add To Cart
                                    </button>
                                    <a href="{{ route('ebooks.buy', $ebook->id) }}" class="shop-buy-btn" title="Buy Now" style="text-decoration: none;">
                                        <i class="fa-solid fa-bolt"></i> Buy Now
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </article>
                    @empty
                    <div style="grid-column: 1/-1; text-align: center; padding: 60px; background: var(--bg-soft); border-radius: var(--radius-lg);">
                        <i class="fa-solid fa-book-open" style="font-size: 48px; color: var(--text-muted); margin-bottom: 20px;"></i>
                        <h3 style="color: var(--text-soft);">কোনো ই-বুক পাওয়া যায়নি</h3>
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

<!-- Quick View Modal -->
<div class="modal fade" id="ebookQuickViewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.15); overflow: hidden;">
            <div class="modal-body p-0 position-relative" id="ebookQuickViewContent"></div>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="ebookPreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 850px; margin-top: 70px;">
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.3); overflow: hidden; height: 500px;">
            <div class="modal-body p-0 position-relative" style="display: flex; height: 100%;">
                <!-- PDF Viewer -->
                <div id="ebookPreviewPdfContainer" style="flex: 1; background: #1e293b; position: relative;">
                    <div id="ebookPreviewLoader" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50); text-align: center; color: #fff;">
                        <i class="fa-solid fa-spinner fa-spin fa-2x mb-3"></i>
                        <p>প্রিভিউ লোড হচ্ছে...</p>
                    </div>
                    <iframe id="ebookPreviewFrame" src="" width="100%" height="100%" frameborder="0" style="display: none;"></iframe>
                </div>
                <!-- Right Sidebar Tooltip -->
                <div id="ebookPreviewSidebar" style="width: 260px; background: #fff; border-left: 1px solid var(--border); padding: 20px; display: flex; flex-direction: column; gap: 12px; overflow-y: auto; flex-shrink: 0;">
                    <button type="button" data-bs-dismiss="modal" aria-label="Close" style="position: absolute; top: 10px; right: 10px; z-index: 20; width: 30px; height: 30px; border-radius: 50%; background: #f1f5f9; border: none; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                        <i class="fa-solid fa-xmark" style="font-size: 13px;"></i>
                    </button>
                    <div style="margin-top: 16px;">
                        <img id="ebookPreviewCover" src="" alt="" style="width: 100%; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                    </div>
                    <div>
                        <span id="ebookPreviewCategory" style="font-size: 10px; font-weight: 700; color: var(--accent); text-transform: uppercase; letter-spacing: 0.5px;"></span>
                        <h3 id="ebookPreviewTitle" style="font-size: 15px; font-weight: 800; color: var(--primary); margin: 4px 0 2px; line-height: 1.3;"></h3>
                        <p id="ebookPreviewAuthor" style="font-size: 12px; color: var(--text-muted); margin: 0;">
                            <i class="fa-solid fa-pen-nib me-1"></i> <span></span>
                        </p>
                    </div>
                    <div style="background: var(--bg-soft); padding: 10px 14px; border-radius: 8px;">
                        <div class="d-flex align-items-baseline gap-2">
                            <span id="ebookPreviewPrice" style="font-size: 20px; font-weight: 900; color: var(--primary);"></span>
                            <span id="ebookPreviewOriginalPrice" style="font-size: 13px; color: var(--text-muted); text-decoration: line-through;"></span>
                        </div>
                    </div>
                    <p id="ebookPreviewDescription" style="font-size: 12px; color: var(--text-soft); line-height: 1.5; margin: 0;"></p>
                    <div style="margin-top: auto; display: flex; flex-direction: column; gap: 6px;">
                        <a id="ebookPreviewBuyBtn" href="#" class="btn btn-primary" style="width: 100%; height: 40px; justify-content: center; border-radius: 8px; font-weight: 700; font-size: 13px;">
                            <i class="fa-solid fa-cart-shopping me-2"></i> এখনই কিনুন
                        </a>
                        <a id="ebookPreviewDetailsBtn" href="#" class="btn btn-outline" style="width: 100%; height: 40px; justify-content: center; border-radius: 8px; font-size: 13px;">
                            বিস্তারিত দেখুন <i class="fa-solid fa-arrow-right ms-1"></i>
                        </a>
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
        // Quick View AJAX for ebooks
        $(document).on('click', '.ebook-card .quick-view-btn', function() {
            let id = $(this).data('id');
            $('#ebookQuickViewModal').modal('show');
            $('#ebookQuickViewContent').html('<div class="p-5 text-center"><i class="fa-solid fa-spinner fa-spin fa-2x" style="color: var(--accent);"></i></div>');

            $.get("{{ route('ebooks.quick.view') }}", {id: id}, function(res) {
                $('#ebookQuickViewContent').html(res.html);
            });
        });

        // Transform ebook card to "in-cart" state after AJAX add
        function markEbookInCart(ebookId) {
            let $card = $('article.ebook-card[data-eid="' + ebookId + '"]');
            $card.addClass('in-cart-card');

            let $thumb = $card.find('.ebook-thumb');
            if (!$thumb.find('.in-cart-badge').length) {
                $thumb.prepend('<span class="in-cart-badge"><i class="fa-solid fa-check-circle"></i> In Cart</span>');
                if (!$thumb.find('.in-cart-overlay').length) {
                    $thumb.append('<div class="in-cart-overlay"></div>');
                }
            }

            // Icon buttons
            $card.find('.shop-action-btn.addToEbookCart').each(function() {
                let $btn = $(this);
                $btn.removeClass('addToEbookCart').addClass('in-cart-state')
                    .attr('title', 'Already in Cart')
                    .html('<i class="fa-solid fa-check"></i>');
            });

            // Text buttons
            $card.find('.shop-cart-btn.addToEbookCart').replaceWith(
                '<a href="{{ route('cart') }}" class="go-to-cart-link"><i class="fa-solid fa-cart-shopping"></i> Go to Cart</a>'
            );
            $card.find('.shop-buy-btn').not('.in-cart-state').replaceWith(
                '<button class="shop-buy-btn in-cart-state" disabled><i class="fa-solid fa-check"></i> In Cart</button>'
            );
        }

        // Preview Modal — open PDF in modal with sidebar tooltip
        function openEbookPreview(ebookId) {
            let $card = $('article.ebook-card[data-eid="' + ebookId + '"]');

            // Reset modal
            $('#ebookPreviewFrame').hide().attr('src', '');
            $('#ebookPreviewLoader').show();

            // Populate sidebar from card data
            let $thumbImg = $card.find('.ebook-thumb img');
            let $titleLink = $card.find('h3 a');
            let $authorText = $card.find('.card-body p').first().text().trim();
            let $price = $card.find('.price').text().trim();
            let $category = $card.find('.card-body span').first().text().trim();
            let detailsUrl = $card.find('h3 a').attr('href');
            let buyUrl = $card.find('.addToEbookCart, .go-to-cart-link').first().data('url') || $card.find('.addToEbookCart, .go-to-cart-link').first().attr('href') || '#';

            $('#ebookPreviewCover').attr('src', $thumbImg.attr('src'));
            $('#ebookPreviewTitle').text($titleLink.text().trim());
            $('#ebookPreviewAuthor span').text($authorText.replace('✍', '').trim());
            $('#ebookPreviewPrice').text($price);
            $('#ebookPreviewCategory').text($category);
            $('#ebookPreviewOriginalPrice').text('');
            $('#ebookPreviewDescription').text('');
            $('#ebookPreviewBuyBtn').attr('href', buyUrl);
            $('#ebookPreviewDetailsBtn').attr('href', detailsUrl);

            $('#ebookPreviewModal').modal('show');

            // Fetch PDF URL via AJAX
            $.get("{{ route('ebooks.preview') }}", {id: ebookId}, function(res) {
                if (res.pdf_url) {
                    $('#ebookPreviewFrame').on('load', function() {
                        $('#ebookPreviewLoader').hide();
                        $(this).show();
                    }).attr('src', res.pdf_url);
                }
            });

            // Fetch full description via AJAX
            $.get("{{ route('ebooks.quick.view') }}", {id: ebookId}, function(res) {
                if (res.html) {
                    let $tmp = $('<div>').html(res.html);
                    let desc = $tmp.find('p').last().text().trim();
                    let origPrice = $tmp.find('span[style*="line-through"]').text().trim();
                    if (desc) $('#ebookPreviewDescription').text(desc);
                    if (origPrice) $('#ebookPreviewOriginalPrice').text(origPrice);
                }
            });
        }

        $(document).on('click', '.ebook-preview-badge', function(e) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            let ebookId = $(this).closest('.ebook-card').data('eid');
            openEbookPreview(ebookId);
            return false;
        });

        $(document).on('click', '.ebook-preview-btn', function(e) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            let ebookId = $(this).data('eid');
            openEbookPreview(ebookId);
            return false;
        });

        // Reset iframe on modal close
        $('#ebookPreviewModal').on('hidden.bs.modal', function() {
            $('#ebookPreviewFrame').attr('src', '').hide();
            $('#ebookPreviewLoader').show();
        });

        // Add to Cart AJAX for ebooks
        $(document).on('click', '.addToEbookCart', function(e) {
            e.preventDefault();
            e.stopPropagation();
            let btn = $(this);
            let ebookId = btn.data('ebook') || btn.data('id');
            let url = btn.data('url');

            if (btn.prop('disabled')) return;

            let originalContent = btn.html();
            btn.prop('disabled', true).addClass('disabled');

            if (btn.hasClass('shop-action-btn')) {
                btn.html('<i class="fa-solid fa-spinner fa-spin"></i>');
            } else {
                btn.text('Adding...');
            }

            $.ajax({
                url: url,
                method: "GET",
                dataType: "json",
                success: function(res) {
                    if (res.login_required) {
                        showLoginToast();
                        btn.html(originalContent);
                        btn.prop('disabled', false).removeClass('disabled');
                        return;
                    }
                    if (res.status) {
                        $('.cartCount').text(parseInt($('.cartCount').text() || 0) + 1);
                        markEbookInCart(ebookId);
                        showCartNotification(res.message, 'success');
                    }
                },
                error: function(xhr) {
                    btn.html(originalContent);
                    btn.prop('disabled', false).removeClass('disabled');
                    if (xhr.status === 401) {
                        showLoginToast();
                    }
                }
            });
        });

        function showLoginToast() {
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
