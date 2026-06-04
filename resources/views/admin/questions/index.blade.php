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
@endsection

@push('js')
<script>
    $(document).ready(function() {
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
