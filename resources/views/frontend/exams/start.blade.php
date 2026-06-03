@extends('website.layouts.sikhobd')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ $exam->title }}</h4>
                    <div id="timer" class="h4 mb-0">Time Left: <span id="time-display">--:--</span></div>
                </div>
                <form action="{{ route('exams.submit', $exam->id) }}" method="POST" id="exam-form">
                    @csrf
                    <div class="card-body">
                        @foreach($questions as $index => $question)
                        <div class="question-block mb-4 p-3 border rounded">
                            <p class="font-weight-bold">Question {{ $index + 1 }}: {{ $question->question_text }}</p>
                            <div class="options ml-3">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" value="a" id="q{{ $question->id }}a">
                                    <label class="form-check-input-label" for="q{{ $question->id }}a">A. {{ $question->option_a }}</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" value="b" id="q{{ $question->id }}b">
                                    <label class="form-check-input-label" for="q{{ $question->id }}b">B. {{ $question->option_b }}</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" value="c" id="q{{ $question->id }}c">
                                    <label class="form-check-input-label" for="q{{ $question->id }}c">C. {{ $question->option_c }}</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" value="d" id="q{{ $question->id }}d">
                                    <label class="form-check-input-label" for="q{{ $question->id }}d">D. {{ $question->option_d }}</label>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-success btn-lg px-5">Submit Exam</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    let duration = {{ $exam->duration }} * 60;
    let timer = setInterval(function() {
        let minutes = Math.floor(duration / 60);
        let seconds = duration % 60;
        document.getElementById('time-display').innerText = 
            (minutes < 10 ? '0' : '') + minutes + ":" + (seconds < 10 ? '0' : '') + seconds;
        
        if (duration <= 0) {
            clearInterval(timer);
            document.getElementById('exam-form').submit();
        }
        duration--;
    }, 1000);
</script>
@endpush
@endsection
