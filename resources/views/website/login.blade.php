@extends('website.layouts.sikhobd')
@section('title', __('frontend.login.page_title') . ' — ' . ($ws->website_title ?? 'SikhoBD'))
@section('content')
<div class="cart-page" style="background: #f8fafc; padding: 100px 0;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="modern-card">
                    <div class="card-header-clean justify-content-center">
                        <i class="fa-solid fa-user-lock"></i>
                        <h2>{{ __('frontend.login.heading') }}</h2>
                    </div>
                    <div class="form-content">
                        @if(session('error'))
                            <div class="alert alert-danger" style="border-radius: 12px; font-size: 14px;">{{ session('error') }}</div>
                        @endif
                        <form action="{{ route('login.post') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="custom-label">{{ __('frontend.login.mobile_email') }}</label>
                                <input type="text" name="email" class="form-control custom-input"
                                    placeholder="{{ __('frontend.login.mobile_email_ph') }}" required>
                            </div>
                            <div class="mb-4">
                                <label class="custom-label">{{ __('frontend.login.password') }}</label>
                                <input type="password" name="password" class="form-control custom-input"
                                    placeholder="{{ __('frontend.login.password_ph') }}" required>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="rememberMe">
                                    <label class="form-check-label text-muted small" for="rememberMe">{{ __('frontend.login.remember_me') }}</label>
                                </div>
                                <a href="#" class="text-muted small">{{ __('frontend.login.forgot_password') }}</a>
                            </div>
                            <button type="submit" class="action-btn">
                                {{ __('frontend.login.login_btn') }} <i class="fa-solid fa-right-to-bracket"></i>
                            </button>
                        </form>

                        <div class="text-center mt-4 pt-3 border-top">
                            <p class="text-muted small mb-0">
                                {{ __('frontend.login.no_account') }}
                                <a href="{{ route('register') }}" class="fw-bold text-primary">{{ __('frontend.login.create_account') }}</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
