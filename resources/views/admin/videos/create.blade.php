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
                        <label for="title" class="form-label">
                            Video Title <span class="text-danger">*</span>
                        </label>
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
                                  name="description" id="description" rows="4" 
                                  placeholder="Enter video description (optional)">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Provide a brief description of the video content.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="file_path" class="form-label">
                            Video File Path/URL <span class="text-danger">*</span>
                        </label>
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
                               placeholder="Example: /images/thumbnail.jpg or https://example.com/thumb.jpg">
                        @error('thumbnail')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            <i class="bi bi-image"></i> Optional thumbnail image for the video
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
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
                    <div class="col-md-6 mb-3">
                        <h6><i class="bi bi-youtube text-danger"></i> YouTube Examples:</h6>
                        <div class="card bg-light">
                            <div class="card-body">
                                <code class="d-block text-success mb-2">https://www.youtube.com/embed/dQw4w9WgXcQ</code>
                                <code class="d-block text-success">https://youtu.be/dQw4w9WgXcQ</code>
                                <small class="text-muted">Replace with actual YouTube video ID</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <h6><i class="bi bi-file-play"></i> Local File Examples:</h6>
                        <div class="card bg-light">
                            <div class="card-body">
                                <code class="d-block text-success mb-2">/storage/videos/tutorial.mp4</code>
                                <code class="d-block text-success">/public/videos/demo.mkv</code>
                                <code class="d-block text-success">videos/sample.webm</code>
                                <small class="text-muted">Paths relative to your public folder</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <h6><i class="bi bi-camera-video"></i> Vimeo Example:</h6>
                        <div class="card bg-light">
                            <div class="card-body">
                                <code class="d-block text-success">https://player.vimeo.com/video/123456789</code>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <h6><i class="bi bi-image"></i> Thumbnail Examples:</h6>
                        <div class="card bg-light">
                            <div class="card-body">
                                <code class="d-block text-success mb-2">/images/thumbnails/video1.jpg</code>
                                <code class="d-block text-success">https://example.com/thumbnail.png</code>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Tips -->
        <div class="card shadow mt-4">
            <div class="card-header bg-success text-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-lightbulb"></i> Quick Tips
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex mb-3">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            <span>Use descriptive titles for better organization</span>
                        </div>
                        <div class="d-flex mb-3">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            <span>Add descriptions to help users understand content</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex mb-3">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            <span>Test video URLs before saving</span>
                        </div>
                        <div class="d-flex mb-3">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            <span>Thumbnails improve user engagement</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-focus on title field
        document.getElementById('title').focus();
        
        // Example placeholder generator
        const examples = {
            youtube: 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            local: '/videos/tutorial.mp4',
            vimeo: 'https://player.vimeo.com/video/123456789'
        };
        
        // Add click handlers to example codes
        document.querySelectorAll('code.text-success').forEach(code => {
            code.style.cursor = 'pointer';
            code.title = 'Click to copy example';
            code.addEventListener('click', function() {
                const text = this.textContent;
                navigator.clipboard.writeText(text).then(() => {
                    // Show temporary feedback
                    const originalText = this.textContent;
                    this.textContent = 'Copied!';
                    this.classList.add('text-warning');
                    setTimeout(() => {
                        this.textContent = originalText;
                        this.classList.remove('text-warning');
                        this.classList.add('text-success');
                    }, 1500);
                });
            });
        });
    });
</script>
@endsection