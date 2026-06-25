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
        // Paid eBooks only (free ones live under the "Free eBook" menu)
        $query = Ebook::where('active', 1)->where('status', 'approved')->where('is_free', 0);

        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        $ebooks = $query->latest()->paginate(12);
        $categories = ProductCategory::where('type', 'ebook')->where('active', 1)->get();

        // Get ebook cart IDs for current user or guest session
        $cartEbookIds = [];
        if(Auth::check()) {
            $cartEbookIds = Cart::where('user_id', Auth::id())
                ->whereNull('product_id')
                ->pluck('ebook_id')
                ->toArray();
        } elseif(session('session_id')) {
            $cartEbookIds = Cart::where('session_id', session('session_id'))
                ->whereNull('product_id')
                ->pluck('ebook_id')
                ->toArray();
        }

        return view('website.ebooks.index', compact('ebooks', 'categories', 'cartEbookIds'));
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

        if (!Auth::check()) {
            if (request()->ajax()) {
                return response()->json([
                    'status' => false,
                    'message' => 'কার্টে যোগ করতে প্রথমে লগইন করুন।',
                    'login_required' => true,
                ], 401);
            }
            return redirect()->route('login')->with('warning', 'কার্টে যোগ করতে প্রথমে লগইন করুন।');
        }

        $session_id = Session::get('session_id', function () {
            $id = Session::getId();
            Session::put('session_id', $id);
            return $id;
        });

        $user_id = Auth::id();

        $cart = Cart::firstOrNew([
            'ebook_id'   => $ebook->id,
            'session_id' => $session_id,
            'user_id'    => $user_id,
        ]);

        $cart->quantity   = 1;
        $cart->addedby_id = $user_id;
        $cart->save();

        if (request()->ajax()) {
            return response()->json([
                'status' => true,
                'message' => 'ই-বুকটি কার্টে যোগ করা হয়েছে।',
            ]);
        }

        return redirect()->route('new.checkout')->with('success', 'ই-বুকটি কার্টে যোগ করা হয়েছে।');
    }

    public function read($id)
    {
        $ebook = Ebook::findOrFail($id);

        if (!$ebook->file_path) {
            return back()->with('error', 'বইটির ফাইল পাওয়া যায়নি।');
        }

        $isFree = $ebook->isFree();

        $isEnrolled = false;
        if (Auth::check()) {
            $isEnrolled = Enrollment::where('user_id', Auth::id())
                ->where('ebook_id', $id)
                ->where('status', 'active')
                ->exists();
        }

        // Full access = free ebook OR purchased (enrolled). Otherwise it is a limited preview.
        $hasFullAccess = $isFree || $isEnrolled;

        $pdfUrl      = asset('storage/ebook_files/' . $ebook->file_path);
        $isPreview   = !$hasFullAccess;
        $maxPages    = $hasFullAccess ? null : max(1, (int) ($ebook->preview_pages ?: 3));
        $canDownload = $isFree;                                   // free -> download + print; paid -> print only
        $downloadUrl = $isFree ? route('ebooks.download', $ebook->id) : null;

        $ebook->increment('view_count');

        return view('website.ebooks.reader', compact(
            'ebook', 'pdfUrl', 'maxPages', 'isPreview', 'canDownload', 'downloadUrl'
        ));
    }

    /**
     * Download — allowed only for FREE eBooks (paid books are print-only).
     */
    public function download($id)
    {
        $ebook = Ebook::findOrFail($id);

        if (!$ebook->isFree()) {
            abort(403, 'This eBook is not available for download.');
        }

        if (!$ebook->file_path || !Storage::disk('public')->exists('ebook_files/' . $ebook->file_path)) {
            abort(404, 'File not found.');
        }

        $filename = ($ebook->title_en ?: 'ebook') . '.pdf';

        return Storage::disk('public')->download('ebook_files/' . $ebook->file_path, $filename);
    }

    /**
     * Free eBook listing.
     */
    public function freeIndex(Request $request)
    {
        $query = Ebook::where('active', 1)->where('status', 'approved')->where('is_free', 1);

        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        $ebooks = $query->latest()->paginate(12);
        $categories = ProductCategory::where('type', 'ebook')->where('active', 1)->get();

        return view('website.ebooks.free', compact('ebooks', 'categories'));
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

    public function preview(Request $request)
    {
        $ebook = Ebook::findOrFail($request->id);
        if (!$ebook->preview_path) {
            return response()->json(['error' => 'Preview not available for this eBook.'], 404);
        }
        return response()->json([
            'pdf_url' => asset('storage/ebook_previews/' . $ebook->preview_path),
        ]);
    }

    public function quickView(Request $request)
    {
        $ebook = Ebook::with('category')->findOrFail($request->id);
        $html = view('website.partials.ebook_quick_view', compact('ebook'))->render();
        return response()->json(['html' => $html]);
    }
}
