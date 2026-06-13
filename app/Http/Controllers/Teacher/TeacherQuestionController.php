<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherQuestionController extends Controller
{
    public function index()
    {
        $questions = Question::where('created_by', Auth::id())->latest()->paginate(20);
        return view('teacher.questions.index', compact('questions'));
    }

    public function create()
    {
        return view('teacher.questions.create');
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
        ]);

        Question::create($request->all() + ['created_by' => Auth::id()]);

        return redirect()->route('user.dashboard', ['activeTab' => 'teacher_questions'])->with('success', 'Question created successfully.');
    }

    public function edit(Question $question)
    {
        if ($question->created_by !== Auth::id()) abort(403);
        return view('teacher.questions.edit', compact('question'));
    }

    public function update(Request $request, Question $question)
    {
        if ($question->created_by !== Auth::id()) abort(403);

        $request->validate([
            'question_text' => 'required',
            'option_a' => 'required',
            'option_b' => 'required',
            'option_c' => 'required',
            'option_d' => 'required',
            'correct_option' => 'required|in:a,b,c,d',
        ]);

        $question->update($request->all());

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
        ]);

        try {
            \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\QuestionsImport(Auth::id()), $request->file('file'));
            return redirect()->route('user.dashboard', ['activeTab' => 'teacher_questions'])->with('success', 'Questions imported successfully to your question bank.');
        } catch (\Exception $e) {
            return redirect()->route('user.dashboard', ['activeTab' => 'teacher_questions'])->with('error', 'Error importing questions: ' . $e->getMessage());
        }
    }
}
