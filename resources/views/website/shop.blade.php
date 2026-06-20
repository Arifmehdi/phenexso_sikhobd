@extends('website.layouts.sikhobd')

@section('title', 'আওয়ার শপ — ' . ($ws->name ?? env('APP_NAME')))

@push('css')
<style>
    .shop-product-thumb {
        aspect-ratio: 1 / 1;
        background: #fff;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border-bottom: 1px solid var(--border);
    }
    .shop-product-thumb img {
        max-width: 80%;
        max-height: 80%;
        object-fit: contain;
        transition: transform 0.3s ease;
    }
    .course-card:hover .shop-product-thumb img {
        transform: scale(1.1);
    }
    .shop-actions {
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
    }
    .course-card:hover .shop-actions {
        opacity: 1;
        transform: translateY(0);
    }
    .shop-action-btn {
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
    }
    .shop-action-btn:hover {
        background: var(--accent);
        color: #fff;
        border-color: var(--accent);
    }
    .shop-price-box {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        flex-direction: row;
        gap: 8px;
        padding: 8px 0;
        margin-bottom: 10px;
        text-align: left;
    }
    .shop-price-box .price {
        font-size: 16px !important;
        font-weight: 700 !important;
        color: var(--accent) !important;
    }
    .old-price-sm {
        font-size: 12px;
        color: var(--text-muted);
        text-decoration: line-through;
    }
    .shop-cart-btn, .shop-buy-btn {
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
    .shop-cart-btn {
        background: #f0f0f0;
        color: var(--primary);
        border: 1px solid var(--border);
    }
    .shop-cart-btn:hover {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    .shop-cart-btn:disabled,
    .shop-cart-btn.disabled {
        background: #e8e8e8;
        color: var(--text-muted);
        border-color: var(--border);
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }
    .shop-buy-btn {
        background: var(--accent);
        color: #fff;
    }
    .shop-buy-btn:hover {
        background: var(--primary);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
    }
    .shop-buy-btn:disabled,
    .shop-buy-btn.disabled {
        background: #ccc;
        color: #666;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }
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

    /* Custom Pagination Styling */
    .pagination {
        display: flex;
        gap: 8px;
        list-style: none;
        padding: 0;
        margin: 0;
        justify-content: center;
    }
    .page-item .page-link {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        border: 1px solid var(--border);
        color: var(--text-soft);
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
        background: #fff;
    }
    .page-item.active .page-link {
        background: var(--primary);
        color: #fff !important;
        border-color: var(--primary);
    }
    .page-item.active .page-link:hover {
        color: #fff !important;
    }
    .page-item .page-link:hover {
        background: var(--bg-soft);
        color: var(--accent);
    }
    .page-item.disabled .page-link {
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>
@endpush

@section('content')
@php
    $isBn = app()->getLocale() == 'bn';
@endphp
  <section class="page-hero">
    <div class="container">
        <h1 data-i18n="shop.title">{{ $isBn ? 'আমাদের  শপ' : 'Our Shop' }}</h1>
        <p data-i18n="shop.subtitle">{{ $isBn ? 'আপনার প্রয়োজনীয় সব শিক্ষামূলক পণ্য এখন এক জায়গায়' : 'All your educational products in one place' }}</p>
        <div class="crumbs">
            <a href="{{ route('home') }}">{{ $isBn ? 'হোম' : 'Home' }}</a> <span>/</span> <span data-i18n="nav.shop">{{ $isBn ? 'শপ' : 'Shop' }}</span>
        </div>
    </div>
  </section>

  <section class="section" style="padding-top: 40px;">
    <div class="container">
      <div class="courses-layout">
        <!-- Reusing the sidebar style from courses page -->
        <aside class="filter-side">
          <form action="{{ route('shop') }}" method="GET" id="filterForm">
            <h3 style="color:var(--primary); margin-bottom:16px; font-size:16px;" data-i18n="filter">ফিল্টার</h3>
            
            <div class="filter-group">
              <h4 data-i18n="category">ক্যাটাগরি</h4>
              <a href="{{ route('shop') }}" style="display: block; margin-bottom: 8px; font-size: 14px; color: {{ !request('category') ? 'var(--accent)' : 'var(--text-soft)' }}; font-weight: 600;">All Products</a>
              @foreach($allRootCategories as $cat)
              <label>
                <input type="checkbox" name="category[]" value="{{ $cat->slug }}" 
                       {{ in_array($cat->slug, (array)request('category')) ? 'checked' : '' }}
                       onchange="document.getElementById('filterForm').submit()"> 
                <span>{{ $cat->name_en }}</span>
              </label>
              @endforeach
            </div>

            <div class="filter-group">
              <h4 data-i18n="price.range">মূল্য</h4>
              <label>
                <input type="radio" name="price" value="all" 
                       {{ request('price') == 'all' || !request('price') ? 'checked' : '' }}
                       onchange="document.getElementById('filterForm').submit()"> 
                <span data-i18n="all">সব</span>
              </label>
              <label>
                <input type="radio" name="price" value="0-1000" {{ request('price') == '0-1000' ? 'checked' : '' }} onchange="document.getElementById('filterForm').submit()"> 
                <span>৳ 0 - 1k</span>
              </label>
              <label>
                <input type="radio" name="price" value="1000-5000" {{ request('price') == '1000-5000' ? 'checked' : '' }} onchange="document.getElementById('filterForm').submit()"> 
                <span>৳ 1k - 5k</span>
              </label>
              <label>
                <input type="radio" name="price" value="5000-plus" {{ request('price') == '5000-plus' ? 'checked' : '' }} onchange="document.getElementById('filterForm').submit()"> 
                <span>৳ 5k+</span>
              </label>
            </div>
            
            <a href="{{ route('shop') }}" class="btn btn-outline btn-sm" style="width:100%; margin-top: 10px; justify-content: center;">Clear Filters</a>
          </form>

          <div class="filter-group mt-5 d-none d-lg-block">
            <h4 data-i18n="best_sellers">বেস্ট সেলার</h4>
            @foreach($topClickedProducts->take(3) as $top)
            <a href="{{ route('productDetails', $top->slug) }}" style="display: flex; gap: 10px; margin-bottom: 15px; text-decoration: none;">
                <div style="width: 50px; height: 50px; background: #fff; border: 1px solid var(--border); border-radius: 8px; padding: 5px;">
                    <img src="{{ route('imagecache', ['template' => 'pnism', 'filename' => $top->fi()]) }}" alt="" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
                <div style="flex: 1;">
                    <h5 style="font-size: 13px; color: var(--primary); margin: 0;">{{ Str::limit($top->name_en, 20) }}</h5>
                    <span style="font-weight: 700; color: var(--accent); font-size: 14px;">৳{{ number_format($top->selling_price) }}</span>
                </div>
            </a>
            @endforeach
          </div>
        </aside>

        <div>
          <!-- Results bar -->
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; padding: 0 5px;">
            <div style="font-size: 14px; color: var(--text-muted);">
                Showing {{ $products->count() }} of {{ $total_products }} results
            </div>
            <form action="{{ url()->current() }}" method="GET">
                <select name="sort" class="form-select-sm" style="border: 1px solid var(--border); border-radius: 8px; padding: 5px 10px;" onchange="this.form.submit()">
                    <option value="1" {{ request('sort') == 1 ? 'selected' : '' }}>Latest</option>
                    <option value="3" {{ request('sort') == 3 ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="4" {{ request('sort') == 4 ? 'selected' : '' }}>Price: Low to High</option>
                </select>
            </form>
          </div>

          <div class="shop-grid">
            @forelse($products as $product)
            <article class="course-card">
              <div class="shop-product-thumb">
                @if($product->discount > 0)
                <span class="course-tag">{{ $product->discount }}% OFF</span>
                @elseif($product->feature)
                <span class="course-tag">HOT</span>
                @endif
                
                <img src="{{ route('imagecache', ['template' => 'pnimd', 'filename' => $product->fi()]) }}" alt="{{ $product->name_en }}">
                
                <div class="shop-actions">
                    <button class="shop-action-btn quick-view-btn" data-id="{{ $product->id }}" title="View Details"><i class="fa-regular fa-eye"></i></button>
                    <button class="shop-action-btn addToCart" data-url="{{ route('addToCart') }}" data-product="{{ $product->id }}" title="Add to Cart"><i class="fa-solid fa-cart-shopping"></i></button>
                    <button class="shop-action-btn buyNow" data-url="{{ route('addToCart') }}" data-product="{{ $product->id }}" title="Buy Now"><i class="fa-solid fa-bolt"></i></button>
                </div>
              </div>
              <div class="course-body">
                <span style="font-size: 11px; color: var(--accent); font-weight: 700; text-transform: uppercase;">{{ $product->categories->first()->name_en ?? 'Product' }}</span>
                <h3 style="margin-top: 5px;"><a href="{{ route('productDetails', $product->slug) }}" style="text-decoration: none; color: inherit;">{{ Str::limit($product->name_en, 40) }}</a></h3>
                
                <div class="course-foot" style="border: none; padding-top: 10px; display: flex; flex-direction: column; gap: 6px;">
                  <div class="shop-price-box">
                    <span style="font-size: 12px; color: var(--text-muted); font-weight: 600;">Price :</span>
                    @if($product->discount > 0)
                      <span class="price">৳{{ number_format($product->discounted_price) }}</span>
                      <span class="old-price-sm">৳{{ number_format($product->regular_price) }}</span>
                    @else
                      <span class="price">৳{{ number_format($product->regular_price) }}</span>
                    @endif
                  </div>
                  <div style="display: flex; flex-direction: row; gap: 8px; width: 100%;">
                    <button class="shop-cart-btn addToCart" data-url="{{ route('addToCart') }}" data-product="{{ $product->id }}" title="Add to Cart">
                      Add To Cart
                    </button>
                    <button class="shop-buy-btn buyNow" data-url="{{ route('addToCart') }}" data-product="{{ $product->id }}" title="Buy Now">
                      Buy Now
                    </button>
                  </div>
                </div>
              </div>
            </article>
            @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 60px; background: var(--bg-soft); border-radius: var(--radius-lg);">
                <i class="fa-solid fa-box-open" style="font-size: 48px; color: var(--text-muted); margin-bottom: 20px;"></i>
                <h3 style="color: var(--text-soft);">No products found matching your criteria.</h3>
                <a href="{{ route('shop') }}" class="btn btn-primary" style="margin-top: 20px;">Reset Filters</a>
            </div>
            @endforelse
          </div>
          
          @if($products->hasPages())
          <div style="margin-top: 40px; display: flex; justify-content: center;">
              {{ $products->links() }}
          </div>
          @endif
        </div>
      </div>
    </div>
  </section>

<!-- Quick View Modal (Simplified) -->
<div class="modal fade" id="quickViewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: var(--radius-lg); border: none; overflow: hidden;">
            <div class="modal-body p-0" id="quickViewContent">
                <!-- Content loaded via AJAX -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        // Cart product IDs from backend
        let cartProductIds = {!! json_encode($cartProductIds ?? []) !!};
        
        // Check each Add to Cart and Buy Now button and disable if product is already in cart
        $('.shop-cart-btn.addToCart, .shop-buy-btn.buyNow').each(function() {
            let productId = $(this).data('product');
            let btn = $(this);
            
            if(cartProductIds.includes(productId)) {
                // Product is in cart, disable button
                btn.attr('disabled', true).addClass('disabled');
                if(btn.hasClass('addToCart')) {
                    btn.text('Added to Cart');
                } else if(btn.hasClass('buyNow')) {
                    btn.text('In Cart');
                }
            }
        });

        // Quick View AJAX
        $('.quick-view-btn').click(function() {
            let id = $(this).data('id');
            $('#quickViewModal').modal('show');
            $('#quickViewContent').html('<div class="p-5 text-center"><i class="fa-solid fa-spinner fa-spin fa-2x" style="color: var(--accent);"></i></div>');
            
            $.get("{{ route('quick.view') }}", {id: id}, function(res) {
                $('#quickViewContent').html(res.html);
            });
        });

        // Add to Cart AJAX
        $(document).on('click', '.shop-cart-btn.addToCart', function(e) {
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
                        
                        // Disable only this Add to Cart button
                        btn.attr('disabled', true).addClass('disabled');
                        btn.text('Added to Cart');
                    }
                }
            });
        });

        // Buy Now - Add to cart and redirect to checkout
        $(document).on('click', '.shop-buy-btn.buyNow', function(e) {
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
                        // Redirect to checkout page instantly
                        window.location.href = "{{ route('new.checkout') }}";
                    }
                }
            });
        });
    });
</script>
@endpush
