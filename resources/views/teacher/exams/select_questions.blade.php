@extends('website.layouts.sikhobd')

@section('title', 'Select Questions — ' . $exam->title)

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card shadow-lg border-0" style="border-radius: 15px;">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center" style="border-radius: 15px 15px 0 0;">
                    <h3 class="card-title mb-0">Select Questions for: {{ $exam->title }}</h3>
                    <span class="badge bg-light text-primary">Need: {{ $exam->question_count }} Questions</span>
                </div>
                <form action="{{ route('teacher.exams.update-questions', $exam->id) }}" method="POST">
                    @csrf
                    <div class="card-body p-4">
                        <div class="alert alert-info">
                            <i class="fa-solid fa-circle-info"></i> Please select exactly <strong>{{ $exam->question_count }}</strong> questions from your question bank below.
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th width="40">Select</th>
                                        <th>Question Text</th>
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
                                        <td><span class="badge bg-success">{{ strtoupper($question->correct_option) }}</span></td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4">
                                            <p class="text-muted mb-0">You haven't created any questions yet.</p>
                                            <a href="{{ route('teacher.questions.create') }}" class="btn btn-sm btn-link">Create Questions Now</a>
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
