@extends('admin.master')
@section('title', 'Admin Dashboard | Contact Messages')
@section('body')
<style>
    .table-responsive {
        overflow: visible !important;
    }
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
                            <i class="fas fa-envelope text-primary"></i> Contact Messages
                        </h3>
                        <div class="card-tools d-flex">
                            <div class="input-group input-group-sm mr-2" style="width: 250px;">
                                <input type="search" name="q" class="global-search form-control float-right" data-url="{{ route('admin.global-search-ajax',['type'=>'contact']) }}" placeholder="Search contacts...">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-0 mb-0">
                        <div class="table-responsive data-container">
                            @include('admin.contacts.search_data')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
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