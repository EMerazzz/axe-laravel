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
                // Establecer la cookie encriptad

                //Primera vez?
                $variablePrimeraVez = Http::post('http://82.180.162.18:4000/primera_vez', [
                    "USUARIO" => $request->input("USUARIO")
                ]);

                $variablePrimera = json_decode( $variablePrimeraVez, true);
                if (count($variablePrimera) > 0){

                    $COD_USUARIO_RECIBIDO = Http::post('http://82.180.162.18:4000/dame_cod_usuario', [
                        "USUARIO" =>  $Usuario
                    ]);
                
                    $COD_USUARIO = json_decode( $COD_USUARIO_RECIBIDO, true);
                    $COD_USUARIO = $COD_USUARIO[0]['COD_USUARIO'];
                
                    $TOTAL_PREGUNTAS_USUARIO = Http::post('http://82.180.162.18:4000/cuenta_preguntas', [
                        "COD_USUARIO" =>  $COD_USUARIO,
                        "USUARIO" =>  $Usuario
                    ]);
                    
                    $TOTALPREGUNTAS = json_decode( $TOTAL_PREGUNTAS_USUARIO, true);
                    $TOTALPREGUNTAS = $TOTALPREGUNTAS['COUNT(PREGUNTA)']; 
    
                    $mensaje = "";

                    return view('AXE/establecer_preguntas', compact('Usuario','mensaje', 'TOTALPREGUNTAS'));
                }else{
                    return redirect('AXE')->withCookie(Cookie::make('token', $valorEncriptado, 0, "./"));
                }

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
        try {
            
            $variableLogin = Http::post('http://82.180.162.18:4000/usuario_contrasena/', [
                "USUARIO" => $request->input("USUARIO"),
            ]);
            
            $variableExiste = json_decode($variableLogin, true);

            if (count($variableExiste) > 0) {
                $variablePreguntas = Http::post('http://82.180.162.18:4000/pregunta_usuario/JOSUE', [
                    "USUARIO" => $request->input("USUARIO"),
                ]);
        
                $variable = $request->input("USUARIO");
                $preguntasUsuario = json_decode($variablePreguntas, true);
        
                return view('AXE/cambioContrasena', compact('variable', 'preguntasUsuario'));

            }else{
                return view('AXE/login');
            }

        } catch (\Exception $e) {

            return "Ha ocurrido un error: " . $e->getMessage();
        }
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
