<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
/*************  ✨ Windsurf Command ⭐  *************/
/**
 * Handle an incoming request.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  \Closure  $next
 * @return \Symfony\Component\HttpFoundation\Response
 *
 * Check if the user is authenticated and has the admin role.
 * If so, the request is passed through to the next middleware.
 * If not, the user is redirected to the home page.
 */
/*******  0e5b4d85-3837-4b55-a053-b2e16a74440b  *******/    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }

        return redirect('/');
    }
}