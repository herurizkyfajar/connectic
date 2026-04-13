<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PembinaReadonlyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only applies to authenticated admin users with role 'pembina'
        if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->role === 'pembina') {
            $method = strtoupper($request->getMethod());
            $routeName = optional($request->route())->getName();

            // Block non-read methods
            if (!in_array($method, ['GET', 'HEAD'])) {
                abort(403, 'Akses read-only untuk pembina.');
            }

            // Allowlisted route names for pembina
            $allowedRoutes = [
                'admin.dashboard',
                'riwayat-kegiatan.index',
                'riwayat-kegiatan.show',
                'anggota.index',
                'anggota.show',
                'admin.analisis-keaktifan',
                'admin.absensi.ranking',
            ];

            // If route name not in allowlist, block
            if ($routeName && !in_array($routeName, $allowedRoutes)) {
                abort(403, 'Halaman tidak tersedia untuk pembina.');
            }
        }

        return $next($request);
    }
}