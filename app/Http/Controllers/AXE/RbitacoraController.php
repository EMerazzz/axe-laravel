<?php

namespace App\Http\Controllers\AXE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class RbitacoraController extends Controller


{
   // private $apiUrl = 'http://localhost:4000/bitacora'; // Declaración de la variable de la URL de la API
   private $apiUrl = 'http://82.180.162.18:4000/bitacora'; // Declaración de la variable de la URL de la API

    public function Rbitacora()
    {$cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
       
        // Obtener los datos de teléfonos
        $Rbitacora = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl);
        $bitacoraArreglo = json_decode($Rbitacora, true);
       
        // Retornar la vista con ambos conjuntos de datos
        return view('AXE.Rbitacora', compact('bitacoraArreglo'));
    }


   
}