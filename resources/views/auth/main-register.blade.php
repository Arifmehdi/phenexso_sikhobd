<!DOCTYPE html>
<html lang="en">



<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register | {{ env('APP_NAME') }}</title>

    <!-- Favicons -->
    <link href="{{ asset('frontend/login/assets') }}/backend/dist/img/favicon.ico" rel="icon">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('frontend/login/assets') }}/backend/plugins/fontawesome-free/css/all.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('frontend/login/assets') }}/backend/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('frontend/login/assets') }}/backend/dist/css/adminlte.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('frontend/login/assets') }}/backend/plugins/select2/css/select2.min.css">
    <link rel="stylesheet"
        href="{{ asset('frontend/login/assets') }}/backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- DataTables -->
    <link rel="stylesheet"
        href="{{ asset('frontend/login/assets') }}/backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="{{ asset('frontend/login/assets') }}/backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet"
        href="{{ asset('frontend/login/assets') }}/backend/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- toastr -->
    <link rel="stylesheet" href="{{ asset('frontend/login/assets') }}/backend/plugins/toastr/toastr.min.css">
    <!-- sweetalert2 -->
    <link rel="stylesheet" href="{{ asset('frontend/login/assets') }}/backend/plugins/sweetalert2/sweetalert2.min.css">
    <!-- custom styles -->
    <link rel="stylesheet" href="{{ asset('frontend/login/assets') }}/dist/css/custom.html">
    <!-- jQuery -->
    <script src="{{ asset('frontend/login/assets') }}/backend/plugins/jquery/jquery.min.js"></script>
        </head>
<body class="hold-transition">
    <div>
            <div class="login-page">
        <div class="login-box">
            <div class="card card-outline card-primary shadow-lg" style="border-radius: 1rem; transition: all 0.3s ease;">
                <div class="card-body">
                    <h3 class="login-box-msg">Create Account</h3>
                    <p class="text-muted text-center">Please fill in your details to register</p>
                  {{-- Flash Messages --}}
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
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
                    <form action="{{ route('main.register') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}"
                                placeholder="Enter your name" required autocomplete="off" style="border-radius:0.25rem;">
                            @error('name')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}"
                                placeholder="Enter your email" required autocomplete="off" style="border-radius:0.25rem;">
                            @error('email')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="passwordID">Password</label>
                            <div class="position-relative">
                                <input type="password" name="password" id="passwordID" class="form-control"
                                    placeholder="Enter password" required style="border-radius:0.25rem;">
                                <i class="fas fa-eye position-absolute" id="passwordIcon"
                                    style="right: 10px; top: 50%; transform: translateY(-50%); cursor:pointer; color:#6c757d;"
                                    onclick="togglePassword('passwordID', 'passwordIcon')"
                                    onmouseover="this.style.color='#007bff'" onmouseout="this.style.color='#6c757d'"></i>
                            </div>
                            @error('password')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="passwordConfirmID">Confirm Password</label>
                            <div class="position-relative">
                                <input type="password" name="password_confirmation" id="passwordConfirmID" class="form-control"
                                    placeholder="Re-enter password" required style="border-radius:0.25rem;">
                                <i class="fas fa-eye position-absolute" id="passwordConfirmIcon"
                                    style="right: 10px; top: 50%; transform: translateY(-50%); cursor:pointer; color:#6c757d;"
                                    onclick="togglePassword('passwordConfirmID', 'passwordConfirmIcon')"
                                    onmouseover="this.style.color='#007bff'" onmouseout="this.style.color='#6c757d'"></i>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block mb-3" style="border-radius:0.25rem;">Register</button>

                        <div class="text-center mt-3">
                            <span>Already have an account? </span>
                            <a href="{{ route('login') }}">Sign In</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('frontend/login/assets') }}/backend/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="{{ asset('frontend/login/assets') }}/backend/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="{{ asset('frontend/login/assets') }}/backend/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="{{ asset('frontend/login/assets') }}/backend/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="{{ asset('frontend/login/assets') }}/backend/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('frontend/login/assets') }}/backend/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="{{ asset('frontend/login/assets') }}/backend/plugins/moment/moment.min.js"></script>
<script src="{{ asset('frontend/login/assets') }}/backend/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script
    src="{{ asset('frontend/login/assets') }}/backend/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="{{ asset('frontend/login/assets') }}/backend/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('frontend/login/assets') }}/backend/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="{{ asset('frontend/login/assets') }}/backend/dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('frontend/login/assets') }}/backend/dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('frontend/login/assets') }}/backend/dist/js/pages/dashboard.js"></script>
<!-- Select2 -->
<script src="{{ asset('frontend/login/assets') }}/backend/plugins/select2/js/select2.min.js"></script>
<script src="{{ asset('frontend/login/assets') }}/backend/plugins/select2/js/select2.full.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="{{ asset('frontend/login/assets') }}/backend/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('frontend/login/assets') }}/backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('frontend/login/assets') }}/backend/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('frontend/login/assets') }}/backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{ asset('frontend/login/assets') }}/backend/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('frontend/login/assets') }}/backend/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{ asset('frontend/login/assets') }}/backend/plugins/jszip/jszip.min.js"></script>
<script src="{{ asset('frontend/login/assets') }}/backend/plugins/pdfmake/pdfmake.min.js"></script>
<script src="{{ asset('frontend/login/assets') }}/backend/plugins/pdfmake/vfs_fonts.js"></script>
<script src="{{ asset('frontend/login/assets') }}/backend/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{ asset('frontend/login/assets') }}/backend/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{ asset('frontend/login/assets') }}/backend/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- toastr -->
<script src="{{ asset('frontend/login/assets') }}/backend/plugins/toastr/toastr.min.js"></script>
<!-- sweetalert2 -->
<script src="{{ asset('frontend/login/assets') }}/backend/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- custom scripts -->
<script src="{{ asset('frontend/login/assets') }}/backend/dist/js/custom.js"></script>
    <script>
        function togglePassword(inputId, iconId) {
            var input = document.getElementById(inputId);
            var icon = document.getElementById(iconId);
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>
</body>

</html>
