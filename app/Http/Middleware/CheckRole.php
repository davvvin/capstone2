<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles (slug peran yang diizinkan)
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) { // Jika pengguna belum login
            return redirect('login');
        }

        $user = Auth::user();
        foreach ($roles as $roleSlug) { // Mengubah nama variabel agar lebih jelas
            if ($user->hasRole($roleSlug)) { // Menggunakan metode hasRole() yang kita buat di model User
                return $next($request);
            }
        }

        // Jika pengguna tidak memiliki salah satu peran yang diizinkan
        // Anda bisa mengarahkan ke halaman 403 (Forbidden) atau halaman lain
        abort(403, 'ANDA TIDAK MEMILIKI AKSES UNTUK HALAMAN INI.');
        // atau return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses.');
    }
}
