@extends('website.layouts.sikhobd')

@section('title', 'কোর্স রেজিস্ট্রেশন — ' . ($ws->name ?? env('APP_NAME')))

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
        <h1 style="font-weight: 900; font-size: 36px; letter-spacing: -1px;">{{ __('frontend.enroll.title') }}</h1>
        <div class="crumbs justify-content-center mt-2">
            <a href="{{ route('home') }}">Home</a> <span class="mx-2 opacity-50">/</span> 
            <span style="color: var(--accent); font-weight: 700;">Registration</span>
        </div>
    </div>
</section>

<div class="cart-page">
    <div class="container">
        @if($cartItems->count() > 0)
        <form action="{{ route('courseOrderStore') }}" method="POST" id="checkoutForm">
            @csrf
            <div class="checkout-layout">
                
                <div class="col-address">
                    <div class="modern-card">
                        <div class="card-header-clean">
                            <i class="fa-solid fa-user-graduate"></i>
                            <h2>{{ __('frontend.enroll.step_reg') }}</h2>
                        </div>
                        <div class="form-content">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="custom-label">{{ app()->getLocale() == 'bn' ? 'পুরো নাম *' : 'Full Name *' }}</label>
                                    <input type="text" name="name" class="form-control custom-input" value="{{ optional(auth()->user())->name }}" placeholder="{{ app()->getLocale() == 'bn' ? 'আপনার নাম লিখুন' : 'Enter your name' }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="custom-label">{{ app()->getLocale() == 'bn' ? 'মোবাইল নম্বর *' : 'Mobile Number *' }}</label>
                                    <input type="text" name="mobile" class="form-control custom-input" value="{{ optional(auth()->user())->mobile }}" placeholder="{{ app()->getLocale() == 'bn' ? 'মোবাইল নম্বর' : 'Mobile number' }}" required>
                                </div>
                                <div class="col-12">
                                    <label class="custom-label">{{ app()->getLocale() == 'bn' ? 'ইমেইল ঠিকানা (ঐচ্ছিক)' : 'Email Address (Optional)' }}</label>
                                    <input type="email" name="email" class="form-control custom-input" value="{{ optional(auth()->user())->email }}" placeholder="{{ app()->getLocale() == 'bn' ? 'আপনার ইমেইল' : 'Your email' }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="custom-label">{{ __('frontend.enroll.profession') }}</label>
                                    <select name="occupation" class="form-control custom-input" required>
                                        <option value="">{{ __('frontend.enroll.select') }}</option>
                                        <option value="Student">{{ __('frontend.enroll.prof_student') }}</option>
                                        <option value="Job Holder">{{ __('frontend.enroll.prof_job') }}</option>
                                        <option value="Business">ব্যবসায়ী (Business)</option>
                                        <option value="Other">{{ __('frontend.enroll.prof_other') }}</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="custom-label">সর্বশেষ পড়াশোনা (Last Study) *</label>
                                    <select name="last_academic_status" class="form-control custom-input" required>
                                        <option value="">{{ __('frontend.enroll.select') }}</option>
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

                                <div class="col-12">
                                    <label class="custom-label">{{ __('frontend.enroll.order_note') }}</label>
                                    <textarea name="order_note" class="form-control custom-input" rows="2" placeholder="এনরোলমেন্ট সম্পর্কে বিশেষ কোনো তথ্য থাকলে দিন"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-details-sidebar">
                    <div class="modern-card">
                        <div class="card-header-clean">
                            <i class="fa-solid fa-receipt"></i>
                            <h2>{{ __('frontend.enroll.reg_summary') }}</h2>
                        </div>
                        <div class="summary-box">
                            <div class="summary-line">
                                <span>{{ __('frontend.enroll.course_fee') }}</span>
                                <span id="summary-subtotal" class="fw-bold text-dark">৳{{ number_format($cartSubtotal) }}</span>
                            </div>
                            <div class="summary-line grand-total">
                                <span>{{ __('frontend.enroll.grand_total') }}</span>
                                <span id="summary-total">৳{{ number_format($cartSubtotal) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="modern-card">
                        <div class="card-header-clean">
                            <i class="fa-solid fa-box-open"></i>
                            <h2>{{ __('frontend.enroll.step_courses') }}</h2>
                        </div>
                        <div class="items-list">
                            @foreach($cartItems as $item)
                            <div class="item-row" id="cart-row-{{ $item->id }}">
                                <img src="{{ route('imagecache', ['template' => 'pnism', 'filename' => $item->product->fi()]) }}" class="item-img" alt="">
                                <div class="item-info">
                                    <a href="{{ route('productDetails', $item->product->slug) }}" class="item-name">{{ Str::limit($item->product->name_en, 40) }}</a>
                                    
                                    <div class="qty-ctrl" style="display: none;"> {{-- Quantity usually 1 for courses --}}
                                        <button type="button" class="qty-btn" onclick="updateCartQty({{ $item->id }}, -1)">-</button>
                                        <input type="text" id="qty-input-{{ $item->id }}" class="qty-val" value="{{ $item->quantity }}" readonly>
                                        <button type="button" class="qty-btn" onclick="updateCartQty({{ $item->id }}, 1)">+</button>
                                    </div>
                                    
                                    <div class="item-price-val" id="item-subtotal-{{ $item->id }}">৳{{ number_format($item->quantity * $item->product->final_price) }}</div>
                                    
                                    <i class="fa-solid fa-xmark remove-x" onclick="removeCartItem({{ $item->id }})"></i>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="modern-card">
                        <div class="card-header-clean">
                            <i class="fa-solid fa-wallet"></i>
                            <h2>{{ __('frontend.enroll.step_payment') }}</h2>
                        </div>
                        <div class="form-content" style="padding-top: 20px;">
                            <label class="pay-card active">
                                <input type="radio" name="payment_method" value="cod" checked>
                                <div>
                                    <div class="fw-bold text-dark" style="font-size: 14px;">Cash on Registration</div>
                                    <div class="text-muted small">{{ __('frontend.enroll.pay_later') }}</div>
                                </div>
                            </label>
                            <label class="pay-card">
                                <input type="radio" name="payment_method" value="online">
                                <div>
                                    <div class="fw-bold text-dark" style="font-size: 14px;">Online Payment</div>
                                    <div class="text-muted small">বিকাশ, নগদ বা কার্ড পেমেন্ট</div>
                                </div>
                            </label>

                            <div class="form-check mt-3 mb-3">
                                <input class="form-check-input" type="checkbox" id="termsCheck" required checked>
                                <label class="form-check-label text-muted small" for="termsCheck">সাইটের শর্তাবলী মেনে নিচ্ছি</label>
                            </div>

                            <button type="submit" class="action-btn">
                                রেজিস্ট্রেশন সম্পন্ন করুন <i class="fa-solid fa-check-circle"></i>
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
            <p class="text-muted mb-4">আমাদের কোর্সসমূহ থেকে আপনার পছন্দের কোর্স যোগ করুন</p>
            <a href="{{ route('courses') }}" class="btn btn-primary" style="padding: 15px 40px; border-radius: 16px; font-weight: 800;">কোর্স দেখুন</a>
        </div>
        @endif
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        const codRoute = "{{ route('courseOrderStore') }}";
        const onlineRoute = "{{ route('onlineOrderStore') }}";

        $('.pay-card').click(function() {
            $('.pay-card').removeClass('active');
            $(this).addClass('active');
            const val = $(this).find('input').val();
            $(this).find('input').prop('checked', true);
            $('#checkoutForm').attr('action', val === 'cod' ? codRoute : onlineRoute);
        });

        const initialVal = $('input[name="payment_method"]:checked').val();
        $('#checkoutForm').attr('action', initialVal === 'cod' ? codRoute : onlineRoute);
    });

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
                    location.reload(); 
                }
            }
        });
    }

    function removeCartItem(cartId) {
        Swal.fire({
            title: 'নিশ্চিত?',
            text: "কোর্সটি মুছে ফেলতে চান?",
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
                            location.reload();
                        }
                    }
                });
            }
        })
    }
</script>
@endpush

