<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CekLogin
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::get('login')) {
            return redirect('/login')->with('error', 'Silakan login dulu bro!');
        }
        return $next($request);
    }
}
