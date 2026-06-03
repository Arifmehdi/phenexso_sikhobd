@extends('website.layouts.sikhobd')

@section('content')
<div class="container py-5 text-center">
    <div class="card shadow p-5">
        <i class="fas fa-clock fa-5x text-warning mb-4"></i>
        <h2>Exam Submitted!</h2>
        <p class="lead">Your exam for <strong>{{ $exam->title }}</strong> has been submitted successfully.</p>
        <p>The results and correct answers will be visible here once the administrator finishes the exam process.</p>
        <div class="mt-4">
            <a href="{{ route('exams.index') }}" class="btn btn-primary">Back to Exams List</a>
        </div>
    </div>
</div>
@endsection
