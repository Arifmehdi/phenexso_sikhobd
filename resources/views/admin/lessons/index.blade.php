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
                        <a href="{{ route('admin.coursesAll') }}" class="btn btn-outline-primary btn-xs mr-2"><i class="fa fa-arrow-left"></i> Back</a>
                        <button type="button" class="btn btn-info btn-xs mr-1" data-toggle="modal" data-target="#addSectionModal">
                            <i class="fas fa-folder-plus"></i> Add Section
                        </button>
                        <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#addLessonModal">
                            <i class="fas fa-plus"></i> Add New Class
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sections Management -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-light py-2">
                    <h5 class="card-title text-sm mb-0">Course Chapters / Sections</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm table-hover mb-0">
                        <thead>
                            <tr>
                                <th width="50">Pos</th>
                                <th>Section Title</th>
                                <th>Classes</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($product->sections as $section)
                            <tr>
                                <td>{{ $section->priority }}</td>
                                <td>
                                    <strong>{{ $section->title_en }}</strong> / {{ $section->title_bn }}
                                </td>
                                <td><span class="badge badge-info">{{ $section->lessons->count() }}</span></td>
                                <td class="text-right">
                                    <button class="btn btn-xs btn-outline-info edit-section" data-section="{{ json_encode($section) }}" data-toggle="modal" data-target="#editSectionModal">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <a href="{{ route('admin.sections.destroy', $section->id) }}" class="btn btn-xs btn-outline-danger" onclick="return confirm('Are you sure? All classes in this section will be unassigned.')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-2 text-muted">No sections created yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
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
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('admin.lessons.store', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addLessonModalLabel">Add New Class</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Title (English)</label>
                                <input type="text" name="title_en" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Title (Bengali)</label>
                                <input type="text" name="title_bn" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Course Section (Chapter)</label>
                                <select name="course_section_id" class="form-control">
                                    <option value="">No Section</option>
                                    @foreach($product->sections as $section)
                                        <option value="{{ $section->id }}">{{ $section->title_en }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Priority (Position)</label>
                                <input type="number" name="priority" class="form-control" value="{{ $lessons->count() + 1 }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Lesson Tutorial / Description</label>
                        <textarea name="description" class="form-control" rows="4" placeholder="Write lesson instructions or tutorial content here..."></textarea>
                    </div>

                    <hr>
                    <h6 class="text-bold text-primary">Media & Resources</h6>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Video Provider</label>
                                <select name="video_provider" class="form-control">
                                    <option value="youtube">YouTube</option>
                                    <option value="vimeo">Vimeo</option>
                                    <option value="custom">Custom/Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Video URL (YouTube/Vimeo)</label>
                                <input type="url" name="video_url" class="form-control" placeholder="https://www.youtube.com/watch?v=...">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Upload local Video (MP4)</label>
                                <input type="file" name="video_file" class="form-control-file upload-input" accept="video/mp4">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Duration</label>
                                <input type="text" name="duration" class="form-control" placeholder="15:30">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Upload Audio (MP3)</label>
                                <input type="file" name="audio_file" class="form-control-file upload-input" accept="audio/*">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Upload PDF Material</label>
                                <input type="file" name="pdf_file" class="form-control-file upload-input" accept="application/pdf">
                            </div>
                        </div>
                    </div>

                    <div class="progress mb-3 d-none" id="upload-progress-container">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;" id="upload-progress-bar">0%</div>
                    </div>
                    <div id="upload-status" class="small text-muted mb-2"></div>

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

<!-- Add Section Modal -->
<div class="modal fade" id="addSectionModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('admin.sections.store', $product->id) }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Section (Chapter)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Section Title (English)</label>
                        <input type="text" name="title_en" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Section Title (Bengali)</label>
                        <input type="text" name="title_bn" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Priority (Position)</label>
                        <input type="number" name="priority" class="form-control" value="{{ $product->sections->count() + 1 }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Section</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Edit Section Modal -->
<div class="modal fade" id="editSectionModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="editSectionForm" action="" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Section</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Section Title (English)</label>
                        <input type="text" name="title_en" id="edit_section_title_en" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Section Title (Bengali)</label>
                        <input type="text" name="title_bn" id="edit_section_title_bn" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Priority (Position)</label>
                        <input type="number" name="priority" id="edit_section_priority" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Section</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Add Lesson Modal -->

<div class="modal fade" id="editLessonModal" tabindex="-1" role="dialog" aria-labelledby="editLessonModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form id="editLessonForm" action="" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Class</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Title (English)</label>
                                <input type="text" name="title_en" id="edit_title_en" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Title (Bengali)</label>
                                <input type="text" name="title_bn" id="edit_title_bn" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Course Section (Chapter)</label>
                                <select name="course_section_id" id="edit_course_section_id" class="form-control">
                                    <option value="">No Section</option>
                                    @foreach($product->sections as $section)
                                        <option value="{{ $section->id }}">{{ $section->title_en }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Priority (Position)</label>
                                <input type="number" name="priority" id="edit_priority" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Lesson Tutorial / Description</label>
                        <textarea name="description" id="edit_description" class="form-control" rows="4"></textarea>
                    </div>

                    <hr>
                    <h6 class="text-bold text-primary">Media & Resources</h6>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Video Provider</label>
                                <select name="video_provider" id="edit_video_provider" class="form-control">
                                    <option value="youtube">YouTube</option>
                                    <option value="vimeo">Vimeo</option>
                                    <option value="custom">Custom/Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Video URL (YouTube/Vimeo)</label>
                                <input type="url" name="video_url" id="edit_video_url" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Change local Video (MP4)</label>
                                <input type="file" name="video_file" class="form-control-file" accept="video/mp4">
                                <small id="current_video_file" class="text-muted"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Duration</label>
                                <input type="text" name="duration" id="edit_duration" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Change Audio (MP3)</label>
                                <input type="file" name="audio_file" class="form-control-file upload-input" accept="audio/*">
                                <small id="current_audio_file" class="text-muted"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Change PDF Material</label>
                                <input type="file" name="pdf_file" class="form-control-file upload-input" accept="application/pdf">
                                <small id="current_pdf_file" class="text-muted"></small>
                            </div>
                        </div>
                    </div>

                    <div class="progress mb-3 d-none" id="edit-upload-progress-container">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;" id="edit-upload-progress-bar">0%</div>
                    </div>
                    <div id="edit-upload-status" class="small text-muted mb-2"></div>

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
        $('#edit_course_section_id').val(lesson.course_section_id);
        $('#edit_description').val(lesson.description);
        $('#edit_video_provider').val(lesson.video_provider);
        $('#edit_video_url').val(lesson.video_url);
        $('#edit_duration').val(lesson.duration);
        $('#edit_priority').val(lesson.priority);
        $('#edit_is_free').prop('checked', !!lesson.is_free);
        $('#edit_active').prop('checked', !!lesson.active);

        // Show current filenames if exist
        $('#current_video_file').text(lesson.video_file ? 'Current: ' + lesson.video_file.split('/').pop() : '');
        $('#current_audio_file').text(lesson.audio_url ? 'Current: ' + lesson.audio_url.split('/').pop() : '');
        $('#current_pdf_file').text(lesson.pdf_url ? 'Current: ' + lesson.pdf_url.split('/').pop() : '');
    });

    $('.edit-section').click(function() {
        const section = $(this).data('section');
        const url = "{{ url('admin/sections') }}/" + section.id + "/update";
        
        $('#editSectionForm').attr('action', url);
        $('#edit_section_title_en').val(section.title_en);
        $('#edit_section_title_bn').val(section.title_bn);
        $('#edit_section_priority').val(section.priority);
    });

    // AJAX Form Submission with Progress
    function handleAjaxForm(formId, progressContainer, progressBar, statusId) {
        $(`#${formId}`).on('submit', function(e) {
            e.preventDefault();
            const form = $(this);
            const formData = new FormData(this);
            const submitBtn = form.find('button[type="submit"]');

            // Reset progress
            $(`#${progressContainer}`).removeClass('d-none');
            $(`#${progressBar}`).css('width', '0%').text('0%');
            $(`#${statusId}`).text('Uploading... Please wait.');
            submitBtn.prop('disabled', true);

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                xhr: function() {
                    const xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            const percentComplete = Math.round((evt.loaded / evt.total) * 100);
                            $(`#${progressBar}`).css('width', percentComplete + '%').text(percentComplete + '%');
                            if (percentComplete === 100) {
                                $(`#${statusId}`).text('Upload complete. Processing file on server...');
                            }
                        }
                    }, false);
                    return xhr;
                },
                success: function(response) {
                    $(`#${statusId}`).text('Success! Reloading...').addClass('text-success');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                },
                error: function(xhr) {
                    submitBtn.prop('disabled', false);
                    $(`#${progressContainer}`).addClass('d-none');
                    let errorMsg = 'An error occurred during upload.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    $(`#${statusId}`).text(errorMsg).addClass('text-danger');
                    alert(errorMsg);
                }
            });
        });
    }

    handleAjaxForm('addLessonModal form', 'upload-progress-container', 'upload-progress-bar', 'upload-status');
    handleAjaxForm('editLessonForm', 'edit-upload-progress-container', 'edit-upload-progress-bar', 'edit-upload-status');
</script>
@endpush
