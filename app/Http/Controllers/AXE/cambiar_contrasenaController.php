<?php

namespace App\Http\Controllers\AXE;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class cambiar_contrasenaController extends Controller


{
    // Para mostrar la pagina
    public function mostrarContrasena(){
        $UsuarioValue = $_COOKIE["Usuario"];
        // Retornar la vista con ambos conjuntos de datos
        return view('AXE.cambiarContrasena', compact('UsuarioValue'));
    }


    public function changeContrasena(Request $request){
        try {
            $UsuarioValue = $_COOKIE["Usuario"];
          
            $variableLogin = Http::post('http://82.180.162.18:4000/cambiarContrasena/', [
                "USUARIO" => $request->input("USUARIO"),
                "CONTRASENA" => $request->input("CONTRASENA"),
            ]);
            
            $mensaje = [
                'type' => 'error',
                'text' => 'Contraseña actualizada exitosamente'
            ];
            
            $variable = json_decode($variableLogin, true);
    
            return view('AXE.cambiarContrasena', compact('UsuarioValue', 'mensaje'));
        } catch (\Exception $e) {
            // Manejo de la excepción
            
            return "Ha ocurrido un error: " . $e->getMessage();
        }
    }

}