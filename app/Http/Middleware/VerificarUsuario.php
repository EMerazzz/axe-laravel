<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Http; // Importa la clase Http
use Closure;


class VerificarUsuario
{
    public function handle($request, Closure $next, $OBJETO)
    {
        $PERMITIDO = 1;
        $usuarioValue = $_COOKIE["Usuario"];;

        $ACCESO_PERMITIDO = Http::post('http://82.180.162.18:4000/acceso_permitido', [
            "USUARIO" =>  $usuarioValue,
            "OBJETO" =>  $OBJETO
        ]);
<<<<<<< HEAD
        */
        $ACCESO_PERMITIDO = Http::post('http://82.180.162.18:4000/acceso_permitido', [
=======
    
       /* $ACCESO_PERMITIDO = Http::post('http://localhost:4000/acceso_permitido', [
>>>>>>> 647e73e89a9af7f48bb865db9d721c513d21874e
            "USUARIO" =>  $usuarioValue,
            "OBJETO" =>  $OBJETO
        ]);*/

        $ACCESO = json_decode( $ACCESO_PERMITIDO, true);


        //dd($usuarioValue);
        if ($ACCESO === $PERMITIDO) {
            // Si el usuario es 1, permitir el acceso
            return $next($request);
        } else {
            // Si el usuario no es 1, redirigir o mostrar un mensaje de error
            abort(403, 'Solo administradores');
        }
    }
}

/*
class VerificarUsuario
{
    public function handle($request, Closure $next)
    {
        $PERMITIDO = 1;
        $usuarioValue = $_COOKIE["Usuario"];;

        $ACCESO_PERMITIDO = Http::post('http://82.180.162.18:4000/acceso_permitido', [
            "USUARIO" =>  $usuarioValue
        ]);

        $ACCESO = json_decode( $ACCESO_PERMITIDO, true);


        //dd($usuarioValue);
        if ($ACCESO === $PERMITIDO) {
            // Si el usuario es 1, permitir el acceso
            return $next($request);
        } else {
            // Si el usuario no es 1, redirigir o mostrar un mensaje de error
            abort(403, 'Solo administradores');
        }
    }
}
*/