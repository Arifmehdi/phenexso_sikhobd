<table class="table table-striped table-bordered table-hover table-md">
    <thead class="w3-small text-muted thead-light">
    <tr>
        <th scope="col" width="30">SL</th>
        <th scope="col" width="60">Action</th>
        <th scope="col">Title</th>
        <th scope="col">Image</th>
        <th scope="col">Active</th>
        <th scope="col">Status</th>
    </tr>
    </thead>
    <tbody>
        <?php $i = (($newses->currentPage() - 1) * $newses->perPage() + 1); ?>
    @forelse($newses as $news)
        <tr>
            <td scope="row">{{$i++}}</td>
            <td scope="row">
                <div class="dropdown show">
                    <a class="btn btn-primary btn-xs dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a href="{{ route('news.show', $news->id) }}" class="dropdown-item"><i class="fa fa-eye"></i> View</a>
                        <a href="{{ route('news.edit', $news->id) }}" class="dropdown-item"><i class="fa fa-edit"></i> Edit</a>
                        <form action="{{ route('news.destroy', $news->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="dropdown-item"><i class="fa fa-trash"></i> Delete</button>
                        </form>
                    </div>
                </div>
            </td>
            <td>{{$news->title}}</td>
            <td>
                <img  src="{{ route('imagecache', ['template' => 'ppsm', 'filename' => $news->fi()]) }}" alt="post">
            </td>
            <td>
                <input type="checkbox" name="toogle" data-url="{{route('news.active')}}" value="{{$news->id}}" data-toggle="toggle" data-size="sm" {{$news->active==1 ? 'checked' : '' }} data-on="On"  data-off="Off" data-onstyle="success" data-offstyle="danger">
            </td>
            <td>{{$news->status}}</td>

        </tr>
    @empty
        <tr>
            <td colspan="6" class="text-danger h5 text-center">No News Found</td>
        </tr>
    @endforelse
    </tbody>
</table>
{{ $newses->render() }}
