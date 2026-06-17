<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Ebook;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class EbookController extends Controller
{
    public function index(Request $request)
    {
        $query = Ebook::where('active', 1)->where('status', 'approved');
        
        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        $ebooks = $query->latest()->paginate(12);
        $categories = ProductCategory::where('type', 'ebook')->where('active', 1)->get();
        
        return view('website.ebooks.index', compact('ebooks', 'categories'));
    }

    public function show($id)
    {
        $ebook = Ebook::where('active', 1)->where('status', 'approved')->findOrFail($id);
        $ebook->increment('view_count');
        return view('website.ebooks.details', compact('ebook'));
    }

    public function uploadForm()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('warning', 'Please login to upload eBook.');
        }
        $categories = ProductCategory::where('type', 'ebook')->where('active', 1)->get();
        return view('website.ebooks.upload', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'category_id' => 'required|exists:product_categories,id',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'file' => 'required|mimes:pdf|max:10240',
            'preview_file' => 'nullable|mimes:pdf|max:2048',
        ]);

        $ebook = new Ebook($request->all());
        $ebook->user_id = Auth::id();
        $ebook->status = 'pending';
        $ebook->save();

        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $name = $ebook->id . '_cover_' . time() . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->put('ebook_covers/' . $name, File::get($file));
            $ebook->cover_image = $name;
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $name = $ebook->id . '_full_' . time() . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->put('ebook_files/' . $name, File::get($file));
            $ebook->file_path = $name;
        }

        if ($request->hasFile('preview_file')) {
            $file = $request->file('preview_file');
            $name = $ebook->id . '_preview_' . time() . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->put('ebook_previews/' . $name, File::get($file));
            $ebook->preview_path = $name;
        }

        $ebook->save();

        return redirect()->route('ebooks.index')->with('success', 'eBook uploaded successfully and waiting for admin approval.');
    }

    public function preview($id)
    {
        $ebook = Ebook::findOrFail($id);
        if (!$ebook->preview_path) {
            return back()->with('error', 'Preview not available for this eBook.');
        }
        return view('website.ebooks.preview', compact('ebook'));
    }
}
