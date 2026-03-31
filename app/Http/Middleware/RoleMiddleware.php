<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        // kalau belum login
        if (!auth()->check()) {
            return redirect('/login');
        }

        // kalau role tidak sesuai
        if (!in_array(auth()->user()->role, $roles)) {
            abort(403, 'AKSES DITOLAK');
        }

        return $next($request);
    }
}