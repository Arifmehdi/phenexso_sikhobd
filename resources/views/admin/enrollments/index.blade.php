@extends('admin.master')

@section('title', 'Admin Dashboard | Enrollments')

@section('body')
<section class="content py-3">
    <div class="row">
        <div class="col-12">
            <div class="card mb-2 shadow-lg">
                <div class="card-header px-2 py-2">
                    <h3 class="card-title text-muted text-bold"><i class="fas fa-graduation-cap text-primary"></i> Course Enrollments</h3>
                    <div class="card-tools">
                        <form action="{{ route('admin.enrollments.index') }}" method="GET" class="input-group input-group-sm" style="width: 250px;">
                            <input type="text" name="search" class="form-control float-right" placeholder="Search user or course..." value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card shadow-lg">
                <div class="card-body p-0 table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Student</th>
                                <th>Course</th>
                                <th>Order</th>
                                <th>Enrolled At</th>
                                <th>Status</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($enrollments as $enrollment)
                            <tr>
                                <td>{{ $enrollment->id }}</td>
                                <td>
                                    <strong>{{ $enrollment->user->name }}</strong><br>
                                    <small class="text-muted">{{ $enrollment->user->mobile }}</small>
                                </td>
                                <td>
                                    <span class="badge badge-info">{{ $enrollment->product->name_en }}</span>
                                </td>
                                <td>
                                    @if($enrollment->order_id)
                                    <a href="{{ route('admin.orderDeatils', $enrollment->order_id) }}">#{{ $enrollment->order_id }}</a>
                                    @else
                                    <span class="text-success">Free Enrollment</span>
                                    @endif
                                </td>
                                <td>{{ $enrollment->enrolled_at ? $enrollment->enrolled_at->format('d M Y, h:i A') : 'Pending' }}</td>
                                <td>
                                    <form action="{{ route('admin.enrollments.updateStatus', $enrollment->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <select name="status" onchange="this.form.submit()" class="form-control form-control-sm d-inline-block w-auto 
                                            @if($enrollment->status == 'active') text-success @elseif($enrollment->status == 'pending') text-warning @else text-danger @endif">
                                            <option value="pending" {{ $enrollment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="active" {{ $enrollment->status == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="completed" {{ $enrollment->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="expired" {{ $enrollment->status == 'expired' ? 'selected' : '' }}>Expired</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('admin.enrollments.destroy', $enrollment->id) }}" class="btn btn-outline-danger btn-xs" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">No enrollments found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($enrollments->hasPages())
                <div class="card-footer clearfix">
                    {{ $enrollments->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
