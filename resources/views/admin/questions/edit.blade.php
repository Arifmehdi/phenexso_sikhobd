@extends('admin.master')

@section('title')
   Admin Dashboard | Edit Question
@endsection

@section('body')
<section class="content py-3">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-lg">
                <div class="card-header">
                    <h3 class="card-title">Edit Question #{{ $question->id }}</h3>
                </div>
                <form action="{{ route('admin.questions.update', $question->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label>Question Text</label>
                            <textarea name="question_text" class="form-control" rows="3" required>{{ $question->question_text }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Option A</label>
                                    <input type="text" name="option_a" class="form-control" value="{{ $question->option_a }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Option B</label>
                                    <input type="text" name="option_b" class="form-control" value="{{ $question->option_b }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Option C</label>
                                    <input type="text" name="option_c" class="form-control" value="{{ $question->option_c }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Option D</label>
                                    <input type="text" name="option_d" class="form-control" value="{{ $question->option_d }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Correct Option</label>
                            <select name="correct_option" class="form-control" required>
                                <option value="a" {{ $question->correct_option == 'a' ? 'selected' : '' }}>Option A</option>
                                <option value="b" {{ $question->correct_option == 'b' ? 'selected' : '' }}>Option B</option>
                                <option value="c" {{ $question->correct_option == 'c' ? 'selected' : '' }}>Option C</option>
                                <option value="d" {{ $question->correct_option == 'd' ? 'selected' : '' }}>Option D</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Explanation (Optional)</label>
                            <textarea name="explanation" class="form-control" rows="2">{{ $question->explanation }}</textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update Question</button>
                        <a href="{{ route('admin.questions.index') }}" class="btn btn-default">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
