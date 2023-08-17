<?php

namespace App\Http\Controllers\AXE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use DateTime;

class anio_academicoController extends Controller
{
    private $apiUrl = 'http://localhost:4000/anio_academico/'; // Declaración de la variable de la URL de la API
    public function anio_academico()
    {
        $anio_academico = Http::get($this->apiUrl);
        $anioArreglo = json_decode($anio_academico, true);
        return view('AXE.anio_academico', compact('anioArreglo'));
    }

    public function nuevo_anio_academico(Request $request)
    {
       
        // Obtener todas las personas desde la API
        $todas_los_anios = Http::get($this->apiUrl);
    
        
        // Enviar la solicitud POST a la API para agregar la nueva persona
        $nuevo_anio_academico = Http::post($this->apiUrl, [
            "descripcion" => $request->input("descripcion"),
        ]);
    
        // Verificar si la solicitud fue exitosa y redireccionar con mensaje de éxito o error
        if ($nuevo_anio_academico->successful()) {
            return redirect('/anio_academico')->with('message', [
                'type' => 'success',
                'text' => 'Año academico agregado exitosamente.'
            ]);
        } else {
            return redirect('/anio_academico')->with('message', [
                'type' => 'error',
                'text' => 'No se pudo agregar el año academico.'
            ]);
        }
    }
    

    public function modificar_anio_academico(Request $request)
    {
        
        $modificar_anio_academico = Http::put($this->apiUrl.'/'.$request->input("COD_ANIO_ACADEMICO"), [
            "descripcion" => $request->input("descripcion"),
            
        ]);
        if ($modificar_anio_academico->successful()) {
            return redirect('/anio_academico')->with('message', [
                'type' => 'success',
                'text' => 'Año academico modificado exitosamente.'
            ]);
        } else {
            return redirect('/anio_academico')->with('message', [
                'type' => 'error',
                'text' => 'No se pudo modificar el año academico.'
            ]);
        }
    }
}