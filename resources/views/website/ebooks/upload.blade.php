@extends('website.layouts.sikhobd')

@section('title', 'ই-বুক আপলোড করুন — ' . ($ws->website_title ?? 'Qalam HR'))

@section('content')
<section class="section" style="padding: 60px 0; background: #f8fafc;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card border-0 shadow-lg" style="border-radius: 20px;">
                    <div class="card-header bg-primary text-white p-4" style="border-radius: 20px 20px 0 0;">
                        <h3 class="mb-0" style="font-weight: 700;">নতুন ই-বুক আপলোড করুন</h3>
                        <p class="mb-0 small">আপনার তৈরি করা ই-বুক সবার সাথে শেয়ার করুন</p>
                    </div>
                    <div class="card-body p-5">
                        <form action="{{ route('ebooks.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label font-weight-bold">ই-বুক শিরোনাম (English) *</label>
                                    <input type="text" name="title_en" class="form-control" placeholder="Enter Ebook Title" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label font-weight-bold">ই-বুক শিরোনাম (বাংলা)</label>
                                    <input type="text" name="title_bn" class="form-control" placeholder="বইয়ের নাম লিখুন">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label font-weight-bold">ক্যাটেগরি নির্বাচন করুন *</label>
                                    <select name="category_id" class="form-control" required>
                                        <option value="">ক্যাটেগরি সিলেক্ট করুন</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name_bn ?? $category->name_en }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label font-weight-bold">লেখকের নাম</label>
                                    <input type="text" name="author_name" class="form-control" placeholder="Author Name">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label font-weight-bold">মূল্য (৳)</label>
                                    <input type="number" name="price" class="form-control" placeholder="0.00" step="0.01">
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label font-weight-bold">ডিসকাউন্ট (৳)</label>
                                    <input type="number" name="discount" class="form-control" placeholder="0.00" step="0.01">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label font-weight-bold">বইয়ের বর্ণনা (বাংলা)</label>
                                <textarea name="description_bn" class="form-control" rows="5" placeholder="বইটি সম্পর্কে কিছু লিখুন..."></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-4">
                                    <label class="form-label font-weight-bold">বইয়ের কভার ইমেজ *</label>
                                    <input type="file" name="cover_image" class="form-control" accept="image/*" required>
                                    <small class="text-muted">JPG, PNG (Max 2MB)</small>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <label class="form-label font-weight-bold">সম্পূর্ণ বই (PDF) *</label>
                                    <input type="file" name="file" class="form-control" accept="application/pdf" required>
                                    <small class="text-muted">PDF Format (Max 10MB)</small>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <label class="form-label font-weight-bold">প্রিভিউ অংশ (PDF)</label>
                                    <input type="file" name="preview_file" class="form-control" accept="application/pdf">
                                    <small class="text-muted">বইয়ের কিছু অংশ (Max 2MB)</small>
                                </div>
                            </div>

                            <div class="text-right mt-4">
                                <button type="submit" class="btn btn-primary btn-lg px-5 shadow" style="border-radius: 50px;">
                                    <i class="fa-solid fa-cloud-arrow-up mr-2"></i> ই-বুকটি জমা দিন
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
