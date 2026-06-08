<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\ProductCat;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    /**
     * Display a paginated list of all courses.
     *
     * @return \Illuminate\View\View
     */
    public function coursesAll(Request $request)
    {
        // Set active menu and submenu for UI highlighting
        menuSubmenu('academy', 'coursesAll');

        $query = Product::where('type', 'course')->latest();

        $data['courses'] = $query->paginate(30);
        $data['totalCount'] = Product::where('type', 'course')->count();

        // Return the courses list view with data
        return view('admin.courses.coursesAll', $data);
    }

    /**
     * Show the form for creating a new course.
     *
     * @return \Illuminate\View\View
     */
    public function courseCreate()
    {
        // Set active menu and submenu for UI highlighting
        menuSubmenu('academy', 'coursesAll');

        // Fetch latest course categories
        $data['categories'] = ProductCategory::where('type', 'course')->latest()->get();

        // Fetch paginated media items
        $data['medias'] = Media::latest()->paginate(20);

        $data['instructors'] = \App\Models\User::whereIn('role', ['instructor', 'teacher'])->where('is_approve', 1)->get();

        // Return the create course view
        return view('admin.courses.courseCreate', $data);
    }

    /**
     * Store a newly created course in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function courseStore(Request $request)
    {
        menuSubmenu('academy', 'coursesAll');

        // Validate incoming request data
        $request->validate([
            'name_en'        => 'required|string',
            'selling_price'  => 'required|numeric',
            'slug'           => 'required|string',
            'featured_image' => 'nullable|image',
            'instructor_id'  => 'nullable|exists:users,id',
        ]);

        // Initialize new course instance
        $course = new Product();
        $course->type = 'course';
        $course->name_en = $request->name_en;
        $course->name_bn = $request->name_bn ?? null;
        $course->sku = $request->sku ?? null;
        $course->stock = 1; // Default for courses

        // Generate slug
        $course->slug = getSlug($request->slug, $course, boolval($request->slug));

        $course->selling_price = $request->selling_price ?? 0.00;
        $course->purchase_price = $request->purchase_price ?? 0.00;
        $course->discount = $request->discount ?? 0.00;

        // Calculate discount price and final price
        $course->discount_price = $request->discount ?? 0.00;
        $course->final_price = $request->selling_price - $course->discount;

        $course->duration = $request->duration;
        $course->lessons_count = $request->lessons_count ?? 0;
        $course->level = $request->level;

        $course->excerpt_en = $request->excerpt_en;
        $course->excerpt_bn = $request->excerpt_bn ?? null;
        $course->description_en = $request->description_en;
        $course->description_bn = $request->description_bn ?? null;

        // Checkbox fields
        $course->feature = $request->feature ? 1 : 0;
        $course->editor = $request->editor ? 1 : 0;
        $course->active = $request->active ? 1 : 0;
        $course->instructor_id = $request->instructor_id;

        $course->addedby_id = Auth::id();

        $course->save();

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $file = $request->file('featured_image');
            $ext = '.' . $file->getClientOriginalExtension();
            $imageName = $course->id . '_' . time() . $ext;
            Storage::disk('public')->put('product_images/' . $imageName, File::get($file));
            $course->featured_image = $imageName;
            $course->save();
        }

        // Cache management
        Cache::forget('product');
        Cache::put("product_{$course->id}", $course, now()->addDays(7));

        // Handle course categories
        if ($request->categories) {
            foreach ($request->categories as $catId) {
                $productCat = new ProductCat();
                $productCat->product_category_id = $catId;
                $productCat->product_id = $course->id;
                $productCat->addedby_id = Auth::id();
                $productCat->save();
            }
        }

        return redirect()->route('admin.coursesAll')->with('success', 'Course successfully created');
    }

    /**
     * Show the form for editing the specified course.
     *
     * @param  \App\Models\Product  $course (passed as product in route)
     * @return \Illuminate\View\View
     */
    public function courseEdit(Product $course)
    {
        menuSubmenu('academy', 'coursesAll');

        $data = [
            'course'    => $course,
            'categories' => ProductCategory::where('type', 'course')->latest()->get(),
            'medias'     => Media::latest()->paginate(20),
            'instructors' => \App\Models\User::whereIn('role', ['instructor', 'teacher'])->where('is_approve', 1)->get(),
        ];

        return view('admin.courses.courseEdit', $data);
    }

    /**
     * Update the specified course in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $course
     * @return \Illuminate\Http\RedirectResponse
     */
    public function courseUpdate(Request $request, Product $course)
    {
        menuSubmenu('academy', 'coursesAll');

        // Validate incoming request data
        $request->validate([
            'name_en' => 'required|string',
            'selling_price'  => 'required|numeric',
            'slug' => 'required|string',
            'featured_image' => 'nullable|image',
            'instructor_id' => 'nullable|exists:users,id',
        ]);

        // Update attributes
        $course->name_en = $request->name_en;
        $course->name_bn = $request->name_bn ?? null;
        $course->sku = $request->sku ?? null;
        $course->slug = getSlug($request->slug, $course, boolval($request->slug));
        $course->purchase_price = $request->purchase_price ?? null;
        $course->selling_price = $request->selling_price ?? null;
        $course->discount = $request->discount ?? 0.00;
        $course->discount_price = $request->discount ?? 0.00;
        $course->final_price = ($course->selling_price ?: $course->price) - $course->discount;

        $course->duration = $request->duration;
        $course->lessons_count = $request->lessons_count ?? 0;
        $course->level = $request->level;

        $course->excerpt_en = $request->excerpt_en;
        $course->excerpt_bn = $request->excerpt_bn ?? null;
        $course->description_en = $request->description_en;
        $course->description_bn = $request->description_bn ?? null;
        $course->feature = $request->feature ? 1 : 0;
        $course->editor = $request->editor ? 1 : 0;
        $course->active = $request->active ? 1 : 0;
        $course->instructor_id = $request->instructor_id;

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            if ($course->featured_image) {
                Storage::disk('public')->delete('product_images/' . $course->featured_image);
            }
            
            $file = $request->file('featured_image');
            $ext = '.' . $file->getClientOriginalExtension();
            $imageName = $course->id . '_' . time() . $ext;
            Storage::disk('public')->put('product_images/' . $imageName, File::get($file));
            $course->featured_image = $imageName;
        }

        $course->save();

        // Clear and update cache
        Cache::forget('product');
        Cache::put("product_{$course->id}", $course, now()->addDays(30));

        // Detach and attach categories
        $course->categories()->detach();

        if ($request->categories) {
            foreach ($request->categories as $cat) {
                $c = new ProductCat;
                $c->product_category_id = $cat;
                $c->product_id = $course->id;
                $c->addedby_id = Auth::id();
                $c->save();
            }
        }

        return redirect()->back()->with('success', 'Course successfully updated');
    }

    /**
     * Delete the specified course from storage.
     *
     * @param  \App\Models\Product  $course
     * @return \Illuminate\Http\RedirectResponse
     */
    public function courseDelete(Product $course)
    {
        menuSubmenu('academy', 'coursesAll');

        if ($course->featured_image) {
            Storage::disk('public')->delete('product_images/' . $course->featured_image);
        }

        $course->delete();

        Cache::forget("product_{$course->id}");

        return redirect()->back()->with('success', 'Course successfully deleted');
    }

    /**
     * Search courses.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function courseSearch(Request $request)
    {
        $q = $request->q;

        $courses = Product::where('type', 'course')
            ->where(function ($qq) use ($q) {
                $qq->orWhere('name_en', 'like', "%{$q}%")
                    ->orWhere('name_bn', 'like', "%{$q}%")
                    ->orWhere('sku', 'like', "%{$q}%")
                    ->orWhere('id', 'like', "%{$q}%");
            })
            ->orderBy('name_en')
            ->paginate(100);

        $courses->appends($request->all());

        $page = View('admin.courses.searchData', ['courses' => $courses])->render();

        return response()->json([
            'success' => true,
            'page' => $page,
        ]);
    }
}
