<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\ExamAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ExamController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $user = Auth::user();
        $user_id = Auth::id();

        $query = Exam::where('status', '!=', 'draft');

        // If not admin, restrict to exams visible to this student (assigned directly,
        // enrolled in an assigned course, or fully public). The view shows the state
        // (available / upcoming / expired / attended) so users understand easily.
        if (!$user || (!$user->hasRole('admin') && $user->role !== 'admin')) {
            $query->visibleToStudent($user_id ?? 0);
        }

        $exams = $query->latest()->paginate(10);

        $completed_exams = $user_id ? ExamAttempt::where('user_id', $user_id)
            ->where('status', 'completed')
            ->with('exam')
            ->get() : collect();

        return view('frontend.exams.index', compact('exams', 'completed_exams'));
    }

    public function start(Exam $exam)
    {
        // Eligibility: only assigned / enrolled-course / public exams (admins exempt)
        $user = Auth::user();
        $isAdmin = $user && ($user->hasRole('admin') || $user->role === 'admin');
        if (!$isAdmin) {
            $eligible = Exam::where('id', $exam->id)->visibleToStudent($user->id)->exists();
            if (!$eligible) {
                return redirect()->route('exams.index')->with('error', 'You are not eligible to take this exam.');
            }
        }

        $now = Carbon::now();
        if ($now->lt($exam->start_time) || $now->gt($exam->end_time)) {
            return redirect()->route('exams.index')->with('error', 'Exam is not available at this time.');
        }

        $existing_attempt = ExamAttempt::where('exam_id', $exam->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existing_attempt && $existing_attempt->status == 'completed') {
            return redirect()->route('exams.result', $exam->id);
        }

        if (!$existing_attempt) {
            $existing_attempt = ExamAttempt::create([
                'exam_id' => $exam->id,
                'user_id' => Auth::id(),
                'start_time' => $now,
                'status' => 'started'
            ]);
        }

        $questions = $exam->questions;

        return view('frontend.exams.start', compact('exam', 'questions', 'existing_attempt'));
    }

    public function submit(Request $request, Exam $exam)
    {
        $attempt = ExamAttempt::where('exam_id', $exam->id)
            ->where('user_id', Auth::id())
            ->where('status', 'started')
            ->firstOrFail();

        $answers = $request->input('answers', []);
        $score = 0;

        foreach ($exam->questions as $question) {
            $selected_option = $answers[$question->id] ?? null;
            $is_correct = ($selected_option == $question->correct_option);
            
            if ($is_correct) {
                $score++;
            }

            ExamAnswer::create([
                'exam_attempt_id' => $attempt->id,
                'question_id' => $question->id,
                'selected_option' => $selected_option,
                'is_correct' => $is_correct
            ]);
        }

        $attempt->update([
            'end_time' => Carbon::now(),
            'score' => $score,
            'status' => 'completed'
        ]);

        return redirect()->route('exams.index')->with('success', 'Exam submitted successfully. Results will be available once the admin finishes the exam.');
    }

    public function result(Exam $exam)
    {
        $attempt = ExamAttempt::where('exam_id', $exam->id)
            ->where('user_id', Auth::id())
            ->where('status', 'completed')
            ->with('answers.question')
            ->firstOrFail();

        if ($exam->status != 'finished') {
             return view('frontend.exams.pending_result', compact('exam', 'attempt'));
        }

        return view('frontend.exams.result', compact('exam', 'attempt'));
    }
}
