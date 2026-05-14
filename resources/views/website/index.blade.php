@extends('website.layouts.mncofee')

@section('title', 'Home - '. ($ws->name ?? env('APP_NAME')))

@section('meta')
<meta name="description" content="{{ $ws->meta_description ?? 'MN Coffee Coffee House offers premium coffee and world-class services.' }}">
<meta name="keywords" content="{{ $ws->meta_keywords ?? 'Coffee, MN Coffee, quality coffee' }}">
<meta property="og:title" content="Home - {{ $ws->name ?? env('APP_NAME') }}">
<meta property="og:description" content="{{ $ws->meta_description ?? 'Discover quality coffee at MN Coffee Coffee House.' }}">
<meta property="og:image" content="{{ route('imagecache', ['template' => 'original', 'filename' => $ws->logo()]) }}">
<meta property="og:type" content="website">
<meta name="robots" content="index, follow">
@endsection

@push('css')
<style>
    .ad-banner-content {
        background-image: url("{{ asset('mncofee/assets/img/aida-images/banner-shape.png') }}") !important;
    }
    .hero-slider {
        position: relative;
        overflow: hidden;
        background-color: #000;
    }
    .hero-slider .carousel-item {
        height: 100vh;
        min-height: 500px;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        transition: transform 1.2s cubic-bezier(0.7, 0, 0.3, 1);
    }
    @media (max-width: 768px) {
        .hero-slider .carousel-item {
            height: 80vh;
            min-height: 400px;
        }
    }
    .hero-slider .carousel-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to right, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.2) 100%);
        z-index: 1;
    }
    .hero-slider .carousel-caption {
        position: absolute;
        top: 50%;
        left: 8%;
        right: 8%;
        transform: translateY(-50%);
        z-index: 2;
        text-align: left;
        color: white;
        max-width: 700px;
        padding: 0;
        background: transparent;
        backdrop-filter: none;
        border: none;
        box-shadow: none;
    }
    .hero-slider .carousel-caption .caption-content {
        background: rgba(0, 0, 0, 0.3);
        backdrop-filter: blur(8px);
        padding: 3rem;
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s ease-out;
    }
    .hero-slider .carousel-item.active .carousel-caption .caption-content {
        opacity: 1;
        transform: translateY(0);
    }
    .hero-slider .carousel-caption h1 {
        font-family: 'Oswald', sans-serif;
        font-size: 4.5rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        text-transform: uppercase;
        line-height: 1.1;
        letter-spacing: -1px;
    }
    .hero-slider .carousel-caption p {
        font-family: 'Jost', sans-serif;
        font-size: 1.25rem;
        margin-bottom: 2.5rem;
        opacity: 0.9;
        line-height: 1.6;
        max-width: 90%;
    }
    .hero-slider .btn-hero {
        background: #A45517;
        color: white;
        border: 2px solid #A45517;
        padding: 16px 40px;
        font-size: 1rem;
        font-weight: 600;
        border-radius: 50px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        text-transform: uppercase;
        letter-spacing: 2px;
        position: relative;
        overflow: hidden;
        z-index: 1;
    }
    .hero-slider .btn-hero:hover {
        background: transparent;
        color: #A45517;
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
    }
    /* Custom Indicators */
    .hero-slider .carousel-indicators {
        bottom: 40px;
        justify-content: center;
        left: 0;
        right: 0;
        margin: 0 auto;
        z-index: 15;
        width: 100%;
    }
    .hero-slider .carousel-indicators [data-bs-target] {
        width: 60px;
        height: 4px;
        background-color: rgba(255, 255, 255, 0.3);
        border: none;
        border-radius: 2px;
        margin: 0 5px;
        transition: all 0.3s ease;
    }
    .hero-slider .carousel-indicators .active {
        background-color: #A45517;
        width: 100px;
    }

    /* Controls */
    .hero-slider .carousel-control-prev,
    .hero-slider .carousel-control-next {
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(5px);
        border-radius: 50%;
        top: 50%;
        transform: translateY(-50%);
        margin: 0 20px;
        opacity: 0;
        transition: all 0.4s ease;
        z-index: 10;
    }
    .hero-slider:hover .carousel-control-prev,
    .hero-slider:hover .carousel-control-next {
        opacity: 1;
    }
    .hero-slider .carousel-control-prev:hover,
    .hero-slider .carousel-control-next:hover {
        background: #A45517;
    }

    /* Hide any sidebar navigation if present */
    .sidebar-nav, .ad-sidebar-nav, .ad-side-menu {
        display: none !important;
    }

    @media (max-width: 992px) {
        .hero-slider .carousel-caption h1 {
            font-size: 3.5rem;
        }
    }

    @media (max-width: 768px) {
        .hero-slider .carousel-caption {
            left: 5%;
            right: 5%;
            text-align: center;
        }
        .hero-slider .carousel-caption .caption-content {
            padding: 2rem;
            border-radius: 15px;
        }
        .hero-slider .carousel-caption h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        .hero-slider .carousel-caption p {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            max-width: 100%;
        }
        .hero-slider .carousel-indicators {
            bottom: 20px;
        }
        .hero-slider .btn-hero {
            padding: 12px 30px;
        }
    }
    @media (max-width: 576px) {
        .hero-slider .carousel-caption h1 {
            font-size: 2rem;
        }
        .hero-slider .carousel-caption p {
            font-size: 0.95rem;
        }
    }
</style>
@endpush

@section('content')
        <!---------------
            Hero Slider
        -------------->
<section class="hero-slider">
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-indicators">
            @foreach($sliders as $key => $slider)
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}" aria-current="{{ $key == 0 ? 'true' : 'false' }}" aria-label="Slide {{ $key + 1 }}"></button>
            @endforeach
        </div>

        <div class="carousel-inner">
            @foreach($sliders as $key => $slider)
            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}" style="background-image: url('{{ route('imagecache', ['template' => 'original', 'filename' => $slider->fi()]) }}');">
                <div class="carousel-caption">
                    <div class="caption-content">
                        <p class="mb-3">{{ $slider->sub_title ?? 'Welcome to MN Coffee' }}</p>
                        <h1 class="animate-text">{{ $slider->title }}</h1>
                        @if($slider->link)
                        <a href="{{ $slider->link }}" class="btn btn-hero animate-button">Explore More</a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>


<!---------------
    About Us 
-------------->
<section class="ad-about-section">
    <div class="container ad-about-container">
        <div class="ad-about-image-container position-relative">
            <div class="ad-about-person-image">
                <img src="{{ asset('mncofee/assets/img/aida-images/about-picture1.png') }}" alt="">
            </div>
            <div class="mt-md-5 mt-4 ad-about-side-image-container">
                <img class="ad-about-side-tea" src="{{ asset('mncofee/assets/img/aida-images/about-picture2.png') }}" alt="">
                <img class=" ad-about-bottom-image" src="{{ asset('mncofee/assets/img/aida-images/about-picture3.png') }}" alt="">
                <div class="ad-about-rounded-text">
                    <img src="{{ asset('mncofee/assets/img/aida-images/about-rounded-shape.png') }}" alt="">
                </div>
            </div>
        </div>
        <div class="ad-about-text-container">
            <h5>{{ $content->subtitle ?? 'about us' }}</h5>
            <h4>
                {!! $content->title ?? 'MN Coffee <br class="d-none d-xxl-block"> Local Beans, Global Taste.' !!}
            </h4>
            <p>
                {{ $content->description ?? 'MN Coffee is a Bangladesh-based specialty coffee venture connecting hill farmers with urban cafés through a direct farm-to-market supply chain. We focus on improving quality, traceability, and farmer income by developing local Arabica production and better post-harvest practices.' }}
            </p>
            <div class="ad-about-list-container">
                @if(isset($content->highlights) && is_array($content->highlights))
                    @foreach($content->highlights as $highlight)
                    <div class="d-flex gap-3 align-items-center">
                        <i class="fa-regular fa-square-check"></i>
                        <p>{{ $highlight }}</p>
                    </div>
                    @endforeach
                @else
                    <div class="d-flex gap-3 align-items-center">
                        <i class="fa-regular fa-square-check"></i>
                        <p>B2B supply of roasted coffee beans (Arabica & Robusta)</p>
                    </div>
                    <div class="d-flex gap-3 align-items-center">
                        <i class="fa-regular fa-square-check"></i>
                        <p>Direct sourcing from Bandarban hill farmers</p>
                    </div>
                    <div class="d-flex gap-3 align-items-center">
                        <i class="fa-regular fa-square-check"></i>
                        <p>Custom roast profiles for cafés</p>
                    </div>
                    <div class="d-flex gap-3 align-items-center">
                        <i class="fa-regular fa-square-check"></i>
                        <p>Quality-controlled and traceable coffee supply</p>
                    </div>
                @endif
            </div>
            <a href="{{ route('about-us') }}">Read More</a>
        </div>
    </div>
</section>

<!---------------
    Video Section
-------------->
<section>
    <div class="ad-video-container position-relative">
        <img src="{{ asset('mncofee/assets/img/aida-images/video-shape.png') }}" alt="">
        <div class="ad-video-icon">
            <a class="text-decoration-none" href="https://youtu.be/Z6Dx-o3vfJY?si=_7CxQt0bH6A0VuJL" data-fslightbox>
                <i class="fa-solid fa-play"></i>
            </a>
        </div>
    </div>
</section>

<!-------------------
    Quality Service (Departments/Services)
----------------->
<section data-aos="fade-up">
    <div class="ad-service">
        <div class="ad-service-title-container">
            <img src="{{ asset('mncofee/assets/img/aida-images/service-icon.png') }}" alt="">
            <h4>{{ $content->meta['process_title'] ?? 'Our Specialty Process' }}</h4>
            <p>
                {{ $content->meta['process_subtitle'] ?? 'From direct farm sourcing to custom roasting, discover how we bring the best coffee to your cup.' }}
            </p>
        </div>
        <div class="container ad-service-container">
            @foreach($departments->take(3) as $dept)
            <div class="ad-single-service position-relative">
                <img src="{{ route('imagecache', ['template' => 'original', 'filename' => $dept->image ?? 'default.png']) }}" alt="{{ $dept->name_en }}" style="max-height: 100px; width: auto; margin-bottom: 20px;">
                <h5>{{ $dept->name_en }}</h5>
                <p>
                    {{ Str::limit($dept->excerpt_en, 100) }}
                </p>
                <a href="{{ route('service') }}" class="ad-service-btn">Read More</a>
                <img class="w-100 ad-service-image" src="{{ asset('mncofee/assets/img/aida-images/service-image1.png') }}" alt="">
                <div class="ad-single-service-overlay">
                    <div>
                        <img src="{{ route('imagecache', ['template' => 'original', 'filename' => $dept->image ?? 'default.png']) }}" alt="{{ $dept->name_en }}" style="max-height: 80px; width: auto; margin-bottom: 10px;">
                        <h5>{{ $dept->name_en }}</h5>
                        <p>
                            {{ Str::limit($dept->excerpt_en, 150) }}
                        </p>
                        <a href="{{ route('service') }}">Read More</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-------------------
    Special Offer (Products by Category)
----------------->
<section data-aos="fade-up">
    <div class="ad-offer">
        <div class="ad-offer-title-container">
            <img src="{{ asset('mncofee/assets/img/aida-images/service-icon.png') }}" alt="">
            <h4>{{ $content->meta['offer_title'] ?? 'Try Our Special Offers' }}</h4>
            <p>
                {{ $content->meta['offer_subtitle'] ?? 'Check out our featured products and special deals.' }}
            </p>
        </div>
        <ul class="nav ad-offer-tab-container" id="myTab" role="tablist">
            @foreach($categories->take(6) as $key => $category)
            <li class="nav-item" role="presentation">
                <button
                    class="nav-link {{ $key == 0 ? 'active' : '' }}"
                    id="cat-{{ $category->id }}-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#cat-{{ $category->id }}-tab-pane"
                    type="button"
                    role="tab"
                    aria-controls="cat-{{ $category->id }}-tab-pane"
                    aria-selected="{{ $key == 0 ? 'true' : 'false' }}"
                >
                    {{ strtoupper($category->name_en) }}
                </button>
            </li>
            @endforeach
        </ul>
        <div class="tab-content" id="myTabContent">
            @foreach($categories->take(6) as $key => $category)
            <div
                class="tab-pane fade {{ $key == 0 ? 'show active' : '' }}"
                id="cat-{{ $category->id }}-tab-pane"
                role="tabpanel"
                aria-labelledby="cat-{{ $category->id }}-tab"
                tabindex="0"
            >
                <div class="container ad-offer-container">
                    @foreach($category->products->where('feature', 1)->take(6) as $product)
                    <div class="ad-offer-single-card h-auto py-3">
                        <div class="">
                            <a href="{{ route('productDetails', $product->slug) }}">
                                <img src="{{ route('imagecache', ['template' => 'pnism', 'filename' => $product->fi()]) }}" alt="{{ $product->name_en }}" style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%;">
                            </a>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-baseline gap-2">
                                <div class="ad-offer-card-text-container flex-grow-1">
                                    <div class="d-flex flex-column">
                                        <small class="text-uppercase text-muted" style="font-size: 10px;">
                                            @foreach ($product->categories as $cat)
                                                {{ $cat->name_en }}@if(!$loop->last), @endif
                                            @endforeach
                                        </small>
                                        <h5 class="mb-0" style="width: auto; max-width: 260px;">{{ strtoupper($product->name_en) }}</h5>
                                    </div>
                                    <div class="d-none d-md-flex flex-grow-1 align-items-center">
                                        <span class="ad-offer-dotted w-100" style="border-bottom: 2px dotted #A45517; height: 1px; margin-bottom: 8px;"></span>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <div class="d-flex flex-column">
                                       {{-- @if($product->discount > 0)
                                            <span class="text-muted text-decoration-line-through small" style="font-size: 12px;">
                                                ৳{{ number_format($product->price, 2) }}
                                            </span>
                                        @endif--}}
                                        <span class="ad-offer-price" style="font-size: 24px;"> ৳{{ number_format($product->selling_price, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                            <p class="mb-2">{{ Str::limit(strip_tags($product->description_en), 80) }}</p>
                            <div class="mt-2 productCartItem" data-product="{{ $product->id }}" style="max-width: 220px;">
                                @include('frontend.home.includes.productCartItem')
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
        <div class="ad-offer-bottom-container">
            <div class="ad-offer-bottom-text-container">
                <div class="grad-border">
                    <div class="left-border"></div>
                    <div class="right-border"></div>
                </div>
                <h5>During winter daily from 7:30 am to 9.30 pm</h5>
                <div class="grad-border">
                    <div class="left-border"></div>
                    <div class="right-border"></div>
                </div>
            </div>
            <a href="{{ route('shop') }}">
                <button>
                    Order Online
                </button>
            </a>
        </div>
    </div>
</section>

<!-------------------
    Our Chef (Placeholder or Team)
----------------->
{{-- <section data-aos="fade-up">
    <div class="ad-chef">
        <div class="ad-chef-title-container">
            <img src="{{ asset('mncofee/assets/img/aida-images/service-icon.png') }}" alt="">
            <h4>Specialty Coffee Experts</h4>
            <p>
                Our team of dedicated coffee professionals ensures the highest quality in every bean.
            </p>
        </div>
        <div class="container ad-chef-container">
            <div class="position-relative ad-chef-card">
                <div class="ad-chef-single-card">
                    <div class="ad-chef-image d-flex gap-3 align-items-end">
                        <div class="overflow-hidden">
                            <a href="#">
                                <img src="{{ asset('mncofee/assets/img/aida-images/chef1.png') }}" class="ad-chef-person" alt="">
                            </a>
                        </div>
                        <div class="ad-chef-icon-container">
                            <i class="fa-brands fa-linkedin-in"></i>
                            <i class="fa-brands fa-twitter"></i>
                            <i class="fa-brands fa-instagram"></i>
                            <i class="fa-brands fa-facebook"></i>
                        </div>
                    </div>
                    <a href="#">
                        <h4>Alberto Da Silva</h4>
                    </a>
                    <p>Senior Chef</p>
                </div>
            </div>
            <div class="position-relative ad-chef-card">
                <div class="ad-chef-single-card">
                    <div class="ad-chef-image d-flex gap-3 align-items-end">
                        <div class="overflow-hidden">
                            <a href="#">
                                <img src="{{ asset('mncofee/assets/img/aida-images/chef2.png') }}" class="ad-chef-person" alt="">
                            </a>
                        </div>
                        <div class="ad-chef-icon-container">
                            <i class="fa-brands fa-linkedin-in"></i>
                            <i class="fa-brands fa-twitter"></i>
                            <i class="fa-brands fa-instagram"></i>
                            <i class="fa-brands fa-facebook"></i>
                        </div>
                    </div>
                    <a href="#">
                        <h4>Rachael Haynes</h4>
                    </a>
                    <p>Chef De Partie</p>
                </div>
            </div>
            <div class="position-relative ad-chef-card">
                <div class="ad-chef-single-card">
                    <div class="ad-chef-image d-flex gap-3 align-items-end">
                        <div class="overflow-hidden">
                            <a href="#">
                                <img src="{{ asset('mncofee/assets/img/aida-images/chef3.png') }}" class="ad-chef-person" alt="">
                            </a>
                        </div>
                        <div class="ad-chef-icon-container">
                            <i class="fa-brands fa-linkedin-in"></i>
                            <i class="fa-brands fa-twitter"></i>
                            <i class="fa-brands fa-instagram"></i>
                            <i class="fa-brands fa-facebook"></i>
                        </div>
                    </div>
                    <a href="#">
                        <h4>James Anderson</h4>
                    </a>
                    <p>Resta Marketing</p>
                </div>
            </div>
        </div>
    </div>
</section>--}}

<!-----------------------
    Counters Section (Modernized)
---------------------->
<section class="py-5 position-relative overflow-hidden" style="background: url('{{ asset($content->meta['counter_bg'] ?? 'mncofee/assets/img/aida-images/reservation-bg.png') }}') center/cover no-repeat fixed;">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(0,0,0,0.7); backdrop-filter: blur(2px);"></div>
    <div class="container position-relative py-5" data-aos="fade-up">
        <div class="row g-4 justify-content-center">
            @if(isset($content->meta['counters']) && is_array($content->meta['counters']))
                @foreach($content->meta['counters'] as $counter)
                <div class="col-6 col-md-3">
                    <div class="text-center p-4 rounded-4" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px); transition: transform 0.3s ease;">
                        <i class="{{ $counter['icon'] ?? 'fa-light fa-circle' }} fa-3x mb-3" style="color: #A45517;"></i>
                        <h2 class="fw-bold mb-1 text-white counter-value" data-target="{{ $counter['count'] ?? 0 }}" style="font-family: 'Oswald', sans-serif;">0</h2>
                        <p class="text-white-50 mb-0 text-uppercase small letter-spacing-1">{{ $counter['label'] ?? '' }}</p>
                    </div>
                </div>
                @endforeach
            @else
                <div class="col-6 col-md-3">
                    <div class="text-center p-4 rounded-4" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                        <i class="fa-light fa-face-smile fa-3x mb-3" style="color: #A45517;"></i>
                        <h2 class="fw-bold mb-1 text-white counter-value" data-target="5670" style="font-family: 'Oswald', sans-serif;">0</h2>
                        <p class="text-white-50 mb-0 text-uppercase small">Happy Customers</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="text-center p-4 rounded-4" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                        <i class="fa-light fa-hat-chef fa-3x mb-3" style="color: #A45517;"></i>
                        <h2 class="fw-bold mb-1 text-white counter-value" data-target="29" style="font-family: 'Oswald', sans-serif;">0</h2>
                        <p class="text-white-50 mb-0 text-uppercase small">Passionate Chefs</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="text-center p-4 rounded-4" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                        <i class="fa-light fa-mug-hot fa-3x mb-3" style="color: #A45517;"></i>
                        <h2 class="fw-bold mb-1 text-white counter-value" data-target="260" style="font-family: 'Oswald', sans-serif;">0</h2>
                        <p class="text-white-50 mb-0 text-uppercase small">Favorite Dishes</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="text-center p-4 rounded-4" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                        <i class="fa-light fa-star fa-3x mb-3" style="color: #A45517;"></i>
                        <h2 class="fw-bold mb-1 text-white counter-value" data-target="778" style="font-family: 'Oswald', sans-serif;">0</h2>
                        <p class="text-white-50 mb-0 text-uppercase small">Customer Rating</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

<!-----------------------
    Customer Review
---------------------->
<section data-aos="fade-up">
    <div class="ad-customer-review">
        <div class="ad-review-title-container">
            <img src="{{ asset('mncofee/assets/img/aida-images/service-icon.png') }}" alt="">
            <h4>{{ $content->meta['testimonial_title'] ?? 'What Our Customer Says' }}</h4>
            <p>
                {{ $content->meta['testimonial_subtitle'] ?? 'Hear from our satisfied customers about their experience with us.' }}
            </p>
        </div>
        <div class="container position-relative">
            <div class="ad-review-bg-container">
                <div class="overflow-hidden">
                    <img src="{{ asset('mncofee/assets/img/aida-images/review-bg-person.png') }}" alt="">
                </div>
                <div class="d-flex gap-3">
                    <i class="fa-solid fa-chevron-left" data-bs-target="#carouselExampleControls" data-bs-slide="prev"></i>
                    <i class="fa-solid fa-chevron-right" data-bs-target="#carouselExampleControls" data-bs-slide="next"></i>
                </div>
            </div>
            <div>
                <div id="carouselExampleControls" class="carousel slide ad-review-carousel" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($testimonials as $key => $testimonial)
                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }} ad-single-review">
                            <div class="d-flex gap-2">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <p>
                                {!! $testimonial->text_en !!}
                            </p>
                            <div class="ad-review-person-container">
                                <img src="{{ asset('storage/' . ($testimonial->image ?? 'default.png')) }}" alt="{{ $testimonial->name }}" style="width: 60px; height: 60px; border-radius: 50%;">
                                <div>
                                    <h4>{{ $testimonial->name }}</h4>
                                    <span>{{ $testimonial->designation }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-----------------------
    Blog & Article 
---------------------->
<section data-aos="fade-up">
    <div class="ad-article">
        <div class="ad-article-title-container">
            <img src="{{ asset('mncofee/assets/img/aida-images/service-icon.png') }}" alt="">
            <h4>{{ $content->meta['blog_title'] ?? 'Blog & Articles' }}</h4>
            <p>
                {{ $content->meta['blog_subtitle'] ?? 'Stay updated with our latest news and recipes.' }}
            </p>
        </div>
        <div class="container ad-article-container">
            @foreach($newses as $news)
            <div class="ad-single-card">
                <a href="{{ route('singleNews', $news->id) }}">
                    <i class="fa-solid fa-arrow-right-long"></i>
                </a>
                <div class="overflow-hidden">
                    <a href="{{ route('singleNews', $news->id) }}">
                        <img src="{{ route('imagecache', ['template'=>'original','filename' => $news->fi() ?? 'default.png']) }}" class="ad-blog-image" alt="{{ $news->title }}">
                    </a>
                </div>
                <p>NEWS . {{ $news->created_at->format('M d, Y') }}</p>
                <a href="{{ route('singleNews', $news->id) }}">
                    <h4>{{ $news->title }}</h4>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Initialize Hero Slider with enhanced options
    var heroCarousel = document.querySelector('#heroCarousel');
    if (heroCarousel) {
        var carousel = new bootstrap.Carousel(heroCarousel, {
            interval: 5000,
            ride: 'carousel',
            pause: 'hover',
            wrap: true,
            keyboard: true,
            touch: true
        });

        // GSAP Animations for Hero Slider
        function animateHeroSlide(item) {
            const title = item.querySelector('h1');
            const subtitle = item.querySelector('p');
            const button = item.querySelector('.btn-hero');
            const content = item.querySelector('.caption-content');

            if (content) {
                gsap.fromTo(content, 
                    { opacity: 0, y: 50 },
                    { opacity: 1, y: 0, duration: 1, ease: "power3.out" }
                );
            }

            if (title) {
                gsap.fromTo(title, 
                    { opacity: 0, x: -50 },
                    { opacity: 1, x: 0, duration: 1, delay: 0.3, ease: "power3.out" }
                );
            }

            if (subtitle) {
                gsap.fromTo(subtitle, 
                    { opacity: 0, x: 50 },
                    { opacity: 1, x: 0, duration: 1, delay: 0.5, ease: "power3.out" }
                );
            }

            if (button) {
                gsap.fromTo(button, 
                    { opacity: 0, scale: 0.8 },
                    { opacity: 1, scale: 1, duration: 0.8, delay: 0.8, ease: "back.out(1.7)" }
                );
            }
        }

        // Animate first slide on load
        const firstSlide = heroCarousel.querySelector('.carousel-item.active');
        if (firstSlide) animateHeroSlide(firstSlide);

        // Animate on slide change
        heroCarousel.addEventListener('slid.bs.carousel', function (e) {
            animateHeroSlide(e.relatedTarget);
        });

        // Keyboard Navigation (Arrow Keys)
        document.addEventListener('keydown', function(e) {
            // Only trigger if carousel is in viewport
            const rect = heroCarousel.getBoundingClientRect();
            const isInViewport = rect.top >= -rect.height && rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) + rect.height;
            
            if (isInViewport) {
                if (e.key === 'ArrowLeft') {
                    carousel.prev();
                } else if (e.key === 'ArrowRight') {
                    carousel.next();
                }
            }
        });

        // Mouse Wheel / Scroll Navigation
        let isThrottled = false;
        heroCarousel.addEventListener('wheel', function(e) {
            const rect = heroCarousel.getBoundingClientRect();
            // Only capture scroll if it's mostly in view
            if (rect.top >= -100 && rect.bottom <= window.innerHeight + 100) {
                if (isThrottled) return;
                
                if (e.deltaY > 0) {
                    carousel.next();
                    e.preventDefault();
                } else if (e.deltaY < 0) {
                    carousel.prev();
                    e.preventDefault();
                }
                
                isThrottled = true;
                setTimeout(() => { isThrottled = false; }, 1000); // Throttling for 1 second
            }
        }, { passive: false });
    }

    // Counter Animation
    const counters = document.querySelectorAll('.counter-value');
    const speed = 200;

    const animateCounters = () => {
        counters.forEach(counter => {
            const updateCount = () => {
                const target = +counter.getAttribute('data-target');
                const count = +counter.innerText;
                const inc = target / speed;

                if (count < target) {
                    counter.innerText = Math.ceil(count + inc);
                    setTimeout(updateCount, 1);
                } else {
                    counter.innerText = target;
                }
            };
            updateCount();
        });
    };

    // Trigger animation when section is in view
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounters();
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    const counterSection = document.querySelector('.counter-value')?.closest('section');
    if (counterSection) observer.observe(counterSection);

    // Explicitly initialize Bootstrap Carousels for other sections
    var myCarousel = document.querySelector('#carouselExample');
    if (myCarousel) {
        var carousel = new bootstrap.Carousel(myCarousel, {
            interval: 5000,
            ride: 'carousel'
        });
    }

    var reviewCarousel = document.querySelector('#carouselExampleControls');
    if (reviewCarousel) {
        var rCarousel = new bootstrap.Carousel(reviewCarousel, {
            interval: 5000,
            ride: 'carousel'
        });
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

// Add to Cart
$(document).on("click", ".addToCart", function () {
    let btn = $(this);
    let url = btn.data("url");
    let product_id = btn.data("product");
    let qty = parseInt(btn.closest(".cart-action-wrapper").find(".product_qty").val()) || 1;

    $.post(url, { product: product_id, qty: qty }, function (res) {
        if (res.status) {
            // Find the specific container for this product to update its HTML
            $(`.productCartItem[data-product="${product_id}"]`).html(res.productCartItem);
            
            $(".cartCount").text(res.cartCount);
            $(".cartItemsCount").text(res.cartItemsCount);
            if(res.cartTotal) {
                $(".cartTotalPrice").text(parseFloat(res.cartTotal).toFixed(2) + " tk");
            }

            Swal.fire({
                toast: true, 
                icon: "success", 
                title: res.message,
                position: "top-end", 
                timer: 2000, 
                showConfirmButton: false
            });
        }
    }).fail(() => {
        Swal.fire("Error", "Could not add to cart.", "error");
    });
});

// Update Cart Item
$(document).on('click', '.updateCartItem', function (e) {
    e.preventDefault();

    let $btn = $(this);
    let cartId = $btn.data('cart');
    let url = $btn.data('url');
    let $wrapper = $btn.closest('.cart-action-wrapper');
    let product_id = $wrapper.data('product');
    let qty = parseInt($wrapper.find('.cartQtyDisplay').text()) || 0;

    if ($btn.hasClass('plus')) {
        qty++;
    } else if ($btn.hasClass('minus')) {
        qty--;
        if (qty < 0) qty = 0;
    }

    $btn.prop('disabled', true);

    $.ajax({
        url: url,
        method: 'POST',
        data: {
            cart: cartId,
            new_qty: qty
        },
        success: function (res) {
            if (res.status) {
                if (qty === 0) {
                    $wrapper.closest(".productCartItem").html(`
                        <div class="cart-action-wrapper" data-product="${product_id}">
                            <div class="add-to-cart-initial-btn">
                                <button class="btn btn-primary btn-sm rounded-pill w-100 addToCart" 
                                        data-url="${res.add_to_cart_url}"
                                        data-product="${product_id}"
                                        style="height: 38px; background-color: #A45517; border-color: #A45517;">
                                    Add to Cart
                                </button>
                                <input type="hidden" name="product_qty" value="1" class="product_qty">
                            </div>
                        </div>
                    `);
                } else {
                    $wrapper.find('.cartQtyDisplay').text(qty);
                }

                $('.cartCount').text(res.cartCount);
                $('.cartItemsCount').text(res.cartItemsCount);
                if(res.cartTotal) {
                    $(".cartTotalPrice").text(parseFloat(res.cartTotal).toFixed(2) + " tk");
                }
            }
        },
        error: function () {
            alert('Something went wrong! Please try again.');
        },
        complete: function () {
            $btn.prop('disabled', false);
        }
    });
});
</script>
@endpush
