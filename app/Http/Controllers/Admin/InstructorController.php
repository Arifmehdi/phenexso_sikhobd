<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class InstructorController extends Controller
{
    /**
     * Display a listing of instructors.
     */
    public function index(Request $request)
    {
        menuSubmenu('instructors', 'allInstructors');

        $query = User::whereIn('role', ['instructor', 'teacher']);

        if ($request->id) {
            $query->where('id', $request->id);
        }

        if ($request->status === 'approved') {
            $query->where('is_approve', 1);
        } elseif ($request->status === 'pending') {
            $query->where('is_approve', 0);
        }

        if ($request->q) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('mobile', 'LIKE', "%{$search}%");
            });
        }

        $data['instructors'] = $query->latest()->paginate(50);
        $data['totalCount'] = User::whereIn('role', ['instructor', 'teacher'])->count();
        $data['approvedCount'] = User::whereIn('role', ['instructor', 'teacher'])->where('is_approve', 1)->count();
        $data['pendingCount'] = User::whereIn('role', ['instructor', 'teacher'])->where('is_approve', 0)->count();

        return view('admin.instructors.index', $data);
    }

    /**
     * Show the form for creating a new instructor.
     */
    public function create()
    {
        menuSubmenu('instructors', 'createInstructor');
        return view('admin.instructors.create');
    }

    /**
     * Store a newly created instructor in storage.
     */
    public function store(Request $request)
    {
        menuSubmenu('instructors', 'createInstructor');

        $this->validate($request, [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'mobile'   => 'nullable|string|max:20',
            'password' => 'required|min:6',
            'is_approve' => 'nullable|in:0,1',
        ]);

        $user = new User;
        $user->name       = $request->name;
        $user->email      = $request->email;
        $user->mobile     = $request->mobile;
        $user->role       = 'instructor';
        $user->is_approve = $request->is_approve ?? 0;
        $user->password   = Hash::make($request->password);
        $user->save();

        return redirect()->route('admin.instructors.index')
            ->with('success', 'Instructor created successfully.');
    }

    /**
     * Show the form for editing the specified instructor.
     */
    public function edit($id)
    {
        menuSubmenu('instructors', 'allInstructors');

        $data['instructor'] = User::whereIn('role', ['instructor', 'teacher'])->findOrFail($id);
        return view('admin.instructors.edit', $data);
    }

    /**
     * Update the specified instructor in storage.
     */
    public function update(Request $request, $id)
    {
        menuSubmenu('instructors', 'allInstructors');

        $instructor = User::whereIn('role', ['instructor', 'teacher'])->findOrFail($id);

        $this->validate($request, [
            'name'       => 'required|string|max:255',
            'email'      => Rule::unique('users', 'email')->ignore($id),
            'mobile'     => 'nullable|string|max:20',
            'is_approve' => 'nullable|in:0,1',
        ]);

        $instructor->name       = $request->name;
        $instructor->email      = $request->email;
        $instructor->mobile     = $request->mobile;
        $instructor->is_approve = $request->is_approve ?? 0;

        if ($request->filled('password')) {
            $this->validate($request, ['password' => 'min:6']);
            $instructor->password = Hash::make($request->password);
        }

        $instructor->save();

        return redirect()->route('admin.instructors.index')
            ->with('success', 'Instructor updated successfully.');
    }

    /**
     * Remove the specified instructor from storage.
     */
    public function destroy($id)
    {
        $instructor = User::whereIn('role', ['instructor', 'teacher'])->findOrFail($id);
        $instructor->delete();

        return redirect()->route('admin.instructors.index')
            ->with('success', 'Instructor deleted successfully.');
    }

    /**
     * Toggle instructor approval status.
     */
    public function toggleApproval(User $user)
    {
        if (!in_array($user->role, ['instructor', 'teacher'])) {
            return back()->with('error', 'User is not an instructor.');
        }

        $user->is_approve = !$user->is_approve;
        $user->save();

        return back()->with('success', 'Instructor approval status updated successfully.');
    }

    /**
     * AJAX search for instructors.
     */
    public function search(Request $request)
    {
        $query = User::whereIn('role', ['instructor', 'teacher']);

        if ($request->status === 'approved') {
            $query->where('is_approve', 1);
        } elseif ($request->status === 'pending') {
            $query->where('is_approve', 0);
        }

        if ($request->q) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('mobile', 'LIKE', "%{$search}%");
            });
        }

        $instructors = $query->latest()->paginate(50);

        $html = view('admin.instructors.search_data', compact('instructors'))->render();

        return response()->json(['success' => true, 'html' => $html]);
    }
}
