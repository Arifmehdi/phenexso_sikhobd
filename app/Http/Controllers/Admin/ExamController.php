<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Question;
use App\Models\ExamAttempt;
use App\Models\Product;
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
        $courses = Product::where('type', 'course')->where('active', 1)->orderBy('name_en')->get();
        return view('admin.exams.create', compact('users', 'courses'));
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
            'student_ids.*' => 'exists:users,id',
            'course_ids' => 'nullable|array',
            'course_ids.*' => 'exists:products,id',
        ]);

        $exam = Exam::create($request->all() + ['created_by' => Auth::id()]);

        $exam->students()->sync($request->student_ids ?? []);
        $exam->courses()->sync($request->course_ids ?? []);

        return redirect()->route('admin.exams.select-questions', $exam->id);
    }

    public function edit(Exam $exam)
    {
        menuSubmenu('academy', 'examsAll');
        $users = \App\Models\User::orderBy('name')->get();
        $courses = Product::where('type', 'course')->where('active', 1)->orderBy('name_en')->get();
        $selected_student_ids = $exam->students()->pluck('users.id')->toArray();
        $selected_course_ids = $exam->courses()->pluck('products.id')->toArray();
        return view('admin.exams.edit', compact('exam', 'users', 'selected_student_ids', 'courses', 'selected_course_ids'));
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
            'student_ids.*' => 'exists:users,id',
            'course_ids' => 'nullable|array',
            'course_ids.*' => 'exists:products,id',
        ]);

        $exam->update($request->all());

        $exam->students()->sync($request->student_ids ?? []);
        $exam->courses()->sync($request->course_ids ?? []);

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
