<div class="checkout-card-header" style="background-color: #A45517; border-bottom: 1px solid rgba(0,0,0,0.05);">
    <i class="fa fa-shopping-cart"></i> CART ITEMS
    <span class="badge bg-white text-dark ms-2 cartCountBadge">{{ $cartItems->count() }}</span>
</div>

<div class="p-0 overflow-auto cart-action-wrapper-main">
    @if($cartItems->isEmpty())
        <div class="p-5 text-center text-muted fs-5 empty-cart-msg">Your cart is empty 🛒</div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 border-0 small fw-bold text-uppercase">Product</th>
                        <th class="py-3 border-0 small fw-bold text-uppercase text-center">Price</th>
                        <th class="py-3 border-0 small fw-bold text-uppercase text-center">Qty</th>
                        <th class="py-3 border-0 small fw-bold text-uppercase text-end pe-4">Total</th>
                    </tr>
                </thead>
                <tbody id="cartTableBody">
                    @foreach ($cartItems as $cart)
                        <tr class="cart-item-row" data-cart="{{ $cart->id }}">
                            <td class="ps-4 py-3 border-bottom-0">
                                <div class="d-flex align-items-center gap-3">
                                    <button title="Remove" class="btn btn-sm p-0 ajaxDeleteCartItem" data-url="{{ route('cartRemoveItem', $cart->id) }}">
                                        <i class="fas fa-times-circle text-danger"></i>
                                    </button>
                                    <img src="{{ route('imagecache', ['template'=>'ppsm','filename' => $cart->product->fi()]) }}"
                                         class="rounded" style="width:50px; height:50px; object-fit:cover;">
                                    <div>
                                        <a href="{{ route('productDetails', ['slug' => $cart->product->slug, 'id' => $cart->product_id]) }}"
                                           class="text-dark text-decoration-none fw-semibold d-block small">
                                            {{ Str::limit($cart->product->name_en, 30) }}
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center py-3 border-bottom-0 small fw-bold">
                                ৳{{ number_format($cart->product->selling_price, 2) }}
                            </td>
                            <td class="text-center py-3 border-bottom-0">
                                <div class="d-flex align-items-center justify-content-center gap-1">
                                    <button class="btn btn-xs btn-outline-secondary rounded-circle qty-update-btn minus" 
                                            style="width:24px; height:24px; line-height:1; padding:0;"
                                            data-url="{{ route('cartUpdateQty') }}" data-cart="{{ $cart->id }}" data-type="minus">−</button>
                                    <span class="cartQtyDisplay small fw-bold px-2">{{ $cart->quantity }}</span>
                                    <button class="btn btn-xs btn-outline-secondary rounded-circle qty-update-btn plus" 
                                            style="width:24px; height:24px; line-height:1; padding:0;"
                                            data-url="{{ route('cartUpdateQty') }}" data-cart="{{ $cart->id }}" data-type="plus">+</button>
                                </div>
                            </td>
                            <td class="text-end pe-4 py-3 border-bottom-0 fw-bold text-primary row-subtotal" 
                                style="color: #A45517 !important;"
                                data-unit-price="{{ $cart->product->selling_price }}">
                                ৳{{ number_format($cart->quantity * $cart->product->selling_price, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@php
    $totalCartPrice = \App\Models\Cart::totalCartPrice();
    $totalDiscountAmount = \App\Models\Cart::totalDiscountAmount();
    $shippingCharge = isset($ws) && isset($ws->shipping_charge) ? $ws->shipping_charge : 0;
    $initialTotal = $totalCartPrice - $totalDiscountAmount + $shippingCharge;
@endphp

<div id="cartSummaryContainer" class="@if($cartItems->isEmpty()) d-none @endif">
    <div class="p-4 border-top bg-light">
        <div id="savingContainer" class="text-center text-white rounded-pill py-1 fw-bold mb-3 small @if($totalDiscountAmount <= 0) d-none @endif" style="background: #A45517">
            SAVING ৳<span class="total-discount-text">{{ number_format($totalDiscountAmount, 2) }}</span> ON THIS ORDER
        </div>

        <div class="d-flex justify-content-between mb-2">
            <span class="text-muted small fw-bold text-uppercase">Subtotal</span>
            <span class="subtotal-text fw-bold small">৳{{ number_format($totalCartPrice, 2) }}</span>
        </div>

        <div class="d-flex justify-content-between mb-2">
            <span class="text-muted small fw-bold text-uppercase">Discount</span>
            <span class="discount-text fw-bold small text-danger">-৳{{ number_format($totalDiscountAmount, 2) }}</span>
        </div>

        <div class="d-flex justify-content-between mb-3">
            <span class="text-muted small fw-bold text-uppercase">Shipping</span>
            <span class="shipping-text fw-bold small">৳{{ number_format($shippingCharge, 2) }}</span>
        </div>

        <hr>

        <div class="d-flex justify-content-between align-items-center">
            <span class="fw-bold text-uppercase">Total</span>
            <span class="payable-text fw-bold fs-4" style="color: #A45517;">
                ৳{{ number_format($initialTotal, 2) }}
            </span>
        </div>
    </div>
</div>
