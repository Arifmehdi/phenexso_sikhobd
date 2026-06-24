@extends('website.layouts.sikhobd')

@section('title', 'আমার সার্টিফিকেট — ' . ($ws->name ?? env('APP_NAME')))

@section('content')
<section class="section" style="padding: 60px 0; background:#f8fafc; min-height:70vh;">
    <div class="container">
        <div style="max-width: 900px; margin: 0 auto;">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; flex-wrap:wrap; gap:10px;">
                <h1 style="font-weight:900; color:#1e293b; font-size:26px; margin:0;">
                    <i class="fa-solid fa-certificate" style="color:#c7a008;"></i> আমার সার্টিফিকেট
                </h1>
                <a href="{{ route('user.dashboard', ['activeTab' => 'courses']) }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fa-solid fa-arrow-left"></i> ড্যাশবোর্ডে ফিরুন
                </a>
            </div>

            @forelse($certificates as $certificate)
            <div style="background:#fff; border:1px solid #e2e8f0; border-radius:16px; padding:20px 24px; margin-bottom:14px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
                <div>
                    <h4 style="margin:0; font-weight:800; color:#1e3a8a;">
                        {{ optional($certificate->course)->name_en ?? optional($certificate->course)->name_bn ?? 'Course' }}
                    </h4>
                    <div style="color:#64748b; font-size:13px; margin-top:4px;">
                        Certificate No: <strong>{{ $certificate->certificate_number }}</strong>
                        &middot; Issued: {{ optional($certificate->issued_at)->format('d M, Y') }}
                        @if(!is_null($certificate->final_score))
                            &middot; Score: {{ rtrim(rtrim(number_format($certificate->final_score, 2), '0'), '.') }}%
                        @endif
                    </div>
                </div>
                <a href="{{ route('user.certificate', $certificate->product_id) }}" target="_blank" class="btn btn-success btn-sm">
                    <i class="fa-solid fa-download"></i> Download
                </a>
            </div>
            @empty
            <div style="text-align:center; background:#fff; border:1px solid #e2e8f0; border-radius:20px; padding:50px 20px;">
                <i class="fa-solid fa-certificate" style="font-size:46px; color:#cbd5e1;"></i>
                <h5 style="margin-top:16px; color:#1e293b; font-weight:800;">এখনো কোনো সার্টিফিকেট নেই</h5>
                <p class="text-muted">কোর্স সম্পূর্ণ করে সার্টিফিকেট অর্জন করুন।</p>
                <a href="{{ route('user.dashboard', ['activeTab' => 'courses']) }}" class="btn btn-primary">আমার কোর্সসমূহ</a>
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
