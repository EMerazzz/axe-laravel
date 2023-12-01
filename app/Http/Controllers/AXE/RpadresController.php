<?php

namespace App\Http\Controllers\AXE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class RpadresController extends Controller
{
    private $apiUrl = 'http://82.180.162.18:4000/padres_tutores'; // Declaración de la variable de la URL de la API
    public function Rpadres()
    {
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        // Obtener los datos de personas desde el controlador PersonasController
        $personasController = new personasController();
        $personas = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://82.180.162.18:4000/personas');
        $personasArreglo = json_decode($personas, true);

        // Obtener los datos de teléfonos
        $Rpadres =Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl);
        $padresArreglo = json_decode($Rpadres, true);
        return view('AXE.Rpadres', compact('personasArreglo', 'padresArreglo'));
    }
}