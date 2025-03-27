<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check() || !Auth::user()->roles->pluck('title')->intersect($roles)->isNotEmpty()) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
