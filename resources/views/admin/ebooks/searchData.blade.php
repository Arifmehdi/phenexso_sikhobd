<table class="table table-striped table-bordered table-hover table-md">
    <thead class="w3-small text-muted thead-light">
        <tr>
            <th scope="col" width="30">SL</th>
            <th scope="col" width="60">Action</th>
            <th scope="col">Ebook Title</th>
            <th scope="col">Author</th>
            <th scope="col">Category</th>
            <th scope="col">Price</th>
            <th scope="col">Status</th>
            <th scope="col">Approval</th>
            <th scope="col">Active</th>
        </tr>
    </thead>
    <tbody class="">
        <?php $i = (($ebooks->currentPage() - 1) * $ebooks->perPage() + 1); ?>
        @forelse ($ebooks as $ebook)
            <tr>
                <td>{{ $i++ }}</td>
                <td>
                    <div class="dropdown show">
                        <a class="btn btn-primary btn-xs dropdown-toggle" href="#" role="button" id="dropdownMenuLink{{ $ebook->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink{{ $ebook->id }}">
                            <a href="{{ route('admin.ebooks.edit', $ebook->id) }}" class="dropdown-item"><i class="fa fa-edit"></i> Edit</a>
                            <form action="{{ route('admin.ebooks.destroy', $ebook->id) }}" method="post" onclick="return confirm('Are you sure to delete?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="dropdown-item"><i class="fa fa-trash"></i> Delete</button>
                            </form>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('storage/ebook_covers/' . $ebook->cover_image) }}" width="40" height="60" class="mr-2 shadow-sm" style="object-fit: cover;">
                        <div>
                            <div class="font-weight-bold">{{ Str::limit($ebook->title_en, 40) }}</div>
                            <small class="text-muted">{{ Str::limit($ebook->title_bn, 40) }}</small>
                        </div>
                    </div>
                </td>
                <td>{{ $ebook->author_name }}</td>
                <td>
                    <span class="badge badge-info">{{ optional($ebook->category)->name_en }}</span>
                </td>
                <td>৳{{ number_format($ebook->price, 2) }}</td>
                <td>
                    <span class="badge badge-{{ $ebook->status == 'approved' ? 'success' : ($ebook->status == 'pending' ? 'warning' : 'danger') }}">
                        {{ ucfirst($ebook->status) }}
                    </span>
                </td>
                <td>
                    {{-- Status Toggle similar to product --}}
                    <button class="badge border-0 badge-{{ $ebook->status == 'approved' ? 'primary' : 'danger' }} ebookStatus"
                        data-id="{{ $ebook->id }}">
                        {{ $ebook->status == 'approved' ? 'Approved' : 'Pending' }}
                    </button>
                </td>
                <td>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input active-status" id="activeSwitch{{ $ebook->id }}" data-id="{{ $ebook->id }}" {{ $ebook->active ? 'checked' : '' }}>
                        <label class="custom-control-label" for="activeSwitch{{ $ebook->id }}"></label>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="text-danger h5 text-center">No Ebook Found</td>
            </tr>
        @endforelse
    </tbody>
</table>
