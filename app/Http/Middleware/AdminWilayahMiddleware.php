<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminWilayahMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/admin/login');
        }

        $user = Auth::guard('admin')->user();
        if (!in_array($user->role, ['admin_wilayah', 'admin_nasional'])) {
            abort(403, 'Halaman khusus Admin Wilayah.');
        }

        return $next($request);
    }
}

