<table class="table table-sm table-bordered table-striped">
    <thead>
        <tr>
            <th width="20">SL</th>
            <th width="100">Action</th>
            <th>Question</th>
            <th>Correct Option</th>
        </tr>
    </thead>
    <tbody>
        @php $i = (($questions->currentPage() - 1) * $questions->perPage() + 1); @endphp
        @foreach($questions as $question)
        <tr>
            <td>{{ $i++ }}</td>
            <td>
                <div class="dropdown show">
                    <a class="btn btn-primary btn-xs dropdown-toggle" href="#" role="button" id="dropdownMenuLink{{ $question->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                    </a>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink{{ $question->id }}">
                        <a class="dropdown-item" href="{{ route('admin.questions.edit', $question->id) }}"><i class="fas fa-edit"></i> Edit</a>
                        <form action="{{ route('admin.questions.destroy', $question->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="dropdown-item text-danger"><i class="fa fa-trash"></i> Delete</button>
                        </form>
                    </div>
                </div>
            </td>
            <td>{{ Str::limit($question->question_text, 100) }}</td>
            <td><span class="badge badge-success">{{ strtoupper($question->correct_option) }}</span></td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="px-2">
    {{ $questions->links() }}
</div>
