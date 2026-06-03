@extends('admin.master')

@section('title')
   Admin Dashboard | Exams
@endsection

@section('body')
<section class="content py-3">
    <div class="row">
        <div class="col-md-11 mx-auto">
            <div class="card mb-2 shadow-lg">
                <div class="card-header px-2 py-2">
                    <h3 class="card-title w3-small text-bold text-muted pt-1">
                        <i class="fas fa-file-alt text-primary"></i> Exams
                    </h3>
                    <div class="card-tools w3-small">
                        <a href="{{ route('admin.exams.create') }}" 
                           class="btn btn-outline-primary btn-xs pull-right mr-2 py-1">
                            <i class="fas fa-plus-square"></i> Create New Exam
                        </a>
                    </div>
                </div>
            </div>

            <div class="card w3-round shadow-lg">
                <div class="card-body bg-light px-0 pb-0 pt-2">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Questions</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($exams as $exam)
                                <tr>
                                    <td>{{ $exam->title }}</td>
                                    <td>{{ $exam->start_time }}</td>
                                    <td>{{ $exam->end_time }}</td>
                                    <td>{{ $exam->questions->count() }} / {{ $exam->question_count }}</td>
                                    <td>
                                        <span class="badge badge-{{ $exam->status == 'published' ? 'success' : ($exam->status == 'finished' ? 'secondary' : 'warning') }}">
                                            {{ ucfirst($exam->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.exams.edit', $exam->id) }}" class="btn btn-xs btn-info" title="Edit"><i class="fas fa-edit"></i></a>
                                        <a href="{{ route('admin.exams.select-questions', $exam->id) }}" class="btn btn-xs btn-warning" title="Manage Questions"><i class="fas fa-list"></i></a>
                                        @if($exam->status == 'published')
                                        <form action="{{ route('admin.exams.finish', $exam->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            <button type="submit" class="btn btn-xs btn-success" title="Finish & Declare Results" onclick="return confirm('Finish this exam and show results to students?')"><i class="fas fa-flag-checkered"></i></button>
                                        </form>
                                        @endif
                                        <a href="{{ route('admin.exams.results', $exam->id) }}" class="btn btn-xs btn-primary" title="View Results"><i class="fas fa-poll"></i></a>
                                        <form action="{{ route('admin.exams.destroy', $exam->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="px-2">
                        {{ $exams->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
