@extends('admin.master')
@section('title',"Admin Dashboard | Agencies")

@section('body')
<section class="content py-3">
    <div class="row">
        <div class="col-md-11 mx-auto">

            @if(session('success'))
                <div class="alert alert-success py-2">{{ session('success') }}</div>
            @endif

            <!-- Top Header Card -->
            <div class="card mb-2 shadow-lg">
                <div class="card-header- px-2 py-2 d-flex justify-content-between align-items-center">
                    <h3 class="card-title w3-small text-bold text-muted pt-1">
                        <i class="fas fa-truck text-primary"></i> Delivery Agencies
                    </h3>
                    <a href="{{ route('admin.drivers.create') }}" class="btn btn-outline-primary btn-xs py-1">
                        <i class="fas fa-plus-square"></i> Add New Agency
                    </a>
                </div>
            </div>

            <!-- Table Card -->
            <div class="card w3-round shadow-lg">
                <div class="card-header pl-2 py-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title w3-small text-bold text-muted">
                            <i class="fas fa-th text-primary pt-1"></i> All Agencies
                        </h3>

                        <!-- Search Box -->
                        <div class="card-tools">
                            <form action="{{ route('admin.drivers.index') }}" method="GET">
                                <div class="input-group input-group-sm">
                                    <input type="search" name="search" value="{{ $search ?? '' }}"
                                        class="form-control border-right-0 border py-2"
                                        placeholder="Search agency, contact name, mobile, email, license, NID...">
                                    <div class="input-group-append">
                                        <button type="submit" class="input-group-text bg-transparent">
                                            <i class="fa fa-search w3-text-orange"></i>
                                        </button>
                                        @if(!empty($search))
                                            <a href="{{ route('admin.drivers.index') }}" class="input-group-text bg-transparent" title="Clear">
                                                <i class="fa fa-times text-danger"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card-body bg-light px-0 pb-0 pt-2">
                    <div class="col-sm-12">
                        @if(!empty($search))
                            <p class="text-muted w3-small mb-2 px-2">Showing results for "<strong>{{ $search }}</strong>" — {{ $drivers->total() }} found.</p>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover table-md mb-0">
                                <thead class="w3-small text-muted thead-light">
                                    <tr>
                                        <th width="30">#</th>
                                        <th width="70">Action</th>
                                        <th>Agency Name / Contact Person</th>
                                        <th>Mobile</th>
                                        <th>Email</th>
                                        <th>License No</th>
                                        <th>NID</th>
                                        <th>Address</th>
                                        <th width="90">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($drivers as $driver)
                                        <tr class="bg-white">
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <a class="btn btn-primary btn-xs dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                        Action
                                                    </a>
                                                    <div class="dropdown-menu">
                                                        <a href="{{ route('admin.drivers.edit', $driver->id) }}" class="dropdown-item"><i class="fa fa-edit text-info"></i> Edit</a>
                                                        <form action="{{ route('admin.drivers.destroy', $driver->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this agency?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger"><i class="fa fa-trash"></i> Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <strong>{{ $driver->agency_name ?: '—' }}</strong>
                                                @if($driver->name)
                                                    <br><small class="text-muted">{{ $driver->name }}</small>
                                                @endif
                                            </td>
                                            <td>{{ $driver->mobile }}</td>
                                            <td>{{ $driver->email }}</td>
                                            <td>{{ $driver->license_no }}</td>
                                            <td>{{ $driver->nid }}</td>
                                            <td>{{ $driver->address }}</td>
                                            <td class="text-center">
                                                <span class="badge badge-{{ $driver->is_approve == '1' ? 'success' : 'warning' }}">
                                                    {{ $driver->is_approve == '1' ? 'Approved' : 'Pending' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-danger h6 text-center py-4">No agencies found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="w3-small float-right pt-1">
                            {!! $drivers->links() !!}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
