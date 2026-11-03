<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CekAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (Session::get('role') != 'admin') {
            return redirect('/')->with('error', 'Akses ditolak! Hanya admin yang bisa buka Kelola Menu');
        }
        return $next($request);
    }
}
