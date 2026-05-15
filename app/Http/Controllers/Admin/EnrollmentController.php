<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index(Request $request)
    {
        menuSubmenu('elearning', 'enrollments');

        $query = Enrollment::with(['user', 'product', 'order'])->latest();

        if ($request->search) {
            $q = $request->search;
            $query->whereHas('user', function($query) use ($q) {
                $query->where('name', 'like', "%$q%")->orWhere('mobile', 'like', "%$q%");
            })->orWhereHas('product', function($query) use ($q) {
                $query->where('name_en', 'like', "%$q%");
            });
        }

        $enrollments = $query->paginate(30);

        return view('admin.enrollments.index', compact('enrollments'));
    }

    public function updateStatus(Request $request, Enrollment $enrollment)
    {
        $request->validate([
            'status' => 'required|in:active,completed,expired,pending',
        ]);

        $enrollment->update([
            'status' => $request->status,
            'enrolled_at' => ($request->status == 'active' && !$enrollment->enrolled_at) ? now() : $enrollment->enrolled_at,
        ]);

        return back()->with('success', 'Enrollment status updated successfully.');
    }

    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();
        return back()->with('success', 'Enrollment deleted successfully.');
    }
}
