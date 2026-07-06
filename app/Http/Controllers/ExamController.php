<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\ExamAnswer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ExamController extends Controller
{
    /**
     * Classes (lessons) of a course as JSON — used by the admin/teacher
     * question & exam forms to cascade Course → Class selects.
     */
    public function courseClasses(Product $product)
    {
        $classes = $product->sections()
            ->with(['lessons' => function ($q) {
                $q->where('active', 1);
            }])
            ->get()
            ->flatMap(function ($section) {
                return $section->lessons->map(function ($lesson) use ($section) {
                    return [
                        'id' => $lesson->id,
                        'title' => ($lesson->title_en ?: $lesson->title_bn),
                        'section' => ($section->title_en ?: $section->title_bn),
                    ];
                });
            })
            ->values();

        // Lessons that are not under any section
        $orphans = $product->lessons()
            ->whereNull('course_section_id')
            ->where('active', 1)
            ->orderBy('priority')
            ->get()
            ->map(function ($lesson) {
                return [
                    'id' => $lesson->id,
                    'title' => ($lesson->title_en ?: $lesson->title_bn),
                    'section' => null,
                ];
            });

        return response()->json(['classes' => $classes->concat($orphans)->values()]);
    }

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

        $exams = $query->with(['course', 'lesson'])->latest()->paginate(10);

        $completed_exams = $user_id ? ExamAttempt::where('user_id', $user_id)
            ->where('status', 'completed')
            ->with('exam')
            ->get() : collect();

        // Classes (lessons) this user has completed — used to lock class-bound exams
        $completed_lesson_ids = $user_id
            ? \App\Models\LessonCompletion::where('user_id', $user_id)->pluck('course_lesson_id')->all()
            : [];

        return view('frontend.exams.index', compact('exams', 'completed_exams', 'completed_lesson_ids'));
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

            // Class-bound exam: the student must finish that class first
            if (!$exam->isClassCompletedBy($user->id)) {
                $className = $exam->lesson ? ($exam->lesson->title_en ?: $exam->lesson->title_bn) : '';
                return redirect()->route('exams.index')->with('error', __('frontend.exams.complete_class_first', ['class' => $className]));
            }
        }

        // Exam is answerable only within its scheduled time window.
        if ($exam->status === 'finished') {
            return redirect()->route('exams.index')->with('error', 'This exam has been finished.');
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

        // Show the result to the student right after they submit
        return redirect()->route('exams.result', $exam->id)->with('success', 'Exam submitted successfully. Here is your result.');
    }

    public function result(Exam $exam)
    {
        $attempt = ExamAttempt::where('exam_id', $exam->id)
            ->where('user_id', Auth::id())
            ->where('status', 'completed')
            ->with('answers.question')
            ->firstOrFail();

        // Result is available to the student immediately after submitting.
        return view('frontend.exams.result', compact('exam', 'attempt'));
    }
}
