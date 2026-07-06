<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\CourseLesson;
use App\Models\Product;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherQuestionController extends Controller
{
    /** Courses that belong to (are assigned to) the logged-in teacher. */
    private function teacherCourses()
    {
        return Product::where('type', 'course')
            ->where('active', 1)
            ->where('instructor_id', Auth::id())
            ->orderBy('name_en')
            ->get();
    }

    private function questionRules()
    {
        return [
            'question_text' => 'required',
            'option_a' => 'required',
            'option_b' => 'required',
            'option_c' => 'required',
            'option_d' => 'required',
            'correct_option' => 'required|in:a,b,c,d',
            'product_id' => 'nullable|exists:products,id',
            'course_lesson_id' => 'nullable|exists:course_lessons,id',
        ];
    }

    /**
     * Teachers may only tag questions to their own courses, and the class
     * must belong to the selected course.
     */
    private function validateCourseAndClass(Request $request)
    {
        if ($request->filled('product_id')) {
            if (!$this->teacherCourses()->pluck('id')->contains((int) $request->product_id)) {
                return 'You can only use your own courses.';
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

    public function index()
    {
        $questions = Question::with(['course', 'lesson'])->where('created_by', Auth::id())->latest()->paginate(20);
        return view('teacher.questions.index', compact('questions'));
    }

    public function create()
    {
        $courses = $this->teacherCourses();
        return view('teacher.questions.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate($this->questionRules());

        if ($error = $this->validateCourseAndClass($request)) {
            return back()->withInput()->with('error', $error);
        }

        Question::create($request->all() + ['created_by' => Auth::id()]);

        if ($request->input('save_and_new')) {
            return redirect()->route('teacher.questions.create', array_filter([
                'course_id' => $request->product_id,
                'class_id' => $request->course_lesson_id,
            ]))->with('success', 'Question saved. Add the next one.');
        }

        return redirect()->route('user.dashboard', ['activeTab' => 'teacher_questions'])->with('success', 'Question created successfully.');
    }

    public function edit(Question $question)
    {
        if ($question->created_by !== Auth::id()) abort(403);
        $courses = $this->teacherCourses();
        return view('teacher.questions.edit', compact('question', 'courses'));
    }

    public function update(Request $request, Question $question)
    {
        if ($question->created_by !== Auth::id()) abort(403);

        $request->validate($this->questionRules());

        if ($error = $this->validateCourseAndClass($request)) {
            return back()->withInput()->with('error', $error);
        }

        $data = $request->all();
        $data['product_id'] = $request->input('product_id') ?: null;
        $data['course_lesson_id'] = $request->input('course_lesson_id') ?: null;

        $question->update($data);

        return redirect()->route('user.dashboard', ['activeTab' => 'teacher_questions'])->with('success', 'Question updated successfully.');
    }

    public function destroy(Question $question)
    {
        if ($question->created_by !== Auth::id()) abort(403);
        $question->delete();
        return redirect()->route('user.dashboard', ['activeTab' => 'teacher_questions'])->with('success', 'Question deleted successfully.');
    }

    public function bulkUpload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv,txt',
            'product_id' => 'nullable|exists:products,id',
            'course_lesson_id' => 'nullable|exists:course_lessons,id',
        ]);

        if ($error = $this->validateCourseAndClass($request)) {
            return redirect()->route('user.dashboard', ['activeTab' => 'teacher_questions'])->with('error', $error);
        }

        try {
            \Maatwebsite\Excel\Facades\Excel::import(
                new \App\Imports\QuestionsImport(Auth::id(), $request->product_id, $request->course_lesson_id),
                $request->file('file')
            );
            return redirect()->route('user.dashboard', ['activeTab' => 'teacher_questions'])->with('success', 'Questions imported successfully to your question bank.');
        } catch (\Exception $e) {
            return redirect()->route('user.dashboard', ['activeTab' => 'teacher_questions'])->with('error', 'Error importing questions: ' . $e->getMessage());
        }
    }
}
