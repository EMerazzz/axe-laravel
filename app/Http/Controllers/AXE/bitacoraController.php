<?php

namespace App\Http\Controllers\AXE;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class bitacoraController extends Controller


{
    private $apiUrl = 'http://82.180.162.18:4000/bitacora'; // Declaración de la variable de la URL de la API

      public function bitacora()
    {$cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
       
        // Obtener los datos de teléfonos
        $bitacora = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl);
        $bitacoraArreglo = json_decode($bitacora, true);
       
        // Retornar la vista con ambos conjuntos de datos
        return view('AXE.bitacora', compact('bitacoraArreglo'));
    }
   
}