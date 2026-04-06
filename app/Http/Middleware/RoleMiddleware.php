<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userRole = strtolower(trim(Auth::user()->role));

        $allowedRoles = array_map(fn($r) => strtolower(trim($r)), $roles);

        if (in_array($userRole, $allowedRoles)) {
            return $next($request);
        }

        abort(403, "AKSES DITOLAK: Role Anda adalah ($userRole), halaman ini hanya untuk (" . implode(', ', $roles) . ")");
    }
}