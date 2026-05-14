<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', $ws->name ?? 'Cafeu')</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @yield('meta')
        <link rel="shortcut icon" type="image/png" href="{{ route('imagecache', ['template' => 'original', 'filename' => $ws->favicon()]) }}">
        <link rel="stylesheet" href="{{ asset('mncofee/assets/css/bootstrap/bootstrap.min.css') }}">
        <link rel="preconnect" href="https://fonts.googleapis.com/">
        <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond&amp;family=Jost&amp;family=Nunito&amp;family=Oswald:wght@400;500;600;700&amp;family=Plus+Jakarta+Sans&amp;display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('mncofee/assets/font-awesome/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('mncofee/assets/css/animation/aos.css') }}">
        <link rel="stylesheet" href="{{ asset('mncofee/assets/css/aida-home-styles.css') }}">
        @stack('css')
    </head>
    <body>
        <div id="preloader">
            <div id="container" class="container-preloader">
                <div class="animation-preloader">
                    <div class="spinner"></div>
                </div>
                <div class="loader-section section-left"></div>
                <div class="loader-section section-right"></div>
            </div>
        </div>

        @include('website.layouts.mncofee_header')

        <main>
            @yield('content')
        </main>

        @include('website.layouts.mncofee_footer')

        <!-- Script -->
        <script src="{{ asset('mncofee/assets/js/fslightbox/fslightbox.js') }}"></script>
        <script src="{{ asset('mncofee/assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('mncofee/assets/js/jquery.nice-select.min.js') }}"></script>
        <!-- Aos Animation -->
        <script src="{{ asset('mncofee/assets/js/animation/aos.js') }}"></script>
        <script>
            AOS.init();
        </script>

        <!-- GSAP Effect-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

        <script>
            gsap.registerPlugin(ScrollTrigger);

        let bannerContainers = document.querySelectorAll(".ad-banner-person");
        let aboutContainers = document.querySelectorAll(".ad-about-image-container");

        bannerContainers.forEach((container) => {
          let image = container.querySelector("img");
          let tl = gsap.timeline({
            scrollTrigger: {
              trigger: container,
              toggleActions: "restart none none reset"
            }
          });

          tl.set(container, { autoAlpha: 1 });
          tl.from(container, 1.5, {
            xPercent: -100,
            ease: Power2.out
          });
          tl.from(image, 1.5, {
            xPercent: 100,
            scale: 1.3,
            delay: -1.5,
            ease: Power2.out
          });
        });
        aboutContainers.forEach((container) => {
          let image = container.querySelector("img");
          let tl = gsap.timeline({
            scrollTrigger: {
              trigger: container,
              toggleActions: "restart none none reset"
            }
          });

          tl.set(container, { autoAlpha: 1 });
          tl.from(container, 1.5, {
            xPercent: -100,
            ease: Power2.out
          });
          tl.from(image, 1.5, {
            xPercent: 100,
            scale: 1.3,
            delay: -1.5,
            ease: Power2.out
          });
        });
        </script>
        <!-- Preloader -->
        <script src="{{ asset('mncofee/assets/js/jquery/jquery.min.js') }}"></script>
        <script>
            $(document).ready(function() {
            setTimeout(function() {
            $('#container').addClass('loaded');
            if ($('#container').hasClass('loaded')) {

            $('#preloader').delay(2000).queue(function() {
             $(this).remove();
            });}
            }, 2000);});
        </script>
        @stack('js')
    </body>
</html>
