<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', $ws->website_title ?? 'Qalam HR')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', $ws->meta_description ?? 'QalamHR is one of the premier training institutes in Bangladesh. We create professionals.')">
    @yield('meta')
    
    <link rel="shortcut icon" type="image/png" href="{{ route('imagecache', ['template' => 'original', 'filename' => $ws->favicon()]) }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('sikhobd/css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    
    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            background: var(--bg, #ffffff);
            color: var(--text-main, inherit);
            line-height: 1.6;
        }

        main {
            padding: 30px 0 60px;
        }

        .site-header {
            position: sticky;
            top: 0;
            z-index: 1100;
            background: #ffffff;
            border-bottom: 1px solid rgba(148, 163, 184, 0.16);
            box-shadow: 0 18px 50px rgba(15, 23, 42, 0.06);
        }

        .header-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 18px 0;
        }

        .logo img {
            max-height: 60px;
            transition: transform 0.3s ease;
        }

        .logo img:hover {
            transform: translateY(-2px);
        }

        .nav-desktop {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .nav-item {
            position: relative;
        }

        .nav-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--text-main, inherit);
            font-weight: 600;
            padding: 10px 14px;
            border-radius: 999px;
            transition: background 0.2s ease, color 0.2s ease, transform 0.2s ease;
            text-decoration: none;
        }

        .nav-link:hover,
        .nav-link:focus {
            background: rgba(41, 82, 255, 0.1);
            color: var(--primary, #2b2553);
            transform: translateY(-1px);
        }

        .caret,
        .arrow {
            width: 10px;
            height: 10px;
            display: inline-block;

        }

        .dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            min-width: 240px;
            background: #ffffff;
            border: 1px solid rgba(148, 163, 184, 0.18);
            border-radius: 20px;
            padding: 12px 0;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.12);
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: opacity 0.3s ease, transform 0.3s cubic-bezier(0.23, 1, 0.32, 1), visibility 0.3s;
            z-index: 1000;
            pointer-events: none;
        }

        /* Bridge the gap between nav-item and dropdown to maintain hover */
        .dropdown::before {
            content: '';
            position: absolute;
            top: -15px;
            left: 0;
            right: 0;
            height: 15px;
            background: transparent;
        }

        .nav-item:hover > .dropdown,
        .nav-item:focus-within > .dropdown,
        .dropdown-item:hover > .dropdown,
        .user-dropdown:hover > .dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
            pointer-events: auto;
        }

        .dropdown-item {
            position: relative;
            list-style: none;
            padding: 2px 8px;
        }

        .dropdown-item > .dropdown {
            top: 0;
            left: 100%;
            margin-top: -12px;
            margin-left: -4px;
            transform: translateX(10px);
        }

        .dropdown-item:hover > .dropdown {
            transform: translateX(0);
        }

        .dropdown-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 16px;
            color: #334155;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
            border-radius: 12px;
        }

        .dropdown-link:hover,
        .dropdown-link:focus {
            background: #f8fafc;
            color: var(--primary, #2952ff);
            transform: translateX(4px);
        }

        .dropdown-link span {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .dropdown-link .arrow {
            width: 8px;
            height: 8px;
            opacity: 0.6;
            transition: transform 0.2s ease;
        }

        .dropdown-item:hover > .dropdown-link .arrow {
            transform: translateX(2px);
            opacity: 1;
        }

        .drawer-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.35);
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.2s ease;
            z-index: 1290;
        }

        .drawer-overlay.open {
            opacity: 1;
            visibility: visible;
        }

        .drawer {
            position: fixed;
            top: 0;
            right: -100%;
            width: min(320px, 100%);
            height: 100vh;
            background: #ffffff;
            box-shadow: -20px 0 80px rgba(15, 23, 42, 0.12);
            transition: right 0.25s ease;
            z-index: 1300;
            display: flex; flex-direction: column;
        }

        .drawer.open {
            right: 0;
        }

        .drawer-head {
            padding: 20px 18px;
            border-bottom: 1px solid rgba(148, 163, 184, 0.18);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .drawer-body {
            padding: 18px;
            overflow-y: auto;
            gap: 14px;
            display: flex;
            flex-direction: column;
        }

        .drawer-search input {
            width: 100%;
            padding: 14px 16px;
            border-radius: 16px;
            border: 1px solid rgba(148, 163, 184, 0.18);
            outline: none;
            font-size: 1rem;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .drawer-search input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(41, 82, 255, 0.08);
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .icon-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 46px;
            height: 46px;
            border-radius: 16px;
            border: 1px solid rgba(148, 163, 184, 0.18);
            background: var(--surface);
            color: var(--text-main);
            cursor: pointer;
            transition: transform 0.2s ease, background 0.2s ease, border-color 0.2s ease;
        }

        .menu-toggle {
            display: none;
            align-items: center;
            justify-content: center;
            width: 46px;
            height: 46px;
            border-radius: 16px;
            border: 1px solid rgba(148, 163, 184, 0.18);
            background: var(--surface);
            color: var(--text-main);
            cursor: pointer;
            transition: transform 0.2s ease, background 0.2s ease, border-color 0.2s ease;
        }

        .icon-btn:hover,
        .menu-toggle:hover {
            transform: translateY(-1px);
            border-color: rgba(41, 82, 255, 0.24);
            background: var(--surface-soft);
        }

        .lang-switch {
            display: inline-flex;
            gap: 6px;
            border: 1px solid rgba(148, 163, 184, 0.18);
            background: var(--surface);
            border-radius: 999px;
            padding: 4px;
        }

        .lang-switch button {
            min-width: 42px;
            border: none;
            background: transparent;
            color: var(--text-muted);
            font-weight: 700;
            padding: 10px 12px;
            border-radius: 999px;
            cursor: pointer;
            transition: background 0.2s ease, color 0.2s ease;
        }

        .lang-switch button:hover,
        .lang-switch button:focus {
            background: var(--surface-soft);
            color: var(--text-main);
        }

        .btn-primary,
        .btn-primary:focus,
        .btn-primary:hover {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
            box-shadow: 0 20px 40px rgba(41, 82, 255, 0.16);
        }

        .btn-outline-primary {
            color: var(--primary);
            border-color: var(--primary);
        }

        .btn-outline-primary:hover {
            background: rgba(41, 82, 255, 0.08);
            color: var(--primary);
        }

        .form-control {
            border-radius: 16px;
            border: 1px solid rgba(148, 163, 184, 0.22);
            box-shadow: none;
            min-height: 50px;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(41, 82, 255, 0.08);
        }

        .card {
            border: 1px solid rgba(148, 163, 184, 0.14);
            border-radius: 24px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.08);
        }

        .card-body {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .search-results-page {
            min-height: calc(100vh - 160px);
        }

        .search-results-page h1,
        .search-results-page h3 {
            font-weight: 700;
        }

        .btn-group .btn {
            border-radius: 999px;
        }

        .btn-group .btn.active,
        .btn-group .btn:hover {
            background: var(--primary-soft);
            border-color: var(--primary);
            color: var(--primary);
        }

        .floating-whatsapp {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background: #25D366;
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 16px 40px rgba(37, 211, 102, 0.3);
            z-index: 999;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 32px;
        }

        .floating-whatsapp:hover {
            transform: translateY(-5px) scale(1.1);
            color: #fff;
            box-shadow: 0 24px 60px rgba(37, 211, 102, 0.4);
        }

        .floating-whatsapp::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: inherit;
            border-radius: 50%;
            z-index: -1;
            animation: pulse-whatsapp 2s infinite;
        }

        @keyframes pulse-whatsapp {
            0% { transform: scale(1); opacity: 0.6; }
            100% { transform: scale(1.6); opacity: 0; }
        }

        .floating-cart {
            position: fixed;
            bottom: 105px;
            right: 30px;
            width: 60px;
            height: 60px;
            background: var(--primary);
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 16px 40px rgba(41, 82, 255, 0.24);
            z-index: 999;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 24px;
        }

        .floating-cart:hover {
            transform: translateY(-5px) scale(1.1);
            color: #fff;
            box-shadow: 0 24px 60px rgba(41, 82, 255, 0.28);
        }

        .floating-cart .cart-count-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--accent);
            color: #fff;
            font-size: 12px;
            font-weight: 800;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #fff;
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.14);
        }

        @media (max-width: 768px) {
            .floating-whatsapp {
                bottom: 20px;
                right: 20px;
                width: 54px;
                height: 54px;
                font-size: 28px;
            }

            .floating-cart {
                bottom: 85px;
                right: 20px;
                width: 54px;
                height: 54px;
                font-size: 20px;
            }

            .header-inner {
                flex-wrap: wrap;
                padding: 14px 0;
            }

            .nav-desktop {
                display: none;
            }

            .menu-toggle {
                display: inline-flex;
            }

            .header-right {
                gap: 8px;
            }
        }

        .user-dropdown {
            position: relative;
            display: inline-flex;
            align-items: center;
            height: 100%;
        }

        .user-dropdown .dropdown {
            left: auto;
            right: 0;
            min-width: 200px;
            margin-top: 8px;
        }

        .user-dropdown .dropdown-link {
            display: flex;
            align-items: center;
            padding: 10px 18px;
            color: var(--text-main);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .user-dropdown .dropdown-link:hover {
            background: var(--surface-soft);
            color: var(--primary);
        }

        .user-dropdown .dropdown-link.text-danger:hover {
            background: #fff5f5;
        }

        .search-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.72);
            z-index: 1200;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            backdrop-filter: blur(12px);
        }

        .search-overlay.open {
            display: flex;
        }

        .search-panel {
            width: min(100%, 780px);
            background: #ffffff;
            border-radius: 30px;
            box-shadow: 0 36px 120px rgba(15, 23, 42, 0.18);
            overflow: hidden;
            padding: 36px;
            position: relative;
        }

        .search-panel h2 {
            margin: 0;
            font-size: 2rem;
            color: var(--text-main);
        }

        .search-panel .search-form {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 12px;
            margin-top: 16px;
        }

        .search-panel .search-form input {
            width: 100%;
            min-height: 64px;
            padding: 0 20px;
            border: 1px solid rgba(148, 163, 184, 0.18);
            border-radius: 18px;
            font-size: 1rem;
            color: var(--text-main);
        }

        .search-panel .search-form input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 6px rgba(41, 82, 255, 0.08);
        }

        .search-panel .search-form button {
            min-width: 80px;
            border: none;
            border-radius: 18px;
            background: var(--primary);
            color: #fff;
            font-size: 1.05rem;
            cursor: pointer;
            padding: 0 20px;
        }

        .search-panel .search-subtitle {
            margin: 0;
            color: var(--text-muted);
            font-size: 0.96rem;
            line-height: 1.75;
        }

        .search-close {
            position: absolute;
            top: 18px;
            right: 18px;
            width: 44px;
            height: 44px;
            border: none;
            background: var(--surface-soft);
            border-radius: 50%;
            display: grid;
            place-items: center;
            cursor: pointer;
            color: var(--text-main);
        }

        .search-close:hover {
            background: rgba(226, 232, 240, 1);
        }

        body.no-scroll {
            overflow: hidden;
        }

        .scroll-top {
            position: fixed;
            bottom: 30px;
            left: 30px;
            width: 50px;
            height: 50px;
            background: #fff;
            color: var(--primary, #2b2553);
            border: 2px solid var(--primary, #2b2553);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            cursor: pointer;
            z-index: 998;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            transform: translateY(20px);
        }

        .scroll-top.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .scroll-top:hover {
            background: var(--primary, #2b2553);
            color: #fff;
            transform: translateY(-5px);
        }

        @media (max-width: 768px) {
            .scroll-top {
                bottom: 20px;
                left: 20px;
                width: 44px;
                height: 44px;
                font-size: 18px;
            }
        }

        .swal2-container {
            z-index: 9999 !important;
        }
    </style>

    @stack('css')
</head>
<body>

    @include('website.layouts.sikhobd_header')

    <main>
        @yield('content')
    </main>

    @if($ws->whatsapp)
    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $ws->whatsapp) }}" class="floating-whatsapp" target="_blank" title="Chat with us on WhatsApp">
        <i class="fa-brands fa-whatsapp"></i>
    </a>
    @endif

    <div class="scroll-top" id="scrollTop" title="Go to Top">
        <i class="fa-solid fa-arrow-up"></i>
    </div>

    <a href="{{ route('cart') }}" class="floating-cart">
        <i class="fa-solid fa-cart-shopping"></i>
        <span class="cart-count-badge cartCount">{{ $cartCount ?? 0 }}</span>
    </a>

    @include('website.layouts.sikhobd_footer')

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('sikhobd/js/main.js') }}"></script>
    
    <script>
        // Global AJAX Cart Notification Helper
        function showCartNotification(message, type = 'success') {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: type,
                title: message
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            const searchToggle = document.getElementById('searchToggle');
            const searchOverlay = document.getElementById('searchOverlay');
            const searchClose = document.getElementById('searchClose');

            function openSearch() {
                if (searchOverlay) {
                    searchOverlay.classList.add('open');
                    document.body.classList.add('no-scroll');
                }
            }

            function closeSearch() {
                if (searchOverlay) {
                    searchOverlay.classList.remove('open');
                    document.body.classList.remove('no-scroll');
                }
            }

            if (searchToggle) {
                searchToggle.addEventListener('click', function (event) {
                    event.preventDefault();
                    openSearch();
                });
            }

            if (searchClose) {
                searchClose.addEventListener('click', closeSearch);
            }

            if (searchOverlay) {
                searchOverlay.addEventListener('click', function (event) {
                    if (event.target === searchOverlay) {
                        closeSearch();
                    }
                });
            }

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && searchOverlay && searchOverlay.classList.contains('open')) {
                    closeSearch();
                }
            });

            // Scroll to Top Logic
            const scrollTopBtn = document.getElementById('scrollTop');
            window.onscroll = function() {
                if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
                    scrollTopBtn.classList.add('show');
                } else {
                    scrollTopBtn.classList.remove('show');
                }
            };

            scrollTopBtn.onclick = function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            };
        });
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    @stack('js')
</body>
</html>
