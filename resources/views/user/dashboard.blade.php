@extends('website.layouts.mncofee')

@section('title', 'Member Dashboard - '. ($ws->name ?? env('APP_NAME')))

@section('meta')
<meta name="description" content="Manage your account, view orders, and more.">
@endsection

@push('css')
<style>
    .ad-menu-banner {
        background-image: url("{{ asset('mncofee/assets/img/aida-images/menu-banner.png') }}") !important;
        background-size: cover;
        background-position: center;
        height: 250px;
    }
    .dashboard-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        overflow: hidden;
        margin-bottom: 30px;
        background: #fff;
    }
    .dashboard-card-header {
        background-color: #A45517;
        color: #fff;
        padding: 15px 25px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .dashboard-card-body {
        padding: 30px;
    }
    .nav-dashboard {
        background: #fff;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        margin-bottom: 30px;
    }
    .nav-dashboard .nav-link {
        color: #333;
        font-weight: 500;
        padding: 12px 20px;
        border-radius: 10px;
        margin-bottom: 5px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: 0.3s;
    }
    .nav-dashboard .nav-link:hover, .nav-dashboard .nav-link.active {
        background-color: #A45517;
        color: #fff;
    }
    .nav-dashboard .nav-link i {
        margin-left: 10px;
        opacity: 0.7;
    }
    .status-badge {
        display: inline-block;
        padding: 5px 12px;
        font-size: 12px;
        font-weight: 600;
        border-radius: 50px;
        color: #fff;
        text-transform: capitalize;
    }
    .status-pending { background-color: #ff9800; }
    .status-accepted { background-color: #03a9f4; }
    .status-approved { background-color: #4caf50; }
    .status-rejected { background-color: #f44336; }
    .status-default { background-color: #757575; }

    .table {
        border-collapse: separate;
        border-spacing: 0 10px;
    }
    .table thead th {
        border: none;
        background: #f8f9fa;
        padding: 15px;
        font-weight: 600;
    }
    .table tbody tr {
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        transition: 0.3s;
    }
    .table tbody td {
        background: #fff;
        padding: 15px;
        vertical-align: middle;
        border-top: 1px solid #f1f1f1;
        border-bottom: 1px solid #f1f1f1;
    }
    .table tbody td:first-child { border-left: 1px solid #f1f1f1; border-radius: 10px 0 0 10px; }
    .table tbody td:last-child { border-right: 1px solid #f1f1f1; border-radius: 0 10px 10px 0; }
    
    .btn-action {
        width: 35px;
        height: 35px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: #f8f9fa;
        color: #A45517;
        transition: 0.3s;
    }
    .btn-action:hover {
        background: #A45517;
        color: #fff;
    }
</style>
@endpush

@section('content')
<!--------------- 
    Banner 
---------------->
<section>
    <div class="ad-menu-banner position-relative">
        <div class="ad-menu-banner-overlay">
            <div>
                <a href="{{ route('home') }}">Home /</a>
                <a class="selected-page" href="#"> My Account</a>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <!-- Sidebar Navigation -->
            <div class="col-lg-4">
                <div class="nav-dashboard">
                    <div class="nav flex-column nav-pills">
                        <a class="nav-link {{ $activeTab == 'dashboard' ? 'active' : '' }}" data-bs-toggle="pill" href="#tab-dashboard">Dashboard <i class="fas fa-home"></i></a>
                        <a class="nav-link {{ $activeTab == 'order' ? 'active' : '' }}" href="{{ route('user.orders', ['type' => 'all']) }}">Orders <i class="fas fa-file-alt"></i></a>
                        {{--<a class="nav-link {{ $activeTab == 'feature_products' ? 'active' : '' }}" href="{{ route('user.feature_products') }}">Feature Products <i class="fas fa-star"></i></a>
                        <a class="nav-link {{ $activeTab == 'stock_requests' ? 'active' : '' }}" data-bs-toggle="pill" href="#tab-stock-requests">My Stock Requests <i class="fas fa-cubes"></i></a>
                        <a class="nav-link {{ $activeTab == 'create_stock_request' ? 'active' : '' }}" data-bs-toggle="pill" href="#tab-create-stock-request">Add Stock Request <i class="fas fa-plus-circle"></i></a>--}}
                        <a class="nav-link" data-bs-toggle="pill" href="#tab-address">Address <i class="fas fa-map-marker-alt"></i></a>
                        <a class="nav-link" data-bs-toggle="pill" href="#tab-account">Account Details <i class="fas fa-user"></i></a>
                        <a class="nav-link text-danger" href="{{ route('logout') }}">Logout <i class="fas fa-sign-out-alt"></i></a>
                    </div>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="col-lg-8">
                <div class="tab-content">
                    <!-- Dashboard Tab -->
                    <div class="tab-pane fade {{ $activeTab == 'dashboard' ? 'show active' : '' }}" id="tab-dashboard">
                        <div class="dashboard-card">
                            <div class="dashboard-card-header">
                                <i class="fas fa-user-circle"></i> WELCOME
                            </div>
                            <div class="dashboard-card-body">
                                <h3>Hello, <strong>{{ auth()->user()->name ?? 'User' }}</strong></h3>
                                <p class="text-muted mt-3">From your account dashboard you can view your <span>recent orders</span>, manage your <span>shipping and billing addresses</span>, and <span>edit your password and account details</span>.</p>
                                
                                <div class="row mt-4">
                                    <div class="col-md-4 mb-3">
                                        <div class="p-4 border rounded text-center bg-white shadow-sm">
                                            <i class="fas fa-shopping-bag fa-2x mb-3" style="color: #A45517;"></i>
                                            <h5 class="mb-1">{{ $orders->count() }}</h5>
                                            <small class="text-muted">Total Orders</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="p-4 border rounded text-center bg-white shadow-sm">
                                            <i class="fas fa-cubes fa-2x mb-3" style="color: #A45517;"></i>
                                            <h5 class="mb-1">{{ $stockRequests->count() }}</h5>
                                            <small class="text-muted">Stock Requests</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="p-4 border rounded text-center bg-white shadow-sm">
                                            <i class="fas fa-clock fa-2x mb-3" style="color: #A45517;"></i>
                                            <h5 class="mb-1">{{ now()->format('M d, Y') }}</h5>
                                            <small class="text-muted">Current Date</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Orders Tab (Logic handled via redirect but structure preserved for visual) -->
                    <div class="tab-pane fade {{ $activeTab == 'order' ? 'show active' : '' }}" id="tab-orders">
                        <div class="dashboard-card">
                            <div class="dashboard-card-header justify-content-between">
                                <div><i class="fas fa-file-alt"></i> MY ORDERS</div>
                                @if(isset($type))
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('user.orders', ['type' => 'all']) }}" class="btn btn-sm {{ $type=='all'?'btn-light text-dark':'btn-outline-light' }}">All</a>
                                    <a href="{{ route('user.orders', ['type' => 'today']) }}" class="btn btn-sm {{ $type=='today'?'btn-light text-dark':'btn-outline-light' }}">Today</a>
                                </div>
                                @endif
                            </div>
                            <div class="dashboard-card-body p-0">
                                @if($orders->count())
                                    <div class="table-responsive p-3">
                                        <table class="table table-borderless align-middle mb-0">
                                            <thead>
                                                <tr>
                                                    <th>ORDER #</th>
                                                    <th>DATE</th>
                                                    <th>STATUS</th>
                                                    <th>TOTAL</th>
                                                    <th>ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($orders as $order)
                                                <tr>
                                                    <td><strong>#{{ $order->id }}</strong></td>
                                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                                    <td>
                                                        <span class="status-badge {{ str_contains(strtolower($order->order_status), 'pending') ? 'status-pending' : (str_contains(strtolower($order->order_status), 'cancel') ? 'status-rejected' : 'status-approved') }}">
                                                            {{ $order->order_status }}
                                                        </span>
                                                    </td>
                                                    <td>৳{{ number_format($order->grand_total, 2) }}</td>
                                                    <td>
                                                        <a class="btn-action" target="_blank" href="{{ route('user.orderPrint', $order->id) }}" title="Invoice"><i class="fas fa-file-invoice"></i></a>
                                                        <a class="btn-action" target="_blank" href="{{ route('user.orderChalan', $order->id) }}" title="Chalan"><i class="fas fa-receipt"></i></a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="p-3 border-top">
                                        {{ $orders->links() }}
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <i class="fas fa-box-open fa-3x mb-3 text-muted"></i>
                                        <p class="text-muted">No orders found.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Featured Products Tab -->
                    <div class="tab-pane fade {{ $activeTab == 'feature_products' ? 'show active' : '' }}" id="tab-feature-products">
                        <div class="dashboard-card">
                            <div class="dashboard-card-header justify-content-between">
                                <div><i class="fas fa-star"></i> FEATURED PRODUCTS</div>
                                <a href="{{ route('user.stock_requests.create') }}" class="btn btn-sm btn-light">Stock Request</a>
                            </div>
                            <div class="dashboard-card-body p-0">
                                @if($featured_products->count())
                                    <div class="table-responsive p-3">
                                        <table class="table table-borderless align-middle mb-0">
                                            <thead>
                                                <tr>
                                                    <th>IMAGE</th>
                                                    <th>PRODUCT</th>
                                                    <th>PRICE</th>
                                                    <th>ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($featured_products as $product)
                                                <tr>
                                                    <td>
                                                        <img src="{{ asset('storage/product_images/'.$product->featured_image) }}" 
                                                             alt="{{ $product->name_en }}" 
                                                             class="rounded" 
                                                             style="width: 50px; height: 50px; object-fit: cover;">
                                                    </td>
                                                    <td><strong>{{ $product->name_en }}</strong></td>
                                                    <td>৳{{ number_format($product->final_price, 2) }}</td>
                                                    <td>
                                                        <a class="btn-action" target="_blank" href="{{ route('productDetails', $product->slug) }}" title="View"><i class="fas fa-eye"></i></a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="p-3 border-top">
                                        {{ $featured_products->links() }}
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <i class="fas fa-star fa-3x mb-3 text-muted"></i>
                                        <p class="text-muted">No featured products found.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Stock Requests Tab -->
                    <div class="tab-pane fade {{ $activeTab == 'stock_requests' ? 'show active' : '' }}" id="tab-stock-requests">
                        <div class="dashboard-card">
                            <div class="dashboard-card-header justify-content-between">
                                <div><i class="fas fa-cubes"></i> MY STOCK REQUESTS</div>
                                <a href="#tab-create-stock-request" data-bs-toggle="pill" class="btn btn-sm btn-light">Add New</a>
                            </div>
                            <div class="dashboard-card-body p-0">
                                <div class="table-responsive p-3">
                                    <table class="table table-borderless align-middle mb-0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>PRODUCT</th>
                                                <th>QTY</th>
                                                <th>DATE</th>
                                                <th>STATUS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($stockRequests as $request)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td><strong>{{ $request->product->name_en ?? 'N/A' }}</strong></td>
                                                <td>{{ $request->quantity }}</td>
                                                <td>{{ \Carbon\Carbon::parse($request->collection_datetime)->format('M d, Y') }}</td>
                                                <td>
                                                    @php
                                                        $status = strtolower(trim($request->status));
                                                        $statusClass = match ($status) {
                                                            'pending'  => 'status-pending',
                                                            'accepted' => 'status-accepted',
                                                            'approved' => 'status-approved',
                                                            'rejected' => 'status-rejected',
                                                            default    => 'status-default'
                                                        };
                                                    @endphp
                                                    <span class="status-badge {{ $statusClass }}">{{ $status }}</span>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-5">No stock requests found.</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="p-3 border-top">
                                    {{ $stockRequests->links() }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Create Stock Request Tab -->
                    <div class="tab-pane fade {{ $activeTab == 'create_stock_request' ? 'show active' : '' }}" id="tab-create-stock-request">
                        <div class="dashboard-card">
                            <div class="dashboard-card-header">
                                <i class="fas fa-plus-circle"></i> NEW STOCK REQUEST
                            </div>
                            <div class="dashboard-card-body">
                                <form action="{{ route('user.stock_requests.store') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label class="form-label font-weight-bold">Select Product</label>
                                            <select name="product_id" class="form-control @error('product_id') is-invalid @enderror">
                                                <option value="">Choose a product...</option>
                                                @foreach($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->name_en }}</option>
                                                @endforeach
                                            </select>
                                            @error('product_id') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Quantity</label>
                                            <input type="number" name="quantity" class="form-control" step="0.01" placeholder="Enter quantity">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Collection Date/Time</label>
                                            <input type="datetime-local" name="collection_datetime" class="form-control">
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label">Collection Location</label>
                                            <textarea name="collection_location" class="form-control" rows="2" placeholder="Where will you collect?"></textarea>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn w-100" style="background: #A45517; color: white; border-radius: 50px; padding: 12px;">SUBMIT REQUEST</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Account Details Tab -->
                    <div class="tab-pane fade" id="tab-account">
                        <div class="dashboard-card">
                            <div class="dashboard-card-header">
                                <i class="fas fa-user-edit"></i> ACCOUNT DETAILS
                            </div>
                            <div class="dashboard-card-body">
                                <form action="#">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Full Name</label>
                                            <input type="text" class="form-control" value="{{ auth()->user()->name }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Email Address</label>
                                            <input type="email" class="form-control" value="{{ auth()->user()->email }}" disabled>
                                        </div>
                                        <div class="col-12 mb-4">
                                            <hr>
                                            <h5 class="mb-3">Password Change</h5>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label">Current Password</label>
                                            <input type="password" class="form-control" placeholder="Leave blank to keep current">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">New Password</label>
                                            <input type="password" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Confirm New Password</label>
                                            <input type="password" class="form-control">
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn w-100" style="background: #A45517; color: white; border-radius: 50px; padding: 12px;">UPDATE ACCOUNT</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Address Tab -->
                    <div class="tab-pane fade" id="tab-address">
                        <div class="dashboard-card">
                            <div class="dashboard-card-header">
                                <i class="fas fa-map-marker-alt"></i> MY ADDRESSES
                            </div>
                            <div class="dashboard-card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="p-4 border rounded bg-light">
                                            <h6 class="mb-3 text-uppercase font-weight-bold">Billing Address</h6>
                                            @php $dl = auth()->user()->locations()->first(); @endphp
                                            @if($dl)
                                                <p class="mb-1"><strong>{{ $dl->name }}</strong></p>
                                                <p class="mb-1 small text-muted">{{ $dl->address_title }}</p>
                                                <p class="mb-0 small text-muted">Phone: {{ $dl->mobile }}</p>
                                            @else
                                                <p class="small text-muted">No billing address saved.</p>
                                            @endif
                                            <a href="#" class="mt-3 d-inline-block small text-decoration-none" style="color: #A45517;">Edit Address</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
    // Ensure URL hash matches active tab
    $(document).ready(function() {
        var hash = window.location.hash;
        if (hash) {
            $('.nav-pills a[href="' + hash + '"]').tab('show');
        }
        
        $('.nav-pills a').on('click', function() {
            window.location.hash = $(this).attr('href');
        });
    });
</script>
@endpush
