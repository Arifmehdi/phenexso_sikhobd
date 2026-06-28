@extends('website.layouts.sikhobd')

@section('title', __('frontend.page.contact.title') . ' — ' . ($ws->website_title ?? 'Qalam HR'))

@section('meta')
<meta name="description" content="{{ __('frontend.contact.subtitle') }}">
<meta name="keywords" content="Contact, {{ $ws->website_title ?? 'Qalam HR' }}, Help, Inquiries">
@endsection

@section('content')
<!-- Page Hero -->
<section class="page-hero">
  <div class="container">
    <h1>{{ __('frontend.contact.title') }}</h1>
    <p>{{ __('frontend.contact.subtitle') }}</p>
  </div>
</section>

<!-- Contact Section -->
<section class="section">
  <div class="container">
    <div class="contact-grid">
      <!-- Info Card -->
      <div class="info-card">
        <h3 style="color:var(--primary); margin-bottom: 12px;">{{ __('frontend.contact.get_in_touch') }}</h3>
        <p style="color:var(--text-soft); font-size:14px;">{{ __('frontend.contact.response_time') }}</p>
        <div class="info-item">
          <div class="info-icon"><i class="fa-solid fa-phone"></i></div>
          <div>
            <h4>{{ __('frontend.contact.phone') }}</h4>
            <p>{{ $ws->phone ?? '16910 (24/7 helpline)' }}</p>
          </div>
        </div>
        <div class="info-item">
          <div class="info-icon"><i class="fa-solid fa-envelope"></i></div>
          <div>
            <h4>{{ __('frontend.contact.email') }}</h4>
            <p>{{ $ws->email ?? 'support@example.com' }}</p>
          </div>
        </div>
        <div class="info-item">
          <div class="info-icon"><i class="fa-solid fa-location-dot"></i></div>
          <div>
            <h4>{{ __('frontend.contact.office') }}</h4>
            <p>{{ $ws->address ?? 'Dhaka, Bangladesh' }}</p>
          </div>
        </div>
        <div class="info-item">
          <div class="info-icon"><i class="fa-solid fa-clock"></i></div>
          <div>
            <h4>{{ __('frontend.contact.hours') }}</h4>
            <p>Sun – Thu, 9:00 AM – 8:00 PM</p>
          </div>
        </div>
      </div>

      <!-- Contact Form -->
      <form class="contact-form" action="{{ route('contact.store') }}" method="POST">
        @csrf
        @if(session('success'))
          <div class="alert alert-success" style="margin-bottom: 20px;">{{ session('success') }}</div>
        @endif
        <h3 style="color:var(--primary); margin-bottom:20px;">{{ __('frontend.contact.send_message') }}</h3>
        <div class="form-row">
          <div class="field">
            <label>{{ __('frontend.contact.your_name') }}</label>
            <input type="text" name="name" required>
          </div>
          <div class="field">
            <label>{{ __('frontend.contact.your_email') }}</label>
            <input type="email" name="email" required>
          </div>
        </div>
        <div class="form-row">
          <div class="field">
            <label>{{ __('frontend.contact.your_phone') }}</label>
            <input type="tel" name="phone">
          </div>
          <div class="field">
            <label>{{ __('frontend.contact.subject') }}</label>
            <select name="subject">
              <option>{{ __('frontend.contact.subjects.general') }}</option>
              <option>{{ __('frontend.contact.subjects.course') }}</option>
              <option>{{ __('frontend.contact.subjects.payment') }}</option>
              <option>{{ __('frontend.contact.subjects.technical') }}</option>
            </select>
          </div>
        </div>
        <div class="field">
          <label>{{ __('frontend.contact.message') }}</label>
          <textarea name="message" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">{{ __('frontend.contact.send_btn') }}</button>
      </form>
    </div>
    <div class="contact-page-map mt-5">
        <iframe
            src="{{ $ws->iframe_map ?? 'https://maps.google.com/maps?q=dhaka&t=&z=13&ie=UTF8&iwloc=&output=embed' }}"
            frameborder="0"
            scrolling="no"
            style="width: 100%; height: 450px;"
        ></iframe>
    </div>
  </div>
</section>
@endsection

@push('js')
<script src="{{ asset('sikhobd/js/partials.js') }}"></script>
<script src="{{ asset('sikhobd/js/main.js') }}"></script>
@endpush
