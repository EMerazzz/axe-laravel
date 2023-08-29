<?php

namespace App\Http\Controllers\AXE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class preguntas_usuarioController extends Controller
{
    private $apiUrl = 'http://82.180.162.18:4000/pregunta_usuario'; // Declaración de la variable de la URL de la API

    public function nueva_pregunta(Request $request)
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
        $TOTALPREGUNTAS = $TOTALPREGUNTAS['COUNT(PREGUNTA)']; 

      // Verificar si la solicitud fue exitosa y redireccionar con mensaje de éxito o error
      if ($nueva_pregunta ->successful()) {
        return view('AXE/establecer_preguntas', compact('mensaje', 'Usuario', 'TOTALPREGUNTAS'));
    } 
    }
}