@extends('website.layouts.sikhobd')

@section('title', 'আমার পরীক্ষাসমূহ — ' . ($ws->name ?? env('APP_NAME')))

@push('css')
<style>
    /* Reuse dashboard styles */
    .custom-table { width: 100%; border-collapse: collapse; }
    .custom-table th { padding: 14px 18px; background: var(--bg-muted); color: var(--text-soft); font-size: 12px; font-weight: 700; text-transform: uppercase; text-align: left; letter-spacing: 0.3px; }
    .custom-table td { padding: 16px 18px; border-bottom: 1px solid var(--border); font-size: 14px; vertical-align: middle; }
    .status-pill { padding: 4px 12px; border-radius: 50px; font-size: 11px; font-weight: 700; text-transform: uppercase; display: inline-block; }
    .status-pending { background: #fff7ed; color: #c2410c; }
    .status-approved { background: #f0fdf4; color: #15803d; }
    .dash-main { min-height: calc(100vh - 76px); }
    .avatar-sm { width: 44px; height: 44px; border-radius: 50%; object-fit: cover; }
</style>
@endpush

@section('content')
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
        <nav class="dash-nav">
            <a href="{{ route('user.dashboard') }}#tab-dashboard">
                <i class="fa-solid fa-house"></i> <span>ড্যাশবোর্ড</span>
            </a>
            <a href="{{ route('user.dashboard') }}#tab-courses">
                <i class="fa-solid fa-graduation-cap"></i> <span>আমার কোর্সসমূহ</span>
            </a>
            <a href="{{ route('user.dashboard') }}#tab-orders-inline">
                <i class="fa-solid fa-cart-shopping"></i> <span>আমার অর্ডারসমূহ</span>
            </a>
            <a href="{{ route('user.dashboard') }}#tab-exams" class="active">
                <i class="fa-solid fa-file-pen"></i> <span>আমার পরীক্ষাসমূহ</span>
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
                <h1>আমার পরীক্ষাসমূহ</h1>
                <p>আপনার সকল উপলব্ধ এবং সম্পন্ন করা পরীক্ষা</p>
            </div>
        </div>
        
        <div class="panel mb-4">
            <div class="panel-head">
                <h3><i class="fa-solid fa-file-pen"></i> উপলব্ধ পরীক্ষাসমূহ</h3>
            </div>
            @forelse($exams as $exam)
            <div class="course-row">
                <div class="thumb" style="--c1:#6c5ce7;--c2:#a29bfe;">
                    E
                </div>
                <div class="body">
                    <h4>{{ $exam->title }}</h4>
                    <div class="meta">
                        <i class="far fa-clock"></i> {{ $exam->duration }} মিনিট &middot; 
                        <i class="far fa-calendar-alt"></i> শেষ সময়: {{ $exam->end_time->format('M d, h:i A') }}
                    </div>
                </div>
                <a href="{{ route('exams.start', $exam->id) }}" class="btn btn-primary btn-sm">অংশগ্রহণ করুন</a>
            </div>
            @empty
            <div class="empty-state">
                <h5>বর্তমানে কোনো পরীক্ষা উপলব্ধ নেই</h5>
            </div>
            @endforelse
        </div>

        <div class="panel">
            <div class="panel-head">
                <h3><i class="fa-solid fa-check-double"></i> সম্পন্ন করা পরীক্ষাসমূহ</h3>
            </div>
            <div style="overflow-x: auto;">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>পরীক্ষা</th>
                            <th>তারিখ</th>
                            <th>মার্কস</th>
                            <th>অবস্থা</th>
                            <th>অ্যাকশন</th>
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
                                    <span class="status-pill status-approved">ফলাফল প্রকাশিত</span>
                                @else
                                    <span class="status-pill status-pending">অপেক্ষমান</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('exams.result', $attempt->exam->id) }}" class="btn btn-primary btn-sm">বিস্তারিত</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="empty-state">আপনি কোনো পরীক্ষায় অংশগ্রহণ করেননি</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
@endsection
