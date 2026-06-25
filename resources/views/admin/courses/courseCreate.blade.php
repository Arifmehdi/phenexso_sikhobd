@extends('admin.master')

@section('title')
   Admin Dashboard | Course Create
@endsection

@push('css')
    <style>
        /* Custom styling for product tags select box */
        .productTags {
            width: 100%;
        }
        /* Margin bottom utility class */
        .margin-bottom {
            margin-bottom: 20px;
        }
    </style>
@endpush

@section('body')
<section class="content py-3">
    <div class="row">
        <div class="col-md-11 mx-auto">
            {{-- Card Header --}}
            <div class="card mb-2 shadow-lg">
                <div class="card-header px-2 py-2">
                    <h3 class="card-title w3-small text-bold text-muted pt-1">
                        <i class="fas fa-plus-circle text-primary"></i>&nbsp; Add New Course
                    </h3>
                    <div class="card-tools w3-small">
                        <a href="{{ route('admin.coursesAll')}}" class="btn-create-from btn btn-outline-primary btn-xs pull-right mr-2 py-1">
                            <i class="fa fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
            </div>

            {{-- Course Create Form --}}
            <form action="{{ route('admin.courseStore')}}" method="POST" enctype="multipart/form-data">
                @csrf
                {{-- Hidden input for type --}}
                <input type="hidden" name="type" value="course">

                <div class="row">
                    {{-- Left Column: Course Details --}}
                    <div class="col-sm-7">
                        <div class="card card-primary card-outline">
                            <div class="card-body">

                                {{-- Course Name (English)--}}
                                <div class="form-group">
                                    <label for="name_en">Course Name<span class="text-danger">*</span></label>
                                    <input type="text" name="name_en" value="{{ old('name_en') }}" class="form-control" placeholder="Course Name (English)" onkeyup="makeSlug(this.value)" required>
                                    @error('name_en')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Slug --}}
                                <div class="form-group">
                                    <label for="slug">Slug <span class="text-danger">*</span></label>
                                    <input type="text" id="slug" name="slug" value="{{ old('slug') }}" placeholder="URL" class="form-control" required>
                                    @error('slug')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Course Specific Fields --}}
                                <div id="course_fields" style="border: 1px dashed var(--primary); padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                                    <h5 class="text-primary"><i class="fas fa-graduation-cap"></i> E-learning Details</h5>
                                    <div class="form-group">
                                        <label for="duration">Duration (e.g. 10 hours, 4 weeks)</label>
                                        <input type="text" name="duration" value="{{ old('duration') }}" class="form-control" placeholder="Duration">
                                    </div>
                                    <div class="form-group">
                                        <label for="lessons_count">Total Lessons (Classes)</label>
                                        <input type="number" name="lessons_count" value="{{ old('lessons_count', 0) }}" class="form-control" placeholder="Total Lessons">
                                    </div>
                                    <div class="form-group">
                                        <label for="level">Course Level</label>
                                        <select name="level" id="level" class="form-control">
                                            <option value="">Select Level</option>
                                            <option value="beginner" {{ old('level') == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                            <option value="intermediate" {{ old('level') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                            <option value="advanced" {{ old('level') == 'advanced' ? 'selected' : '' }}>Advanced</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="selling_price">Course Fee <span class="text-danger">*</span></label>
                                    <input type="number" name="selling_price" value="{{ old('selling_price') }}" class="form-control" placeholder="Enter course fee" required>
                                    @error('selling_price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Discount --}}
                                <div class="form-group">
                                    <label for="discount">Course Discount (flat)</label>
                                    <input type="number" name="discount" value="{{ old('discount') }}" class="form-control" placeholder="Enter discount">
                                </div>

                                {{-- Instructor Assignment --}}
                                <div class="form-group">
                                    <label for="instructor_id">Assign Instructor (Teacher)</label>
                                    <select name="instructor_id" id="instructor_id" class="form-control select2">
                                        <option value="">Select Instructor</option>
                                        @foreach($instructors as $instructor)
                                            <option value="{{ $instructor->id }}" {{ old('instructor_id') == $instructor->id ? 'selected' : '' }}>
                                                {{ $instructor->name }} ({{ $instructor->mobile }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('instructor_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                            </div>
                        </div>

                        {{-- Excerpt & Description --}}
                        <div class="card card-primary card-outline">
                            <div class="card-body">
                                {{-- Excerpt --}}
                                <div class="form-group">
                                    <label for="excerpt_en">Excerpt</label>
                                    <textarea name="excerpt_en" id="excerpt_en" class="form-control" rows="2" placeholder="Excerpt">{{ old('excerpt_en') }}</textarea>
                                </div>

                                {{-- Description --}}
                                <div class="form-group">
                                    <label for="description_en">Description</label>
                                    <textarea name="description_en" id="summernote" class="form-control summernote" rows="5" placeholder="Description">{{ old('description_en') }}</textarea>
                                </div>

                                {{-- Active Checkbox --}}
                                <div class="form-group">
                                    <label class="mr-3">
                                        <input type="checkbox" name="active" {{ old('active', 1) ? 'checked' : '' }}>
                                        Active
                                    </label>
                                </div>

                                {{-- Feature Checkbox --}}
                                <div class="form-group">
                                    <label class="mr-3">
                                        <input type="checkbox" name="feature" {{ old('feature', 0) ? 'checked' : '' }}>
                                        Featured
                                    </label>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- Right Column: Featured Image and Media --}}
                    <div class="col-sm-5">
                        <div class="card card-primary card-outline margin-bottom">
                            <div class="card-header">
                                <h3 class="card-title">Add Featured Image</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="feature_image" class="col-sm-4 col-form-label">Featured Image</label>
                                    <div class="col-sm-8">
                                        <input type="file" class="form-control-file" id="feature_image" name="featured_image" accept="image/*">
                                        <small class="form-text text-muted">
                                            <i class="fas fa-info-circle"></i> Recommended: <strong>560 × 600 px</strong> (14:15 ratio · use the same shape as 280 × 300).
                                            JPG / PNG / WEBP, max 2 MB.
                                        </small>
                                    </div>
                                    @error('featured_image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Categories Section --}}
                @if($categories->count() > 0)
                <div class="row">
                    <div class="col-12">
                        <div class="add-categories-subcategories">
                            <div class="card card-primary card-outline">
                                <div class="card-header with-border">
                                    <h3 class="card-title">Add Category</h3>
                                </div>
                                <div class="card-body p-2">
                                    @foreach($categories as $cat)
                                        <div class="category-area">
                                            {{-- Category Checkbox --}}
                                            <div class="custom-control custom-checkbox bg-light rounded-lg mb-1">
                                                <input type="checkbox" class="custom-control-input toggle-category-checkbox" id="customCheckId_{{ $cat->id }}" name="categories[]" value="{{ $cat->id }}">
                                                <label class="custom-control-label" for="customCheckId_{{ $cat->id }}">{{ $cat->name_en ?? $cat->name_bn }}</label>
                                            </div>

                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Submit Button --}}
                <div class="card-footer text-right">
                    <input type="submit" class="btn btn-primary px-5" value="Save Course">
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@push('js')
<script>
    // Slug generator from course name input
    function makeSlug(val) {
        let str = val;
        let output = str.replace(/\s+/g, '-').toLowerCase();
        $('#slug').val(output);
    }
</script>
@endpush
