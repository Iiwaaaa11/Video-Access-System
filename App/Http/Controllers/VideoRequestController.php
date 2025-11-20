<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\VideoRequest;
use App\Models\VideoAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class VideoRequestController extends Controller
{
    /**
     * Display video catalog for customers
     */
    public function catalog()
{
    // Only for customers
    if (auth()->user()->role !== 'customer') {
        return redirect('/dashboard')->with('error', 'Access denied.');
    }

    $videos = \App\Models\Video::all();
    $userRequests = \App\Models\VideoRequest::where('user_id', auth()->id())->get()->keyBy('video_id');
    
    // MANUAL QUERY untuk bypass model issue
    $userAccess = \Illuminate\Support\Facades\DB::table('video_access')
                    ->where('user_id', auth()->id())
                    ->where('expires_at', '>', now())
                    ->get()
                    ->keyBy('video_id');

    return view('customer.videos.catalog', compact('videos', 'userRequests', 'userAccess'));
}

    /**
     * Request access to watch a video
     */
    public function requestAccess(Request $request, $videoId)
    {
        // Only for customers
        if (auth()->user()->role !== 'customer') {
            return redirect('/dashboard')->with('error', 'Access denied.');
        }

        // Check if already has a pending or approved request
        $existingRequest = DB::table('video_requests')
                           ->where('user_id', auth()->id())
                           ->where('video_id', $videoId)
                           ->first();

        if ($existingRequest) {
            if ($existingRequest->status === 'pending') {
                return redirect()->route('video.catalog')->with('info', 'You already have a pending request for this video.');
            } elseif ($existingRequest->status === 'approved') {
                return redirect()->route('video.catalog')->with('info', 'You already have access to this video.');
            }
        }

        // Create new request using DB facade
        DB::table('video_requests')->insert([
            'user_id' => auth()->id(),
            'video_id' => $videoId,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('video.catalog')->with('success', 'Access request sent to admin.');
    }

    /**
     * Watch video (if access is granted and valid)
     */
    public function watch($videoId)
    {
        // Only for customers
        if (auth()->user()->role !== 'customer') {
            return redirect('/dashboard')->with('error', 'Access denied.');
        }

        // Check if user has valid access
        $videoAccess = DB::table('video_accesses')
                        ->where('user_id', auth()->id())
                        ->where('video_id', $videoId)
                        ->where('expires_at', '>', now())
                        ->first();

        if (!$videoAccess) {
            return redirect()->route('video.catalog')->with('error', 'You do not have access to this video or access has expired.');
        }

        // Get video data
        $video = DB::table('videos')->where('id', $videoId)->first();

        if (!$video) {
            return redirect()->route('video.catalog')->with('error', 'Video not found.');
        }

        return view('customer.videos.watch', compact('video'));
    }

    /**
     * Request access again after expiration
     */
    public function requestAgain($videoId)
    {
        // Only for customers
        if (auth()->user()->role !== 'customer') {
            return redirect('/dashboard')->with('error', 'Access denied.');
        }

        // Delete old access and request
        DB::table('video_accesses')
          ->where('user_id', auth()->id())
          ->where('video_id', $videoId)
          ->delete();

        DB::table('video_requests')
          ->where('user_id', auth()->id())
          ->where('video_id', $videoId)
          ->delete();

        // Create new request
        DB::table('video_requests')->insert([
            'user_id' => auth()->id(),
            'video_id' => $videoId,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('video.catalog')->with('success', 'New access request sent to admin.');
    }
}