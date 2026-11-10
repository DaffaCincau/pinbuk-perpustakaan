<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Pemakaian di route:
     *   ->middleware('role:admin')
     *   ->middleware('role:siswa')
     *   ->middleware('role:admin,siswa')  // boleh dua-duanya
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // 1. Pastikan user sudah login
        if (! $request->user()) {
            return redirect()->route('login');
        }

        // 2. Cek apakah role user ada di daftar role yang diizinkan
        if (! in_array($request->user()->role, $roles, true)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}