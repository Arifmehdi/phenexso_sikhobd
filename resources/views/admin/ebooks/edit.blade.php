@extends('admin.master')

@section('title') Admin Dashboard | Edit Ebook @endsection

@section('body')
<section class="content py-3">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card shadow-lg">
                <div class="card-header bg-white">
                    <h3 class="card-title text-bold text-muted">
                        <i class="fas fa-edit text-primary mr-1"></i> Edit Ebook: {{ $ebook->title_en }}
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.ebooks.update', $ebook->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Ebook Title (English) *</label>
                                <input type="text" name="title_en" class="form-control" value="{{ old('title_en', $ebook->title_en) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Ebook Title (Bangla)</label>
                                <input type="text" name="title_bn" class="form-control" value="{{ old('title_bn', $ebook->title_bn) }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Category *</label>
                                <select name="category_id" class="form-control" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $ebook->category_id == $category->id ? 'selected' : '' }}>{{ $category->name_en }} ({{ $category->name_bn }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Author Name</label>
                                <input type="text" name="author_name" class="form-control" value="{{ old('author_name', $ebook->author_name) }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label>Price (৳)</label>
                                <input type="number" name="price" class="form-control" step="0.01" value="{{ old('price', $ebook->price) }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Discount (৳)</label>
                                <input type="number" name="discount" class="form-control" step="0.01" value="{{ old('discount', $ebook->discount) }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Status *</label>
                                <select name="status" class="form-control" required>
                                    <option value="pending" {{ $ebook->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ $ebook->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ $ebook->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label>Free Preview Pages</label>
                                <input type="number" name="preview_pages" class="form-control" min="1" value="{{ old('preview_pages', $ebook->preview_pages ?? 3) }}">
                                <small class="form-text text-muted">Pages non-buyers can read (paid eBooks).</small>
                            </div>
                            <div class="col-md-8 mb-3 d-flex align-items-center">
                                <div class="custom-control custom-switch mt-3">
                                    <input type="checkbox" class="custom-control-input" id="is_free" name="is_free" value="1" {{ $ebook->is_free ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_free">
                                        <strong>Free eBook</strong> — anyone can read, <u>download</u> &amp; print (no purchase needed).
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Description (Bangla)</label>
                            <textarea name="description_bn" class="form-control" rows="4">{{ old('description_bn', $ebook->description_bn) }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label>Cover Image</label>
                                <input type="file" name="cover_image" class="form-control" accept="image/*">
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle"></i> Recommended: <strong>260 × 372 px</strong> (portrait, 2× for sharpness). Leave blank to keep current.
                                </small>
                                @if($ebook->cover_image)
                                    <img src="{{ asset('storage/ebook_covers/' . $ebook->cover_image) }}" alt="cover" class="img-thumbnail mt-2" style="max-height: 110px;">
                                @endif
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Full Ebook (PDF)</label>
                                <input type="file" name="file" class="form-control" accept="application/pdf">
                                <small class="form-text text-muted">Leave blank to keep current.</small>
                                @if($ebook->file_path)
                                    <a href="{{ asset('storage/ebook_files/' . $ebook->file_path) }}" target="_blank" class="d-block mt-2 small">
                                        <i class="fas fa-file-pdf text-danger"></i> Current file
                                    </a>
                                @endif
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Preview File (PDF)</label>
                                <input type="file" name="preview_file" class="form-control" accept="application/pdf">
                                <small class="form-text text-muted">Leave blank to keep current.</small>
                                @if($ebook->preview_path)
                                    <a href="{{ asset('storage/ebook_previews/' . $ebook->preview_path) }}" target="_blank" class="d-block mt-2 small">
                                        <i class="fas fa-file-pdf text-danger"></i> Current preview
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary px-5">Update Ebook</button>
                            <a href="{{ route('admin.ebooks.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
