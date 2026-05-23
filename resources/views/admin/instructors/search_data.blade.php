<table id="instructorsTable" class="table table-sm table-bordered table-striped">
    <thead>
    <tr>
        <th width="20">SL</th>
        <th width="100">Action</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Role</th>
        <th>Courses</th>
        <th>Approval</th>
    </tr>
    </thead>
    <tbody>
        <?php $i = (($instructors->currentPage() - 1) * $instructors->perPage() + 1); ?>

        @forelse($instructors as $instructor)
        <tr>
            <td>{{ $i++ }}</td>
            <td>
                <div class="dropdown show">
                    <a class="btn btn-primary btn-xs dropdown-toggle" href="#" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="{{ route('admin.instructors.edit', $instructor->id) }}">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.show-user', $instructor->id) }}">
                            <i class="fa fa-eye"></i> Show
                        </a>
                        <form action="{{ route('admin.instructors.destroy', $instructor->id) }}" method="post"
                              onsubmit="return confirm('Are you sure you want to delete this instructor?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="dropdown-item">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </td>
            <td>{{ $instructor->name }}</td>
            <td>{{ $instructor->email }}</td>
            <td>{{ $instructor->mobile ?? 'N/A' }}</td>
            <td>
                <span class="badge badge-info">{{ Str::ucfirst($instructor->role) }}</span>
            </td>
            <td>
                @php
                    $courseCount = \App\Models\Product::where('instructor_id', $instructor->id)
                        ->where('type', 'course')
                        ->count();
                @endphp
                <span class="badge badge-primary">{{ $courseCount }}</span>
            </td>
            <td>
                <form action="{{ route('admin.instructors.toggle-approval', $instructor->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input"
                               id="isApprovedSwitch{{ $instructor->id }}"
                               name="is_approve" onchange="this.form.submit()"
                               {{ $instructor->is_approve ? 'checked' : '' }}>
                        <label class="custom-control-label" for="isApprovedSwitch{{ $instructor->id }}"></label>
                    </div>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8" class="text-danger h5 text-center">No Instructors Found</td>
        </tr>
        @endforelse
    </tbody>
</table>

{{ $instructors->appends(request()->query())->links() }}
