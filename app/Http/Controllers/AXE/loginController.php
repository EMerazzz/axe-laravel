<?php
namespace App\Http\Controllers\AXE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cookie;

class loginController extends Controller
{   
    public function login(){
        try {
            // Tu código para mostrar la vista 'AXE/login'
            return view('AXE/login');
        } catch (\Exception $e) {
            // Manejo de la excepción
            return "Ha ocurrido un error: " . $e->getMessage();
        }
    }
    
    
    //Agregando try-catch
    public function ingresar(Request $request) {
        try {
            $variableLogin = Http::post('http://82.180.162.18:4000/login', [
                "USUARIO" => $request->input("USUARIO"),
                "CONTRASENA" => $request->input("CONTRASENA"),
            ]);
    
            $variable = json_decode($variableLogin, true);
    
            if (count($variable) > 1) {
                // Encriptar el token antes de establecer la cookie
                $valorEncriptado = encrypt($variable['token']);
    
                $Usuario = $request->input("USUARIO");
                setcookie("Usuario", $Usuario);
                // Establecer la cookie encriptada
                return redirect('AXE')->withCookie(Cookie::make('token', $valorEncriptado, 0, "./"));
            } else {
                $errorMessage = $variable['mensaje'];
                return redirect('login')->with('errorMessage', $errorMessage);
            }
        } catch (\Exception $e) {
            // Manejo de excepciones: puedes mostrar un mensaje genérico o registrar el error
            return redirect('login')->with('errorMessage', 'Ocurrió un error al intentar ingresar.');
        }
    }
    

    public function logout(Request $request){
        try {
            // Eliminar la cookie de token
            return redirect('login')->withCookie(Cookie::forget('token'));
        } catch (\Exception $e) {
            // Manejo de la excepción
            return "Ha ocurrido un error: " . $e->getMessage();
        }
    }
    
    public function existeUsuario(Request $request){
        $variableLogin = Http::post('http://82.180.162.18:4000/usuario_contrasena/', [
            "USUARIO" => $request->input("USUARIO"),
        ]);
        
        // Cambiar a la direccion ip cuando suba los cambios
        // http://localhost:4000/pregunta_usuario/

        $variablePreguntas = Http::post('http://localhost:4000/pregunta_usuario/JOSUE', [
            "USUARIO" => $request->input("USUARIO"),
        ]);

        // "USUARIO" => $request->input("USUARIO"),
        $variable = $request->input("USUARIO");
        $preguntasUsuario = json_decode($variablePreguntas, true);

        return view('AXE/cambioContrasena', compact('variable', 'preguntasUsuario'));
    }

    public function cambiarContrasena(Request $request){
        try {
            $variableLogin = Http::post('http://82.180.162.18:4000/cambiarContrasena/', [
                "USUARIO" => $request->input("USUARIO"),
                "CONTRASENA" => $request->input("CONTRASENA"),
            ]);
    
            $variable = json_decode($variableLogin, true);
    
            return view('AXE/login');
        } catch (\Exception $e) {
            // Manejo de la excepción
            return "Ha ocurrido un error: " . $e->getMessage();
        }
    }
    
}
