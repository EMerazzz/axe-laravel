<?php

namespace App\Http\Controllers\AXE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class preguntas_usuariosController extends Controller
{
    private $apiUrl = 'http://82.180.162.18:4000/pregunta_usuario'; // Declaración de la variable de la URL de la API
    
    public function pregunta_usuarios(){
        $UsuarioValue = $_COOKIE["Usuario"];
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
          // Obtener los datos de usuarios desde el controlador UsuariosController
          $usuariosController = new usuariosController();
          $usuarios = Http::withHeaders([
              'Authorization' => 'Bearer ' . $token,
          ])->get('http://82.180.162.18:4000/usuarios');
          $usuariosArreglo = json_decode($usuarios, true);

       $pregunta_usuario = Http::withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->get($this->apiUrl);
       $pregunta_usuarioArreglo = json_decode($pregunta_usuario,true);
       //return $reservaciones;
       return view('AXE.preguntas_usuario', compact('pregunta_usuarioArreglo', 'usuariosArreglo'));
       
    }

    public function nueva_pregunta_usuario(Request $request ){
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        $nueva_pregunta_usuario = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post($this->apiUrl,[
        "PREGUNTA" => $request->input("PREGUNTA"),
        "RESPUESTA" => $request->input("RESPUESTA"),
        "COD_USUARIO" => $request->input("COD_USUARIO"),
        ]);
         // Verificar si la solicitud fue exitosa y redireccionar con mensaje de éxito o error
         if ($nueva_pregunta_usuario ->successful()) {
            return redirect('/pregunta_usuario')->with('message', [
                'type' => 'success',
                'text' => 'Agregado exitosamente.'
            ]);
        } else {
            return redirect('/pregunta_usuario')->with('message', [
                'type' => 'error',
                'text' => 'No se pudo agregar.'
            ]);
        }
    }

    public function modificar_pregunta_usuario(Request $request ){
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        $modificar_pregunta_usuario = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put($this->apiUrl.'/'.$request->input("COD_PREGUNTA"),[
        "COD_PREGUNTA"=> $request->input("COD_PREGUNTA"),
        "PREGUNTA" => $request->input("PREGUNTA"),
        "RESPUESTA" => $request->input("RESPUESTA"),

        ]);
       //print_r([$putformatos]);die();

       if ($modificar_pregunta_usuario->successful()) {
        return redirect('/pregunta_usuario')->with('message', [
            'type' => 'success',
            'text' => 'Modificado exitosamente.'
        ]);
    } else {
        return redirect('/pregunta_usuario')->with('message', [
            'type' => 'error',
            'text' => 'No se pudo modificar .'
        ]);
    }
    }


}