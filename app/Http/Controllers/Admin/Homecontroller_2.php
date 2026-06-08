<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\BisesoggoCategory;
use App\Models\BlogPost;
use App\Models\BookAppointment;
use App\Models\ContactUs;
use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\Member;
use App\Models\Order;
use App\Models\Page;
use App\Models\Product;
use App\Models\Tag;
use App\Models\User;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        menuSubmenu('dashboardM','dashboardSM');
        
        // E-Learning Stats
        $totalCourses = Product::where('type', 'course')->count();
        $totalInstructors = User::where('role', 'instructor')->orWhereHas('roles', function($q){
            $q->where('role_name', 'instructor');
        })->count();
        $totalEnrollments = \App\Models\Enrollment::count();
        $pendingEnrollments = \App\Models\Enrollment::where('status', 'pending')->count();
        
        // E-commerce Stats
        $productcount = Product::where('type', 'product')->count();
        $todayOrders = Order::whereDate('created_at', now()->today())->count();
        $pendingOrders = Order::where('order_status', 'pending')->count();
        $totalRevenue = Order::where('payment_status', 'paid')->sum('grand_total');
        
        // Trends for Chart
        $enrollmentData = [];
        $enrollmentLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $enrollmentLabels[] = $date->format('D');
            $enrollmentData[] = \App\Models\Enrollment::whereDate('created_at', $date)->count();
        }
        
        $recentEnrollments = \App\Models\Enrollment::with(['user', 'product'])->latest()->take(6)->get();
        $recentCourses = Product::where('type', 'course')->latest()->take(5)->get();
        $recentOrders = Order::latest()->take(6)->get();

        return view('admin.index', compact(
            'totalCourses', 'totalInstructors', 'totalEnrollments', 'pendingEnrollments',
            'productcount', 'todayOrders', 'pendingOrders', 'totalRevenue',
            'recentEnrollments', 'recentCourses', 'recentOrders', 'enrollmentData', 'enrollmentLabels'
        ));
    }



    public function selectTagsOrAddNew(Request $request)
    {

        $tags = Tag::where('name', 'like', '%'.$request->q.'%')
        ->select(['name'])->take(30)->get();

        if($tags->count())
        {
            if ($request->ajax())
            {
                return $tags;
            }
        }
        else
        {
            if ($request->ajax())
            {
                return $tags;
            }
        }
    }


    public function selectAuthorsOrAddNew(Request $request)
    {

        $tags =Author::where('name', 'like', '%'.$request->q.'%')
        ->select(['name'])->take(30)->get();
        if($tags->count())
        {
            if ($request->ajax())
            {
                return $tags;
            }
        }
        else
        {
            if ($request->ajax())
            {
                return $tags;
            }
        }
    }


    public function allAppointments(){
        menuSubmenu('appointments','allAppointments');
        $data['appointments'] = BookAppointment::paginate(50);
        return view('admin.appointments.index',$data);
    }


    public function deleteAppointment($id){
        $appointment = BookAppointment::find($id);
        $appointment->delete();
        return back()->with("success","Appointment Delated Successfuly");
    }


}
