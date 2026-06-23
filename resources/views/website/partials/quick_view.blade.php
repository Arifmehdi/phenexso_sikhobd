<div class="row g-0" style="position: relative;">
    <!-- Close button — top right of entire modal -->
    <button type="button" data-bs-dismiss="modal" aria-label="Close" style="position: absolute; top: 12px; right: 12px; z-index: 20; width: 36px; height: 36px; border-radius: 50%; background: #fff; border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 10px rgba(0,0,0,0.08); cursor: pointer; padding: 0;">
        <i class="fa-solid fa-xmark" style="color: var(--text-soft); font-size: 14px;"></i>
    </button>

    <!-- Left: Image -->
    <div class="col-md-5" style="background: var(--bg-soft); display: flex; align-items: center; justify-content: center; min-height: 380px; position: relative;">
        @if($product->discount > 0)
            <span style="position: absolute; top: 16px; left: 16px; background: var(--accent); color: #fff; padding: 4px 12px; border-radius: 20px; font-weight: 700; font-size: 12px; z-index: 10;">
                {{ $product->discount }}% OFF
            </span>
        @endif
        <img src="{{ route('imagecache', ['template' => 'pnimd', 'filename' => $product->fi()]) }}" alt="{{ $product->name_en }}" style="max-height: 320px; max-width: 80%; object-fit: contain; padding: 20px;">
    </div>

    <!-- Right: Details -->
    <div class="col-md-7 p-4" style="position: relative;">
        <div style="font-size: 11px; font-weight: 700; color: var(--accent); text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 6px;">
            {{ $product->categories->first()->name_en ?? 'Product' }}
        </div>

        <h2 style="color: var(--primary); font-size: 22px; font-weight: 800; line-height: 1.25; margin-bottom: 12px;">
            {{ Str::limit($product->name_en, 70) }}
        </h2>

        <div class="d-flex align-items-center gap-2 mb-3">
            <div style="color: #f59e0b; font-size: 13px;">
                @php $avgRating = $product->averageRating(); @endphp
                @for($i = 1; $i <= 5; $i++)
                    <i class="{{ $i <= $avgRating ? 'fas' : 'far' }} fa-star"></i>
                @endfor
            </div>
            <span style="font-size: 12px; color: var(--text-muted);">({{ $product->reviews->count() }} reviews)</span>
        </div>

        <div style="background: var(--bg-soft); padding: 14px 18px; border-radius: 12px; margin-bottom: 16px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
            <div class="d-flex align-items-baseline gap-2">
                <span style="font-size: 28px; font-weight: 900; color: var(--primary);">৳{{ number_format($product->selling_price) }}</span>
                @if($product->discount > 0)
                    <span style="font-size: 16px; color: var(--text-muted); text-decoration: line-through;">৳{{ number_format($product->price) }}</span>
                @endif
            </div>
            <span style="font-size: 12px; color: #28a745; font-weight: 600;">
                <i class="fa-solid fa-circle-check"></i> In Stock
            </span>
        </div>

        <p style="color: var(--text-soft); font-size: 14px; line-height: 1.6; margin-bottom: 20px;">
            {{ Str::limit(strip_tags($product->description_en), 160) }}
        </p>

        <div class="d-flex gap-2 mb-3">
            <div style="display: flex; align-items: center; background: #fff; border: 1px solid var(--border); border-radius: 10px; padding: 3px; flex-shrink: 0;">
                <button onclick="updateQtyQV(-1)" style="width: 34px; height: 34px; border: none; background: none; color: var(--primary); font-weight: 700; border-radius: 8px; cursor: pointer;">−</button>
                <input type="text" id="qtyQV" value="1" readonly style="width: 32px; border: none; text-align: center; font-weight: 700; font-size: 14px; outline: none; background: transparent;">
                <button onclick="updateQtyQV(1)" style="width: 34px; height: 34px; border: none; background: none; color: var(--primary); font-weight: 700; border-radius: 8px; cursor: pointer;">+</button>
            </div>
            <button class="btn btn-primary addToCartQV" data-product="{{ $product->id }}" data-url="{{ route('addToCart') }}" style="flex: 1; height: 44px; justify-content: center; border-radius: 10px; font-size: 14px;">
                <i class="fa-solid fa-cart-plus me-2"></i> Add to Cart
            </button>
        </div>

        <a href="{{ route('productDetails', $product->slug) }}" class="btn btn-outline" style="width: 100%; height: 44px; justify-content: center; border-radius: 10px; font-size: 14px;">
            View Full Details <i class="fa-solid fa-arrow-right ms-2"></i>
        </a>
    </div>
</div>

<script>
    function updateQtyQV(val) {
        let input = document.getElementById('qtyQV');
        let qty = parseInt(input.value) + val;
        if (qty < 1) qty = 1;
        input.value = qty;
    }

    $(document).ready(function() {
        $('.addToCartQV').off('click').on('click', function() {
            let btn = $(this);
            let product_id = btn.data('product');
            let url = btn.data('url');
            let qty = $('#qtyQV').val();

            btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin me-2"></i> Adding...');

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
                        $('#quickViewModal').modal('hide');
                    } else {
                        btn.prop('disabled', false).html('<i class="fa-solid fa-cart-plus me-2"></i> Add to Cart');
                    }
                },
                error: function() {
                    btn.prop('disabled', false).html('<i class="fa-solid fa-cart-plus me-2"></i> Add to Cart');
                }
            });
        });
    });
</script>
