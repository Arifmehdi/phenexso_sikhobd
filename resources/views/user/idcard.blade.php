@extends('website.layouts.sikhobd')

@section('title', 'আইডি কার্ড — ' . ($ws->name ?? env('APP_NAME')))

@push('css')
<style>
    .dash-main { min-height: calc(100vh - 76px); }
    .avatar-sm { width: 44px; height: 44px; border-radius: 50%; object-fit: cover; }
    .stat-grid-compact { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 28px; }
    .stat-card-compact { background: var(--bg); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 18px 20px; display: flex; align-items: center; gap: 16px; transition: all .2s; }
    .stat-card-compact:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.06); }
    .stat-card-compact .icon { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
    .stat-card-compact .num { font-size: 20px; font-weight: 800; color: var(--text); line-height: 1.2; }
    .stat-card-compact .label { font-size: 12px; color: var(--text-soft); }
    .icon-primary { background: #ede9fe; color: #7c3aed; }
    .icon-success { background: #dcfce7; color: #16a34a; }
    .icon-danger { background: #fee2e2; color: #dc2626; }

    /* ID Card styles */
    .idcard-wrapper { display: flex; justify-content: center; padding: 20px 0; }
    .idcard-preview { width: 360px; height: 560px; border-radius: 14px; position: relative; overflow: hidden; font-family: 'Segoe UI', Arial, sans-serif; background: linear-gradient(to bottom, #BBDFBB 0%, #BBDFBB 32%, #DFF2DF 50%, #ffffff 100%); box-shadow: 0 8px 32px rgba(0,0,0,0.1); transition: transform .2s; }
    .idcard-preview:hover { transform: scale(1.01); }
    .idcard-preview .print-btn { position: absolute; top: 12px; right: 12px; z-index: 10; width: 36px; height: 36px; border-radius: 50%; border: none; background: rgba(89, 186, 71, 0.9); color: #fff; font-size: 14px; cursor: pointer; transition: all .2s; display: flex; align-items: center; justify-content: center; text-decoration: none; }
    .idcard-preview .print-btn:hover { background: #59BA47; transform: scale(1.1); }
    .idcard-body { padding: 24px 20px 20px; text-align: center; }
    .idcard-avatar { width: 130px; height: 130px; border-radius: 10px; object-fit: cover; border: 3px solid #59BA47; margin-bottom: 12px; display: block; margin-left: auto; margin-right: auto; cursor: pointer; transition: opacity .2s; }
    .idcard-avatar:hover { opacity: 0.85; }
    .idcard-name { font-weight: 700; font-size: 17px; margin: 0 0 2px; }
    .idcard-blood { font-size: 14px; color: #444; margin: 2px 0; }
    .idcard-mobile { font-size: 14px; color: #444; margin: 2px 0 10px; }
    .idcard-title { font-size: 26px; font-weight: 800; color: #788377; margin: 8px 0 4px; letter-spacing: 0.5px; }
    .idcard-logo { width: 45%; margin: 4px auto; display: block; }
    .idcard-footer { background: #59BA47; color: #053800; padding: 10px 14px; font-size: 12px; text-align: center; line-height: 1.4; position: absolute; bottom: 0; width: 100%; }
    .idcard-footer a { color: #053800; text-decoration: none; font-weight: 600; }
    .idcard-signature-area { display: flex; justify-content: space-between; align-items: flex-end; padding: 0 20px; position: absolute; bottom: 70px; width: 100%; font-size: 13px; }
    .idcard-signature-area img { width: 100px; height: auto; display: block; margin-bottom: 2px; }
    .idcard-signature-area .sig-label { font-size: 11px; color: #555; }
    .idcard-reg-date { font-size: 15px; font-weight: 600; }
    .idcard-reg-label { font-size: 11px; color: #555; }

    .profile-upload { margin-top: 12px; }
    .profile-upload input[type="file"] { display: none; }

    @media (max-width: 576px) {
        .stat-grid-compact { grid-template-columns: 1fr; }
        .idcard-preview { width: 320px; height: auto; min-height: 520px; }
    }
</style>
@endpush

@section('content')
<div class="dash-wrap">
    <!-- Sidebar -->
    <aside class="dash-side">
        <div class="dash-user">
            <img src="{{ auth()->user()->image ? asset('storage/user_images/'.auth()->user()->image) : 'https://cdn-icons-png.flaticon.com/512/3177/3177440.png' }}"
                 class="avatar-sm" alt="">
            <div>
                <strong>{{ auth()->user()->name }}</strong>
                <span>{{ auth()->user()->email }}</span>
            </div>
        </div>
        <nav class="dash-nav">
            <a href="{{ route('user.dashboard') }}">
                <i class="fa-solid fa-house"></i> <span>ড্যাশবোর্ড</span>
            </a>
            <a href="{{ route('user.orders', ['type' => 'all']) }}">
                <i class="fa-solid fa-cart-shopping"></i> <span>আমার অর্ডারসমূহ</span>
            </a>
            <a href="{{ route('user.editMyInformation') }}">
                <i class="fa-solid fa-user-gear"></i> <span>প্রোফাইল আপডেট</span>
            </a>
            <a href="{{ route('user.idcard') }}" class="active">
                <i class="fa-solid fa-id-card"></i> <span>আইডি কার্ড</span>
            </a>
            @if(isset($user) && $user->idcard)
                <a href="{{ asset('storage/'.$user->idcard->file_name) }}" target="_blank">
                    <i class="fa-solid fa-file-medical"></i> <span>হেলথ কার্ড</span>
                </a>
            @endif
            <a href="{{ route('health.registration') }}">
                <i class="fa-solid fa-clipboard-list"></i> <span>হেলথ কার্ড ফর্ম</span>
            </a>
            <a href="{{ route('logout') }}" style="color: var(--accent); margin-top: auto;">
                <i class="fa-solid fa-right-from-bracket"></i> <span>লগআউট</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <section class="dash-main">
        <div class="dash-head">
            <div>
                <h1>আইডি কার্ড</h1>
                <p>আপনার হেলথ আইডি কার্ড</p>
            </div>
            <div class="btn-group-custom">
                <a href="{{ route('user.idcard.pdf') }}" target="_blank" class="btn btn-primary">
                    <i class="fa-solid fa-download"></i> PDF ডাউনলোড
                </a>
            </div>
        </div>

        <!-- Stats Row -->
        <div class="stat-grid-compact">
            <a href="{{ route('user.orders', ['type' => 'all']) }}" class="stat-card-compact text-decoration-none">
                <div class="icon icon-primary"><i class="fa-solid fa-cart-plus"></i></div>
                <div>
                    <div class="num">{{ $user->orders()->count() }}</div>
                    <div class="label">সর্বমোট অর্ডার</div>
                </div>
            </a>
            <a href="{{ route('user.orders', ['type' => 'today']) }}" class="stat-card-compact text-decoration-none">
                <div class="icon icon-success"><i class="fa-solid fa-calendar-day"></i></div>
                <div>
                    <div class="num">{{ $todayOrdersCount }}</div>
                    <div class="label">আজকের অর্ডার</div>
                </div>
            </a>
            <a href="{{ route('user.orders', ['type' => 'cancelled']) }}" class="stat-card-compact text-decoration-none">
                <div class="icon icon-danger"><i class="fa-solid fa-ban"></i></div>
                <div>
                    <div class="num">{{ $cancelOrdersCount }}</div>
                    <div class="label">বাতিল অর্ডার</div>
                </div>
            </a>
        </div>

        <!-- ID Card -->
        <div class="panel">
            <div class="panel-head">
                <h3><i class="fa-solid fa-id-card"></i> হেলথ আইডি কার্ড</h3>
                <div class="profile-upload">
                    <label for="profileImageInput" class="btn btn-accent btn-sm" style="cursor:pointer;">
                        <i class="fa-solid fa-camera"></i> ছবি পরিবর্তন
                    </label>
                    <input type="file" id="profileImageInput" accept="image/*">
                </div>
            </div>
            <div class="idcard-wrapper">
                <div class="idcard-preview">
                    <a href="{{ route('user.idcard.pdf') }}" target="_blank" class="print-btn" title="Print / Download PDF">
                        <i class="fa-solid fa-download"></i>
                    </a>

                    <div class="idcard-body">
                        <img id="cardProfilePreview"
                             src="{{ route('imagecache', ['template' => 'pfimd', 'filename' => $user->fi()]) }}"
                             alt="Profile Photo"
                             class="idcard-avatar"
                             onclick="document.getElementById('profileImageInput').click()">

                        <div class="idcard-name">{{ Auth::user()->name ?? 'Guest User' }}</div>
                        <div class="idcard-blood">Blood Group: {{ Auth::user()->blood_group ?? 'A+' }}</div>
                        <div class="idcard-mobile">Mobile: {{ Auth::user()->mobile ?? '+880123456789' }}</div>
                        <div class="idcard-title">Health Card</div>
                        <img src="https://93.phenexsoft.com/uslive/original/logo-alt1756994190.png" alt="site logo" class="idcard-logo">
                    </div>

                    <!-- Signature & Date -->
                    <div class="idcard-signature-area">
                        <div style="text-align:left;">
                            <img src="{{ asset('img/sign.png') }}" alt="signature">
                            <div class="sig-label">Signature</div>
                        </div>
                        <div style="text-align:right;">
                            <div class="idcard-reg-date">{{ Auth::user()->registration_date ?? date('d/m/Y') }}</div>
                            <div class="idcard-reg-label">Date of Registration</div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="idcard-footer">
                        <div>H-302 High School Road Muradpur High School Road East Jurain, Dhaka - 1204</div>
                        <div>Phone: 01973-005566 &middot; {{ 'www.93shasthoseba.com' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    // Profile Image Upload
    document.addEventListener('DOMContentLoaded', function() {
        var input = document.getElementById('profileImageInput');
        if (input) {
            input.addEventListener('change', function() {
                var file = this.files[0];
                if (!file) return;

                var formData = new FormData();
                formData.append('image', file);
                formData.append('_token', '{{ csrf_token() }}');

                // Preview immediately
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('cardProfilePreview').src = e.target.result;
                };
                reader.readAsDataURL(file);

                // Upload
                fetch("{{ route('user.uploadProfileImage') }}", {
                    method: 'POST',
                    body: formData
                })
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    if (!data.success) alert('Upload failed');
                })
                .catch(function() { alert('Upload failed'); });
            });
        }
    });
</script>
@endsection
