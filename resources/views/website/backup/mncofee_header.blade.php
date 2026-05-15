<header style="position: sticky; top: 0; z-index: 1050; background: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
    <!---------------
    Navbar 
-------------->
    <nav>
        <div class="ad-navbar-sm d-flex justify-content-between align-items-center d-lg-none">
            <div>
                <img src="{{ route('imagecache', ['template' => 'original', 'filename' => $ws->logo_alt()]) }}" alt="{{ $ws->name }}" style="max-height: 50px;">
            </div>
            <div
                class="ad-responsive-menubar"
                data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasTop"
                aria-controls="offcanvasTop"
            >
                <i class="fa-thin fa-bars-sort"></i>
            </div>
        </div>
        <div class=" d-none d-lg-block">
            <div class="ad-header-container">
                <div class="ad-header-menu-container">
                    <div class="d-flex gap-3">
                        <div
                            class="ad-search-icon"
                            type="button"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasTopSearch"
                            aria-controls="offcanvasTopSearch"
                        >
                            <i class="fa-light fa-magnifying-glass"></i>
                        </div>
                        <div
                            class="offcanvas offcanvas-top navbar-offcanvas-lg"
                            tabindex="-1"
                            id="offcanvasTopSearch"
                            aria-labelledby="offcanvasTopLabel"
                        >
                            <div class="offcanvas-header">
                                <h5 id="offcanvasTopLabel"></h5>
                                <div class="ad-responsive-close-btn">
                                    <button
                                        type="button"
                                        class="btn-close text-reset"
                                        data-bs-dismiss="offcanvas"
                                        aria-label="Close"
                                    ></button>
                                </div>
                            </div>
                            <div class="offcanvas-body navbar-offcanvas-search">
                                <form action="{{ route('search') }}" method="GET">
                                    <input
                                        type="text"
                                        name="parameter"
                                        placeholder="Search Your Food"
                                    >
                                    <br>
                                    <button type="submit">Search</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <nav class="ad-navlist">
                        <li >
                            <a href="{{ route('home') }}" class="ad-nav-anchor">Home</a>
                        </li>
                        <li >
                            <a href="{{ route('about') }}" class="ad-nav-anchor">About Us</a>
                        </li>
                        <li >
                            <a href="{{ route('shop') }}" class="ad-nav-anchor">Products</a>
                        </li>
                        <li>
                            <a href="{{ route('service') }}" class="ad-nav-anchor">Our Process</a>
                            <div class="grad-nav-border">
                                <div class="left-nav-border"></div>
                                <div class="right-nav-border"></div>
                            </div>
                        </li>
                    </nav>
                </div>
                <div class="ad-logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ route('imagecache', ['template' => 'original', 'filename' => $ws->logo_alt()]) }}" alt="{{ $ws->name }}" style="max-height: 80px;">
                    </a>
                </div>
                <div class="ad-header-pages-container">
                    <li class="dropdown">
                        <a href="{{ route('image.galleries') }}" class="ad-nav-anchor">Gallery</a>
                    </li>
                    <li class="dropdown">
                        <a href="{{ route('contact') }}" class="ad-nav-anchor">Contact</a>
                    </li>
                    <div class="d-flex gap-3 align-items-center">
                        <div class="ad-header-cart-container">
                            <a href="{{ route('new.checkout') }}" class="text-decoration-none">
                                <div class="ad-cart-img-container">
                                    <i class="fa-light fa-cart-shopping"></i>
                                    <span class="ad-cart-count">{{ App\Models\Cart::cartCount() }}</span>
                                </div>
                            </a>
                        </div>
                        <div class="ad-header-cart-container">
                            <a href="{{ route('login') }}" class="text-decoration-none">
                                <div class="ad-cart-img-container" style="width: 21px; height: 35px; border-radius: 50%; overflow: hidden;">
                                     <i class="fa-solid fa-user"></i>
                                    {{-- <img src="{{ route('imagecache', ['template' => 'original', 'filename' => auth()->user()->profile_image ?? 'default.png']) }}" alt="{{ auth()->user()->name ?? 'User' }}" style="width: 100%; height: 100%; object-fit: cover;"> --}}
                                    <i class="fa-light fa-cart-user"></i>
                                </div>
                            </a>
                        </div>
                        <div class="fs-5">
                            <a href="{{ route('service') }}">
                                <button>Our Process</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div
            class="offcanvas offcanvas-top h-100 ad-responsive-navbar"
            tabindex="-1"
            id="offcanvasTop"
            aria-labelledby="offcanvasTopLabel"
        >
            <div class="d-flex align-items-center justify-content-between mt-3 mx-3">
                <a href="{{ route('home') }}">
                    <img src="{{ route('imagecache', ['template' => 'original', 'filename' => $ws->logo_alt()]) }}" alt="{{ $ws->name }}" style="max-height: 50px;">
                </a>
                <div class="ad-responsive-close-btn">
                    <button
                        type="button"
                        class="btn-close text-reset"
                        data-bs-dismiss="offcanvas"
                        aria-label="Close"
                    ></button>
                </div>
            </div>
            <div class="offcanvas-body">
                <ul class="ad-responsive-navbar-list">
                    <li>
                        <a href="{{ route('home') }}">Home</a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}">About Us</a>
                    </li>
                    <li>
                        <a href="{{ route('shop') }}">Products</a>
                    </li>
                    <li>
                        <a href="{{ route('service') }}">
                            <p>Our Process</p>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('image.galleries') }}">Gallery</a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}">Contact</a>
                    </li>
                    <li>
                        <a href="{{ route('login') }}">Login</a>
                    </li>
                </ul>
                <div class="ad-responsive-search position-relative">
                    <form action="{{ route('search') }}" method="GET">
                        <input type="text" name="parameter" placeholder="Search Your Food">
                        <button type="submit" style="background: transparent; border: none; position: absolute; right: 10px; top: 10px;">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </form>
                </div>
                <div class="d-flex gap-4 mt-4 text-center ad-responsive-account">
                    <div>
                        <a href="{{ route('change.profile') }}" class="text-decoration-none" style="color: inherit;">
                            <i class="fa-solid fa-user"></i>
                            <p>Account</p>
                        </a>
                    </div>
                    <div class="position-relative">
                        <a href="{{ route('new.checkout') }}" class="text-decoration-none" style="color: inherit;">
                            <i class="fa-light fa-cart-shopping"></i>
                            <span>{{ App\Models\Cart::cartCount() }}</span>
                            <p>View Cart</p>
                        </a>
                    </div>
                    <div class="fs-5 ad-responsive-btn text-center">
                        <a href="{{ route('service') }}">
                            <button>Our Process</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
