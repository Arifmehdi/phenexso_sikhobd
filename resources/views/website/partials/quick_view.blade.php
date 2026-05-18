<div class="row g-0">
    <!-- Left: Image Section -->
    <div class="col-md-6" style="background: var(--bg-soft); position: relative; display: flex; align-items: center; justify-content: center; min-height: 400px;">
        @if($product->discount > 0)
            <span style="position: absolute; top: 20px; left: 20px; background: var(--accent); color: #fff; padding: 5px 12px; border-radius: 8px; font-weight: 800; font-size: 14px; z-index: 10;">
                {{ $product->discount }}% OFF
            </span>
        @endif
        <button type="button" class="btn-close d-md-none" data-bs-dismiss="modal" aria-label="Close" style="position: absolute; top: 20px; right: 20px; z-index: 10;"></button>
        <img src="{{ route('imagecache', ['template' => 'original', 'filename' => $product->fi()]) }}" class="img-fluid p-5" alt="{{ $product->name_en }}" style="max-height: 100%; object-fit: contain;">
    </div>

    <!-- Right: Details Section -->
    <div class="col-md-6 p-4 p-lg-5" style="position: relative;">
        <button type="button" class="btn-close d-none d-md-block" data-bs-dismiss="modal" aria-label="Close" style="position: absolute; top: 30px; right: 30px;"></button>
        
        <div style="font-size: 12px; font-weight: 800; color: var(--accent); text-transform: uppercase; margin-bottom: 8px; letter-spacing: 1px;">
            {{ $product->categories->first()->name_en ?? 'Product' }}
        </div>
        
        <h2 style="color: var(--primary); font-size: 28px; font-weight: 800; line-height: 1.2; margin-bottom: 15px;">
            {{ $product->name_en }}
        </h2>

        <div class="d-flex align-items-center gap-3 mb-4">
            <div style="color: #f59e0b; font-size: 14px;">
                @php $avgRating = $product->averageRating(); @endphp
                @for($i = 1; $i <= 5; $i++)
                    <i class="{{ $i <= $avgRating ? 'fas' : 'far' }} fa-star"></i>
                @endfor
            </div>
            <span style="font-size: 13px; color: var(--text-muted);">({{ $product->reviews->count() }} reviews)</span>
        </div>

        <div style="background: var(--bg-soft); padding: 20px; border-radius: 12px; margin-bottom: 25px;">
            <div class="d-flex align-items-baseline gap-2">
                <span style="font-size: 32px; font-weight: 900; color: var(--primary);">৳{{ number_format($product->selling_price) }}</span>
                @if($product->discount > 0)
                    <span style="font-size: 18px; color: var(--text-muted); text-decoration: line-through;">৳{{ number_format($product->price) }}</span>
                @endif
            </div>
            <div style="font-size: 13px; color: var(--success); font-weight: 600; margin-top: 5px;">
                <i class="fa-solid fa-circle-check"></i> In Stock & Ready to Ship
            </div>
        </div>

        <p style="color: var(--text-soft); font-size: 15px; line-height: 1.6; margin-bottom: 30px;">
            {{ Str::limit(strip_tags($product->description_en), 180) }}
        </p>

        <div class="d-flex flex-column gap-3">
            <div class="d-flex gap-3">
                <div style="display: flex; align-items: center; background: #fff; border: 1px solid var(--border); border-radius: 12px; padding: 4px;">
                    <button class="qty-btn-qv" onclick="updateQtyQV(-1)" style="width: 32px; height: 32px; border: none; background: none; color: var(--primary); font-weight: 700;">-</button>
                    <input type="text" id="qtyQV" value="1" readonly style="width: 35px; border: none; text-align: center; font-weight: 700; outline: none;">
                    <button class="qty-btn-qv" onclick="updateQtyQV(1)" style="width: 32px; height: 32px; border: none; background: none; color: var(--primary); font-weight: 700;">+</button>
                </div>
                <button class="btn btn-primary addToCartQV" data-product="{{ $product->id }}" data-url="{{ route('addToCart') }}" style="flex: 1; height: 48px; justify-content: center; border-radius: 12px;">
                    <i class="fa-solid fa-cart-plus me-2"></i> Add to Cart
                </button>
            </div>
            <a href="{{ route('productDetails', $product->slug) }}" class="btn btn-outline" style="height: 48px; justify-content: center; border-radius: 12px;">
                View Full Details <i class="fa-solid fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</div>

<script>
    function updateQtyQV(val) {
        let input = document.getElementById('qtyQV');
        let qty = parseInt(input.value);
        qty = qty + val;
        if (qty < 1) qty = 1;
        input.value = qty;
    }

    $(document).ready(function() {
        $('.addToCartQV').off('click').on('click', function() {
            let btn = $(this);
            let product_id = btn.data('product');
            let url = btn.data('url');
            let qty = $('#qtyQV').val();

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
                    }
                }
            });
        });
    });
</script>
