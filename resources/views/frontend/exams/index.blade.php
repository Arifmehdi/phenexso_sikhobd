@extends('website.layouts.sikhobd')

@section('title', __('frontend.exams.page_title') . ' — ' . ($ws->name ?? env('APP_NAME')))

@push('css')
<style>
    /* Reuse dashboard styles */
    .custom-table { width: 100%; border-collapse: collapse; }
    .custom-table th { padding: 14px 18px; background: var(--bg-muted); color: var(--text-soft); font-size: 12px; font-weight: 700; text-transform: uppercase; text-align: left; letter-spacing: 0.3px; }
    .custom-table td { padding: 16px 18px; border-bottom: 1px solid var(--border); font-size: 14px; vertical-align: middle; }
    .status-pill { padding: 4px 12px; border-radius: 50px; font-size: 11px; font-weight: 700; text-transform: uppercase; display: inline-block; }
    .status-pending { background: #fff7ed; color: #c2410c; }
    .status-approved { background: #f0fdf4; color: #15803d; }
    .status-rejected { background: #fef2f2; color: #b91c1c; }
    .dash-main { min-height: calc(100vh - 76px); }
    .avatar-sm { width: 44px; height: 44px; border-radius: 50%; object-fit: cover; }
</style>
@endpush

@section('content')
<div class="dash-wrap {{ !auth()->check() ? 'guest-view' : '' }}">
    <!-- Sidebar -->
    @auth
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
                <i class="fa-solid fa-house"></i> <span>{{ __('frontend.exams.nav_dashboard') }}</span>
            </a>
            <a href="{{ route('user.dashboard') }}#tab-courses">
                <i class="fa-solid fa-graduation-cap"></i> <span>{{ __('frontend.exams.nav_courses') }}</span>
            </a>
            <a href="{{ route('user.dashboard') }}#tab-orders-inline">
                <i class="fa-solid fa-cart-shopping"></i> <span>{{ __('frontend.exams.nav_orders') }}</span>
            </a>
            <a href="{{ route('user.dashboard') }}#tab-exams" class="active">
                <i class="fa-solid fa-file-pen"></i> <span>{{ __('frontend.exams.nav_exams') }}</span>
            </a>
            <a href="{{ route('logout') }}" style="color: var(--accent); margin-top: auto;">
                <i class="fa-solid fa-right-from-bracket"></i> <span>{{ __('frontend.exams.nav_logout') }}</span>
            </a>
        </nav>
    </aside>
    @else
    <section class="page-hero" style="background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%); padding: 60px 0; color: #fff; text-align: center; width: 100%;">
        <div class="container">
            <h1>{{ __('frontend.exams.all_exams') }}</h1>
            <p>{{ __('frontend.exams.all_exams_sub') }}</p>
        </div>
    </section>
    @endauth

    <!-- Main Content -->
    <section class="dash-main" style="{{ !auth()->check() ? 'padding-top: 40px; max-width: 1200px; margin: 0 auto;' : '' }}">
        @auth
        <div class="dash-head">
            <div>
                <h1>{{ __('frontend.exams.page_title') }}</h1>
                <p>{{ __('frontend.exams.page_sub') }}</p>
            </div>
        </div>
        @endauth

        <div class="panel mb-4">
            <div class="panel-head">
                <h3><i class="fa-solid fa-file-pen"></i> {{ __('frontend.exams.available') }}</h3>
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
                        <i class="far fa-clock"></i> {{ $exam->duration }} {{ __('frontend.exams.minutes') }} &middot;
                        <i class="far fa-calendar-alt"></i> {{ __('frontend.exams.ends') }}: {{ $exam->end_time->format('M d, h:i A') }}
                    </div>
                </div>
                @if($isCompleted)
                    @if($exam->status == 'finished')
                        <a href="{{ route('exams.result', $exam->id) }}" class="btn btn-success btn-sm">{{ __('frontend.exams.view_result') }}</a>
                    @else
                        <span class="status-pill status-approved">{{ __('frontend.exams.attended') }}</span>
                    @endif
                @elseif($isUpcoming)
                    <span class="status-pill status-pending">{{ __('frontend.exams.upcoming') }}</span>
                @elseif($isEnded)
                    <span class="status-pill status-rejected">{{ __('frontend.exams.expired') }}</span>
                @else
                    <a href="{{ route('exams.start', $exam->id) }}" class="btn btn-primary btn-sm">{{ __('frontend.exams.participate') }}</a>
                @endif
            </div>
            @empty
            <div class="empty-state">
                <h5>{{ __('frontend.exams.none_available') }}</h5>
            </div>
            @endforelse
        </div>

        @auth
        <div class="panel">
            <div class="panel-head">
                <h3><i class="fa-solid fa-check-double"></i> {{ __('frontend.exams.completed') }}</h3>
            </div>
            <div style="overflow-x: auto;">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>{{ __('frontend.exams.col_exam') }}</th>
                            <th>{{ __('frontend.exams.col_date') }}</th>
                            <th>{{ __('frontend.exams.col_marks') }}</th>
                            <th>{{ __('frontend.exams.col_status') }}</th>
                            <th>{{ __('frontend.exams.col_action') }}</th>
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
                                    <span class="status-pill status-approved">{{ __('frontend.exams.result_published') }}</span>
                                @else
                                    <span class="status-pill status-pending">{{ __('frontend.exams.pending') }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('exams.result', $attempt->exam->id) }}" class="btn btn-primary btn-sm">{{ __('frontend.exams.details') }}</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="empty-state">{{ __('frontend.exams.no_attempt') }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <div class="text-center mt-5">
            <p>{{ __('frontend.exams.login_to_see') }}</p>
            <a href="{{ route('login') }}" class="btn btn-outline">{{ __('frontend.exams.login') }}</a>
        </div>
        @endauth
    </section>
</div>
@endsection
