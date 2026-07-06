@extends('admin.master')

@section('title')
   Admin Dashboard | Questions All
@endsection

@section('body')
<style>
    /* Prevent table responsive from clipping dropdowns */
    .table-responsive {
        overflow: visible !important;
    }
    /* Ensure the card has enough space at the bottom for the last row's dropdown */
    .card-body {
        padding-bottom: 60px !important;
    }
    @media (max-width: 767.98px) {
        .table-responsive {
            overflow-x: auto !important;
        }
    }
</style>
<section class="content py-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-lg">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-question-circle text-primary"></i> Question Bank
                        </h3>
                        <div class="card-tools d-flex">
                            <div class="input-group input-group-sm mr-2" style="width: 250px;">
                                <input type="search" name="q" class="global-search form-control float-right" data-url="{{ route('admin.global-search-ajax',['type'=>'question']) }}" placeholder="Search question text or ID...">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                            <a href="{{ route('admin.questions.create') }}" class="btn btn-sm btn-success mr-2">
                                <i class="fas fa-plus"></i> Add New
                            </a>
                            <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#bulkUploadModal">
                                <i class="fas fa-file-upload"></i> Bulk Upload
                            </button>
                        </div>
                    </div>

                    <div class="card-body py-2 border-bottom">
                        <form method="GET" action="{{ route('admin.questions.index') }}" class="form-inline">
                            <label class="mr-2 mb-0"><i class="fas fa-filter text-muted"></i> Filter:</label>
                            <select name="course_id" id="courseSelect" class="form-control form-control-sm mr-2" style="max-width: 250px;">
                                <option value="">All Courses</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                        {{ $course->name_en ?? $course->name_bn }}
                                    </option>
                                @endforeach
                            </select>
                            <select name="class_id" id="classSelect" class="form-control form-control-sm mr-2" style="max-width: 250px;" data-selected="{{ request('class_id') }}" {{ request('course_id') ? '' : 'disabled' }}>
                                <option value="">All Classes</option>
                            </select>
                            <button type="submit" class="btn btn-sm btn-primary mr-2">Apply</button>
                            <a href="{{ route('admin.questions.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
                        </form>
                    </div>

                    <div class="card-body p-0 mb-0">
                        <div class="table-responsive data-container">
                            @include('admin.questions.search_data')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Bulk Upload Modal -->
<div class="modal fade" id="bulkUploadModal" tabindex="-1" role="dialog" aria-labelledby="bulkUploadModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{ route('admin.questions.bulk-upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="bulkUploadModalLabel">Bulk Upload Questions</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Select Course <small class="text-muted">(optional — all imported questions get tagged to it)</small></label>
            <select name="product_id" id="bulkCourseSelect" class="form-control">
                <option value="">— General (no course) —</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->name_en ?? $course->name_bn }}</option>
                @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Select Class <small class="text-muted">(optional)</small></label>
            <select name="course_lesson_id" id="bulkClassSelect" class="form-control" disabled>
                <option value="">— Select a course first —</option>
            </select>
          </div>
          <div class="form-group">
            <label>Select Excel/CSV/TXT File</label>
            <input type="file" name="file" class="form-control" required>
            <small class="text-muted">Supported formats: .xlsx, .xls, .csv, .txt</small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Upload</button>
        </div>
      </form>
    </div>
  </div>
</div>
@include('admin.questions._course_class_script')
@endsection

@push('js')
<script>
    $(document).ready(function() {
        // Course → Class cascade for the Bulk Upload modal
        var bulkUrlTemplate = "{{ route('course.classes.json', ['product' => 'PRODUCT_ID']) }}";
        $('#bulkCourseSelect').on('change', function () {
            var courseId = $(this).val();
            var $class = $('#bulkClassSelect');
            if (!courseId) {
                $class.prop('disabled', true).html('<option value="">— Select a course first —</option>');
                return;
            }
            $class.prop('disabled', true).html('<option value="">Loading classes...</option>');
            $.get(bulkUrlTemplate.replace('PRODUCT_ID', courseId), function (res) {
                var options = '<option value="">— Whole course (no specific class) —</option>';
                (res.classes || []).forEach(function (c) {
                    var label = (c.section ? c.section + ' › ' : '') + c.title;
                    options += '<option value="' + c.id + '">' + $('<div>').text(label).html() + '</option>';
                });
                $class.html(options).prop('disabled', false);
            });
        });

        $(document).on('keyup', ".global-search", function(e){
            e.preventDefault();
            var that = $( this );
            var url = that.attr('data-url');
            var q = that.val();

            $.ajax({
                 url: url,
                 data : {q:q},
                 method: "get",
                 success: function(res)
                 {
                    if(res.success)
                    {
                        $(".data-container").empty().append(res.html);
                    }
                 }
            });
        });
    });
</script>
@endpush
