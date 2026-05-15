<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', $ws->name ?? 'SikhoBD')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta')
    
    <link rel="shortcut icon" type="image/png" href="{{ route('imagecache', ['template' => 'original', 'filename' => $ws->favicon()]) }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <link rel="stylesheet" href="{{ asset('sikhobd/css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    
    <style>
        .floating-cart {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 64px;
            height: 64px;
            background: var(--primary);
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            z-index: 999;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .floating-cart:hover {
            transform: scale(1.1) translateY(-5px);
            background: var(--text-main);
            color: #fff;
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
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .floating-cart i { font-size: 24px; }

        @media (max-width: 768px) {
            .floating-cart {
                bottom: 20px;
                right: 20px;
                width: 56px;
                height: 56px;
            }
        }
    </style>

    @stack('css')
</head>
<body>

    @include('website.layouts.sikhobd_header')

    <main>
        @yield('content')
    </main>

    <a href="{{ route('cart') }}" class="floating-cart">
        <i class="fa-solid fa-cart-shopping"></i>
        <span class="cart-count-badge cartCount">{{ $cartCount ?? 0 }}</span>
    </a>

    @include('website.layouts.sikhobd_footer')

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
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
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    @stack('js')
</body>
</html>
