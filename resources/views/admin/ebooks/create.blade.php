@extends('admin.master')

@section('title') Admin Dashboard | Upload New Ebook @endsection

@section('body')
<section class="content py-3">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card shadow-lg">
                <div class="card-header bg-white">
                    <h3 class="card-title text-bold text-muted">
                        <i class="fas fa-upload text-primary mr-1"></i> Upload New Ebook
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.ebooks.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Ebook Title (English) *</label>
                                <input type="text" name="title_en" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Ebook Title (Bangla)</label>
                                <input type="text" name="title_bn" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Category *</label>
                                <select name="category_id" class="form-control" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name_en }} ({{ $category->name_bn }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Author Name</label>
                                <input type="text" name="author_name" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Price (৳)</label>
                                <input type="number" name="price" class="form-control" step="0.01">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Discount (৳)</label>
                                <input type="number" name="discount" class="form-control" step="0.01">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Description (Bangla)</label>
                            <textarea name="description_bn" class="form-control" rows="4"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label>Cover Image *</label>
                                <input type="file" name="cover_image" class="form-control" accept="image/*" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Full Ebook (PDF) *</label>
                                <input type="file" name="file" class="form-control" accept="application/pdf" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Preview File (PDF)</label>
                                <input type="file" name="preview_file" class="form-control" accept="application/pdf">
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary px-5">Upload Ebook</button>
                            <a href="{{ route('admin.ebooks.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
