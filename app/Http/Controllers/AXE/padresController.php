<?php

namespace App\Http\Controllers\AXE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class padresController extends Controller
{
    private $apiUrl = 'http://localhost:4000/padres_tutores'; // Declaración de la variable de la URL de la API
    public function padres()
    {
        // Obtener los datos de personas desde el controlador PersonasController
        $personasController = new PersonasController();
        $personas = Http::get('http://localhost:4000/personas');
        $personasArreglo = json_decode($personas, true);

        // Obtener los datos de teléfonos
        $padres = Http::get($this->apiUrl);
        $padresArreglo = json_decode($padres, true);

        return view('AXE.padres', compact('personasArreglo', 'padresArreglo'));
    }

    public function nuevo_padre(Request $request)
    {
        $personaSeleccionadaId = $request->input("COD_PERSONA");
        // Obtener los datos de la persona seleccionada por su ID desde la API de personas
        $personaSeleccionada = Http::get("http://localhost:4000/personas/{$personaSeleccionadaId}");
       // dd($personaSeleccionada);
        $personaSeleccionadaData = json_decode($personaSeleccionada, true);
        //dd($personaSeleccionadaData);
       
            // Crear una solicitud para agregar un nuevo docente con los datos combinados
            $nuevo_padre = Http::post($this->apiUrl, [
                "COD_PERSONA" => $request->input("COD_PERSONA"),
                "NOMBRE_PADRE_TUTOR" => $personaSeleccionadaData[0]['NOMBRE'],
                "APELLIDO_PADRE_TUTOR" => $personaSeleccionadaData[0]['APELLIDO'],
                "OCUPACION_PADRE_TUTOR" => $request->input("OCUPACION_PADRE_TUTOR"),
                "RELACION_PADRE_ESTUDIANTE" => $request->input("RELACION_PADRE_ESTUDIANTE"),
            ]);

            // Verificar si la solicitud fue exitosa y redireccionar con mensaje de éxito o error
            if ($nuevo_padre ->successful()) {
                return redirect('/padres')->with('message', [
                    'type' => 'success',
                    'text' => 'Agregado exitosamente.'
                ]);
            } else {
                return redirect('/padres')->with('message', [
                    'type' => 'error',
                    'text' => 'No se pudo agregar.'
                ]);
            }
        
    }
    

    public function modificar_padre(Request $request)
    {
        $modificar_padre=  Http::put($this->apiUrl.'/'. $request->input("COD_PADRE_TUTOR"), [
           
            "OCUPACION_PADRE_TUTOR" => $request->input("OCUPACION_PADRE_TUTOR"),
            "RELACION_PADRE_ESTUDIANTE" => $request->input("RELACION_PADRE_ESTUDIANTE"),
        ]);

       // Verificar si la solicitud fue exitosa y redireccionar con mensaje de éxito o error
       if ($modificar_padre->successful()) {
        return redirect('/padres')->with('message', [
            'type' => 'success',
            'text' => 'Modificado exitosamente.'
        ]);
    } else {
        return redirect('/padres')->with('message', [
            'type' => 'error',
            'text' => 'No se pudo modificar .'
        ]);
    }
    }
}
