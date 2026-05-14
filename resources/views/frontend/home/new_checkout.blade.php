@extends('website.layouts.mncofee')

@section('title', 'Checkout - ' . ($ws->name ?? env('APP_NAME')))

@push('css')
<style>
    .ad-menu-banner {
        background-image: url("{{ asset('mncofee/assets/img/aida-images/menu-banner.png') }}") !important;
        background-size: cover;
        background-position: center;
        height: 250px;
    }
    .checkout-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        overflow: hidden;
        margin-bottom: 30px;
    }
    .checkout-card-header {
        background-color: #A45517;
        color: #fff;
        padding: 15px 25px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .checkout-card-body {
        padding: 30px;
        background: #fff;
    }
    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
    }
    .form-control {
        border-radius: 10px;
        padding: 12px 15px;
        border: 1px solid #eee;
    }
    .form-control:focus {
        border-color: #A45517;
        box-shadow: 0 0 0 0.2rem rgba(197, 157, 95, 0.1);
    }
    .btn-checkout {
        background-color: #A45517;
        color: #fff;
        border: none;
        padding: 15px;
        border-radius: 50px;
        font-weight: 600;
        transition: 0.3s;
    }
    .btn-checkout:hover:not(:disabled) {
        background-color: #a8854d;
        color: #fff;
        transform: translateY(-2px);
    }
    .btn-checkout:disabled {
        background-color: #ddd;
        cursor: not-allowed;
    }
    .payment-option {
        border: 1px solid #eee;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 10px;
        cursor: pointer;
        transition: 0.3s;
    }
    .payment-option:hover {
        border-color: #A45517;
    }
    .payment-option.active {
        border-color: #A45517;
        background-color: rgba(197, 157, 95, 0.05);
    }
    .payment-option .form-check-input:checked + .form-check-label {
        color: #A45517;
        font-weight: 600;
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
                <a class="selected-page" href="#"> Checkout</a>
            </div>
        </div>
    </div>
</section>

@php
    $me = Auth::user();
    $dl = $me ? $me->locations()->first() : null;
@endphp

<section class="py-5 bg-light">
    <div class="container">
        @if($cartItems->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-shopping-cart fa-4x mb-4 text-muted"></i>
                <h3>Your cart is empty</h3>
                <a href="{{ route('shop') }}" class="btn btn-primary-custom mt-3" style="background-color:#A45517; color:#fff; padding:10px 30px; border-radius:50px; text-decoration:none;">Go to Shop</a>
            </div>
        @else
            <div class="row">
                <!-- Left Column: Shipping & Payment -->
                <div class="col-lg-7">
                    <!-- Shipping Address -->
                    <div class="checkout-card">
                        <div class="checkout-card-header">
                            <i class="fas fa-map-marker-alt"></i> SHIPPING ADDRESS
                        </div>
                        <div class="checkout-card-body">
                            <form id="addressForm">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name" 
                                               value="{{ $dl ? $dl->name : ($me ? $me->name : '') }}" placeholder="Enter your name" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                        <input type="tel" class="form-control" id="mobile" name="mobile" 
                                               value="{{ $dl ? $dl->mobile : ($me ? $me->mobile : '') }}" placeholder="01XXXXXXXXX" maxlength="11" required>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Email Address</label>
                                        <input type="email" class="form-control" id="email" name="email" 
                                               value="{{ $dl ? $dl->email : ($me ? $me->email : '') }}" placeholder="Email (optional)">
                                    </div>
                                    <div class="col-12 mb-0">
                                        <label class="form-label">Delivery Address <span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="billing-address" name="billing_address" rows="3" 
                                                  placeholder="Full address (House, Road, Area...)" required>{{ $dl ? $dl->address_title : '' }}</textarea>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="checkout-card">
                        <div class="checkout-card-header">
                            <i class="fas fa-credit-card"></i> PAYMENT METHOD
                        </div>
                        <div class="checkout-card-body">
                            <div class="payment-option active">
                                <div class="form-check">
                                    <input class="form-check-input paymentMethodSelect" type="radio" value="cod" name="payment-method" id="cod" checked>
                                    <label class="form-check-label w-100" for="cod">
                                        <strong>Cash on Delivery</strong>
                                        <p class="mb-0 small text-muted">Pay with cash upon delivery.</p>
                                    </label>
                                </div>
                            </div>

                            <div class="payment-option">
                                <div class="form-check">
                                    <input class="form-check-input paymentMethodSelect" type="radio" value="online" name="payment-method" id="online">
                                    <label class="form-check-label w-100" for="online">
                                        <strong>Online Payment (bKash)</strong>
                                        <p class="mb-0 small text-muted">Pay securely via bKash.</p>
                                    </label>
                                </div>
                                <div id="online-payment-details" class="mt-3 p-3 bg-light rounded" style="display: none;">
                                    <p class="mb-2"><strong>bKash Number:</strong> 01790552864 (Merchant)</p>
                                    <div class="mb-0">
                                        <label class="form-label small">Transaction ID <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" id="transaction_id" name="transaction_id" placeholder="Enter Transaction ID">
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <label class="form-label">Order Note (Optional)</label>
                                <textarea name="order_note" id="order_note" rows="3" class="form-control" placeholder="Any special instructions..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Order Summary -->
                <div class="col-lg-5">
                    <div class="checkout-card " style="top: 20px; z-index: 1000;">
                        <div class="checkout-card-header">
                            <i class="fas fa-shopping-basket"></i> ORDER SUMMARY
                        </div>
                        <div class="checkout-card-body p-0">
                            @include('frontend.home.includes.checkout-cart-items', ['cartItems' => $cartItems])
                            
                            <div class="p-4 border-top">
                                <form id="checkoutForm" method="POST" action="">
                                    @csrf
                                    <button type="button" class="btn-checkout w-100" id="proceed-to-pay-button">
                                        PLACE ORDER NOW
                                    </button>
                                </form>
                                <p class="text-center small text-muted mt-3 mb-0">
                                    By placing your order, you agree to our <a href="#" class="text-decoration-none" style="color:#A45517;">Terms & Conditions</a>.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // CSRF for AJAX
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    @php
        $shippingCharge = isset($ws) && isset($ws->shipping_charge) ? (float)$ws->shipping_charge : 0;
    @endphp
    const shippingCharge = {{ $shippingCharge }};

    function updateSummary(res) {
        $('.cartCountBadge').text(res.cartItemsCount);
        $('.subtotal-text').text('৳' + parseFloat(res.cartTotal).toFixed(2));
        $('.discount-text').text('-৳' + parseFloat(res.discount).toFixed(2));
        $('.total-discount-text').text(parseFloat(res.discount).toFixed(2));
        $('.payable-text').text('৳' + (parseFloat(res.cartTotal) - parseFloat(res.discount) + shippingCharge).toFixed(2));
        
        // Update header count
        $('.ad-cart-count').text(res.cartCount);

        if (res.discount > 0) {
            $('#savingContainer').removeClass('d-none');
        } else {
            $('#savingContainer').addClass('d-none');
        }

        if (res.cartItemsCount == 0) {
            $('#cartSummaryContainer').addClass('d-none');
            $('.cart-action-wrapper-main').html('<div class="p-5 text-center text-muted fs-5 empty-cart-msg">Your cart is empty 🛒</div>');
            // Reload page after a delay to show empty state fully if needed
            setTimeout(() => { location.reload(); }, 2000);
        }
    }

    // AJAX Remove Item
    $(document).on('click', '.ajaxDeleteCartItem', function(e) {
        e.preventDefault();
        let btn = $(this);
        let url = btn.data('url');
        let row = btn.closest('.cart-item-row');

        Swal.fire({
            title: 'Remove Item?',
            text: "Do you want to remove this product from your cart?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#A45517',
            confirmButtonText: 'Yes, remove it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(url, function(res) {
                    if (res.status) {
                        row.fadeOut(300, function() { 
                            $(this).remove(); 
                            updateSummary(res);
                        });
                        Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: res.message, showConfirmButton: false, timer: 2000 });
                    }
                });
            }
        });
    });

    // AJAX Qty Update
    $(document).on('click', '.qty-update-btn', function() {
        let btn = $(this);
        let url = btn.data('url');
        let cartId = btn.data('cart');
        let type = btn.data('type');
        let display = btn.siblings('.cartQtyDisplay');
        let row = btn.closest('.cart-item-row');
        let subtotalDisplay = row.find('.row-subtotal');
        let unitPrice = parseFloat(subtotalDisplay.data('unit-price'));
        let currentQty = parseInt(display.text());
        
        let newQty = (type === 'plus') ? currentQty + 1 : currentQty - 1;
        if (newQty < 1) {
            // If qty becomes 0, use remove logic
            btn.closest('.cart-item-row').find('.ajaxDeleteCartItem').trigger('click');
            return;
        }

        btn.prop('disabled', true);

        $.post(url, { cart: cartId, new_qty: newQty }, function(res) {
            if (res.status) {
                display.text(newQty);
                subtotalDisplay.text('৳' + (newQty * unitPrice).toFixed(2));
                updateSummary(res);
                Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Quantity updated!', showConfirmButton: false, timer: 1500 });
            }
        }).always(() => {
            btn.prop('disabled', false);
        });
    });

    const codRoute = "{{ route('codOrderStore') }}";
    const onlineRoute = "{{ url('order/store') }}";

    // Toggle Payment Details
    $('.paymentMethodSelect').change(function() {
        $('.payment-option').removeClass('active');
        $(this).closest('.payment-option').addClass('active');

        if ($(this).val() === 'online') {
            $('#online-payment-details').slideDown();
        } else {
            $('#online-payment-details').slideUp();
        }
    });

    // Handle Order Submission
    $('#proceed-to-pay-button').click(function(e) {
        e.preventDefault();

        // Basic Validation
        const name = $('#name').val().trim();
        const mobile = $('#mobile').val().trim();
        const address = $('#billing-address').val().trim();
        const paymentMethod = $('.paymentMethodSelect:checked').val();

        if (!name || !mobile || !address) {
            Swal.fire('Required Fields', 'Please fill in name, phone, and address.', 'warning');
            return;
        }

        if (paymentMethod === 'online' && !$('#transaction_id').val().trim()) {
            Swal.fire('Required', 'Please enter your bKash Transaction ID.', 'warning');
            return;
        }

        Swal.fire({
            title: 'Confirm Order',
            text: 'Do you want to place this order?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#A45517',
            confirmButtonText: 'Yes, Confirm!'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = $('#checkoutForm');
                form.attr('action', paymentMethod === 'cod' ? codRoute : onlineRoute);
                
                // Add hidden fields
                const data = {
                    name: name,
                    mobile: mobile,
                    email: $('#email').val(),
                    billing_address: address,
                    order_note: $('#order_note').val(),
                    payment_method: paymentMethod,
                    transaction_id: $('#transaction_id').val()
                };

                $.each(data, function(key, value) {
                    form.append($('<input>').attr({type: 'hidden', name: key, value: value}));
                });

                form.submit();
            }
        });
    });
});
</script>
@endpush
