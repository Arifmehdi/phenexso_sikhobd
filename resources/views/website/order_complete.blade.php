@extends('website.layouts.sikhobd')

@section('title', 'রেজিস্ট্রেশন সম্পন্ন — ' . ($ws->name ?? env('APP_NAME')))

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
                    $hasCourses = $order && ($order->has_course || $order->orderItems->contains(fn($item) => $item->product && $item->product->type === 'course'));
                @endphp

                <h1 style="font-size: 28px; font-weight: 800; color: #1e293b; margin-bottom: 12px;">
                    @if($isNewUser)
                        স্বাগতম! আপনার রেজিস্ট্রেশন সফলভাবে সম্পন্ন হয়েছে
                    @else
                        ওয়েলকাম ব্যাক! আপনার এনরোলমেন্ট সম্পন্ন হয়েছে
                    @endif
                </h1>

                <p style="color: #64748b; font-size: 16px; line-height: 1.6; max-width: 600px; margin: 0 auto 30px;">
                    @if($isNewUser)
                        @if(app()->getLocale() == 'bn')
                            আপনার নিবন্ধন সফলভাবে সম্পন্ন হয়েছে। কোর্সে প্রবেশের জন্য আপনার লগইন তথ্য প্রস্তুত করা হয়েছে। নিচে আপনার অস্থায়ী পাসওয়ার্ড প্রদান করা হলো। নিরাপত্তার স্বার্থে প্রথম লগইনের পর পাসওয়ার্ড পরিবর্তন করার পরামর্শ দেওয়া হচ্ছে।
                            <br>
                            <strong style="color: var(--primary); font-size: 18px; display: block; margin-top: 10px;">
                                পাসওয়ার্ড: {{ $tempPassword }}
                            </strong>
                        @else
                            Your registration has been completed successfully. Your login credentials have been prepared for course access. Please find your temporary password below. For security reasons, we recommend changing your password after your first login.
                            <br>
                            <strong style="color: var(--primary); font-size: 18px; display: block; margin-top: 10px;">
                                Password: {{ $tempPassword }}
                            </strong>
                        @endif
                    @else
                        @if(app()->getLocale() == 'bn')
                            এই ইমেইল ঠিকানার মাধ্যমে পূর্বে একটি অ্যাকাউন্ট নিবন্ধিত হয়েছে। আপনার বিদ্যমান লগইন তথ্য ব্যবহার করে কোর্সে প্রবেশ করতে পারবেন। পাসওয়ার্ড ভুলে গেলে "পাসওয়ার্ড পুনরুদ্ধার" অপশন ব্যবহার করুন।
                        @else
                            An account is already registered with this email address. You may access the course using your existing login credentials. If you have forgotten your password, please use the password recovery option.
                        @endif
                    @endif
                </p>

                <div style="background: #f0fdf4; border: 1px dashed #22c55e; padding: 15px; border-radius: 12px; margin-bottom: 30px;">
                    <p style="margin: 0; color: #166534; font-weight: 600; font-size: 14px;">
                        <i class="fa-solid fa-circle-info mr-2"></i>
                        আপনার এনরোলমেন্ট বর্তমানে এডমিন অনুমোদনের অপেক্ষায় আছে। পেমেন্ট ভেরিফাই হওয়ার পর আপনি কোর্সটি এক্সেস করতে পারবেন।
                    </p>
                </div>

                <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
                    <a href="{{ route('user.dashboard') }}" class="btn btn-primary" style="padding: 12px 25px; border-radius: 12px; font-weight: 700;">
                        ড্যাশবোর্ড দেখুন <i class="fa-solid fa-arrow-right ml-2"></i>
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary" style="padding: 12px 25px; border-radius: 12px; font-weight: 700;">
                        হোমে ফিরে যান
                    </a>
                </div>
            </div>

            <!-- Enrollment Summary (Invoice-like) -->
            @if($order)
            <div style="background: #fff; padding: 30px; border-radius: 24px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); border: 1px solid #e2e8f0;">
                <h3 style="font-size: 18px; font-weight: 800; color: #1e293b; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-file-invoice" style="color: var(--primary);"></i>
                    এনরোলমেন্ট ইনভয়েস: #{{ $order->id }}
                </h3>

                <div style="border-bottom: 1px solid #f1f5f9; padding-bottom: 15px; margin-bottom: 15px; display: flex; justify-content: space-between; font-size: 14px;">
                    <div>
                        <span style="color: #94a3b8; display: block; font-weight: 600; text-transform: uppercase; font-size: 11px;">তারিখ</span>
                        <strong style="color: #334155;">{{ $order->created_at->format('d M, Y') }}</strong>
                    </div>
                    <div style="text-align: right;">
                        <span style="color: #94a3b8; display: block; font-weight: 600; text-transform: uppercase; font-size: 11px;">পেমেন্ট স্ট্যাটাস</span>
                        <span style="background: #fef3c7; color: #92400e; padding: 2px 10px; border-radius: 20px; font-weight: 700; font-size: 12px;">
                            {{ strtoupper($order->payment_status) }}
                        </span>
                    </div>
                </div>

                <div style="margin-bottom: 20px;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="text-align: left; border-bottom: 2px solid #f1f5f9;">
                                <th style="padding: 10px 0; color: #64748b; font-size: 13px;">কোর্সের নাম</th>
                                <th style="padding: 10px 0; color: #64748b; font-size: 13px; text-align: right;">মূল্য</th>
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
                                <td style="padding: 20px 0 5px; color: #64748b; font-weight: 600;">সাবটোটাল</td>
                                <td style="padding: 20px 0 5px; text-align: right; color: #334155; font-weight: 700;">৳{{ number_format($order->subtotal) }}</td>
                            </tr>
                            @if($order->delivery_cost > 0)
                            <tr>
                                <td style="padding: 5px 0; color: #64748b; font-weight: 600;">ডেলিভারি চার্জ</td>
                                <td style="padding: 5px 0; text-align: right; color: #334155; font-weight: 700;">৳{{ number_format($order->delivery_cost) }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td style="padding: 10px 0; font-size: 18px; font-weight: 900; color: #1e293b;">সর্বমোট</td>
                                <td style="padding: 10px 0; text-align: right; font-size: 20px; font-weight: 900; color: var(--primary);">৳{{ number_format($order->grand_total) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div style="background: #f8fafc; padding: 20px; border-radius: 12px; font-size: 14px;">
                    <div style="display: flex; gap: 20px;">
                        <div style="flex: 1;">
                            <span style="color: #94a3b8; display: block; font-weight: 600; text-transform: uppercase; font-size: 11px; margin-bottom: 5px;">প্রশিক্ষক তথ্য</span>
                            <strong style="color: #334155;">{{ $order->name }}</strong><br>
                            <span style="color: #64748b;">{{ $order->mobile }}</span><br>
                            <span style="color: #64748b;">{{ $order->email }}</span>
                        </div>
                        <div style="flex: 1;">
                            <span style="color: #94a3b8; display: block; font-weight: 600; text-transform: uppercase; font-size: 11px; margin-bottom: 5px;">পেমেন্ট মেথড</span>
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
