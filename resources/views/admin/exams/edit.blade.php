@extends('admin.master')

@section('title')
   Admin Dashboard | Edit Exam
@endsection

@section('body')
<section class="content py-3">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-lg">
                <div class="card-header">
                    <h3 class="card-title">Edit Exam: {{ $exam->title }}</h3>
                </div>
                <form action="{{ route('admin.exams.update', $exam->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label>Exam Title</label>
                            <input type="text" name="title" class="form-control" value="{{ $exam->title }}" required>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control" rows="3">{{ $exam->description }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Duration (Minutes)</label>
                                    <input type="number" name="duration" class="form-control" value="{{ $exam->duration }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Start Time</label>
                                    <input type="datetime-local" name="start_time" class="form-control" value="{{ $exam->start_time->format('Y-m-d\TH:i') }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>End Time</label>
                                    <input type="datetime-local" name="end_time" class="form-control" value="{{ $exam->end_time->format('Y-m-d\TH:i') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Number of Questions to Select</label>
                            <input type="number" name="question_count" class="form-control" value="{{ $exam->question_count }}" required>
                        </div>
                        <div class="form-group">
                            <label>Select Students (Leave empty for all students)</label>
                            <select name="student_ids[]" class="form-control select2" multiple="multiple" data-placeholder="Select Students" style="width: 100%;">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ in_array($user->id, $selected_student_ids) ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update Exam</button>
                        <a href="{{ route('admin.exams.index') }}" class="btn btn-default">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@push('js')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap4'
        });
    });
</script>
@endpush
@endsection
