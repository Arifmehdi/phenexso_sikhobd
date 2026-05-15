<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseLesson;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseLessonController extends Controller
{
    public function index(Product $product)
    {
        menuSubmenu('product', 'productsAll');
        $lessons = $product->lessons()->orderBy('priority')->get();
        return view('admin.lessons.index', compact('product', 'lessons'));
    }

    public function store(Request $request, Product $product)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'video_url' => 'nullable|url',
        ]);

        CourseLesson::create([
            'product_id' => $product->id,
            'title_en' => $request->title_en,
            'title_bn' => $request->title_bn,
            'description' => $request->description,
            'video_provider' => $request->video_provider ?? 'youtube',
            'video_url' => $request->video_url,
            'duration' => $request->duration,
            'priority' => $request->priority ?? 0,
            'is_free' => $request->has('is_free'),
            'active' => $request->has('active'),
            'addedby_id' => Auth::id(),
        ]);

        return back()->with('success', 'Lesson added successfully.');
    }

    public function update(Request $request, CourseLesson $lesson)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'video_url' => 'nullable|url',
        ]);

        $lesson->update([
            'title_en' => $request->title_en,
            'title_bn' => $request->title_bn,
            'description' => $request->description,
            'video_provider' => $request->video_provider,
            'video_url' => $request->video_url,
            'duration' => $request->duration,
            'priority' => $request->priority,
            'is_free' => $request->has('is_free'),
            'active' => $request->has('active'),
        ]);

        return back()->with('success', 'Lesson updated successfully.');
    }

    public function destroy(CourseLesson $lesson)
    {
        $lesson->delete();
        return back()->with('success', 'Lesson deleted successfully.');
    }
}
