@extends('website.layouts.sikhobd')

@section('title', 'Add New Question — Teacher Area')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-lg border-0" style="border-radius: 15px;">
                <div class="card-header bg-primary text-white" style="border-radius: 15px 15px 0 0;">
                    <h3 class="card-title mb-0">Add New Question</h3>
                </div>
                <form action="{{ route('teacher.questions.store') }}" method="POST">
                    @csrf
                    <div class="card-body p-4">
                        <div class="form-group mb-3">
                            <label class="fw-bold mb-2">Question Text</label>
                            <textarea name="question_text" class="form-control" rows="3" required placeholder="Enter your question here..."></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Option A</label>
                                    <input type="text" name="option_a" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Option B</label>
                                    <input type="text" name="option_b" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Option C</label>
                                    <input type="text" name="option_c" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Option D</label>
                                    <input type="text" name="option_d" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="fw-bold mb-2">Correct Option</label>
                            <select name="correct_option" class="form-select" required>
                                <option value="a">Option A</option>
                                <option value="b">Option B</option>
                                <option value="c">Option C</option>
                                <option value="d">Option D</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="fw-bold mb-2">Explanation (Optional)</label>
                            <textarea name="explanation" class="form-control" rows="2" placeholder="Briefly explain the correct answer..."></textarea>
                        </div>
                    </div>
                    <div class="card-footer bg-light p-4" style="border-radius: 0 0 15px 15px;">
                        <button type="submit" class="btn btn-primary px-4">Save Question</button>
                        <a href="{{ route('user.dashboard') }}#tab-teacher-questions" class="btn btn-outline-secondary px-4">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
