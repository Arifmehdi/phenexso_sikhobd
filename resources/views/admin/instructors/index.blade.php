@extends('admin.master')
@section('title', 'Admin Dashboard | All Instructors')
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
                                <i class="fas fa-chalkboard-teacher text-primary"></i> All Instructors
                            </h3>
                            <div class="card-tools d-flex">
                                <div class="input-group input-group-sm mr-2" style="width: 250px;">
                                    <input type="search" name="q" class="global-search form-control float-right"
                                           data-url="{{ route('admin.global-search-ajax', ['type' => 'instructor']) }}"
                                           placeholder="Search instructors...">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <a href="{{ route('admin.instructors.create') }}" class="btn btn-sm btn-success mr-2">
                                    <i class="fas fa-plus"></i> Add New
                                </a>
                            </div>
                        </div>

                        <div class="card-body p-0 mb-0">
                            {{-- Filter Tabs --}}
                            <div class="px-3 pt-3">
                                <ul class="nav nav-pills">
                                    <li class="nav-item">
                                        <a class="nav-link {{ !request('status') ? 'active' : '' }}"
                                           href="{{ route('admin.instructors.index') }}">
                                            All <span class="badge badge-light ml-1">{{ $totalCount }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request('status') === 'approved' ? 'active' : '' }}"
                                           href="{{ route('admin.instructors.index', ['status' => 'approved']) }}">
                                            Approved <span class="badge badge-success ml-1">{{ $approvedCount }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request('status') === 'pending' ? 'active' : '' }}"
                                           href="{{ route('admin.instructors.index', ['status' => 'pending']) }}">
                                            Pending <span class="badge badge-warning ml-1">{{ $pendingCount }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="table-responsive data-container">
                                @include('admin.instructors.search_data')
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
                var status = '{{ request('status') }}';

                $.ajax({
                     url: url,
                     data : {q:q, status:status},
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