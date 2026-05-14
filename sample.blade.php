@extends('frontend.layouts.ecommercemaster')
@section('title', "Shop Shasthoseba")

@push('css')
<style>
.card-hover {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card-hover:hover {
    transform: translateY(-1px) scale(1.01);
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.12);
}
</style>
@endpush

@section('content')
<section class="section my-0 py-0">
    <div class="container-fluid py-5">
        <div class="row g-4">
            
            <!-- Sidebar -->
            <div class="col-lg-2 order-2 order-lg-1 d-none d-lg-block">
                <aside class="sidebar">
                    <h5>Product Categories</h5>

                    <ul class="nav nav-list flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('productCategory') && !request()->segment(2) ? 'active' : '' }}" href="{{ route('productCategory') }}">
                                <span >All</span>
                            </a>
                        </li>

                        @foreach ($productCategories as $category)
                            @php
                                $isActiveParent = request()->segment(2) === $category->slug ||
                                                  ($category->children->isNotEmpty() && $category->children->pluck('slug')->contains(request()->segment(2)));
                            @endphp
                            <li class="nav-item">
                                <a class="nav-link parent-category {{ $isActiveParent ? 'active' : '' }}"
                                   href="{{ count($category->children) > 0 ? '#' : route('productCategory', $category->slug) }}"
                                   @if(count($category->children) > 0) data-bs-toggle="collapse" data-bs-target="#category-{{ $category->id }}" aria-expanded="{{ $isActiveParent ? 'true' : 'false' }}" @endif>
                                    <span>{{ $category->name_en }} </span>
                                    @if(count($category->children) > 0)
                                        <i class="fas fa-chevron-down float-end"></i>
                                    @endif
                                </a>
                                @if(count($category->children) > 0)
                                    <ul id="category-{{ $category->id }}" class="nav flex-column ms-3 collapse {{ $isActiveParent ? 'show' : '' }}">
                                        @foreach($category->children as $child)
                                            <li class="nav-item {{ request()->segment(2) === $child->slug ? 'active' : '' }}">
                                                <a class="nav-link" href="{{ route('productCategory', $child->slug) }}">{{ $child->name_en }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </aside>
            </div>

            <!-- Banner Slider start  -->
            <div class="col-12 col-lg-10 order-1 order-lg-2">
                {{--<section class="mb-3 d-block d-lg-none">
                    <div class="container">
                        <div class="card shadow-sm">
                            <div class="card-body p-2">
                                <div class="owl-carousel owl-theme" data-plugin-options="{'items': 1, 'margin': 10, 'loop': true, 'nav': false, 'dots': false, 'autoplay': true}" style="margin-bottom: 2px">
                                    <div>
                                        <a href="#">
                                            <img class="img-fluid rounded" src="{{ asset('frontend/assets/img/flash-sale.gif') }}" alt="Flash Sale 1">
                                        </a>
                                    </div>
                                    <div>
                                        <a href="#">
                                            <img class="img-fluid rounded" src="{{ asset('frontend/assets/img/flash-sale.gif') }}" alt="Flash Sale 2">
                                        </a>
                                    </div>
                                    <div>
                                        <a href="#">
                                            <img class="img-fluid rounded" src="{{ asset('frontend/assets/img/flash-sale.gif') }}" alt="Flash Sale 3">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>--}}

                <!-- single banner  -->
                @if($banner)
                <section class="mb-3 d-block d-lg-none">
                    <div class="container">
                        <div class="card shadow-sm">
                            <div class="card-body p-2 text-center">
                                <a href="{{ $banner->link }}">
                                    <img class="img-fluid rounded"
                                        src="{{ route('imagecache', ['template' => 'original', 'filename' => $banner->fi()]) }}"
                                        alt="{{ $banner->title }}">
                                </a>
                            </div>
                        </div>
                    </div>
                </section>
                @else
                <section class="mb-3 d-block d-lg-none">
                    <div class="container">
                        <div class="card shadow-sm">
                            <div class="card-body p-2 text-center">
                                <a href="#">
                                    <img class="img-fluid rounded"
                                        src="{{ asset('frontend/assets/img/flash-sale.gif') }}"
                                        alt="Flash Sale">
                                </a>
                            </div>
                        </div>
                    </div>
                </section>
                @endif

                
                <!-- Marquee -->
                @if($offers->count() > 0)
                    <marquee behavior="scroll" direction="left" scrollamount="5" style="font-weight:bold; color:red;">
                        @foreach($offers as $key => $offer)
                            {{ $offer->text }}
                            @if($key < $offers->count() - 1)
                                &nbsp;&nbsp; | &nbsp;&nbsp;
                            @endif
                        @endforeach
                    </marquee>
                @else
                    <marquee behavior="scroll" direction="left" scrollamount="5" style="font-weight:bold; color:red;">
                        🎉 Special Offer: 50% OFF on all products! Hurry up! 🎉
                    </marquee>
                @endif


                <!-- Mobile Category Buttons -->
                <div class="d-flex overflow-x-auto mb-4">
                    <div class="d-flex flex-nowrap d-lg-none">

                        <!-- All Category -->
                        <a href="{{ route('shop.shasthoseba') }}" 
                        class="btn btn-outline-primary m-1 d-flex align-items-center rounded-pill {{ request()->routeIs('shop.shasthoseba') ? 'active' : '' }}"
                        style="{{ request()->routeIs('shop.shasthoseba') ? 'background-color: #2D529F; border-color: #2D529F; color: #fff;' : '' }}">
                            <span class="ms-2 text-nowrap" 
                                style="color: {{ request()->routeIs('shop.shasthoseba') ? '#fff' : '#2D529F' }};">
                                All Category
                            </span>
                        </a>

                        <!-- Subcategories -->
                        @foreach ($subcategories as $subcategory)
                            <a href="{{ route('productCategory', $subcategory->slug) }}" 
                            class="btn btn-outline-primary m-1 d-flex align-items-center rounded-pill {{ request()->segment(2) == $subcategory->slug ? 'active' : '' }}"
                            style="{{ request()->segment(2) == $subcategory->slug ? 'background-color: #2D529F; border-color: #2D529F; color: #fff;' : '' }}">
                                <img src="{{ route('imagecache', ['template' => 'pnism', 'filename' => $subcategory->fi()]) }}" 
                                    alt="{{ $subcategory->name_en }}" class="rounded-circle" width="30" height="30">
                                <span class="ms-2 text-nowrap" 
                                    style="color: {{ request()->segment(2) == $subcategory->slug ? '#fff' : '#2D529F' }};">
                                    {{ $subcategory->name_en }}
                                </span>
                            </a>
                        @endforeach

                    </div>
                </div>


                <!-- Top filter section -->
                <div class="row mb-4 align-items-center">
                    <div class="col-md-6">
                        <form method="GET" class="d-flex align-items-center gap-2">
                            <select name="sort" id="sort" class="form-select w-auto" onchange="this.form.submit()">
                                <option value="1" @if(request()->get('sort')==1) selected @endif>Sort by Latest</option>
                                <option value="2" @if(request()->get('sort')==2) selected @endif>Sort by Oldest</option>
                                <option value="3" @if(request()->get('sort')==3) selected @endif>Sort by Price: High → Low</option>
                                <option value="4" @if(request()->get('sort')==4) selected @endif>Sort by Price: Low → High</option>
                            </select>
                            <input type="hidden" name="min_price" value="{{ request()->get('min_price') }}">
                            <input type="hidden" name="max_price" value="{{ request()->get('max_price') }}">
                        </form>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <span class="text-muted">
                            Showing <strong>{{ $products->firstItem() }} - {{ $products->lastItem() }}</strong> of
                            <strong>{{ $products->total() }}</strong> results
                        </span>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="row g-4">
                    @foreach ($products as $product)
                        <div class="col-6 col-md-3 col-lg-2">
                            <div class="card h-100 border-0 shadow-sm card-hover">

                                <!-- Image -->
                                <a href="{{ route('productDetails', $product->slug) }}" class="d-block">
                                    <img src="{{ route('imagecache', ['template' => 'pnism', 'filename' => $product->fi()]) }}" 
                                         class="card-img-top rounded-top" 
                                         alt="{{ $product->name_en }}">
                                </a>

                                <!-- Body -->
                                <div class="card-body d-flex flex-column p-3">

                                    <!-- Category -->
                                    <small class="d-block text-uppercase mb-1">
                                        @foreach ($product->categories as $key => $cat)
                                            <span class="font-weight-bold" style="color: #dc3545">
                                                {{ $cat->name_en }}
                                            </span>@if(!$loop->last), @endif
                                        @endforeach
                                    </small>

                                    <!-- Product Name -->
                                    <h6 class="fw-semibold text-truncate mb-1">
                                        <a href="{{ route('productDetails', $product->slug) }}" 
                                           class="text-dark text-decoration-none">
                                            {{ $product->name_en }}
                                        </a>
                                    </h6>

                                    <!-- Price -->
                                    <div class="mb-1">
                                        @if($product->discount > 0.00)
                                            <span class="text-muted text-decoration-line-through me-2 w3-small">
                                                {{ number_format($product->price, 2) }} ৳
                                            </span>
                                        @endif
                                        <span class="fw-bold text-primary w3-small">
                                            {{ number_format($product->final_price, 2) }} ৳
                                        </span>
                                    </div>

                                    <!-- Add to Cart -->
                                    <div class="mt-auto productCartItem" data-product="{{ $product->id }}">
                                        @include('frontend.home.includes.productCartItem')
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="row mt-4">
                    <div class="col">
                        <nav>
                            <ul class="pagination justify-content-end mb-0">
                                {{ $products->links() }}
                            </ul>
                        </nav>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection

@push('js')
<script>
@if(session('success'))
    Swal.fire({
        toast: true,
        icon: 'success',
        title: "{{ session('success') }}",
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });
@endif
</script>
@endpush
