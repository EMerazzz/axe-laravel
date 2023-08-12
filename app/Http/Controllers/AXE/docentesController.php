<?php

namespace App\Http\Controllers\AXE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class docentesController extends Controller
{
    private $apiUrl = 'http://localhost:4000/docentes'; // Declaración de la variable de la URL de la API
    public function docentes()
    {
        // Obtener los datos de personas desde el controlador PersonasController
        $personasController = new PersonasController();
        $personas = Http::get('http://localhost:4000/personas');
        $personasArreglo = json_decode($personas, true);

        // Obtener los datos de teléfonos
        $docentes = Http::get($this->apiUrl);
        $docentesArreglo = json_decode($docentes, true);

        return view('AXE.docentes', compact('personasArreglo', 'docentesArreglo'));
    }

    public function nuevo_docente(Request $request)
    {
        $personaSeleccionadaId = $request->input("COD_PERSONA");
        // Obtener los datos de la persona seleccionada por su ID desde la API de personas
        $personaSeleccionada = Http::get("http://localhost:4000/personas/{$personaSeleccionadaId}");
       // dd($personaSeleccionada);
        $personaSeleccionadaData = json_decode($personaSeleccionada, true);
        //dd($personaSeleccionadaData);
       
            // Crear una solicitud para agregar un nuevo docente con los datos combinados
            $nuevo_docente = Http::post($this->apiUrl, [
                "COD_PERSONA" => $request->input("COD_PERSONA"),
                "NOMBRE_DOCENTE" => $personaSeleccionadaData[0]['NOMBRE']. ' ' . $personaSeleccionadaData[0]['APELLIDO'],
                "ESPECIALIDAD" => $request->input("ESPECIALIDAD"),
                "GRADO_ENSENIANZA" => $request->input("GRADO_ENSENIANZA"),
            ]);

            // Verificar si la solicitud fue exitosa y redireccionar con mensaje de éxito o error
            if ($nuevo_docente ->successful()) {
                return redirect('/docentes')->with('message', [
                    'type' => 'success',
                    'text' => 'Agregado exitosamente.'
                ]);
            } else {
                return redirect('/docentes')->with('message', [
                    'type' => 'error',
                    'text' => 'No se pudo agregar.'
                ]);
            }
    }
    

    public function modificar_docente(Request $request)
    {
        $modificar_docente=  Http::put($this->apiUrl.'/'. $request->input("COD_DOCENTE"), [
            "COD_PERSONA" => $request->input("COD_PERSONA"),
            "NOMBRE_DOCENTE" => $request->input("NOMBRE_DOCENTE"),
            "ESPECIALIDAD" => $request->input("ESPECIALIDAD"),
            "GRADO_ENSENIANZA" => $request->input("GRADO_ENSENIANZA"),
        ]);

       // Verificar si la solicitud fue exitosa y redireccionar con mensaje de éxito o error
       if ($modificar_docente->successful()) {
        return redirect('/docentes')->with('message', [
            'type' => 'success',
            'text' => 'Modificado exitosamente.'
        ]);
    } else {
        return redirect('/docentes')->with('message', [
            'type' => 'error',
            'text' => 'No se pudo modificar.'
        ]);
    }
    }
}

