@extends('website.layouts.sikhobd')

@section('title', 'Checkout - '. env('APP_NAME') )

@section('meta')
<meta name="description"
    content="Contact North Bengal for inquiries, product details, or business queries. Get in touch via phone, email, or visit our office.">
<meta name="keywords" content="contact north bengal, contact us, north bengal inquiries, phone, email, office location">
<meta property="og:title" content="Contact Us - North Bengal">
<meta property="og:description" content="Reach North Bengal for product inquiries or business partnerships.">
<meta property="og:image" content="{{ asset('frontend/assets/img/northbengal/contact_banner.png') }}">
<meta property="og:type" content="website">
@endsection
@section('content')
    <!-- BREADCRUMB AREA START -->
    <x-breadcrumb title="Checkout" pageName="Checkout" bgImage="frontend/img/bg/9.jpg" />
    <!-- BREADCRUMB AREA END -->

    <!-- WISHLIST AREA START -->
    <div class="ltn__checkout-area mb-105">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ltn__checkout-inner">
                        <div class="ltn__checkout-single-content ltn__returning-customer-wrap">
                            <h5>Returning customer? <a class="ltn__secondary-color" href="#ltn__returning-customer-login" data-bs-toggle="collapse">Click here to login</a></h5>
                            <div id="ltn__returning-customer-login" class="collapse ltn__checkout-single-content-info">
                                <div class="ltn_coupon-code-form ltn__form-box">
                                    <p>Please login your accont.</p>
                                    <form action="#" >
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="input-item input-item-name ltn__custom-icon">
                                                    <input type="text" name="ltn__name" placeholder="Enter your name">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="input-item input-item-email ltn__custom-icon">
                                                    <input type="email" name="ltn__email" placeholder="Enter email address">
                                                </div>
                                            </div>
                                        </div>
                                        <button class="btn theme-btn-1 btn-effect-1 text-uppercase">Login</button>
                                        <label class="input-info-save mb-0"><input type="checkbox" name="agree"> Remember me</label>
                                        <p class="mt-30"><a href="register.html">Lost your password?</a></p>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="ltn__checkout-single-content ltn__coupon-code-wrap">
                            <h5>Have a coupon? <a class="ltn__secondary-color" href="#ltn__coupon-code" data-bs-toggle="collapse">Click here to enter your code</a></h5>
                            <div id="ltn__coupon-code" class="collapse ltn__checkout-single-content-info">
                                <div class="ltn__coupon-code-form">
                                    <p>If you have a coupon code, please apply it below.</p>
                                    <form action="#" >
                                        <input type="text" name="coupon-code" placeholder="Coupon code">
                                        <button class="btn theme-btn-2 btn-effect-2 text-uppercase">Apply Coupon</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="ltn__checkout-single-content mt-50">
                            <h4 class="title-2">Billing Details</h4>
                            <div class="ltn__checkout-single-content-info">
                                <form action="#" >
                                    <h6>Personal Information</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="input-item input-item-name ltn__custom-icon">
                                                <input type="text" name="ltn__name" placeholder="First name">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-item input-item-name ltn__custom-icon">
                                                <input type="text" name="ltn__lastname" placeholder="Last name">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-item input-item-email ltn__custom-icon">
                                                <input type="email" name="ltn__email" placeholder="email address">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-item input-item-phone ltn__custom-icon">
                                                <input type="text" name="ltn__phone" placeholder="phone number">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-item input-item-website ltn__custom-icon">
                                                <input type="text" name="ltn__company" placeholder="Company name (optional)">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-item input-item-website ltn__custom-icon">
                                                <input type="text" name="ltn__phone" placeholder="Company address (optional)">
                                            </div>
                                        </div>
                                    </div>
                                    <p><label class="input-info-save mb-0"><input type="checkbox" name="agree"> Create an account?</label></p>
                                    <h6>Order Notes (optional)</h6>
                                    <div class="input-item input-item-textarea ltn__custom-icon">
                                        <textarea name="ltn__message" placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="ltn__checkout-payment-method mt-50">
                        <h4 class="title-2">Payment Method</h4>
                        <form action="#" id="checkout-payment-form">
                            <div id="checkout_accordion_1">
                                <!-- card -->
                                <div class="card">
                                    <h5 class="ltn__card-title" data-bs-toggle="collapse" data-bs-target="#faq-item-2-2" aria-expanded="true"> 
                                        <label class="d-flex align-items-center mb-0">
                                            <input class="form-check-input me-2" type="radio" name="payment_method" id="payment_method_cod" value="cod" checked>
                                            Cash on delivery
                                        </label>
                                        <img src="{{ asset('frontend/img/icons/cash.png') }}" alt="#">
                                    </h5>
                                    <div id="faq-item-2-2" class="collapse show" data-parent="#checkout_accordion_1">
                                        <div class="card-body">
                                            <p>Pay with cash upon delivery.</p>
                                        </div>
                                    </div>
                                </div>                             

                                <!-- card -->
                                <div class="card">
                                    <h5 class="collapsed ltn__card-title" data-bs-toggle="collapse" data-bs-target="#faq-item-2-4" aria-expanded="false" >
                                        <label class="d-flex align-items-center mb-0">
                                            <input class="form-check-input me-2" type="radio" name="payment_method" id="payment_method_online" value="online">
                                            Online Payment
                                        </label>
                                        <img src="{{ asset('frontend/img/icons/payment-3.png') }}" alt="#">
                                    </h5>
                                    <div id="faq-item-2-4" class="collapse" data-parent="#checkout_accordion_1">
                                        <div class="card-body">
                                            <p>Pay using bKash, Nagad, or Rocket to <strong>01349494295</strong>. After sending payment, enter your transaction ID below.</p>
                                            <div id="online_payment_details" class="mt-3" style="display: none;">
                                                <div class="input-item input-item-name ltn__custom-icon">
                                                    <label for="transaction_id">Transaction ID</label>
                                                    <input type="text" class="form-control" id="transaction_id" name="transaction_id" placeholder="Enter transaction ID">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="ltn__payment-note mt-30 mb-30">
                                <p>Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our privacy policy.</p>
                            </div>
                            <button class="btn theme-btn-1 btn-effect-1 text-uppercase" type="submit">Place order</button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="shoping-cart-total mt-50">
                        <h4 class="title-2">Cart Totals</h4>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Vegetables Juices <strong>× 2</strong></td>
                                    <td>$298.00</td>
                                </tr>
                                <tr>
                                    <td>Orange Sliced Mix <strong>× 2</strong></td>
                                    <td>$170.00</td>
                                </tr>
                                <tr>
                                    <td>Red Hot Tomato <strong>× 2</strong></td>
                                    <td>$150.00</td>
                                </tr>
                                <tr>
                                    <td>Shipping and Handing</td>
                                    <td>$15.00</td>
                                </tr>
                                <tr>
                                    <td>Vat</td>
                                    <td>$00.00</td>
                                </tr>
                                <tr>
                                    <td><strong>Order Total</strong></td>
                                    <td><strong>$633.00</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- WISHLIST AREA START -->

    <!-- FEATURE AREA START ( Feature - 3) -->
    <x-footer-feature />
    <!-- FEATURE AREA END -->

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const onlineRadio = document.getElementById('payment_method_online');
            const codRadio = document.getElementById('payment_method_cod');
            const onlineDetails = document.getElementById('online_payment_details');
            const transactionInput = document.getElementById('transaction_id');
            const paymentForm = document.getElementById('checkout-payment-form');

            function updateOnlinePaymentFields() {
                const onlineSelected = onlineRadio.checked;
                onlineDetails.style.display = onlineSelected ? 'block' : 'none';
                transactionInput.required = onlineSelected;
            }

            onlineRadio.addEventListener('change', updateOnlinePaymentFields);
            codRadio.addEventListener('change', updateOnlinePaymentFields);
            updateOnlinePaymentFields();

            paymentForm.addEventListener('submit', function (event) {
                if (onlineRadio.checked && !transactionInput.value.trim()) {
                    event.preventDefault();
                    alert('Please enter your transaction ID for online payment.');
                    transactionInput.focus();
                }
            });
        });
    </script>
@endsection