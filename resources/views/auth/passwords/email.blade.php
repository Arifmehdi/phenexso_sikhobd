<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password | {{ env('APP_NAME') }}</title>
    <link href="{{ asset('frontend/login/assets') }}/backend/dist/img/favicon.ico" rel="icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">
    <link rel="stylesheet" href="{{ asset('frontend/login/assets') }}/backend/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('frontend/login/assets') }}/backend/dist/css/adminlte.min.css">
    <script src="{{ asset('frontend/login/assets') }}/backend/plugins/jquery/jquery.min.js"></script>
</head>
<body class="hold-transition">
    <div class="login-page">
        <div class="login-box">
            <div class="card card-outline card-primary shadow-lg" style="border-radius: 1rem;">
                <div class="card-body">
                    <h3 class="login-box-msg" style="font-weight:700;">Forgot Password?</h3>
                    <p class="text-muted text-center">Enter your email or mobile number and we'll send a reset link to your email.</p>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('password.email.send') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="email">Email or Mobile</label>
                            <input type="text" class="form-control" name="email" id="email"
                                   value="{{ old('email') }}" placeholder="Enter your registered email or mobile"
                                   required autofocus style="border-radius:0.25rem;">
                        </div>

                        <button type="submit" class="btn btn-primary btn-block mb-3" style="border-radius:0.25rem;">
                            <i class="fas fa-paper-plane mr-1"></i> Send Reset Link
                        </button>

                        <div class="text-center mt-3">
                            <a href="{{ route('login') }}"><i class="fas fa-arrow-left mr-1"></i> Back to Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('frontend/login/assets') }}/backend/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
