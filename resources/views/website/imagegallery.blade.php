@extends('website.layouts.mncofee')

@section('title', 'Gallery - '.  env('APP_NAME'))

@section('meta')
<meta name="description" content="Explore the MN Coffee gallery - from farm sourcing in Bandarban to specialty coffee roasting.">
<meta name="keywords" content="MN Coffee, Coffee Gallery, Specialty Coffee Bangladesh, Bandarban Coffee Farmers">
@endsection

@push('css')
<style>
    .ad-menu-banner {
        background-image: url("{{ asset('mncofee/assets/img/aida-images/menu-banner.png') }}") !important;
        background-size: cover;
        background-position: center;
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
                <a class="selected-page" href="{{ route('image.galleries') }}"> Gallery</a>
            </div>
        </div>
    </div>
</section>

<!-- Gallery Section -->
<section>
    <div class="all-product product-3 theme-1 cpy-6 py-5">
        <div class="product-inner">
            <div class="container">
                <div class="row">
                    <div class="section-head text-center" data-aos="fade-up" data-aos-duration="1000">
                        <span class="sm-title" style="color: #A45517; font-weight: 600; text-transform: uppercase;">Our Gallery</span>
                        <h2 class="sec-title" style="font-family: 'Oswald', sans-serif; font-size: 40px; margin-top: 10px;">
                            Our Coffee Journey
                        </h2>
                    </div>
                </div>
                
                <div class="row mt-40" data-aos="fade-up" data-aos-duration="1000">
                    @forelse($images as $image)
                    <div class="col-xl-3 col-md-4 col-sm-6 col-12 mb-4">
                        <div class="product-card position-relative overflow-hidden" style="border-radius: 10px;">
                            <div class="product-img">
                                <a href="{{ route('imagecache', ['template' => 'original', 'filename' => $image->featured_image]) }}" data-fslightbox="gallery" data-type="image">
                                    <img src="{{ route('imagecache', ['template' => 'original', 'filename' => $image->featured_image]) }}" 
                                         alt="{{ $image->title }}" 
                                         class="w-100" 
                                         style="height: 250px; object-fit: cover; transition: transform 0.3s ease;">
                                </a>
                            </div>
                            <div class="view-project position-absolute bottom-0 start-0 w-100 p-3" style="background: rgba(0,0,0,0.6); color: white; transform: translateY(100%); transition: transform 0.3s ease;">
                                <div class="text-center">
                                    <h5 class="project-title mb-0" style="font-size: 18px;">{{ $image->title }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center">
                        <p>No images found in the gallery.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('js')
<style>
    .product-card:hover .view-project {
        transform: translateY(0) !important;
    }
    .product-card:hover img {
        transform: scale(1.1);
    }
</style>
@endpush
