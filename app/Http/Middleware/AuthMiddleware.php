<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthMiddleware
{
    public function handle($request, Closure $next)
    {
        $token = Session::get('access_token');

        if (!$token) {
            return redirect('/');
        }

        $resultado = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->get('http://localhost:8000/api/validate');

        if ($resultado->status() == 200) {
            return $next($request);
        }

        Session::forget(['access_token']);
        return redirect('/')->with('error', 'Sesión expirada');
    }
}
