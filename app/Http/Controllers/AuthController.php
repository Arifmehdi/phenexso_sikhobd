<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\IdCard;
use App\Models\Role;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use PDF; 

use Session;
class AuthController extends Controller
{
    /**
     * Redirect the user to the social provider's authentication page.
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from the social provider.
     */
    public function handleProviderCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Something went wrong while logging in with ' . ucfirst($provider));
        }

        // Check if user already exists with this provider_id
        $user = User::where('provider', $provider)
                    ->where('provider_id', $socialUser->getId())
                    ->first();

        if (!$user) {
            // Check if user exists with the same email
            $user = User::where('email', $socialUser->getEmail())->first();

            if ($user) {
                // Update existing user with provider details
                $user->update([
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId(),
                ]);
            } else {
                // Create new user
                $user = User::create([
                    'name' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId(),
                    'password' => Hash::make(rand(100000, 999999)), // Dummy password
                    'role' => 'buyer',
                    'is_approve' => 1, // Auto approve social login users? Or keep 0? Usually 1 for social.
                ]);
                
                // Assign role if needed (the roles table seems to be used)
                $user->roles()->create([
                    'role_name' => 'buyer'
                ]);
            }
        }

        Auth::login($user, true);
        $this->cartSessionToUser();

        return redirect()->route('user.dashboard')->with('success', 'Logged in successfully with ' . ucfirst($provider));
    }

    public function index(){
        if(Auth::check()){
            if(Auth::user()->hasRole('admin') || Auth::user()->role === 'admin'){
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('user.dashboard');
        }
        return view('auth.login');
    }



   
     /**
     * Handle User Login
     */
    public function login(Request $request)
    {
        // Redirect if already logged in
        if (Auth::check()) {
            return redirect()->route('user.dashboard');
        }

        // Validate request
        $request->validate([
            'email'    => 'required|string|email',
            'password' => 'required|string',
        ], [
            'email.required'    => 'Email is required',
            'password.required' => 'Password is required',
        ]);

        $credentials = $request->only('email', 'password');

        // Attempt login
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();

            // Check if user is approved
            if (!$user->is_approve && !$user->hasRole('admin')) {
                Auth::logout();
                return back()->with('error', 'Your account is pending approval from the administrator. Please wait for approval.');
            }

            // Merge session cart to user cart
            $this->cartSessionToUser();

            // Redirect based on role: admin -> admin dashboard, everyone else -> user dashboard
            if ($user->hasRole('admin') || $user->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Signed in successfully');
            }

            return redirect()->route('user.dashboard')->with('success', 'Signed in successfully');
        }

        // Failed login
        return back()->withInput($request->only('email'))
                    ->with('error', 'Login details are not valid');
    }



    public function registerPage(){
        if(Auth::check()){
            return redirect()->route('user.dashboard');;
        }
        else{
            return view('auth.registration');
        }

    }

    public function registration(){ 

        if(Auth::check()){
            return redirect()->route('user.dashboard');;
        }
        else{
            return view('auth.main-register');
        }
    }

    public function healthCard(){ 
        return view('auth.health-register');
    }



  
    // old register for create table 
    // public function register(Request $request)
    // {
    //     $request->validate([
    //         'name'               => 'required|string|max:255',
    //         'father_name'        => 'required|string|max:255',
    //         'present_address'    => 'required|string|max:500',
    //         'permanent_address'  => 'required|string|max:500',
    //         'ssc_passing'        => 'required|string|max:50',
    //         'ssc_registration'   => 'required|string|max:50',
    //         'reg_date'           => 'required|date',
    //         'tin_number'         => 'nullable',
    //         'bkash_number'       => 'nullable',
    //         'health_history'     => 'nullable',
    //         'nid'                => 'required|string|max:100',
    //         'mobile'             => 'required|unique:users,mobile',
    //         'dob'                => 'required|date',
    //         'blood_group'        => 'required|string|max:10',
    //         'image'              => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
    //         'email'              => 'required|email|unique:users,email',
    //         'password'           => 'required|string|min:8',
    //     ]);

    //     // Handle Image Upload
    //      $photoPath = null;
    //     if ($request->hasFile('image')) {
    //         $file = $request->file('image');
    //         $imageName = time() . '.' . $file->getClientOriginalExtension();
    //         Storage::disk('public')->put('users/' . $imageName, File::get($file));
    //         $photoPath = $imageName;
    //     }

    //     // Create user
    //     $user = User::create([
    //         'name'               => $request->name,
    //         'father_name'        => $request->father_name,
    //         'address'            => $request->present_address,
    //         'present_address'    => $request->present_address,
    //         'permanent_address'  => $request->permanent_address,
    //         'reg_date'           => $request->reg_date,
    //         'tin_number'         => $request->tin_number,
    //         'health_history'     => $request->health_history,
    //         'nid'                => $request->nid,
    //         'mobile'             => $request->mobile,
    //         'bkash_number'       => $request->bkash_number,
    //         'ssc_passing'        => $request->ssc_passing,
    //         'ssc_registration'   => $request->ssc_registration,
    //         'dob'                => $request->dob,
    //         'blood_group'        => $request->blood_group,
    //         'image'              => $photoPath,
    //         'email'              => $request->email,
    //         'password'           => Hash::make($request->password),
    //     ]);

    //     // Auto login
    //     Auth::login($user);

    //     // Merge session cart
    //     $this->cartSessionToUser();

    //     // ID Card generation
    //     $idcardData = ['user' => $user];
    //     $filename = "idcard_{$user->id}_" . time() . ".pdf";



    //    $pdf = PDF::loadView('idcard', compact('idcardData'))
    //     // ->setPaper([0, 0, 350, 500], 'portrait') 
    //     ->setOptions([
    //         'isHtml5ParserEnabled' => true,
    //         'isRemoteEnabled' => true,
    //         'defaultFont' => 'sans-serif',
    //         'dpi' => 96,
    //         'background' => false, // transparent background
    //         'margin-top' => 0,
    //         'margin-right' => 0,
    //         'margin-bottom' => 0,
    //         'margin-left' => 0,
    //     ]);
      

    //     Storage::disk('public')->put("idcards/{$filename}", $pdf->output());

    //     IdCard::create([
    //         'user_id' => $user->id,
    //         'issued_at' => $user->reg_date,
    //         'file_name' => "idcards/{$filename}",
    //     ]);

    //     // Redirect
    //     return redirect()->route('user.dashboard')
    //                     ->with('success', 'Registration successful! Welcome, ' . $user->name);
    // }

    public function register(Request $request)
    {
        $request->validate([
            'name'               => 'required|string|max:255',
            'father_name'        => 'required|string|max:255',
            'present_address'    => 'required|string|max:500',
            'permanent_address'  => 'required|string|max:500',
            'ssc_passing'        => 'required|string|max:50',
            'ssc_registration'   => 'required|string|max:50',
            'reg_date'           => 'required|date',
            'tin_number'         => 'nullable',
            'bkash_number'       => 'nullable',
            'health_history'     => 'nullable',
            'nid'                => 'required|string|max:100',
            'mobile'             => 'required|unique:users,mobile',
            'dob'                => 'required|date',
            'blood_group'        => 'required|string|max:10',
            'image'              => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'role'              => 'required|in:rider,seller,buyer',
            // 'email'              => 'required|email|unique:users,email',
            // 'password'           => 'required|string|min:8',
        ]);
        // Handle Image Upload
         $photoPath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->put('users/' . $imageName, File::get($file));
            $photoPath = $imageName;
        }

        $user = User::findOrFail(Auth::id());

        // Update user
        $user->update([
            'name'               => $request->name,
            'father_name'        => $request->father_name,
            'address'            => $request->present_address,
            'present_address'    => $request->present_address,
            'permanent_address'  => $request->permanent_address,
            'reg_date'           => $request->reg_date,
            'tin_number'         => $request->tin_number,
            'health_history'     => $request->health_history,
            'nid'                => $request->nid,
            'mobile'             => $request->mobile,
            'bkash_number'       => $request->bkash_number,
            'ssc_passing'        => $request->ssc_passing,
            'ssc_registration'   => $request->ssc_registration,
            'dob'                => $request->dob,
            'blood_group'        => $request->blood_group,
            'image'              => $photoPath,
            // 'email'              => $request->email, // optional
            // 'password'           => Hash::make($request->password), // optional
        ]);

        // Auto login
        // Auth::login($user);

        // Merge session cart
        $this->cartSessionToUser();

        // ID Card generation
        $idcardData = ['user' => $user];
        $filename = "idcard_{$user->id}_" . time() . ".pdf";



       $pdf = PDF::loadView('idcard', compact('idcardData'))
        // ->setPaper([0, 0, 350, 500], 'portrait') 
        ->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultFont' => 'sans-serif',
            'dpi' => 96,
            'background' => false, // transparent background
            'margin-top' => 0,
            'margin-right' => 0,
            'margin-bottom' => 0,
            'margin-left' => 0,
        ]);
      

        Storage::disk('public')->put("idcards/{$filename}", $pdf->output());

        IdCard::updateOrCreate(
            ['user_id' => $user->id], // search condition
            [
                'issued_at' => $user->reg_date,
                'file_name' => "idcards/{$filename}",
            ]
        );

        // Redirect
        return redirect()->route('user.dashboard')
                        ->with('success', 'Registration successful! Welcome, ' . $user->name);
    }

    public function mainRegister(Request $request)
    {

        $request->validate([
            'name'               => 'required|string|max:255',
            'email'              => 'required|email|unique:users,email',
            'password'           => 'required|string|min:8|confirmed',
            'role'               => 'nullable|in:rider,seller,buyer',
        ]);

        $user = User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role'       => $request->role ?? 'buyer',
            'is_approve' => 1,
        ]);

        // Merge session cart
        $this->cartSessionToUser();

        // Redirect
        return redirect()->route('login')
                        ->with('success', 'Registration successful! ');
    }




    /**
     * Move session cart items to logged-in user
     */
    private function cartSessionToUser()
    {
        $session_id = Session::get('session_id');
        if ($session_id && Auth::check()) {
            Cart::where('session_id', $session_id)
                ->update(['user_id' => Auth::id(), 'session_id' => null]);
        }
    }



    public function dashboard(Request $request)
    {
        $user = Auth::user();
        $todayOrdersCount = $user->orders()->whereDate('created_at', now()->toDateString())->count();
        $cancelOrdersCount = $user->orders()->where('order_status', 'cancelled')->count();
        $orders = $user->orders()->latest()->paginate(30);
        $featured_products = \App\Models\Product::where('feature', 1)->where('active',1)->latest()->paginate(12);
        $stockRequests = \App\Models\ProductStockRequest::where('user_id', Auth::id())->latest()->paginate(20); // Initialize
        $products = \App\Models\Product::all(); // Add this line
        $enrollments = \App\Models\Enrollment::where('user_id', $user->id)
            ->with(['product' => function ($q) {
                $q->with('instructor')->withCount(['lessons' => function ($lq) {
                    $lq->where('active', 1);
                }]);
            }])
            ->latest()->get();

        // Product-wise items for the student's orders (for the "Product-wise" view)
        $orderItems = \App\Models\OrderItem::where('user_id', $user->id)->with('order')->latest()->get();

        // Course completion progress + existing certificates (product_id => certificate id)
        $courseProgress = [];
        foreach ($enrollments as $e) {
            if ($e->product && $e->product->type === 'course') {
                $courseProgress[$e->product_id] = $e->product->completionPercentForUser($user->id);
            }
        }
        $userCertificates = \App\Models\Certificate::where('user_id', $user->id)->pluck('id', 'product_id');

        $now = \Carbon\Carbon::now();
        $user_id = Auth::id();
        
        $examsQuery = \App\Models\Exam::where('status', '!=', 'draft');
        
        if (!$user->hasRole('admin') && $user->role !== 'admin') {
            // Exams assigned directly, via an enrolled course, or fully public.
            $examsQuery->visibleToStudent($user_id);
        }
        
        $exams = $examsQuery->latest()->get();
            
        $completed_exams = \App\Models\ExamAttempt::where('user_id', $user_id)
            ->where('status', 'completed')
            ->with('exam')
            ->get();

        $activeTab = $request->activeTab ?? 'dashboard'; 

        $teacher_questions_count = 0;
        $teacher_exams_count = 0;
        $teacher_questions = collect();
        $teacher_exams = collect();
        if ($user->hasRole('instructor') || $user->role === 'instructor' || $user->hasRole('teacher') || $user->role === 'teacher') {
            $teacher_questions = \App\Models\Question::where('created_by', $user->id)->latest()->paginate(20, ['*'], 'questions_page');
            $teacher_exams = \App\Models\Exam::where('created_by', $user->id)->latest()->paginate(20, ['*'], 'exams_page');
            $teacher_questions_count = \App\Models\Question::where('created_by', $user->id)->count();
            $teacher_exams_count = \App\Models\Exam::where('created_by', $user->id)->count();
        }

        return view('user.dashboard', compact('user', 'todayOrdersCount', 'cancelOrdersCount', 'orders', 'orderItems', 'activeTab','featured_products', 'stockRequests', 'products', 'enrollments', 'courseProgress', 'userCertificates', 'exams', 'completed_exams', 'teacher_questions_count', 'teacher_exams_count', 'teacher_questions', 'teacher_exams'));
    }

    public function orders(Request $request)
    {
        $user = Auth::user();
        $query = $user->orders();

        $type = $request->type;
        switch ($type) {
            case 'today':
                $query->whereDate('created_at', now()->toDateString());
                break;
            case 'cancelled':
                $query->where('order_status', 'cancelled');
                break;
        }

        $orders = $query->latest()->paginate(30);
        $todayOrdersCount = $user->orders()->whereDate('created_at', now()->toDateString())->count();
        $cancelOrdersCount = $user->orders()->where('order_status', 'cancelled')->count();
        $featured_products = \App\Models\Product::where('feature', 1)->where('active',1)->latest()->paginate(12); // Ensure it's always passed
        $stockRequests = \App\Models\ProductStockRequest::where('user_id', Auth::id())->latest()->paginate(20); // Ensure it's always passed
        $products = \App\Models\Product::all(); // Add this line
        $enrollments = \App\Models\Enrollment::where('user_id', $user->id)->with('product')->latest()->get();

        $activeTab = 'order'; 

        return view('user.dashboard', compact('user', 'todayOrdersCount', 'cancelOrdersCount', 'orders', 'activeTab', 'type','featured_products', 'stockRequests', 'products', 'enrollments'));

    }
    
    public function editMyInformation()
    {
        $user = Auth::user();
        $todayOrdersCount = $user->orders()->whereDate('created_at', now()->toDateString())->count();
        $cancelOrdersCount = $user->orders()->where('order_status', 'cancelled')->count();
        $orders = $user->orders()->latest()->paginate(30);
        $featured_products = \App\Models\Product::where('feature', 1)->where('active',1)->latest()->paginate(12);
        $stockRequests = \App\Models\ProductStockRequest::where('user_id', Auth::id())->latest()->paginate(20); // Initialize
        $products = \App\Models\Product::all(); // Add this line
        $enrollments = \App\Models\Enrollment::where('user_id', $user->id)->with('product')->latest()->get();

        $activeTab = 'edit'; 

        return view('user.dashboard', compact('user', 'todayOrdersCount', 'cancelOrdersCount', 'orders', 'activeTab', 'featured_products', 'stockRequests', 'products', 'enrollments'));
    }

    public function idcard()
    {
        $user = Auth::user();
        $todayOrdersCount = $user->orders()->whereDate('created_at', now()->toDateString())->count();
        $cancelOrdersCount = $user->orders()->where('order_status', 'cancelled')->count();
        $orders = $user->orders()->latest()->paginate(30);
        $enrollments = \App\Models\Enrollment::where('user_id', $user->id)->with('product')->latest()->get();

        $activeTab = 'edit'; 

        return view('user.idcard', compact('user', 'todayOrdersCount', 'cancelOrdersCount', 'orders', 'activeTab', 'enrollments'));
    }

    public function featureProducts()
    {
        $user = Auth::user();
        $todayOrdersCount = $user->orders()->whereDate('created_at', now()->toDateString())->count();
        $cancelOrdersCount = $user->orders()->where('order_status', 'cancelled')->count();
        $orders = $user->orders()->latest()->paginate(30);
        $featured_products = Product::where('feature', 1)->where('active',1)->latest()->paginate(12);
        $stockRequests = \App\Models\ProductStockRequest::where('user_id', Auth::id())->latest()->paginate(20); // Initialize
        $products = \App\Models\Product::all(); // Add this line
        $enrollments = \App\Models\Enrollment::where('user_id', $user->id)->with('product')->latest()->get();

        $activeTab = 'feature_products'; 

        return view('user.dashboard', compact('user', 'todayOrdersCount', 'cancelOrdersCount', 'orders', 'activeTab', 'featured_products', 'stockRequests', 'products', 'enrollments'));
    }

    public function stockRequests()
    {
        $user = Auth::user();
        $orders = $user->orders()->latest()->paginate(30);
        $todayOrdersCount = $user->orders()->whereDate('created_at', now()->toDateString())->count();
        $cancelOrdersCount = $user->orders()->where('order_status', 'cancelled')->count();
        $featured_products = collect(); // Initialize as empty collection
        $products = \App\Models\Product::all(); // Add this line
        $enrollments = \App\Models\Enrollment::where('user_id', $user->id)->with('product')->latest()->get();

        $stockRequests = \App\Models\ProductStockRequest::with('product')->where('user_id', Auth::id())->latest()->paginate(20);

        $activeTab = 'stock_requests'; 

        return view('user.dashboard', compact('user', 'todayOrdersCount', 'cancelOrdersCount', 'orders', 'activeTab', 'stockRequests', 'featured_products', 'products', 'enrollments'));
    }
    
    // public function createStockRequestForm()
    // {
    //     $user = Auth::user();
    //     $todayOrdersCount = $user->orders()->whereDate('created_at', now()->toDateString())->count();
    //     $cancelOrdersCount = $user->orders()->where('order_status', 'cancelled')->count();
    //     $orders = $user->orders()->latest()->paginate(30);
    //     $featured_products = collect(); // Initialize as empty collection
    //     $stockRequests = collect(); // Initialize as empty collection

    //     $products = \App\Models\Product::all(); // Products needed for the form

    //     $activeTab = 'create_stock_request'; 

    //     return view('user.dashboard', compact('user', 'todayOrdersCount', 'cancelOrdersCount', 'orders', 'activeTab', 'featured_products', 'stockRequests', 'products'));
    // }

    public function createStockRequestForm()
    {
        $user = Auth::user();
        $todayOrdersCount = $user->orders()->whereDate('created_at', now()->toDateString())->count();
        $cancelOrdersCount = $user->orders()->where('order_status', 'cancelled')->count();
        $orders = $user->orders()->latest()->paginate(30);
        $featured_products = collect(); // Initialize as empty collection
        $stockRequests = \App\Models\ProductStockRequest::with('product')->where('user_id', Auth::id())->latest()->paginate(20); // Initialize as empty collection

        $products = \App\Models\Product::all(); // Products needed for the form
        $enrollments = \App\Models\Enrollment::where('user_id', $user->id)->with('product')->latest()->get();

        $activeTab = 'create_stock_request'; 

        return view('user.dashboard', compact('user', 'todayOrdersCount', 'cancelOrdersCount', 'orders', 'activeTab', 'featured_products', 'stockRequests', 'products', 'enrollments'));
    }


    public function changeMyInformation(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name'   => 'required|string|max:255',
            'mobile' => 'required|unique:users,mobile,' . $user->id,
            'image'  => 'nullable|image|max:2048',
            'address'      => 'nullable|string|max:500',
            'father_name'  => 'nullable|string',
            'reg_date'     => 'nullable|date',
            'bkash_number' => 'nullable|string|max:20',
            'dob'          => 'nullable|date',
            'blood_group'  => 'nullable|string|max:10',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error', 'Validation failed. Please check the form.');
        }

        // Update basic info
        $user->name   = $request->name;
        $user->mobile = $request->mobile;
        $user->father_name   = $request->father_name;
        $user->bkash_number   = $request->bkash_number;
        $user->address  = $request->address;
        $user->reg_date = $request->reg_date;
        $user->dob  = $request->dob;
        $user->blood_group = $request->blood_group;

        // Handle Image Upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '.' . $file->getClientOriginalExtension();
            
            // storeAs is cleaner and handles the move correctly
            $file->storeAs('users', $imageName, 'public');
            
            // Delete old image if exists
            if ($user->image && Storage::disk('public')->exists('users/' . $user->image)) {
                Storage::disk('public')->delete('users/' . $user->image);
            }
            
            $user->image = $imageName;
        }

        // Password update only if filled
        if ($request->filled('old_password') || $request->filled('new_password') || $request->filled('confirm_password')) {
            if (!Hash::check($request->old_password, $user->password)) {
                return back()->with('error', 'Current password is incorrect!')->withInput();
            }

            if ($request->new_password !== $request->confirm_password) {
                return back()->with('error', 'New password and confirmation do not match!')->withInput();
            }

            if (Hash::check($request->new_password, $user->password)) {
                return back()->with('error', 'New password cannot be the same as the old password!')->withInput();
            }

            // Set new password
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }


    public function uploadProfileImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $user = Auth::user();

        $file = $request->file('image');
        $imageName  = time() . '.' . $file->getClientOriginalExtension();
        Storage::disk('public')->put('users/' . $imageName, File::get($file));
        $user->image = $imageName;

        $user->save();

        return response()->json(['success' => true, 'image' => $imageName]);
    }


    public function idcardPdf()
    {
        $user = Auth::user();
        $pdf = PDF::loadView('user.idcard_pdf', compact('user'));
        return $pdf->stream('idcard.pdf');
    }


    
    public function logOut(){
        Session::flush();
        Auth::user()->carts()->delete();
        Auth::logout();
        return redirect('/');
    }

    
}
