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
                    <h3 class="card-title">Select Questions for: {{ $exam->title }}</h3>
                    <div class="card-tools">
                        <button type="button" id="random-select" class="btn btn-sm btn-info">Random Select {{ $exam->question_count }}</button>
                    </div>
                </div>
                <form action="{{ route('admin.exams.update-questions', $exam->id) }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <p class="text-muted">Total needed: <strong>{{ $exam->question_count }}</strong>. Selected: <strong id="selected-count">{{ count($selected_question_ids) }}</strong></p>
                        <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>Select</th>
                                        <th>Question</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($questions as $question)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="question_ids[]" value="{{ $question->id }}" class="question-checkbox" {{ in_array($question->id, $selected_question_ids) ? 'checked' : '' }}>
                                        </td>
                                        <td>{{ $question->question_text }}</td>
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
