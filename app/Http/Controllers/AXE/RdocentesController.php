<?php

namespace App\Http\Controllers\AXE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class RdocentesController extends Controller
{
    private $apiUrl = 'http://82.180.162.18:4000/docentes'; // Declaración de la variable de la URL de la API
    public function Rdocentes()
    {
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        // Obtener los datos de personas desde el controlador PersonasController
        $personasController = new personasController();
        $personas = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://82.180.162.18:4000/personas');
        $personasArreglo = json_decode($personas, true);

        // Obtener los datos docentes
        $Rdocentes = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl);
        $docentesArreglo = json_decode($Rdocentes, true);

         // Obtener los datos de nivel academico desde el controlador nivel_academicoController
         $nivel_academicoController = new nivel_academicoController();
         $nivel_academico = Http::withHeaders([
             'Authorization' => 'Bearer ' . $token,
         ])->get('http://82.180.162.18:4000/nivel_academico');
         $nivel_academicoArreglo = json_decode($nivel_academico,true);
 

        return view('AXE.Rdocentes', compact('personasArreglo', 'docentesArreglo','nivel_academicoArreglo'));
    }
}