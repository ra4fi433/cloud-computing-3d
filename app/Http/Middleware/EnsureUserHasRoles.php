<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
// use App\Http\Middleware\Filament;
use Filament\Facades\Filament;
// use Illuminate\Support\Facades\Auth;

class EnsureUserHasRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next): Response
    {

        $allowedRoles = ['admin', 'superadmin', 'user']; // Tentukan role yang diizinkan di sini

        // Periksa apakah pengguna sudah login
        if (! auth()->check()) {
            // Jika tidak login, arahkan ke halaman login
            
              return redirect(Filament::getLoginUrl());
        }
        // Ambil pengguna yang sudah login
        $user = auth()->user();

        // Periksa apakah pengguna memiliki salah satu role yang diizinkan
        $hasRequiredRole = $user->roles()->whereIn('name', $allowedRoles)->exists();

        if (! $hasRequiredRole) {
            return abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}

