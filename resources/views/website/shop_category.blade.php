@extends('website.layouts.mncofee')

@section('title', (isset($category) ? $category->name_en : 'Shop') . ' - ' . ($ws->name ?? env('APP_NAME')))

@push('css')
<style>
    .ad-menu-banner {
        background-image: url("{{ asset('mncofee/assets/img/aida-images/menu-banner.png') }}") !important;
        background-size: cover;
        background-position: center;
        height: 300px;
    }
    .card-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .product-card-img {
        overflow: hidden;
        border-radius: 1rem;
        background: #fff;
    }
    .product-card-img img {
        width: 100%;
        height: 240px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .product-card-img:hover img {
        transform: scale(1.03);
    }
    .sidebar {
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0,0,0,0.05);
    }
    .nav-list .nav-link {
        color: #333;
        padding: 8px 0;
        border-bottom: 1px solid #f1f1f1;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .nav-list .nav-link:hover, .nav-list .nav-link.active {
        color: #A45517;
    }
    .btn-primary-custom {
        background-color: #A45517;
        border-color: #A45517;
        color: #fff;
    }
    .btn-primary-custom:hover {
        background-color: #a8854d;
        border-color: #a8854d;
        color: #fff;
    }
    .parent-category[aria-expanded="true"] i {
        transform: rotate(180deg);
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
                <a class="selected-page" href="{{ route('shop') }}"> Shop</a>
                @if(isset($category))
                    <span class="text-white"> / {{ $category->name_en }}</span>
                @endif
            </div>
        </div>
    </div>
</section>

<section class="section my-0 py-5">
    <div class="container">
        <div class="row g-4">
            
            <!-- Sidebar -->
            <div class="col-lg-3 order-2 order-lg-1 d-none d-lg-block">
                <aside class="sidebar">
                    <h5 class="mb-4">Product Categories</h5>

                    <ul class="nav nav-list flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ !request()->segment(2) ? 'active' : '' }}" href="{{ route('shop') }}">
                                <span>All Products</span>
                            </a>
                        </li>

                        @foreach ($allRootCategories as $rootCat)
                            @php
                                $isActiveParent = request()->segment(2) === $rootCat->slug ||
                                                  ($rootCat->children->isNotEmpty() && $rootCat->children->pluck('slug')->contains(request()->segment(2)));
                            @endphp
                            <li class="nav-item">
                                <a class="nav-link parent-category {{ $isActiveParent ? 'active' : '' }}"
                                   href="{{ count($rootCat->children) > 0 ? '#category-' . $rootCat->id : route('productCategory', $rootCat->slug) }}"
                                   @if(count($rootCat->children) > 0) data-bs-toggle="collapse" data-bs-target="#category-{{ $rootCat->id }}" aria-expanded="{{ $isActiveParent ? 'true' : 'false' }}" @endif>
                                    <span>{{ $rootCat->name_en }} </span>
                                    @if(count($rootCat->children) > 0)
                                        <i class="fas fa-chevron-down small transition"></i>
                                    @endif
                                </a>
                                @if(count($rootCat->children) > 0)
                                    <ul id="category-{{ $rootCat->id }}" class="nav flex-column ms-3 collapse {{ $isActiveParent ? 'show' : '' }}">
                                        @foreach($rootCat->children as $child)
                                            <li class="nav-item">
                                                <a class="nav-link {{ request()->segment(2) === $child->slug ? 'active' : '' }}" href="{{ route('productCategory', $child->slug) }}">{{ $child->name_en }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>

                    <div class="mt-5">
                        <h5 class="mb-3">Filter by Price</h5>
                        <form action="{{ url()->current() }}" method="GET">
                            <div class="d-flex flex-column gap-2">
                                <input type="number" name="min_price" class="form-control form-control-sm" placeholder="Min Price" value="{{ request('min_price') }}">
                                <input type="number" name="max_price" class="form-control form-control-sm" placeholder="Max Price" value="{{ request('max_price') }}">
                                <button type="submit" class="btn btn-sm btn-primary-custom mt-2">Apply</button>
                            </div>
                        </form>
                    </div>
                </aside>
            </div>

            <!-- Main Content -->
            <div class="col-12 col-lg-9 order-1 order-lg-2">
                
                <!-- Subcategories horizontally on mobile -->
                @if(count($subcategories) > 0)
                <div class="d-lg-none mb-4">
                    <div class="d-flex overflow-auto pb-2 gap-2">
                        @foreach ($subcategories as $subcat)
                            <a href="{{ route('productCategory', $subcat->slug) }}" 
                               class="btn btn-sm btn-outline-primary rounded-pill text-nowrap {{ request()->segment(2) == $subcat->slug ? 'active' : '' }}">
                                {{ $subcat->name_en }}
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif


                <!-- Top filter section -->
                <div class="row mb-4 align-items-center bg-light p-3 rounded mx-0 border">
                    <div class="col-md-6">
                        <form method="GET" class="d-flex align-items-center gap-2">
                            <select name="sort" id="sort" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
                                <option value="1" @if(request()->get('sort')==1) selected @endif>Latest</option>
                                <option value="2" @if(request()->get('sort')==2) selected @endif>Oldest</option>
                                <option value="3" @if(request()->get('sort')==3) selected @endif>Price: High to Low</option>
                                <option value="4" @if(request()->get('sort')==4) selected @endif>Price: Low to High</option>
                            </select>
                            <input type="hidden" name="min_price" value="{{ request()->get('min_price') }}">
                            <input type="hidden" name="max_price" value="{{ request()->get('max_price') }}">
                        </form>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <span class="text-muted small">
                            Showing {{ $products->firstItem() }} - {{ $products->lastItem() }} of {{ $products->total() }} results
                        </span>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="row g-3">
                    @forelse ($products as $product)
                        <div class="col-6 col-md-4 col-lg-4">
                            <div class="card h-100 border-0 shadow-sm card-hover">
                                <div class="position-relative overflow-hidden text-center p-2 product-card-img">
                                    <a href="{{ route('productDetails', $product->slug) }}">
                                        <img src="{{ route('imagecache', ['template' => 'pnimd', 'filename' => $product->fi()]) }}" 
                                             class="card-img-top" 
                                             alt="{{ $product->name_en }}">
                                    </a>
                                </div>
                                <div class="card-body p-3 d-flex flex-column text-center">
                                    <small class="text-uppercase text-muted mb-1" style="font-size: 10px;">
                                        @foreach ($product->categories as $cat)
                                            {{ $cat->name_en }}@if(!$loop->last), @endif
                                        @endforeach
                                    </small>
                                    <h6 class="card-title text-truncate mb-1" style="font-size: 14px;">
                                        <a href="{{ route('productDetails', $product->slug) }}" class="text-dark text-decoration-none">
                                            {{ strtoupper($product->name_en) }}
                                        </a>
                                    </h6>
                                    <div class="mb-2">
                                        {{--@if($product->discount > 0)
                                            <span class="text-muted text-decoration-line-through small me-1" style="font-size: 11px;">
                                                ৳{{ number_format($product->price, 2) }}
                                            </span>
                                        @endif--}}
                                        <span class="fw-bold text-primary" style="font-size: 14px; color: #A45517 !important;">
                                            ৳{{ number_format($product->selling_price, 2) }}
                                        </span>
                                    </div>
                                    <div class="mt-auto productCartItem" data-product="{{ $product->id }}">
                                        @include('frontend.home.includes.productCartItem')
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <p class="text-muted">No products found in this category.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-5 d-flex justify-content-center">
                    {{ $products->links() }}
                </div>

            </div>
        </div>
    </div>
</section>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Add to Cart
    $(document).on("click", ".addToCart", function () {
        let btn = $(this);
        let url = btn.data("url");
        let product_id = btn.data("product");
        let qty = parseInt(btn.closest(".productCartItem").find(".product_qty").val()) || 1;

        $.post(url, { product: product_id, qty: qty }, function (res) {
            if (res.status) {
                btn.closest(".productCartItem").html(res.productCartItem);
                $(".cartCount").text(res.cartCount);
                $(".cartItemsCount").text(res.cartItemsCount);
                $(".cartTotalPrice").text(res.cartTotal.toFixed(2) + " tk");

                Swal.fire({
                    toast: true, icon: "success", title: res.message,
                    position: "top-end", timer: 2000, showConfirmButton: false
                });
            }
        }).fail(() => {
            Swal.fire("Error", "Could not add to cart.", "error");
        });
    });

    // Update Cart Item
    $(document).on('click', '.updateCartItem', function (e) {
        e.preventDefault();

        let $btn = $(this);
        let cartId = $btn.data('cart');
        let url = $btn.data('url');
        let $wrapper = $btn.closest('.cart-action-wrapper');
        let qty = parseInt($wrapper.find('.cartQtyDisplay').text()) || 0;

        if ($btn.hasClass('plus')) {
            qty++;
        } else if ($btn.hasClass('minus')) {
            qty--;
            if (qty < 0) qty = 0;
        }

        $btn.prop('disabled', true);

        $.ajax({
            url: url,
            method: 'POST',
            data: {
                cart: cartId,
                new_qty: qty
            },
            success: function (res) {
                if (res.status) {
                    if (qty === 0) {
                        $wrapper.html(`
                            <input type="hidden" name="product_qty" value="1" class="product_qty">
                            <button class="btn btn-outline-primary w-100 btn-sm addToCart"
                                data-url="${res.add_to_cart_url}"
                                data-product="${res.product_id}">
                                Buy Now
                            </button>
                        `);
                    } else {
                        $wrapper.find('.cartQtyDisplay').text(qty);
                    }

                    $('.cartCount').text(res.cartCount);
                    $('.cartItemsCount').text(res.cartItemsCount);
                }
            },
            error: function () {
                alert('Something went wrong! Please try again.');
            },
            complete: function () {
                $btn.prop('disabled', false);
            }
        });
    });
</script>
@endpush
