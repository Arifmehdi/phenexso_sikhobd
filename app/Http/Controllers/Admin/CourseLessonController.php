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
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
            'audio_file' => 'nullable|file|mimes:mp3,wav,ogg|max:20480',
            'video_file' => 'nullable|file|mimes:mp4,webm|max:51200',
        ]);

        $data = [
            'product_id' => $product->id,
            'course_section_id' => $request->course_section_id,
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
        ];

        if ($request->hasFile('pdf_file')) {
            $data['pdf_url'] = $request->file('pdf_file')->store('course_materials/pdf', 'public');
        }
        if ($request->hasFile('audio_file')) {
            $data['audio_url'] = $request->file('audio_file')->store('course_materials/audio', 'public');
        }
        if ($request->hasFile('video_file')) {
            $data['video_file'] = $request->file('video_file')->store('course_materials/video', 'public');
        }

        CourseLesson::create($data);

        return back()->with('success', 'Lesson added successfully.');
    }

    public function update(Request $request, CourseLesson $lesson)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'video_url' => 'nullable|url',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
            'audio_file' => 'nullable|file|mimes:mp3,wav,ogg|max:20480',
            'video_file' => 'nullable|file|mimes:mp4,webm|max:51200',
        ]);

        $data = [
            'course_section_id' => $request->course_section_id,
            'title_en' => $request->title_en,
            'title_bn' => $request->title_bn,
            'description' => $request->description,
            'video_provider' => $request->video_provider,
            'video_url' => $request->video_url,
            'duration' => $request->duration,
            'priority' => $request->priority,
            'is_free' => $request->has('is_free'),
            'active' => $request->has('active'),
        ];

        if ($request->hasFile('pdf_file')) {
            if ($lesson->pdf_url) \Storage::disk('public')->delete($lesson->pdf_url);
            $data['pdf_url'] = $request->file('pdf_file')->store('course_materials/pdf', 'public');
        }
        if ($request->hasFile('audio_file')) {
            if ($lesson->audio_url) \Storage::disk('public')->delete($lesson->audio_url);
            $data['audio_url'] = $request->file('audio_file')->store('course_materials/audio', 'public');
        }
        if ($request->hasFile('video_file')) {
            if ($lesson->video_file) \Storage::disk('public')->delete($lesson->video_file);
            $data['video_file'] = $request->file('video_file')->store('course_materials/video', 'public');
        }

        $lesson->update($data);

        return back()->with('success', 'Lesson updated successfully.');
    }

    public function destroy(CourseLesson $lesson)
    {
        $lesson->delete();
        return back()->with('success', 'Lesson deleted successfully.');
    }
}
