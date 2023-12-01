<?php

namespace App\Http\Controllers\AXE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class RpersonasController extends Controller
{
    private $apiUrl = 'http://82.180.162.18:4000/personas'; // Declaración de la variable de la URL de la API
    public function Rpersonas()
    {
    
        $cookieEncriptada = request()->cookie('token');//trae la cookie encriptada
        $token = decrypt($cookieEncriptada);//desencripta la cookie

        $Rpersonas = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl);

        $personasArreglo = json_decode($Rpersonas, true);
        return view('AXE.Rpersonas', compact('personasArreglo'));
    }

   
}