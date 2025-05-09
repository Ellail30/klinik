<?php

// app/Http/Middleware/CheckLogin.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class CheckLogin
{
    public function handle($request, Closure $next)
    {
        // Periksa apakah user sudah login (ada di session)
        if (!Session::has('user_id')) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu');
        }

        return $next($request);
    }
}