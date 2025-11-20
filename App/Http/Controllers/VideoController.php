<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Cek role admin
        if (auth()->user()->role !== 'admin') {
            return redirect('/dashboard')->with('error', 'Access denied. Admin only.');
        }

        $videos = Video::latest()->get();
        return view('admin.videos.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            return redirect('/dashboard')->with('error', 'Access denied. Admin only.');
        }

        return view('admin.videos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect('/dashboard')->with('error', 'Access denied. Admin only.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file_path' => 'required|string|max:500',
            'thumbnail' => 'nullable|string|max:500',
        ]);

        Video::create([
        'title' => $request->title,
        'description' => $request->description,
        'file_path' => $request->file_path,
            'thumbnail' => $request->thumbnail,
        ]);

        return redirect()->route('admin.videos.index')->with('success', 'Video created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Video $video)
    {
        return view('admin.videos.show', compact('video'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Video $video)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect('/dashboard')->with('error', 'Access denied. Admin only.');
        }

        return view('admin.videos.edit', compact('video'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Video $video)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect('/dashboard')->with('error', 'Access denied. Admin only.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file_path' => 'required|string|max:500',
            'thumbnail' => 'nullable|string|max:500',
        ]);

        $video->update($request->all());

        return redirect()->route('admin.videos.index')->with('success', 'Video updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Video $video)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect('/dashboard')->with('error', 'Access denied. Admin only.');
        }

        $video->delete();

        return redirect()->route('admin.videos.index')->with('success', 'Video deleted successfully.');
    }
}