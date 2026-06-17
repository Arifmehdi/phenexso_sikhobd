@extends('website.layouts.sikhobd')
@section('title', 'লগইন — ' . ($ws->website_title ?? 'SikhoBD'))
@section('content')
<div class="cart-page" style="background: #f8fafc; padding: 100px 0;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="modern-card">
                    <div class="card-header-clean justify-content-center">
                        <i class="fa-solid fa-user-lock"></i>
                        <h2>অ্যাকাউন্টে লগইন করুন</h2>
                    </div>
                    <div class="form-content">
                        @if(session('error'))
                            <div class="alert alert-danger" style="border-radius: 12px; font-size: 14px;">{{ session('error') }}</div>
                        @endif
                        <form action="{{ route('login.post') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="custom-label">মোবাইল অথবা ইমেইল *</label>
                                <input type="text" name="email" class="form-control custom-input" placeholder="আপনার মোবাইল অথবা ইমেইল লিখুন" required>
                            </div>
                            <div class="mb-4">
                                <label class="custom-label">পাসওয়ার্ড *</label>
                                <input type="password" name="password" class="form-control custom-input" placeholder="পাসওয়ার্ড লিখুন" required>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="rememberMe">
                                    <label class="form-check-label text-muted small" for="rememberMe">মনে রাখুন</label>
                                </div>
                                <a href="#" class="text-muted small">পাসওয়ার্ড ভুলে গেছেন?</a>
                            </div>
                            <button type="submit" class="action-btn">
                                লগইন করুন <i class="fa-solid fa-right-to-bracket"></i>
                            </button>
                        </form>
                        
                        <div class="text-center mt-4 pt-3 border-top">
                            <p class="text-muted small mb-0">অ্যাকাউন্ট নেই? <a href="{{ route('register') }}" class="fw-bold text-primary">নতুন অ্যাকাউন্ট তৈরি করুন</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
