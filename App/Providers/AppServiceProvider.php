<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Define gate untuk akses admin
        Gate::define('access-admin', function ($user) {
            return $user->role === 'admin';
        });
    }
}