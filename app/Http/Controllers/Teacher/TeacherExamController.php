<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Question;
use App\Models\ExamAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherExamController extends Controller
{
    public function index()
    {
        $exams = Exam::where('created_by', Auth::id())->latest()->paginate(20);
        return view('teacher.exams.index', compact('exams'));
    }

    /**
     * Courses that belong to (are assigned to) the logged-in teacher.
     */
    private function teacherCourses()
    {
        return \App\Models\Product::where('type', 'course')
            ->where('active', 1)
            ->where('instructor_id', Auth::id())
            ->orderBy('name_en')
            ->get();
    }

    public function create()
    {
        $courses = $this->teacherCourses();
        return view('teacher.exams.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'duration' => 'required|integer',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'question_count' => 'required|integer',
            'course_ids' => 'nullable|array',
            'course_ids.*' => 'exists:products,id',
        ]);

        $exam = Exam::create($request->all() + ['created_by' => Auth::id()]);

        // Only allow assigning courses the teacher actually owns
        $allowed = $this->teacherCourses()->pluck('id')->toArray();
        $courseIds = array_values(array_intersect($request->course_ids ?? [], $allowed));
        $exam->courses()->sync($courseIds);

        return redirect()->route('teacher.exams.select-questions', $exam->id);
    }

    public function edit(Exam $exam)
    {
        if ($exam->created_by !== Auth::id()) abort(403);
        $courses = $this->teacherCourses();
        $selected_course_ids = $exam->courses()->pluck('products.id')->toArray();
        return view('teacher.exams.edit', compact('exam', 'courses', 'selected_course_ids'));
    }

    public function update(Request $request, Exam $exam)
    {
        if ($exam->created_by !== Auth::id()) abort(403);

        $request->validate([
            'title' => 'required',
            'duration' => 'required|integer',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'question_count' => 'required|integer',
            'course_ids' => 'nullable|array',
            'course_ids.*' => 'exists:products,id',
        ]);

        $exam->update($request->all());

        // Only allow assigning courses the teacher actually owns
        $allowed = $this->teacherCourses()->pluck('id')->toArray();
        $courseIds = array_values(array_intersect($request->course_ids ?? [], $allowed));
        $exam->courses()->sync($courseIds);

        return redirect()->route('user.dashboard', ['activeTab' => 'teacher_exams'])->with('success', 'Exam updated successfully.');
    }

    public function selectQuestions(Exam $exam)
    {
        if ($exam->created_by !== Auth::id()) abort(403);
        $selected_question_ids = $exam->questions()->pluck('questions.id')->toArray();
        // Allow teachers to select from their own questions OR all public questions if that's a feature. 
        // For now, only their own questions.
        $questions = Question::where('created_by', Auth::id())->get();

        return view('teacher.exams.select_questions', compact('exam', 'questions', 'selected_question_ids'));
    }

    public function updateQuestions(Request $request, Exam $exam)
    {
        if ($exam->created_by !== Auth::id()) abort(403);

        $request->validate([
            'question_ids' => 'required|array',
            'question_ids.*' => 'exists:questions,id'
        ]);

        $exam->questions()->sync($request->question_ids);
        $exam->update(['status' => 'published']);

        return redirect()->route('user.dashboard', ['activeTab' => 'teacher_exams'])->with('success', 'Exam questions updated and exam published.');
    }

    public function finishExam(Exam $exam)
    {
        if ($exam->created_by !== Auth::id()) abort(403);
        $exam->update(['status' => 'finished']);
        return redirect()->route('user.dashboard', ['activeTab' => 'teacher_exams'])->with('success', 'Exam finished. Results are now available to students.');
    }

    public function results(Exam $exam)
    {
        if ($exam->created_by !== Auth::id()) abort(403);
        $attempts = ExamAttempt::with('user')->where('exam_id', $exam->id)->orderBy('score', 'desc')->get();
        return view('teacher.exams.results', compact('exam', 'attempts'));
    }

    public function destroy(Exam $exam)
    {
        if ($exam->created_by !== Auth::id()) abort(403);
        $exam->delete();
        return redirect()->route('user.dashboard', ['activeTab' => 'teacher_exams'])->with('success', 'Exam deleted successfully.');
    }
}
