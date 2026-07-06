<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\CourseLesson;
use App\Models\Exam;
use App\Models\Question;
use App\Models\ExamAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherExamController extends Controller
{
    public function index()
    {
        $exams = Exam::with(['course', 'lesson'])->where('created_by', Auth::id())->latest()->paginate(20);
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

    private function examRules()
    {
        return [
            'title' => 'required',
            'duration' => 'required|integer',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'question_count' => 'required|integer',
            'product_id' => 'nullable|exists:products,id',
            'course_lesson_id' => 'nullable|exists:course_lessons,id',
        ];
    }

    /**
     * Teachers may only assign exams to their own courses, and the class
     * must belong to the selected course.
     */
    private function validateCourseAndClass(Request $request)
    {
        if ($request->filled('product_id')) {
            if (!$this->teacherCourses()->pluck('id')->contains((int) $request->product_id)) {
                return 'You can only assign exams to your own courses.';
            }
        }
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

    public function create()
    {
        $courses = $this->teacherCourses();
        return view('teacher.exams.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate($this->examRules());

        if ($error = $this->validateCourseAndClass($request)) {
            return back()->withInput()->with('error', $error);
        }

        $data = $request->all();
        $data['product_id'] = $request->input('product_id') ?: null;
        $data['course_lesson_id'] = $request->input('course_lesson_id') ?: null;

        $exam = Exam::create($data + ['created_by' => Auth::id()]);

        // Keep the course pivot in sync so existing visibility logic keeps working
        $exam->courses()->sync($data['product_id'] ? [$data['product_id']] : []);

        return redirect()->route('teacher.exams.select-questions', $exam->id);
    }

    public function edit(Exam $exam)
    {
        if ($exam->created_by !== Auth::id()) abort(403);
        $courses = $this->teacherCourses();
        return view('teacher.exams.edit', compact('exam', 'courses'));
    }

    public function update(Request $request, Exam $exam)
    {
        if ($exam->created_by !== Auth::id()) abort(403);

        $request->validate($this->examRules());

        if ($error = $this->validateCourseAndClass($request)) {
            return back()->withInput()->with('error', $error);
        }

        $data = $request->all();
        $data['product_id'] = $request->input('product_id') ?: null;
        $data['course_lesson_id'] = $request->input('course_lesson_id') ?: null;

        $exam->update($data);

        $exam->courses()->sync($data['product_id'] ? [$data['product_id']] : []);

        return redirect()->route('user.dashboard', ['activeTab' => 'teacher_exams'])->with('success', 'Exam updated successfully.');
    }

    public function selectQuestions(Exam $exam, Request $request)
    {
        if ($exam->created_by !== Auth::id()) abort(403);
        $selected_question_ids = $exam->questions()->pluck('questions.id')->toArray();

        // Default scope: the exam's class, then its course, then all own questions
        $scope = $request->input('scope');
        if (!$scope) {
            $scope = $exam->course_lesson_id ? 'class' : ($exam->product_id ? 'course' : 'all');
        }

        $query = Question::with(['course', 'lesson'])->where('created_by', Auth::id())->latest();
        if ($scope === 'class' && $exam->course_lesson_id) {
            $query->where('course_lesson_id', $exam->course_lesson_id);
        } elseif ($scope === 'course' && $exam->product_id) {
            $query->where('product_id', $exam->product_id);
        } else {
            $scope = 'all';
        }

        $questions = $query->get();

        return view('teacher.exams.select_questions', compact('exam', 'questions', 'selected_question_ids', 'scope'));
    }

    public function updateQuestions(Request $request, Exam $exam)
    {
        if ($exam->created_by !== Auth::id()) abort(403);

        $request->validate([
            'question_ids' => 'required|array',
            'question_ids.*' => 'exists:questions,id'
        ]);

        // Merge instead of replace so switching filters doesn't drop earlier picks;
        // unchecked boxes on the currently visible list are removed.
        $visible = array_map('intval', explode(',', $request->input('visible_ids', '')));
        $current = $exam->questions()->pluck('questions.id')->toArray();
        $keep = array_diff($current, $visible);
        $ids = array_unique(array_merge($keep, $request->question_ids));

        $exam->questions()->sync($ids);
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
