<!DOCTYPE html>
<html>
<head>
    <title>{{ $video->title }} - Admin</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .video-info { background: #f8f9fa; padding: 20px; border-radius: 5px; margin-bottom: 20px; }
        .btn { padding: 10px 15px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; }
        .btn:hover { background: #0056b3; }
        .btn-secondary { background: #6c757d; }
        .btn-secondary:hover { background: #545b62; }
    </style>
</head>
<body>
    <h1>{{ $video->title }}</h1>

    <div class="video-info">
        <p><strong>Description:</strong> {{ $video->description ?? 'No description' }}</p>
        <p><strong>File Path:</strong> {{ $video->file_path }}</p>
        <p><strong>Thumbnail:</strong> {{ $video->thumbnail ?? 'No thumbnail' }}</p>
        <p><strong>Created:</strong> {{ $video->created_at->format('M d, Y H:i') }}</p>
        <p><strong>Last Updated:</strong> {{ $video->updated_at->format('M d, Y H:i') }}</p>
    </div>

    <div>
        <a href="{{ route('admin.videos.edit', $video) }}" class="btn">Edit Video</a>
        <a href="{{ route('admin.videos.index') }}" class="btn btn-secondary">Back to List</a>
    </div>

    <div style="margin-top: 20px;">
        <a href="{{ route('admin.videos.index') }}">← Back to Videos List</a>
    </div>
</body>
</html>