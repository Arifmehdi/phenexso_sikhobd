@extends('admin.master')

@section('title')
   Admin Dashboard | Exam Results
@endsection

@section('body')
<section class="content py-3">
    <div class="row">
        <div class="col-md-11 mx-auto">
            <div class="card shadow-lg">
                <div class="card-header">
                    <h3 class="card-title">Results for Exam: {{ $exam->title }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.exams.index') }}" class="btn btn-sm btn-default">Back to Exams</a>
                    </div>
                </div>
                <div class="card-body bg-light">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th>Student Name</th>
                                    <th>Score</th>
                                    <th>Percentage</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($attempts as $index => $attempt)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $attempt->user->name }}</td>
                                    <td>{{ $attempt->score }} / {{ $exam->question_count }}</td>
                                    <td>{{ number_format(($attempt->score / $exam->question_count) * 100, 2) }}%</td>
                                    <td>{{ $attempt->start_time->format('M d, Y h:i A') }}</td>
                                    <td>{{ $attempt->end_time ? $attempt->end_time->format('M d, Y h:i A') : 'N/A' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No students have taken this exam yet.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
