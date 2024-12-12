<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // give access only to admin and staff to /admin/...
        if ($request->user()->is_admin || $request->user()->is_staff) {
            return $next($request);
        }

        // if its a normal user redirect to home
        return redirect('/');
    }
}
