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
    .in-cart-badge {
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
    .in-cart-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.08);
        pointer-events: none;
        z-index: 1;
    }
    .course-card.in-cart-card {
        border-color: #28a745;
        box-shadow: 0 0 0 1px #28a745, var(--shadow-md);
    }
    .course-card.in-cart-card .shop-product-thumb {
        background: #f0fff4;
    }
    .go-to-cart-link {
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
    .go-to-cart-link:hover {
        background: #218838;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
    }
    .shop-cart-btn.in-cart-state,
    .shop-buy-btn.in-cart-state {
        background: #e8f5e9;
        color: #28a745;
        border-color: #28a745;
        cursor: default;
    }
    .shop-action-btn.in-cart-state {
        background: #28a745;
        color: #fff;
        border-color: #28a745;
        cursor: default;
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
             @php $isInCart = in_array($product->id, $cartProductIds ?? []); @endphp
             <article class="course-card {{ $isInCart ? 'in-cart-card' : '' }}" data-pid="{{ $product->id }}">
               <div class="shop-product-thumb">
                 @if($isInCart)
                 <span class="in-cart-badge"><i class="fa-solid fa-check-circle"></i> In Cart</span>
                 @elseif($product->discount > 0)
                 <span class="course-tag">{{ $product->discount }}% OFF</span>
                 @elseif($product->feature)
                 <span class="course-tag">HOT</span>
                 @endif

                 @if($isInCart)<div class="in-cart-overlay"></div>@endif

                 <img src="{{ route('imagecache', ['template' => 'pnimd', 'filename' => $product->fi()]) }}" alt="{{ $product->name_en }}">

                 <div class="shop-actions">
                     <button class="shop-action-btn quick-view-btn" data-id="{{ $product->id }}" title="View Details"><i class="fa-regular fa-eye"></i></button>
                     @if($isInCart)
                     <button class="shop-action-btn in-cart-state" title="Already in Cart"><i class="fa-solid fa-check"></i></button>
                     @else
                     <button class="shop-action-btn addToCart" data-url="{{ route('addToCart') }}" data-product="{{ $product->id }}" title="Add to Cart"><i class="fa-solid fa-cart-shopping"></i></button>
                     @endif
                     <button class="shop-action-btn {{ $isInCart ? 'in-cart-state' : 'buyNow' }}" data-url="{{ route('addToCart') }}" data-product="{{ $product->id }}" title="{{ $isInCart ? 'Already in Cart' : 'Buy Now' }}"><i class="fa-solid {{ $isInCart ? 'fa-check' : 'fa-bolt' }}"></i></button>
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
                     @if($isInCart)
                     <a href="{{ route('cart') }}" class="go-to-cart-link">
                       <i class="fa-solid fa-cart-shopping"></i> Go to Cart
                     </a>
                     <button class="shop-buy-btn in-cart-state" disabled>
                       <i class="fa-solid fa-check"></i> In Cart
                     </button>
                     @else
                     <button class="shop-cart-btn addToCart" data-url="{{ route('addToCart') }}" data-product="{{ $product->id }}" title="Add to Cart">
                       Add To Cart
                     </button>
                     <button class="shop-buy-btn buyNow" data-url="{{ route('addToCart') }}" data-product="{{ $product->id }}" title="Buy Now">
                       Buy Now
                     </button>
                     @endif
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

<!-- Quick View Modal -->
<div class="modal fade" id="quickViewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 920px; margin: 20px auto;">
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.15); overflow: hidden;">
            <div class="modal-body p-0 position-relative" id="quickViewContent">
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        // Quick View AJAX
        $('.quick-view-btn').click(function() {
            let id = $(this).data('id');
            $('#quickViewModal').modal('show');
            $('#quickViewContent').html('<div class="p-5 text-center"><i class="fa-solid fa-spinner fa-spin fa-2x" style="color: var(--accent);"></i></div>');

            $.get("{{ route('quick.view') }}", {id: id}, function(res) {
                $('#quickViewContent').html(res.html);
            });
        });

        // Transform a product card to "in-cart" state after AJAX add
        function markProductInCart(productId) {
            let $card = $('article.course-card[data-pid="' + productId + '"]');
            $card.addClass('in-cart-card');

            // Add badge + overlay to product thumb if not already present
            let $thumb = $card.find('.shop-product-thumb');
            if (!$thumb.find('.in-cart-badge').length) {
                $thumb.find('.course-tag').remove();
                $thumb.prepend('<span class="in-cart-badge"><i class="fa-solid fa-check-circle"></i> In Cart</span>');
                if (!$thumb.find('.in-cart-overlay').length) {
                    $thumb.append('<div class="in-cart-overlay"></div>');
                }
            }

            // Icon buttons
            $card.find('.shop-action-btn.addToCart, .shop-action-btn.buyNow').each(function() {
                let $btn = $(this);
                $btn.removeClass('addToCart buyNow').addClass('in-cart-state')
                    .attr('title', 'Already in Cart')
                    .html('<i class="fa-solid fa-check"></i>');
            });

            // Text buttons — replace Add To Cart with "Go to Cart" link, disable Buy Now
            $card.find('.shop-cart-btn.addToCart').replaceWith(
                '<a href="{{ route('cart') }}" class="go-to-cart-link"><i class="fa-solid fa-cart-shopping"></i> Go to Cart</a>'
            );
            $card.find('.shop-buy-btn.buyNow').addClass('in-cart-state')
                .attr('disabled', true)
                .html('<i class="fa-solid fa-check"></i> In Cart');
        }

        // Add to Cart AJAX
        $(document).on('click', '.shop-cart-btn.addToCart, .shop-action-btn.addToCart', function(e) {
            e.preventDefault();
            let btn = $(this);
            let product_id = btn.data('product');
            let url = btn.data('url');

            if(btn.prop('disabled')) return;

            let originalContent = btn.html();
            btn.prop('disabled', true).addClass('disabled');

            if(btn.hasClass('shop-action-btn')) {
                btn.html('<i class="fa-solid fa-spinner fa-spin"></i>');
            } else {
                btn.text('Adding...');
            }

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
                        markProductInCart(product_id);
                    } else {
                        btn.html(originalContent);
                        btn.prop('disabled', false).removeClass('disabled');
                    }
                },
                error: function() {
                    btn.html(originalContent);
                    btn.prop('disabled', false).removeClass('disabled');
                }
            });
        });

        // Buy Now - Add to cart and redirect to checkout
        $(document).on('click', '.shop-buy-btn.buyNow, .shop-action-btn.buyNow', function(e) {
            e.preventDefault();
            let btn = $(this);
            let product_id = btn.data('product');
            let url = btn.data('url');

            if(btn.prop('disabled')) return;

            let originalContent = btn.html();
            btn.prop('disabled', true).addClass('disabled');

            if(btn.hasClass('shop-action-btn')) {
                btn.html('<i class="fa-solid fa-spinner fa-spin"></i>');
            } else {
                btn.text('Processing...');
            }

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
                        window.location.href = "{{ route('new.checkout') }}";
                    } else {
                        btn.html(originalContent);
                        btn.prop('disabled', false).removeClass('disabled');
                    }
                },
                error: function() {
                    btn.html(originalContent);
                    btn.prop('disabled', false).removeClass('disabled');
                }
            });
        });
    });
</script>
@endpush
