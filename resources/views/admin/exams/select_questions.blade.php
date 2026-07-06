@extends('admin.master')

@section('title')
   Admin Dashboard | Select Questions
@endsection

@section('body')
<section class="content py-3">
    <div class="row">
        <div class="col-md-11 mx-auto">
            <div class="card shadow-lg">
                <div class="card-header">
                    <h3 class="card-title">
                        Select Questions for: {{ $exam->title }}
                        @if($exam->course)
                            <span class="badge badge-info ml-2">{{ $exam->course->name_en ?? $exam->course->name_bn }}</span>
                        @endif
                        @if($exam->lesson)
                            <span class="badge badge-primary">{{ $exam->lesson->title_en ?? $exam->lesson->title_bn }}</span>
                        @endif
                    </h3>
                    <div class="card-tools">
                        <button type="button" id="random-select" class="btn btn-sm btn-info">Random Select {{ $exam->question_count }}</button>
                    </div>
                </div>
                <form action="{{ route('admin.exams.update-questions', $exam->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="visible_ids" value="{{ $questions->pluck('id')->implode(',') }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap">
                            <p class="text-muted mb-2">Total needed: <strong>{{ $exam->question_count }}</strong>. Selected: <strong id="selected-count">{{ count($selected_question_ids) }}</strong></p>
                            <div class="btn-group mb-2">
                                @if($exam->course_lesson_id)
                                    <a href="{{ route('admin.exams.select-questions', ['exam' => $exam->id, 'scope' => 'class']) }}" class="btn btn-sm {{ $scope == 'class' ? 'btn-primary' : 'btn-outline-primary' }}">This Class Only</a>
                                @endif
                                @if($exam->product_id)
                                    <a href="{{ route('admin.exams.select-questions', ['exam' => $exam->id, 'scope' => 'course']) }}" class="btn btn-sm {{ $scope == 'course' ? 'btn-primary' : 'btn-outline-primary' }}">Whole Course</a>
                                @endif
                                <a href="{{ route('admin.exams.select-questions', ['exam' => $exam->id, 'scope' => 'all']) }}" class="btn btn-sm {{ $scope == 'all' ? 'btn-primary' : 'btn-outline-primary' }}">All Questions</a>
                            </div>
                        </div>
                        @if($questions->isEmpty())
                            <div class="alert alert-warning">
                                No questions found for this filter.
                                @if($scope != 'all')
                                    Try <a href="{{ route('admin.exams.select-questions', ['exam' => $exam->id, 'scope' => 'all']) }}">All Questions</a>, or
                                @endif
                                <a href="{{ route('admin.questions.create', array_filter(['course_id' => $exam->product_id, 'class_id' => $exam->course_lesson_id])) }}" target="_blank">create new questions for this class</a> and refresh this page.
                            </div>
                        @endif
                        <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>Select</th>
                                        <th>Question</th>
                                        <th>Course</th>
                                        <th>Class</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($questions as $question)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="question_ids[]" value="{{ $question->id }}" class="question-checkbox" {{ in_array($question->id, $selected_question_ids) ? 'checked' : '' }}>
                                        </td>
                                        <td>{{ $question->question_text }}</td>
                                        <td>
                                            @if($question->course)
                                                <span class="badge badge-info">{{ Str::limit($question->course->name_en ?? $question->course->name_bn, 25) }}</span>
                                            @else
                                                <span class="text-muted">General</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($question->lesson)
                                                <span class="badge badge-primary">{{ Str::limit($question->lesson->title_en ?? $question->lesson->title_bn, 25) }}</span>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Save and Publish Exam</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@push('js')
<script>
    $(document).ready(function() {
        const totalNeeded = {{ $exam->question_count }};

        $('.question-checkbox').change(function() {
            updateCount();
        });

        $('#random-select').click(function() {
            $('.question-checkbox').prop('checked', false);
            let checkboxes = $('.question-checkbox');
            let randomIndices = [];
            while(randomIndices.length < totalNeeded && randomIndices.length < checkboxes.length) {
                let r = Math.floor(Math.random() * checkboxes.length);
                if(randomIndices.indexOf(r) === -1) randomIndices.push(r);
            }
            randomIndices.forEach(idx => $(checkboxes[idx]).prop('checked', true));
            updateCount();
        });

        function updateCount() {
            $('#selected-count').text($('.question-checkbox:checked').length);
        }
    });
</script>
@endpush
@endsection
