<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="text-lg"><strong>Welcome, {{ auth()->user()->name }}!</strong></p>
                    <p class="text-gray-600">Role: {{ auth()->user()->role }}</p>

                    <div class="mt-6">
                        @if(auth()->user()->role === 'admin')
                            <h3 class="text-lg font-semibold mb-4">Admin Menu:</h3>
                            <div class="space-y-2">
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                    Admin Dashboard
                                </a>
                                <a href="{{ route('admin.videos.index') }}" class="block px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                                    Manage Videos
                                </a>
                                <a href="{{ route('admin.requests.index') }}" class="block px-4 py-2 bg-purple-500 text-white rounded hover:bg-purple-600">
                                    Manage Video Requests
                                </a>
                            </div>
                        @else
                            <h3 class="text-lg font-semibold mb-4">Customer Menu:</h3>
                            <div class="space-y-2">
                                <a href="{{ route('video.catalog') }}" class="block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                    Browse Video Catalog
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>