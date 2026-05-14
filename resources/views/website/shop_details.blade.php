@extends('website.layouts.mncofee')

@section('title', $product->name_en . ' - ' . ($ws->name ?? env('APP_NAME')))

@push('css')
<style>
    .ad-menu-banner {
        background-image: url("{{ asset('mncofee/assets/img/aida-images/menu-banner.png') }}") !important;
        background-size: cover;
        background-position: center;
        height: 250px;
    }
    .product-main-img {
        border-radius: 15px;
        box-shadow: 0 5px 25px rgba(0,0,0,0.08);
        background: #fff;
        padding: 20px;
    }
    .thumb-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 10px;
        cursor: pointer;
        border: 2px solid transparent;
        transition: 0.3s;
    }
    .thumb-img:hover, .thumb-img.active {
        border-color: #A45517;
    }
    .product-info-box {
        padding-left: 30px;
    }
    .product-price {
        font-size: 28px;
        color: #A45517;
        font-weight: 700;
    }
    .old-price {
        text-decoration: line-through;
        color: #999;
        font-size: 18px;
        margin-left: 10px;
    }
    .btn-buy-now {
        background-color: #A45517;
        color: #fff;
        padding: 12px 40px;
        border-radius: 50px;
        border: none;
        font-weight: 600;
        transition: 0.3s;
    }
    .btn-buy-now:hover {
        background-color: #a8854d;
        color: #fff;
        transform: translateY(-2px);
    }
    .qty-input {
        width: 60px;
        text-align: center;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin: 0 10px;
    }
    .qty-btn {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        border: 1px solid #ddd;
        background: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    .nav-tabs-custom .nav-link {
        border: none;
        color: #333;
        font-weight: 600;
        padding: 15px 30px;
        border-bottom: 3px solid transparent;
    }
    .nav-tabs-custom .nav-link.active {
        color: #A45517;
        border-bottom-color: #A45517;
        background: transparent;
    }
    .card-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
</style>
@endpush

@section('content')
<!--------------- 
    Banner 
---------------->
<section>
    <div class="ad-menu-banner position-relative">
        <div class="ad-menu-banner-overlay">
            <div>
                <a href="{{ route('home') }}">Home /</a>
                <a href="{{ route('shop') }}"> Shop /</a>
                <a class="selected-page" href="#"> {{ $product->name_en }}</a>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Product Images -->
            <div class="col-lg-6">
                <div class="product-main-img text-center mb-4">
                    <img id="mainImage" src="{{ route('imagecache', ['template' => 'original', 'filename' => $product->fi()]) }}" 
                         class="img-fluid" alt="{{ $product->name_en }}" style="max-height: 500px;">
                </div>
                
                @if($product->media->count() > 0)
                <div class="d-flex gap-2 overflow-auto pb-2">
                    <img src="{{ route('imagecache', ['template' => 'original', 'filename' => $product->fi()]) }}" 
                         class="thumb-img active" onclick="changeImage(this, '{{ route('imagecache', ['template' => 'original', 'filename' => $product->fi()]) }}')">
                    @foreach($product->media as $media)
                        <img src="{{ route('imagecache', ['template' => 'original', 'filename' => $media->file_name]) }}" 
                             class="thumb-img" onclick="changeImage(this, '{{ route('imagecache', ['template' => 'original', 'filename' => $media->file_name]) }}')">
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Product Info -->
            <div class="col-lg-6">
                <div class="product-info-box">
                    <h1 class="fw-bold mb-3">{{ strtoupper($product->name_en) }}</h1>
                    
                    <div class="d-flex align-items-center mb-4">
                        <div class="text-warning me-2">
                            @php $avgRating = $product->averageRating(); @endphp
                            @for($i = 1; $i <= 5; $i++)
                                <i class="{{ $i <= $avgRating ? 'fas' : 'far' }} fa-star"></i>
                            @endfor
                        </div>
                        <span class="text-muted">({{ $product->reviews->count() }} Reviews)</span>
                    </div>

                    <div class="mb-4">
                        <span class="product-price">৳{{ number_format($product->selling_price, 2) }}</span>
                        {{--@if($product->discount > 0)
                            <span class="old-price">৳{{ number_format($product->price, 2) }}</span>
                        @endif--}}
                    </div>

                    <p class="text-muted mb-4">
                        {!! Str::limit(strip_tags($product->description_en), 250) !!}
                    </p>

                    <div class="mb-4">
                        <h6 class="fw-bold">Quantity</h6>
                        <div class="d-flex align-items-center mt-2">
                            <span class="qty-btn minus"><i class="fas fa-minus"></i></span>
                            <input type="text" class="qty-input" value="1" id="mainQty">
                            <span class="qty-btn plus"><i class="fas fa-plus"></i></span>
                        </div>
                    </div>

                    <div class="d-flex gap-3 mb-5">
                        <button class="btn btn-buy-now addToCartDetail" data-url="{{ route('addToCart') }}" data-product="{{ $product->id }}">
                            <i class="fas fa-shopping-cart me-2"></i> ADD TO CART
                        </button>
                    </div>

                    <div class="border-top pt-4">
                        <p class="mb-2"><strong>Categories:</strong> 
                            @foreach($product->categories as $cat)
                                <a href="{{ route('productCategory', $cat->slug) }}" class="text-decoration-none text-muted">{{ $cat->name_en }}</a>@if(!$loop->last), @endif
                            @endforeach
                        </p>
                        @if($product->sku)
                            <p class="mb-0"><strong>SKU:</strong> <span class="text-muted">{{ $product->sku }}</span></p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="mt-5">
            <ul class="nav nav-tabs nav-tabs-custom border-bottom" id="productTab" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" id="desc-tab" data-bs-toggle="tab" data-bs-target="#desc" type="button">DESCRIPTION</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="review-tab" data-bs-toggle="tab" data-bs-target="#review" type="button">REVIEWS ({{ $product->reviews->count() }})</button>
                </li>
            </ul>
            <div class="tab-content p-4" id="productTabContent">
                <div class="tab-pane fade show active" id="desc">
                    <div class="pro-description">
                        {!! $product->description_en !!}
                    </div>
                </div>
                <div class="tab-pane fade" id="review">
                    <div class="row">
                        <div class="col-lg-6">
                            <h5 class="fw-bold mb-4">Customer Reviews</h5>
                            @forelse($product->reviews as $review)
                                <div class="mb-4 pb-4 border-bottom">
                                    <div class="text-warning mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star"></i>
                                        @endfor
                                    </div>
                                    <h6 class="fw-bold">{{ $review->user->name ?? 'Anonymous' }}</h6>
                                    <p class="text-muted small mb-1">{{ $review->created_at->format('M d, Y') }}</p>
                                    <p class="mb-0 text-muted">{{ $review->comment }}</p>
                                </div>
                            @empty
                                <p class="text-muted">No reviews yet.</p>
                            @endforelse
                        </div>
                        <div class="col-lg-6">
                            <h5 class="fw-bold mb-4">Write a Review</h5>
                            <form action="{{ route('reviewsStore') }}" method="POST" class="bg-light p-4 rounded">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <div class="mb-3">
                                    <label class="form-label">Rating</label>
                                    <select name="rating" class="form-select">
                                        <option value="5">5 Stars</option>
                                        <option value="4">4 Stars</option>
                                        <option value="3">3 Stars</option>
                                        <option value="2">2 Stars</option>
                                        <option value="1">1 Star</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Your Review</label>
                                    <textarea name="comment" class="form-control" rows="4" placeholder="Write your thoughts here..." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary-custom" style="background-color:#A45517; border:none; color:#fff; padding:10px 30px; border-radius:50px;">SUBMIT REVIEW</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
        <div class="mt-5 pt-5">
            <h3 class="fw-bold mb-4 text-center">RELATED PRODUCTS</h3>
            <div class="row g-3">
                @foreach($relatedProducts->take(4) as $related)
                <div class="col-6 col-md-3">
                    <div class="card h-100 border-0 shadow-sm card-hover">
                        <div class="position-relative overflow-hidden text-center p-2">
                            <a href="{{ route('productDetails', $related->slug) }}">
                                <img src="{{ route('imagecache', ['template' => 'pnism', 'filename' => $related->fi()]) }}" 
                                     class="card-img-top rounded-circle" 
                                     alt="{{ $related->name_en }}"
                                     style="width: 120px; height: 120px; object-fit: cover; margin: 0 auto;">
                            </a>
                        </div>
                        <div class="card-body p-3 d-flex flex-column text-center">
                            <h6 class="card-title text-truncate mb-1" style="font-size: 14px;">
                                <a href="{{ route('productDetails', $related->slug) }}" class="text-dark text-decoration-none">
                                    {{ strtoupper($related->name_en) }}
                                </a>
                            </h6>
                            <div class="mb-2">
                                <span class="fw-bold" style="font-size: 14px; color: #A45517 !important;">
                                    ৳{{ number_format($related->selling_price, 2) }}
                                </span>
                            </div>
                            <div class="mt-auto productCartItem" data-product="{{ $related->id }}">
                                @include('frontend.home.includes.productCartItem', ['product' => $related])
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function changeImage(el, src) {
        document.getElementById('mainImage').src = src;
        $('.thumb-img').removeClass('active');
        $(el).addClass('active');
    }

    $(document).ready(function() {
        // Quantity Controls
        $('.plus').click(function() {
            let qty = parseInt($('#mainQty').val());
            $('#mainQty').val(qty + 1);
        });

        $('.minus').click(function() {
            let qty = parseInt($('#mainQty').val());
            if(qty > 1) $('#mainQty').val(qty - 1);
        });

        // Add to Cart from Detail Page
        $(document).on("click", ".addToCartDetail", function () {
            let btn = $(this);
            let url = btn.data("url");
            let product_id = btn.data("product");
            let qty = parseInt($('#mainQty').val()) || 1;

            $.post(url, { product: product_id, qty: qty, _token: "{{ csrf_token() }}" }, function (res) {
                if (res.status) {
                    $(".cartCount").text(res.cartCount);
                    $(".cartItemsCount").text(res.cartItemsCount);

                    Swal.fire({
                        toast: true, icon: "success", title: res.message,
                        position: "top-end", timer: 2000, showConfirmButton: false
                    });
                }
            }).fail(() => {
                Swal.fire("Error", "Could not add to cart.", "error");
            });
        });
    });
    
    // Use standard cart JS for related products
    $(document).on("click", ".addToCart", function () {
        let btn = $(this);
        let url = btn.data("url");
        let product_id = btn.data("product");
        let qty = 1;

        $.post(url, { product: product_id, qty: qty, _token: "{{ csrf_token() }}" }, function (res) {
            if (res.status) {
                btn.closest(".productCartItem").html(res.productCartItem);
                $(".cartCount").text(res.cartCount);
                $(".cartItemsCount").text(res.cartItemsCount);
                Swal.fire({
                    toast: true, icon: "success", title: res.message,
                    position: "top-end", timer: 2000, showConfirmButton: false
                });
            }
        });
    });
</script>
@endpush
