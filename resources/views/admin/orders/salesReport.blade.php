@extends('admin.master')

@section('title') Admin Dashboard | {{ $title }} @endsection

@push('css')
<style>
    .sales-card {
        transition: transform 0.2s;
    }
    .sales-card:hover {
        transform: translateY(-5px);
    }
</style>
@endpush

@section('body')
<section class="content py-3">
    <div class="row">
        <div class="col-md-11 mx-auto">
            <h2 class="mb-4 text-muted"><i class="fas fa-chart-line text-primary"></i> {{ $title }}</h2>
            
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card bg-gradient-info text-white shadow sales-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-uppercase mb-1">Total Sales (Paid)</h6>
                                    <h3 class="font-weight-bold mb-0">৳ {{ number_format($totalSales, 2) }}</h3>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-money-bill-wave fa-3x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-gradient-success text-white shadow sales-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-uppercase mb-1">Total Orders</h6>
                                    <h3 class="font-weight-bold mb-0">{{ $totalOrders }}</h3>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-shopping-cart fa-3x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0 text-muted"><i class="fas fa-filter mr-1"></i> Filter Report</h5>
                </div>
                <div class="card-body">
                    <form action="" method="get">
                        <div class="form-row align-items-end">
                            <div class="form-group input-group-sm col-md-2">
                                <label class="text-muted small font-weight-bold">Date From</label>
                                <input type="date" name="date_from" class="form-control border-info" value="{{ request()->date_from }}">
                            </div>
                            <div class="form-group input-group-sm col-md-2">
                                <label class="text-muted small font-weight-bold">Date To</label>
                                <input type="date" name="date_to" class="form-control border-info" value="{{ request()->date_to }}">
                            </div>
                            <div class="form-group input-group-sm col-md-2">
                                <label class="text-muted small font-weight-bold">Order Status</label>
                                <select name="status" class="form-control border-info">
                                    <option value="">All Status</option>
                                    @foreach (config('parameter.order_status') as $item)
                                        <option value="{{ $item }}" {{ $item == request()->status ? 'selected' : '' }}>{{ ucfirst($item) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group input-group-sm col-md-2">
                                <label class="text-muted small font-weight-bold">Mobile Number</label>
                                <input type="text" name="mobile" class="form-control border-info" value="{{ request()->mobile }}" placeholder="Mobile">
                            </div>
                            <div class="form-group col-auto">
                                <button type="submit" class="btn btn-warning btn-sm px-4 shadow-sm">
                                    <i class="fas fa-search mr-1"></i> Search
                                </button>
                            </div>
                            <div class="form-group col-auto">
                                <a href="{{ url()->current() }}?{{ http_build_query(array_merge(request()->query(), ['download' => 'excel'])) }}" 
                                   class="btn btn-success btn-sm px-4 shadow-sm">
                                    <i class="fas fa-file-excel mr-1"></i> Export Excel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Orders Table -->
            <div class="card w3-round shadow-lg border-0">
                <div class="card-header bg-white pl-2 py-2">
                    <h3 class="card-title w3-small text-bold text-muted pt-2">
                        <i class="fas fa-list text-primary mr-1"></i> Sales Data Breakdown
                    </h3>
                </div>
                <div class="card-body bg-light px-0 pb-0 pt-2">
                    <div class="col-sm-12">
                        @include('admin.orders.includes.orderListPart')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
