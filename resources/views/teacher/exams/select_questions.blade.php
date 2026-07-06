@extends('website.layouts.sikhobd')

@section('title', 'Select Questions — ' . $exam->title)

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card shadow-lg border-0" style="border-radius: 15px;">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center" style="border-radius: 15px 15px 0 0;">
                    <h3 class="card-title mb-0">
                        Select Questions for: {{ $exam->title }}
                        @if($exam->course)
                            <span class="badge bg-info">{{ $exam->course->name_en ?? $exam->course->name_bn }}</span>
                        @endif
                        @if($exam->lesson)
                            <span class="badge bg-light text-primary">{{ $exam->lesson->title_en ?? $exam->lesson->title_bn }}</span>
                        @endif
                    </h3>
                    <span class="badge bg-light text-primary">Need: {{ $exam->question_count }} Questions</span>
                </div>
                <form action="{{ route('teacher.exams.update-questions', $exam->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="visible_ids" value="{{ $questions->pluck('id')->implode(',') }}">
                    <div class="card-body p-4">
                        <div class="alert alert-info">
                            <i class="fa-solid fa-circle-info"></i> Please select exactly <strong>{{ $exam->question_count }}</strong> questions from your question bank below.
                        </div>

                        <div class="btn-group mb-3">
                            @if($exam->course_lesson_id)
                                <a href="{{ route('teacher.exams.select-questions', ['exam' => $exam->id, 'scope' => 'class']) }}" class="btn btn-sm {{ $scope == 'class' ? 'btn-primary' : 'btn-outline-primary' }}">This Class Only</a>
                            @endif
                            @if($exam->product_id)
                                <a href="{{ route('teacher.exams.select-questions', ['exam' => $exam->id, 'scope' => 'course']) }}" class="btn btn-sm {{ $scope == 'course' ? 'btn-primary' : 'btn-outline-primary' }}">Whole Course</a>
                            @endif
                            <a href="{{ route('teacher.exams.select-questions', ['exam' => $exam->id, 'scope' => 'all']) }}" class="btn btn-sm {{ $scope == 'all' ? 'btn-primary' : 'btn-outline-primary' }}">All My Questions</a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th width="40">Select</th>
                                        <th>Question Text</th>
                                        <th>Course / Class</th>
                                        <th width="100">Correct</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($questions as $question)
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input question-checkbox" type="checkbox" name="question_ids[]" value="{{ $question->id }}" {{ in_array($question->id, $selected_question_ids) ? 'checked' : '' }}>
                                            </div>
                                        </td>
                                        <td>{{ $question->question_text }}</td>
                                        <td>
                                            @if($question->course)
                                                <span class="badge bg-info">{{ Str::limit($question->course->name_en ?? $question->course->name_bn, 20) }}</span>
                                            @endif
                                            @if($question->lesson)
                                                <span class="badge bg-secondary">{{ Str::limit($question->lesson->title_en ?? $question->lesson->title_bn, 20) }}</span>
                                            @endif
                                            @if(!$question->course && !$question->lesson)
                                                <span class="text-muted">General</span>
                                            @endif
                                        </td>
                                        <td><span class="badge bg-success">{{ strtoupper($question->correct_option) }}</span></td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">
                                            <p class="text-muted mb-0">No questions found for this filter.</p>
                                            <a href="{{ route('teacher.questions.create', array_filter(['course_id' => $exam->product_id, 'class_id' => $exam->course_lesson_id])) }}" class="btn btn-sm btn-link">Create Questions Now</a>
                                            @if($scope != 'all')
                                                <a href="{{ route('teacher.exams.select-questions', ['exam' => $exam->id, 'scope' => 'all']) }}" class="btn btn-sm btn-link">Show All My Questions</a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-light p-4 d-flex justify-content-between align-items-center" style="border-radius: 0 0 15px 15px;">
                        <div>
                            <span id="selected-count" class="fw-bold text-primary">0</span> / {{ $exam->question_count }} selected
                        </div>
                        <div>
                            <button type="submit" id="submit-btn" class="btn btn-primary px-4" disabled>Save & Publish Exam</button>
                            <a href="{{ route('user.dashboard') }}#tab-teacher-exams" class="btn btn-outline-secondary px-4">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        const requiredCount = {{ $exam->question_count }};
        
        function updateCount() {
            const count = $('.question-checkbox:checked').length;
            $('#selected-count').text(count);
            
            if (count === requiredCount) {
                $('#submit-btn').prop('disabled', false);
                $('#selected-count').removeClass('text-danger').addClass('text-success');
            } else {
                $('#submit-btn').prop('disabled', true);
                $('#selected-count').removeClass('text-success').addClass('text-danger');
            }
        }

        $('.question-checkbox').on('change', updateCount);
        updateCount();
    });
</script>
@endpush
