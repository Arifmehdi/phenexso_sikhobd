@extends('admin.master')

@section('title')
    Unified Dashboard | {{ env('APP_NAME') }}
@endsection

@section('body')
<div class="content-header">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="m-0 fw-bolder text-dark" style="font-size: 1.8rem;">Dashboard</h1>
                <p class="text-muted small mb-0">Overview of your platform's performance and growth.</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-white shadow-sm rounded-pill px-4 text-primary fw-bold border">
                    <i class="fas fa-download me-2"></i> Report
                </button>
                <div class="dropdown">
                    <button class="btn btn-primary shadow rounded-pill px-4 fw-bold dropdown-toggle" data-toggle="dropdown">
                        <i class="fas fa-plus me-2"></i> Add New
                    </button>
                    <div class="dropdown-menu dropdown-menu-right rounded-4 border-0 shadow-lg">
                        <a class="dropdown-item py-2" href="{{ route('admin.productCreate') }}?type=course"><i class="fas fa-graduation-cap me-2 text-primary"></i> Course</a>
                        <a class="dropdown-item py-2" href="{{ route('admin.productCreate') }}?type=product"><i class="fas fa-box me-2 text-success"></i> Product</a>
                        <a class="dropdown-item py-2" href="{{ route('admin.instructors.create') }}"><i class="fas fa-user-tie me-2 text-info"></i> Instructor</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        
        {{-- E-Learning Top Cards --}}
        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-soft rounded-4 h-100 overflow-hidden">
                    <div class="card-body p-3 position-relative">
                        <div class="d-flex align-items-center mb-2">
                            <div class="icon-shape bg-soft-primary rounded-3 text-primary me-3" style="width: 40px; height: 40px; font-size: 1rem;">
                                <i class="fas fa-book-open"></i>
                            </div>
                            <span class="text-muted fw-bold small uppercase" style="font-size: 0.7rem;">Courses</span>
                        </div>
                        <h3 class="fw-bolder mb-1">{{ $totalCourses }}</h3>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-soft-success text-success rounded-pill px-2 py-0 small me-2" style="font-size: 0.65rem;">+12%</span>
                            <span class="text-muted" style="font-size: 0.7rem;">monthly growth</span>
                        </div>
                        <div class="glass-decoration bg-primary"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-soft rounded-4 h-100 overflow-hidden">
                    <div class="card-body p-3 position-relative">
                        <div class="d-flex align-items-center mb-2">
                            <div class="icon-shape bg-soft-success rounded-3 text-success me-3" style="width: 40px; height: 40px; font-size: 1rem;">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <span class="text-muted fw-bold small uppercase" style="font-size: 0.7rem;">Students</span>
                        </div>
                        <h3 class="fw-bolder mb-1">{{ $totalEnrollments }}</h3>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-soft-info text-info rounded-pill px-2 py-0 small me-2" style="font-size: 0.65rem;">+5.4%</span>
                            <span class="text-muted" style="font-size: 0.7rem;">new enrollments</span>
                        </div>
                        <div class="glass-decoration bg-success"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-soft rounded-4 h-100 overflow-hidden">
                    <div class="card-body p-3 position-relative">
                        <div class="d-flex align-items-center mb-2">
                            <div class="icon-shape bg-soft-warning rounded-3 text-warning me-3" style="width: 40px; height: 40px; font-size: 1rem;">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                            <span class="text-muted fw-bold small uppercase" style="font-size: 0.7rem;">Instructors</span>
                        </div>
                        <h3 class="fw-bolder mb-1">{{ $totalInstructors }}</h3>
                        <span class="text-muted" style="font-size: 0.7rem;">Active educators</span>
                        <div class="glass-decoration bg-warning"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-soft rounded-4 h-100 overflow-hidden bg-dark text-white shadow-lg">
                    <div class="card-body p-3 position-relative">
                        <div class="d-flex align-items-center mb-2 opacity-75">
                            <div class="icon-shape bg-white bg-opacity-25 rounded-3 text-white me-3" style="width: 40px; height: 40px; font-size: 1rem;">
                                <i class="fas fa-wallet"></i>
                            </div>
                            <span class="fw-bold small uppercase" style="font-size: 0.7rem;">Total Revenue</span>
                        </div>
                        <h3 class="fw-bolder mb-1 text-gradient-gold">{{ number_format($totalRevenue, 0) }} ৳</h3>
                        <div class="progress progress-xs bg-white bg-opacity-10 mb-1" style="height: 4px;">
                            <div class="progress-bar bg-white" style="width: 75%"></div>
                        </div>
                        <span class="opacity-75" style="font-size: 0.7rem;">75% of quarterly goal</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-2">
            {{-- Enrollment Analytics Chart --}}
            <div class="col-lg-8 mb-4">
                <div class="card border-0 shadow-soft rounded-4 h-100">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="fw-bold mb-0">Enrollment Trends</h5>
                            <div class="d-flex gap-2">
                                <span class="badge bg-soft-primary text-primary rounded-pill px-3 py-2 small fw-bold">Daily Stats</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-4 pb-4">
                        <div style="position: relative; height: 220px; width: 100%;">
                            <canvas id="enrollmentChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Activity Highlights --}}
            <div class="col-lg-4 mb-4">
                <div class="card border-0 shadow-soft rounded-4 h-100">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                        <h5 class="fw-bold mb-0">Shop Highlights</h5>
                    </div>
                    <div class="card-body px-4 pt-3">
                        <div class="d-flex align-items-center mb-3 p-2 rounded-3 bg-light bg-opacity-50">
                            <div class="flex-shrink-0 me-3">
                                <div class="bg-warning p-2 rounded-3 text-white" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <span class="text-muted small d-block">Pending Enrollments</span>
                                <span class="fw-bold text-dark">{{ $pendingEnrollments }}</span>
                            </div>
                            <a href="{{ route('admin.enrollments.index') }}?status=pending" class="btn btn-sm btn-icon btn-light rounded-circle"><i class="fas fa-chevron-right"></i></a>
                        </div>
                        <div class="d-flex align-items-center mb-3 p-2 rounded-3 bg-light bg-opacity-50">
                            <div class="flex-shrink-0 me-3">
                                <div class="bg-info p-2 rounded-3 text-white" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <span class="text-muted small d-block">Today's Shop Orders</span>
                                <span class="fw-bold text-dark">{{ $todayOrders }}</span>
                            </div>
                            <a href="{{ route('admin.orderList') }}" class="btn btn-sm btn-icon btn-light rounded-circle"><i class="fas fa-chevron-right"></i></a>
                        </div>
                        <div class="d-flex align-items-center p-2 rounded-3 bg-light bg-opacity-50">
                            <div class="flex-shrink-0 me-3">
                                <div class="bg-success p-2 rounded-3 text-white" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">
                                    <i class="fas fa-boxes"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <span class="text-muted small d-block">E-commerce Products</span>
                                <span class="fw-bold text-dark">{{ $productcount }}</span>
                            </div>
                            <a href="{{ route('admin.productsAll') }}?type=product" class="btn btn-sm btn-icon btn-light rounded-circle"><i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            {{-- Recent Enrollments Table --}}
            <div class="col-xl-7 mb-4">
                <div class="card border-0 shadow-soft rounded-4">
                    <div class="card-header bg-white border-0 py-4 px-4 d-flex align-items-center justify-content-between">
                        <h5 class="fw-bold mb-0">Recent Enrollments</h5>
                        <a href="{{ route('admin.enrollments.index') }}" class="btn btn-link btn-sm text-decoration-none fw-bold">View All</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light bg-opacity-50">
                                    <tr>
                                        <th class="ps-4 border-0 text-muted small uppercase">Student</th>
                                        <th class="border-0 text-muted small uppercase">Course</th>
                                        <th class="border-0 text-muted small uppercase">Status</th>
                                        <th class="text-end pe-4 border-0 text-muted small uppercase">Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentEnrollments as $enrollment)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-soft-primary rounded-circle me-3 text-primary fw-bold d-flex align-items-center justify-content-center">
                                                    {{ strtoupper(substr($enrollment->user->name ?? 'U', 0, 1)) }}
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <span class="text-dark fw-bold mb-0">{{ $enrollment->user->name ?? 'User' }}</span>
                                                    <span class="text-muted small">{{ $enrollment->user->email ?? '' }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-dark-75 fw-bold">{{ Str::limit($enrollment->product->name_en ?? 'N/A', 20) }}</span>
                                        </td>
                                        <td>
                                            <span class="badge rounded-pill px-3 {{ $enrollment->status == 'pending' ? 'bg-soft-warning text-warning' : ($enrollment->status == 'active' ? 'bg-soft-success text-success' : 'bg-soft-danger text-danger') }}">
                                                {{ ucfirst($enrollment->status) }}
                                            </span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <span class="text-muted small">{{ $enrollment->created_at ? $enrollment->created_at->diffForHumans() : '-' }}</span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="4" class="text-center py-5 text-muted">No enrollments yet.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Latest Courses --}}
            <div class="col-xl-5 mb-4">
                <div class="card border-0 shadow-soft rounded-4">
                    <div class="card-header bg-white border-0 py-4 px-4 d-flex align-items-center justify-content-between">
                        <h5 class="fw-bold mb-0">Latest Courses</h5>
                        <a href="{{ route('admin.productsAll') }}?type=course" class="btn btn-link btn-sm text-decoration-none fw-bold text-success">View All</a>
                    </div>
                    <div class="card-body px-4 pb-4">
                        @foreach($recentCourses as $course)
                        <div class="d-flex align-items-center mb-4 transition-hover-left p-2 rounded-3">
                            <div class="me-3 position-relative">
                                <img src="{{ route('imagecache', ['template' => 'sbixs', 'filename' => $course->fi()]) }}" alt="" class="rounded-4 shadow-sm" style="width: 70px; height: 50px; object-fit: cover;">
                                @if($course->feature)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-circle bg-warning p-1" title="Featured"><i class="fas fa-star text-white" style="font-size: 8px;"></i></span>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <a href="{{ route('admin.productEdit', $course) }}" class="text-dark fw-bold text-hover-primary mb-1 d-block">{{ Str::limit($course->name_en, 35) }}</a>
                                <div class="d-flex align-items-center">
                                    <span class="fw-bolder text-primary me-3">{{ $course->selling_price }} ৳</span>
                                    <span class="text-muted small"><i class="fas fa-play-circle me-1 opacity-50"></i> {{ $course->lessons_count ?? 0 }} Lessons</span>
                                </div>
                            </div>
                            <div class="ms-2">
                                <a href="{{ route('admin.productEdit', $course) }}" class="btn btn-sm btn-light rounded-pill px-3">Edit</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    body {
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        background-color: #f8f9fc !important;
    }

    .shadow-soft {
        box-shadow: 0 0.75rem 1.5rem rgba(18, 38, 63, 0.03) !important;
    }

    .rounded-4 { border-radius: 1.2rem !important; }

    .icon-shape {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .bg-soft-primary { background-color: #eef3ff !important; }
    .bg-soft-success { background-color: #e8fff3 !important; }
    .bg-soft-warning { background-color: #fff8dd !important; }
    .bg-soft-info { background-color: #f1faff !important; }
    .bg-soft-danger { background-color: #fff5f8 !important; }

    .text-gradient-gold {
        background: linear-gradient(to right, #f6d365 0%, #fda085 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .glass-decoration {
        position: absolute;
        top: -20px;
        right: -20px;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        opacity: 0.05;
        filter: blur(20px);
    }

    .transition-hover-left {
        transition: all 0.2s ease;
    }
    .transition-hover-left:hover {
        background-color: #f8f9fa;
        transform: translateX(5px);
    }

    .avatar-sm {
        width: 40px;
        height: 40px;
        font-size: 0.9rem;
    }

    .uppercase { text-transform: uppercase; letter-spacing: 0.5px; }

    /* Custom Scrollbar */
    ::-webkit-scrollbar { width: 6px; height: 6px; }
    ::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    ::-webkit-scrollbar-track { background: transparent; }
</style>

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('enrollmentChart').getContext('2d');
    const enrollmentChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($enrollmentLabels) !!},
            datasets: [{
                label: 'New Enrollments',
                data: {!! json_encode($enrollmentData) !!},
                borderColor: '#2952FF',
                backgroundColor: 'rgba(41, 82, 255, 0.1)',
                fill: true,
                tension: 0.4,
                borderWidth: 3,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#2952FF',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { display: false },
                    ticks: {
                        stepSize: 1,
                        font: { family: 'Plus Jakarta Sans', size: 12 }
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { family: 'Plus Jakarta Sans', size: 12 } }
                }
            }
        }
    });
</script>
@endpush
@endsection
