<?php

namespace App\Http\Middleware;

use Closure;

class VerificarUsuario
{
    public function handle($request, Closure $next)
    {
        $usuarioValue = $_COOKIE["Usuario"];;
        //dd($usuarioValue);
        if ($usuarioValue === "JOSUE") {
            // Si el usuario es "JOSUE", permitir el acceso
            return $next($request);
        } else {
            // Si el usuario no es "JOSUE", redirigir o mostrar un mensaje de error
            abort(403, 'Acceso denegado');
        }
    }
}
