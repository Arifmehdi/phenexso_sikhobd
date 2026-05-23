@extends('website.layouts.sikhobd')

@section('title', 'প্রোফাইল আপডেট — ' . ($ws->name ?? env('APP_NAME')))

@push('css')
<style>
    .profile-page { padding: 60px 0;
        min-height: 60vh;
        background: var(--bg-soft); }
    .action-btn {
        padding: 12px 28px;
        background: var(--primary);
        color: #fff;
        border: none;
        border-radius: var(--radius-full);
        font-weight: 600;
        font-size: 14px;
        transition: all .2s;
        cursor: pointer;
    }
    .action-btn:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
    }
    .custom-input {
        padding: 12px 14px;
        border: 1px solid var(--border);
        border-radius: 10px;
        font-family: inherit;
        font-size: 14px;
        background: var(--bg);
        color: var(--text);
        transition: border .15s, box-shadow .15s;
        width: 100%;
    }
    .custom-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(43, 37, 83, .08);
    }
    .custom-label {
        font-size: 13px;
        font-weight: 600;
        color: var(--text);
        margin-bottom: 6px;
        display: block;
    }
    .password-status {
        font-size: 12px;
        font-weight: 600;
        margin-top: 4px;
        display: block;
    }
    .password-status.valid { color: var(--success); }
    .password-status.invalid { color: var(--accent); }
    .field { margin-bottom: 20px; }
    label.error {
        color: var(--accent);
        font-size: 12px;
        font-weight: 600;
        margin-top: 4px;
    }
</style>
@endpush

@section('content')
<section class="page-hero" style="padding: 40px 0;">
    <div class="container text-center">
        <h1 style="font-weight: 900; font-size: 32px; color: var(--primary);">প্রোফাইল ও পাসওয়ার্ড পরিবর্তন</h1>
        <div class="crumbs">
            <a href="{{ route('home') }}">Home</a> <span>/</span>
            <a href="{{ route('user.dashboard') }}">Dashboard</a> <span>/</span>
            <span style="color: var(--accent);">Profile</span>
        </div>
    </div>
</section>

<div class="profile-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="alert alert-success" style="border-radius: 12px; padding: 16px 20px; border: none; background: #f0fdf4; color: #15803d; font-weight: 600; margin-bottom: 24px;">
                        <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger" style="border-radius: 12px; padding: 16px 20px; border: none; background: #fef2f2; color: #b91c1c; font-weight: 600; margin-bottom: 24px;">
                        <i class="fa-solid fa-circle-exclamation me-2"></i> {{ session('error') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger" style="border-radius: 12px; padding: 16px 20px; border: none; background: #fef2f2; color: #b91c1c; margin-bottom: 24px;">
                        <ul class="mb-0" style="padding-left: 20px;">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Navigation Buttons -->
                <div style="margin-bottom: 24px; display: flex; gap: 10px; flex-wrap: wrap;">
                    @if(Auth::user()->member)
                        <a href="{{ route('agent.dashboard') }}" class="btn btn-outline btn-sm"><i class="fa-solid fa-arrow-left"></i> ব্যাক টু ড্যাশবোর্ড</a>
                    @elseif(Auth::user()->doctor)
                        <a href="{{ route('doctor.dashboard') }}" class="btn btn-outline btn-sm"><i class="fa-solid fa-arrow-left"></i> ব্যাক টু ড্যাশবোর্ড</a>
                    @else
                        <a href="{{ route('user.dashboard') }}" class="btn btn-outline btn-sm"><i class="fa-solid fa-arrow-left"></i> ব্যাক টু ড্যাশবোর্ড</a>
                    @endif
                </div>

                <!-- Change Password Card -->
                <div class="panel">
                    <div class="panel-head">
                        <h3><i class="fa-solid fa-lock"></i> পাসওয়ার্ড পরিবর্তন করুন</h3>
                    </div>
                    <div style="padding: 24px;">
                        <form id="updatePasswordForm" action="{{ route('member.update_password') }}" method="post">
                            @csrf

                            <div class="field">
                                <label class="custom-label">বর্তমান পাসওয়ার্ড</label>
                                <input type="password" class="custom-input" id="old_password" name="old_password"
                                       data-url="{{ route('member.old_password') }}" placeholder="Enter Old Password" required>
                                <span id="checkOldPwd" class="password-status"></span>
                                @error('old_password')
                                    <span class="password-status invalid">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="field">
                                <label class="custom-label">নতুন পাসওয়ার্ড</label>
                                <input type="password" class="custom-input" name="new_password" id="new_password"
                                       placeholder="Enter New Password" required minlength="6">
                                @error('new_password')
                                    <span class="password-status invalid">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="field">
                                <label class="custom-label">নতুন পাসওয়ার্ড (আবার)</label>
                                <input type="password" class="custom-input" name="confirm_password" id="confirm_password"
                                       placeholder="Re-enter New Password" required minlength="6">
                                @error('confirm_password')
                                    <span class="password-status invalid">{{ $message }}</span>
                                @enderror
                            </div>

                            <div style="margin-top: 24px;">
                                <button type="submit" class="action-btn"><i class="fa-solid fa-save me-2"></i> পাসওয়ার্ড পরিবর্তন করুন</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Back to Dashboard -->
                <div class="text-center mt-4">
                    <a href="{{ route('user.dashboard') }}" class="btn btn-outline">
                        <i class="fa-solid fa-arrow-left"></i> ড্যাশবোর্ডে ফিরে যান
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        // Old password validation via AJAX
        $('#old_password').keyup(function() {
            var old_pwd = $(this).val();
            var url = $(this).attr('data-url');
            if (old_pwd.length === 0) {
                $('#checkOldPwd').html('').removeClass('valid invalid');
                return;
            }
            $.ajax({
                url: url,
                method: 'post',
                data: { old_pwd: old_pwd },
                success: function(result) {
                    if (result.success == true) {
                        $('#checkOldPwd').html('<i class="fa-solid fa-check-circle me-1"></i> Password is correct')
                            .addClass('valid').removeClass('invalid');
                    } else {
                        $('#checkOldPwd').html('<i class="fa-solid fa-exclamation-circle me-1"></i> Password is incorrect')
                            .addClass('invalid').removeClass('valid');
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        // Form validation
        $("#updatePasswordForm").validate({
            rules: {
                old_password: {
                    required: true,
                    minlength: 6
                },
                new_password: {
                    required: true,
                    minlength: 6
                },
                confirm_password: {
                    required: true,
                    minlength: 6,
                    equalTo: "#new_password"
                }
            },
            messages: {
                old_password: {
                    required: "Please enter your current password",
                    minlength: "Password must be at least 6 characters"
                },
                new_password: {
                    required: "Please choose a new password",
                    minlength: "Password must be at least 6 characters"
                },
                confirm_password: {
                    required: "Please confirm your new password",
                    minlength: "Password must be at least 6 characters",
                    equalTo: "Passwords do not match"
                }
            },
            errorElement: "label",
            errorPlacement: function(error, element) {
                error.insertAfter(element);
            }
        });
    });
</script>
@endpush
