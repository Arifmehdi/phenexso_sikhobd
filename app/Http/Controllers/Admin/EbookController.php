<?php

namespace App\Http\Controllers\Admin;

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
        menuSubmenu('ebook', 'ebookList');
        $ebooks = Ebook::with(['user', 'category'])->latest()->paginate(30);
        return view('admin.ebooks.index', compact('ebooks'));
    }

    public function ebookSearch(Request $request)
    {
        $q = $request->q;
        $ebooks = Ebook::with(['user', 'category'])
            ->where(function($query) use ($q) {
                $query->where('title_en', 'like', '%' . $q . '%')
                    ->orWhere('title_bn', 'like', '%' . $q . '%')
                    ->orWhere('author_name', 'like', '%' . $q . '%');
            })
            ->latest()
            ->paginate(30);

        if ($request->ajax()) {
            $view = view('admin.ebooks.searchData', compact('ebooks'))->render();
            return response()->json([
                'success' => true,
                'page' => $view
            ]);
        }

        return view('admin.ebooks.index', compact('ebooks'));
    }

    public function create()
    {
        menuSubmenu('ebook', 'ebookList');
        $categories = ProductCategory::where('type', 'ebook')->latest()->get();
        return view('admin.ebooks.create', compact('categories'));
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
        $ebook->user_id = Auth::id(); // Admin is the uploader
        $ebook->status = 'approved'; // Admin uploads are auto-approved
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

        return redirect()->route('admin.ebooks.index')->with('success', 'eBook uploaded successfully.');
    }

    public function edit(Ebook $ebook)
    {
        menuSubmenu('ebook', 'ebookList');
        $categories = ProductCategory::where('type', 'ebook')->latest()->get();
        return view('admin.ebooks.edit', compact('ebook', 'categories'));
    }

    public function update(Request $request, Ebook $ebook)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $ebook->update($request->all());

        if ($request->hasFile('cover_image')) {
            if ($ebook->cover_image) {
                Storage::disk('public')->delete('ebook_covers/' . $ebook->cover_image);
            }
            $file = $request->file('cover_image');
            $name = time() . '_' . $file->getClientOriginalName();
            Storage::disk('public')->put('ebook_covers/' . $name, File::get($file));
            $ebook->cover_image = $name;
            $ebook->save();
        }

        return redirect()->route('admin.ebooks.index')->with('success', 'Ebook updated successfully.');
    }

    public function destroy(Ebook $ebook)
    {
        if ($ebook->cover_image) {
            Storage::disk('public')->delete('ebook_covers/' . $ebook->cover_image);
        }
        if ($ebook->file_path) {
            Storage::disk('public')->delete('ebook_files/' . $ebook->file_path);
        }
        if ($ebook->preview_path) {
            Storage::disk('public')->delete('ebook_previews/' . $ebook->preview_path);
        }
        $ebook->delete();
        return back()->with('success', 'Ebook deleted successfully.');
    }

    public function status(Request $request)
    {
        $ebook = Ebook::find($request->id);
        $ebook->active = !$ebook->active;
        $ebook->save();
        return response()->json(['success' => true, 'active' => $ebook->active]);
    }

    public function toggleApproval(Request $request)
    {
        $ebook = Ebook::find($request->id);
        $ebook->status = $ebook->status == 'approved' ? 'pending' : 'approved';
        $ebook->save();
        return response()->json(['success' => true, 'status' => $ebook->status]);
    }
}
