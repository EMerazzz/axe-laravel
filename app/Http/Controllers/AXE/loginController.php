<?php
namespace App\Http\Controllers\AXE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cookie;

class loginController extends Controller
{   
    public function login(){
       return view('AXE/login');
    }
    
    public function ingresar(Request $request ){
        $variableLogin = Http::post('http://localhost:4000/login', [
            "USUARIO" => $request->input("USUARIO"),
            "CONTRASENA" => $request->input("CONTRASENA"),
        ]);
      
        $variable = json_decode($variableLogin, true);
        if (count($variable) > 1) {
            // Encriptar el token antes de establecer la cookie
            $valorEncriptado = encrypt($variable['token']);
            
            // Establecer la cookie encriptada
            return redirect('AXE')->withCookie(Cookie::make('token', $valorEncriptado, 0, "./"));
        } else {
            $errorMessage =  $variable['mensaje'];
            return redirect('login')->with('errorMessage', $errorMessage);
        }
    }
    public function logout(Request $request){
        // Eliminar la cookie de token
        return redirect('login')->withCookie(Cookie::forget('token'));
    }

    public function existeUsuario(Request $request){
        $variableLogin = Http::post('http://localhost:4000/usuario_contrasena/', [
            "USUARIO" => $request->input("USUARIO"),
        ]);
        
        $variable = $request->input("USUARIO");
        //$variable = json_decode($variableLogin, true);

        return view('AXE/cambioContrasena', compact('variable'));
    }

    public function cambiarContrasena(Request $request){
        $variableLogin = Http::post('http://localhost:4000/cambiarContrasena/', [
            "USUARIO" => $request->input("USUARIO"),
            "CONTRASENA" => $request->input("CONTRASENA"),
        ]);
      
        $variable = json_decode($variableLogin, true);
        
        
        dd($variable);
        return view('AXE/cambioContrasena');
    }
}
