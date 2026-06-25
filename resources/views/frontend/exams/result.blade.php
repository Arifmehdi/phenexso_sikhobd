@extends('website.layouts.sikhobd')

@section('title', 'পরীক্ষার ফলাফল — ' . ($ws->name ?? env('APP_NAME')))

@push('css')
<style>
    /* Reuse dashboard styles */
    .dash-main { min-height: calc(100vh - 76px); }
    .avatar-sm { width: 44px; height: 44px; border-radius: 50%; object-fit: cover; }
    .result-header { background: var(--bg-soft); padding: 30px; border-radius: 12px; margin-bottom: 24px; text-align: center; border: 1px solid var(--border); }
    .score-box { font-size: 36px; font-weight: 800; color: var(--primary); margin: 15px 0; }
    .question-review { background: #fff; border: 1px solid var(--border); border-radius: 12px; padding: 20px; margin-bottom: 20px; }
    .question-review.correct { border-left: 5px solid #15803d; background: #f0fdf4; }
    .question-review.incorrect { border-left: 5px solid #b91c1c; background: #fef2f2; }
    .option-item { padding: 8px 12px; border-radius: 8px; margin-bottom: 5px; border: 1px solid transparent; }
    .option-item.selected.correct { background: #dcfce7; border-color: #15803d; font-weight: 700; }
    .option-item.selected.incorrect { background: #fee2e2; border-color: #b91c1c; font-weight: 700; }
    .correct-badge { background: #15803d; color: #fff; padding: 2px 8px; border-radius: 4px; font-size: 11px; margin-left: 10px; }
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
            <a href="{{ route('exams.index') }}" class="active">
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
                <h1>পরীক্ষার ফলাফল</h1>
                <p>{{ $exam->title }}</p>
            </div>
            <a href="{{ route('exams.index') }}" class="btn btn-outline btn-sm">পিছনে যান</a>
        </div>

        <div class="result-header">
            <h3>আপনার প্রাপ্ত মার্কস</h3>
            <div class="score-box">{{ $attempt->score }} / {{ $exam->question_count }}</div>
            <p class="text-muted">শতকরা হার: {{ number_format(($attempt->score / $exam->question_count) * 100, 2) }}%</p>

            <a href="{{ route('user.exam_certificate', $exam->id) }}" target="_blank" class="btn btn-success mt-2">
                <i class="fa-solid fa-certificate"></i> সার্টিফিকেট ডাউনলোড করুন
            </a>
        </div>

        <h4 class="mb-4">উত্তরপত্র পর্যালোচনা:</h4>
        
        @foreach($attempt->answers as $index => $answer)
        <div class="question-review {{ $answer->is_correct ? 'correct' : 'incorrect' }}">
            <p class="fw-bold mb-3">প্রশ্ন {{ $index + 1 }}: {{ $answer->question->question_text }}</p>
            
            <div class="options-list">
                <div class="option-item {{ $answer->selected_option == 'a' ? ($answer->is_correct ? 'selected correct' : 'selected incorrect') : '' }}">
                    A. {{ $answer->question->option_a }}
                    @if($answer->question->correct_option == 'a' && $answer->selected_option != 'a') <span class="correct-badge">সঠিক উত্তর</span> @endif
                </div>
                <div class="option-item {{ $answer->selected_option == 'b' ? ($answer->is_correct ? 'selected correct' : 'selected incorrect') : '' }}">
                    B. {{ $answer->question->option_b }}
                    @if($answer->question->correct_option == 'b' && $answer->selected_option != 'b') <span class="correct-badge">সঠিক উত্তর</span> @endif
                </div>
                <div class="option-item {{ $answer->selected_option == 'c' ? ($answer->is_correct ? 'selected correct' : 'selected incorrect') : '' }}">
                    C. {{ $answer->question->option_c }}
                    @if($answer->question->correct_option == 'c' && $answer->selected_option != 'c') <span class="correct-badge">সঠিক উত্তর</span> @endif
                </div>
                <div class="option-item {{ $answer->selected_option == 'd' ? ($answer->is_correct ? 'selected correct' : 'selected incorrect') : '' }}">
                    D. {{ $answer->question->option_d }}
                    @if($answer->question->correct_option == 'd' && $answer->selected_option != 'd') <span class="correct-badge">সঠিক উত্তর</span> @endif
                </div>
            </div>

            @if($answer->question->explanation)
            <div class="mt-3 p-3 bg-light rounded border">
                <small><strong>ব্যাখ্যা:</strong> {{ $answer->question->explanation }}</small>
            </div>
            @endif
        </div>
        @endforeach
    </section>
</div>
@endsection
