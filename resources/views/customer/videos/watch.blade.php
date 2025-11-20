<!DOCTYPE html>
<html>
<head>
    <title>Watch: {{ $video->title }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f5f5f5; }
        .video-container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .video-player { width: 100%; height: 400px; background: #000; border-radius: 8px; margin-bottom: 20px; }
        .video-title { font-size: 24px; font-weight: bold; margin-bottom: 10px; }
        .video-description { color: #666; margin-bottom: 20px; line-height: 1.6; }
        .btn { padding: 10px 15px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; border: none; cursor: pointer; }
        .btn:hover { background: #0056b3; }
        .btn-secondary { background: #6c757d; }
        .btn-secondary:hover { background: #545b62; }
        .access-info { background: #e7f3ff; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="video-container">
        <div class="access-info">
            <strong>✓ Access Granted</strong> - You can watch this video until your access expires.
        </div>

        <div class="video-title">{{ $video->title }}</div>
        
        @if($video->description)
            <div class="video-description">{{ $video->description }}</div>
        @endif

        <!-- Video Player -->
<div class="video-player">
    @php
        use App\Helpers\VideoHelper;
        $youtubeId = VideoHelper::extractYouTubeId($video->file_path);
        $vimeoId = VideoHelper::extractVimeoId($video->file_path);
    @endphp

    @if($youtubeId)
        <!-- YouTube Embed -->
        <iframe 
            width="100%" 
            height="100%" 
            src="https://www.youtube.com/embed/{{ $youtubeId }}" 
            frameborder="0" 
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
            allowfullscreen>
        </iframe>
    @elseif($vimeoId)
        <!-- Vimeo Embed -->
        <iframe 
            src="https://player.vimeo.com/video/{{ $vimeoId }}" 
            width="100%" 
            height="100%" 
            frameborder="0" 
            allow="autoplay; fullscreen; picture-in-picture" 
            allowfullscreen>
        </iframe>
    @else
        <!-- Local Video File -->
        <video controls width="100%" height="100%">
            <source src="{{ $video->file_path }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    @endif
</div>
                <!-- YouTube Embed -->
                <iframe 
                    width="100%" 
                    height="100%" 
                    src="https://www.youtube.com/embed/{{ extractYouTubeId($video->file_path) }}" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen>
                </iframe>
            @elseif(str_contains($video->file_path, 'vimeo.com'))
                <!-- Vimeo Embed -->
                <iframe 
                    src="https://player.vimeo.com/video/{{ extractVimeoId($video->file_path) }}" 
                    width="100%" 
                    height="100%" 
                    frameborder="0" 
                    allow="autoplay; fullscreen; picture-in-picture" 
                    allowfullscreen>
                </iframe>
            @else
                <!-- Local Video File -->
                <video controls width="100%" height="100%">
                    <source src="{{ $video->file_path }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            @endif
        </div>

        <div style="margin-top: 20px;">
            <a href="{{ route('video.catalog') }}" class="btn btn-secondary">← Back to Catalog</a>
        </div>
    </div>
</body>
</html>