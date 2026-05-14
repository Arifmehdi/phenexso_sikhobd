@extends('website.layouts.sikhobd')

@section('title', 'ইউজার ড্যাশবোর্ড — ' . ($ws->name ?? env('APP_NAME')))

@push('css')
<style>
    .dashboard-page { padding: 60px 0; background: #f8fafc; min-height: 80vh; }
    
    /* Sidebar Styling */
    .dashboard-sidebar { background: #fff; border-radius: 24px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.02); }
    .user-profile-mini { padding: 30px; text-align: center; border-bottom: 1px solid #f1f5f9; background: var(--bg-soft); }
    .user-avatar { width: 80px; height: 80px; border-radius: 50%; border: 4px solid #fff; box-shadow: var(--shadow-sm); margin-bottom: 15px; object-fit: cover; }
    .user-name { font-size: 18px; font-weight: 800; color: var(--primary); margin-bottom: 5px; }
    .user-email { font-size: 13px; color: var(--text-muted); }

    .dash-nav { padding: 15px; }
    .dash-nav-link { display: flex; align-items: center; gap: 12px; padding: 12px 20px; border-radius: 12px; color: #64748b; font-weight: 600; font-size: 14px; text-decoration: none; transition: all 0.2s; margin-bottom: 5px; }
    .dash-nav-link i { font-size: 16px; opacity: 0.7; width: 20px; text-align: center; }
    .dash-nav-link:hover { background: var(--bg-soft); color: var(--primary); }
    .dash-nav-link.active { background: var(--primary); color: #fff; box-shadow: 0 4px 12px rgba(var(--primary-rgb), 0.2); }
    .dash-nav-link.active i { opacity: 1; }
    .dash-nav-link.text-danger:hover { background: #fef2f2; color: #ef4444; }

    /* Card Styling */
    .dash-card { background: #fff; border-radius: 24px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.02); margin-bottom: 24px; }
    .dash-card-header { padding: 25px 30px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; }
    .dash-card-header h2 { font-size: 18px; font-weight: 800; color: var(--primary); margin: 0; display: flex; align-items: center; gap: 10px; }
    .dash-card-body { padding: 30px; }

    /* Stat Widgets */
    .stat-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px; }
    .stat-item { padding: 25px; border-radius: 20px; background: #fff; border: 1px solid #e2e8f0; text-align: center; transition: all 0.3s; }
    .stat-item:hover { transform: translateY(-5px); border-color: var(--primary); }
    .stat-icon { width: 50px; height: 50px; border-radius: 14px; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; font-size: 20px; }
    .stat-icon.blue { background: rgba(59, 130, 246, 0.1); color: #3b82f6; }
    .stat-icon.orange { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }
    .stat-icon.purple { background: rgba(139, 92, 246, 0.1); color: #8b5cf6; }
    .stat-val { font-size: 24px; font-weight: 900; color: var(--primary); display: block; }
    .stat-label { font-size: 13px; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }

    /* Table Styling */
    .custom-table { width: 100%; border-collapse: collapse; }
    .custom-table th { padding: 15px 20px; background: var(--bg-soft); color: var(--text-muted); font-size: 12px; font-weight: 700; text-transform: uppercase; text-align: left; }
    .custom-table td { padding: 18px 20px; border-bottom: 1px solid #f1f5f9; font-size: 14px; vertical-align: middle; }
    .order-id { font-weight: 800; color: var(--primary); }
    
    .status-pill { padding: 6px 12px; border-radius: 50px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
    .status-pending { background: #fff7ed; color: #c2410c; }
    .status-approved { background: #f0fdf4; color: #15803d; }
    .status-rejected { background: #fef2f2; color: #b91c1c; }

    .btn-circle { width: 34px; height: 34px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; background: var(--bg-soft); color: var(--primary); transition: all 0.2s; border: none; text-decoration: none; }
    .btn-circle:hover { background: var(--primary); color: #fff; transform: scale(1.1); }

    @media (max-width: 991px) {
        .stat-grid { grid-template-columns: 1fr; }
        .dashboard-sidebar { margin-bottom: 30px; }
    }
</style>
@endpush

@section('content')
<section class="page-hero" style="padding: 60px 0;">
    <div class="container text-center text-lg-start">
        <h1 style="font-weight: 900; font-size: 32px; color: var(--primary);">স্বাগতম, {{ auth()->user()->name }}</h1>
        <div class="crumbs">
            <a href="{{ route('home') }}">Home</a> <span>/</span> 
            <span style="color: var(--accent);">Dashboard</span>
        </div>
    </div>
</section>

<div class="dashboard-page">
    <div class="container">
        <div class="row g-4">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <aside class="dashboard-sidebar">
                    <div class="user-profile-mini">
                        <img src="{{ auth()->user()->image ? asset('storage/user_images/'.auth()->user()->image) : 'https://cdn-icons-png.flaticon.com/512/3177/3177440.png' }}" class="user-avatar" alt="">
                        <div class="user-name">{{ auth()->user()->name }}</div>
                        <div class="user-email">{{ auth()->user()->email }}</div>
                    </div>
                    <div class="dash-nav">
                        <div class="nav flex-column nav-pills">
                            <a class="dash-nav-link {{ $activeTab == 'dashboard' ? 'active' : '' }}" data-bs-toggle="pill" href="#tab-dashboard"><i class="fa-solid fa-house"></i> ড্যাশবোর্ড</a>
                            <a class="dash-nav-link {{ $activeTab == 'order' ? 'active' : '' }}" href="{{ route('user.orders', ['type' => 'all']) }}"><i class="fa-solid fa-cart-shopping"></i> আমার অর্ডারসমূহ</a>
                            <a class="dash-nav-link" data-bs-toggle="pill" href="#tab-address"><i class="fa-solid fa-location-dot"></i> ঠিকানা</a>
                            <a class="dash-nav-link" data-bs-toggle="pill" href="#tab-account"><i class="fa-solid fa-user-gear"></i> প্রোফাইল আপডেট</a>
                            <a class="dash-nav-link text-danger" href="{{ route('logout') }}"><i class="fa-solid fa-right-from-bracket"></i> লগআউট</a>
                        </div>
                    </div>
                </aside>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                <div class="tab-content">
                    
                    <!-- Dashboard Home -->
                    <div class="tab-pane fade {{ $activeTab == 'dashboard' ? 'show active' : '' }}" id="tab-dashboard">
                        <div class="stat-grid">
                            <div class="stat-item">
                                <div class="stat-icon blue"><i class="fa-solid fa-bag-shopping"></i></div>
                                <span class="stat-val">{{ $orders->total() }}</span>
                                <span class="stat-label">মোট অর্ডার</span>
                            </div>
                            <div class="stat-item">
                                <div class="stat-icon orange"><i class="fa-solid fa-clock-rotate-left"></i></div>
                                <span class="stat-val">{{ $todayOrdersCount }}</span>
                                <span class="stat-label">আজকের অর্ডার</span>
                            </div>
                            <div class="stat-item">
                                <div class="stat-icon purple"><i class="fa-solid fa-calendar-check"></i></div>
                                <span class="stat-val">{{ now()->format('d M') }}</span>
                                <span class="stat-label">{{ now()->format('Y') }}</span>
                            </div>
                        </div>

                        <div class="dash-card">
                            <div class="dash-card-header">
                                <h2><i class="fa-solid fa-clock-rotate-left"></i> সাম্প্রতিক অর্ডারসমূহ</h2>
                                <a href="{{ route('user.orders', ['type' => 'all']) }}" class="btn btn-link text-primary fw-bold text-decoration-none small">সব দেখুন</a>
                            </div>
                            <div class="dash-card-body p-0">
                                <div class="table-responsive">
                                    <table class="custom-table">
                                        <thead>
                                            <tr>
                                                <th>অর্ডার আইডি</th>
                                                <th>তারিখ</th>
                                                <th>অবস্থা</th>
                                                <th>মোট টাকা</th>
                                                <th>অ্যাকশন</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($orders->take(5) as $order)
                                            <tr>
                                                <td class="order-id">#{{ $order->id }}</td>
                                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                                <td>
                                                    @php
                                                        $status = strtolower($order->order_status);
                                                        $statusClass = str_contains($status, 'pending') ? 'status-pending' : (str_contains($status, 'cancel') ? 'status-rejected' : 'status-approved');
                                                    @endphp
                                                    <span class="status-pill {{ $statusClass }}">{{ $order->order_status }}</span>
                                                </td>
                                                <td class="fw-bold">৳{{ number_format($order->grand_total) }}</td>
                                                <td>
                                                    <a href="{{ route('user.orderPrint', $order->id) }}" target="_blank" class="btn-circle" title="Invoice"><i class="fa-solid fa-file-invoice"></i></a>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-5 text-muted">কোনো অর্ডার পাওয়া যায়নি</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Orders Tab -->
                    <div class="tab-pane fade {{ $activeTab == 'order' ? 'show active' : '' }}" id="tab-orders">
                        <div class="dash-card">
                            <div class="dash-card-header">
                                <h2><i class="fa-solid fa-cart-shopping"></i> আমার সকল অর্ডার</h2>
                                @if(isset($type))
                                <div class="btn-group">
                                    <a href="{{ route('user.orders', ['type' => 'all']) }}" class="btn btn-sm {{ $type=='all'?'btn-primary':'btn-outline-primary' }}">সব</a>
                                    <a href="{{ route('user.orders', ['type' => 'today']) }}" class="btn btn-sm {{ $type=='today'?'btn-primary':'btn-outline-primary' }}">আজকের</a>
                                </div>
                                @endif
                            </div>
                            <div class="dash-card-body p-0">
                                <div class="table-responsive">
                                    <table class="custom-table">
                                        <thead>
                                            <tr>
                                                <th>অর্ডার আইডি</th>
                                                <th>তারিখ</th>
                                                <th>অবস্থা</th>
                                                <th>মোট টাকা</th>
                                                <th>অ্যাকশন</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($orders as $order)
                                            <tr>
                                                <td class="order-id">#{{ $order->id }}</td>
                                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                                <td>
                                                    @php
                                                        $status = strtolower($order->order_status);
                                                        $statusClass = str_contains($status, 'pending') ? 'status-pending' : (str_contains($status, 'cancel') ? 'status-rejected' : 'status-approved');
                                                    @endphp
                                                    <span class="status-pill {{ $statusClass }}">{{ $order->order_status }}</span>
                                                </td>
                                                <td class="fw-bold">৳{{ number_format($order->grand_total) }}</td>
                                                <td>
                                                    <a href="{{ route('user.orderPrint', $order->id) }}" target="_blank" class="btn-circle" title="Invoice"><i class="fa-solid fa-file-invoice"></i></a>
                                                    <a href="{{ route('user.orderChalan', $order->id) }}" target="_blank" class="btn-circle" title="Chalan"><i class="fa-solid fa-receipt"></i></a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="p-4">
                                    {{ $orders->links() }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Address Tab -->
                    <div class="tab-pane fade" id="tab-address">
                        <div class="dash-card">
                            <div class="dash-card-header">
                                <h2><i class="fa-solid fa-location-dot"></i> সংরক্ষিত ঠিকানা</h2>
                            </div>
                            <div class="dash-card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="p-4 border rounded bg-white shadow-sm" style="border-radius: 20px !important;">
                                            <h6 class="fw-bold text-primary mb-3">ডেলিভারি ঠিকানা</h6>
                                            @php $dl = auth()->user()->locations()->first(); @endphp
                                            @if($dl)
                                                <p class="mb-1 fw-bold text-dark">{{ $dl->name }}</p>
                                                <p class="mb-1 text-muted small">{{ $dl->address_title }}</p>
                                                <p class="mb-0 text-muted small"><i class="fa-solid fa-phone me-1"></i> {{ $dl->mobile }}</p>
                                            @else
                                                <p class="text-muted small">কোনো ঠিকানা সংরক্ষিত নেই।</p>
                                            @endif
                                            <hr>
                                            <a href="#tab-account" data-bs-toggle="pill" class="text-accent fw-bold text-decoration-none small">পরিবর্তন করুন</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Account Details Tab -->
                    <div class="tab-pane fade" id="tab-account">
                        <div class="dash-card">
                            <div class="dash-card-header">
                                <h2><i class="fa-solid fa-user-gear"></i> প্রোফাইল এবং পাসওয়ার্ড আপডেট</h2>
                            </div>
                            <div class="dash-card-body">
                                <form action="{{ route('user.changeMyInformation') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label class="custom-label">আপনার নাম *</label>
                                            <input type="text" name="name" class="form-control custom-input" value="{{ auth()->user()->name }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="custom-label">ইমেইল ঠিকানা</label>
                                            <input type="email" name="email" class="form-control custom-input" value="{{ auth()->user()->email }}" disabled>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="custom-label">মোবাইল নম্বর *</label>
                                            <input type="text" name="mobile" class="form-control custom-input" value="{{ auth()->user()->mobile }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="custom-label">পিতার নাম</label>
                                            <input type="text" name="father_name" class="form-control custom-input" value="{{ auth()->user()->father_name }}">
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label class="custom-label">জন্ম তারিখ</label>
                                            <input type="date" name="dob" class="form-control custom-input" value="{{ auth()->user()->dob }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="custom-label">রক্তের গ্রুপ</label>
                                            <select name="blood_group" class="form-control custom-input">
                                                <option value="">নির্বাচন করুন</option>
                                                @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bg)
                                                    <option value="{{ $bg }}" {{ auth()->user()->blood_group == $bg ? 'selected' : '' }}>{{ $bg }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="custom-label">বিকাশ নম্বর</label>
                                            <input type="text" name="bkash_number" class="form-control custom-input" value="{{ auth()->user()->bkash_number }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="custom-label">প্রোফাইল ছবি</label>
                                            <input type="file" name="image" class="form-control custom-input">
                                        </div>

                                        <div class="col-12">
                                            <label class="custom-label">বিস্তারিত ঠিকানা</label>
                                            <textarea name="address" class="form-control custom-input" rows="3">{{ auth()->user()->address }}</textarea>
                                        </div>
                                        
                                        <div class="col-12 py-3"><hr></div>

                                        <div class="col-md-12">
                                            <h5 class="fw-bold text-primary mb-3">পাসওয়ার্ড পরিবর্তন করুন (ঐচ্ছিক)</h5>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="custom-label">বর্তমান পাসওয়ার্ড</label>
                                            <input type="password" name="old_password" class="form-control custom-input" placeholder="পাসওয়ার্ড পরিবর্তন করতে চাইলে বর্তমানটি দিন">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="custom-label">নতুন পাসওয়ার্ড</label>
                                            <input type="password" name="new_password" class="form-control custom-input">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="custom-label">কনফার্ম পাসওয়ার্ড</label>
                                            <input type="password" name="confirm_password" class="form-control custom-input">
                                        </div>
                                        
                                        <div class="col-12">
                                            <button type="submit" class="action-btn">সকল তথ্য আপডেট করুন</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        var hash = window.location.hash;
        if (hash) {
            $('.dash-nav-link[href="' + hash + '"]').tab('show');
            $('.dash-nav-link').removeClass('active');
            $('.dash-nav-link[href="' + hash + '"]').addClass('active');
        }
        
        $('.dash-nav-link[data-bs-toggle="pill"]').on('click', function() {
            window.location.hash = $(this).attr('href');
            $('.dash-nav-link').removeClass('active');
            $(this).addClass('active');
        });
    });
</script>
@endpush
