<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisitorLog;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function index(Request $request)
    {
        menuSubmenu('visitorsM', 'visitorsList');

        $query = VisitorLog::query();

        if ($request->filled('ip')) {
            $query->where('ip_address', 'like', '%' . $request->ip . '%');
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        if ($request->filled('device')) {
            $query->where('device_type', $request->device);
        }
        if ($request->filled('browser')) {
            $query->where('browser', $request->browser);
        }

        $logs = $query->latest()->paginate(50)->withQueryString();

        // Stats
        $totalVisits     = VisitorLog::count();
        $todayVisits     = VisitorLog::whereDate('created_at', today())->count();
        $uniqueIPs       = VisitorLog::distinct('ip_address')->count('ip_address');
        $todayUniqueIPs  = VisitorLog::whereDate('created_at', today())->distinct('ip_address')->count('ip_address');

        $browserStats = VisitorLog::selectRaw('browser, count(*) as total')
            ->groupBy('browser')->orderByDesc('total')->get();

        $deviceStats = VisitorLog::selectRaw('device_type, count(*) as total')
            ->groupBy('device_type')->orderByDesc('total')->get();

        $dailyStats = VisitorLog::selectRaw('DATE(created_at) as date, count(*) as total')
            ->where('created_at', '>=', now()->subDays(14))
            ->groupBy('date')->orderBy('date')->get();

        $topPages = VisitorLog::selectRaw('url, count(*) as total')
            ->groupBy('url')->orderByDesc('total')->limit(10)->get();

        $topIPs = VisitorLog::selectRaw('ip_address, count(*) as total, MAX(created_at) as last_seen')
            ->groupBy('ip_address')->orderByDesc('total')->limit(10)->get();

        return view('admin.visitors.index', compact(
            'logs', 'totalVisits', 'todayVisits', 'uniqueIPs', 'todayUniqueIPs',
            'browserStats', 'deviceStats', 'dailyStats', 'topPages', 'topIPs'
        ));
    }

    public function ipDetail(Request $request, string $ip)
    {
        menuSubmenu('visitorsM', 'visitorsList');

        $logs = VisitorLog::where('ip_address', $ip)->latest()->paginate(30);
        $firstSeen = VisitorLog::where('ip_address', $ip)->min('created_at');
        $lastSeen  = VisitorLog::where('ip_address', $ip)->max('created_at');
        $totalHits = VisitorLog::where('ip_address', $ip)->count();

        return view('admin.visitors.ip_detail', compact('ip', 'logs', 'firstSeen', 'lastSeen', 'totalHits'));
    }

    public function clearOld(Request $request)
    {
        $days = max(1, (int) $request->input('days', 30));
        VisitorLog::where('created_at', '<', now()->subDays($days))->delete();
        return back()->with('success', "Visitor logs older than {$days} days cleared.");
    }
}
