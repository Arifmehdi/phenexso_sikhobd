<table class="table table-striped table-bordered table-hover table-md mb-0">
    <thead class="w3-small text-muted thead-light">
        <tr>
            <th width="30">Pos</th>
            <th width="60">Action</th>
            <th>Category Name</th>
            <th width="100">Type</th>
            <th width="80">Image</th>
            <th width="80">Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($categories as $category)
            {{-- 🔹 Level 1: Parent Category --}}
            <tr class="bg-white parent-row cursor-pointer" data-id="{{ $category->id }}" data-toggle="collapse" data-target=".child-of-{{ $category->id }}">
                <td class="text-center font-weight-bold">{{ $category->position }}</td>
                <td>
                    <div class="dropdown">
                        <a class="btn btn-primary btn-xs dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                            Action
                        </a>
                        <div class="dropdown-menu">
                            <a href="{{ route('admin.productCategoryEdit', $category) }}" class="dropdown-item"><i class="fa fa-edit"></i> Edit</a>
                            <form action="{{ route('admin.productCategoryDelete', $category) }}" method="post" onsubmit="return confirm('Delete this category and all sub-items?')">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger"><i class="fa fa-trash"></i> Delete</button>
                            </form>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        @if($category->children->count() > 0)
                            <i class="fas fa-chevron-right mr-2 text-primary transition-transform toggle-icon-{{ $category->id }}"></i>
                        @endif
                        <strong>{{ $category->name_en }}</strong>
                        <span class="badge badge-pill badge-light ml-2 border">{{ $category->children->count() }} Sub</span>
                    </div>
                </td>
                <td><span class="badge {{ $category->type == 'course' ? 'badge-info' : 'badge-warning' }}">{{ strtoupper($category->type) }}</span></td>
                <td class="text-center">
                    <img width="30" height="20" src="{{ route('imagecache', ['template' => 'sbixs', 'filename' => $category->fi()]) }}" class="rounded shadow-sm">
                </td>
                <td class="text-center">
                    <button class="badge border-0 {{ $category->active ? 'badge-primary' : 'badge-danger' }} categoryStatus"
                        data-url="{{ route('admin.categoryStatus', ['category' => $category->id]) }}">
                        {{ $category->active ? 'Active' : 'Inactive' }}
                    </button>
                </td>
            </tr>

            {{-- 🔸 Level 2: Subcategories --}}
            @foreach ($category->children->sortBy('position') as $child)
                <tr class="collapse child-of-{{ $category->id }} bg-light" data-id="{{ $child->id }}" data-toggle="collapse" data-target=".grandchild-of-{{ $child->id }}">
                    <td class="text-center">{{ $child->position }}</td>
                    <td>
                        <div class="dropdown">
                            <a class="btn btn-secondary btn-xs dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                Action
                            </a>
                            <div class="dropdown-menu">
                                <a href="{{ route('admin.productCategoryEdit', $child) }}" class="dropdown-item"><i class="fa fa-edit"></i> Edit</a>
                                <form action="{{ route('admin.productCategoryDelete', $child) }}" method="post" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger"><i class="fa fa-trash"></i> Delete</button>
                                </form>
                            </div>
                        </div>
                    </td>
                    <td class="pl-4">
                        <div class="d-flex align-items-center">
                            @if($child->children->count() > 0)
                                <i class="fas fa-chevron-right mr-2 text-secondary toggle-icon-{{ $child->id }}"></i>
                            @else
                                <i class="fas fa-level-up-alt fa-rotate-90 mr-2 text-muted"></i>
                            @endif
                            {{ $child->name_en }}
                            @if($child->children->count() > 0)
                                <span class="badge badge-pill badge-light ml-2 border">{{ $child->children->count() }} Child</span>
                            @endif
                        </div>
                    </td>
                    <td><small class="text-muted">{{ strtoupper($child->type) }}</small></td>
                    <td class="text-center">
                        <img width="25" height="15" src="{{ route('imagecache', ['template' => 'sbixs', 'filename' => $child->fi()]) }}" class="rounded shadow-sm">
                    </td>
                    <td class="text-center">
                        <button class="badge border-0 {{ $child->active ? 'badge-primary' : 'badge-danger' }} categoryStatus"
                            data-url="{{ route('admin.categoryStatus', ['category' => $child->id]) }}">
                            {{ $child->active ? 'Active' : 'Inactive' }}
                        </button>
                    </td>
                </tr>

                {{-- 🔹 Level 3: Child Categories (Grandchildren) --}}
                @foreach ($child->children->sortBy('position') as $grandchild)
                    <tr class="collapse grandchild-of-{{ $child->id }} bg-white">
                        <td class="text-center text-muted"><small>{{ $grandchild->position }}</small></td>
                        <td>
                            <div class="dropdown">
                                <a class="btn btn-outline-secondary btn-xs dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                    Action
                                </a>
                                <div class="dropdown-menu">
                                    <a href="{{ route('admin.productCategoryEdit', $grandchild) }}" class="dropdown-item px-2"><i class="fa fa-edit text-info"></i> Edit</a>
                                    <form action="{{ route('admin.productCategoryDelete', $grandchild) }}" method="post" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        <button type="submit" class="dropdown-item px-2 text-danger"><i class="fa fa-trash"></i> Delete</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                        <td class="pl-5">
                            <small class="text-muted"><i class="fas fa-level-up-alt fa-rotate-90 mr-1"></i></small>
                            <span class="text-secondary">{{ $grandchild->name_en }}</span>
                        </td>
                        <td><small class="text-muted">{{ strtoupper($grandchild->type) }}</small></td>
                        <td class="text-center">
                            <img width="20" height="12" src="{{ route('imagecache', ['template' => 'sbixs', 'filename' => $grandchild->fi()]) }}" class="rounded">
                        </td>
                        <td class="text-center">
                            <button class="badge border-0 {{ $grandchild->active ? 'badge-primary' : 'badge-danger' }} categoryStatus"
                                data-url="{{ route('admin.categoryStatus', ['category' => $grandchild->id]) }}">
                                {{ $grandchild->active ? 'Active' : 'Inactive' }}
                            </button>
                        </td>
                    </tr>
                @endforeach
            @endforeach

        @empty
            <tr>
                <td colspan="6" class="text-danger h6 text-center py-4">No Category Found</td>
            </tr>
        @endforelse
    </tbody>
</table>

<style>
    .parent-row:hover { background-color: rgba(0,0,0,.02) !important; }
    .cursor-pointer { cursor: pointer; }
    .transition-transform { transition: transform 0.2s; }
    tr:not(.collapse).show .toggle-icon-{{ $category->id ?? '' }} { transform: rotate(90deg); }
    .pl-4 { padding-left: 2.5rem !important; }
    .pl-5 { padding-left: 4.5rem !important; }
</style>

<script>
    $('.parent-row').on('click', function() {
        $(this).find('.fas.fa-chevron-right').toggleClass('fa-rotate-90');
    });
    $('[data-toggle="collapse"]').on('click', function(e) {
        if ($(e.target).closest('.dropdown, .categoryStatus').length) {
            e.stopPropagation();
        }
    });
</script>
