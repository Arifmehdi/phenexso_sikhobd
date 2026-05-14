@extends('website.layouts.sikhobd')

@section('title', $product->name_en . ' — ' . ($ws->name ?? env('APP_NAME')))

@push('css')
<style>
    .product-details-container {
        background: #fff;
        border-radius: var(--radius-lg);
        border: 1px solid var(--border);
        padding: 40px;
        margin-bottom: 40px;
    }
    .main-image-box {
        aspect-ratio: 1 / 1;
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        margin-bottom: 20px;
    }
    .main-image-box img {
        max-width: 90%;
        max-height: 90%;
        object-fit: contain;
        transition: transform 0.5s ease;
    }
    .thumb-gallery {
        display: flex;
        gap: 12px;
        overflow-x: auto;
        padding-bottom: 10px;
    }
    .thumb-item {
        width: 80px;
        height: 80px;
        border-radius: 12px;
        border: 2px solid var(--border);
        background: #fff;
        cursor: pointer;
        padding: 8px;
        flex-shrink: 0;
        transition: all 0.2s;
    }
    .thumb-item.active, .thumb-item:hover {
        border-color: var(--accent);
    }
    .thumb-item img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
    .product-meta-top {
        font-size: 14px;
        color: var(--accent);
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 12px;
        letter-spacing: 0.5px;
    }
    .product-main-title {
        font-size: 32px;
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 16px;
        line-height: 1.2;
    }
    .product-rating {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 24px;
    }
    .stars { color: #f59e0b; font-size: 14px; }
    .review-count { font-size: 14px; color: var(--text-muted); }
    
    .price-section {
        background: var(--bg-soft);
        padding: 24px;
        border-radius: var(--radius);
        margin-bottom: 30px;
    }
    .price-now-lg {
        font-size: 36px;
        font-weight: 900;
        color: var(--primary);
    }
    .price-was-lg {
        font-size: 18px;
        color: var(--text-muted);
        text-decoration: line-through;
        margin-left: 12px;
    }
    .discount-tag-lg {
        background: var(--accent);
        color: #fff;
        padding: 4px 12px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 700;
        margin-left: 15px;
    }
    
    .qty-box {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 30px;
    }
    .qty-selector {
        display: flex;
        align-items: center;
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 5px;
    }
    .qty-btn {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        border: none;
        background: var(--bg-soft);
        color: var(--primary);
        font-weight: 700;
        transition: all 0.2s;
    }
    .qty-btn:hover { background: var(--border); }
    .qty-input {
        width: 50px;
        border: none;
        text-align: center;
        font-weight: 700;
        font-size: 16px;
        outline: none;
    }
    
    .buy-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-bottom: 30px;
    }
    
    /* Tabs */
    .cd-tabs {
        display: flex;
        gap: 40px;
        border-bottom: 1px solid var(--border);
        margin-bottom: 30px;
    }
    .cd-tabs button {
        background: none;
        border: none;
        padding: 15px 0;
        font-weight: 700;
        font-size: 16px;
        color: var(--text-muted);
        position: relative;
        cursor: pointer;
    }
    .cd-tabs button.active {
        color: var(--primary);
    }
    .cd-tabs button.active::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        width: 100%;
        height: 3px;
        background: var(--accent);
    }

    /* Robust Custom Grid for Side-by-Side */
    .pd-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
    }
    @media (max-width: 991px) {
        .pd-grid {
            grid-template-columns: 1fr;
            gap: 30px;
        }
    }

    /* Related Products Grid */
    .shop-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
    }
    @media (max-width: 991px) {
        .shop-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 575px) {
        .shop-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
<section class="page-hero">
    <div class="container">
        <div class="crumbs" style="margin-bottom: 10px;">
            <a href="{{ route('home') }}">Home</a> <span>/</span> 
            <a href="{{ route('shop') }}">Shop</a> <span>/</span> 
            <span style="color: var(--accent);">{{ $product->name_en }}</span>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <!-- Main Product Section -->
        <div class="product-details-container">
            <!-- Using custom pd-grid to FORCE side-by-side -->
            <div class="pd-grid">
                <!-- Left: Gallery -->
                <div>
                    <div class="main-image-box">
                        <img id="mainImage" src="{{ route('imagecache', ['template' => 'original', 'filename' => $product->fi()]) }}" alt="{{ $product->name_en }}">
                    </div>
                    
                    <div class="thumb-gallery">
                        <div class="thumb-item active" onclick="changeImage(this, '{{ route('imagecache', ['template' => 'original', 'filename' => $product->fi()]) }}')">
                            <img src="{{ route('imagecache', ['template' => 'original', 'filename' => $product->fi()]) }}" alt="">
                        </div>
                        @foreach($product->media as $media)
                        <div class="thumb-item" onclick="changeImage(this, '{{ route('imagecache', ['template' => 'original', 'filename' => $media->file_name]) }}')">
                            <img src="{{ route('imagecache', ['template' => 'original', 'filename' => $media->file_name]) }}" alt="">
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Right: Content -->
                <div>
                    <div class="product-meta-top">{{ $product->categories->first()->name_en ?? 'General Product' }}</div>
                    <h1 class="product-main-title">{{ $product->name_en }}</h1>
                    
                    <div class="product-rating">
                        <div class="stars">
                            @php $avgRating = $product->averageRating(); @endphp
                            @for($i = 1; $i <= 5; $i++)
                                <i class="{{ $i <= $avgRating ? 'fas' : 'far' }} fa-star"></i>
                            @endfor
                        </div>
                        <span class="review-count">({{ $product->reviews->count() }} Reviews)</span>
                        <span style="color: var(--border);">|</span>
                        <span class="review-count"><i class="fa-solid fa-check-circle" style="color: var(--success);"></i> In Stock</span>
                    </div>

                    <div class="price-section">
                        <div class="d-flex align-items-center">
                            <span class="price-now-lg">৳{{ number_format($product->selling_price) }}</span>
                            @if($product->discount > 0)
                            <span class="price-was-lg">৳{{ number_format($product->price) }}</span>
                            <span class="discount-tag-lg">{{ $product->discount }}% OFF</span>
                            @endif
                        </div>
                    </div>

                    <div style="color: var(--text-soft); line-height: 1.6; margin-bottom: 30px;">
                        {!! Str::limit(strip_tags($product->description_en), 200) !!}
                    </div>

                    <div class="qty-box">
                        <span style="font-weight: 700; color: var(--primary);">Quantity:</span>
                        <div class="qty-selector">
                            <button class="qty-btn" onclick="updateQty(-1)">-</button>
                            <input type="text" id="mainQty" class="qty-input" value="1" readonly>
                            <button class="qty-btn" onclick="updateQty(1)">+</button>
                        </div>
                    </div>

                    <div class="buy-actions">
                        <button class="btn btn-primary addToCartDetail" data-product="{{ $product->id }}" data-url="{{ route('addToCart') }}" style="height: 56px; justify-content: center; font-size: 16px;">
                            <i class="fa-solid fa-basket-shopping me-2"></i> Add to Cart
                        </button>
                        <button class="btn btn-accent buyNowDetail" data-product="{{ $product->id }}" data-url="{{ route('addToCart') }}" style="height: 56px; justify-content: center; font-size: 16px;">
                            Buy Now
                        </button>
                    </div>

                    <div style="padding-top: 20px; border-top: 1px solid var(--border); display: grid; gap: 10px; font-size: 14px;">
                        <div><strong style="color: var(--primary);">Categories:</strong> 
                            @foreach($product->categories as $cat)
                                <a href="{{ route('productCategory', $cat->slug) }}" class="text-decoration-none text-muted">{{ $cat->name_en }}</a>@if(!$loop->last), @endif
                            @endforeach
                        </div>
                        @if($product->sku)
                        <div><strong style="color: var(--primary);">SKU:</strong> <span class="text-muted">{{ $product->sku }}</span></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Tabs -->
        <div class="product-details-container">
            <div class="cd-tabs">
                <button class="active" data-tab="desc">Description</button>
                <button data-tab="reviews">Reviews ({{ $product->reviews->count() }})</button>
                <button data-tab="policy">Shipping & Return</button>
            </div>

            <div data-tab-content="desc" style="display: block;">
                <div class="pro-description" style="color: var(--text-soft); line-height: 1.8;">
                    {!! $product->description_en !!}
                </div>
            </div>

            <div data-tab-content="reviews" style="display: none;">
                <div class="row">
                    <div class="col-lg-7">
                        <h4 style="color: var(--primary); margin-bottom: 25px;">Customer Reviews</h4>
                        @forelse($product->reviews as $review)
                        <div style="padding-bottom: 20px; border-bottom: 1px solid var(--border); margin-bottom: 20px;">
                            <div style="color: #f59e0b; margin-bottom: 8px; font-size: 12px;">
                                @for($i = 1; $i <= 5; $i++)
                                <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star"></i>
                                @endfor
                            </div>
                            <h5 style="font-size: 16px; font-weight: 700; color: var(--primary); margin-bottom: 5px;">{{ $review->user->name ?? 'SikhoBD Learner' }}</h5>
                            <span style="font-size: 12px; color: var(--text-muted);">{{ $review->created_at->format('M d, Y') }}</span>
                            <p style="color: var(--text-soft); margin-top: 10px; font-size: 14px;">{{ $review->comment }}</p>
                        </div>
                        @empty
                        <p style="color: var(--text-muted);">No reviews yet. Be the first to review!</p>
                        @endforelse
                    </div>
                    <div class="col-lg-5">
                        <div style="background: var(--bg-soft); padding: 30px; border-radius: var(--radius);">
                            <h4 style="color: var(--primary); margin-bottom: 20px;">Write a Review</h4>
                            <form action="{{ route('reviewsStore') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <div class="mb-3">
                                    <label class="form-label" style="font-weight: 700; font-size: 14px;">Rating</label>
                                    <select name="rating" class="form-select" style="border-radius: 10px;">
                                        <option value="5">5 Stars</option>
                                        <option value="4">4 Stars</option>
                                        <option value="3">3 Stars</option>
                                        <option value="2">2 Stars</option>
                                        <option value="1">1 Star</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" style="font-weight: 700; font-size: 14px;">Your Comment</label>
                                    <textarea name="comment" class="form-control" rows="4" style="border-radius: 12px;" placeholder="What did you like about this product?"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary w-100" style="justify-content: center; height: 48px; border-radius: 12px; font-weight: 700;">Submit Review</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div data-tab-content="policy" style="display: none;">
                <div style="color: var(--text-soft); line-height: 1.8;">
                    <h5 style="color: var(--primary); margin-bottom: 15px;">Shipping Information</h5>
                    <p>We deliver products all over Bangladesh within 3-5 working days. Shipping charges may vary based on your location and product weight.</p>
                    <h5 style="color: var(--primary); margin: 20px 0 15px;">Return Policy</h5>
                    <p>If you receive a damaged or incorrect product, you can request a return within 7 days of delivery. The product must be in its original packaging and unused.</p>
                </div>
            </div>
        </div>

        <!-- Related Products (Reusing Shop Grid Style) -->
        @if($relatedProducts->count() > 0)
        <div class="mt-5">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                <h2 style="color: var(--primary); font-weight: 800;">Related Products</h2>
                <a href="{{ route('shop') }}" style="color: var(--accent); font-weight: 700; text-decoration: none;">View All <i class="fa-solid fa-arrow-right ms-1"></i></a>
            </div>
            
            <div class="shop-grid">
                @foreach($relatedProducts->take(3) as $related)
                <article class="course-card">
                  <div class="shop-product-thumb">
                    @if($related->discount > 0)
                    <span class="course-tag">{{ $related->discount }}% OFF</span>
                    @elseif($related->feature)
                    <span class="course-tag">HOT</span>
                    @endif
                    
                    <img src="{{ route('imagecache', ['template' => 'pnimd', 'filename' => $related->fi()]) }}" alt="{{ $related->name_en }}">
                    
                    <div class="shop-actions">
                        <button class="shop-action-btn addToCart" data-url="{{ route('addToCart') }}" data-product="{{ $related->id }}" title="Add to Cart"><i class="fa-solid fa-cart-shopping"></i></button>
                    </div>
                  </div>
                  <div class="course-body">
                    <span style="font-size: 11px; color: var(--accent); font-weight: 700; text-transform: uppercase;">{{ $related->categories->first()->name_en ?? 'Product' }}</span>
                    <h3 style="margin-top: 5px;"><a href="{{ route('productDetails', $related->slug) }}" style="text-decoration: none; color: inherit;">{{ Str::limit($related->name_en, 40) }}</a></h3>
                    
                    <div class="course-foot" style="border: none; padding-top: 10px;">
                      <div class="shop-price-box">
                        <span class="price">৳{{ number_format($related->selling_price) }}</span>
                        @if($related->discount > 0)
                        <span class="old-price-sm">৳{{ number_format($related->price) }}</span>
                        @endif
                      </div>
                    </div>
                  </div>
                </article>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>
@endsection

@push('js')
<script>
    function changeImage(el, src) {
        document.getElementById('mainImage').src = src;
        $('.thumb-item').removeClass('active');
        $(el).addClass('active');
    }

    function updateQty(val) {
        let qty = parseInt($('#mainQty').val());
        qty = qty + val;
        if (qty < 1) qty = 1;
        $('#mainQty').val(qty);
    }

    $(document).ready(function() {
        // Tab switching
        $('.cd-tabs button').click(function() {
            $('.cd-tabs button').removeClass('active');
            $(this).addClass('active');
            const tab = $(this).data('tab');
            $('[data-tab-content]').hide();
            $(`[data-tab-content="${tab}"]`).fadeIn();
        });

        // Add to Cart Logic
        $('.addToCartDetail').click(function() {
            let btn = $(this);
            let product_id = btn.data('product');
            let url = btn.data('url');
            let qty = $('#mainQty').val();

            $.ajax({
                url: url,
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    product: product_id,
                    qty: qty
                },
                success: function(res) {
                    if(res.status) {
                        showCartNotification(res.message);
                        $('.cartCount').text(res.cartCount);
                    }
                }
            });
        });

        // Buy Now Logic
        $('.buyNowDetail').click(function() {
            let btn = $(this);
            let product_id = btn.data('product');
            let url = btn.data('url');
            let qty = $('#mainQty').val();

            $.ajax({
                url: url,
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    product: product_id,
                    qty: qty
                },
                success: function(res) {
                    if(res.status) {
                        window.location.href = "{{ route('cart') }}";
                    }
                }
            });
        });

        // Standard Cart (for related products)
        $(document).on('click', '.addToCart', function(e) {
            e.preventDefault();
            let btn = $(this);
            let product_id = btn.data('product');
            let url = btn.data('url');

            $.ajax({
                url: url,
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    product: product_id,
                    qty: 1
                },
                success: function(res) {
                    if(res.status) {
                        showCartNotification(res.message);
                        $('.cartCount').text(res.cartCount);
                    }
                }
            });
        });
    });
</script>
@endpush
