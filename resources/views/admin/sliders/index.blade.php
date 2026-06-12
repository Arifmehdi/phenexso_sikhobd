@extends('admin.master')
@section('title',"Admin Dashboard | Front Sliders")

@section('body')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Slider Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Sliders</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="card card-outline card-primary shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-plus-circle mr-1"></i> Add New Slider</h3>
                    </div>

                    <div class="card-body">
                        <form action="{{route('sliders.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" id="title" placeholder="Enter title" class="form-control" value="{{ old('title') }}">
                                @error('title')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" cols="30" rows="3" class="form-control" placeholder="Enter short description">{{ old('description') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="link">Action Link (URL)</label>
                                <input type="text" name="link" id="link" class="form-control" placeholder="https://example.com/course" value="{{ old('link') }}">
                                @error('link')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="featured_image">Slider Image</label>
                                <div class="custom-file">
                                    <input type="file" name="featured_image" class="custom-file-input" id="featured_image">
                                    <label class="custom-file-label" for="featured_image">Choose file</label>
                                </div>
                                <small class="text-muted mt-2 d-block">
                                    <i class="fas fa-info-circle mr-1"></i> Recommended size: <strong>1000x750px</strong> (4:3 ratio) or <strong>1000x600px</strong>.
                                </small>
                                @error('featured_image')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="custom-control custom-switch mb-3">
                                <input type="checkbox" class="custom-control-input" id="activeSwitch" name="active" checked>
                                <label class="custom-control-label" for="activeSwitch">Active Status</label>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-save mr-1"></i> Save Slider
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card card-outline card-info shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-list mr-1"></i> Active Sliders</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th style="width: 50px">SL</th>
                                        <th>Preview</th>
                                        <th>Content</th>
                                        <th>Status</th>
                                        <th style="width: 120px" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = (($sliders->currentPage() - 1) * $sliders->perPage() + 1); @endphp
                                    @forelse($sliders as $slider)
                                    <tr>
                                        <td class="align-middle text-center">{{ $i++ }}</td>
                                        <td class="align-middle">
                                            <div class="img-thumbnail" style="width: 100px; height: 60px; overflow: hidden;">
                                                <img src="{{ route('imagecache', [ 'template'=>'sbixs','filename' => $slider->fi() ]) }}" 
                                                     alt="Slider" style="width: 100%; height: 100%; object-fit: cover;">
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <div class="font-weight-bold text-dark">{{ $slider->title ?? 'No Title' }}</div>
                                            <div class="small text-muted text-truncate" style="max-width: 250px;">{{ $slider->description }}</div>
                                            @if($slider->link)
                                                <a href="{{ $slider->link }}" target="_blank" class="text-xs text-primary">
                                                    <i class="fas fa-link mr-1"></i>{{ Str::limit($slider->link, 30) }}
                                                </a>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            @if ($slider->active)
                                                <span class="badge badge-success shadow-sm">Active</span>
                                            @else
                                                <span class="badge badge-secondary shadow-sm">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="btn-group btn-group-sm">
                                                <a href="#" class="btn btn-info" data-toggle="modal" data-target="#fsedit{{$slider->id}}" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{route('sliders.destroy', $slider) }}" method="post" class="d-inline">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Delete this slider permanently?')" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- Edit Modal --}}
                                    <div class="modal fade" id="fsedit{{$slider->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                          <div class="modal-content">
                                            <div class="modal-header bg-info text-white">
                                              <h5 class="modal-title"><i class="fas fa-edit mr-2"></i>Edit Slider</h5>
                                              <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <form action="{{route('sliders.update',$slider->id)}}" method="POST" enctype="multipart/form-data">
                                                @method('PATCH')
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="edit_title{{$slider->id}}">Title</label>
                                                        <input type="text" name="title" id="edit_title{{$slider->id}}" class="form-control" value="{{ $slider->title }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="edit_desc{{$slider->id}}">Description</label>
                                                        <textarea name="description" id="edit_desc{{$slider->id}}" cols="30" rows="3" class="form-control">{{ $slider->description }}</textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="edit_link{{$slider->id}}">Link</label>
                                                        <input type="text" name="link" id="edit_link{{$slider->id}}" class="form-control" value="{{ $slider->link }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Current Image</label>
                                                        <div class="mb-2">
                                                            <img src="{{ route('imagecache', [ 'template'=>'sbism','filename' => $slider->fi() ]) }}" 
                                                                 class="img-fluid rounded border shadow-sm" style="max-height: 150px;">
                                                        </div>
                                                        <label for="edit_image{{$slider->id}}">Change Image</label>
                                                        <div class="custom-file">
                                                            <input type="file" name="featured_image" class="custom-file-input" id="edit_image{{$slider->id}}">
                                                            <label class="custom-file-label">Choose new image</label>
                                                        </div>
                                                    </div>
                                                    <div class="custom-control custom-switch mt-3">
                                                        <input type="checkbox" class="custom-control-input" id="editActive{{$slider->id}}" name="active" {{$slider->active? 'checked' : ''}}>
                                                        <label class="custom-control-label" for="editActive{{$slider->id}}">Active</label>
                                                    </div>
                                                </div>
                                                <div class="modal-footer bg-light">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-info px-4">Update Changes</button>
                                                </div>
                                            </form>
                                          </div>
                                        </div>
                                    </div>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" style="width: 80px; opacity: 0.3;">
                                            <p class="text-muted mt-3">No sliders found. Add your first slider to get started!</p>
                                        </td>
                                    </tr>
                                   @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if($sliders->hasPages())
                    <div class="card-footer clearfix bg-white">
                        {{ $sliders->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('js')
<script>
    // Show selected filename in custom-file-input
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
</script>
@endpush




