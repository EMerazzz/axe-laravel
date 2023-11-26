<?php

namespace App\Http\Controllers\AXE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class preguntas_usuarioController extends Controller
{
    private $apiUrl = 'http://82.180.162.18:4000/usuario_pregunta/'; // Declaración de la variable de la URL de la API

    //Version obsoleta
    public function nueva_pregunta1(Request $request)
    {
      $Usuario = $_COOKIE["Usuario"];

      $COD_USUARIO_RECIBIDO = Http::post('http://82.180.162.18:4000/dame_cod_usuario', [
        "USUARIO" =>  $Usuario
    ]);

    $COD_USUARIO = json_decode( $COD_USUARIO_RECIBIDO, true);
    $COD_USUARIO = $COD_USUARIO[0]['COD_USUARIO'];

   

    $nueva_pregunta = Http::post($this->apiUrl, [
        "PREGUNTA" => $request->input("PREGUNTA"),
        "RESPUESTA" =>  $request->input("RESPUESTA"),
        "COD_USUARIO" => $COD_USUARIO,
    ]);
    $mensaje = 'Pregunta agregada exitosamente';

    $TOTAL_PREGUNTAS_USUARIO = Http::post('http://82.180.162.18:4000/cuenta_preguntas', [
        "COD_USUARIO" =>  $COD_USUARIO,
        "USUARIO" =>  $Usuario
    ]);
    
        $TOTALPREGUNTAS = json_decode( $TOTAL_PREGUNTAS_USUARIO, true);
        $TOTALPREGUNTAS = $TOTALPREGUNTAS['COUNT(*)']; 

      // Verificar si la solicitud fue exitosa y redireccionar con mensaje de éxito o error
      if ($nueva_pregunta ->successful()) {
        return view('AXE/establecer_preguntas', compact('mensaje', 'Usuario', 'TOTALPREGUNTAS'));
    } 
    }
<<<<<<< HEAD

    // VERSION DE TRABAJO
    public function nueva_pregunta(Request $request)
    {
      $Usuario = $_COOKIE["Usuario"];

      $COD_USUARIO_RECIBIDO = Http::post('http://82.180.162.18:4000/dame_cod_usuario', [
        "USUARIO" =>  $Usuario
    ]);

    $COD_USUARIO = json_decode( $COD_USUARIO_RECIBIDO, true);
    $COD_USUARIO = $COD_USUARIO[0]['COD_USUARIO'];
   

    $nueva_pregunta = Http::post($this->apiUrl, [
        "COD_PREGUNTA" => $request->input("COD_PREGUNTA"),
        "COD_USUARIO" =>  $COD_USUARIO,
        "RESPUESTA" => $request->input("RESPUESTA"),
    ]);
    $mensaje = 'Pregunta agregada exitosamente';

    $PREGUNTAS_USUARIO_RECIBIDAS = Http::post('http://82.180.162.18:4000/preguntaUsuario/', [
      "USUARIO" =>  $Usuario
  ]);

    $PREGUNTAS_USUARIO = json_decode($PREGUNTAS_USUARIO_RECIBIDAS, true);
    

    $TOTAL_PREGUNTAS_USUARIO = Http::post('http://82.180.162.18:4000/cuenta_preguntas', [
        "COD_USUARIO" =>  $COD_USUARIO,
        "USUARIO" =>  $Usuario
    ]);
    
    $TOTALPREGUNTAS = json_decode( $TOTAL_PREGUNTAS_USUARIO, true);
    $TOTALPREGUNTAS = $TOTALPREGUNTAS['COUNT(*)']; 


    $CAN_PREGUNTAS_SOLICITADAS = Http::get('http://82.180.162.18:4000/preguntasSolicitadas');
                    

    $CAN_PREGUNTAS_SOLICITADAS = json_decode( $CAN_PREGUNTAS_SOLICITADAS, true);
    $CAN_PREGUNTAS_SOLICITADAS = $CAN_PREGUNTAS_SOLICITADAS['VALOR']; 


      // Verificar si la solicitud fue exitosa y redireccionar con mensaje de éxito o error
        
      if ($nueva_pregunta ->successful()) {
        return view('AXE/establecer_preguntas', compact('mensaje', 'Usuario', 'PREGUNTAS_USUARIO', 'TOTALPREGUNTAS', 'CAN_PREGUNTAS_SOLICITADAS'));
        //return view('AXE/establecer_preguntas', compact('mensaje', 'Usuario', 'TOTALPREGUNTAS'));
    } 

    }

}
=======
}
>>>>>>> 647e73e89a9af7f48bb865db9d721c513d21874e
