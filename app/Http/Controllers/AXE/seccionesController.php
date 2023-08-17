<?php

namespace App\Http\Controllers\AXE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use DateTime;

class seccionesController extends Controller
{
    private $apiUrl = 'http://localhost:4000/Secciones'; // Declaración de la variable de la URL de la API
    public function secciones()
    {
        $secciones = Http::get($this->apiUrl);
        $seccionesArreglo = json_decode($secciones, true);
        return view('AXE.secciones', compact('seccionesArreglo'));
    }

    public function nueva_seccion(Request $request)
    {
        
        // Enviar la solicitud POST a la API para agregar la nueva persona
        $nueva_seccion = Http::post($this->apiUrl, [
            "DESCRIPCION_SECCIONES" => $request->input("DESCRIPCION_SECCIONES"),
        ]);
    
        // Verificar si la solicitud fue exitosa y redireccionar con mensaje de éxito o error
        if ($nueva_seccion->successful()) {
            return redirect('/secciones')->with('message', [
                'type' => 'success',
                'text' => 'Sección agregada exitosamente.'
            ]);
        } else {
            return redirect('/secciones')->with('message', [
                'type' => 'error',
                'text' => 'No se pudo agregar la sección.'
            ]);
        }
    }
    

    public function modificar_seccion(Request $request)
    {
        
        $modificar_seccion = Http::put($this->apiUrl.'/'.$request->input("COD_SECCIONES"), [
            "DESCRIPCION_SECCIONES" => $request->input("DESCRIPCION_SECCIONES"),
            
        ]);
        if ($modificar_seccion->successful()) {
            return redirect('/secciones')->with('message', [
                'type' => 'success',
                'text' => 'Sección modificada exitosamente.'
            ]);
        } else {
            return redirect('/secciones')->with('message', [
                'type' => 'error',
                'text' => 'No se pudo modificar la sección.'
            ]);
        }
    }
}