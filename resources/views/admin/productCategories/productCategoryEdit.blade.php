@extends('admin.master')

@section('title')
   Admin Dashboard | Product Category Edit
@endsection

@push('css')
<!-- Add any page-specific CSS here -->
@endpush

@section('body')
<section class="content py-3">
    <div class="row">
        <div class="col-md-8 mx-auto">

            <!-- Header Card -->
            <div class="card mb-2 shadow-lg">
                <div class="card-header- d-flex justify-content-between align-items-center px-2 py-2">
                    <h3 class="card-title text-sm text-bold text-muted pt-1">
                        <i class="fas fa-edit text-primary"></i> Edit Category: {{ $category->name_en }}
                    </h3>
                    <a href="{{ route('admin.productCategoriesAll') }}" class="btn btn-outline-primary btn-xs">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>

            <!-- Form Card -->
            <div class="card card-primary card-outline shadow-lg">
                <div class="card-body bg-light px-3">
                    <form action="{{ route('admin.productCategoryUpdate', $category) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')

                        {{-- Category Type --}}
                        <div class="form-group row">
                            <label for="type" class="col-sm-3 col-form-label text-left">Category Type <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                                    <option value="product" {{ old('type', $category->type) == 'product' ? 'selected' : '' }}>Physical Product (Ecommerce)</option>
                                    <option value="course" {{ old('type', $category->type) == 'course' ? 'selected' : '' }}>Digital Course (E-learning)</option>
                                </select>
                                @error('type') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Position -->
                        <div class="form-group row">
                            <label for="position" class="col-sm-3 col-form-label text-left">Position</label>
                            <div class="col-sm-9">
                                <input type="number" name="position" value="{{ old('position', $category->position) }}" id="position" class="form-control" placeholder="Sort Order">
                                @error('position') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        {{-- Category Name (English) --}}
                        <div class="form-group row">
                            <label for="name_en" class="col-sm-3 col-form-label text-left">Category Name (English) <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" name="name_en" value="{{ old('name_en', $category->name_en) }}" class="form-control" placeholder="Name" required onkeyup="makeSlug(this.value)">
                                @error('name_en') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        {{-- Category Name (Bangla) --}}
                        <div class="form-group row">
                            <label for="name_bn" class="col-sm-3 col-form-label text-left">Category Name (Bangla)</label>
                            <div class="col-sm-9">
                                <input type="text" name="name_bn" value="{{ old('name_bn', $category->name_bn) }}" class="form-control" placeholder="Name">
                                @error('name_bn') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        {{-- Slug --}}
                        <div class="form-group row">
                            <label for="slug" class="col-sm-3 col-form-label text-left">Slug <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" id="slug" name="slug" value="{{ old('slug', $category->slug) }}" class="form-control" placeholder="URL" required>
                                @error('slug') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Parent Category -->
                        <div class="form-group row">
                            <label for="parent_id" class="col-sm-3 col-form-label text-left">Parent Category</label>
                            <div class="col-sm-9">
                                <select name="parent_id" id="parent_id" class="form-control">
                                    <option value="">-- None (Main Category) --</option>
                                    @foreach($categories as $cat)
                                        @if($cat->parent_id === null)
                                            <option value="{{ $cat->id }}" {{ old('parent_id', $category->parent_id) == $cat->id ? 'selected' : '' }}>
                                                [{{ strtoupper($cat->type) }}] {{ $cat->name_en }}
                                            </option>
                                            {{-- Subcategories --}}
                                            @foreach($cat->children as $child)
                                                <option value="{{ $child->id }}" {{ old('parent_id', $category->parent_id) == $child->id ? 'selected' : '' }}>
                                                    &nbsp;&nbsp;├─ {{ $child->name_en }}
                                                </option>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Excerpt --}}
                        <div class="form-group row">
                            <label for="excerpt" class="col-sm-3 col-form-label text-left">Excerpt</label>
                            <div class="col-sm-9">
                                <textarea name="excerpt" rows="2" class="form-control" placeholder="Short description...">{{ old('excerpt', $category->excerpt) }}</textarea>
                            </div>
                        </div>

                        {{-- Image --}}
                        <div class="form-group row">
                            <label for="image" class="col-sm-3 col-form-label text-left">Update Image</label>
                            <div class="col-sm-9 text-center">
                                @if($category->image)
                                    <img src="{{ route('imagecache', ['template' => 'sbixs', 'filename' => $category->fi()]) }}" class="mb-2 w3-round shadow-sm" alt="">
                                @endif
                                <input type="file" name="image" class="form-control">
                            </div>
                        </div>

                        {{-- Active --}}
                        <div class="form-group row">
                            <label for="active" class="col-sm-3 col-form-label text-left">Active</label>
                            <div class="col-sm-9">
                                <div class="form-check">
                                    <input class="form-check-input" name="active" type="checkbox" id="active" {{ $category->active ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <div class="form-group row mb-0">
                            <div class="col-sm-9 offset-sm-3 text-right">
                                <button type="submit" class="btn btn-primary">Update Category</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection

@push('js')
<script>
    function makeSlug(val) {
        let str = val.trim().toLowerCase();
        let slug = str.replace(/\s+/g, '-').replace(/[^\w\-]+/g, '');
        document.getElementById('slug').value = slug;
    }
</script>
@endpush
