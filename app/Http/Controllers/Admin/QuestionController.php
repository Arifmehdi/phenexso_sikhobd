<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        menuSubmenu('academy', 'questionsAll');
        $questions = Question::latest()->paginate(20);
        return view('admin.questions.index', compact('questions'));
    }

    public function create()
    {
        menuSubmenu('academy', 'questionsAll');
        return view('admin.questions.create');
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

        Question::create($request->all());

        return redirect()->route('admin.questions.index')->with('success', 'Question created successfully.');
    }

    public function edit(Question $question)
    {
        menuSubmenu('academy', 'questionsAll');
        return view('admin.questions.edit', compact('question'));
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
        ]);

        $question->update($request->all());

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
        ]);

        try {
            \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\QuestionsImport, $request->file('file'));
            return back()->with('success', 'Questions imported successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error importing questions: ' . $e->getMessage());
        }
    }
}
