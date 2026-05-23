<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseSection;
use App\Models\Product;
use Illuminate\Http\Request;

class CourseSectionController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'priority' => 'nullable|integer',
        ]);

        CourseSection::create([
            'product_id' => $product->id,
            'title_en' => $request->title_en,
            'title_bn' => $request->title_bn,
            'priority' => $request->priority ?? 0,
            'active' => true,
        ]);

        return back()->with('success', 'Section added successfully.');
    }

    public function update(Request $request, CourseSection $section)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'priority' => 'nullable|integer',
        ]);

        $section->update([
            'title_en' => $request->title_en,
            'title_bn' => $request->title_bn,
            'priority' => $request->priority ?? 0,
        ]);

        return back()->with('success', 'Section updated successfully.');
    }

    public function destroy(CourseSection $section)
    {
        $section->delete();
        return back()->with('success', 'Section deleted successfully.');
    }
}
