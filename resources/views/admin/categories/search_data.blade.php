<table class="table table-striped table-bordered table-hover table-md">
    <thead class="w3-small text-muted thead-light">
    <tr>
        <th scope="col" width="30">SL</th>
        <th scope="col" width="60">Action</th>
        <th scope="col">Name</th>
        <th scope="col">Active</th>
    </tr>
    </thead>
    <tbody>
        <?php $i = (($categories->currentPage() - 1) * $categories->perPage() + 1); ?>
    @forelse($categories as $category)
        <tr>
            <td scope="row">{{$i++}}</td>
            <td scope="row">
                <div class="dropdown show">
                    <a class="btn btn-primary btn-xs dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a href="{{ route('categories.show', $category->id) }}" class="dropdown-item"><i class="fa fa-eye"></i> View</a>
                        <a href="{{ route('categories.edit', $category->id) }}" class="dropdown-item"><i class="fa fa-edit"></i> Edit</a>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="dropdown-item"><i class="fa fa-trash"></i> Delete</button>
                        </form>
                    </div>
                </div>
            </td>
            <td>{{$category->name}}</td>
            <td>
                <input type="checkbox" name="toogle" data-url="{{route('category.active')}}" value="{{$category->id}}" data-toggle="toggle" data-size="sm" {{$category->active==1 ? 'checked' : '' }} data-on="On"  data-off="Off" data-onstyle="success" data-offstyle="danger">
            </td>

        </tr>
    @empty
        <tr>
            <td colspan="4" class="text-danger h5 text-center">No Category Found</td>
        </tr>
    @endforelse
    </tbody>
</table>

{{ $categories->render() }}
