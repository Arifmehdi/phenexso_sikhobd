<table class="table table-striped table-bordered table-hover table-md">
    <thead class="w3-small text-muted thead-light">
        <tr>
            <th scope="col" width="30">SL</th>
            <th scope="col" width="60">Action</th>
            <th scope="col">Course Name</th>
            <th scope="col">Instructor</th>
            <th scope="col">Fee</th>
            <th scope="col">Discount</th>
            <th scope="col">Final Price</th>
            <th scope="col">Image</th>
            <th scope="col">Status</th>
            <th scope="col">Approval</th>
        </tr>
    </thead>
    <tbody class="">
        <?php $i = (($courses->currentPage() - 1) * $courses->perPage() + 1); ?>
        @forelse ($courses as $key => $course)
            <tr>
                <td scope="row">{{ $i++ }}</td>
                <td scope="row">
                    <div class="dropdown show">
                        <a class="btn btn-primary btn-xs dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a href="{{  route('admin.courseEdit',$course)}}" class="dropdown-item"><i class="fa fa-edit"></i> Edit</a>
                            
                            <a href="{{ route('admin.lessons.index', $course->id) }}" class="dropdown-item text-primary"><i class="fa fa-graduation-cap"></i> Manage Classes</a>

                            <form action="{{ route('admin.courseDelete',$course)}}" method="post" onclick="return confirm('Are you sure to delete?')">
                                @csrf
                                <button type="submit" class="dropdown-item"><i class="fa fa-trash"></i> Delete</button>
                            </form>
                        </div>
                    </div>
                </td>

                <td>{{ Str::limit($course->name_en, 30) }}</td>
                <td>
                    @if($course->instructor)
                        <span class="badge badge-secondary">{{ $course->instructor->name }}</span>
                    @else
                        <span class="text-muted">Not assigned</span>
                    @endif
                </td>
                <td>{{ number_format($course->selling_price, 2) }}</td>
                <td>{{ number_format($course->discount, 2) }}</td>
                <td class="text-bold text-primary">{{ number_format($course->final_price, 2) }}</td>
                <td>
                    <img width="30px" height="20px" src="{{ route('imagecache', ['template' => 'sbixs', 'filename' => $course->fi()]) }}" alt="">
                </td>
                <td>
                    <button class="badge border-0 {{ $course->active ? 'badge-primary' : 'badge-danger' }} courseStatus"
                        data-url="{{ route('admin.courseStatus', ['course' => $course->id]) }}">
                        {{ $course->active ? 'Active' : 'Inactive' }}
                    </button>
                </td>
                <td>
                    <form action="{{ route('admin.product.toggle-approval', $course->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="isActiveSwitch{{ $course->id }}" name="active" {{ $course->active ? 'checked' : '' }} onchange="this.form.submit()">
                            <label class="custom-control-label" for="isActiveSwitch{{ $course->id }}"></label>
                        </div>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="10" class="text-danger h5 text-center">No Course Found</td>
            </tr>
        @endforelse
    </tbody>
</table>

