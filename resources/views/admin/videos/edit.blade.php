@extends('layouts.bootstrap')

@section('title', 'Edit Video: ' . $video->title)
@section('page-title', 'Edit Video: ' . $video->title)

@section('page-actions')
    <a href="{{ route('admin.videos.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back to Videos
    </a>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header bg-warning text-dark">
                <h5 class="card-title mb-0">
                    <i class="bi bi-pencil"></i> Edit Video
                </h5>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Please fix the following errors:</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.videos.update', $video) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Video Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               name="title" id="title" value="{{ old('title', $video->title) }}" 
                               placeholder="Enter video title" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  name="description" id="description" rows="3" 
                                  placeholder="Enter video description">{{ old('description', $video->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="file_path" class="form-label">Video File Path/URL <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('file_path') is-invalid @enderror" 
                               name="file_path" id="file_path" value="{{ old('file_path', $video->file_path) }}" 
                               placeholder="Example: /videos/sample.mp4 or https://youtube.com/embed/abc123" required>
                        @error('file_path')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="thumbnail" class="form-label">Thumbnail URL (Optional)</label>
                        <input type="text" class="form-control @error('thumbnail') is-invalid @enderror" 
                               name="thumbnail" id="thumbnail" value="{{ old('thumbnail', $video->thumbnail) }}" 
                               placeholder="Example: /images/thumbnail.jpg">
                        @error('thumbnail')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('admin.videos.index') }}" class="btn btn-secondary me-md-2">
                            <i class="bi bi-x-circle"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-check-circle"></i> Update Video
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Video Info -->
        <div class="card shadow mt-4">
            <div class="card-header bg-info text-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-info-circle"></i> Video Information
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Created:</strong> {{ $video->created_at->format('M d, Y H:i') }}</p>
                        <p><strong>Last Updated:</strong> {{ $video->updated_at->format('M d, Y H:i') }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Current File Path:</strong></p>
                        <code class="d-block text-truncate">{{ $video->file_path }}</code>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection