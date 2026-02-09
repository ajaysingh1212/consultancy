<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            abort(403);
        }

        // allow any user who has ANY admin permission
        if (
            auth()->user()->hasAnyRole(['Super Admin', 'admin', 'editor'])
        ) {
            return $next($request);
        }

        abort(403, 'You are not allowed to access admin panel');
    }
}
