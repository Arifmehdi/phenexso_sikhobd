@extends('website.layouts.sikhobd')

@section('title', 'Exam Results — ' . $exam->title)

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card shadow-lg border-0" style="border-radius: 15px;">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center" style="border-radius: 15px 15px 0 0;">
                    <h3 class="card-title mb-0">Results: {{ $exam->title }}</h3>
                    <a href="{{ route('user.dashboard') }}#tab-teacher-exams" class="btn btn-sm btn-light">Back to List</a>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4 mb-4">
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded-3 text-center">
                                <h6 class="text-muted mb-1">Total Attendees</h6>
                                <h3 class="mb-0">{{ $attempts->count() }}</h3>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded-3 text-center">
                                <h6 class="text-muted mb-1">Average Score</h6>
                                <h3 class="mb-0">{{ $attempts->avg('score') ? round($attempts->avg('score'), 1) : 0 }} / {{ $exam->question_count }}</h3>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded-3 text-center">
                                <h6 class="text-muted mb-1">Highest Score</h6>
                                <h3 class="mb-0 text-success">{{ $attempts->max('score') ?? 0 }} / {{ $exam->question_count }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Rank</th>
                                    <th>Student Name</th>
                                    <th>Score</th>
                                    <th>Percentage</th>
                                    <th>Completed At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $rank = 1; @endphp
                                @forelse($attempts as $attempt)
                                <tr>
                                    <td><strong>#{{ $rank++ }}</strong></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="{{ $attempt->user->image ? asset('storage/users/'.$attempt->user->image) : 'https://cdn-icons-png.flaticon.com/512/3177/3177440.png' }}" class="rounded-circle" width="32" height="32" style="object-fit: cover;">
                                            <div>
                                                <div class="fw-bold">{{ $attempt->user->name }}</div>
                                                <small class="text-muted">{{ $attempt->user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $attempt->score }} / {{ $exam->question_count }}</td>
                                    <td>
                                        @php $percent = round(($attempt->score / $exam->question_count) * 100); @endphp
                                        <div class="progress" style="height: 8px; width: 100px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percent }}%"></div>
                                        </div>
                                        <small>{{ $percent }}%</small>
                                    </td>
                                    <td>{{ $attempt->end_time->format('M d, Y h:i A') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">No attempts recorded yet.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
