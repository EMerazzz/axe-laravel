<?php

namespace App\Http\Controllers\AXE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use DateTime;

class jornadasController extends Controller
{
    private $apiUrl = 'http://localhost:4000/jornadas/'; // Declaración de la variable de la URL de la API
    public function jornadas()
    {
        $jornadas = Http::get($this->apiUrl);
        $jornadasArreglo = json_decode($jornadas, true);
        return view('AXE.jornadas', compact('jornadasArreglo'));
    }

    public function nueva_jornada(Request $request)
    {
       
        // Obtener todas las personas desde la API
        $todas_las_jornadas = Http::get($this->apiUrl);
    
        
        // Enviar la solicitud POST a la API para agregar la nueva persona
        $nueva_jornada = Http::post($this->apiUrl, [
            "DESCRIPCION_JOR" => $request->input("DESCRIPCION_JOR"),
        ]);
    
        // Verificar si la solicitud fue exitosa y redireccionar con mensaje de éxito o error
        if ($nueva_jornada->successful()) {
            return redirect('/jornadas')->with('message', [
                'type' => 'success',
                'text' => 'Jornada agregada exitosamente.'
            ]);
        } else {
            return redirect('/jornadas')->with('message', [
                'type' => 'error',
                'text' => 'No se pudo agregar la jornada.'
            ]);
        }
    }
    

    public function modificar_jornada(Request $request)
    {
        
        $modificar_jornada = Http::put($this->apiUrl.'/'.$request->input("COD_JORNADA"), [
            "DESCRIPCION_JOR" => $request->input("DESCRIPCION_JOR"),
            
        ]);
        if ($modificar_jornada->successful()) {
            return redirect('/jornadas')->with('message', [
                'type' => 'success',
                'text' => 'Jornada modificada exitosamente.'
            ]);
        } else {
            return redirect('/jornadas')->with('message', [
                'type' => 'error',
                'text' => 'No se pudo modificar la Jornada.'
            ]);
        }
    }
}