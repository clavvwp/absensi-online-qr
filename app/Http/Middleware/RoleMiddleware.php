<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
    return redirect()->route('login');
    }
     /** @var \App\Models\User|null $user */
    $user = Auth::user();

    if ($role === 'admin' && !$user->isAdmin()) {
        abort(403, 'Akses ditolak. Hanya admin.');
    }

    if ($role === 'wali_kelas' && !$user->isWaliKelas()) {
        abort(403, 'Akses ditolak. Hanya wali kelas.');
    }

        return $next($request);
    }
}
