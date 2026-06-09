<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CourseCategoryController extends Controller
{
    /**
     * Display a listing of course categories.
     */
    public function index(Request $request)
    {
        menuSubmenu('academy', 'courseCategoriesAll');

        $type = 'course';

        $query = ProductCategory::whereNull('parent_id')
            ->where('type', $type)
            ->with(['children' => function($query) {
                $query->withCount('products');
            }])
            ->withCount('products');

        $data['categories'] = $query->latest()->paginate(30);
        $data['activeType'] = $type;
        $data['totalCount'] = ProductCategory::whereNull('parent_id')->where('type', $type)->count();

        return view('admin.courseCategories.productCategoriesAll', $data);
    }

    /**
     * Show the form for creating a new course category.
     */
    public function create()
    {
        menuSubmenu('academy', 'courseCategoriesAll');

        $data['categories'] = ProductCategory::whereNull('parent_id')
            ->where('type', 'course')
            ->orderBy('name_en')
            ->get();
        $data['type'] = 'course';

        return view('admin.courseCategories.productCategoryCreate', $data);
    }

    /**
     * Store a newly created course category in storage.
     */
    public function store(Request $request)
    {
        menuSubmenu('academy', 'courseCategoriesAll');

        $request->validate([
            'name_en' => 'required|string|max:255',
            'type'    => 'required|in:product,course',
            'slug'    => 'required|string|unique:product_categories,slug',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $category = new ProductCategory();
        $category->type         = $request->type;
        $category->position     = $request->position ?? 0;
        $category->parent_id    = $request->parent_id;
        $category->name_en      = $request->name_en;
        $category->name_bn      = $request->name_bn ?? null;
        $category->slug         = getSlug($request->slug, $category, true);
        $category->excerpt      = $request->excerpt;
        $category->active       = $request->boolean('active');
        $category->addedby_id   = Auth::id();

        if ($request->hasFile('image')) {
            $file      = $request->file('image');
            $imageName = time() . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->put('product_categories_images/' . $imageName, File::get($file));
            $category->image = $imageName;
        }

        $category->save();
        Cache::flush();

        return redirect()->route('admin.courseCategories.index')->with('success', 'Course Category successfully created');
    }

    /**
     * Show the form for editing the specified course category.
     */
    public function edit(ProductCategory $category)
    {
        menuSubmenu('academy', 'courseCategoriesAll');

        $categories = ProductCategory::whereNull('parent_id')
            ->where('type', 'course')
            ->with(['children' => function($query) use ($category) {
                $query->where('id', '!=', $category->id);
            }])
            ->where('id', '!=', $category->id)
            ->get();

        return view('admin.courseCategories.productCategoryEdit', compact('category', 'categories'));
    }

    /**
     * Update the specified course category in storage.
     */
    public function update(Request $request, ProductCategory $category)
    {
        menuSubmenu('academy', 'courseCategoriesAll');

        $validation = Validator::make($request->all(), [
            'name_en' => 'required|string',
            'type'    => 'required|in:product,course',
            'slug'    => 'required|string|unique:product_categories,slug,' . $category->id . ',id',
        ]);

        if ($validation->fails()) {
            toast('Something went wrong!', 'error');
            return back()->withErrors($validation)->withInput();
        }

        $category->type         = $request->type;
        $category->parent_id    = $request->parent_id;
        $category->position     = $request->position;
        $category->name_en      = $request->name_en;
        $category->name_bn      = $request->name_bn;
        $category->slug         = getSlug($request->slug, $category, true);
        $category->excerpt      = $request->excerpt;
        $category->active       = $request->boolean('active');
        $category->editedby_id  = Auth::id();

        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete('product_categories_images/' . $category->image);
            }
            $file      = $request->file('image');
            $imageName = time() . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->put('product_categories_images/' . $imageName, File::get($file));
            $category->image = $imageName;
        }

        $category->save();
        Cache::flush();

        return redirect()->route('admin.courseCategories.index')->with('success', 'Course Category successfully updated');
    }

    /**
     * Remove the specified course category from storage.
     */
    public function destroy(ProductCategory $category)
    {
        if ($category->image) {
            Storage::disk('public')->delete('product_categories_images/' . $category->image);
        }
        $category->delete();
        Cache::flush();

        return redirect()->back()->with('success', 'Course Category successfully deleted');
    }

    /**
     * Toggle status via AJAX.
     */
    public function status(Request $request)
    {
        $category = ProductCategory::findOrFail($request->category);
        $category->active = !$category->active;
        $category->save();

        return response()->json([
            'success' => true,
            'active' => $category->active,
        ]);
    }
}
