@extends('website.layouts.mncofee')

@section('title', 'Home - MN Coffee')

@section('meta')
<meta name="description" content="MN Coffee - Local Beans, Global Taste. Sourcing specialty coffee directly from Bandarban hill farmers.">
<meta name="keywords" content="MN Coffee, Bangladesh coffee, Arabica, Robusta, Bandarban coffee, specialty coffee">
@endsection

@push('css')
<style>
    .ad-banner-content {
        background-image: url("{{ asset('mncofee/assets/img/aida-images/banner-shape.png') }}") !important;
    }
</style>
@endpush

@section('content')
<!---------------
    Banner 
-------------->
<section>
    <div>
        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach($sliders as $key => $slider)
                <div class="carousel-item {{ $key == 0 ? 'active' : '' }} position-relative">
                    <div class="text-end">
                        <img
                            class="ad-banner-img"
                            src="{{ route('imagecache', ['template'=>'original','filename' => $slider->fi() ?? 'default.png']) }}"
                            alt="{{ $slider->title }}"
                        >
                    </div>
                    <div class="ad-banner-content">
                        <div class="ad-banner-text-container">
                            <div class="ad-banner-text-effect">
                                <p>Local Beans, Global Taste</p>
                                <h1>{!! $slider->title !!}</h1>
                                @if($slider->link)
                                <a href="{{ $slider->link }}">
                                    <button>Explore More</button>
                                </a>
                                @endif
                            </div>
                        </div>
                        <div class="ad-banner-person-container">
                            <div class="ad-banner-person">
                                <img src="{{ asset('mncofee/assets/img/aida-images/banner-person1.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @if($sliders->isEmpty())
                <div class="carousel-item active position-relative">
                    <div class="text-end">
                        <img class="ad-banner-img" src="{{ asset('mncofee/assets/img/aida-images/banner.png') }}" alt="MN Coffee Banner">
                    </div>
                    <div class="ad-banner-content">
                        <div class="ad-banner-text-container">
                            <div class="ad-banner-text-effect">
                                <p>Local Beans, Global Taste</p>
                                <h1>Specialty Coffee <br> From Bandarban Hills</h1>
                                <a href="{{ route('shop') }}">
                                    <button>Order Now</button>
                                </a>
                            </div>
                        </div>
                        <div class="ad-banner-person-container">
                            <div class="ad-banner-person">
                                <img src="{{ asset('mncofee/assets/img/aida-images/banner-person1.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <div>
                <button class="carousel-control-prev ad-carousel-prev-btn" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                    <div class="ad-carousel-arrow">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </div>
                </button>
                <button class="carousel-control-next ad-carousel-next-btn" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                    <div class="ad-carousel-arrow">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </div>
                </button>
            </div>
        </div>
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
            <h5>about us</h5>
            <h4>Connecting Hill Farmers <br> With Urban Cafés</h4>
            <p>
                MN Coffee is a Bangladesh-based specialty coffee venture connecting hill farmers with urban cafés through a direct farm-to-market supply chain. We focus on improving quality, traceability, and farmer income by developing local Arabica production and better post-harvest practices.
            </p>
            <div class="ad-about-list-container">
                <div class="d-flex gap-3 align-items-center">
                    <i class="fa-regular fa-square-check"></i>
                    <p>Direct sourcing from Bandarban hill farmers</p>
                </div>
                <div class="d-flex gap-3 align-items-center mt-2">
                    <i class="fa-regular fa-square-check"></i>
                    <p>Improving local Arabica production</p>
                </div>
                <div class="d-flex gap-3 align-items-center mt-2">
                    <i class="fa-regular fa-square-check"></i>
                    <p>Better post-harvest practices for quality</p>
                </div>
            </div>
            <a href="{{ route('about-us') }}">Learn More</a>
        </div>
    </div>
</section>

<!-------------------
    Our Services
----------------->
<section data-aos="fade-up">
    <div class="ad-service">
        <div class="ad-service-title-container">
            <img src="{{ asset('mncofee/assets/img/aida-images/service-icon.png') }}" alt="">
            <h4>Specialty Coffee Services</h4>
            <p>We provide a complete farm-to-cup ecosystem</p>
        </div>
        <div class="container ad-service-container">
            <div class="ad-single-service position-relative">
                <i class="fa-light fa-seedling fa-3x mb-3" style="color: #A45517;"></i>
                <h5>Direct Sourcing</h5>
                <p>Sourcing high-quality beans directly from Bandarban hill farmers, ensuring traceability.</p>
                <div class="ad-single-service-overlay">
                    <div>
                        <i class="fa-light fa-seedling fa-2x mb-2"></i>
                        <h5>Direct Sourcing</h5>
                        <p>We empower farmers by cutting out middlemen and providing better income opportunities.</p>
                    </div>
                </div>
            </div>
            <div class="ad-single-service position-relative">
                <i class="fa-light fa-fire-smoke fa-3x mb-3" style="color: #A45517;"></i>
                <h5>B2B Supply</h5>
                <p>Supply of premium roasted Arabica & Robusta beans to cafés and businesses.</p>
                <div class="ad-single-service-overlay">
                    <div>
                        <i class="fa-light fa-fire-smoke fa-2x mb-2"></i>
                        <h5>B2B Supply</h5>
                        <p>Reliable and consistent supply of locally produced specialty coffee for your café.</p>
                    </div>
                </div>
            </div>
            <div class="ad-single-service position-relative">
                <i class="fa-light fa-flask-vial fa-3x mb-3" style="color: #A45517;"></i>
                <h5>Custom Roast</h5>
                <p>Developing custom roast profiles tailored to the specific needs of urban cafés.</p>
                <div class="ad-single-service-overlay">
                    <div>
                        <i class="fa-light fa-flask-vial fa-2x mb-2"></i>
                        <h5>Custom Roast</h5>
                        <p>We work with you to find the perfect roast profile that highlights the local flavor.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-------------------
    Special Offer (Products)
----------------->
<section data-aos="fade-up">
    <div class="ad-offer">
        <div class="ad-offer-title-container">
            <img src="{{ asset('mncofee/assets/img/aida-images/service-icon.png') }}" alt="">
            <h4>Our Specialty Collection</h4>
            <p>Traceable, quality-controlled coffee from the hills of Bangladesh.</p>
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
                >
                    {{ strtoupper($category->name_en) }}
                </button>
            </li>
            @endforeach
        </ul>
        <div class="tab-content" id="myTabContent">
            @foreach($categories->take(6) as $key => $category)
            <div class="tab-pane fade {{ $key == 0 ? 'show active' : '' }}" id="cat-{{ $category->id }}-tab-pane" role="tabpanel">
                <div class="container ad-offer-container">
                    @foreach($category->products->take(6) as $product)
                    <div class="ad-offer-single-card">
                        <div>
                            <a href="{{ route('productDetails', $product->slug) }}">
                                <img src="{{ route('imagecache', ['template'=>'original','filename' => $product->fi() ?? 'default.png']) }}" alt="{{ $product->name_en }}" style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;">
                            </a>
                        </div>
                        <div>
                            <a href="{{ route('productDetails', $product->slug) }}" class="ad-offer-card-text-container">
                                <h5>{{ strtoupper($product->name_en) }}</h5>
                                <div class="d-flex gap-2 align-items-center">
                                    <span class="ad-offer-dotted">------------------------------</span>
                                    <span class="ad-offer-price"> ৳{{ number_format($product->final_price, 2) }}</span>
                                </div>
                            </a>
                            <p>{{ Str::limit(strip_tags($product->description_en), 80) }}</p>
                            <a href="#" class="add-to-cart-btn" data-id="{{ $product->id }}">Add To Cart</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-----------------------
    Online Reservation
---------------------->
<section data-aos="fade-up">
    <div class="ad-reservation position-relative">
        <div class="d-flex justify-content-center">
            <div class="ad-reservation-form-container">
                <img src="{{ asset('mncofee/assets/img/aida-images/service-icon.png') }}" alt="">
                <h4>Consult with our Experts</h4>
                <p class="text-center mb-4 text-white">Book a session to discuss B2B supply or custom roasting</p>
                <div>
                    <form action="{{ route('contact.store') }}" method="POST">
                        @csrf
                        <div class="row ad-reservation-form">
                            <div class="col-12 col-sm-6 position-relative">
                                <input type="text" name="name" placeholder="Name" required>
                                <i class="fa-regular fa-user"></i>
                            </div>
                            <div class="col-12 col-sm-6 position-relative">
                                <input type="text" name="phone" placeholder="Phone" required>
                                <i class="fa-solid fa-phone"></i>
                            </div>
                        </div>
                        <div class="row ad-reservation-form">
                            <div class="col-12 position-relative">
                                <select name="subject" required>
                                    <option value="" selected disabled hidden>Inquiry Type</option>
                                    <option value="B2B Supply">B2B Supply</option>
                                    <option value="Custom Roasting">Custom Roasting Profile</option>
                                    <option value="Direct Sourcing">Direct Sourcing Details</option>
                                    <option value="Other">Other Inquiry</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit">Send Request</button>
                    </form>
                </div>
            </div>
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
            <h4>What Our Partners Say</h4>
            <p>Hear from the café owners and partners we work with.</p>
        </div>
        <div class="container position-relative">
            <div class="ad-review-bg-container">
                <div class="overflow-hidden">
                    <img src="{{ asset('mncofee/assets/img/aida-images/review-bg-person.png') }}" alt="">
                </div>
                <div class="d-flex gap-3">
                    <i class="fa-solid fa-chevron-left" data-bs-target="#reviewCarousel" data-bs-slide="prev"></i>
                    <i class="fa-solid fa-chevron-right" data-bs-target="#reviewCarousel" data-bs-slide="next"></i>
                </div>
            </div>
            <div>
                <div id="reviewCarousel" class="carousel slide ad-review-carousel" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($testimonials as $key => $testimonial)
                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }} ad-single-review">
                            <div class="d-flex gap-2">
                                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                            </div>
                            <p>{!! $testimonial->text_en !!}</p>
                            <div class="ad-review-person-container">
                                <img src="{{ asset('storage/testimonials/' . ($testimonial->image ?? 'default.png')) }}" alt="{{ $testimonial->name }}" style="width: 60px; height: 60px; border-radius: 50%;">
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
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    var myCarousel = document.querySelector('#carouselExample');
    if (myCarousel) new bootstrap.Carousel(myCarousel, { interval: 5000, ride: 'carousel' });

    var rCarousel = document.querySelector('#reviewCarousel');
    if (rCarousel) new bootstrap.Carousel(rCarousel, { interval: 5000, ride: 'carousel' });
});

$(document).on('click', '.add-to-cart-btn', function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    $.ajax({
        url: "{{ route('cart.quick.add') }}",
        type: "GET",
        data: { id: id },
        success: function(res) {
            if(res.success) {
                Swal.fire({ icon: 'success', title: 'Success', text: res.message, timer: 2000, showConfirmButton: false }).then(() => { location.reload(); });
            } else {
                Swal.fire({ icon: 'error', title: 'Oops...', text: res.message });
            }
        }
    });
});
</script>
@endpush
