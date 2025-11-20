<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .menu { margin: 20px 0; }
        .menu a { display: inline-block; margin: 5px; padding: 10px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; }
        .menu a:hover { background: #0056b3; }
        .user-info { background: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="user-info">
        <h1>Welcome to Dashboard</h1>
        <p>Logged in as: <strong>{{ auth()->user()->name }}</strong> ({{ auth()->user()->role }})</p>
    </div>

    <!-- ROLE-BASED NAVIGATION -->
    <div class="menu">
        <h2>Main Menu:</h2>
        
        @if(auth()->user()->role === 'admin')
            <!-- ADMIN MENU -->
            <a href="{{ route('admin.videos.index') }}">Manage Videos</a>
            <a href="{{ route('admin.requests.index') }}">Manage Video Requests</a>
            <a href="/">Home Page</a>
        @else
            <!-- CUSTOMER MENU -->
            <a href="{{ route('video.catalog') }}">Browse Video Catalog</a>
            <a href="/">Home Page</a>
        @endif
    </div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" style="padding: 10px; background: #dc3545; color: white; border: none; border-radius: 5px; cursor: pointer;">
            Logout
        </button>
    </form>
</body>
</html>