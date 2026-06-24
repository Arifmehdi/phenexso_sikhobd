@extends('website.layouts.sikhobd')

@section('title', 'Shopping Cart & Checkout — ' . ($ws->name ?? env('APP_NAME')))

@push('css')
<style>
    .cart-page { padding: 60px 0; background: #f8fafc; min-height: 80vh; }
    
    .modern-card { background: #fff; border-radius: 24px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.02); margin-bottom: 24px; transition: all 0.3s ease; }
    .modern-card:hover { box-shadow: 0 10px 25px rgba(0,0,0,0.04); }
    
    .card-header-clean { padding: 22px 25px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; gap: 12px; background: #fff; }
    .card-header-clean i { color: var(--primary); font-size: 16px; }
    .card-header-clean h2 { font-size: 16px; font-weight: 800; color: var(--primary); margin: 0; text-transform: uppercase; letter-spacing: 0.5px; }
    
    .form-content { padding: 30px; }
    .custom-label { font-weight: 700; color: #334155; font-size: 13px; margin-bottom: 8px; display: block; text-transform: uppercase; letter-spacing: 0.5px; }
    .custom-input { border-radius: 12px; border: 1px solid #e2e8f0; padding: 12px 15px; font-size: 14px; transition: all 0.2s; background: #fdfdfd; width: 100%; }
    .custom-input:focus { border-color: var(--primary); background: #fff; box-shadow: 0 0 0 4px rgba(var(--primary-rgb), 0.1); outline: none; }
    
    /* Optimized Row Layout */
    .item-row { padding: 15px 20px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; gap: 15px; position: relative; }
    .item-row:last-child { border-bottom: none; }
    .item-img { width: 45px; height: 45px; border-radius: 8px; object-fit: contain; background: #fff; border: 1px solid #f1f5f9; flex-shrink: 0; }
    .item-info { flex: 1; min-width: 0; display: flex; align-items: center; justify-content: space-between; gap: 15px; }
    .item-name { font-size: 13px; font-weight: 700; color: var(--primary); text-decoration: none; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 120px; }
    
    .qty-ctrl { display: flex; align-items: center; background: #f8fafc; border-radius: 8px; padding: 2px; border: 1px solid #e2e8f0; flex-shrink: 0; }
    .qty-btn { width: 24px; height: 24px; border: none; background: #fff; border-radius: 6px; color: var(--primary); font-weight: 800; cursor: pointer; font-size: 10px; display: flex; align-items: center; justify-content: center; }
    .qty-val { width: 25px; border: none; background: transparent; text-align: center; font-weight: 700; font-size: 12px; }
    
    .item-price-val { font-size: 13px; font-weight: 800; color: var(--primary); min-width: 70px; text-align: right; flex-shrink: 0; }
    
    .remove-x { color: #cbd5e1; font-size: 16px; cursor: pointer; transition: 0.2s; flex-shrink: 0; }
    .remove-x:hover { color: #ef4444; transform: scale(1.1); }

    .summary-box { padding: 20px 25px; }
    .summary-line { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px; color: #64748b; }
    .summary-line.grand-total { margin-top: 15px; padding-top: 15px; border-top: 1px solid #f1f5f9; font-size: 20px; font-weight: 900; color: var(--primary); }
    
    .pay-card { border: 2px solid #f1f5f9; border-radius: 16px; padding: 12px 15px; cursor: pointer; transition: 0.2s; display: flex; align-items: center; gap: 10px; width: 100%; margin-bottom: 10px; }
    .pay-card.active { border-color: var(--primary); background: rgba(var(--primary-rgb), 0.03); }
    .pay-card input { width: 16px; height: 16px; accent-color: var(--primary); }
    
    .action-btn { width: 100%; height: 56px; border-radius: 16px; background: var(--primary); color: #fff; font-weight: 800; font-size: 16px; display: flex; align-items: center; justify-content: center; gap: 10px; border: none; transition: all 0.3s; cursor: pointer; box-shadow: 0 4px 15px rgba(var(--primary-rgb), 0.2); margin-top: 15px; }
    .action-btn:hover { background: #000; transform: translateY(-3px); box-shadow: 0 10px 25px rgba(0,0,0,0.15); }

    /* Layout Logic: Address Left, Everything Else Right */
    .checkout-layout { display: flex; gap: 30px; align-items: flex-start; }
    .col-address { flex: 1; }
    .col-details-sidebar { flex: 0 0 450px; width: 450px; }

    @media (max-width: 1100px) {
        .checkout-layout { flex-direction: column; }
        .col-details-sidebar { width: 100%; flex: 1; }
        .item-name { max-width: 100%; }
    }
</style>
@endpush

@section('content')
<section class="page-hero">
    <div class="container text-center">
        <h1 data-i18n="cart.title" style="font-weight: 900; font-size: 36px; letter-spacing: -1px;">চেকআউট</h1>
        <div class="crumbs justify-content-center mt-2">
            <a href="{{ route('home') }}">Home</a> <span class="mx-2 opacity-50">/</span> 
            <span style="color: var(--accent); font-weight: 700;">Secure Checkout</span>
        </div>
    </div>
</section>

<div class="cart-page">
    <div class="container">
        @if($cartItems->count() > 0)
        <form action="{{ route('codOrderStore') }}" method="POST" id="checkoutForm">
            @csrf
            <div class="checkout-layout">
                
                <!-- Left Column (Address Only) -->
                <div class="col-address">
                    <div class="modern-card">
                        <div class="card-header-clean">
                            <i class="fa-solid {{ ($hasCourse || $hasEbook) && !$hasProduct ? 'fa-user-graduate' : 'fa-truck-fast' }}"></i>
                            <h2>১. {{ ($hasCourse || $hasEbook) && !$hasProduct ? 'রেজিস্ট্রেশন তথ্য' : ((($hasCourse || $hasEbook) && $hasProduct) ? 'শিপিং এবং রেজিস্ট্রেশন তথ্য' : 'শিপিং এবং ডেলিভারি তথ্য') }}</h2>
                        </div>
                        <div class="form-content">
                            @if(!auth()->check())
                            <div class="alert alert-info mb-4" style="border-radius: 12px; font-size: 14px;">
                                <i class="fa-solid fa-circle-info mr-2"></i> আপনার কি আগে থেকেই অ্যাকাউন্ট আছে? <a href="{{ route('login') }}" class="fw-bold">লগইন করুন</a>
                            </div>
                            @endif
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="custom-label">পুরো নাম *</label>
                                    <input type="text" name="name" class="form-control custom-input" value="{{ optional(auth()->user())->name }}" placeholder="আপনার নাম লিখুন" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="custom-label">মোবাইল নম্বর *</label>
                                    <input type="text" name="mobile" class="form-control custom-input" value="{{ optional(auth()->user())->mobile }}" placeholder="মোবাইল নম্বর" required>
                                </div>
                                <div class="col-12">
                                    <label class="custom-label">ইমেইল ঠিকানা *</label>
                                    <input type="email" name="email" class="form-control custom-input" value="{{ optional(auth()->user())->email }}" placeholder="আপনার ইমেইল" required>
                                </div>

                                @if($hasCourse || $hasEbook)
                                    <div class="col-md-6">
                                        <label class="custom-label">পেশা *</label>
                                        <select name="occupation" class="form-control custom-input" required>
                                            <option value="">নির্বাচন করুন</option>
                                            <option value="Student" {{ optional(auth()->user())->occupation == 'Student' ? 'selected' : '' }}>ছাত্র (Student)</option>
                                            <option value="Job Holder" {{ optional(auth()->user())->occupation == 'Job Holder' ? 'selected' : '' }}>চাকুরীজীবী (Job Holder)</option>
                                            <option value="Business" {{ optional(auth()->user())->occupation == 'Business' ? 'selected' : '' }}>ব্যবসায়ী (Business)</option>
                                            <option value="Other" {{ optional(auth()->user())->occupation == 'Other' ? 'selected' : '' }}>অন্যান্য (Other)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="custom-label">সর্বশেষ পড়াশোনা (Last Study)</label>
                                        <select name="last_academic_status" class="form-control custom-input">
                                            <option value="">নির্বাচন করুন</option>
                                            <option value="PSC/Ebtedayee">PSC/ইবতেদায়ী</option>
                                            <option value="JSC/JDC">JSC/জেডিসি</option>
                                            <option value="SSC/Dakhil">SSC/দাখিল</option>
                                            <option value="HSC/Alim">HSC/আলিম</option>
                                            <option value="Bachelors/Honors">স্নাতক/অনার্স</option>
                                            <option value="Masters">স্নাতকোত্তর</option>
                                            <option value="Diploma">ডিপ্লোমা</option>
                                            <option value="Other">অন্যান্য</option>
                                        </select>
                                    </div>
                                @endif

                                @if($hasProduct)
                                <div class="col-md-4">
                                    <label class="custom-label">বিভাগ (Division) *</label>
                                    <select name="division_id" id="division_id" class="form-control custom-input" required>
                                        <option value="">বিভাগ নির্বাচন করুন</option>
                                        @foreach($divisions as $division)
                                            <option value="{{ $division->id }}" data-name="{{ $division->name }}">{{ $division->bn_name ?? $division->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="custom-label">জেলা (District) *</label>
                                    <select name="district_id" id="district_id" class="form-control custom-input" required disabled>
                                        <option value="">আগে বিভাগ নির্বাচন করুন</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="custom-label">উপজেলা / থানা (Upazila) *</label>
                                    <select name="upazila_id" id="upazila_id" class="form-control custom-input" required disabled>
                                        <option value="">আগে জেলা নির্বাচন করুন</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <input type="hidden" name="delivery_area" id="delivery_area" value="inside">
                                    <div id="delivery-zone-info" class="alert alert-light mb-0" style="border-radius:12px; border:1px dashed #cbd5e1; display:none; font-size:14px;">
                                        <i class="fa-solid fa-truck-fast mr-2" style="color:var(--primary);"></i>
                                        <span id="delivery-zone-text"></span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="custom-label">বিস্তারিত ঠিকানা (বাসা, রোড, এলাকা) *</label>
                                    <textarea name="billing_address" class="form-control custom-input" rows="3" placeholder="বাসা/হোল্ডিং নম্বর, রোড, এলাকা" required>{{ auth()->check() && auth()->user()->locations()->first() ? auth()->user()->locations()->first()->address_title : '' }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="custom-label">অফিসের ঠিকানা (ঐচ্ছিক)</label>
                                    <input type="text" name="office_address" class="form-control custom-input" placeholder="অফিসের ঠিকানা লিখুন">
                                </div>
                                <div class="col-md-6">
                                    <label class="custom-label">অফিস টাইম (ঐচ্ছিক)</label>
                                    <input type="text" name="office_time" class="form-control custom-input" placeholder="উদাহরণ: সকাল ৯টা - বিকাল ৫টা">
                                </div>
                                @endif

                                <div class="col-12">
                                    <label class="custom-label">অর্ডার নোট (ঐচ্ছিক)</label>
                                    <textarea name="order_note" class="form-control custom-input" rows="2" placeholder="অর্ডার সম্পর্কে বিশেষ কোনো তথ্য থাকলে দিন"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column (Summary, Items, Payment) -->
                <div class="col-details-sidebar">
                    
                    <!-- Order Summary (Top Right) -->
                    <div class="modern-card">
                        <div class="card-header-clean">
                            <i class="fa-solid fa-receipt"></i>
                            <h2>{{ ($hasCourse || $hasEbook) ? 'রেজিস্ট্রেশন সামারি' : 'অর্ডার সামারি' }}</h2>
                        </div>
                        <div class="summary-box">
                            <div class="summary-line">
                                <span>সাবটোটাল</span>
                                <span id="summary-subtotal" class="fw-bold text-dark">৳{{ number_format($cartSubtotal) }}</span>
                            </div>
                            <div class="summary-line">
                                <span>ডেলিভারি চার্জ</span>
                                <span id="summary-delivery" class="fw-bold text-dark" data-charge="{{ $shippingCharge }}">৳{{ number_format($shippingCharge) }}</span>
                            </div>
                            <div class="summary-line grand-total">
                                <span>সর্বমোট</span>
                                <span id="summary-total" data-subtotal="{{ $cartSubtotal }}">৳{{ number_format($cartSubtotal + $shippingCharge) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Product Items (Right Middle) - SINGLE ROW OPTIMIZED -->
                    <div class="modern-card">
                        <div class="card-header-clean">
                            <i class="fa-solid fa-box-open"></i>
                            <h2>২. {{ ($hasCourse || $hasEbook) ? 'এনরোলমেন্টকৃত কোর্স/ই-বুক' : 'অর্ডারকৃত পণ্যসমূহ' }}</h2>
                        </div>
                        <div class="items-list">
                            @foreach($cartItems as $item)
                            <div class="item-row" id="cart-row-{{ $item->id }}">
                                @if($item->ebook_id)
                                    <img src="{{ asset('storage/ebook_covers/' . $item->ebook->cover_image) }}" class="item-img" alt="">
                                    <div class="item-info">
                                        <a href="{{ route('ebooks.show', $item->ebook_id) }}" class="item-name">{{ Str::limit($item->ebook->title_bn ?? $item->ebook->title_en, 40) }}</a>
                                        
                                        <div class="qty-ctrl">
                                            <input type="text" class="qty-val" value="1" readonly style="width: 40px;">
                                        </div>
                                        
                                        <div class="item-price-val">৳{{ number_format($item->ebook->final_price) }}</div>
                                        
                                        <i class="fa-solid fa-xmark remove-x" onclick="removeCartItem({{ $item->id }})"></i>
                                    </div>
                                @else
                                    <img src="{{ route('imagecache', ['template' => 'pnism', 'filename' => $item->product->fi()]) }}" class="item-img" alt="">
                                    <div class="item-info">
                                        <a href="{{ route('productDetails', $item->product->slug) }}" class="item-name">{{ Str::limit($item->product->name_en, 40) }}</a>
                                        
                                        <div class="qty-ctrl">
                                            <button type="button" class="qty-btn" onclick="updateCartQty({{ $item->id }}, -1)">-</button>
                                            <input type="text" id="qty-input-{{ $item->id }}" class="qty-val" value="{{ $item->quantity }}" readonly>
                                            <button type="button" class="qty-btn" onclick="updateCartQty({{ $item->id }}, 1)">+</button>
                                        </div>
                                        
                                        <div class="item-price-val" id="item-subtotal-{{ $item->id }}">৳{{ number_format($item->quantity * $item->product->final_price) }}</div>
                                        
                                        <i class="fa-solid fa-xmark remove-x" onclick="removeCartItem({{ $item->id }})"></i>
                                    </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Payment Methods (Right Bottom) -->
                    <div class="modern-card">
                        <div class="card-header-clean">
                            <i class="fa-solid fa-wallet"></i>
                            <h2>৩. পেমেন্ট মেথড এবং {{ ($hasCourse || $hasEbook) ? 'রেজিস্ট্রেশন' : 'অর্ডার' }}</h2>
                        </div>
                        <div class="form-content" style="padding-top: 20px;">
                            <label class="pay-card active">
                                <input type="radio" name="payment_method" value="cod" checked>
                                <div>
                                    <div class="fw-bold text-dark" style="font-size: 14px;">Cash on Delivery</div>
                                    <div class="text-muted small">পণ্য হাতে পেয়ে টাকা দিন</div>
                                </div>
                            </label>
                            <label class="pay-card">
                                <input type="radio" name="payment_method" value="online">
                                <div>
                                    <div class="fw-bold text-dark" style="font-size: 14px;">Online Payment</div>
                                    <div class="text-muted small">বিকাশ, নগদ, রকেট অথবা কার্ড পেমেন্ট</div>
                                </div>
                            </label>

                            <div id="online_payment_details" class="mt-3 mb-3" style="display: none;">
                                <div class="alert alert-light" style="border-radius: 16px; padding: 16px; border: 1px solid #e2e8f0;">
                                    <p class="mb-2 fw-bold">Online payment instruction</p>
                                    <p class="mb-1">পেমেন্ট পাঠান <strong>01349494295</strong> (bKash / Nagad / Rocket).</p>
                                    <label class="custom-label">Transaction ID (TXN ID) *</label>
                                    <input type="text" name="transaction_id" id="transaction_id" class="form-control custom-input" placeholder="পেমেন্টের টিআরএন আইডি দিন">
                                </div>
                            </div>

                            <div class="form-check mt-3 mb-3">
                                <input class="form-check-input" type="checkbox" id="termsCheck" required checked>
                                <label class="form-check-label text-muted small" for="termsCheck">সাইটের শর্তাবলী মেনে নিচ্ছি</label>
                            </div>

                            <button type="submit" class="action-btn">
                                {{ ($hasCourse || $hasEbook) ? 'রেজিস্ট্রেশন সম্পন্ন করুন' : 'অর্ডার সম্পন্ন করুন' }} <i class="fa-solid fa-check-circle"></i>
                            </button>
                        </div>
                    </div>

                </div>

            </div>
        </form>
        @else
        <div class="text-center py-5" style="background:#fff; border-radius: 30px; border: 1px solid #e2e8f0;">
            <img src="https://cdn-icons-png.flaticon.com/512/1170/1170577.png" alt="" style="width: 100px; opacity: 0.2; margin-bottom: 20px;">
            <h2 style="font-weight: 900; color: #1e293b;">আপনার কার্ট বর্তমানে খালি</h2>
            <p class="text-muted mb-4">আমাদের কালেকশন থেকে আপনার পছন্দের পণ্য যোগ করুন</p>
            <a href="{{ route('shop') }}" class="btn btn-primary" style="padding: 15px 40px; border-radius: 16px; font-weight: 800;">শপিং শুরু করুন</a>
        </div>
        @endif
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        const codRoute = "{{ route('codOrderStore') }}";
        // Online payment now collects a TXN ID and stores the order directly (no gateway)
        const onlineRoute = "{{ route('codOrderStore') }}";

        // Pre-fill form fields from localStorage (if coming from homepage enroll form)
        const enrollName = localStorage.getItem('enroll_name');
        const enrollPhone = localStorage.getItem('enroll_phone');
        const enrollEmail = localStorage.getItem('enroll_email');

        if (enrollName) {
            $('input[name="name"]').val(enrollName);
            localStorage.removeItem('enroll_name'); // Clear after use
        }
        if (enrollPhone) {
            $('input[name="mobile"]').val(enrollPhone);
            localStorage.removeItem('enroll_phone');
        }
        if (enrollEmail) {
            $('input[name="email"]').val(enrollEmail);
            localStorage.removeItem('enroll_email');
        }

        $('.pay-card').click(function() {
            $('.pay-card').removeClass('active');
            $(this).addClass('active');
            const val = $(this).find('input').val();
            $(this).find('input').prop('checked', true);
            
            $('#checkoutForm').attr('action', val === 'cod' ? codRoute : onlineRoute);
            updateOnlinePaymentFields(val === 'online');
        });

        function updateOnlinePaymentFields(isOnline) {
            const details = $('#online_payment_details');
            const txnInput = $('#transaction_id');
            details.toggle(isOnline);
            txnInput.prop('required', isOnline);
        }

        // Initialize form action
        const initialVal = $('input[name="payment_method"]:checked').val();
        $('#checkoutForm').attr('action', initialVal === 'cod' ? codRoute : onlineRoute);
        updateOnlinePaymentFields(initialVal === 'online');

        // ---- Dependent Division -> District -> Upazila + Dhaka-based shipping ----
        const SHIP_INSIDE = {{ (float) ($shippingInside ?? 0) }};
        const SHIP_OUTSIDE = {{ (float) ($shippingOutside ?? 0) }};
        const districtsBase = "{{ url('locations/districts') }}";
        const upazilasBase = "{{ url('locations/upazilas') }}";

        function setDeliveryZone(isDhaka) {
            const charge = isDhaka ? SHIP_INSIDE : SHIP_OUTSIDE;
            $('#delivery_area').val(isDhaka ? 'inside' : 'outside');
            $('#summary-delivery').data('charge', charge);
            recalcTotal();
            $('#delivery-zone-text').text((isDhaka ? 'ঢাকার ভিতরে' : 'ঢাকার বাইরে') + ' — ডেলিভারি চার্জ ৳' + charge.toLocaleString());
            $('#delivery-zone-info').show();
        }

        $('#division_id').on('change', function() {
            const divId = $(this).val();
            const $district = $('#district_id'), $upazila = $('#upazila_id');
            $upazila.prop('disabled', true).html('<option value="">আগে জেলা নির্বাচন করুন</option>');
            $('#delivery-zone-info').hide();
            if (!divId) { $district.prop('disabled', true).html('<option value="">আগে বিভাগ নির্বাচন করুন</option>'); return; }
            $district.prop('disabled', true).html('<option value="">লোড হচ্ছে...</option>');
            $.getJSON(districtsBase + '/' + divId, function(data) {
                let opts = '<option value="">জেলা নির্বাচন করুন</option>';
                data.forEach(function(d) { opts += '<option value="' + d.id + '" data-name="' + d.name + '">' + (d.bn_name || d.name) + '</option>'; });
                $district.html(opts).prop('disabled', false);
            });
        });

        $('#district_id').on('change', function() {
            const distId = $(this).val();
            const distName = ($(this).find('option:selected').data('name') || '').toString().toLowerCase();
            const $upazila = $('#upazila_id');
            if (!distId) { $upazila.prop('disabled', true).html('<option value="">আগে জেলা নির্বাচন করুন</option>'); $('#delivery-zone-info').hide(); return; }
            setDeliveryZone(distName === 'dhaka');
            $upazila.prop('disabled', true).html('<option value="">লোড হচ্ছে...</option>');
            $.getJSON(upazilasBase + '/' + distId, function(data) {
                let opts = '<option value="">উপজেলা / থানা নির্বাচন করুন</option>';
                data.forEach(function(u) { opts += '<option value="' + u.id + '">' + (u.bn_name || u.name) + '</option>'; });
                $upazila.html(opts).prop('disabled', false);
            });
        });
    });

    function recalcTotal() {
        const subtotal = parseFloat($('#summary-total').data('subtotal')) || 0;
        const charge = parseFloat($('#summary-delivery').data('charge')) || 0;
        $('#summary-delivery').text('৳' + charge.toLocaleString());
        $('#summary-total').text('৳' + (subtotal + charge).toLocaleString());
    }

    function updateCartQty(cartId, change) {
        let input = $(`#qty-input-${cartId}`);
        let newQty = parseInt(input.val()) + change;
        if (newQty < 1) return;
        
        $.ajax({
            url: "{{ route('cartUpdateQty') }}",
            method: "POST",
            data: { _token: "{{ csrf_token() }}", cart: cartId, new_qty: newQty },
            success: function(res) {
                if(res.status) {
                    input.val(newQty);
                    $('#summary-subtotal').text('৳' + res.cartTotal.toLocaleString());
                    $('#summary-total').text('৳' + (res.cartTotal + res.shippingCharge).toLocaleString());
                    $('.cartCount').text(res.cartCount);
                    location.reload(); 
                }
            }
        });
    }

    function removeCartItem(cartId) {
        Swal.fire({
            title: 'নিশ্চিত?',
            text: "পণ্যটি মুছে ফেলতে চান?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'var(--primary)',
            confirmButtonText: 'হ্যাঁ, মুছুন',
            cancelButtonText: 'না'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/cart/remove/item/${cartId}`,
                    method: "POST",
                    data: { _token: "{{ csrf_token() }}" },
                    success: function(res) {
                        if(res.status) {
                            $(`#cart-row-${cartId}`).fadeOut(300, function() {
                                $(this).remove();
                                if($('.item-row').length == 0) location.reload();
                            });
                            $('#summary-subtotal').text('৳' + res.cartTotal.toLocaleString());
                            $('#summary-total').data('subtotal', res.cartTotal); recalcTotal();
                            $('.cartCount').text(res.cartCount);
                            showCartNotification('পণ্যটি সরানো হয়েছে');
                        }
                    }
                });
            }
        })
    }
</script>
@endpush
