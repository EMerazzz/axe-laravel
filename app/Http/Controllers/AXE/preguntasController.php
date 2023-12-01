<?php

namespace App\Http\Controllers\AXE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use DateTime;

class preguntasController extends Controller

{
    private $apiUrl = 'http://82.180.162.18:4000/preguntas'; // Declaración de la variable de la URL de la API
   
    public function preguntas()
    {
    
        $cookieEncriptada = request()->cookie('token');//trae la cookie encriptada
        $token = decrypt($cookieEncriptada);//desencripta la cookie
       

       // dd ( $UsuarioValue);
        $preguntas = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl);

        $preguntasArreglo = json_decode($preguntas, true);


        $UsuarioValue = $_COOKIE["Usuario"];
        $OBJETO = "PREGUNTAS";
            $permisos = Http::post('http://82.180.162.18:4000/permisos_usuario',[
                "USUARIO" => $UsuarioValue,
                "OBJETO" =>  $OBJETO,
            ]);
            $permisosDisponibles = json_decode($permisos, true);

        $permisosDisponibles = json_decode($permisos, true);
        return view('AXE.preguntas', compact('preguntasArreglo', 'permisosDisponibles'));
    }

    public function nueva_preguntas(Request $request ){
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        $nueva_preguntas = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post($this->apiUrl,[
        "PREGUNTA" => $request->input("PREGUNTA"),
        ]);
         // Verificar si la solicitud fue exitosa y redireccionar con mensaje de éxito o error
         if ($nueva_preguntas ->successful()) {
            return redirect('/preguntas')->with('message', [
                'type' => 'success',
                'text' => 'Agregado exitosamente.'
            ]);
        } else {
            return redirect('/preguntas')->with('message', [
                'type' => 'error',
                'text' => 'No se pudo agregar.'
            ]);
        }
    }

    public function modificar_preguntas(Request $request ){
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        $modificar_preguntas = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put($this->apiUrl.'/'.$request->input("COD_PREGUNTA"),[
        "COD_PREGUNTA"=> $request->input("COD_PREGUNTA"),
        "PREGUNTA" => $request->input("PREGUNTA"),
        ]);
       //print_r([$putformatos]);die();

       if ($modificar_preguntas->successful()) {
        return redirect('/preguntas')->with('message', [
            'type' => 'success',
            'text' => 'Modificado exitosamente.'
        ]);
    } else {
        return redirect('/preguntas')->with('message', [
            'type' => 'error',
            'text' => 'No se pudo modificar .'
        ]);
    }
    }

    public function delete_preguntas(Request $request)
    {
        try {
            $cookieEncriptada = request()->cookie('token');
            $token = decrypt($cookieEncriptada);
    
            $delete_preguntas = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->put('http://82.180.162.18:4000/del_preguntas/'.$request->input("COD_PREGUNTA"));
    
            // Verificar si la solicitud fue exitosa
            if ($delete_preguntas->successful()) {
                return redirect('/preguntas')->with('message', [
                    'type' => 'success',
                    'text' => 'Pregunta eliminada correctamente.'
                ]);
            } else {
                // Manejar casos de error
                $statusCode = $delete_preguntas->status();
                return redirect('/preguntas')->with('message', [
                    'type' => 'error',
                    'text' => "No se pudo eliminar. Código de estado: $statusCode"
                ]);
            }
        } catch (\Exception $e) {
            // Manejar excepciones
            return redirect('/preguntas')->with('message', [
                'type' => 'error',
                'text' => "Error al intentar desactivar la pregunta: " . $e->getMessage()
            ]);
        }
    }
    


}