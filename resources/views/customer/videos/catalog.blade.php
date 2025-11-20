@extends('layouts.bootstrap')

@section('title', 'Video Catalog')
@section('page-title', 'Video Catalog')

@section('page-actions')
    <div class="btn-group">
        <span class="badge bg-primary fs-6">
            <i class="bi bi-person"></i> {{ auth()->user()->name }}
        </span>
    </div>
@endsection

@section('content')
<div class="row">
    @foreach($videos as $video)
    @php
        $userRequest = $userRequests[$video->id] ?? null;
        $userAccess = $userAccess[$video->id] ?? null;
    @endphp
    
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100 shadow-sm">
            @if($video->thumbnail)
            <img src="{{ $video->thumbnail }}" class="card-img-top" alt="{{ $video->title }}" style="height: 200px; object-fit: cover;">
            @else
            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                <i class="bi bi-play-btn fs-1 text-muted"></i>
            </div>
            @endif
            
            <div class="card-body">
                <h5 class="card-title">{{ $video->title }}</h5>
                <p class="card-text text-muted">{{ Str::limit($video->description, 100) }}</p>
                
                <!-- Status Badge -->
                <div class="mb-3">
                    @if($userAccess && $userAccess->isValid())
                        <span class="badge bg-success">
                            <i class="bi bi-check-circle"></i> Access Granted
                        </span>
                        <small class="text-muted d-block mt-1">
                            Expires: {{ $userAccess->expires_at->format('M d, Y H:i') }}
                        </small>
                    @elseif($userRequest)
                        @if($userRequest->status === 'pending')
                            <span class="badge bg-warning text-dark">
                                <i class="bi bi-clock"></i> Pending Approval
                            </span>
                        @elseif($userRequest->status === 'approved')
                            <span class="badge bg-danger">
                                <i class="bi bi-clock-history"></i> Access Expired
                            </span>
                        @else
                            <span class="badge bg-secondary">
                                <i class="bi bi-x-circle"></i> Request Rejected
                            </span>
                        @endif
                    @endif
                </div>
            </div>
            
            <div class="card-footer bg-white">
                @if($userAccess && $userAccess->isValid())
                    <a href="{{ route('video.watch', $video) }}" class="btn btn-success w-100">
                        <i class="bi bi-play-circle"></i> Watch Video
                    </a>
                @elseif($userRequest && $userRequest->status === 'approved')
                    <form action="{{ route('video.request.again', $video) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-warning w-100">
                            <i class="bi bi-arrow-clockwise"></i> Request Again
                        </button>
                    </form>
                @elseif(!$userRequest || $userRequest->status === 'rejected')
                    <form action="{{ route('video.request.access', $video) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-send"></i> Request Access
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>

@if($videos->isEmpty())
<div class="text-center py-5">
    <i class="bi bi-play-btn fs-1 text-muted"></i>
    <h3 class="text-muted mt-3">No Videos Available</h3>
    <p class="text-muted">Check back later for new content.</p>
</div>
@endif
@endsection