@extends('admin.master')

@section('title')
   Admin Dashboard | Product Categories All
@endsection

@push('css')
<!-- Add custom styles here if needed -->
@endpush

@section('body')
<section class="content py-3">
    <div class="row">
        <div class="col-md-11 mx-auto">

            <!-- Top Header Card -->
            <div class="card mb-2 shadow-lg">
                <div class="card-header- px-2 py-2 d-flex justify-content-between align-items-center">
                    <h3 class="card-title w3-small text-bold text-muted pt-1">
                        <i class="fas fa-sitemap text-primary"></i> Categories
                    </h3>
                    <a href="{{ route('admin.productCategoryCreate') }}" class="btn btn-outline-primary btn-xs py-1">
                        <i class="fas fa-plus-square"></i> Add New Category
                    </a>
                </div>
           
            </div>

            <!-- Categories Table Card -->
            <div class="card w3-round shadow-lg">
                <div class="card-header pl-2 py-2">
                    <div class="d-flex justify-content-between align-items-center">
                      <h3 class="card-title w3-small text-bold text-muted">
                        <i class="fas fa-th text-primary pt-1"></i> All Categories 
                      </h3>

                        <!-- Search Box -->
                        <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <input type="search" name="q" class="category-search form-control border-right-0 border py-2"
                                data-url="{{ route('admin.productSearch', ['type' => 'category']) }}"
                                placeholder="Search name, id...">
                            <div class="input-group-append">
                                <button type="submit" class="input-group-text bg-transparent">
                                    <i class="fa fa-search w3-text-orange"></i>
                                </button>
                            </div>
                        </div>
                        </div>
                    </div>
                   
                </div>

                {{-- Type filter tabs --}}
                <div class="card-header bg-light border-bottom-0 py-2">
                    <ul class="nav nav-pills w3-small">
                        <li class="nav-item">
                            <a class="nav-link py-1 px-3 {{ !$activeType ? 'active' : '' }}" 
                               href="{{ route('admin.productCategoriesAll') }}">
                                All <span class="badge badge-light ml-1">{{ $totalCount }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link py-1 px-3 {{ $activeType === 'product' ? 'active' : '' }}" 
                               href="{{ route('admin.productCategoriesAll', ['type' => 'product']) }}">
                                <i class="fas fa-box text-info"></i> Product <span class="badge badge-light ml-1">{{ $productCount }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link py-1 px-3 {{ $activeType === 'course' ? 'active' : '' }}" 
                               href="{{ route('admin.productCategoriesAll', ['type' => 'course']) }}">
                                <i class="fas fa-graduation-cap text-success"></i> Course <span class="badge badge-light ml-1">{{ $courseCount }}</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Categories Table -->
                <div class="card-body bg-light px-0 pb-0 pt-2">
                    <div class="col-sm-12">
                        <div class="table-responsive data-container">
                            @include('admin.productCategories.searchData')
                        </div>
                        <div class="w3-small float-right pt-1">
                            {!! $categories->links() !!}
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

        // Toggle Category Status
        $(document).on('click', ".categoryStatus", function(e){
            e.preventDefault();
            const $btn = $(this);
            const url = $btn.data('url');

            $.get(url, function(res) {
                if (res.active) {
                    $btn.removeClass('badge-danger').addClass('badge-primary').text('Active');
                } else {
                    $btn.removeClass('badge-primary').addClass('badge-danger').text('Inactive');
                }
            });
        });

        // Live Search for Categories
        $(document).on('keyup', ".category-search", function(e){
            e.preventDefault();
            const $input = $(this);
            const url = $input.data('url');
            const query = $input.val();

            // Get current filter type from URL query string
            const urlParams = new URLSearchParams(window.location.search);
            const filterType = urlParams.get('type') || '';

            $.get(url, { q: query, filter_type: filterType }, function(res) {
                if (res.success) {
                    $(".data-container").html(res.page);
                }
            });
        });
    });

    // Convert string to slug
    function makeSlug(val) {
        const slug = val.trim().replace(/\s+/g, '-').toLowerCase();
        $('#slug').val(slug);
    }
</script>
@endpush
