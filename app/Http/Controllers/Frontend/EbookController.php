<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Ebook;
use App\Models\ProductCategory;
use App\Models\Enrollment;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

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

        $isEnrolled = false;
        if (Auth::check()) {
            $isEnrolled = Enrollment::where('user_id', Auth::id())
                ->where('ebook_id', $id)
                ->where('status', 'active')
                ->exists();
        }

        return view('website.ebooks.details', compact('ebook', 'isEnrolled'));
    }

    public function buy($id)
    {
        $ebook = Ebook::findOrFail($id);
        
        $session_id = Session::get('session_id', function () {
            $id = Session::getId();
            Session::put('session_id', $id);
            return $id;
        });

        $user_id = Auth::id() ?? 0;

        // Check if already in cart
        $cart = Cart::firstOrNew([
            'ebook_id'   => $ebook->id,
            'session_id' => $session_id,
            'user_id'    => $user_id,
        ]);

        $cart->quantity   = 1;
        $cart->addedby_id = $user_id;
        $cart->save();

        return redirect()->route('new.checkout')->with('success', 'ই-বুকটি কার্টে যোগ করা হয়েছে।');
    }

    public function read($id)
    {
        $ebook = Ebook::findOrFail($id);
        
        $isEnrolled = false;
        if (Auth::check()) {
            $isEnrolled = Enrollment::where('user_id', Auth::id())
                ->where('ebook_id', $id)
                ->where('status', 'active')
                ->exists();
        }

        if (!$isEnrolled) {
            return redirect()->route('ebooks.show', $id)->with('error', 'সম্পূর্ণ বইটি পড়তে প্রথমে এটি কিনুন।');
        }

        if (!$ebook->file_path) {
            return back()->with('error', 'বইটির ফাইল পাওয়া যায়নি।');
        }

        return view('website.ebooks.read', compact('ebook'));
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
