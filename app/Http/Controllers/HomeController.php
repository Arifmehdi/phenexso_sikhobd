<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function Spatie\Ignition\register;

class HomeController extends Controller
{
    public function index(){
        $user = auth()->user();
        $data['activeTab'] = 'dashboard';
        $data['orders'] = \App\Models\Order::where('user_id', $user->id)->latest()->paginate(10);
        $data['todayOrdersCount'] = \App\Models\Order::where('user_id', $user->id)->whereDate('created_at', today())->count();
        $data['enrollments'] = \App\Models\Enrollment::where('user_id', $user->id)->with('product')->latest()->get();
        return view('user.dashboard', $data);
    }
}
