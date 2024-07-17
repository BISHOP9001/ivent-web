<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!$request->user() || !$request->user()->hasAnyRole($roles)) {
            // Redirect or abort based on application design
            return redirect('home')->with('error', 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}
