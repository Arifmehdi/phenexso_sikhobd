<table class="table table-sm table-bordered table-striped">
    <thead>
        <tr>
            <th width="20">SL</th>
            <th width="100">Actions</th>
            <th>Title</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Questions</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @php $i = (($exams->currentPage() - 1) * $exams->perPage() + 1); @endphp
        @foreach($exams as $exam)
        <tr>
            <td>{{ $i++ }}</td>
            <td>
                <div class="dropdown show">
                    <a class="btn btn-primary btn-xs dropdown-toggle" href="#" role="button" id="dropdownMenuLink{{ $exam->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                    </a>

                    <div class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuLink{{ $exam->id }}">
                        <a class="dropdown-item" href="{{ route('admin.exams.edit', $exam->id) }}"><i class="fas fa-edit"></i> Edit</a>
                        <a class="dropdown-item" href="{{ route('admin.exams.select-questions', $exam->id) }}"><i class="fas fa-list"></i> Manage Questions</a>
                        
                        @if($exam->status == 'published')
                        <div class="dropdown-divider"></div>
                        <form action="{{ route('admin.exams.finish', $exam->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-success" onclick="return confirm('Finish this exam and show results to students?')"><i class="fas fa-flag-checkered"></i> Finish & Results</button>
                        </form>
                        @endif

                        <a class="dropdown-item" href="{{ route('admin.exams.results', $exam->id) }}"><i class="fas fa-poll"></i> View Results</a>
                        
                        <div class="dropdown-divider"></div>
                        <form action="{{ route('admin.exams.destroy', $exam->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="dropdown-item text-danger"><i class="fas fa-trash"></i> Delete</button>
                        </form>
                    </div>
                </div>
            </td>
            <td>{{ $exam->title }}</td>
            <td>{{ $exam->start_time->format('d M Y, h:i A') }}</td>
            <td>{{ $exam->end_time->format('d M Y, h:i A') }}</td>
            <td>{{ $exam->questions->count() }} / {{ $exam->question_count }}</td>
            <td>
                <span class="badge badge-{{ $exam->status == 'published' ? 'success' : ($exam->status == 'finished' ? 'secondary' : 'warning') }}">
                    {{ ucfirst($exam->status) }}
                </span>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="px-2">
    {{ $exams->links() }}
</div>
