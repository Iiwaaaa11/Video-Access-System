@extends('layouts.bootstrap')

@section('title', 'Add New Video')
@section('page-title', 'Add New Video')

@section('page-actions')
    <a href="{{ route('admin.videos.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back to Videos
    </a>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-plus-circle"></i> Create New Video
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

                <form action="{{ route('admin.videos.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Video Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               name="title" id="title" value="{{ old('title') }}" 
                               placeholder="Enter video title" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  name="description" id="description" rows="3" 
                                  placeholder="Enter video description">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="file_path" class="form-label">Video File Path/URL <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('file_path') is-invalid @enderror" 
                               name="file_path" id="file_path" value="{{ old('file_path') }}" 
                               placeholder="Example: /videos/sample.mp4 or https://youtube.com/embed/abc123" required>
                        @error('file_path')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <i class="bi bi-info-circle"></i> You can use local file paths or YouTube/Vimeo embed URLs
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="thumbnail" class="form-label">Thumbnail URL (Optional)</label>
                        <input type="text" class="form-control @error('thumbnail') is-invalid @enderror" 
                               name="thumbnail" id="thumbnail" value="{{ old('thumbnail') }}" 
                               placeholder="Example: /images/thumbnail.jpg">
                        @error('thumbnail')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <i class="bi bi-image"></i> Optional thumbnail image for the video
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('admin.videos.index') }}" class="btn btn-secondary me-md-2">
                            <i class="bi bi-x-circle"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Create Video
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Help Section -->
        <div class="card shadow mt-4">
            <div class="card-header bg-info text-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-question-circle"></i> Video URL Examples
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>YouTube Examples:</h6>
                        <code class="d-block text-muted mb-2">https://www.youtube.com/embed/VIDEO_ID</code>
                        <code class="d-block text-muted">https://youtu.be/VIDEO_ID</code>
                    </div>
                    <div class="col-md-6">
                        <h6>Local File Examples:</h6>
                        <code class="d-block text-muted mb-2">/storage/videos/sample.mp4</code>
                        <code class="d-block text-muted">/public/videos/tutorial.mkv</code>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection