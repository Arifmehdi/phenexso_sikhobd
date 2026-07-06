<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseLesson;
use App\Models\Exam;
use App\Models\Question;
use App\Models\ExamAttempt;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    private function courses()
    {
        return Product::where('type', 'course')->where('active', 1)->orderBy('name_en')->get();
    }

    private function examValidationRules()
    {
        return [
            'title' => 'required',
            'duration' => 'required|integer',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'question_count' => 'required|integer',
            'student_ids' => 'nullable|array',
            'student_ids.*' => 'exists:users,id',
            'product_id' => 'nullable|exists:products,id',
            'course_lesson_id' => 'nullable|exists:course_lessons,id',
        ];
    }

    /** Make sure the selected class really belongs to the selected course. */
    private function validateClassBelongsToCourse(Request $request)
    {
        if ($request->filled('course_lesson_id')) {
            if (!$request->filled('product_id')) {
                return 'Please select a course before selecting a class.';
            }
            $belongs = CourseLesson::where('id', $request->course_lesson_id)
                ->where('product_id', $request->product_id)
                ->exists();
            if (!$belongs) {
                return 'The selected class does not belong to the selected course.';
            }
        }
        return null;
    }

    public function index()
    {
        menuSubmenu('academy', 'examsAll');
        $exams = Exam::with(['course', 'lesson'])->latest()->paginate(20);
        return view('admin.exams.index', compact('exams'));
    }

    public function create()
    {
        menuSubmenu('academy', 'examsAll');
        $users = \App\Models\User::orderBy('name')->get();
        $courses = $this->courses();
        return view('admin.exams.create', compact('users', 'courses'));
    }

    public function store(Request $request)
    {
        $request->validate($this->examValidationRules());

        if ($error = $this->validateClassBelongsToCourse($request)) {
            return back()->withInput()->with('error', $error);
        }

        $data = $request->all();
        $data['product_id'] = $request->input('product_id') ?: null;
        $data['course_lesson_id'] = $request->input('course_lesson_id') ?: null;

        $exam = Exam::create($data + ['created_by' => Auth::id()]);

        $exam->students()->sync($request->student_ids ?? []);
        // Keep the course pivot in sync so existing visibility logic keeps working
        $exam->courses()->sync($data['product_id'] ? [$data['product_id']] : []);

        return redirect()->route('admin.exams.select-questions', $exam->id);
    }

    public function edit(Exam $exam)
    {
        menuSubmenu('academy', 'examsAll');
        $users = \App\Models\User::orderBy('name')->get();
        $courses = $this->courses();
        $selected_student_ids = $exam->students()->pluck('users.id')->toArray();
        return view('admin.exams.edit', compact('exam', 'users', 'selected_student_ids', 'courses'));
    }

    public function update(Request $request, Exam $exam)
    {
        $request->validate($this->examValidationRules());

        if ($error = $this->validateClassBelongsToCourse($request)) {
            return back()->withInput()->with('error', $error);
        }

        $data = $request->all();
        $data['product_id'] = $request->input('product_id') ?: null;
        $data['course_lesson_id'] = $request->input('course_lesson_id') ?: null;

        $exam->update($data);

        $exam->students()->sync($request->student_ids ?? []);
        $exam->courses()->sync($data['product_id'] ? [$data['product_id']] : []);

        return redirect()->route('admin.exams.index')->with('success', 'Exam updated successfully.');
    }

    public function selectQuestions(Exam $exam, Request $request)
    {
        $selected_question_ids = $exam->questions()->pluck('questions.id')->toArray();

        // Default scope: the exam's class, then its course, then everything
        $scope = $request->input('scope');
        if (!$scope) {
            $scope = $exam->course_lesson_id ? 'class' : ($exam->product_id ? 'course' : 'all');
        }

        $query = Question::with(['course', 'lesson'])->latest();
        if ($scope === 'class' && $exam->course_lesson_id) {
            $query->where('course_lesson_id', $exam->course_lesson_id);
        } elseif ($scope === 'course' && $exam->product_id) {
            $query->where('product_id', $exam->product_id);
        } else {
            $scope = 'all';
        }

        $questions = $query->get();

        return view('admin.exams.select_questions', compact('exam', 'questions', 'selected_question_ids', 'scope'));
    }

    public function updateQuestions(Request $request, Exam $exam)
    {
        $request->validate([
            'question_ids' => 'required|array',
            'question_ids.*' => 'exists:questions,id'
        ]);

        // Merge instead of replace so switching filters doesn't drop earlier picks;
        // unchecked boxes on the current page are removed via kept_visible_ids.
        $visible = array_map('intval', explode(',', $request->input('visible_ids', '')));
        $current = $exam->questions()->pluck('questions.id')->toArray();
        $keep = array_diff($current, $visible);
        $ids = array_unique(array_merge($keep, $request->question_ids));

        $exam->questions()->sync($ids);
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
