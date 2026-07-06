@extends('admin.master')

@section('title')
   Admin Dashboard | Create Question
@endsection

@section('body')
<section class="content py-3">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-lg">
                <div class="card-header">
                    <h3 class="card-title">Add New Question</h3>
                </div>
                <form action="{{ route('admin.questions.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Select Course <small class="text-muted">(optional)</small></label>
                                    <select name="product_id" id="courseSelect" class="form-control" data-selected="{{ request('course_id') }}">
                                        <option value="">— General (no course) —</option>
                                        @foreach($courses as $course)
                                            <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                                {{ $course->name_en ?? $course->name_bn }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Select Class <small class="text-muted">(optional)</small></label>
                                    <select name="course_lesson_id" id="classSelect" class="form-control" data-selected="{{ request('class_id') }}" disabled>
                                        <option value="">— Select a course first —</option>
                                    </select>
                                    <small class="form-text text-muted">Questions tagged to a class are easy to pick when creating that class's exam.</small>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Question Text</label>
                            <textarea name="question_text" class="form-control" rows="3" required>{{ old('question_text') }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Option A</label>
                                    <input type="text" name="option_a" class="form-control" value="{{ old('option_a') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Option B</label>
                                    <input type="text" name="option_b" class="form-control" value="{{ old('option_b') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Option C</label>
                                    <input type="text" name="option_c" class="form-control" value="{{ old('option_c') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Option D</label>
                                    <input type="text" name="option_d" class="form-control" value="{{ old('option_d') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Correct Option</label>
                            <select name="correct_option" class="form-control" required>
                                <option value="a">Option A</option>
                                <option value="b">Option B</option>
                                <option value="c">Option C</option>
                                <option value="d">Option D</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Explanation (Optional)</label>
                            <textarea name="explanation" class="form-control" rows="2">{{ old('explanation') }}</textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Save Question</button>
                        <button type="submit" name="save_and_new" value="1" class="btn btn-success">Save & Add Another</button>
                        <a href="{{ route('admin.questions.index') }}" class="btn btn-default">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@include('admin.questions._course_class_script')
@endsection
