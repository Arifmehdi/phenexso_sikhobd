@extends('website.layouts.mncofee')

@section('title', 'Our Process - '. env('APP_NAME'))

@section('meta')
<meta name="description" content="Discover MN Coffee's direct farm-to-market supply chain, connecting Bandarban hill farmers with urban cafés.">
<meta name="keywords" content="Post-harvest practices, Farm-to-market, Specialty coffee process, Bandarban coffee, MN Coffee">
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
                <a class="selected-page" href="{{ route('service') }}"> Our Process</a>
            </div>
        </div>
    </div>
</section>

<!-- Process Section -->
<section class="position-relative py-5" data-aos="fade-up">
    <div class="reservation-page">
        <div class="reservation-page-title-container">
            <img src="{{ asset('mncofee/assets/img/aida-images/service-icon.png') }}" alt="" />
            <h4>{{ $content->title ?? 'Our Direct Farm-to-Market Supply Chain' }}</h4>
            <p>
                {{ $content->description ?? 'We focus on improving quality, traceability, and farmer income through a meticulous post-harvest process.' }}
            </p>
        </div>

        <div class="reservation-page-direction-container">
            @if(isset($content->highlights) && is_array($content->highlights))
                @foreach($content->highlights as $index => $step)
                    <div class="reservation-page-single-direction {{ $index == 1 ? 'reservation-page-single-middle-direction' : '' }}">
                        <p>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</p>
                        <h6>{{ $step['title'] ?? '' }}</h6>
                    </div>
                    @if($index == 0)
                        <div class="reservation-page-direction">
                            <img src="{{ asset('mncofee/assets/img/aida-images/reservation-page-direction-image1.png') }}" alt="" />
                        </div>
                    @elseif($index == 1)
                        <div class="reservation-page-right-direction">
                            <img src="{{ asset('mncofee/assets/img/aida-images/reservation-page-direction-image2.png') }}" alt="" />
                        </div>
                    @endif
                @endforeach
            @else
                <div class="reservation-page-single-direction">
                    <p>01</p>
                    <h6>Direct Sourcing</h6>
                </div>
                <div class="reservation-page-direction">
                    <img src="{{ asset('mncofee/assets/img/aida-images/reservation-page-direction-image1.png') }}" alt="" />
                </div>
                <div class="reservation-page-single-direction reservation-page-single-middle-direction">
                    <p>02</p>
                    <h6>Post-Harvest</h6>
                </div>
                <div class="reservation-page-right-direction">
                    <img src="{{ asset('mncofee/assets/img/aida-images/reservation-page-direction-image2.png') }}" alt="" />
                </div>
                <div class="reservation-page-single-direction">
                    <p>03</p>
                    <h6>Urban Supply</h6>
                </div>
            @endif
        </div>
    </div>
</section>

<!-- Detailed Steps -->
<section class="py-5" style="background: #fdfaf7;">
    <div class="container">
        @if(isset($content->meta['steps']) && is_array($content->meta['steps']))
            @foreach($content->meta['steps'] as $index => $step)
                <div class="row align-items-center mb-5 {{ $index % 2 != 0 ? 'flex-md-row-reverse' : '' }}" data-aos="{{ $index % 2 != 0 ? 'fade-left' : 'fade-right' }}">
                    <div class="col-md-6">
                        <img src="{{ asset($step['image'] ?? 'mncofee/assets/img/aida-images/about-picture1.png') }}" alt="{{ $step['title'] ?? '' }}" class="img-fluid rounded shadow">
                    </div>
                    <div class="col-md-6 {{ $index % 2 == 0 ? 'ps-md-5' : 'pe-md-5' }}">
                        <h3 style="color: #A45517; font-family: 'Oswald', sans-serif;">Step {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}: {{ $step['title'] ?? '' }}</h3>
                        <p>{{ $step['text'] ?? '' }}</p>
                    </div>
                </div>
            @endforeach
        @else
            <div class="row align-items-center mb-5" data-aos="fade-right">
                <div class="col-md-6">
                    <img src="{{ asset('mncofee/assets/img/aida-images/about-picture1.png') }}" alt="Sourcing" class="img-fluid rounded shadow">
                </div>
                <div class="col-md-6 ps-md-5">
                    <h3 style="color: #A45517; font-family: 'Oswald', sans-serif;">Step 01: Direct Farm Sourcing</h3>
                    <p>We work directly with Bandarban hill farmers, cutting out middlemen to ensure higher income for the producers. This direct connection allows us to maintain full traceability of every bean.</p>
                </div>
            </div>

            <div class="row align-items-center mb-5 flex-md-row-reverse" data-aos="fade-left">
                <div class="col-md-6">
                    <img src="{{ asset('mncofee/assets/img/aida-images/service-image1.png') }}" alt="Processing" class="img-fluid rounded shadow">
                </div>
                <div class="col-md-6 pe-md-5">
                    <h3 style="color: #A45517; font-family: 'Oswald', sans-serif;">Step 02: Post-Harvest Excellence</h3>
                    <p>Our team implements better post-harvest practices on the ground. From precise fermentation to controlled drying, we ensure the local Arabica and Robusta beans reach their full specialty potential.</p>
                </div>
            </div>

            <div class="row align-items-center" data-aos="fade-right">
                <div class="col-md-6">
                    <img src="{{ asset('mncofee/assets/img/aida-images/about-picture3.png') }}" alt="Roasting" class="img-fluid rounded shadow">
                </div>
                <div class="col-md-6 ps-md-5">
                    <h3 style="color: #A45517; font-family: 'Oswald', sans-serif;">Step 03: Custom Roasting & Supply</h3>
                    <p>We develop custom roast profiles specifically for urban cafés. Our quality-controlled B2B supply chain delivers the global taste of local beans directly to your business.</p>
                </div>
            </div>
        @endif
    </div>
</section>
    </div>
</section>

<!-- Call to Action -->
<section class="py-5 text-center" data-aos="zoom-in">
    <div class="container">
        <h2 style="font-family: 'Oswald', sans-serif;">Ready to partner with MN Coffee?</h2>
        <p class="mb-4">Join us in building a sustainable specialty coffee industry in Bangladesh.</p>
        <a href="{{ route('contact') }}" class="btn" style="background: #A45517; color: white; padding: 12px 30px; border-radius: 50px;">Contact Us for B2B Supply</a>
    </div>
</section>
@endsection
