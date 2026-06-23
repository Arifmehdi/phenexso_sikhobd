<div class="row g-0" style="position: relative;">
    <button type="button" data-bs-dismiss="modal" aria-label="Close" style="position: absolute; top: 12px; right: 12px; z-index: 20; width: 36px; height: 36px; border-radius: 50%; background: #fff; border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 10px rgba(0,0,0,0.08); cursor: pointer; padding: 0;">
        <i class="fa-solid fa-xmark" style="color: var(--text-soft); font-size: 14px;"></i>
    </button>

    <div class="col-md-5" style="background: var(--bg-soft); display: flex; align-items: center; justify-content: center; min-height: 380px; position: relative;">
        @if($ebook->discount > 0)
            <span style="position: absolute; top: 16px; left: 16px; background: var(--accent); color: #fff; padding: 4px 12px; border-radius: 20px; font-weight: 700; font-size: 12px; z-index: 10;">
                {{ $ebook->discount }} TK OFF
            </span>
        @endif
        <img src="{{ asset('storage/ebook_covers/' . $ebook->cover_image) }}" alt="{{ $ebook->title_en }}" style="max-height: 320px; max-width: 80%; object-fit: contain; padding: 20px;">
    </div>

    <div class="col-md-7 p-4" style="position: relative;">
        <div style="font-size: 11px; font-weight: 700; color: var(--accent); text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 6px;">
            {{ optional($ebook->category)->name_en ?? optional($ebook->category)->name_bn ?? 'eBook' }}
        </div>

        <h2 style="color: var(--primary); font-size: 22px; font-weight: 800; line-height: 1.25; margin-bottom: 8px;">
            {{ Str::limit($ebook->title_bn ?? $ebook->title_en, 70) }}
        </h2>

        <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 12px;">
            <i class="fa-solid fa-pen-nib me-1"></i> {{ $ebook->author_name ?? 'অজানা' }}
        </p>

        <div style="background: var(--bg-soft); padding: 14px 18px; border-radius: 12px; margin-bottom: 16px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
            <div class="d-flex align-items-baseline gap-2">
                <span style="font-size: 28px; font-weight: 900; color: var(--primary);">৳{{ number_format($ebook->final_price, 2) }}</span>
                @if($ebook->discount > 0)
                    <span style="font-size: 16px; color: var(--text-muted); text-decoration: line-through;">৳{{ number_format($ebook->price, 2) }}</span>
                @endif
            </div>
            <span style="font-size: 12px; color: #28a745; font-weight: 600;">
                <i class="fa-solid fa-circle-check"></i> Available
            </span>
        </div>

        <p style="color: var(--text-soft); font-size: 14px; line-height: 1.6; margin-bottom: 20px;">
            {{ Str::limit(strip_tags($ebook->description_bn ?? $ebook->description_en), 160) }}
        </p>

        <div class="d-flex gap-2 mb-3">
            <button class="btn btn-primary addToEbookCartQV" data-ebook="{{ $ebook->id }}" data-url="{{ route('ebooks.buy', $ebook->id) }}" style="flex: 1; height: 44px; justify-content: center; border-radius: 10px; font-size: 14px;">
                <i class="fa-solid fa-cart-plus me-2"></i> Add to Cart
            </button>
        </div>

        <a href="{{ route('ebooks.show', $ebook->id) }}" class="btn btn-outline" style="width: 100%; height: 44px; justify-content: center; border-radius: 10px; font-size: 14px;">
            View Full Details <i class="fa-solid fa-arrow-right ms-2"></i>
        </a>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.addToEbookCartQV').off('click').on('click', function() {
            let btn = $(this);
            let url = btn.data('url');
            let ebookId = btn.data('ebook');

            btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin me-2"></i> Adding...');

            $.ajax({
                url: url,
                method: "GET",
                dataType: "json",
                success: function(res) {
                    if (res.login_required) {
                        $('#ebookQuickViewModal').modal('hide');
                        showLoginToastQV();
                        btn.prop('disabled', false).html('<i class="fa-solid fa-cart-plus me-2"></i> Add to Cart');
                        return;
                    }
                    if (res.status) {
                        $('.cartCount').text(parseInt($('.cartCount').text() || 0) + 1);
                        $('#ebookQuickViewModal').modal('hide');
                        showCartNotificationQV(res.message, 'success');
                    }
                },
                error: function(xhr) {
                    btn.prop('disabled', false).html('<i class="fa-solid fa-cart-plus me-2"></i> Add to Cart');
                    if (xhr.status === 401) {
                        $('#ebookQuickViewModal').modal('hide');
                        showLoginToastQV();
                    }
                }
            });
        });

        function showLoginToastQV() {
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

        function showCartNotificationQV(message, type) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
            Toast.fire({ icon: type, title: message });
        }
    });
</script>
