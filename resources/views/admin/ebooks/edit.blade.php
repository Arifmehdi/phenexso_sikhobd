@extends('admin.master')

@section('title') Admin Dashboard | Edit Ebook @endsection

@section('body')
<section class="content py-3">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-lg">
                <div class="card-header bg-white">
                    <h3 class="card-title text-bold text-muted">Edit Ebook: {{ $ebook->title_en }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.ebooks.update', $ebook->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Title (English)</label>
                            <input type="text" name="title_en" class="form-control" value="{{ $ebook->title_en }}" required>
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <select name="category_id" class="form-control">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $ebook->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name_en }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Price</label>
                                    <input type="number" name="price" class="form-control" value="{{ $ebook->price }}" step="0.01">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="pending" {{ $ebook->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ $ebook->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="rejected" {{ $ebook->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update Ebook</button>
                            <a href="{{ route('admin.ebooks.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
