@extends('admin.master')

@section('title')
    LMS & Shop Admin Dashboard | {{ env('APP_NAME') }}
@endsection

@section('body')
<style>
    /* Compact, modern stat cards (scoped to dashboard) */
    .col-lg-3.col-6 .card { border-radius: 12px !important; }
    .col-lg-3.col-6 .card-body { padding: 13px 15px !important; }
    .col-lg-3.col-6 .card-body .p-4 { padding: 0 !important; }
    .col-lg-3.col-6 .symbol { width: 40px !important; height: 40px !important; flex-shrink: 0; }
    .col-lg-3.col-6 .symbol-label { width: 40px; height: 40px; display: inline-flex; align-items: center; justify-content: center; border-radius: 10px; background: rgba(0,0,0,.04); }
    .col-lg-3.col-6 .symbol.me-4 { margin-right: 12px !important; }
    .col-lg-3.col-6 .fs-3 { font-size: 1rem !important; }
    .col-lg-3.col-6 .fs-4 { font-size: 1.25rem !important; font-weight: 800 !important; }
    .col-lg-3.col-6 .card-body .small { font-size: 11.5px !important; }
    .col-lg-3.col-6 .card-footer { padding: 5px !important; font-size: 11.5px !important; }
    .col-lg-3.col-6 .card.transition-hover { transition: box-shadow .2s ease, transform .2s ease; }
    .col-lg-3.col-6 .card.transition-hover:hover { box-shadow: 0 6px 16px rgba(0,0,0,.08); transform: translateY(-2px); }
</style>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-4 align-items-center">
            <div class="col-sm-6">
                <h1 class="m-0 fw-bold text-dark">Admin Dashboard</h1>
                <p class="text-muted mb-0">Unified management for your E-Learning and E-Commerce platform.</p>
            </div>
            <div class="col-sm-6 text-sm-right mt-3 mt-sm-0">
                <div class="btn-group shadow-sm rounded-pill overflow-hidden">
                    <a href="{{ route('admin.courseCreate') }}?type=course" class="btn btn-primary px-4">
                        <i class="fas fa-graduation-cap me-2"></i> New Course
                    </a>
                    <a href="{{ route('admin.productCreate') }}?type=product" class="btn btn-outline-primary px-4">
                        <i class="fas fa-box me-2"></i> New Product
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        
        {{-- Section Header: E-Learning --}}
        <div class="d-flex align-items-center mb-3">
            <h5 class="fw-bold mb-0 text-primary"><i class="fas fa-book-reader me-2"></i> E-Learning Overview</h5>
            <hr class="flex-grow-1 ms-3 opacity-25">
        </div>

        <div class="row mb-4">
            <div class="col-lg-3 col-6 mb-3">
                <div class="card h-100 border-0 shadow-sm transition-hover rounded-4">
                    <div class="card-body p-4 d-flex align-items-center">
                        <div class="symbol symbol-50px symbol-light-primary me-4">
                            <span class="symbol-label">
                                <i class="fas fa-graduation-cap text-primary fs-3"></i>
                            </span>
                        </div>
                        <div class="p-4">
                            <span class="text-muted fw-bold d-block small">Total Courses</span>
                            <span class="text-dark fw-bolder fs-4">{{ $totalCourses }}</span>
                        </div>
                    </div>
                    <a href="{{ route('admin.productsAll') }}?type=course" class="card-footer bg-light py-2 text-center text-decoration-none small fw-bold">Manage <i class="fas fa-chevron-right ms-1"></i></a>
                </div>
            </div>
            
            <div class="col-lg-3 col-6 mb-3">
                <div class="card h-100 border-0 shadow-sm transition-hover rounded-4">
                    <div class="card-body p-4 d-flex align-items-center">
                        <div class="symbol symbol-50px symbol-light-success me-4">
                            <span class="symbol-label">
                                <i class="fas fa-chalkboard-teacher text-success fs-3"></i>
                            </span>
                        </div>
                        <div class="p-4">
                            <span class="text-muted fw-bold d-block small">Instructors</span>
                            <span class="text-dark fw-bolder fs-4">{{ $totalInstructors }}</span>
                        </div>
                    </div>
                    <a href="{{ route('admin.instructors.index') }}" class="card-footer bg-light py-2 text-center text-decoration-none small fw-bold">View All <i class="fas fa-chevron-right ms-1"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6 mb-3">
                <div class="card h-100 border-0 shadow-sm transition-hover rounded-4">
                    <div class="card-body p-4 d-flex align-items-center">
                        <div class="symbol symbol-50px symbol-light-info me-4">
                            <span class="symbol-label">
                                <i class="fas fa-user-graduate text-info fs-3"></i>
                            </span>
                        </div>
                        <div class="p-4">
                            <span class="text-muted fw-bold d-block small">Total Enrollments</span>
                            <span class="text-dark fw-bolder fs-4">{{ $totalEnrollments }}</span>
                        </div>
                    </div>
                    <a href="{{ route('admin.enrollments.index') }}" class="card-footer bg-light py-2 text-center text-decoration-none small fw-bold">Reports <i class="fas fa-chevron-right ms-1"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6 mb-3">
                <div class="card h-100 border-0 shadow-sm transition-hover rounded-4 bg-light-warning">
                    <div class="card-body p-4 d-flex align-items-center">
                        <div class="symbol symbol-50px symbol-light-warning me-4">
                            <span class="symbol-label">
                                <i class="fas fa-clock text-warning fs-3"></i>
                            </span>
                        </div>
                        <div class="p-4">
                            <span class="text-muted fw-bold d-block small">Pending Requests</span>
                            <span class="text-dark fw-bolder fs-4">{{ $pendingEnrollments }}</span>
                        </div>
                    </div>
                    <a href="{{ route('admin.enrollments.index') }}?status=pending" class="card-footer bg-warning py-2 text-center text-decoration-none small fw-bold text-dark">Review Now <i class="fas fa-chevron-right ms-1"></i></a>
                </div>
            </div>
        </div>

        {{-- Section Header: Exams --}}
        <div class="d-flex align-items-center mb-3">
            <h5 class="fw-bold mb-0 text-info"><i class="fas fa-file-pen me-2"></i> Exam Overview</h5>
            <hr class="flex-grow-1 ms-3 opacity-25">
        </div>

        <div class="row mb-4">
            <div class="col-lg-3 col-6 mb-3">
                <div class="card h-100 border-0 shadow-sm transition-hover rounded-4">
                    <div class="card-body p-4 d-flex align-items-center">
                        <div class="symbol symbol-50px symbol-light-info me-4">
                            <span class="symbol-label"><i class="fas fa-file-pen text-info fs-3"></i></span>
                        </div>
                        <div class="p-4">
                            <span class="text-muted fw-bold d-block small">Total Exams</span>
                            <span class="text-dark fw-bolder fs-4">{{ $totalExams }}</span>
                        </div>
                    </div>
                    <a href="{{ route('admin.exams.index') }}" class="card-footer bg-light py-2 text-center text-decoration-none small fw-bold">Manage <i class="fas fa-chevron-right ms-1"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6 mb-3">
                <div class="card h-100 border-0 shadow-sm transition-hover rounded-4">
                    <div class="card-body p-4 d-flex align-items-center">
                        <div class="symbol symbol-50px symbol-light-success me-4">
                            <span class="symbol-label"><i class="fas fa-circle-check text-success fs-3"></i></span>
                        </div>
                        <div class="p-4">
                            <span class="text-muted fw-bold d-block small">Published Exams</span>
                            <span class="text-dark fw-bolder fs-4">{{ $publishedExams }}</span>
                        </div>
                    </div>
                    <a href="{{ route('admin.exams.index') }}" class="card-footer bg-light py-2 text-center text-decoration-none small fw-bold">View <i class="fas fa-chevron-right ms-1"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6 mb-3">
                <div class="card h-100 border-0 shadow-sm transition-hover rounded-4">
                    <div class="card-body p-4 d-flex align-items-center">
                        <div class="symbol symbol-50px symbol-light-primary me-4">
                            <span class="symbol-label"><i class="fas fa-user-check text-primary fs-3"></i></span>
                        </div>
                        <div class="p-4">
                            <span class="text-muted fw-bold d-block small">Exam Attempts</span>
                            <span class="text-dark fw-bolder fs-4">{{ $totalExamAttempts }}</span>
                        </div>
                    </div>
                    <a href="{{ route('admin.exams.index') }}" class="card-footer bg-light py-2 text-center text-decoration-none small fw-bold">Results <i class="fas fa-chevron-right ms-1"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6 mb-3">
                <div class="card h-100 border-0 shadow-sm transition-hover rounded-4">
                    <div class="card-body p-4 d-flex align-items-center">
                        <div class="symbol symbol-50px symbol-light-warning me-4">
                            <span class="symbol-label"><i class="fas fa-circle-question text-warning fs-3"></i></span>
                        </div>
                        <div class="p-4">
                            <span class="text-muted fw-bold d-block small">Question Bank</span>
                            <span class="text-dark fw-bolder fs-4">{{ $totalQuestions }}</span>
                        </div>
                    </div>
                    <a href="{{ route('admin.questions.index') }}" class="card-footer bg-light py-2 text-center text-decoration-none small fw-bold">Manage <i class="fas fa-chevron-right ms-1"></i></a>
                </div>
            </div>
        </div>

        {{-- Section Header: E-Commerce --}}
        <div class="d-flex align-items-center mb-3">
            <h5 class="fw-bold mb-0 text-success"><i class="fas fa-shopping-bag me-2"></i> E-Commerce Overview</h5>
            <hr class="flex-grow-1 ms-3 opacity-25">
        </div>

        <div class="row mb-5">
            <div class="col-lg-3 col-6 mb-3">
                <div class="card h-100 border-0 shadow-sm transition-hover rounded-4">
                    <div class="card-body p-4 d-flex align-items-center">
                        <div class="symbol symbol-50px symbol-light-danger me-4">
                            <span class="symbol-label">
                                <i class="fas fa-shopping-cart text-danger fs-3"></i>
                            </span>
                        </div>
                        <div class="p-4">
                            <span class="text-muted fw-bold d-block small">Today's Orders</span>
                            <span class="text-dark fw-bolder fs-4">{{ $todayOrders }}</span>
                        </div>
                    </div>
                    <a href="{{ route('admin.orderList', ['date_from' => now()->toDateString(), 'date_to' => now()->toDateString()]) }}" class="card-footer bg-light py-2 text-center text-decoration-none small fw-bold">View <i class="fas fa-chevron-right ms-1"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6 mb-3">
                <div class="card h-100 border-0 shadow-sm transition-hover rounded-4">
                    <div class="card-body p-4 d-flex align-items-center">
                        <div class="symbol symbol-50px symbol-light-info me-4">
                            <span class="symbol-label">
                                <i class="fas fa-box text-info fs-3"></i>
                            </span>
                        </div>
                        <div class="p-4">
                            <span class="text-muted fw-bold d-block small">Active Products</span>
                            <span class="text-dark fw-bolder fs-4">{{ $productcount }}</span>
                        </div>
                    </div>
                    <a href="{{ route('admin.productsAll') }}?type=product" class="card-footer bg-light py-2 text-center text-decoration-none small fw-bold">Manage <i class="fas fa-chevron-right ms-1"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6 mb-3">
                <div class="card h-100 border-0 shadow-sm transition-hover rounded-4">
                    <div class="card-body p-4 d-flex align-items-center">
                        <div class="symbol symbol-50px symbol-light-warning me-4">
                            <span class="symbol-label">
                                <i class="fas fa-hourglass-half text-warning fs-3"></i>
                            </span>
                        </div>
                        <div class="p-4">
                            <span class="text-muted fw-bold d-block small">Pending Orders</span>
                            <span class="text-dark fw-bolder fs-4">{{ $pendingOrders }}</span>
                        </div>
                    </div>
                    <a href="{{ route('admin.orderList', ['status' => 'pending']) }}" class="card-footer bg-light py-2 text-center text-decoration-none small fw-bold">Review <i class="fas fa-chevron-right ms-1"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6 mb-3">
                <div class="card h-100 border-0 shadow-sm transition-hover rounded-4 bg-primary text-white">
                    <div class="card-body p-4 d-flex align-items-center">
                        <div class="symbol symbol-50px bg-dark bg-opacity-25 me-4">
                            <span class="symbol-label ">
                                <i class="fas fa-wallet text-white fs-3 "></i>
                            </span>
                        </div>
                        <div class="p-4">
                            <span class="text-white-50 fw-bold d-block small">Paid Revenue</span>
                            <span class="text-white fw-bolder fs-4">{{ number_format($totalRevenue, 0) }} ৳</span>
                        </div>
                    </div>
                    <a href="{{ route('admin.productSalesReport') }}" class="card-footer bg-dark bg-opacity-25 py-2 text-center text-decoration-none small fw-bold text-white">Sales Report <i class="fas fa-chevron-right ms-1"></i></a>
                </div>
            </div>
        </div>

        
        {{-- Recent Exams --}}
        <div class="card border-0 shadow-sm rounded-4 mb-5">
            <div class="card-header bg-white border-0 d-flex align-items-center justify-content-between">
                <h6 class="fw-bold mb-0"><i class="fas fa-clock-rotate-left text-info me-2"></i> Recent Exams</h6>
                <a href="{{ route('admin.exams.index') }}" class="small fw-bold text-decoration-none">View All <i class="fas fa-chevron-right ms-1"></i></a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th class="pl-3">Title</th>
                                <th class="text-center">Questions</th>
                                <th class="text-center">Duration</th>
                                <th class="text-center">Attempts</th>
                                <th>Status</th>
                                <th>End Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentExams as $exam)
                            <tr>
                                <td class="pl-3 fw-bold">{{ $exam->title }}</td>
                                <td class="text-center">{{ $exam->question_count }}</td>
                                <td class="text-center">{{ $exam->duration }} min</td>
                                <td class="text-center"><span class="badge badge-primary">{{ $exam->attempts_count }}</span></td>
                                <td>
                                    @php $st = $exam->status; $stClass = $st=='published' ? 'badge-success' : ($st=='finished' ? 'badge-info' : 'badge-secondary'); @endphp
                                    <span class="badge {{ $stClass }}">{{ ucfirst($st) }}</span>
                                </td>
                                <td class="small text-muted">{{ optional($exam->end_time)->format('d M Y, h:i A') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center text-muted py-3">No exams created yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{-- Detailed Data Section --}}
        <div class="row mt-4">
            {{-- Recent Enrollments --}}
            <div class="col-md-7">
                <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-4">
                    <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
                        <h3 class="card-title fw-bold mb-0">Recent Enrollments</h3>
                        <a href="{{ route('admin.enrollments.index') }}" class="btn btn-sm btn-light-primary rounded-pill px-3 fw-bold">All Requests</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table m-0 table-hover align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4">Student</th>
                                        <th>Course</th>
                                        <th>Status</th>
                                        <th class="text-end pe-4">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentEnrollments as $enrollment)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex flex-column">
                                                <span class="text-dark fw-bold">{{ $enrollment->user->name ?? 'User' }}</span>
                                                <span class="text-muted small">{{ $enrollment->user->email ?? '' }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-muted small fw-bold">{{ Str::limit($enrollment->product->name_en ?? 'N/A', 25) }}</span>
                                        </td>
                                        <td>
                                            <span class="badge rounded-pill px-3 {{ $enrollment->status == 'pending' ? 'bg-warning text-dark' : ($enrollment->status == 'active' ? 'bg-success' : 'bg-danger') }}">
                                                {{ ucfirst($enrollment->status) }}
                                            </span>
                                        </td>
                                        <td class="text-end pe-4 text-muted small">{{ $enrollment->created_at ? $enrollment->created_at->format('d M') : '-' }}</td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="4" class="text-center py-4 text-muted">No recent enrollments.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Recent Orders --}}
                <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-4">
                    <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
                        <h3 class="card-title fw-bold mb-0 text-success">Recent Shop Orders</h3>
                        <a href="{{ route('admin.orderList') }}" class="btn btn-sm btn-light-success rounded-pill px-3 fw-bold">All Orders</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table m-0 table-hover align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4">ID</th>
                                        <th>Customer</th>
                                        <th>Total</th>
                                        <th class="text-end pe-4">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentOrders as $order)
                                    <tr>
                                        <td class="ps-4 fw-bold">#{{ $order->id }}</td>
                                        <td>{{ Str::limit($order->name, 20) }}</td>
                                        <td class="fw-bold">{{ number_format($order->grand_total, 0) }} ৳</td>
                                        <td class="text-end pe-4">
                                            <span class="badge {{ $order->order_status == 'pending' ? 'bg-light-warning text-warning' : 'bg-light-success text-success' }} px-3 rounded-pill">
                                                {{ ucfirst($order->order_status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="4" class="text-center py-4 text-muted">No recent orders.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Latest Courses & Quick Links --}}
            <div class="col-md-5">
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-header bg-white py-3">
                        <h3 class="card-title fw-bold mb-0">Latest Courses</h3>
                    </div>
                    <div class="card-body p-4">
                        @foreach($recentCourses as $course)
                        <div class="d-flex align-items-center mb-4" style="margin-left: .5rem;">
                            <div class="me-3">
                                <img src="{{ route('imagecache', ['template' => 'sbixs', 'filename' => $course->fi()]) }}" alt="" class="rounded-3 shadow-sm" style="width: 65px; height: 45px; object-fit: cover;">
                            </div>
                            <div class="flex-grow-1">
                                <a href="{{ route('admin.productEdit', $course) }}" class="text-dark fw-bold text-hover-primary mb-1 d-block">{{ Str::limit($course->name_en, 30) }}</a>
                                <div class="d-flex align-items-center">
                                    <span class="text-primary fw-bold me-3">{{ $course->selling_price }} ৳</span>
                                    <span class="text-muted small"><i class="fas fa-users me-1"></i> {{ $course->enrollments_count ?? 0 }} Students</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="card-footer bg-white border-0 text-center py-3">
                        <a href="{{ route('admin.productsAll') }}?type=course" class="btn btn-sm btn-light fw-bold rounded-pill px-4">All Courses</a>
                    </div>
                </div>

                {{-- Quick Actions --}}
                <div class="card shadow-sm border-0 rounded-4 bg-gradient-dark text-white p-4">
                    <h5 class="fw-bold mb-3">Quick Actions</h5>
                    <div class="row g-2">
                        <div class="col-6 p-2">
                            <a href="{{ route('admin.all_user') }}" class="btn btn-dark w-100 text-start py-3 rounded-3 border-0 bg-white bg-opacity-10">
                                <i class="fas fa-users-cog d-block mb-2 fs-4 text-info"></i>
                                <span class="fw-bold small">Manage Users</span>
                            </a>
                        </div>
                        <div class="col-6 p-2">
                            <a href="{{ route('websiteparam') }}" class="btn btn-dark w-100 text-start py-3 rounded-3 border-0 bg-white bg-opacity-10">
                                <i class="fas fa-cogs d-block mb-2 fs-4 text-warning"></i>
                                <span class="fw-bold small">Settings</span>
                            </a>
                        </div>
                        <div class="col-6 p-2">
                            <a href="{{ route('admin.lessons.index', ['product' => 0]) }}" class="btn btn-dark w-100 text-start py-3 rounded-3 border-0 bg-white bg-opacity-10">
                                <i class="fas fa-play-circle d-block mb-2 fs-4 text-danger"></i>
                                <span class="fw-bold small">Manage Lessons</span>
                            </a>
                        </div>
                        <div class="col-6 p-2">
                            <a href="{{ route('admin.exams.index') }}" class="btn btn-dark w-100 text-start py-3 rounded-3 border-0 bg-white bg-opacity-10">
                                <i class="fas fa-file-alt d-block mb-2 fs-4 text-primary"></i>
                                <span class="fw-bold small">Quiz/Exams</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .rounded-4 { border-radius: 1rem !important; }
    .transition-hover { transition: all 0.25s ease-in-out; }
    .transition-hover:hover { transform: translateY(-5px); box-shadow: 0 1rem 3rem rgba(0,0,0,0.1) !important; }
    
    .symbol-50px { width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border-radius: 12px; }
    .symbol-light-primary { background-color: #E3F2FD; }
    .symbol-light-success { background-color: #E8F5E9; }
    .symbol-light-info { background-color: #E0F7FA; }
    .symbol-light-warning { background-color: #FFF3E0; }
    .symbol-light-danger { background-color: #FFEBEE; }
    
    .bg-light-warning { background-color: #fdfae9 !important; }
    .bg-light-success { background-color: #ebfaf0 !important; }
    .btn-light-primary { background-color: #eef3ff; color: #009ef7; }
    .btn-light-primary:hover { background-color: #009ef7; color: white; }
    .btn-light-success { background-color: #e8fff3; color: #50cd89; }
    .btn-light-success:hover { background-color: #50cd89; color: white; }
    
    .bg-gradient-dark { background: linear-gradient(135deg, #2c3e50 0%, #000000 100%); }
    .text-hover-primary:hover { color: #009ef7 !important; }
</style>
@endsection
