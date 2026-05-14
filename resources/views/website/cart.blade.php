@extends('website.layouts.sungoods')

@section('title', 'Cart - '. env('APP_NAME') )

@section('met<meta name="description" content="Cart - North Bengal">
<meta name="keywords" content="cart, shopping">
@endsection

@push('css')
<style>
.page-content { padding-top: 30px; padding-bottom: 40px; }
.step-by { display: flex; justify-content: center; gap: 30px; margin-bottom: 40px; }
.title-step { font-size: 14px; font-weight: 500; }
.title-step a { color: #999; text-decoration: none; }
.title-step.active a, .title-step a:hover { color: #333; }
.title-step.active a { font-weight: 700; }
.shop-table { width: 100%; border-collapse: collapse; }
.shop-table thead th { padding: 15px; text-align: left; font-weight: 600; color: #333; border-bottom: 1px solid #eee; }
.shop-table tbody td { padding: 20px 15px; border-bottom: 1px solid #eee; vertical-align: middle; }
.shop-table .product-thumbnail img { width: 80px; height: 80px; object-fit: cover; border-radius: 4px; }
.shop-table .product-name a { color: #333; font-weight: 500; text-decoration: none; }
.shop-table .amount { font-weight: 600; color: #333; }
.cart-actions { display: flex; justify-content: space-between; margin-top: 20px; }
.cart-summary { background: #f9f9f9; padding: 30px; border-radius: 8px; }
.order-table { width: 100%; border-collapse: collapse; }
.order-table th, .order-table td { padding: 12px 0; border-bottom: 1px solid #eee; }
.summary-total-price { font-size: 18px; font-weight: 700; color: #333; }
.btn-order { width: 100%; padding: 15px; background: #333; color: #fff; border: none; border-radius: 25px; font-size: 16px; font-weight: 600; cursor: pointer; }
.cart-empty { text-align: center; padding: 60px 20px; }
.cart-empty p { font-size: 18px; color: #666; margin-bottom: 20px; }
</style>
@endpush

@section('content')
<!-- BREADCRUMB AREA START -->
<x-breadcrumb title="Cart" pageName="Cart" bgImage="frontend/img/bg/9.jpg" />
<!-- BREADCRUMB AREA END -->

@php
$me = Auth::user();
$dl = $me ? $me->locations()->first() : null;
$cartTotal = $cart_total ?? $cartItems->sum(fn($item) => $item->price * $item->quantity);
@endphp

@if($cartItems->isEmpty())
<div class=""cart-empty"">
    <p>Your cart is empty</p>
    <a href=""{{ route('shop') }}"" class=""btn btn-dark btn-rounded"">Continue Shopping</a>
</div>
@else
<main class=""main cart checkout"">
    <div class=""page-content pt-7 pb-10"">
        <div class=""step-by pr-4 pl-4"">
            <h3 class=""title title-simple title-step active""><a href=""#"">1. Shopping Cart</a></h3>
            <h3 class=""title title-simple title-step""><a href=""#"">2. Checkout</a></h3>
            <h3 class=""title title-simple title-step""><a href=""#"">3. Order Complete</a></h3>
        </div>
        
        <div class=""container mt-7"">
            @if(session('success'))
                <div class=""alert alert-success mb-4"">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class=""alert alert-danger mb-4"">{{ session('error') }}</div>
            @endif

            <form id=""checkoutForm"" method=""POST"" action=""""">
                @csrf
                <input type=""hidden"" name=""shipping_price"" id=""hidden-shipping-price"" value=""0"">
                
                <div class=""row"">
                    <div class=""col-lg-8 col-md-12 pr-lg-4 mb-6 mb-lg-0"">
                        <table class=""shop-table cart-table"">
                            <thead>
                                <tr>
                                    <th><span>Product</span></th>
                                    <th></th>
                                    <th><span>Price</span></th>
                                    <th><span>Quantity</span></th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cartItems as $item)
                                <tr id=""cart-item-{{ $item->id }}"">
                                    <td class=""product-thumbnail"">
                                        <a href=""{{ route('productDetails', $item->product->slug) }}"">
                                            <img src=""{{ route('imagecache', ['template'=>'pnism','filename'=>$item->product->fi()]) }}"" alt=""{{ $item->product->name_en }}"" width=""80"" height=""80"">
                                        </a>
                                    </td>
                                    <td class=""product-name"">
                                        <a href=""{{ route('productDetails', $item->product->slug) }}"">{{ Str::limit($item->product->name_en, 30) }}</a>
                                    </td>
                                    <td class=""product-subtotal"">
                                        <span class=""amount"">{{ number_format($item->product->final_price,2) }} ?</span>
                                    </td>
                                    <td class=""product-quantity"">
                                        <input type=""number"" value=""{{ $item->quantity }}"" min=""1"" data-id=""{{ $item->id }}"" class=""form-control"" style=""width: 80px;"">
                                    </td>
                                    <td class=""product-price"">
                                        <span class=""amount"" id=""subtotal-{{ $item->id }}"">{{ number_format($item->quantity * $item->product->final_price,2) }} ?</span>
                                    </td>
                                    <td class=""product-close"">
                                        <a href=""javascript:void(0);"" class=""product-remove"" data-id=""{{ $item->id }}""><i class=""fas fa-times""></i></a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan=""6"" class=""text-center"">Your cart is empty!</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        
                        <div class=""cart-actions mb-6 pt-4"">
                            <a href=""{{ route('shop') }}"" class=""btn btn-dark btn-md btn-rounded"">Continue Shopping</a>
                            <button type=""button"" class=""btn btn-outline btn-dark btn-md btn-rounded"" onclick=""updateCart()"">Update Cart</button>
                        </div>

                        <div class=""billing-form mt-6"">
                            <h3>Billing Details</h3>
                            <div class=""row"">
                                <div class=""col-md-6 mb-3"">
                                    <label>First Name *</label>
                                    <input type=""text"" class=""form-control"" name=""first_name"" required>
                                </div>
                                <div class=""col-md-6 mb-3"">
                                    <label>Last Name *</label>
                                    <input type=""text"" class=""form-control"" name=""last_name"" required>
                                </div>
                            </div>
                            <div class=""row"">
                                <div class=""col-md-6 mb-3"">
                                    <label>Email Address *</label>
                                    <input type=""email"" class=""form-control"" name=""email"" required>
                                </div>
                                <div class=""col-md-6 mb-3"">
                                    <label>Phone Number *</label>
                                    <input type=""text"" class=""form-control"" name=""phone"" required>
                                </div>
                            </div>
                            <div class=""mb-3"">
                                <label>Address *</label>
                                <input type=""text"" class=""form-control"" name=""address"" required>
                            </div>
                            <div class=""row"">
                                <div class=""col-md-6 mb-3"">
                                    <label>Town / City *</label>
                                    <input type=""text"" class=""form-control"" name=""city"" required>
                                </div>
                                <div class=""col-md-6 mb-3"">
                                    <label>Post Code *</label>
                                    <input type=""text"" class=""form-control"" name=""post_code"" required>
                                </div>
                            </div>
                            <div class=""mb-3"">
                                <label>Order Notes (Optional)</label>
                                <textarea class=""form-control"" rows=""3"" name=""notes""></textarea>
                            </div>
                        </div>
                    </div>

                    <aside class=""col-lg-4"">
                        <div class=""cart-summary"">
                            <h3>Your Order</h3>
                            <table class=""order-table"">
                                <tbody>
                                    @forelse($cartItems as $item)
                                    <tr>
                                        <td>{{ Str::limit($item->product->name_en, 25) }} x {{ $item->quantity
                                     }}</td>
                           @empty 
                                   <p>Your cart is empty.</p>              <td>{{ number_format($item->quantity * $item->product->final_price,2) }} ?</td>
                                    </tr>
                                    @endforelse
                                    <tr>
                                        <td><strong>Subtotal</strong></td>
                                        <td id=""cart-subtotal"">{{ number_format($cartSubtotal,2) }} ?</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Shipping</strong></td>
                                        <td>{{ $ws->shipping_charge ?? '0.00' }} ?</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total</strong></td>
                                        <td class=""summary-total-price"" id=""order-total"">{{ number_format($cartSubtotal + ($ws->shipping_charge ?? 0), 2) }} ?</td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class=""mt-4"">
                                <h4>Payment Methods</h4>
                                <div class=""form-check mb-2"">
                                    <input class=""form-check-input"" type=""radio"" name=""payment"" id=""cod"" value=""cod"" checked>
                                    <label class=""form-check-label"" for=""cod"">Cash on Delivery</label>
                                </div>
                                <div class=""form-check mb-3"">
                                    <input class=""form-check-input"" type=""radio"" name=""payment"" id=""online"" value=""online"">
                                    <label class=""form-check-label"" for=""online"">Online Payment</label>
                                </div>
                            </div>

                            <div class=""form-check mb-4"">
                                <input type=""checkbox"" class=""form-check-input"" id=""terms-condition"" required>
                                <label class=""form-check-label"" for=""terms-condition"">I agree to terms & conditions</label>
                            </div>

                            <button type=""submit"" class=""btn-order"">Place Order</button>
                        </div>
                    </aside>
                </div>
            </form>
        </div>
    </div>
</main>
@endif

<!-- FEATURE AREA START ( Feature - 3) -->
<x-footer-feature />
<!-- FEATURE AREA END -->
@endsection

@push('js')
">Place Order</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- WISHLIST AREA START -->
@endif

<!-- FEATURE AREA START ( Feature - 3) -->
<x-footer-feature />
<!-- FEATURE AREA END -->
@endsection

@push('js')

@endpush