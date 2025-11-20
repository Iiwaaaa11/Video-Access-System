@extends('layouts.bootstrap')

@section('title', 'Admin Dashboard')
@section('page-title', 'Admin Dashboard')

@section('page-actions')
    <div class="btn-group">
        <span class="badge bg-success fs-6">
            <i class="bi bi-shield-check"></i> Administrator
        </span>
    </div>
@endsection

@section('content')
<!-- Statistics Cards -->
<div class="row">
    <!-- Total Videos Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Videos</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['totalVideos'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-play-btn fs-1 text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Pending Requests</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pendingRequests'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-clock-history fs-1 text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Access Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Active Access</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['activeAccess'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-check-circle fs-1 text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Customers Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total Customers</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['totalCustomers'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-people fs-1 text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-lightning"></i> Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-xl-3 col-md-6">
                        <a href="{{ route('admin.videos.create') }}" class="btn btn-primary w-100 h-100 py-3">
                            <i class="bi bi-plus-circle fs-2"></i>
                            <div class="mt-2">Add New Video</div>
                        </a>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <a href="{{ route('admin.videos.index') }}" class="btn btn-success w-100 h-100 py-3">
                            <i class="bi bi-play-btn fs-2"></i>
                            <div class="mt-2">Manage Videos</div>
                        </a>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <a href="{{ route('admin.requests.index') }}" class="btn btn-warning w-100 h-100 py-3">
                            <i class="bi bi-clock-history fs-2"></i>
                            <div class="mt-2">Review Requests</div>
                            @if($stats['pendingRequests'] > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $stats['pendingRequests'] }}
                                </span>
                            @endif
                        </a>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <a href="/" class="btn btn-info w-100 h-100 py-3">
                            <i class="bi bi-eye fs-2"></i>
                            <div class="mt-2">View Site</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity & Stats -->
<div class="row mt-4">
    <!-- Recent Requests -->
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-activity"></i> Recent Video Requests
                </h5>
            </div>
            <div class="card-body">
                @if($recentRequests->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Video</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentRequests as $request)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-person-circle me-2"></i>
                                            {{ $request->user->name }}
                                        </div>
                                    </td>
                                    <td>{{ Str::limit($request->video->title, 30) }}</td>
                                    <td>
                                        @if($request->status === 'pending')
                                            <span class="badge bg-warning text-dark">
                                                <i class="bi bi-clock"></i> Pending
                                            </span>
                                        @elseif($request->status === 'approved')
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle"></i> Approved
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="bi bi-x-circle"></i> Rejected
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $request->created_at->format('M d, H:i') }}</td>
                                    <td>
                                        <a href="{{ route('admin.requests.index') }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-inbox fs-1 text-muted"></i>
                        <p class="text-muted mt-2">No recent requests</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- System Stats -->
    <div class="col-lg-4">
        <div class="card shadow">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-graph-up"></i> System Overview
                </h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span>
                            <i class="bi bi-play-btn text-primary"></i>
                            Total Videos
                        </span>
                        <span class="badge bg-primary rounded-pill">{{ $stats['totalVideos'] }}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span>
                            <i class="bi bi-people text-info"></i>
                            Total Users
                        </span>
                        <span class="badge bg-info rounded-pill">{{ $stats['totalUsers'] }}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span>
                            <i class="bi bi-clock-history text-warning"></i>
                            Pending Requests
                        </span>
                        <span class="badge bg-warning rounded-pill">{{ $stats['pendingRequests'] }}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span>
                            <i class="bi bi-check-circle text-success"></i>
                            Approved Requests
                        </span>
                        <span class="badge bg-success rounded-pill">{{ $stats['approvedRequests'] }}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span>
                            <i class="bi bi-play-circle text-success"></i>
                            Active Access
                        </span>
                        <span class="badge bg-success rounded-pill">{{ $stats['activeAccess'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="card shadow mt-4">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-link"></i> Quick Links
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.videos.index') }}" class="btn btn-outline-primary text-start">
                        <i class="bi bi-play-btn me-2"></i>Manage Videos
                    </a>
                    <a href="{{ route('admin.requests.index') }}" class="btn btn-outline-warning text-start">
                        <i class="bi bi-clock-history me-2"></i>Manage Requests
                    </a>
                    <a href="#" class="btn btn-outline-info text-start">
                        <i class="bi bi-gear me-2"></i>System Settings
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Simple chart animation
    document.addEventListener('DOMContentLoaded', function() {
        // Animate counter numbers
        const counters = document.querySelectorAll('.font-weight-bold');
        counters.forEach(counter => {
            if (counter.textContent.match(/^\d+$/)) {
                const target = parseInt(counter.textContent);
                let current = 0;
                const increment = target / 50;
                
                const updateCounter = () => {
                    if (current < target) {
                        current += increment;
                        counter.textContent = Math.ceil(current);
                        setTimeout(updateCounter, 25);
                    } else {
                        counter.textContent = target;
                    }
                };
                
                updateCounter();
            }
        });
    });
</script>
@endsection