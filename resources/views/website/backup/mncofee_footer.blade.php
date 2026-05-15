<footer data-aos="fade-up">
    <div class="ad-footer position-relative">
        <div class="container">
            <div class="ad-footer-subscribe">
                <h4>Our Newsletter Now</h4>
                <div class="position-relative">
                    <input type="text" placeholder="Your Email Address">
                    <a href="#">
                        <button>Subscribe</button>
                    </a>
                </div>
            </div>
            <div class="ad-footer-border"></div>
            <div class="ad-footer-list-container row align-items-center">
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 ad-footer-list">
                    <a href="{{ route('home') }}">
                        <img src="{{ route('imagecache', ['template' => 'original', 'filename' => $ws->logo()]) }}" alt="{{ $ws->name }}" style="max-height: 50px;">
                    </a>
                    <p class="mt-2" style="color: #A45517; font-style: italic;">Local Beans, Global Taste.</p>
                    <div class="d-flex gap-3 align-items-center">
                        <i class="fa-solid fa-location-dot"></i>
                        <p>
                            {{ $ws->contact_address ?? '4920 Trails End Road Ft United States, FL 33311' }}
                        </p>
                    </div>
                    <div class="d-flex gap-3 align-items-center">
                        <i class="fa-solid fa-envelope-open-text"></i>
                        <p>
                            {{ $ws->contact_email ?? 'info@example.com' }}
                        </p>
                    </div>
                    <div class="d-flex gap-3 align-items-center">
                        <i class="fa-solid fa-phone-volume"></i>
                        <div>
                            <a href="tel:{{ $ws->contact_phone ?? '+123 456 679 123' }}">
                                {{ $ws->contact_mobile ?? '+123 456 679 123' }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 ad-footer-list">
                    <h5>Our Services</h5>
                    <ul>
                        <li>
                            <a href="{{ route('service') }}">B2B Coffee Supply</a>
                        </li>
                        <li>
                            <a href="{{ route('service') }}">Direct Sourcing</a>
                        </li>
                        <li>
                            <a href="{{ route('service') }}">Custom Roast Profiles</a>
                        </li>
                        <li>
                            <a href="{{ route('service') }}">Traceable Beans</a>
                        </li>
                        <li>
                            <a href="{{ route('service') }}">Specialty Arabica</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 ad-footer-list">
                    <h5>Quick Links</h5>
                    <ul>
                        <li>
                            <a href="{{ route('about-us') }}">About Us</a>
                        </li>
                        <li>
                            <a href="{{ route('testimonial') }}">Testimonials</a>
                        </li>
                        <li>
                            <a href="{{ route('shop') }}">Shop</a>
                        </li>
                        <li>
                            <a href="{{ route('news') }}">Blog</a>
                        </li>
                        <li>
                            <a href="{{ route('contact') }}">Contact Us</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 ad-footer-list">
                    <h5>Opening Hours</h5>
                    <ul>
                        <li>
                            Mon -
                            <span class="ad-footer-list-opening-timer">from 8am to 9pm</span>
                        </li>
                        <li>
                            Saturday -
                            <span class="ad-footer-list-opening-timer">from 9am to 4pm</span>
                        </li>
                        <li>
                            Sunday -
                            <span class="ad-footer-list-opening-timer">from 8am to 9pm</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="ad-footer-bottom">
        <p>
            Copyright © {{ date('Y') }}
            <a href="https://phenexsoft.com/" target="_blank">Phenexsoft IT</a>.
            All Rights Reserved.
        </p>
            <img src="{{ asset('mncofee/assets/img/aida-images/payment.png') }}" alt="payment">
        </div>
    </div>
</footer>
