@extends('admin.master')
@section('title', 'Admin Dashboard | Edit Instructor')
@section('body')
    <section class="pt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-edit"></i> Edit Instructor
                            </h3>
                            <div class="card-tools">
                                <a href="{{ route('admin.instructors.index') }}" class="btn btn-outline-light btn-xs">
                                    <i class="fa fa-arrow-left"></i> Back
                                </a>
                            </div>
                        </div>

                        <form action="{{ route('admin.instructors.update', $instructor->id) }}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control"
                                           value="{{ old('name', $instructor->name) }}" placeholder="Enter full name" required>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" class="form-control"
                                           value="{{ old('email', $instructor->email) }}" placeholder="Enter email" required>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="mobile">Phone/Mobile</label>
                                    <input type="text" name="mobile" id="mobile" class="form-control"
                                           value="{{ old('mobile', $instructor->mobile) }}" placeholder="Enter phone number">
                                    @error('mobile')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password">New Password <small class="text-muted">(leave blank to keep current)</small></label>
                                    <input type="password" name="password" id="password" class="form-control"
                                           placeholder="Enter new password">
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="is_approve">Status</label>
                                    <select name="is_approve" id="is_approve" class="form-control">
                                        <option value="0" {{ old('is_approve', $instructor->is_approve) == '0' ? 'selected' : '' }}>Pending</option>
                                        <option value="1" {{ old('is_approve', $instructor->is_approve) == '1' ? 'selected' : '' }}>Approved</option>
                                    </select>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update Instructor
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
