<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseLesson;
use App\Models\Product;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    private function courses()
    {
        return Product::where('type', 'course')->where('active', 1)->orderBy('name_en')->get();
    }

    /**
     * If both a course and a class are submitted, make sure the class
     * really belongs to that course (guards against stale AJAX values).
     */
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

    public function index(Request $request)
    {
        menuSubmenu('academy', 'questionsAll');

        $query = Question::with(['course', 'lesson'])->latest();

        if ($request->filled('course_id')) {
            $query->where('product_id', $request->course_id);
        }
        if ($request->filled('class_id')) {
            $query->where('course_lesson_id', $request->class_id);
        }

        $questions = $query->paginate(20)->withQueryString();
        $courses = $this->courses();

        return view('admin.questions.index', compact('questions', 'courses'));
    }

    public function create()
    {
        menuSubmenu('academy', 'questionsAll');
        $courses = $this->courses();
        return view('admin.questions.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'question_text' => 'required',
            'option_a' => 'required',
            'option_b' => 'required',
            'option_c' => 'required',
            'option_d' => 'required',
            'correct_option' => 'required|in:a,b,c,d',
            'product_id' => 'nullable|exists:products,id',
            'course_lesson_id' => 'nullable|exists:course_lessons,id',
        ]);

        if ($error = $this->validateClassBelongsToCourse($request)) {
            return back()->withInput()->with('error', $error);
        }

        Question::create($request->all() + ['created_by' => auth()->id()]);

        if ($request->input('save_and_new')) {
            return redirect()->route('admin.questions.create', array_filter([
                'course_id' => $request->product_id,
                'class_id' => $request->course_lesson_id,
            ]))->with('success', 'Question saved. Add the next one.');
        }

        return redirect()->route('admin.questions.index')->with('success', 'Question created successfully.');
    }

    public function edit(Question $question)
    {
        menuSubmenu('academy', 'questionsAll');
        $courses = $this->courses();
        return view('admin.questions.edit', compact('question', 'courses'));
    }

    public function update(Request $request, Question $question)
    {
        $request->validate([
            'question_text' => 'required',
            'option_a' => 'required',
            'option_b' => 'required',
            'option_c' => 'required',
            'option_d' => 'required',
            'correct_option' => 'required|in:a,b,c,d',
            'product_id' => 'nullable|exists:products,id',
            'course_lesson_id' => 'nullable|exists:course_lessons,id',
        ]);

        if ($error = $this->validateClassBelongsToCourse($request)) {
            return back()->withInput()->with('error', $error);
        }

        // When the course is cleared/changed without a class, clear the stale class too
        $data = $request->all();
        $data['product_id'] = $request->input('product_id') ?: null;
        $data['course_lesson_id'] = $request->input('course_lesson_id') ?: null;

        $question->update($data);

        return redirect()->route('admin.questions.index')->with('success', 'Question updated successfully.');
    }

    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->route('admin.questions.index')->with('success', 'Question deleted successfully.');
    }

    public function bulkUpload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv,txt',
            'product_id' => 'nullable|exists:products,id',
            'course_lesson_id' => 'nullable|exists:course_lessons,id',
        ]);

        if ($error = $this->validateClassBelongsToCourse($request)) {
            return back()->with('error', $error);
        }

        try {
            \Maatwebsite\Excel\Facades\Excel::import(
                new \App\Imports\QuestionsImport(null, $request->product_id, $request->course_lesson_id),
                $request->file('file')
            );
            return back()->with('success', 'Questions imported successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error importing questions: ' . $e->getMessage());
        }
    }
}
