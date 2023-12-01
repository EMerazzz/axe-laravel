<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckToken
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->hasCookie('token')) {
            return $next($request);
        }

        // Si no hay token en la cookie, redirige al inicio de sesión
        return redirect('login');
    }
}
