@extends('admin.master')

@section('title')
   Admin Dashboard | Ebook Management
@endsection

@push('css')
<style>
    .ebookStatus { cursor: pointer; }
</style>
@endpush

@section('body')
<section class="content py-3">
    <div class="row">
        <div class="col-md-11 mx-auto">

            {{-- Card: Header with Page Title and Add Ebook Button --}}
            <div class="card mb-2 shadow-lg">
                <div class="card-header px-2 py-2">
                    <h3 class="card-title w3-small text-bold text-muted pt-1">
                        <i class="fas fa-book text-primary"></i> Ebooks
                    </h3>
                    <div class="card-tools w3-small">
                        <a href="{{ route('admin.ebooks.create') }}" 
                           class="btn-create-from btn btn-outline-primary btn-xs pull-right mr-2 py-1">
                            <i class="fas fa-plus-square"></i> Add New Ebook
                        </a>
                    </div>
                </div>
            </div>

            {{-- Card: Ebooks Table with Search --}}
            <div class="card w3-round shadow-lg">
                <div class="card-header pl-2 py-2">
                    <h3 class="card-title w3-small text-bold text-muted">
                        <i class="fas fa-list text-primary pt-1"></i> All Ebooks
                    </h3>
                    <div class="card-tools">
                        {{-- Search input --}}
                        <div class="input-group input-group-sm">
                            <input type="search" name="q" 
                                   class="ebook-search form-control border-right-0 border py-2" 
                                   data-url="{{ route('admin.ebooks.search') }}"  
                                   placeholder="Search title, author...">
                            <div class="input-group-append">
                                <button type="submit" class="input-group-text bg-transparent">
                                    <i class="fa fa-search w3-text-orange"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card body: Ebooks list and pagination --}}
                <div class="card-body bg-light px-0 pb-0 pt-2">
                    <div class="col-sm-12">
                        <div class="table-responsive table-responsive-sm data-container">
                            {{-- Include ebook search results partial --}}
                            @include('admin.ebooks.searchData')
                        </div>

                        {{-- Pagination links --}}
                        <div class="w3-small float-right pt-1">
                            {!! $ebooks->links() !!}
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
    $(document).ready(function () {
        // Toggle active status via AJAX
        $(document).on('change', '.active-status', function() {
            var id = $(this).data('id');
            $.ajax({
                url: "{{ route('admin.ebooks.status') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                success: function(res) {
                    if(res.success) {
                        toastr.success('Status updated successfully');
                    }
                }
            });
        });

        // Toggle approval status via AJAX
        $(document).on('click', '.ebookStatus', function() {
            var id = $(this).data('id');
            var btn = $(this);
            $.ajax({
                url: "{{ route('admin.ebooks.toggleApproval') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                success: function(res) {
                    if(res.success) {
                        toastr.success('Approval status updated');
                        if(res.status == 'approved') {
                            btn.removeClass('badge-danger').addClass('badge-primary').text('Approved');
                            // Also update the status badge in the same row
                            btn.closest('tr').find('.badge-warning, .badge-danger').removeClass('badge-warning badge-danger').addClass('badge-success').text('Approved');
                        } else {
                            btn.removeClass('badge-primary').addClass('badge-danger').text('Pending');
                            btn.closest('tr').find('.badge-success').removeClass('badge-success').addClass('badge-warning').text('Pending');
                        }
                    }
                }
            });
        });

        // Live search ebooks with AJAX on keyup
        $(document).on('keyup', ".ebook-search", function(e){
            e.preventDefault();
            var that = $(this);
            var url = that.attr('data-url');
            var q = that.val();

            $.ajax({
                url: url,
                data : {q: q},
                method: "get",
                success: function(res) {
                    if(res.success) {
                        $(".data-container").empty().append(res.page);
                    }
                }
            });
        });
    });
</script>
@endpush
