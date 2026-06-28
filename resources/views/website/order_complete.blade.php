@extends('website.layouts.sikhobd')

@section('title', __('frontend.order.complete_title') . ' — ' . ($ws->name ?? env('APP_NAME')))

@section('content')
<section class="section" style="padding: 80px 0; background: #f8fafc;">
    <div class="container">
        <div style="max-width: 800px; margin: 0 auto;">
            
            <!-- Success Card -->
            <div style="background: #fff; padding: 40px; border-radius: 24px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); text-align: center; margin-bottom: 30px; border: 1px solid #e2e8f0;">
                <div style="width: 70px; height: 70px; background: #10b981; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px; font-size: 32px;">
                    <i class="fa-solid fa-check"></i>
                </div>

                @php
                    $isNewUser = session('is_new_user', false);
                    $tempPassword = session('temp_password');
                    $tempEmail = session('temp_email');
                    $isBn = app()->getLocale() == 'bn';
                    $hasCourses = $order && ($order->has_course || $order->orderItems->contains(fn($item) => $item->product && $item->product->type === 'course'));
                    $hasProducts = $order && $order->orderItems->contains(fn($item) => $item->product && $item->product->type !== 'course');
                @endphp

                <h1 style="font-size: 28px; font-weight: 800; color: #1e293b; margin-bottom: 12px;">
                    {{ $isNewUser ? __('frontend.order.welcome_new') : __('frontend.order.welcome_back') }}
                </h1>

                <p style="color: #64748b; font-size: 16px; line-height: 1.6; max-width: 600px; margin: 0 auto 20px;">
                    {{ $isNewUser ? __('frontend.order.account_created') : __('frontend.order.existing_account') }}
                </p>

                @if($isNewUser && $tempPassword)
                <div style="background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 14px; padding: 20px 28px; max-width: 420px; margin: 0 auto 28px; text-align: left;">
                    <p style="margin: 0 0 12px; font-size: 12px; font-weight: 700; color: #0369a1; text-transform: uppercase; letter-spacing: 0.5px;">
                        {{ __('frontend.order.login_info') }}
                    </p>
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span style="min-width: 90px; color: #64748b; font-size: 14px; font-weight: 600;">{{ __('frontend.order.login_email') }}</span>
                            <code style="background:#fff; border:1px solid #e0f2fe; border-radius:6px; padding:4px 12px; font-size:15px; color:#0c4a6e; font-weight:700;">{{ $tempEmail }}</code>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span style="min-width: 90px; color: #64748b; font-size: 14px; font-weight: 600;">{{ __('frontend.order.login_password') }}</span>
                            <code style="background:#fff; border:1px solid #e0f2fe; border-radius:6px; padding:4px 12px; font-size:15px; color:#0c4a6e; font-weight:700;">{{ $tempPassword }}</code>
                        </div>
                    </div>
                    <p style="margin: 12px 0 0; font-size: 12px; color: #0369a1;">
                        <i class="fa-solid fa-circle-info mr-1"></i>
                        {{ __('frontend.order.change_password') }}
                    </p>
                </div>
                @endif

                @if($hasCourses)
                <div style="background: #f0fdf4; border: 1px dashed #22c55e; padding: 15px; border-radius: 12px; margin-bottom: 30px;">
                    <p style="margin: 0; color: #166534; font-weight: 600; font-size: 14px;">
                        <i class="fa-solid fa-circle-info mr-2"></i>
                        {{ __('frontend.order.course_pending') }}
                    </p>
                </div>
                @endif

                <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
                    <a href="{{ route('user.dashboard') }}" class="btn btn-primary" style="padding: 12px 25px; border-radius: 12px; font-weight: 700;">
                        {{ __('frontend.order.go_dashboard') }} <i class="fa-solid fa-arrow-right ml-2"></i>
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary" style="padding: 12px 25px; border-radius: 12px; font-weight: 700;">
                        {{ __('frontend.order.go_home') }}
                    </a>
                </div>
            </div>

            <!-- Enrollment Summary (Invoice-like) -->
            @if($order)
            <div style="background: #fff; padding: 30px; border-radius: 24px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); border: 1px solid #e2e8f0;">
                <h3 style="font-size: 18px; font-weight: 800; color: #1e293b; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-file-invoice" style="color: var(--primary);"></i>
                    {{ $hasCourses ? __('frontend.order.enrollment_invoice') : __('frontend.order.invoice') }}: #{{ $order->id }}
                </h3>

                <div style="border-bottom: 1px solid #f1f5f9; padding-bottom: 15px; margin-bottom: 15px; display: flex; justify-content: space-between; font-size: 14px;">
                    <div>
                        <span style="color: #94a3b8; display: block; font-weight: 600; text-transform: uppercase; font-size: 11px;">{{ __("frontend.order.date") }}</span>
                        <strong style="color: #334155;">{{ $order->created_at->format('d M, Y') }}</strong>
                    </div>
                    <div style="text-align: right;">
                        <span style="color: #94a3b8; display: block; font-weight: 600; text-transform: uppercase; font-size: 11px;">{{ __("frontend.order.payment_status") }}</span>
                        <span style="background: #fef3c7; color: #92400e; padding: 2px 10px; border-radius: 20px; font-weight: 700; font-size: 12px;">
                            {{ strtoupper($order->payment_status) }}
                        </span>
                    </div>
                </div>

                <div style="margin-bottom: 20px;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="text-align: left; border-bottom: 2px solid #f1f5f9;">
                                <th style="padding: 10px 0; color: #64748b; font-size: 13px;">{{ $hasCourses ? __('frontend.order.course_name') : __('frontend.order.product_name') }}</th>
                                <th style="padding: 10px 0; color: #64748b; font-size: 13px; text-align: right;">{{ __("frontend.order.price") }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td style="padding: 15px 0;">
                                    <strong style="color: #334155; font-size: 15px;">{{ $item->product_name }}</strong>
                                </td>
                                <td style="padding: 15px 0; text-align: right;">
                                    <strong style="color: #1e293b;">৳{{ number_format($item->product_price) }}</strong>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td style="padding: 20px 0 5px; color: #64748b; font-weight: 600;">{{ __("frontend.order.subtotal") }}</td>
                                <td style="padding: 20px 0 5px; text-align: right; color: #334155; font-weight: 700;">৳{{ number_format($order->subtotal) }}</td>
                            </tr>
                            @if($order->delivery_cost > 0)
                            <tr>
                                <td style="padding: 5px 0; color: #64748b; font-weight: 600;">{{ __("frontend.order.delivery") }}</td>
                                <td style="padding: 5px 0; text-align: right; color: #334155; font-weight: 700;">৳{{ number_format($order->delivery_cost) }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td style="padding: 10px 0; font-size: 18px; font-weight: 900; color: #1e293b;">{{ __("frontend.order.grand_total") }}</td>
                                <td style="padding: 10px 0; text-align: right; font-size: 20px; font-weight: 900; color: var(--primary);">৳{{ number_format($order->grand_total) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div style="background: #f8fafc; padding: 20px; border-radius: 12px; font-size: 14px;">
                    <div style="display: flex; gap: 20px;">
                        <div style="flex: 1;">
                            <span style="color: #94a3b8; display: block; font-weight: 600; text-transform: uppercase; font-size: 11px; margin-bottom: 5px;">{{ $hasCourses ? __('frontend.order.student_info') : __('frontend.order.customer_info') }}</span>
                            <strong style="color: #334155;">{{ $order->name }}</strong><br>
                            <span style="color: #64748b;">{{ $order->mobile }}</span><br>
                            <span style="color: #64748b;">{{ $order->email }}</span>
                        </div>
                        <div style="flex: 1;">
                            <span style="color: #94a3b8; display: block; font-weight: 600; text-transform: uppercase; font-size: 11px; margin-bottom: 5px;">{{ __("frontend.order.payment_method") }}</span>
                            <strong style="color: #334155; text-transform: uppercase;">{{ $order->payment_method }}</strong>
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</section>
@endsection

