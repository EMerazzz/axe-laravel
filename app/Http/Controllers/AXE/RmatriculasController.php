<?php

namespace App\Http\Controllers\AXE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class RmatriculasController extends Controller


{
    
    private $apiUrl = 'http://82.180.162.18:4000/matricula'; // Declaración de la variable de la URL de la API

    public function Rmatriculas()

    {$cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        // Obtener los datos de personas desde el controlador PersonasController
        $personasController = new personasController();
        $personas = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://82.180.162.18:4000/personas');
        $personasArreglo = json_decode($personas, true);
        // Obtener los datos de nivel academico desde el controlador nivel_academicoController
        $nivel_academicoController = new nivel_academicoController();
        $nivel_academico = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://82.180.162.18:4000/nivel_academico');
        $nivel_academicoArreglo = json_decode($nivel_academico,true);

        // Obtener los datos de año academico desde el controlador anio_academicoController
        $anio_academicoController = new anio_academicoController();
        $anio_academico = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://82.180.162.18:4000/anio_academico/');
        $anio_academicoArreglo = json_decode($anio_academico,true);

        // Obtener los datos de Jornada desde el controlador jornadasController
        $jornadasController = new jornadasController();
        $jornadas = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://82.180.162.18:4000/jornadas/');
        $jornadasArreglo = json_decode($jornadas,true);
        
         // Obtener los datos de secciones desde el controlador seccionesController
         $seccionesController = new seccionesController();
         $secciones = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://82.180.162.18:4000/Secciones/');
         $seccionesArreglo = json_decode($secciones,true);
            // Obtener los datos de personas desde el controlador padresController
            $padresController = new padresController();
            $padres = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('http://82.180.162.18:4000/padres_tutores');
            $padresArreglo = json_decode($padres, true);
            
        // Obtener los datos de teléfonos
        $Rmatriculas = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl);
        $matriculaArreglo = json_decode($Rmatriculas, true);
       
        // Retornar la vista con ambos conjuntos de datos
        return view('AXE.Rmatriculas', compact('matriculaArreglo','personasArreglo','nivel_academicoArreglo','anio_academicoArreglo','jornadasArreglo','seccionesArreglo','padresArreglo'));
    }


   
}