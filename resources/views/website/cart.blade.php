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
    .item-row { padding: 15px 20px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; gap: 12px; position: relative; transition: opacity 0.2s; }
    .item-row:last-child { border-bottom: none; }
    .item-row.unchecked { opacity: 0.45; }

    /* Select-all header + custom checkbox */
    .items-head { display: flex; align-items: center; gap: 10px; padding: 12px 20px; border-bottom: 1px solid #f1f5f9; font-size: 12px; font-weight: 700; color: #64748b; }
    .cart-cbx {
        -webkit-appearance: none; -moz-appearance: none; appearance: none;
        width: 20px; height: 20px; min-width: 20px; margin: 0;
        border: 2px solid #cbd5e1; border-radius: 5px; background: #fff;
        cursor: pointer; flex-shrink: 0; position: relative; display: inline-block;
        vertical-align: middle; transition: background 0.15s, border-color 0.15s;
    }
    .cart-cbx:checked { background: var(--primary); border-color: var(--primary); }
    .cart-cbx:checked::after {
        content: ''; position: absolute; left: 6px; top: 2px;
        width: 5px; height: 10px; border: solid #fff; border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }
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
    .col-details-sidebar { flex: 0 0 450px; width: 450px; display: flex; flex-direction: column; }
    /* Reorder sidebar cards: Product list on top, Summary below it, Payment last */
    .col-details-sidebar > .modern-card:nth-child(1) { order: 2; } /* Order Summary */
    .col-details-sidebar > .modern-card:nth-child(2) { order: 1; } /* Product Items */
    .col-details-sidebar > .modern-card:nth-child(3) { order: 3; } /* Payment */

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
        <h1 data-i18n="cart.title" style="font-weight: 900; font-size: 36px; letter-spacing: -1px;">{{ __('frontend.cartpage.title') }}</h1>
        <div class="crumbs justify-content-center mt-2">
            <a href="{{ route('home') }}">{{ __('frontend.nav.home') }}</a> <span class="mx-2 opacity-50">/</span> 
            <span style="color: var(--accent); font-weight: 700;">{{ __('frontend.checkout.secure') }}</span>
        </div>
    </div>
</section>

<div class="cart-page">
    <div class="container">
        @if($cartItems->count() > 0)
        <form action="{{ route('codOrderStore') }}" method="POST" id="checkoutForm">
            @csrf
            <input type="hidden" name="selected_items" id="selectedItems" value="">
            <div class="checkout-layout">
                
                <!-- Left Column (Address Only) -->
                <div class="col-address">
                    <div class="modern-card">
                        <div class="card-header-clean">
                            <i class="fa-solid {{ ($hasCourse || $hasEbook) && !$hasProduct ? 'fa-user-graduate' : 'fa-truck-fast' }}"></i>
                            <h2>১. {{ ($hasCourse || $hasEbook) && !$hasProduct ? __('frontend.cartpage.step1_reg') : ((($hasCourse || $hasEbook) && $hasProduct) ? __('frontend.cartpage.step1_ship_reg') : __('frontend.cartpage.step1_ship')) }}</h2>
                        </div>
                        <div class="form-content">
                            @if(!auth()->check())
                            <div class="alert alert-info mb-4" style="border-radius: 12px; font-size: 14px;">
                                <i class="fa-solid fa-circle-info mr-2"></i> {{ __('frontend.cartpage.have_account') }} <a href="{{ route('login') }}" class="fw-bold">{{ __('frontend.cartpage.login') }}</a>
                            </div>
                            @endif
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="custom-label">{{ __('frontend.cartpage.name') }}</label>
                                    <input type="text" name="name" class="form-control custom-input" value="{{ optional(auth()->user())->name }}" placeholder="{{ __('frontend.cartpage.name_ph') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="custom-label">{{ __('frontend.cartpage.mobile') }}</label>
                                    <input type="text" name="mobile" class="form-control custom-input" value="{{ optional(auth()->user())->mobile }}" placeholder="{{ __('frontend.cartpage.mobile_ph') }}" required>
                                </div>
                                <div class="col-12">
                                    <label class="custom-label">{{ __('frontend.cartpage.email') }}</label>
                                    <input type="email" name="email" class="form-control custom-input" value="{{ optional(auth()->user())->email }}" placeholder="{{ __('frontend.cartpage.email_ph') }}" required>
                                </div>

                                @if($hasCourse || $hasEbook)
                                    <div class="col-md-6">
                                        <label class="custom-label">{{ __('frontend.cartpage.profession') }}</label>
                                        <select name="occupation" class="form-control custom-input" required>
                                            <option value="">{{ __('frontend.cartpage.select') }}</option>
                                            <option value="Student" {{ optional(auth()->user())->occupation == 'Student' ? 'selected' : '' }}>{{ __('frontend.cartpage.prof_student') }}</option>
                                            <option value="Job Holder" {{ optional(auth()->user())->occupation == 'Job Holder' ? 'selected' : '' }}>{{ __('frontend.cartpage.prof_job') }}</option>
                                            <option value="Business" {{ optional(auth()->user())->occupation == 'Business' ? 'selected' : '' }}>{{ __('frontend.cartpage.prof_business') }}</option>
                                            <option value="Other" {{ optional(auth()->user())->occupation == 'Other' ? 'selected' : '' }}>{{ __('frontend.cartpage.prof_other') }}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="custom-label">{{ __('frontend.cartpage.last_study') }}</label>
                                        <select name="last_academic_status" class="form-control custom-input">
                                            <option value="">{{ __('frontend.cartpage.select') }}</option>
                                            <option value="PSC/Ebtedayee">{{ __('frontend.cartpage.study_psc') }}</option>
                                            <option value="JSC/JDC">{{ __('frontend.cartpage.study_jsc') }}</option>
                                            <option value="SSC/Dakhil">{{ __('frontend.cartpage.study_ssc') }}</option>
                                            <option value="HSC/Alim">{{ __('frontend.cartpage.study_hsc') }}</option>
                                            <option value="Bachelors/Honors">{{ __('frontend.cartpage.study_graduate') }}</option>
                                            <option value="Masters">{{ __('frontend.cartpage.study_postgrad') }}</option>
                                            <option value="Diploma">{{ __('frontend.cartpage.study_diploma') }}</option>
                                            <option value="Other">{{ __('frontend.cartpage.study_other') }}</option>
                                        </select>
                                    </div>
                                @endif

                                @if($hasProduct)
                                <div class="col-md-4">
                                    <label class="custom-label">{{ __('frontend.cartpage.division') }}</label>
                                    <select name="division_id" id="division_id" class="form-control custom-input" required>
                                        <option value="">{{ __('frontend.cartpage.division_select') }}</option>
                                        @foreach($divisions as $division)
                                            <option value="{{ $division->id }}" data-name="{{ $division->name }}">{{ $division->bn_name ?? $division->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="custom-label">{{ __('frontend.cartpage.district') }}</label>
                                    <select name="district_id" id="district_id" class="form-control custom-input" required disabled>
                                        <option value="">{{ __('frontend.cartpage.district_first') }}</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="custom-label">{{ __('frontend.cartpage.upazila') }}</label>
                                    <select name="upazila_id" id="upazila_id" class="form-control custom-input" required disabled>
                                        <option value="">{{ __('frontend.cartpage.upazila_first') }}</option>
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
                                    <label class="custom-label">{{ __('frontend.cartpage.address') }}</label>
                                    <textarea name="billing_address" class="form-control custom-input" rows="3" placeholder="{{ __('frontend.cartpage.address_ph') }}" required>{{ auth()->check() && auth()->user()->locations()->first() ? auth()->user()->locations()->first()->address_title : '' }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="custom-label">{{ __('frontend.cartpage.office_address') }}</label>
                                    <input type="text" name="office_address" class="form-control custom-input" placeholder="{{ __('frontend.cartpage.office_address_ph') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="custom-label">{{ __('frontend.cartpage.office_time') }}</label>
                                    <input type="text" name="office_time" class="form-control custom-input" placeholder="{{ __('frontend.cartpage.office_time_ph') }}">
                                </div>
                                @endif

                                <div class="col-12">
                                    <label class="custom-label">{{ __('frontend.cartpage.order_note') }}</label>
                                    <textarea name="order_note" class="form-control custom-input" rows="2" placeholder="{{ __('frontend.cartpage.order_note_ph') }}"></textarea>
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
                            <h2>{{ ($hasCourse || $hasEbook) ? __('frontend.cartpage.summary_reg') : __('frontend.cartpage.summary_order') }}</h2>
                        </div>
                        <div class="summary-box">
                            <div class="summary-line">
                                <span>{{ __('frontend.cartpage.subtotal') }}</span>
                                <span id="summary-subtotal" class="fw-bold text-dark">৳{{ number_format($cartSubtotal) }}</span>
                            </div>
                            <div class="summary-line">
                                <span>{{ __('frontend.cartpage.delivery') }}</span>
                                <span id="summary-delivery" class="fw-bold text-dark" data-charge="{{ $shippingCharge }}">৳{{ number_format($shippingCharge) }}</span>
                            </div>
                            <div class="summary-line grand-total">
                                <span>{{ __('frontend.cartpage.total') }}</span>
                                <span id="summary-total" data-subtotal="{{ $cartSubtotal }}">৳{{ number_format($cartSubtotal + $shippingCharge) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Product Items (Right Middle) - SINGLE ROW OPTIMIZED -->
                    <div class="modern-card">
                        <div class="card-header-clean">
                            <i class="fa-solid fa-box-open"></i>
                            <h2>২. {{ ($hasCourse || $hasEbook) ? __('frontend.cartpage.items_enroll') : __('frontend.cartpage.items_order') }}</h2>
                        </div>
                        <div class="items-head">
                            <input type="checkbox" id="selectAllItems" class="cart-cbx" checked>
                            <span>{{ ($hasCourse || $hasEbook) ? __('frontend.cartpage.select_all') : __('frontend.cartpage.select_all') }}</span>
                        </div>
                        <div class="items-list">
                            @foreach($cartItems as $item)
                            @php $rowPrice = $item->ebook_id ? $item->ebook->final_price : ($item->quantity * $item->product->final_price); @endphp
                            <div class="item-row" id="cart-row-{{ $item->id }}" data-id="{{ $item->id }}" data-price="{{ $rowPrice }}">
                                <input type="checkbox" class="item-check cart-cbx" data-id="{{ $item->id }}" checked>
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
                            <h2>৩. {{ __('frontend.cartpage.payment_method') }} {{ ($hasCourse || $hasEbook) ? __('frontend.cartpage.payment_reg') : __('frontend.cartpage.payment_order') }}</h2>
                        </div>
                        <div class="form-content" style="padding-top: 20px;">
                            <label class="pay-card active">
                                <input type="radio" name="payment_method" value="cod" checked>
                                <div>
                                    <div class="fw-bold text-dark" style="font-size: 14px;">{{ __('frontend.cartpage.cod') }}</div>
                                    <div class="text-muted small">{{ __('frontend.cartpage.cod_desc') }}</div>
                                </div>
                            </label>
                            <label class="pay-card">
                                <input type="radio" name="payment_method" value="online">
                                <div>
                                    <div class="fw-bold text-dark" style="font-size: 14px;">{{ __('frontend.cartpage.online') }}</div>
                                    <div class="text-muted small">{{ __('frontend.cartpage.online_desc') }}</div>
                                </div>
                            </label>

                            <div id="online_payment_details" class="mt-3 mb-3" style="display: none;">
                                <div class="alert alert-light" style="border-radius: 16px; padding: 16px; border: 1px solid #e2e8f0;">
                                    <p class="mb-2 fw-bold">{{ __('frontend.cartpage.online_instruction') }}</p>
                                    <p class="mb-1">{{ __('frontend.cartpage.pay_send') }} <strong>01349494295</strong> (bKash / Nagad / Rocket).</p>
                                    <label class="custom-label">{{ __('frontend.cartpage.txn') }}</label>
                                    <input type="text" name="transaction_id" id="transaction_id" class="form-control custom-input" placeholder="{{ __('frontend.cartpage.txn_ph') }}">
                                </div>
                            </div>

                            <div class="form-check mt-3 mb-3">
                                <input class="form-check-input" type="checkbox" id="termsCheck" required checked>
                                <label class="form-check-label text-muted small" for="termsCheck">{{ __('frontend.cartpage.terms') }}</label>
                            </div>

                            <button type="submit" class="action-btn">
                                {{ auth()->check() ? __('frontend.cartpage.submit_order') : __('frontend.cartpage.submit_reg') }} <i class="fa-solid fa-check-circle"></i>
                            </button>
                        </div>
                    </div>

                </div>

            </div>
        </form>
        @else
        <div class="text-center py-5" style="background:#fff; border-radius: 30px; border: 1px solid #e2e8f0;">
            <img src="https://cdn-icons-png.flaticon.com/512/1170/1170577.png" alt="" style="width: 100px; opacity: 0.2; margin-bottom: 20px;">
            <h2 style="font-weight: 900; color: #1e293b;">{{ __('frontend.cartpage.empty') }}</h2>
            <p class="text-muted mb-4">{{ __('frontend.cartpage.empty_desc') }}</p>
            <a href="{{ route('shop') }}" class="btn btn-primary" style="padding: 15px 40px; border-radius: 16px; font-weight: 800;">{{ __('frontend.cartpage.start_shopping') }}</a>
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
            $('#delivery-zone-text').text((isDhaka ? '{{ __('frontend.cartpage.inside_dhaka') }}' : '{{ __('frontend.cartpage.outside_dhaka') }}') + ' — {{ __('frontend.cartpage.delivery_charge') }}' + charge.toLocaleString());
            $('#delivery-zone-info').show();
        }

        $('#division_id').on('change', function() {
            const divId = $(this).val();
            const $district = $('#district_id'), $upazila = $('#upazila_id');
            $upazila.prop('disabled', true).html('<option value="">{{ __('frontend.cartpage.upazila_first') }}</option>');
            $('#delivery-zone-info').hide();
            if (!divId) { $district.prop('disabled', true).html('<option value="">{{ __('frontend.cartpage.district_first') }}</option>'); return; }
            $district.prop('disabled', true).html('<option value="">{{ __('frontend.cartpage.loading') }}</option>');
            $.getJSON(districtsBase + '/' + divId, function(data) {
                let opts = '<option value="">{{ __('frontend.cartpage.district_select') }}</option>';
                data.forEach(function(d) { opts += '<option value="' + d.id + '" data-name="' + d.name + '">' + (d.bn_name || d.name) + '</option>'; });
                $district.html(opts).prop('disabled', false);
            });
        });

        $('#district_id').on('change', function() {
            const distId = $(this).val();
            const distName = ($(this).find('option:selected').data('name') || '').toString().toLowerCase();
            const $upazila = $('#upazila_id');
            if (!distId) { $upazila.prop('disabled', true).html('<option value="">{{ __('frontend.cartpage.upazila_first') }}</option>'); $('#delivery-zone-info').hide(); return; }
            setDeliveryZone(distName === 'dhaka');
            $upazila.prop('disabled', true).html('<option value="">{{ __('frontend.cartpage.loading') }}</option>');
            $.getJSON(upazilasBase + '/' + distId, function(data) {
                let opts = '<option value="">{{ __('frontend.cartpage.upazila_select') }}</option>';
                data.forEach(function(u) { opts += '<option value="' + u.id + '">' + (u.bn_name || u.name) + '</option>'; });
                $upazila.html(opts).prop('disabled', false);
            });
        });

        // ── Item selection checkboxes ──
        $(document).on('change', '.item-check', function() {
            recalcTotal();
            const total = $('.item-check').length;
            const checked = $('.item-check:checked').length;
            $('#selectAllItems').prop('checked', total === checked);
        });

        $('#selectAllItems').on('change', function() {
            $('.item-check').prop('checked', this.checked);
            recalcTotal();
        });

        // Block submit if nothing selected
        $('#checkoutForm').on('submit', function(e) {
            if (recalcTotal() === 0) {
                e.preventDefault();
                Swal.fire({ icon: 'warning', title: '{{ __('frontend.cartpage.select_item') }}', confirmButtonColor: 'var(--primary)' });
                return false;
            }
        });

        // Initial calculation
        recalcTotal();
    });

    function recalcTotal() {
        let subtotal = 0, checkedCount = 0;
        $('.item-check').each(function() {
            const row = document.getElementById('cart-row-' + $(this).data('id'));
            if (!row) return;
            if (this.checked) {
                subtotal += parseFloat(row.getAttribute('data-price')) || 0;
                checkedCount++;
                row.classList.remove('unchecked');
            } else {
                row.classList.add('unchecked');
            }
        });
        const charge = parseFloat($('#summary-delivery').data('charge')) || 0;
        $('#summary-subtotal').text('৳' + subtotal.toLocaleString());
        $('#summary-delivery').text('৳' + charge.toLocaleString());
        $('#summary-total').data('subtotal', subtotal).text('৳' + (subtotal + charge).toLocaleString());

        // Collect selected cart ids for submission
        const ids = [];
        $('.item-check:checked').each(function(){ ids.push($(this).data('id')); });
        $('#selectedItems').val(ids.join(','));

        // Disable order button when nothing is selected
        const $btn = $('.action-btn');
        $btn.prop('disabled', checkedCount === 0)
            .css({ opacity: checkedCount === 0 ? 0.5 : 1, cursor: checkedCount === 0 ? 'not-allowed' : 'pointer' });
        return checkedCount;
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
            title: '{{ __('frontend.cartpage.confirm') }}',
            text: "{{ __('frontend.cartpage.confirm_remove') }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'var(--primary)',
            confirmButtonText: '{{ __('frontend.cartpage.yes_remove') }}',
            cancelButtonText: '{{ __('frontend.cartpage.no') }}'
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
                                if($('.item-row').length == 0) { location.reload(); return; }
                                recalcTotal();
                            });
                            $('.cartCount').text(res.cartCount);
                            showCartNotification('{{ __('frontend.cartpage.removed') }}');
                        }
                    }
                });
            }
        })
    }
</script>
@endpush
