@extends('admin.master')
@section('title',"Admin Dashboard | Vehicles")

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
                        <i class="fas fa-truck-moving text-primary"></i> Vehicles
                    </h3>
                    <a href="{{ route('admin.vehicles.create') }}" class="btn btn-outline-primary btn-xs py-1">
                        <i class="fas fa-plus-square"></i> Add New Vehicle
                    </a>
                </div>
            </div>

            <!-- Table Card -->
            <div class="card w3-round shadow-lg">
                <div class="card-header pl-2 py-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title w3-small text-bold text-muted">
                            <i class="fas fa-th text-primary pt-1"></i> All Vehicles
                        </h3>

                        <!-- Search Box -->
                        <div class="card-tools">
                            <form action="{{ route('admin.vehicles.index') }}" method="GET">
                                <div class="input-group input-group-sm">
                                    <input type="search" name="search" value="{{ $search ?? '' }}"
                                        class="form-control border-right-0 border py-2"
                                        placeholder="Search type, plate no, rider...">
                                    <div class="input-group-append">
                                        <button type="submit" class="input-group-text bg-transparent">
                                            <i class="fa fa-search w3-text-orange"></i>
                                        </button>
                                        @if(!empty($search))
                                            <a href="{{ route('admin.vehicles.index') }}" class="input-group-text bg-transparent" title="Clear">
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
                            <p class="text-muted w3-small mb-2 px-2">Showing results for "<strong>{{ $search }}</strong>" — {{ $vehicles->total() }} found.</p>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover table-md mb-0">
                                <thead class="w3-small text-muted thead-light">
                                    <tr>
                                        <th width="30">#</th>
                                        <th width="70">Action</th>
                                        <th>Vehicle Type</th>
                                        <th>Plate Number</th>
                                        <th width="90">Capacity</th>
                                        <th>Assigned Rider</th>
                                        <th width="90">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($vehicles as $vehicle)
                                        <tr class="bg-white">
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <a class="btn btn-primary btn-xs dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                        Action
                                                    </a>
                                                    <div class="dropdown-menu">
                                                        <a href="{{ route('admin.vehicles.edit', $vehicle->id) }}" class="dropdown-item"><i class="fa fa-edit text-info"></i> Edit</a>
                                                        <form action="{{ route('admin.vehicles.destroy', $vehicle->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this vehicle?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger"><i class="fa fa-trash"></i> Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><strong>{{ $vehicle->vehicle_type }}</strong></td>
                                            <td>{{ $vehicle->plate_number }}</td>
                                            <td class="text-center">{{ $vehicle->capacity }}</td>
                                            <td>
                                                @if($vehicle->drivers->count() > 0)
                                                    @foreach($vehicle->drivers as $rider)
                                                        <span class="badge badge-secondary">{{ $rider->name }} ({{ $rider->mobile }})</span><br>
                                                    @endforeach
                                                @else
                                                    <span class="text-muted">None</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-{{ $vehicle->status == '1' ? 'success' : ($vehicle->status == '0' ? 'warning' : 'danger') }}">
                                                    {{ $vehicle->status == '1' ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-danger h6 text-center py-4">No vehicles found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="w3-small float-right pt-1">
                            {!! $vehicles->links() !!}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
