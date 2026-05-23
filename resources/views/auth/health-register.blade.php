<!DOCTYPE html>
<html lang="en">



<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Health Card | {{ env('APP_NAME') }}</title>

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
    <style>
        .health-card-box {
            max-width: 800px;
            margin: 2rem auto;
        }
        .health-card-box .card {
            border-radius: 1rem;
            transition: all 0.3s ease;
        }
        .health-card-box .card-header {
            border-radius: 1rem 1rem 0 0 !important;
        }
    </style>
</head>
<body class="hold-transition">
    <div class="login-page">
        <div class="health-card-box">
            <div class="card card-outline card-primary shadow-lg">
                <div class="card-header bg-primary text-white text-center" style="border-radius: 1rem 1rem 0 0;">
                    <h4 class="my-1 font-weight-bold">Health Card Form</h4>
                    <hr class="my-2" style="border-color: rgba(255,255,255,0.3);">
                    <p class="text-white mb-0" style="font-size: 0.9rem;">Health Card holders can purchase healthcare and medicine at special discounts from specific hospitals and pharmacies, as per the terms of the agreement with the Foundation.</p>
                </div>
                <div class="card-body p-4">

                    <!-- Success/Error Messages -->
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
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

                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <!-- Name -->
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Enter Name" value="{{ Auth::user()->name }}" required style="border-radius:0.25rem;">
                                @error('name')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Father Name -->
                            <div class="col-md-6 mb-3">
                                <label for="father_name" class="form-label">Father Name <span class="text-danger">*</span></label>
                                <input type="text" id="father_name" name="father_name" class="form-control" placeholder="Enter Father Name" value="{{ Auth::user()->father_name }}" required style="border-radius:0.25rem;">
                                @error('father_name')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Present Address -->
                            <div class="col-md-6 mb-3">
                                <label for="present_address" class="form-label">Present Address <span class="text-danger">*</span></label>
                                <input type="text" id="present_address" name="present_address" class="form-control" placeholder="Enter Present Address" value="{{ Auth::user()->present_address }}" required style="border-radius:0.25rem;">
                                @error('present_address')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Permanent Address -->
                            <div class="col-md-6 mb-3">
                                <label for="permanent_address" class="form-label">Permanent Address <span class="text-danger">*</span></label>
                                <input type="text" id="permanent_address" name="permanent_address" class="form-control" placeholder="Enter Permanent Address" value="{{ Auth::user()->permanent_address }}" required style="border-radius:0.25rem;">
                                @error('permanent_address')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Date of Registration -->
                            <div class="col-md-6 mb-3">
                                <label for="reg_date" class="form-label">Date Of Registration <span class="text-danger">*</span></label>
                                <input type="date" id="reg_date" name="reg_date" class="form-control" value="{{ Auth::user()->reg_date }}" required style="border-radius:0.25rem;">
                                @error('reg_date')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Nid No -->
                            <div class="col-md-6 mb-3">
                                <label for="nid" class="form-label">NID Number <span class="text-danger">*</span></label>
                                <input type="text" id="nid" name="nid" class="form-control" placeholder="Enter Your Nid Number" value="{{ Auth::user()->nid }}" required style="border-radius:0.25rem;">
                                @error('nid')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Mobile No -->
                            <div class="col-md-6 mb-3">
                                <label for="mobile" class="form-label">Contact Number <span class="text-danger">*</span></label>
                                <input type="text" id="mobile" name="mobile" class="form-control" placeholder="E.g. 01700 123456" value="{{ Auth::user()->mobile }}" required style="border-radius:0.25rem;">
                                @error('mobile')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" value="{{ Auth::user()->email }}" disabled style="border-radius:0.25rem; background-color: #e9ecef;">
                                <input type="hidden" id="email" name="email" class="form-control" value="{{ Auth::user()->email }}">
                                @error('email')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Date of Birth -->
                            <div class="col-md-6 mb-3">
                                <label for="dob" class="form-label">Date Of Birth <span class="text-danger">*</span></label>
                                <input type="date" id="dob" name="dob" class="form-control" value="{{ Auth::user()->dob }}" required style="border-radius:0.25rem;">
                                @error('dob')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Blood Group -->
                            <div class="col-md-6 mb-3">
                                <label for="blood_group" class="form-label">Blood Group <span class="text-danger">*</span></label>
                                <select id="blood_group" name="blood_group" class="form-control" required style="border-radius:0.25rem;">
                                    <option value="">Select One</option>
                                    @foreach(['A+','A-','B+','B-','O+','O-','AB+','AB-'] as $bg)
                                        <option value="{{ $bg }}" {{ old('blood_group', Auth::user()->blood_group ?? '') == $bg ? 'selected' : '' }}>
                                            {{ $bg }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('blood_group')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- S.S.C Passing -->
                            <div class="col-md-6 mb-3">
                                <label for="ssc_passing" class="form-label">S.S.C Passing Year<span class="text-danger">*</span></label>
                                <input type="text" id="ssc_passing" name="ssc_passing" class="form-control" placeholder="S.S.C Passing Year" value="{{ Auth::user()->ssc_passing }}" required style="border-radius:0.25rem;">
                                @error('ssc_passing')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- S.S.C Registration -->
                            <div class="col-md-6 mb-3">
                                <label for="ssc_registration" class="form-label">S.S.C Registration Year<span class="text-danger">*</span></label>
                                <input type="text" id="ssc_registration" name="ssc_registration" class="form-control" placeholder="S.S.C Registration Year" value="{{ Auth::user()->ssc_registration }}" required style="border-radius:0.25rem;">
                                @error('ssc_registration')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Image Upload -->
                            <div class="col-md-6 mb-3">
                                <label for="image" class="form-label">Image Upload (Passport Size) <span class="text-danger">*</span></label>
                                <input type="file" id="image" name="image" class="form-control" accept="image/*" style="border-radius:0.25rem;">
                                @error('image')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary px-5" style="border-radius:0.25rem;">Register</button>
                        </div>

                        <div class="text-center mt-3">
                            <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary" style="border-radius:0.25rem;">
                                <i class="fas fa-arrow-left"></i> Back to Dashboard
                            </a>
                        </div>
                    </form>

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
    <script src="{{ asset('frontend/login/assets') }}/backend/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
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
</body>

</html>
