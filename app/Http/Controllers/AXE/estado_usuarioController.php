<?php

namespace App\Http\Controllers\AXE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use DateTime;

class estado_usuarioController extends Controller
{
    private $apiUrl = 'http://82.180.162.18:4000/estado_usuario'; // Declaración de la variable de la URL de la API
    
    public function estado_usuario()
    {
        $cookieEncriptada = request()->cookie('token');//trae la cookie encriptada
        $token = decrypt($cookieEncriptada);//desencripta la cookie
        //dd($token);
        $estado_usuario = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl);
        $estado_usuarioArreglo = json_decode($estado_usuario, true);

        $UsuarioValue = $_COOKIE["Usuario"];
        $OBJETO = "ESTADO USUARIO";
        $permisos = Http::post('http://82.180.162.18:4000/permisos_usuario',[
                "USUARIO" => $UsuarioValue,
                "OBJETO" =>  $OBJETO,
]);
$permisosDisponibles = json_decode($permisos, true);

        return view('AXE.estado_usuario', compact('estado_usuarioArreglo', 'permisosDisponibles'));
    }

    public function nuevo_estado_usuario(Request $request)
    {
        $cookieEncriptada = request()->cookie('token');//trae la cookie encriptada
        $token = decrypt($cookieEncriptada);//desencripta la cookie
       
        // Obtener todas las personas desde la API
        $todas_los_estado_usuarios = Http::get($this->apiUrl);
    
      
        // Enviar la solicitud POST a la API para agregar la nueva persona
        $nuevo_estado_usuario = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post($this->apiUrl, [
            "DESCRIPCION" => $request->input("DESCRIPCION"),
        ]);
    
        // Verificar si la solicitud fue exitosa y redireccionar con mensaje de éxito o error
        if ($nuevo_estado_usuario->successful()) {
            return redirect('/estado_usuario')->with('message', [
                'type' => 'success',
                'text' => 'Estado Usuario agregado exitosamente.'
            ]);
        } else {
            return redirect('/usuarios')->with('message', [
                'type' => 'error',
                'text' => 'No se pudo agregar el Estado Usuario.'
            ]);
        }
    }
    

    public function modificar_estado_usuario(Request $request)
    {
        $cookieEncriptada = request()->cookie('token');//trae la cookie encriptada
        $token = decrypt($cookieEncriptada);//desencripta la cookie
        
        $modificar_estado_usuario = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put($this->apiUrl.'/'.$request->input("COD_ESTADO_USUARIO"), [
            
            "DESCRIPCION" => $request->input("DESCRIPCION"),
               
        ]);
        if ($modificar_estado_usuario->successful()) {
            return redirect('/estado_usuario')->with('message', [
                'type' => 'success',
                'text' => 'Estado modificado exitosamente.'
            ]);
        } else {
            return redirect('/estado_usuario')->with('message', [
                'type' => 'error',
                'text' => 'No se pudo modificar el Estado.'
            ]);
        }
    }
}