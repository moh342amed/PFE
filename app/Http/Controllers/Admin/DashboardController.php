<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Summary Stats
        $stats = [
            'total_events' => Event::count(),
            'total_registrations' => Registration::count(),
            'pending_requests' => Registration::where('status', 'pending')->count(),
            'active_users' => User::count(),
        ];

        // Registration Trends (Last 7 Days)
        $days = [];
        $counts = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $days[] = $date->format('D, d M');
            
            $count = Registration::whereDate('created_at', $date->toDateString())->count();
            $counts[] = $count;
        }

        $trends = [
            'labels' => $days,
            'data' => $counts,
        ];

        // Popular Events
        $popularEvents = Event::withCount('registrations')
            ->orderBy('registrations_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'trends', 'popularEvents'));
    }
}
