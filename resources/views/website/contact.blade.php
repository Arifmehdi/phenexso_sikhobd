@extends('website.layouts.mncofee')

@section('title', 'Contact Us - '. ($ws->name ?? env('APP_NAME')))

@section('meta')
<meta name="description" content="Get in touch with {{ $ws->name ?? env('APP_NAME') }}. We are here to help you with your inquiries.">
<meta name="keywords" content="Contact, Coffee, Help, Inquiries, MNCOfee">
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
                <a class="selected-page" href="{{ route('contact') }}"> Contact</a>
            </div>
        </div>
    </div>
</section>

<!-- Our Office -->
{{--<section data-aos="fade-up">
    <div class=" contact-page-office-container">
        <div class="contact-page-single-office">
            <div class="overflow-hidden">
                <a href="#">
                    <img src="{{ asset('mncofee/assets/img/aida-images/contact-page-outlet-image1.png') }}" class="contact-page-outlet" alt="">
                </a>
            </div>
            <div class="d-flex gap-2 align-items-center mt-3">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    style="width: 24px; height: 24px;"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                </svg>
                <div>
                    <h5>Main Office</h5>
                </div>
            </div>
            <div>
                <p>Location</p>
                <span>{{ $ws->address ?? '27, Division Street, New York' }}</span>
            </div>
            <div>
                <p>Phone</p>
                <a href="tel:{{ $ws->phone ?? '+1 800 123 456 789' }}" class="ms-3">{{ $ws->phone ?? '+1 800 123 456 789' }}</a>
            </div>
            <div>
                <p>Email</p>
                <span>{{ $ws->email ?? 'info@example.com' }}</span>
            </div>
        </div>
        <div class="contact-page-single-office">
            <div class="overflow-hidden">
                <a href="#">
                    <img src="{{ asset('mncofee/assets/img/aida-images/contact-page-outlet-image2.png') }}" class="contact-page-outlet" alt="">
                </a>
            </div>
            <div class="d-flex gap-2 align-items-center mt-3">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    style="width: 24px; height: 24px;"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                </svg>
                <div>
                    <h5>Secondary Outlet</h5>
                </div>
            </div>
            <div>
                <p>Location</p>
                <span>{{ $ws->contact_address ?? 'Available upon request' }}</span>
            </div>
            <div>
                <p>Phone</p>
                <a href="tel:{{ $ws->contact_mobile ?? '+1 800 123 456 789' }}" class="ms-3">{{ $ws->contact_mobile ?? '+1 800 123 456 789' }}</a>
            </div>
            <div>
                <p>Email</p>
                <span>{{ $ws->contact_email ?? 'support@example.com' }}</span>
            </div>
        </div>
        <div class="contact-page-single-office">
            <div class="overflow-hidden">
                <a href="#">
                    <img src="{{ asset('mncofee/assets/img/aida-images/contact-page-outlet-image3.png') }}" class="contact-page-outlet" alt="">
                </a>
            </div>
            <div class="d-flex gap-2 align-items-center mt-3">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    style="width: 24px; height: 24px;"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                </svg>
                <div>
                    <h5>Customer Support</h5>
                </div>
            </div>
            <div>
                <p>Availability</p>
                <span>24/7 Online Support</span>
            </div>
            <div>
                <p>Phone</p>
                <a href="tel:{{ $ws->phone ?? '+1 800 123 456 789' }}" class="ms-3">{{ $ws->phone ?? '+1 800 123 456 789' }}</a>
            </div>
            <div>
                <p>Email</p>
                <span>{{ $ws->email ?? 'info@example.com' }}</span>
            </div>
        </div>
    </div>
</section>--}}

<!-- Contact Form -->
<section data-aos="fade-up">
    <div class="contact-page-form-container ">
        <div class="contact-page-form">
            <h4>Get In Touch</h4>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <p>
                Feel free to contact us for any inquiries or support.
            </p>
            <form action="{{ route('contact.store') }}" method="POST">
                @csrf
                <div class="row ad-reservation-form contact-page-single-form">
                    <div class="col-12 col-sm-6 position-relative ps-3">
                        <i class="fa-regular fa-user"></i>
                        <input
                            type="text"
                            name="name"
                            placeholder="Name"
                            required
                        >
                    </div>
                    <div class="col-12 col-sm-6 position-relative ps-3 ps-sm-0 pe-sm-3">
                        <i class="fa-regular fa-envelope"></i>
                        <input
                            type="email"
                            name="email"
                            placeholder="Email Address"
                            required
                        >
                    </div>
                </div>
                <div class="row ad-reservation-form contact-page-single-form contact-page-phone-container">
                    <div class="col-12 col-sm-6 position-relative ps-3">
                        <i class="fa-solid fa-phone"></i>
                        <input
                            type="text"
                            name="phone"
                            placeholder="Phone"
                            required
                        >
                    </div>
                    <div class="col-12 col-sm-6 position-relative ps-3 ps-sm-0 pe-sm-3">
                        <i class="fa-solid fa-user-large"></i>
                        <input
                            type="text"
                            name="subject"
                            placeholder="Subject"
                            required
                        >
                    </div>
                </div>
                <div class="ad-reservation-form contact-page-single-form">
                    <div class="col-12 position-relative ps-2 contact-page-form-edit">
                        <div>
                            <i class="fa-solid fa-pen"></i>
                            <span class="ps-3">How can we help you</span>
                        </div>
                        <textarea
                            name="message"
                            rows="4"
                            style="width: 100%; border: 1px solid #ccc; padding: 10px; margin-top: 10px;"
                            required
                        ></textarea>
                    </div>
                </div>
                <button type="submit">Send Message</button>
            </form>
        </div>
        <div class="contact-page-form-right">
            <div class="contact-page-right-single-container">
                <i class="fa-solid fa-phone-volume"></i>
                <div>
                    <h5>Call Now</h5>
                    <a href="tel:{{ $ws->contact_mobile ?? '+554551556695' }}">
                        <span>{{ $ws->contact_mobile ?? '+554551556695' }}</span>
                    </a>
                </div>
            </div>
            <div class="contact-page-right-single-container">
                <i class="fa-solid fa-envelope-open-text"></i>
                <div>
                    <h5>Message Now</h5>
                    <span>{{ $ws->contact_email ?? 'info@example.com' }}</span>
                </div>
            </div>
            <div class="contact-page-right-single-container">
                <i class="fa-solid fa-location-dot"></i>
                <div>
                    <h5>Address Now</h5>
                    <span>{{ $ws->contact_address ?? 'Uttara, Dhaka' }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="contact-page-map">
        <iframe
            src="{{ $ws->iframe_map ?? 'https://maps.google.com/maps?q=dhaka&t=&z=13&ie=UTF8&iwloc=&output=embed' }}"
            frameborder="0"
            scrolling="no"
            style="width: 100%; height: 450px;"
        ></iframe>
    </div>
</section>
@endsection