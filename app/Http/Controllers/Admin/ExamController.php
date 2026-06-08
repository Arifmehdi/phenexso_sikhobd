<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Question;
use App\Models\ExamAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    public function index()
    {
        menuSubmenu('academy', 'examsAll');
        $exams = Exam::latest()->paginate(20);
        return view('admin.exams.index', compact('exams'));
    }

    public function create()
    {
        menuSubmenu('academy', 'examsAll');
        $users = \App\Models\User::orderBy('name')->get();
        return view('admin.exams.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'duration' => 'required|integer',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'question_count' => 'required|integer',
            'student_ids' => 'nullable|array',
            'student_ids.*' => 'exists:users,id'
        ]);

        $exam = Exam::create($request->all() + ['created_by' => Auth::id()]);
        
        if ($request->has('student_ids')) {
            $exam->students()->sync($request->student_ids);
        }

        return redirect()->route('admin.exams.select-questions', $exam->id);
    }

    public function edit(Exam $exam)
    {
        menuSubmenu('academy', 'examsAll');
        $users = \App\Models\User::orderBy('name')->get();
        $selected_student_ids = $exam->students()->pluck('users.id')->toArray();
        return view('admin.exams.edit', compact('exam', 'users', 'selected_student_ids'));
    }

    public function update(Request $request, Exam $exam)
    {
        $request->validate([
            'title' => 'required',
            'duration' => 'required|integer',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'question_count' => 'required|integer',
            'student_ids' => 'nullable|array',
            'student_ids.*' => 'exists:users,id'
        ]);

        $exam->update($request->all());
        
        if ($request->has('student_ids')) {
            $exam->students()->sync($request->student_ids);
        } else {
            $exam->students()->detach();
        }

        return redirect()->route('admin.exams.index')->with('success', 'Exam updated successfully.');
    }

    public function selectQuestions(Exam $exam)
    {
        $selected_question_ids = $exam->questions()->pluck('questions.id')->toArray();
        $questions = Question::all();

        return view('admin.exams.select_questions', compact('exam', 'questions', 'selected_question_ids'));
    }

    public function updateQuestions(Request $request, Exam $exam)
    {
        $request->validate([
            'question_ids' => 'required|array',
            'question_ids.*' => 'exists:questions,id'
        ]);

        $exam->questions()->sync($request->question_ids);
        $exam->update(['status' => 'published']);

        return redirect()->route('admin.exams.index')->with('success', 'Exam questions updated and exam published.');
    }

    public function finishExam(Exam $exam)
    {
        $exam->update(['status' => 'finished']);
        return back()->with('success', 'Exam finished. Results are now available to students.');
    }

    public function results(Exam $exam)
    {
        $attempts = ExamAttempt::with('user')->where('exam_id', $exam->id)->orderBy('score', 'desc')->get();
        return view('admin.exams.results', compact('exam', 'attempts'));
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();
        return redirect()->route('admin.exams.index')->with('success', 'Exam deleted successfully.');
    }
}
