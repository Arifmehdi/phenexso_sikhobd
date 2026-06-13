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
        menuSubmenu('academy', 'coursesAll');
        $lessons = $product->lessons()->orderBy('priority')->get();
        return view('admin.lessons.index', compact('product', 'lessons'));
    }

    public function store(Request $request, Product $product)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'video_url' => 'nullable|url',
            'pdf_file' => 'nullable|file|mimes:pdf|max:51200', // Increased limit
            'audio_file' => 'nullable|file|mimes:mp3,wav,ogg,m4a|max:51200',
            'video_file' => 'nullable|file|mimes:mp4,webm,mov|max:512000', // 500MB limit for 224MB request
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
            $videoFile = $request->file('video_file');
            $path = 'course_materials/video/' . time() . '_' . $videoFile->getClientOriginalName();
            
            // Optimization Logic
            $tempPath = $videoFile->getRealPath();
            $optimizedPath = storage_path('app/public/' . $path);
            
            if ($this->optimizeVideo($tempPath, $optimizedPath)) {
                $data['video_file'] = $path;
            } else {
                // Fallback to direct store if optimization fails or FFmpeg not found
                $data['video_file'] = $request->file('video_file')->store('course_materials/video', 'public');
            }
        }

        $lesson = CourseLesson::create($data);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Lesson added successfully.', 'lesson' => $lesson]);
        }

        return back()->with('success', 'Lesson added successfully.');
    }

    public function update(Request $request, CourseLesson $lesson)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'video_url' => 'nullable|url',
            'pdf_file' => 'nullable|file|mimes:pdf|max:51200',
            'audio_file' => 'nullable|file|mimes:mp3,wav,ogg,m4a|max:51200',
            'video_file' => 'nullable|file|mimes:mp4,webm,mov|max:512000',
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
            
            $videoFile = $request->file('video_file');
            $path = 'course_materials/video/' . time() . '_' . $videoFile->getClientOriginalName();
            $tempPath = $videoFile->getRealPath();
            $optimizedPath = storage_path('app/public/' . $path);
            
            if ($this->optimizeVideo($tempPath, $optimizedPath)) {
                $data['video_file'] = $path;
            } else {
                $data['video_file'] = $request->file('video_file')->store('course_materials/video', 'public');
            }
        }

        $lesson->update($data);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Lesson updated successfully.']);
        }

        return back()->with('success', 'Lesson updated successfully.');
    }

    private function optimizeVideo($inputPath, $outputPath)
    {
        // Ensure directory exists
        if (!file_exists(dirname($outputPath))) {
            mkdir(dirname($outputPath), 0755, true);
        }

        // Try to find ffmpeg
        $ffmpeg = 'ffmpeg'; // Default in PATH
        
        // On Windows, common paths if not in PATH
        if (PHP_OS_FAMILY === 'Windows') {
            $commonPaths = [
                'C:\ffmpeg\bin\ffmpeg.exe',
                'D:\ffmpeg\bin\ffmpeg.exe',
                'C:\laragon\bin\ffmpeg\bin\ffmpeg.exe',
            ];
            foreach ($commonPaths as $path) {
                if (file_exists($path)) {
                    $ffmpeg = '"' . $path . '"';
                    break;
                }
            }
        }

        // Check if ffmpeg is executable
        $check = shell_exec("$ffmpeg -version 2>&1");
        if (strpos($check, 'ffmpeg version') === false) {
            return false; // FFmpeg not found
        }

        // Optimization parameters: 
        // -crf 23 (good quality, lower is better quality/bigger file)
        // -preset faster (balance between speed and compression)
        // -vf scale=-2:720 (scale to 720p height, maintaining aspect ratio)
        $command = "$ffmpeg -i " . escapeshellarg($inputPath) . " -vcodec libx264 -crf 28 -preset faster -vf scale=-2:720 -acodec aac -b:a 128k " . escapeshellarg($outputPath) . " 2>&1";
        
        exec($command, $output, $returnVar);

        return $returnVar === 0;
    }

    public function destroy(CourseLesson $lesson)
    {
        $lesson->delete();
        return back()->with('success', 'Lesson deleted successfully.');
    }
}
