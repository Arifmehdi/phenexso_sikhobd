@extends('admin.master')

@section('title')
   Admin Dashboard | Create Exam
@endsection

@section('body')
<section class="content py-3">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-lg">
                <div class="card-header">
                    <h3 class="card-title">Create New Exam</h3>
                </div>
                <form action="{{ route('admin.exams.store') }}" method="POST" id="examForm">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Exam Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Duration (Minutes)</label>
                                    <input type="number" name="duration" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Start Time</label>
                                    <input type="datetime-local" name="start_time" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>End Time</label>
                                    <input type="datetime-local" name="end_time" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Number of Questions to Select</label>
                            <input type="number" name="question_count" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Select Course
                                        <small class="text-muted">— only enrolled students get this exam</small>
                                    </label>
                                    <select name="product_id" id="courseSelect" class="form-control">
                                        <option value="">— No course (public exam) —</option>
                                        @foreach($courses as $course)
                                            <option value="{{ $course->id }}" {{ old('product_id') == $course->id ? 'selected' : '' }}>
                                                {{ $course->name_en ?? $course->name_bn }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle"></i> If you leave this empty, the exam becomes <strong>public</strong> (available to everyone).
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Select Class
                                        <small class="text-muted">— students must finish this class first</small>
                                    </label>
                                    <select name="course_lesson_id" id="classSelect" class="form-control" data-selected="{{ old('course_lesson_id') }}" disabled>
                                        <option value="">— Select a course first —</option>
                                    </select>
                                    <small class="form-text text-muted">
                                        <i class="fas fa-lock"></i> The exam unlocks only after the student completes the selected class. Leave it as "Whole course" for no such condition.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Create & Select Questions</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@include('admin.questions._course_class_script')

@push('js')
<script>
    $(document).ready(function() {
        // Warn before submit if no course is selected (exam will be public)
        $('#examForm').on('submit', function(e) {
            var course = $('#courseSelect').val();
            if (!course) {
                if (!confirm('You have not selected any course.\n\nThis exam will be PUBLIC — available to EVERYONE.\n\nDo you want to continue?')) {
                    e.preventDefault();
                }
            }
        });
    });
</script>
@endpush
@endsection
