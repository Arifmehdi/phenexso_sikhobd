@extends('website.layouts.sikhobd')

@section('title', __('frontend.dash.title') . ' — ' . ($ws->name ?? env('APP_NAME')))

@push('css')
<style>
    .custom-table { width: 100%; border-collapse: collapse; }
    .custom-table th { padding: 14px 18px; background: var(--bg-muted); color: var(--text-soft); font-size: 12px; font-weight: 700; text-transform: uppercase; text-align: left; letter-spacing: 0.3px; }
    .custom-table td { padding: 16px 18px; border-bottom: 1px solid var(--border); font-size: 14px; vertical-align: middle; }
    .order-id { font-weight: 800; color: var(--primary); }
    .status-pill { padding: 4px 12px; border-radius: 50px; font-size: 11px; font-weight: 700; text-transform: uppercase; display: inline-block; }
    .status-pending { background: #fff7ed; color: #c2410c; }
    .status-approved { background: #f0fdf4; color: #15803d; }
    .status-rejected { background: #fef2f2; color: #b91c1c; }
    .custom-input { padding: 12px 14px; border: 1px solid var(--border); border-radius: 10px; font-family: inherit; font-size: 14px; background: var(--bg); color: var(--text); transition: border .15s, box-shadow .15s; width: 100%; }
    .custom-input:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 4px rgba(43, 37, 83, .08); }
    .custom-label { font-size: 13px; font-weight: 600; color: var(--text); margin-bottom: 6px; display: block; }
    .action-btn { padding: 12px 28px; background: var(--primary); color: #fff; border: none; border-radius: var(--radius-full); font-weight: 600; font-size: 14px; transition: all .2s; }
    .action-btn:hover { background: var(--primary-dark); transform: translateY(-1px); }
    .avatar-sm { width: 44px; height: 44px; border-radius: 50%; object-fit: cover; }
    .tab-pane { min-height: 300px; }
    .empty-state { text-align: center; padding: 60px 20px; }
    .empty-state i { font-size: 48px; color: var(--border); margin-bottom: 16px; }
    .empty-state h5 { color: var(--text-soft); margin-bottom: 12px; }
    .dash-main { min-height: calc(100vh - 76px); }
    .tab-pane .panel { margin-bottom: 0; }
    /* Compact, modern stat cards */
    .stat-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 12px; margin-bottom: 22px; }
    .stat-card { background:#fff; border:1px solid var(--border); display: flex; flex-wrap: wrap; align-items: center; column-gap: 11px; row-gap: 0; padding: 12px 14px; border-radius: 12px; transition: box-shadow .2s ease, transform .2s ease, border-color .2s ease; }
    .stat-card:hover { box-shadow: 0 6px 16px rgba(0,0,0,.07); transform: translateY(-2px); border-color: transparent; }
    .stat-card .icon { width: 38px; height: 38px; border-radius: 10px; margin-bottom: 0 !important; font-size: 15px; flex-shrink: 0; }
    .stat-card .num { font-size: 20px; font-weight: 800; line-height: 1.1; }
    .stat-card .label { flex-basis: 100%; margin-left: 49px; font-size: 11.5px; margin-top: 1px; }
    .panel + .panel { margin-top: 24px; }
    .dash-cols-custom { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
    .btn-circle { width: 34px; height: 34px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; background: var(--bg-muted); color: var(--primary); transition: all 0.2s; border: none; text-decoration: none; }
    .btn-circle:hover { background: var(--primary); color: #fff; transform: scale(1.1); }
    .filter-tabs { display: flex; gap: 8px; }
    .filter-tabs .btn { border-radius: var(--radius-full); padding: 6px 16px; font-size: 13px; }
    .btn-group-custom { display: flex; gap: 8px; }
    @media (max-width: 768px) { .dash-cols-custom { grid-template-columns: 1fr; } }

    /* Prevent horizontal overflow (white space on the right) */
    .dash-wrap { max-width: 100%; overflow-x: hidden; }
    .dash-main { min-width: 0; }            /* let the 1fr grid track shrink */
    .dash-main .panel, .dash-main .tab-content-item { max-width: 100%; }
    .dash-main table { width: 100%; }       /* tables fill, wrappers scroll if needed */

    /* ───────── Mobile responsive ───────── */
    @media (max-width: 991px) {
        /* Sidebar becomes a top bar; make nav a clean horizontal scroll */
        .dash-side { padding: 14px 12px; }
        .dash-user { margin-bottom: 14px; }
        .dash-nav { gap: 6px; padding-bottom: 4px; -webkit-overflow-scrolling: touch; scrollbar-width: none; }
        .dash-nav::-webkit-scrollbar { display: none; }
        .dash-nav a { padding: 9px 14px; border-radius: 999px; border: 1px solid var(--border); font-size: 13px; }
        .dash-nav a.active { border-color: var(--primary); }
        .dash-nav > div { display: none; } /* hide "Teacher Area" divider label in row mode */
        .dash-main { padding: 20px 14px; }
        .dash-head h1 { font-size: 20px; }
    }

    @media (max-width: 575px) {
        .dash-main { padding: 16px 12px; }
        /* Stat cards: 2 per row */
        .stat-grid { grid-template-columns: 1fr 1fr !important; gap: 10px; }
        .stat-card .num { font-size: 18px; }
        .stat-card .label { font-size: 11px; }
        /* Course / e-book rows: let the action button drop full-width */
        .course-row { flex-wrap: wrap; padding: 12px; gap: 12px; }
        .course-row .thumb { width: 54px; height: 54px; }
        .course-row .body { flex: 1 1 60%; min-width: 0; }
        .course-row > a.btn, .course-row > .btn, .course-row > .status-pill { flex: 1 0 100%; text-align: center; justify-content: center; }
        /* Tables: tighter cells + horizontal scroll already wrapped */
        .custom-table th, .custom-table td { padding: 10px 12px; font-size: 13px; }
        .dash-user span { font-size: 11px; word-break: break-all; }
        .dash-head { gap: 8px; }
        .filter-tabs { flex-wrap: wrap; }
    }
</style>
@endpush

@section('content')
@php
    // Safe defaults — some dashboard routes render this view with a subset of variables
    $exams = $exams ?? collect();
    $completed_exams = $completed_exams ?? collect();
    $enrollments = $enrollments ?? collect();
    $ebookEnrollments = $ebookEnrollments ?? collect();
    $orderItems = $orderItems ?? collect();
    $courseProgress = $courseProgress ?? [];
    $userCertificates = $userCertificates ?? collect();
    $teacher_questions = $teacher_questions ?? collect();
    $teacher_exams = $teacher_exams ?? collect();
    $teacher_questions_count = $teacher_questions_count ?? 0;
    $teacher_exams_count = $teacher_exams_count ?? 0;
    // Platform-wide totals (browse-able)
    $totalCourses  = \App\Models\Product::where('type', 'course')->where('active', 1)->count();
    $totalProducts = \App\Models\Product::where('type', 'product')->where('active', 1)->count();
    $totalExams    = \App\Models\Exam::where('status', '!=', 'draft')->count();
@endphp
<div class="dash-wrap">
    <!-- Sidebar -->
    <aside class="dash-side">
        <div class="dash-user">
            <img src="{{ auth()->user()->image ? asset('storage/users/'.auth()->user()->image) : 'https://cdn-icons-png.flaticon.com/512/3177/3177440.png' }}"
                 class="avatar-sm" alt="">
            <div>
                <strong>{{ auth()->user()->name }}</strong>
                <span>{{ auth()->user()->email }}</span>
            </div>
        </div>
        <nav class="dash-nav" id="dashNav">
            <a href="#tab-dashboard" data-tab="tab-dashboard" class="{{ ($activeTab == 'dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-house"></i> <span>{{ __('frontend.dash.nav_dashboard') }}</span>
            </a>
            <a href="#tab-courses" data-tab="tab-courses" class="{{ ($activeTab == 'courses') ? 'active' : '' }}">
                <i class="fa-solid fa-graduation-cap"></i> <span>{{ __('frontend.dash.nav_courses') }}</span>
            </a>
            <a href="#tab-orders-inline" data-tab="tab-orders-inline" class="{{ ($activeTab == 'order') ? 'active' : '' }}">
                <i class="fa-solid fa-cart-shopping"></i> <span>{{ __('frontend.dash.nav_orders') }}</span>
            </a>
            <a href="#tab-ebooks" data-tab="tab-ebooks" class="{{ ($activeTab == 'ebooks') ? 'active' : '' }}">
                <i class="fa-solid fa-book-open"></i> <span>{{ __('frontend.dash.nav_ebooks') }}</span>
            </a>
            <a href="#tab-address" data-tab="tab-address" class="{{ ($activeTab == 'address') ? 'active' : '' }}">
                <i class="fa-solid fa-location-dot"></i> <span>{{ __('frontend.dash.nav_address') }}</span>
            </a>
            <a href="#tab-account" data-tab="tab-account" class="{{ ($activeTab == 'edit') ? 'active' : '' }}">
                <i class="fa-solid fa-user-gear"></i> <span>{{ __('frontend.dash.nav_profile') }}</span>
            </a>
            <a href="#tab-exams" data-tab="tab-exams" class="{{ ($activeTab == 'exams') ? 'active' : '' }}">
                <i class="fa-solid fa-file-pen"></i> <span>{{ __('frontend.dash.nav_exams') }}</span>
            </a>
            @if(auth()->user()->hasRole('instructor') || auth()->user()->role === 'instructor' || auth()->user()->hasRole('teacher') || auth()->user()->role === 'teacher')
            <div style="padding: 15px 20px 5px; font-size: 11px; font-weight: 800; color: var(--text-soft); text-transform: uppercase; letter-spacing: 1px;">Teacher Area</div>
            <a href="#tab-teacher-questions" data-tab="tab-teacher-questions" class="{{ ($activeTab == 'teacher_questions') ? 'active' : '' }}">
                <i class="fa-solid fa-circle-question"></i> <span>Manage Questions</span>
            </a>
            <a href="#tab-teacher-exams" data-tab="tab-teacher-exams" class="{{ ($activeTab == 'teacher_exams') ? 'active' : '' }}">
                <i class="fa-solid fa-file-invoice"></i> <span>Manage Exams</span>
            </a>
            @endif
            @if($enrollments->count() > 0)
            <a href="#tab-featured" data-tab="tab-featured" class="{{ ($activeTab == 'feature_products') ? 'active' : '' }}">
                <i class="fa-solid fa-star"></i> <span>{{ __('frontend.dash.nav_featured') }}</span>
            </a>
            @endif
            <a href="{{ route('logout') }}" style="color: var(--accent); margin-top: auto;">
                <i class="fa-solid fa-right-from-bracket"></i> <span>{{ __('frontend.dash.nav_logout') }}</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <section class="dash-main">
        <!-- Tab: Dashboard Home -->
        <div class="tab-content-item" id="tab-dashboard">
            <div class="dash-head">
                <div>
                    <h1>{{ __('frontend.dash.nav_dashboard') }}</h1>
                    <p>{{ __('frontend.dash.welcome_sub') }}</p>
                </div>
                <a href="{{ route('courses') }}" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Browse Courses</a>
            </div>

            @php
                $completedCoursesCount = collect($courseProgress)->filter(fn($p) => $p >= 100)->count();
                $certificatesCount = is_countable($userCertificates) ? count($userCertificates) : $userCertificates->count();
                $availableExamsCount = $exams->count();
            @endphp
            <div class="stat-grid">
                <a class="stat-card" href="{{ route('courses') }}" style="text-decoration:none; color:inherit; cursor:pointer;">
                    <div class="icon"><i class="fa-solid fa-book"></i></div>
                    <div class="num">{{ $totalCourses }}</div>
                    <div class="label">{{ __('frontend.dash.total_courses') }}</div>
                </a>
                <a class="stat-card accent" href="{{ route('shop') }}" style="text-decoration:none; color:inherit; cursor:pointer;">
                    <div class="icon"><i class="fa-solid fa-bag-shopping"></i></div>
                    <div class="num">{{ $totalProducts }}</div>
                    <div class="label">{{ __('frontend.dash.total_products') }}</div>
                </a>
                <a class="stat-card warning" href="{{ route('exams.index') }}" style="text-decoration:none; color:inherit; cursor:pointer;">
                    <div class="icon"><i class="fa-solid fa-file-pen"></i></div>
                    <div class="num">{{ $totalExams }}</div>
                    <div class="label">{{ __('frontend.dash.total_exams') }}</div>
                </a>
                <a class="stat-card" href="#" onclick="switchTab('tab-courses'); return false;" style="text-decoration:none; color:inherit; cursor:pointer;">
                    <div class="icon"><i class="fa-solid fa-graduation-cap"></i></div>
                    <div class="num">{{ $enrollments->count() }}</div>
                    <div class="label">{{ __('frontend.dash.enrolled_courses') }}</div>
                </a>
                <a class="stat-card success" href="#" onclick="switchTab('tab-courses'); return false;" style="text-decoration:none; color:inherit; cursor:pointer;">
                    <div class="icon"><i class="fa-solid fa-circle-check"></i></div>
                    <div class="num">{{ $completedCoursesCount }}</div>
                    <div class="label">{{ __('frontend.dash.completed_courses') }}</div>
                </a>
                <a class="stat-card accent" href="#" onclick="switchTab('tab-exams'); return false;" style="text-decoration:none; color:inherit; cursor:pointer;">
                    <div class="icon"><i class="fa-solid fa-file-pen"></i></div>
                    <div class="num">{{ $completed_exams->count() }}</div>
                    <div class="label">{{ __('frontend.dash.completed_exams') }}</div>
                </a>
                <a class="stat-card" href="{{ route('user.certificates') }}" style="text-decoration:none; color:inherit; cursor:pointer;">
                    <div class="icon"><i class="fa-solid fa-certificate"></i></div>
                    <div class="num">{{ $certificatesCount }}</div>
                    <div class="label">{{ __('frontend.dash.certificates') }}</div>
                </a>
                <a class="stat-card warning" href="#" onclick="switchTab('tab-orders-inline'); return false;" style="text-decoration:none; color:inherit; cursor:pointer;">
                    <div class="icon"><i class="fa-solid fa-box"></i></div>
                    <div class="num">{{ $orders->total() }}</div>
                    <div class="label">{{ __('frontend.dash.total_orders') }}</div>
                </a>
                <a class="stat-card success" href="{{ route('exams.index') }}" style="text-decoration:none; color:inherit; cursor:pointer;">
                    <div class="icon"><i class="fa-solid fa-clipboard-list"></i></div>
                    <div class="num">{{ $availableExamsCount }}</div>
                    <div class="label">{{ __('frontend.dash.available_exams') }}</div>
                </a>
            </div>

            <!-- Available Exams (overview summary) -->
            <div class="panel mb-4">
                <div class="panel-head">
                    <h3><i class="fa-solid fa-file-pen"></i> {{ __('frontend.dash.available_exams') }}</h3>
                    <a href="#" onclick="switchTab('tab-exams'); return false;">{{ __('frontend.dash.see_all') }}</a>
                </div>
                @php $ovCompletedExamIds = $completed_exams->pluck('exam_id')->all(); @endphp
                @forelse($exams->take(3) as $exam)
                <div class="course-row">
                    <div class="thumb" style="--c1:#6c5ce7;--c2:#a29bfe;">E</div>
                    <div class="body">
                        <h4>{{ $exam->title }}</h4>
                        <div class="meta">
                            <i class="far fa-clock"></i> {{ $exam->duration }} {{ __('frontend.dash.minutes') }}
                            @if($exam->end_time) &middot; <i class="far fa-calendar-alt"></i> {{ __('frontend.dash.ends') }}: {{ $exam->end_time->format('M d, h:i A') }} @endif
                        </div>
                    </div>
                    @php
                        $exCompleted = in_array($exam->id, $ovCompletedExamIds);
                        $exUpcoming = $exam->start_time && $exam->start_time->isFuture();
                        $exEnded = $exam->end_time && $exam->end_time->isPast();
                    @endphp
                    @if($exCompleted)
                        <span class="status-pill status-approved">{{ __('frontend.dash.completed') }}</span>
                    @elseif($exUpcoming)
                        <span class="status-pill status-pending">{{ __('frontend.dash.upcoming') }}</span>
                    @elseif($exEnded)
                        <span class="status-pill status-pending">{{ __('frontend.dash.ended') }}</span>
                    @else
                        <a href="{{ route('exams.start', $exam->id) }}" class="btn btn-primary btn-sm">{{ __('frontend.dash.participate') }}</a>
                    @endif
                </div>
                @empty
                <div class="empty-state" style="padding:24px;">
                    <i class="fa-solid fa-file-circle-question"></i>
                    <h5>{{ __('frontend.dash.no_exams_title') }}</h5>
                    <p class="text-muted" style="font-size:13px; margin-top:6px;">{{ __('frontend.dash.no_exams_sub') }}</p>
                </div>
                @endforelse
            </div>

            @if($enrollments->count() > 0)
            <div class="panel mb-4">
                <div class="panel-head">
                    <h3><i class="fa-solid fa-graduation-cap"></i> {{ __('frontend.dash.recent_courses') }}</h3>
                    <a href="#" onclick="switchTab('tab-courses'); return false;">{{ __('frontend.dash.see_all') }}</a>
                </div>
                @foreach($enrollments->take(3) as $enrollment)
                @if($enrollment->product)
                <div class="course-row">
                    <a href="{{ route('courseDetail', $enrollment->product->slug ?? '#') }}" class="thumb" style="--c1:#6c5ce7;--c2:#a29bfe; overflow: hidden; display: flex; align-items: center; justify-content: center; text-decoration: none;">
                        @if($enrollment->product->fi() && $enrollment->product->fi() !== 'not_found.png')
                            <img src="{{ route('imagecache', ['template' => 'sbixs', 'filename' => $enrollment->product->fi()]) }}" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            {{ substr($enrollment->product->name_en ?? 'C', 0, 1) }}
                        @endif
                    </a>
                    <div class="body">
                        <h4><a href="{{ route('courseDetail', $enrollment->product->slug ?? '#') }}" style="text-decoration: none; color: inherit;">{{ $enrollment->product->name_en ?? $enrollment->product->name_bn ?? 'Course' }}</a></h4>
                        <div class="meta">
                            @if($enrollment->product->instructor)
                                <i class="fa-solid fa-chalkboard-user"></i>
                                <a href="{{ route('instructor.profile', $enrollment->product->instructor->id) }}" style="color:#6c5ce7; text-decoration:none; font-weight:600;">{{ $enrollment->product->instructor->name }}</a>
                                &middot;
                            @endif
                            <i class="fa-solid fa-book-open"></i> {{ $enrollment->product->lessons_count ?? 0 }} {{ __('frontend.dash.lessons') }}
                        </div>
                    </div>
                    @if($enrollment->status == 'active')
                        <a href="{{ route('courseDetail', $enrollment->product->slug ?? '#') }}" class="btn btn-primary btn-sm">Continue</a>
                    @else
                        <span class="status-pill status-pending">{{ ucfirst($enrollment->status) }}</span>
                    @endif
                </div>
                @endif
                @endforeach
            </div>
            @endif

            <div class="panel">
                <div class="panel-head">
                    <h3><i class="fa-solid fa-clock-rotate-left"></i> {{ __('frontend.dash.recent_orders') }}</h3>
                    <a href="#" onclick="switchTab('tab-orders-inline'); return false;">{{ __('frontend.dash.see_all') }}</a>
                </div>
                <div style="overflow-x: auto;">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>{{ __('frontend.dash.col_order_id') }}</th>
                                <th>{{ __('frontend.dash.col_date') }}</th>
                                <th>{{ __('frontend.dash.col_status') }}</th>
                                <th>{{ __('frontend.dash.col_total') }}</th>
                                <th>{{ __('frontend.dash.col_action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders->take(5) as $order)
                            <tr>
                                <td class="order-id">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                                <td style="color: var(--text-soft);">{{ $order->created_at->format('M d, Y') }}</td>
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
                            @empty
                            <tr>
                                <td colspan="5" class="empty-state">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                    <h5>{{ __('frontend.dash.no_orders') }}</h5>
                                    <a href="{{ route('shop') }}" class="btn btn-primary">{{ __('frontend.dash.shop_now') }}</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tab: Courses -->
        <div class="tab-content-item" id="tab-courses" style="display:none;">
            <div class="dash-head">
                <div>
                    <h1>{{ __('frontend.dash.nav_courses') }}</h1>
                    <p>{{ __('frontend.dash.my_courses_sub') }}</p>
                </div>
            </div>
            <div class="panel">
                @forelse($enrollments as $enrollment)
                @if($enrollment->product)
                @php
                    $product    = $enrollment->product;
                    $productUrl = $product->slug ? route('courseDetail', $product->slug) : '#';
                    $progress   = $courseProgress[$enrollment->product_id] ?? 0;
                    $hasCertificate = isset($userCertificates[$enrollment->product_id]);
                    $isCompleted    = $progress >= 100;
                @endphp
                <div class="course-row">
                    <a href="{{ $productUrl }}" class="thumb" style="--c1:#6c5ce7;--c2:#a29bfe; overflow: hidden; display: flex; align-items: center; justify-content: center; text-decoration: none;">
                        @if($product->fi() && $product->fi() !== 'not_found.png')
                            <img src="{{ route('imagecache', ['template' => 'sbixs', 'filename' => $product->fi()]) }}" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            {{ substr($product->name_en ?? 'C', 0, 1) }}
                        @endif
                    </a>
                    <div class="body">
                        <h4><a href="{{ $productUrl }}" style="text-decoration: none; color: inherit;">{{ $product->name_en ?? $product->name_bn ?? 'Course' }}</a></h4>
                        @if($product->instructor)
                        <div class="meta" style="display:flex; align-items:center; gap:8px; margin-top:4px;">
                            <span style="width:24px; height:24px; border-radius:50%; display:inline-flex; align-items:center; justify-content:center; background:#6c5ce7; color:#fff; font-size:10px; font-weight:700; overflow:hidden; background-size:cover; background-position:center; {{ $product->instructor->image ? "background-image:url('".asset('storage/users/'.$product->instructor->image)."');" : '' }}">
                                @if(!$product->instructor->image){{ strtoupper(substr($product->instructor->name, 0, 1)) }}@endif
                            </span>
                            <span>{{ __('frontend.dash.instructor') }}:
                                <a href="{{ route('instructor.profile', $product->instructor->id) }}" style="color:#6c5ce7; font-weight:600; text-decoration:none;">{{ $product->instructor->name }}</a>
                            </span>
                        </div>
                        @endif
                        <div class="meta">
                            <i class="fa-solid fa-book-open"></i> {{ $product->lessons_count ?? 0 }} {{ __('frontend.dash.lessons') }}
                        </div>
                        <div class="meta">
                            @if($enrollment->enrolled_at)
                                Enrolled: {{ $enrollment->enrolled_at->format('d M, Y') }}
                            @else
                                Enrolled: Pending
                            @endif
                            &middot; Status: {{ $isCompleted ? 'Completed' : ucfirst($enrollment->status) }}
                        </div>
                        <div style="margin-top:8px; background:#eef2f7; border-radius:20px; height:8px; width:100%; max-width:260px; overflow:hidden;">
                            <div style="height:8px; width:{{ $progress }}%; background:{{ $isCompleted ? '#16a34a' : '#6c5ce7' }};"></div>
                        </div>
                        <div class="meta" style="margin-top:4px;">{{ __('frontend.dash.progress') }} (Progress): {{ $progress }}%</div>
                    </div>
                    @if($isCompleted)
                        <a href="{{ route('user.certificate', $enrollment->product_id) }}" target="_blank" class="btn btn-success btn-sm">
                            <i class="fa-solid fa-certificate"></i> {{ $hasCertificate ? 'Download Certificate' : 'Get Certificate' }}
                        </a>
                    @elseif($enrollment->status == 'active')
                        <a href="{{ $productUrl }}" class="btn btn-primary btn-sm">Continue Learning</a>
                    @else
                        <span class="status-pill status-pending">{{ ucfirst($enrollment->status) }}</span>
                    @endif
                </div>
                @endif
                @empty
                <div class="empty-state">
                    <i class="fa-solid fa-graduation-cap"></i>
                    <h5>{{ __('frontend.dash.no_enrolled') }}</h5>
                    <a href="{{ route('courses') }}" class="btn btn-primary">{{ __('frontend.dash.view_courses') }}</a>
                </div>
                @endforelse
            </div>
        </div>
        <!-- Tab: My E-books -->
        <div class="tab-content-item" id="tab-ebooks" style="display:none;">
            <div class="dash-head">
                <div>
                    <h1>{{ __('frontend.dash.nav_ebooks') }}</h1>
                    <p>{{ __('frontend.dash.my_ebooks_sub') }}</p>
                </div>
            </div>
            <div class="panel">
                @forelse($ebookEnrollments as $enroll)
                @if($enroll->ebook)
                @php $ebook = $enroll->ebook; $isActive = $enroll->status === 'active'; @endphp
                <div class="course-row">
                    <a href="{{ route('ebooks.show', $ebook->id) }}" class="thumb" style="--c1:#0ea5e9;--c2:#38bdf8; overflow: hidden; display: flex; align-items: center; justify-content: center; text-decoration: none;">
                        @if($ebook->cover_image)
                            <img src="{{ asset('storage/ebook_covers/'.$ebook->cover_image) }}" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <i class="fa-solid fa-book-open"></i>
                        @endif
                    </a>
                    <div class="body">
                        <h4><a href="{{ route('ebooks.show', $ebook->id) }}" style="text-decoration: none; color: inherit;">{{ $ebook->title_bn ?? $ebook->title_en }}</a></h4>
                        <div class="meta">
                            <i class="fa-solid fa-pen-nib"></i> {{ $ebook->author_name ?? (__('frontend.dash.unknown')) }}
                        </div>
                        <div class="meta">
                            <i class="fa-solid fa-file-pdf"></i> PDF
                            @if($enroll->created_at)
                                &middot; {{ __('frontend.dash.purchased') }}: {{ $enroll->created_at->format('d M, Y') }}
                            @endif
                        </div>
                    </div>
                    @if($isActive)
                        <a href="{{ route('ebooks.read', $ebook->id) }}" target="_blank" class="btn btn-primary btn-sm">
                            <i class="fa-solid fa-book-reader"></i> {{ __('frontend.dash.read') }}
                        </a>
                    @else
                        <span class="status-pill status-pending">{{ __('frontend.dash.pending_approval') }}</span>
                    @endif
                </div>
                @endif
                @empty
                <div class="empty-state">
                    <i class="fa-solid fa-book-open"></i>
                    <h5>{{ __('frontend.dash.no_ebooks_bought') }}</h5>
                    <a href="{{ route('ebooks.index') }}" class="btn btn-primary">{{ __('frontend.dash.browse_ebooks') }}</a>
                </div>
                @endforelse
            </div>
        </div>
        <!-- Tab: Orders Inline -->
        <div class="tab-content-item" id="tab-orders-inline" style="display:none;">
            <div class="dash-head">
                <div>
                    <h1>{{ __('frontend.dash.all_orders_title') }}</h1>
                    <p>{{ __('frontend.dash.order_list_sub') }}</p>
                </div>
                <div class="filter-tabs">
                    <a href="{{ route('user.orders', ['type' => 'all']) }}" class="btn {{ (!isset($type) || $type == 'all') ? 'btn-primary' : 'btn-outline' }} btn-sm">{{ __('frontend.dash.filter_all') }}</a>
                    <a href="{{ route('user.orders', ['type' => 'today']) }}" class="btn {{ isset($type) && $type == 'today' ? 'btn-primary' : 'btn-outline' }} btn-sm">{{ __('frontend.dash.filter_today') }}</a>
                    <a href="{{ route('user.orders', ['type' => 'cancelled']) }}" class="btn {{ isset($type) && $type == 'cancelled' ? 'btn-primary' : 'btn-outline' }} btn-sm">{{ __('frontend.dash.filter_cancelled') }}</a>
                </div>
            </div>
            <div class="filter-tabs" style="margin-bottom:14px;">
                <button type="button" class="btn btn-primary btn-sm" id="ordViewInvoiceBtn" onclick="switchOrderView('invoice')">{{ __('frontend.dash.view_invoice') }}</button>
                <button type="button" class="btn btn-outline btn-sm" id="ordViewProductBtn" onclick="switchOrderView('product')">{{ __('frontend.dash.view_product') }}</button>
            </div>

            <div class="panel" id="orders-view-invoice">
                <div style="overflow-x: auto;">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>{{ __('frontend.dash.col_order_id') }}</th>
                                <th>{{ __('frontend.dash.col_date') }}</th>
                                <th>{{ __('frontend.dash.col_status') }}</th>
                                <th>{{ __('frontend.dash.col_total') }}</th>
                                <th>{{ __('frontend.dash.col_action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                            <tr>
                                <td class="order-id">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                                <td style="color: var(--text-soft);">{{ $order->created_at->format('M d, Y') }}</td>
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
                            @empty
                            <tr>
                                <td colspan="5" class="empty-state">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                    <h5>{{ __('frontend.dash.no_orders') }}</h5>
                                    <a href="{{ route('shop') }}" class="btn btn-primary">{{ __('frontend.dash.shop_now') }}</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($orders->hasPages())
                <div style="padding: 20px;">
                    {{ $orders->links() }}
                </div>
                @endif
            </div>

            <!-- Product-wise view -->
            <div class="panel" id="orders-view-product" style="display:none;">
                <div style="overflow-x: auto;">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>{{ __('frontend.dash.col_product') }}</th>
                                <th>{{ __('frontend.dash.col_order_id') }}</th>
                                <th>{{ __('frontend.dash.col_date') }}</th>
                                <th>{{ __('frontend.dash.col_qty') }}</th>
                                <th>{{ __('frontend.dash.col_price') }}</th>
                                <th>{{ __('frontend.dash.col_total') }}</th>
                                <th>{{ __('frontend.dash.col_status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(($orderItems ?? collect()) as $item)
                            <tr>
                                <td>{{ $item->product_name }}</td>
                                <td class="order-id">#{{ str_pad($item->order_id, 6, '0', STR_PAD_LEFT) }}</td>
                                <td style="color: var(--text-soft);">{{ optional($item->order)->created_at ? $item->order->created_at->format('M d, Y') : '' }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>৳{{ number_format($item->product_price) }}</td>
                                <td class="fw-bold">৳{{ number_format($item->total_cost) }}</td>
                                <td>
                                    @php $ps = strtolower(optional($item->order)->order_status ?? ''); @endphp
                                    <span class="status-pill {{ str_contains($ps,'pending') ? 'status-pending' : (str_contains($ps,'cancel') ? 'status-rejected' : 'status-approved') }}">
                                        {{ optional($item->order)->order_status }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="empty-state">
                                    <i class="fa-solid fa-box-open"></i>
                                    <h5>{{ __('frontend.dash.no_products') }}</h5>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>



        <!-- Tab: Address -->
        <div class="tab-content-item" id="tab-address" style="display:none;">
            <div class="dash-head">
                <div>
                    <h1>{{ __('frontend.dash.saved_address') }}</h1>
                    <p>{{ __('frontend.dash.address_sub') }}</p>
                </div>
            </div>
            <div class="dash-cols-custom">
                @php $dl = auth()->user()->locations()->first(); @endphp
                @if($dl)
                <div class="panel">
                    <div class="panel-head">
                        <h3><i class="fa-solid fa-location-dot"></i> {{ __('frontend.dash.delivery_address') }}</h3>
                        <a href="#" onclick="switchTab('tab-account'); return false;">{{ __('frontend.dash.change') }}</a>
                    </div>
                    <div style="padding: 20px;">
                        <p style="font-weight: 700; color: var(--primary); margin-bottom: 6px;">{{ $dl->name }}</p>
                        <p style="color: var(--text-soft); font-size: 14px; margin-bottom: 4px;">{{ $dl->address_title }}</p>
                        <p style="color: var(--text-muted); font-size: 13px;"><i class="fa-solid fa-phone me-1"></i> {{ $dl->mobile }}</p>
                        <p style="color: var(--text-muted); font-size: 13px;"><i class="fa-solid fa-map-pin me-1"></i> {{ $dl->address }}</p>
                    </div>
                </div>
                @else
                <div class="panel">
                    <div class="empty-state">
                        <i class="fa-solid fa-location-dot"></i>
                        <h5>{{ __('frontend.dash.no_address') }}</h5>
                        <p style="color: var(--text-muted); font-size: 14px;">{{ __('frontend.dash.no_address_sub') }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Tab: Account / Profile -->
        <div class="tab-content-item" id="tab-account" style="display:none;">
            <div class="dash-head">
                <div>
                    <h1>{{ __('frontend.dash.profile_title') }}</h1>
                    <p>{{ __('frontend.dash.profile_sub') }}</p>
                </div>
            </div>
            <div class="panel">
                <div style="padding: 20px 20px 0;">
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
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <form action="{{ route('user.changeMyInformation') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-4" style="padding: 20px;">
                        <div class="col-md-6">
                            <label class="custom-label">{{ __('frontend.dash.name') }}</label>
                            <input type="text" name="name" class="custom-input" value="{{ auth()->user()->name }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="custom-label">{{ __('frontend.dash.email') }}</label>
                            <input type="email" class="custom-input" value="{{ auth()->user()->email }}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="custom-label">{{ __('frontend.dash.mobile') }}</label>
                            <input type="text" name="mobile" class="custom-input" value="{{ auth()->user()->mobile }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="custom-label">{{ __('frontend.dash.father_name') }}</label>
                            <input type="text" name="father_name" class="custom-input" value="{{ auth()->user()->father_name }}">
                        </div>
                        <div class="col-md-6">
                            <label class="custom-label">{{ __('frontend.dash.dob') }}</label>
                            <input type="date" name="dob" class="custom-input" value="{{ auth()->user()->dob }}">
                        </div>
                        <div class="col-md-6">
                            <label class="custom-label">{{ __('frontend.dash.blood_group') }}</label>
                            <select name="blood_group" class="custom-input">
                                <option value="">{{ __('frontend.dash.select') }}</option>
                                @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bg)
                                    <option value="{{ $bg }}" {{ auth()->user()->blood_group == $bg ? 'selected' : '' }}>{{ $bg }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="custom-label">{{ __('frontend.dash.bkash') }}</label>
                            <input type="text" name="bkash_number" class="custom-input" value="{{ auth()->user()->bkash_number }}">
                        </div>
                        <div class="col-md-6">
                            <label class="custom-label">{{ __('frontend.dash.profile_photo') }}</label>
                            <input type="file" name="image" class="custom-input">
                        </div>
                        <div class="col-12">
                            <label class="custom-label">{{ __('frontend.dash.full_address') }}</label>
                            <textarea name="address" class="custom-input" rows="3">{{ auth()->user()->address }}</textarea>
                        </div>

                        <div class="col-12"><hr style="border-color: var(--border);"></div>

                        <div class="col-12">
                            <h5 style="font-weight: 700; color: var(--primary);">{{ __('frontend.dash.change_password') }}</h5>
                        </div>
                        <div class="col-12">
                            <label class="custom-label">{{ __('frontend.dash.current_password') }}</label>
                            <input type="password" name="old_password" class="custom-input" placeholder="{{ __('frontend.dash.current_pass_ph') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="custom-label">{{ __('frontend.dash.new_password') }}</label>
                            <input type="password" name="new_password" class="custom-input">
                        </div>
                        <div class="col-md-6">
                            <label class="custom-label">{{ __('frontend.dash.confirm_password') }}</label>
                            <input type="password" name="confirm_password" class="custom-input">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="action-btn">{{ __('frontend.dash.update_all') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tab: Featured Products -->
        <div class="tab-content-item" id="tab-featured" style="display:none;">
            <div class="dash-head">
                <div>
                    <h1>{{ __('frontend.dash.nav_featured') }}</h1>
                    <p>{{ __('frontend.dash.featured_sub') }}</p>
                </div>
            </div>
            <div class="row g-4">
                @forelse($featured_products as $product)
                <div class="col-md-6 col-xl-4">
                    <div class="course-card h-100" style="border-radius: var(--radius-lg) !important;">
                        <div class="course-thumb" style="--c1:#6c5ce7;--c2:#a29bfe;">
                            @if($product->active)
                                <span class="course-tag">AVAILABLE</span>
                            @endif
                            {{ substr($product->name_en ?? 'P', 0, 1) }}
                        </div>
                        <div class="course-body">
                            <h3>{{ $product->name_en }}</h3>
                            <div class="course-meta">
                                @if($product->price)
                                    <span><i class="fa-solid fa-tag"></i> ৳{{ number_format($product->price) }}</span>
                                @endif
                                @if($product->stock)
                                    <span><i class="fa-solid fa-box"></i> Stock: {{ $product->stock }}</span>
                                @endif
                            </div>
                            <div class="course-foot">
                                @if($product->price)
                                    <span class="price">৳{{ number_format($product->price) }}</span>
                                @endif
                                <a href="{{ route('productDetails', $product->slug) }}" class="btn btn-accent btn-sm">View</a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="empty-state">
                        <i class="fa-solid fa-star"></i>
                        <h5>{{ __('frontend.dash.no_featured') }}</h5>
                    </div>
                </div>
                @endforelse
            </div>
            @if($featured_products->hasPages())
            <div style="padding: 20px;">
                {{ $featured_products->links() }}
            </div>
            @endif
        </div>

        <!-- Tab: Exams -->
        <div class="tab-content-item" id="tab-exams" style="display:none;">
            <div class="dash-head">
                <div>
                    <h1>{{ __('frontend.dash.nav_exams') }}</h1>
                    <p>{{ __('frontend.dash.my_exams_sub') }}</p>
                </div>
            </div>
            
            <div class="panel mb-4">
                <div class="panel-head">
                    <h3><i class="fa-solid fa-file-pen"></i> {{ __('frontend.dash.available_exams') }}</h3>
                </div>
                @php $completedExamIds = $completed_exams->pluck('exam_id')->all(); @endphp
                @forelse($exams as $exam)
                @php
                    $isCompleted = in_array($exam->id, $completedExamIds);
                    $isUpcoming  = $exam->start_time && $exam->start_time->isFuture();
                    $isEnded     = $exam->end_time && $exam->end_time->isPast();
                @endphp
                <div class="course-row">
                    <div class="thumb" style="--c1:#6c5ce7;--c2:#a29bfe;">
                        E
                    </div>
                    <div class="body">
                        <h4>{{ $exam->title }}</h4>
                        <div class="meta">
                            <i class="far fa-clock"></i> {{ $exam->duration }} {{ __('frontend.dash.minutes') }} &middot;
                            <i class="far fa-calendar-alt"></i> {{ __('frontend.dash.ends') }}: {{ $exam->end_time->format('M d, h:i A') }}
                        </div>
                    </div>
                    @if($isCompleted)
                        @if($exam->status == 'finished')
                            <a href="{{ route('exams.result', $exam->id) }}" class="btn btn-success btn-sm">{{ __('frontend.dash.view_result') }}</a>
                        @else
                            <span class="status-pill status-approved">{{ __('frontend.dash.completed') }}</span>
                        @endif
                    @elseif($isUpcoming)
                        <span class="status-pill status-pending">{{ __('frontend.dash.upcoming') }}</span>
                    @elseif($isEnded)
                        <span class="status-pill status-pending">{{ __('frontend.dash.ended') }}</span>
                    @else
                        <a href="{{ route('exams.start', $exam->id) }}" class="btn btn-primary btn-sm">{{ __('frontend.dash.participate') }}</a>
                    @endif
                </div>
                @empty
                <div class="empty-state">
                    <h5>{{ __('frontend.dash.no_exams_title') }}</h5>
                </div>
                @endforelse
            </div>

            <div class="panel">
                <div class="panel-head">
                    <h3><i class="fa-solid fa-check-double"></i> {{ __('frontend.dash.completed_exams_panel') }}</h3>
                </div>
                <div style="overflow-x: auto;">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>{{ __('frontend.dash.col_exam') }}</th>
                                <th>{{ __('frontend.dash.col_date') }}</th>
                                <th>{{ __('frontend.dash.col_marks') }}</th>
                                <th>{{ __('frontend.dash.col_status') }}</th>
                                <th>{{ __('frontend.dash.col_action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($completed_exams as $attempt)
                            <tr>
                                <td>{{ $attempt->exam->title }}</td>
                                <td>{{ $attempt->end_time->format('M d, Y') }}</td>
                                <td>{{ $attempt->score }} / {{ $attempt->exam->question_count }}</td>
                                <td>
                                    @if($attempt->exam->status == 'finished')
                                        <span class="status-pill status-approved">{{ __('frontend.dash.result_published') }}</span>
                                    @else
                                        <span class="status-pill status-pending">{{ __('frontend.dash.pending') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('exams.result', $attempt->exam->id) }}" class="btn btn-primary btn-sm">{{ __('frontend.dash.details') }}</a>
                                    @if($attempt->exam->status == 'finished')
                                        <a href="{{ route('user.exam_certificate', $attempt->exam->id) }}" target="_blank" class="btn btn-success btn-sm">
                                            <i class="fa-solid fa-certificate"></i> {{ __('frontend.dash.certificate') }}
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="empty-state">{{ __('frontend.dash.no_attempt') }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if(auth()->user()->hasRole('instructor') || auth()->user()->role === 'instructor' || auth()->user()->hasRole('teacher') || auth()->user()->role === 'teacher')
        <!-- Tab: Teacher Questions -->
        <div class="tab-content-item" id="tab-teacher-questions" style="display:none;">
            <div class="dash-head">
                <div>
                    <h1>Manage Questions</h1>
                    <p>Your personal question bank ({{ $teacher_questions_count }} questions)</p>
                </div>
                <div style="display: flex; gap: 10px;">
                    <a href="{{ asset('100_plus_mcq_questions.csv') }}" class="btn btn-outline-info" download>
                        <i class="fa-solid fa-download"></i> Demo CSV
                    </a>
                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#bulkUploadModal">
                        <i class="fa-solid fa-file-import"></i> Bulk Upload
                    </button>
                    <a href="{{ route('teacher.questions.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Create New Question</a>
                </div>
            </div>
            <div class="panel">
                <div style="overflow-x: auto;">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>Question Text</th>
                                <th>Correct Option</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($teacher_questions as $question)
                            <tr>
                                <td>{{ Str::limit($question->question_text, 100) }}</td>
                                <td><span class="status-pill status-approved">{{ strtoupper($question->correct_option) }}</span></td>
                                <td>
                                    <div class="btn-group-custom">
                                        <a href="{{ route('teacher.questions.edit', $question->id) }}" class="btn-circle" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <form action="{{ route('teacher.questions.destroy', $question->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            <button type="submit" class="btn-circle text-danger" title="Delete"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="empty-state">You haven't created any questions yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div style="padding: 20px;">
                    {{ $teacher_questions->appends(['activeTab' => 'teacher_questions'])->links() }}
                </div>
            </div>
        </div>

        <!-- Tab: Teacher Exams -->
        <div class="tab-content-item" id="tab-teacher-exams" style="display:none;">
            <div class="dash-head">
                <div>
                    <h1>Manage Exams</h1>
                    <p>Exams created by you ({{ $teacher_exams_count }} exams)</p>
                </div>
                <a href="{{ route('teacher.exams.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Create New Exam</a>
            </div>
            <div class="panel">
                <div style="overflow-x: auto;">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>Exam Title</th>
                                <th>Schedule</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($teacher_exams as $exam)
                            <tr>
                                <td><strong>{{ $exam->title }}</strong></td>
                                <td style="font-size: 12px; color: var(--text-soft);">
                                    {{ $exam->start_time->format('M d, h:i A') }} -<br>
                                    {{ $exam->end_time->format('M d, h:i A') }}
                                </td>
                                <td>
                                    @php
                                        $statusClass = $exam->status == 'published' ? 'status-approved' : ($exam->status == 'finished' ? 'status-rejected' : 'status-pending');
                                    @endphp
                                    <span class="status-pill {{ $statusClass }}">{{ ucfirst($exam->status) }}</span>
                                </td>
                                <td>
                                    <div class="btn-group-custom">
                                        <a href="{{ route('teacher.exams.edit', $exam->id) }}" class="btn-circle" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="{{ route('teacher.exams.select-questions', $exam->id) }}" class="btn-circle" title="Select Questions"><i class="fa-solid fa-list-check"></i></a>
                                        <a href="{{ route('teacher.exams.results', $exam->id) }}" class="btn-circle" title="View Results"><i class="fa-solid fa-chart-bar"></i></a>
                                        @if($exam->status == 'published')
                                        <form action="{{ route('teacher.exams.finish', $exam->id) }}" method="POST" onsubmit="return confirm('Finish this exam? Results will be released to students.')">
                                            @csrf
                                            <button type="submit" class="btn-circle text-info" title="Finish Exam"><i class="fa-solid fa-flag-checkered"></i></button>
                                        </form>
                                        @endif
                                        <form action="{{ route('teacher.exams.destroy', $exam->id) }}" method="POST" onsubmit="return confirm('Delete this exam?')">
                                            @csrf
                                            <button type="submit" class="btn-circle text-danger" title="Delete"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="empty-state">You haven't created any exams yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div style="padding: 20px;">
                    {{ $teacher_exams->appends(['activeTab' => 'teacher_exams'])->links() }}
                </div>
            </div>
        </div>
        @endif

    </section>
</div>

<!-- Bulk Upload Modal -->
<div class="modal fade" id="bulkUploadModal" tabindex="-1" aria-labelledby="bulkUploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 15px;">
            <form action="{{ route('teacher.questions.bulk-upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="bulkUploadModalLabel">Bulk Upload Questions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="alert alert-info" style="font-size: 13px;">
                        <i class="fa-solid fa-circle-info"></i> Please use our demo CSV format. The first row should be headers: <strong>Question, Option_A, Option_B, Option_C, Option_D, Correct_Answer</strong>.
                    </div>
                    <div class="form-group">
                        <label class="custom-label">Select File (.csv, .xlsx, .xls)</label>
                        <input type="file" name="file" class="custom-input" required accept=".csv, .xlsx, .xls">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Start Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Tab switching
    function switchOrderView(view) {
        var inv = document.getElementById('orders-view-invoice');
        var prod = document.getElementById('orders-view-product');
        var invBtn = document.getElementById('ordViewInvoiceBtn');
        var prodBtn = document.getElementById('ordViewProductBtn');
        if (view === 'product') {
            if (inv) inv.style.display = 'none';
            if (prod) prod.style.display = 'block';
            if (prodBtn) { prodBtn.classList.add('btn-primary'); prodBtn.classList.remove('btn-outline'); }
            if (invBtn) { invBtn.classList.add('btn-outline'); invBtn.classList.remove('btn-primary'); }
        } else {
            if (inv) inv.style.display = 'block';
            if (prod) prod.style.display = 'none';
            if (invBtn) { invBtn.classList.add('btn-primary'); invBtn.classList.remove('btn-outline'); }
            if (prodBtn) { prodBtn.classList.add('btn-outline'); prodBtn.classList.remove('btn-primary'); }
        }
    }

    function switchTab(tabId) {
        // Hide all tabs
        document.querySelectorAll('.tab-content-item').forEach(function(el) {
            el.style.display = 'none';
        });
        // Show target tab
        var target = document.getElementById(tabId);
        if (target) {
            target.style.display = 'block';
        }
        // Update nav active states
        document.querySelectorAll('#dashNav a[data-tab]').forEach(function(link) {
            link.classList.remove('active');
            if (link.getAttribute('data-tab') === tabId) {
                link.classList.add('active');
            }
        });
        // Update URL hash
        window.location.hash = '#' + tabId;
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Click handlers for nav links with data-tab
        document.querySelectorAll('#dashNav a[data-tab]').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                var tabId = this.getAttribute('data-tab');
                switchTab(tabId);
            });
        });

        // Determine which tab to show on page load
        // Priority: URL hash > activeTab from server > default (dashboard)
        var hash = window.location.hash.replace('#', '');
        if (hash && document.getElementById(hash)) {
            switchTab(hash);
        } else if ('{{ $activeTab }}' === 'order') {
            switchTab('tab-orders-inline');
        } else if ('{{ $activeTab }}' === 'edit') {
            switchTab('tab-account');
        } else if ('{{ $activeTab }}' === 'address') {
            switchTab('tab-address');
        } else if ('{{ $activeTab }}' === 'feature_products') {
            switchTab('tab-featured');
        } else if ('{{ $activeTab }}' === 'courses') {
            switchTab('tab-courses');
        } else if ('{{ $activeTab }}' === 'exams') {
            switchTab('tab-exams');
        } else if ('{{ $activeTab }}' === 'teacher_questions') {
            switchTab('tab-teacher-questions');
        } else if ('{{ $activeTab }}' === 'teacher_exams') {
            switchTab('tab-teacher-exams');
        } else {
            switchTab('tab-dashboard');
        }
    });
</script>
@endsection

@push('js')
<script>
    // Keep any existing page-specific JS here
</script>
@endpush
