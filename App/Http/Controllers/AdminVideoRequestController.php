<?php

namespace App\Http\Controllers;

use App\Models\VideoRequest;
use App\Models\VideoAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AdminVideoRequestController extends Controller
{
    /**
     * Display all video requests
     */
    public function index()
    {
        // Only for admin
        if (auth()->user()->role !== 'admin') {
            return redirect('/dashboard')->with('error', 'Access denied.');
        }

        $pendingRequests = VideoRequest::with(['user', 'video'])
                                    ->where('status', 'pending')
                                    ->latest()
                                    ->get();

        $approvedRequests = VideoRequest::with(['user', 'video'])
                                      ->where('status', 'approved')
                                      ->latest()
                                      ->get();

        $rejectedRequests = VideoRequest::with(['user', 'video'])
                                      ->where('status', 'rejected')
                                      ->latest()
                                      ->get();

        return view('admin.requests.index', compact('pendingRequests', 'approvedRequests', 'rejectedRequests'));
    }

    /**
     * Approve video request with time limit
     */
    public function approve(Request $request, VideoRequest $videoRequest)
    {
        // Only for admin
        if (auth()->user()->role !== 'admin') {
            return redirect('/dashboard')->with('error', 'Access denied.');
        }

        $request->validate([
            'hours' => 'required|integer|min:1|max:720', // Max 30 days
            'admin_notes' => 'nullable|string|max:500',
        ]);

        // Update the request status
        $videoRequest->update([
            'status' => 'approved',
            'admin_notes' => $request->admin_notes,
        ]);

        // Calculate expiration time
        $expiresAt = Carbon::now()->addHours($request->hours);

        // Create video access record
        VideoAccess::create([
            'user_id' => $videoRequest->user_id,
            'video_id' => $videoRequest->video_id,
            'video_request_id' => $videoRequest->id,
            'expires_at' => $expiresAt,
        ]);

        return redirect()->route('admin.requests.index')->with('success', 'Video access approved for ' . $request->hours . ' hours.');
    }

    /**
     * Reject video request
     */
    public function reject(Request $request, VideoRequest $videoRequest)
    {
        // Only for admin
        if (auth()->user()->role !== 'admin') {
            return redirect('/dashboard')->with('error', 'Access denied.');
        }

        $request->validate([
            'admin_notes' => 'required|string|max:500',
        ]);

        $videoRequest->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->route('admin.requests.index')->with('success', 'Video request rejected.');
    }

    /**
     * Revoke access (delete video access)
     */
    public function revokeAccess(VideoAccess $videoAccess)
    {
        // Only for admin
        if (auth()->user()->role !== 'admin') {
            return redirect('/dashboard')->with('error', 'Access denied.');
        }

        $videoAccess->delete();

        return redirect()->route('admin.requests.index')->with('success', 'Video access revoked.');
    }
}