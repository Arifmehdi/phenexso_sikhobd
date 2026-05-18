@extends('website.layouts.sikhobd')

@section('title', 'আমার উইশলিস্ট — ' . ($ws->name ?? env('APP_NAME')))

@push('css')
<style>
    .wishlist-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 30px;
        margin-top: 40px;
    }
    .wishlist-card {
        background: #fff;
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        position: relative;
        display: flex;
        flex-direction: column;
    }
    .wishlist-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }
    .wishlist-card .image {
        aspect-ratio: 16/9;
        background-size: cover;
        background-position: center;
        position: relative;
    }
    .wishlist-card .remove-btn {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(255,255,255,0.9);
        color: #ff4d4d;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
        z-index: 10;
    }
    .wishlist-card .remove-btn:hover {
        background: #ff4d4d;
        color: #fff;
    }
    .wishlist-card .content {
        padding: 24px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    .wishlist-card h3 {
        font-size: 18px;
        color: var(--text-main);
        margin-bottom: 12px;
        line-height: 1.4;
        font-weight: 700;
    }
    .wishlist-card .price-area {
        margin-top: auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 15px;
        border-top: 1px solid var(--bg-soft);
    }
    .wishlist-card .price {
        font-weight: 800;
        color: var(--primary);
        font-size: 20px;
    }
    .wishlist-card .old-price {
        text-decoration: line-through;
        color: var(--text-muted);
        font-size: 14px;
        margin-left: 8px;
    }
    .empty-wishlist {
        text-align: center;
        padding: 100px 20px;
    }
    .empty-wishlist i {
        font-size: 80px;
        color: var(--bg-soft);
        margin-bottom: 24px;
    }
</style>
@endpush

@section('content')
<section class="section" style="background: var(--bg-soft); min-height: 70vh;">
    <div class="container">
        <div class="section-header" style="text-align: left;">
            <h2 data-i18n="nav.wishlist">আমার উইশলিস্ট</h2>
            <p style="color: var(--text-soft);">আপনার পছন্দের কোর্সগুলো এখানে সংরক্ষিত আছে।</p>
        </div>

        @if($wishlists->count() > 0)
            <div class="wishlist-grid">
                @foreach($wishlists as $w)
                    @php $product = $w->product; @endphp
                    <div class="wishlist-card" id="wishlist-row-{{ $w->id }}">
                        <button class="remove-btn remove-wishlist" data-id="{{ $w->id }}" title="Remove">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                        
                        <a href="{{ route('courseDetail', $product->slug) }}" class="image" 
                           style="background-image: url('{{ route('imagecache', ['template' => 'medium', 'filename' => $product->fi()]) }}');">
                        </a>

                        <div class="content">
                            <h3><a href="{{ route('courseDetail', $product->slug) }}">{{ $product->name_en }}</a></h3>
                            
                            <div class="price-area">
                                <div>
                                    <span class="price">৳ {{ number_format($product->selling_price, 0) }}</span>
                                    @if($product->discount > 0)
                                        <span class="old-price">৳ {{ number_format($product->price ?: ($product->selling_price + $product->discount), 0) }}</span>
                                    @endif
                                </div>
                                
                                <button class="btn btn-accent btn-sm add-to-cart-ajax" 
                                        data-id="{{ $product->id }}" 
                                        style="padding: 8px 16px; font-size: 14px;">
                                    <i class="fa-solid fa-cart-plus"></i> <span data-i18n="nav.add_to_cart">কার্টে যোগ করুন</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-wishlist">
                <i class="fa-solid fa-heart-circle-xmark"></i>
                <h3 style="color: var(--text-main); margin-bottom: 16px;">আপনার উইশলিস্ট খালি!</h3>
                <p style="color: var(--text-soft); margin-bottom: 30px;">আমাদের কোর্সগুলো দেখুন এবং আপনার পছন্দের কোর্সটি খুঁজে নিন।</p>
                <a href="{{ route('courses') }}" class="btn btn-primary" data-i18n="nav.courses">কোর্সসমূহ দেখুন</a>
            </div>
        @endif
    </div>
</section>
@endsection

@push('js')
<script>
    // Remove from Wishlist
    $(document).on('click', '.remove-wishlist', function() {
        const id = $(this).data('id');
        const card = $(`#wishlist-row-${id}`);

        Swal.fire({
            title: 'আপনি কি নিশ্চিত?',
            text: "এই আইটেমটি উইশলিস্ট থেকে সরিয়ে ফেলা হবে।",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff4d4d',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'হ্যাঁ, সরিয়ে ফেলুন',
            cancelButtonText: 'না'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("{{ route('wishlist.remove') }}", {
                    id: id,
                    _token: "{{ csrf_token() }}"
                }, function(res) {
                    card.fadeOut(300, function() {
                        $(this).remove();
                        if ($('.wishlist-card').length === 0) {
                            location.reload();
                        }
                    });
                    showCartNotification('উইশলিস্ট থেকে সরানো হয়েছে', 'success');
                });
            }
        });
    });

    // Add to Cart from Wishlist
    $(document).on('click', '.add-to-cart-ajax', function() {
        const productId = $(this).data('id');
        const btn = $(this);
        
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

        $.ajax({
            url: "{{ route('addToCart') }}",
            type: "POST",
            data: {
                product: productId,
                qty: 1,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                btn.prop('disabled', false).html('<i class="fa-solid fa-check"></i> যোগ হয়েছে');
                
                // Update floating cart count
                if (response.cartCount) {
                    $('.cartCount').text(response.cartCount);
                }
                
                showCartNotification('কার্টে সফলভাবে যোগ করা হয়েছে');
                
                setTimeout(() => {
                    btn.html('<i class="fa-solid fa-cart-plus"></i> <span data-i18n="nav.add_to_cart">কার্টে যোগ করুন</span>');
                }, 2000);
            },
            error: function() {
                btn.prop('disabled', false).html('<i class="fa-solid fa-cart-plus"></i> কার্টে যোগ করুন');
                showCartNotification('কিছু ভুল হয়েছে, আবার চেষ্টা করুন', 'error');
            }
        });
    });
</script>
@endpush
