@extends('admin.master')

@section('title', 'Admin Dashboard | Manage classes')

@section('body')
<section class="content py-3">
    <div class="row">
        <div class="col-md-12 mx-auto">
            <div class="card mb-2 shadow-lg">
                <div class="card-header px-2 py-2">
                    <h3 class="card-title text-muted text-bold">
                        <i class="fas fa-graduation-cap text-primary"></i> Classes for: {{ $product->name_en }}
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.productsAll') }}" class="btn btn-outline-primary btn-xs mr-2"><i class="fa fa-arrow-left"></i> Back</a>
                        <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#addLessonModal">
                            <i class="fas fa-plus"></i> Add New Class
                        </button>
                    </div>
                </div>
            </div>

            <div class="card shadow-lg">
                <div class="card-body p-0">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th width="50">Pos</th>
                                <th>Class Title</th>
                                <th>Video URL</th>
                                <th>Duration</th>
                                <th>Free</th>
                                <th>Active</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($lessons as $lesson)
                            <tr>
                                <td>{{ $lesson->priority }}</td>
                                <td>
                                    <strong>{{ $lesson->title_en }}</strong><br>
                                    <small>{{ $lesson->title_bn }}</small>
                                </td>
                                <td>
                                    @if($lesson->video_url)
                                    <a href="{{ $lesson->video_url }}" target="_blank" class="text-primary"><i class="fab fa-youtube"></i> View Link</a>
                                    @else
                                    <span class="text-muted">No Link</span>
                                    @endif
                                </td>
                                <td>{{ $lesson->duration }}</td>
                                <td>{!! $lesson->is_free ? '<span class="badge badge-success">Yes</span>' : '<span class="badge badge-secondary">No</span>' !!}</td>
                                <td>{!! $lesson->active ? '<span class="badge badge-primary">Active</span>' : '<span class="badge badge-danger">Inactive</span>' !!}</td>
                                <td class="text-right">
                                    <button class="btn btn-xs btn-outline-info edit-lesson" data-lesson="{{ json_encode($lesson) }}" data-toggle="modal" data-target="#editLessonModal">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <a href="{{ route('admin.lessons.destroy', $lesson->id) }}" class="btn btn-xs btn-outline-danger" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">No classes added yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Add Lesson Modal -->
<div class="modal fade" id="addLessonModal" tabindex="-1" role="dialog" aria-labelledby="addLessonModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('admin.lessons.store', $product->id) }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addLessonModalLabel">Add New Class</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Title (English)</label>
                        <input type="text" name="title_en" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Title (Bengali)</label>
                        <input type="text" name="title_bn" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Video Provider</label>
                        <select name="video_provider" class="form-control">
                            <option value="youtube">YouTube</option>
                            <option value="vimeo">Vimeo</option>
                            <option value="custom">Custom/Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Video URL</label>
                        <input type="url" name="video_url" class="form-control" placeholder="https://www.youtube.com/watch?v=...">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Duration</label>
                                <input type="text" name="duration" class="form-control" placeholder="15:30">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Priority (Position)</label>
                                <input type="number" name="priority" class="form-control" value="{{ $lessons->count() + 1 }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-check mb-2">
                        <input type="checkbox" name="is_free" class="form-check-input" id="is_free">
                        <label class="form-check-label" for="is_free">Free Preview?</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="active" class="form-check-input" id="active" checked>
                        <label class="form-check-label" for="active">Active?</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Class</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Edit Lesson Modal -->
<div class="modal fade" id="editLessonModal" tabindex="-1" role="dialog" aria-labelledby="editLessonModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="editLessonForm" action="" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Class</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Title (English)</label>
                        <input type="text" name="title_en" id="edit_title_en" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Title (Bengali)</label>
                        <input type="text" name="title_bn" id="edit_title_bn" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Video Provider</label>
                        <select name="video_provider" id="edit_video_provider" class="form-control">
                            <option value="youtube">YouTube</option>
                            <option value="vimeo">Vimeo</option>
                            <option value="custom">Custom/Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Video URL</label>
                        <input type="url" name="video_url" id="edit_video_url" class="form-control">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Duration</label>
                                <input type="text" name="duration" id="edit_duration" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Priority (Position)</label>
                                <input type="number" name="priority" id="edit_priority" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-check mb-2">
                        <input type="checkbox" name="is_free" class="form-check-input" id="edit_is_free">
                        <label class="form-check-label" for="edit_is_free">Free Preview?</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="active" class="form-check-input" id="edit_active">
                        <label class="form-check-label" for="edit_active">Active?</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Class</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
<script>
    $('.edit-lesson').click(function() {
        const lesson = $(this).data('lesson');
        const url = "{{ url('admin/lessons') }}/" + lesson.id + "/update";
        
        $('#editLessonForm').attr('action', url);
        $('#edit_title_en').val(lesson.title_en);
        $('#edit_title_bn').val(lesson.title_bn);
        $('#edit_video_provider').val(lesson.video_provider);
        $('#edit_video_url').val(lesson.video_url);
        $('#edit_duration').val(lesson.duration);
        $('#edit_priority').val(lesson.priority);
        $('#edit_is_free').prop('checked', !!lesson.is_free);
        $('#edit_active').prop('checked', !!lesson.active);
    });
</script>
@endpush
