@extends('admin.master')

@section('title')
    Admin Dashboard | {{ env('APP_NAME') }}
@endsection

@section('body')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Dashboard Overview</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        {{-- Stat Cards --}}
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info shadow-sm">
                    <div class="inner">
                        <h3>{{ $todayOrders }}</h3>
                        <p>Today's Orders</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <a href="{{ route('admin.orderList') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success shadow-sm">
                    <div class="inner">
                        <h3>৳ {{ number_format($totalRevenue, 2) }}</h3>
                        <p>Total Revenue (Paid)</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <a href="{{ route('admin.orderList') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning shadow-sm">
                    <div class="inner">
                        <h3>{{ $pendingOrders }}</h3>
                        <p>Pending Orders</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <a href="{{ route('admin.orderList') }}?status=pending" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger shadow-sm">
                    <div class="inner">
                        <h3>{{ $productcount }}</h3>
                        <p>Active Products</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <a href="{{ route('admin.productsAll') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <div class="row">
            {{-- Recent Orders Table --}}
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header border-transparent">
                        <h3 class="card-title fw-bold">Recent Orders</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table m-0 table-hover table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentOrders as $order)
                                    <tr>
                                        <td><a href="#">#{{ $order->id }}</a></td>
                                        <td>{{ $order->name }}</td>
                                        <td>৳ {{ number_format($order->total_price ?? $order->grand_total ?? 0, 2) }}</td>
                                        <td>
                                            <span class="badge {{ $order->order_status == 'pending' ? 'bg-warning' : ($order->order_status == 'completed' ? 'bg-success' : 'bg-secondary') }}">
                                                {{ ucfirst($order->order_status) }}
                                            </span>
                                        </td>
                                        <td>{{ $order->created_at->format('d M, Y') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No recent orders found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer clearfix">
                        <a href="{{ route('admin.orderList') }}" class="btn btn-sm btn-secondary float-right">View All Orders</a>
                    </div>
                </div>
            </div>

            {{-- Recently Added Products --}}
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title fw-bold">Latest Products</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <ul class="products-list product-list-in-card pl-2 pr-2">
                            @foreach($products as $product)
                            <li class="item d-flex align-items-center py-2 border-bottom">
                                <div class="product-img me-3">
                                    <img src="{{ route('imagecache', ['template' => 'sbixs', 'filename' => $product->fi()]) }}" alt="Product Image" class="rounded" style="width: 50px; height: 40px; object-fit: cover;">
                                </div>
                                <div class="product-info flex-grow-1">
                                    <a href="{{ route('admin.productEdit', $product) }}" class="product-title fw-bold text-dark">
                                        {{ Str::limit($product->name_en, 25) }}
                                        <span class="badge badge-info float-right">৳ {{ $product->selling_price }}</span>
                                    </a>
                                    <span class="product-description d-block text-muted small">
                                        Stock: {{ $product->stock ?? 'N/A' }}
                                    </span>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('admin.productsAll') }}" class="uppercase text-muted small fw-bold">View All Products</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
