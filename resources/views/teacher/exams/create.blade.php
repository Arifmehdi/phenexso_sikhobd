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
                        <div class="form-group mb-3">
                            <label class="fw-bold mb-2">Assign to Specific Students (Optional)</label>
                            <select name="student_ids[]" class="form-select select2" multiple="multiple" data-placeholder="Select Students" style="width: 100%;">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Leave empty if it's open for all students.</small>
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

@push('js')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
@endpush
