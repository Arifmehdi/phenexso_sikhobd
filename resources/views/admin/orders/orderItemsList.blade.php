@extends('admin.master')

@section('title') Admin Dashboard | Product-wise Order List @endsection

@section('body')
@php use Illuminate\Support\Str; @endphp
<section class="content py-3">
    <div class="row">
        <div class="col-md-11 mx-auto">

            <!-- Tabs -->
            <ul class="nav nav-pills mb-3">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.orderList') }}"><i class="fas fa-file-invoice"></i> Invoice List</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('admin.orderItems') }}"><i class="fas fa-boxes"></i> Product List</a>
                </li>
            </ul>

            <!-- Filter Card -->
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.orderItems') }}" method="get">
                        <div class="form-row">
                            <div class="form-group input-group-sm col-md-2">
                                <label>Date From</label>
                                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                            </div>
                            <div class="form-group input-group-sm col-md-2">
                                <label>Date To</label>
                                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                            </div>
                            <div class="form-group input-group-sm col-md-2">
                                <label>Order Status</label>
                                <select name="status" class="form-control">
                                    <option value="">All Status</option>
                                    @foreach (config('parameter.order_status') as $item)
                                        <option value="{{ $item }}" {{ $item == request('status') ? 'selected' : '' }}>{{ ucfirst($item) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group input-group-sm col-md-2">
                                <label>Product</label>
                                <input type="text" name="product" class="form-control" value="{{ request('product') }}" placeholder="Product name">
                            </div>
                            <div class="form-group input-group-sm col-md-2">
                                <label>Mobile</label>
                                <input type="text" name="mobile" class="form-control" value="{{ request('mobile') }}" placeholder="Mobile">
                            </div>
                            <div class="form-group col-auto align-self-end">
                                <button type="submit" class="btn btn-warning btn-sm">Search</button>
                                <a href="{{ route('admin.orderItems') }}" class="btn btn-secondary btn-sm">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-md-11 mx-auto">
            <div class="card w3-round shadow-lg">
                <div class="card-header pl-2 py-2">
                    <h3 class="card-title w3-small text-bold text-muted pt-2">
                        <i class="fas fa-boxes text-primary"></i> Product-wise Orders
                    </h3>
                </div>
                <div class="card-body bg-light px-0 pb-0 pt-2">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-striped table-hover mb-1 bg-white">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#SL</th>
                                        <th>Order #</th>
                                        <th>Date</th>
                                        <th>Customer</th>
                                        <th>Phone</th>
                                        <th>Product</th>
                                        <th>Type</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-right">Unit Price</th>
                                        <th class="text-right">Total</th>
                                        <th>Order Status</th>
                                        <th>Payment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = (($items->currentPage() - 1) * $items->perPage() + 1); @endphp
                                    @forelse($items as $item)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>
                                            <a href="{{ route('admin.orderDeatils', $item->order_id) }}">
                                                {{ str_pad($item->order_id, 6, '0', STR_PAD_LEFT) }}
                                            </a>
                                        </td>
                                        <td>{{ optional($item->order)->created_at ? $item->order->created_at->format('d/m/Y') : '' }}</td>
                                        <td>{{ optional($item->order)->name }}</td>
                                        <td>{{ optional($item->order)->mobile }}</td>
                                        <td>{{ $item->product_name }}</td>
                                        <td>
                                            @if($item->ebook_id)
                                                <span class="badge badge-info">E-book</span>
                                            @elseif($item->product && $item->product->type === 'course')
                                                <span class="badge badge-primary">Course</span>
                                            @else
                                                <span class="badge badge-secondary">Product</span>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-right">৳{{ number_format($item->product_price, 2) }}</td>
                                        <td class="text-right">৳{{ number_format($item->total_cost, 2) }}</td>
                                        <td>{{ optional($item->order)->order_status }}</td>
                                        <td>
                                            <span class="badge {{ optional($item->order)->payment_status == 'paid' ? 'badge-success' : 'badge-warning' }}">
                                                {{ optional($item->order)->payment_status }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="12" class="text-center text-danger py-3">No products found</td></tr>
                                    @endforelse
                                    <tr>
                                        <th colspan="9" class="text-right">Total (this page)</th>
                                        <th class="text-right">৳{{ number_format($items->getCollection()->sum('total_cost'), 2) }}</th>
                                        <th colspan="2"></th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="w3-small float-right pt-1">
                            {!! $items->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
