@extends('website.layouts.sikhobd')

@section('title', 'যোগাযোগ — '.($ws->name ?? env('APP_NAME')))

@section('meta')
<meta name="description" content="Get in touch with {{ $ws->name ?? env('APP_NAME') }}. We are here to help you with your inquiries.">
<meta name="keywords" content="Contact, {{ $ws->name ?? env('APP_NAME') }}, Help, Inquiries">
@endsection

@section('content')
<!-- Page Hero -->
<section class="page-hero">
  <div class="container">
    <h1 data-i18n="page.contact.title">যোগাযোগ করুন</h1>
    <p data-i18n="page.contact.sub">যেকোনো প্রশ্ন বা পরামর্শে আমরা সবসময় প্রস্তুত</p>
  </div>
</section>

<!-- Contact Section -->
<section class="section">
  <div class="container">
    <div class="contact-grid">
      <!-- Info Card -->
      <div class="info-card">
        <h3 style="color:var(--primary); margin-bottom: 12px;">Get in touch</h3>
        <p style="color:var(--text-soft); font-size:14px;">We respond within 24 hours.</p>
        <div class="info-item">
          <div class="info-icon"><i class="fa-solid fa-phone"></i></div>
          <div>
            <h4>Phone</h4>
            <p>{{ $ws->phone ?? '16910 (24/7 helpline)' }}</p>
          </div>
        </div>
        <div class="info-item">
          <div class="info-icon"><i class="fa-solid fa-envelope"></i></div>
          <div>
            <h4>Email</h4>
            <p>{{ $ws->email ?? 'support@10minuteschool.com' }}</p>
          </div>
        </div>
        <div class="info-item">
          <div class="info-icon"><i class="fa-solid fa-location-dot"></i></div>
          <div>
            <h4>Office</h4>
            <p>{{ $ws->address ?? 'House 53, Road 12, Block C, Banani, Dhaka 1213' }}</p>
          </div>
        </div>
        <div class="info-item">
          <div class="info-icon"><i class="fa-solid fa-clock"></i></div>
          <div>
            <h4>Hours</h4>
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
        <h3 style="color:var(--primary); margin-bottom:20px;">Send us a message</h3>
        <div class="form-row">
          <div class="field"><label data-i18n="form.name">আপনার নাম</label><input type="text" name="name" required></div>
          <div class="field"><label data-i18n="form.email">ইমেইল</label><input type="email" name="email" required></div>
        </div>
        <div class="form-row">
          <div class="field"><label data-i18n="form.phone">ফোন</label><input type="tel" name="phone"></div>
          <div class="field"><label data-i18n="form.subject">বিষয়</label><select name="subject"><option>General</option><option>Course inquiry</option><option>Payment</option><option>Technical</option></select></div>
        </div>
        <div class="field"><label data-i18n="form.message">আপনার বার্তা</label><textarea name="message" required></textarea></div>
        <button type="submit" class="btn btn-primary" data-i18n="form.send">বার্তা পাঠান</button>
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