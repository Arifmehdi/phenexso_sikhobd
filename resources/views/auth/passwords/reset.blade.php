<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password | {{ env('APP_NAME') }}</title>
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
                    <h3 class="login-box-msg" style="font-weight:700;">Reset Password</h3>
                    <p class="text-muted text-center">Choose a new password for your account.</p>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('password.update.web') }}" method="POST">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email"
                                   value="{{ old('email', $email) }}" placeholder="Your email"
                                   required readonly style="border-radius:0.25rem; background:#f8f9fa;">
                        </div>

                        <div class="form-group mb-3">
                            <label for="password">New Password</label>
                            <div class="position-relative">
                                <input type="password" name="password" id="password" class="form-control"
                                       placeholder="Enter new password (min 6 chars)" required style="border-radius:0.25rem;">
                                <i class="fas fa-eye position-absolute" id="passwordIcon"
                                   style="right: 10px; top: 50%; transform: translateY(-50%); cursor:pointer; color:#6c757d;"
                                   onclick="togglePassword('password', 'passwordIcon')"></i>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="password_confirmation">Confirm New Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   class="form-control" placeholder="Re-enter new password"
                                   required style="border-radius:0.25rem;">
                        </div>

                        <button type="submit" class="btn btn-primary btn-block mb-3" style="border-radius:0.25rem;">
                            <i class="fas fa-key mr-1"></i> Reset Password
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
    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
