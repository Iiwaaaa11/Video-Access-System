<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\VideoRequest;
use App\Models\VideoAccess;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            return redirect('/dashboard')->with('error', 'Access denied. Admin only.');
        }

        // Get statistics
        $stats = [
            'totalVideos' => Video::count(),
            'pendingRequests' => VideoRequest::where('status', 'pending')->count(),
            'approvedRequests' => VideoRequest::where('status', 'approved')->count(),
            'activeAccess' => VideoAccess::where('expires_at', '>', now())->count(),
            'totalUsers' => User::count(),
            'totalCustomers' => User::where('role', 'customer')->count(),
        ];

        // Recent activities
        $recentRequests = VideoRequest::with(['user', 'video'])
                                    ->latest()
                                    ->take(5)
                                    ->get();

        return view('admin.dashboard', compact('stats', 'recentRequests'));
    }
}