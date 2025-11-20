@extends('layouts.bootstrap')

@section('title', 'Manage Video Requests')
@section('page-title', 'Manage Video Requests')

@section('page-actions')
    @if($pendingRequests->count() > 0)
        <span class="badge bg-danger fs-6">
            <i class="bi bi-exclamation-triangle"></i> {{ $pendingRequests->count() }} Pending
        </span>
    @endif
@endsection

@section('content')
<!-- Pending Requests Section -->
<div class="card shadow mb-4">
    <div class="card-header bg-warning text-dark">
        <h5 class="card-title mb-0">
            <i class="bi bi-clock-history"></i> Pending Requests
            <span class="badge bg-dark">{{ $pendingRequests->count() }}</span>
        </h5>
    </div>
    <div class="card-body">
        @if($pendingRequests->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>User</th>
                            <th>Video</th>
                            <th>Requested</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingRequests as $request)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="bi bi-person-circle fs-4 text-primary"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0">{{ $request->user->name }}</h6>
                                        <small class="text-muted">{{ $request->user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <strong>{{ $request->video->title }}</strong>
                                @if($request->video->description)
                                    <br><small class="text-muted">{{ Str::limit($request->video->description, 50) }}</small>
                                @endif
                            </td>
                            <td>
                                <small>{{ $request->created_at->format('M d, Y') }}</small>
                                <br><small class="text-muted">{{ $request->created_at->format('H:i') }}</small>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#approveModal{{ $request->id }}">
                                        <i class="bi bi-check-lg"></i> Approve
                                    </button>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $request->id }}">
                                        <i class="bi bi-x-lg"></i> Reject
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Approve Modal -->
                        <div class="modal fade" id="approveModal{{ $request->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-success text-white">
                                        <h5 class="modal-title">
                                            <i class="bi bi-check-circle"></i> Approve Access
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('admin.requests.approve', $request) }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <p>Approve access for <strong>{{ $request->user->name }}</strong> to watch <strong>"{{ $request->video->title }}"</strong>?</p>
                                            
                                            <div class="mb-3">
                                                <label for="hours{{ $request->id }}" class="form-label">Access Duration:</label>
                                                <select class="form-select" name="hours" id="hours{{ $request->id }}" required>
                                                    <option value="1">1 Hour</option>
                                                    <option value="2" selected>2 Hours</option>
                                                    <option value="6">6 Hours</option>
                                                    <option value="24">24 Hours</option>
                                                    <option value="72">3 Days</option>
                                                    <option value="168">7 Days</option>
                                                </select>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="notes{{ $request->id }}" class="form-label">Notes (Optional):</label>
                                                <textarea class="form-control" name="admin_notes" id="notes{{ $request->id }}" rows="2" placeholder="Optional message for the user..."></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-success">
                                                <i class="bi bi-check-lg"></i> Approve Access
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Reject Modal -->
                        <div class="modal fade" id="rejectModal{{ $request->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title">
                                            <i class="bi bi-x-circle"></i> Reject Request
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('admin.requests.reject', $request) }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <p>Reject access request from <strong>{{ $request->user->name }}</strong> for <strong>"{{ $request->video->title }}"</strong>?</p>
                                            
                                            <div class="mb-3">
                                                <label for="rejectNotes{{ $request->id }}" class="form-label">Reason for Rejection:</label>
                                                <textarea class="form-control" name="admin_notes" id="rejectNotes{{ $request->id }}" rows="3" placeholder="Please provide a reason for rejection..." required></textarea>
                                                <div class="form-text">This message will be sent to the user.</div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-danger">
                                                <i class="bi bi-x-lg"></i> Reject Request
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-4">
                <i class="bi bi-check-circle fs-1 text-success"></i>
                <h5 class="text-muted mt-3">No Pending Requests</h5>
                <p class="text-muted">All video requests have been processed.</p>
            </div>
        @endif
    </div>
</div>

<!-- Approved Requests Section -->
<div class="card shadow mb-4">
    <div class="card-header bg-success text-white">
        <h5 class="card-title mb-0">
            <i class="bi bi-check-circle"></i> Approved Requests
            <span class="badge bg-light text-dark">{{ $approvedRequests->count() }}</span>
        </h5>
    </div>
    <div class="card-body">
        @if($approvedRequests->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>User</th>
                            <th>Video</th>
                            <th>Approved</th>
                            <th>Expires</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($approvedRequests as $request)
                        @php
                            $isActive = $request->videoAccess && $request->videoAccess->isValid();
                        @endphp
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-person-circle me-2 text-primary"></i>
                                    {{ $request->user->name }}
                                </div>
                            </td>
                            <td>{{ $request->video->title }}</td>
                            <td>
                                <small>{{ $request->updated_at->format('M d, Y') }}</small>
                                <br><small class="text-muted">{{ $request->updated_at->format('H:i') }}</small>
                            </td>
                            <td>
                                @if($request->videoAccess)
                                    <small>{{ $request->videoAccess->expires_at->format('M d, Y H:i') }}</small>
                                    <br>
                                    <small class="{{ $isActive ? 'text-success' : 'text-danger' }}">
                                        {{ $request->videoAccess->expires_at->diffForHumans() }}
                                    </small>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                @if($isActive)
                                    <span class="badge bg-success">
                                        <i class="bi bi-play-circle"></i> Active
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        <i class="bi bi-clock-history"></i> Expired
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($isActive && $request->videoAccess)
                                    <form action="{{ route('admin.access.revoke', $request->videoAccess) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Revoke access immediately?')">
                                            <i class="bi bi-x-circle"></i> Revoke
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-4">
                <i class="bi bi-inbox fs-1 text-muted"></i>
                <p class="text-muted mt-2">No approved requests yet</p>
            </div>
        @endif
    </div>
</div>

<!-- Rejected Requests Section -->
<div class="card shadow">
    <div class="card-header bg-secondary text-white">
        <h5 class="card-title mb-0">
            <i class="bi bi-x-circle"></i> Rejected Requests
            <span class="badge bg-light text-dark">{{ $rejectedRequests->count() }}</span>
        </h5>
    </div>
    <div class="card-body">
        @if($rejectedRequests->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>User</th>
                            <th>Video</th>
                            <th>Rejected</th>
                            <th>Reason</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rejectedRequests as $request)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-person-circle me-2 text-muted"></i>
                                    {{ $request->user->name }}
                                </div>
                            </td>
                            <td>{{ $request->video->title }}</td>
                            <td>
                                <small>{{ $request->updated_at->format('M d, Y') }}</small>
                                <br><small class="text-muted">{{ $request->updated_at->format('H:i') }}</small>
                            </td>
                            <td>
                                @if($request->admin_notes)
                                    <span class="text-muted">{{ Str::limit($request->admin_notes, 80) }}</span>
                                @else
                                    <span class="text-muted fst-italic">No reason provided</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-4">
                <i class="bi bi-emoji-smile fs-1 text-muted"></i>
                <p class="text-muted mt-2">No rejected requests</p>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Auto-focus on textarea when modal opens
    document.addEventListener('DOMContentLoaded', function() {
        var modals = document.querySelectorAll('.modal');
        modals.forEach(function(modal) {
            modal.addEventListener('shown.bs.modal', function() {
                var textarea = this.querySelector('textarea');
                if (textarea) {
                    textarea.focus();
                }
            });
        });
    });
</script>
@endsection