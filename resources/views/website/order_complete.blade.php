@extends('website.layouts.sikhobd')

@section('title', 'অর্ডার সম্পন্ন — ' . ($ws->name ?? env('APP_NAME')))

@section('content')
<section class="section" style="padding: 100px 0; text-align: center;">
    <div class="container">
        <div style="max-width: 600px; margin: 0 auto; background: #fff; padding: 50px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
            <div style="width: 80px; height: 80px; background: #10b981; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 30px; font-size: 40px;">
                <i class="fa-solid fa-check"></i>
            </div>
            <h1 style="font-size: 32px; color: var(--text-main); margin-bottom: 16px;">ধন্যবাদ! আপনার অর্ডারটি সফলভাবে সম্পন্ন হয়েছে।</h1>
            <p style="color: #666; font-size: 18px; margin-bottom: 40px;">অল্প কিছুক্ষণের মধ্যে আমাদের একজন প্রতিনিধি আপনার সাথে যোগাযোগ করবেন।</p>
            
            <div style="display: flex; gap: 16px; justify-content: center;">
                <a href="{{ route('shop') }}" class="btn btn-primary" style="padding: 12px 30px;">Continue Shopping</a>
                <a href="{{ route('user.dashboard') }}" class="btn btn-outline" style="padding: 12px 30px;">Go to Dashboard</a>
            </div>
        </div>
    </div>
</section>
@endsection
