<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Guards the login route itself: if already signed in as admin, skip
 * straight to the dashboard. Written by hand rather than using Laravel's
 * built-in "guest" alias — that middleware's default redirect target
 * doesn't know about this app's admin.* route names and would send an
 * already-authenticated admin somewhere that 404s.
 */
class RedirectIfAdminAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return $next($request);
    }
}
