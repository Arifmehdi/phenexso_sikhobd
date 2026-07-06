@extends('website.layouts.sikhobd')

@section('title', 'Create New Exam — Teacher Area')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-lg border-0" style="border-radius: 15px;">
                <div class="card-header bg-primary text-white" style="border-radius: 15px 15px 0 0;">
                    <h3 class="card-title mb-0">Create New Exam</h3>
                </div>
                <form action="{{ route('teacher.exams.store') }}" method="POST">
                    @csrf
                    <div class="card-body p-4">
                        <div class="form-group mb-3">
                            <label class="fw-bold mb-2">Exam Title</label>
                            <input type="text" name="title" class="form-control" required placeholder="e.g., Mid-term Quiz 2024">
                        </div>
                        <div class="form-group mb-3">
                            <label class="fw-bold mb-2">Description</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Brief details about the exam..."></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Duration (Minutes)</label>
                                    <input type="number" name="duration" class="form-control" required min="1">
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Start Time</label>
                                    <input type="datetime-local" name="start_time" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label class="fw-bold mb-2">End Time</label>
                                    <input type="datetime-local" name="end_time" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="fw-bold mb-2">Number of Questions to Select</label>
                            <input type="number" name="question_count" class="form-control" required min="1">
                            <small class="text-muted">Total questions students will see.</small>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Select Course
                                        <small class="text-muted">— only enrolled students get this exam</small>
                                    </label>
                                    <select name="product_id" id="courseSelect" class="form-select">
                                        <option value="">— No course (public exam) —</option>
                                        @forelse($courses as $course)
                                            <option value="{{ $course->id }}" {{ old('product_id') == $course->id ? 'selected' : '' }}>{{ $course->name_en ?? $course->name_bn }}</option>
                                        @empty
                                            <option value="" disabled>You have no assigned courses</option>
                                        @endforelse
                                    </select>
                                    <small class="text-muted">Only the courses assigned to you are shown. Leave empty to make it public.</small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Select Class
                                        <small class="text-muted">— students must finish this class first</small>
                                    </label>
                                    <select name="course_lesson_id" id="classSelect" class="form-select" data-selected="{{ old('course_lesson_id') }}" disabled>
                                        <option value="">— Select a course first —</option>
                                    </select>
                                    <small class="text-muted">The exam unlocks only after the student completes the selected class.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light p-4" style="border-radius: 0 0 15px 15px;">
                        <button type="submit" class="btn btn-primary px-4">Create & Select Questions</button>
                        <a href="{{ route('user.dashboard') }}#tab-teacher-exams" class="btn btn-outline-secondary px-4">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@include('admin.questions._course_class_script')
