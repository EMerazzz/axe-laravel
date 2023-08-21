<?php

namespace App\Http\Controllers\AXE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class estudiantesController extends Controller
{
    private $apiUrl = 'http://localhost:4000/estudiantes'; // Declaración de la variable de la URL de la API
    public function estudiantes()
    {
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        // Obtener los datos de personas desde el controlador PersonasController
        $personasController = new PersonasController();
        $personas = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://localhost:4000/personas');
        $personasArreglo = json_decode($personas, true);
        // Obtener los datos de personas desde el controlador padresController
        $padresController = new padresController();
        $padres = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://localhost:4000/padres_tutores');
        $padresArreglo = json_decode($padres, true);
        

        // Obtener los datos de teléfonos
        $estudiantes = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl);
        $estudiantesArreglo = json_decode($estudiantes, true);

        return view('AXE.estudiantes', compact('personasArreglo', 'estudiantesArreglo','padresArreglo'));
    }

    public function nuevo_estudiante(Request $request)
    {
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        $personaSeleccionadaId = $request->input("COD_PERSONA");
        // Obtener los datos de la persona seleccionada por su ID desde la API de personas
        $personaSeleccionada = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get("http://localhost:4000/personas/{$personaSeleccionadaId}");
       // dd($personaSeleccionada);
        $personaSeleccionadaData = json_decode($personaSeleccionada, true);
        //dd($personaSeleccionadaData);
        $nuevo_estudiante = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post($this->apiUrl, [
            "COD_PERSONA" => $request->input("COD_PERSONA"),
            "COD_PADRE_TUTOR" => $request->input("COD_PADRE_TUTOR"),
            "COD_NIVACAD_ANIOACAD" => $request->input("COD_NIVACAD_ANIOACAD"),
            "NOMBRE_ESTUDIANTE" => $personaSeleccionadaData[0]['NOMBRE'],
            "APELLIDO_ESTUDIANTE" => $personaSeleccionadaData[0]['APELLIDO'],
            "JORNADA_ESTUDIANTE" => $request->input("JORNADA_ESTUDIANTE"),

        ]);

      // Verificar si la solicitud fue exitosa y redireccionar con mensaje de éxito o error
      if ($nuevo_estudiante ->successful()) {
        return redirect('/estudiantes')->with('message', [
            'type' => 'success',
            'text' => 'Agregado exitosamente.'
        ]);
    } else {
        return redirect('/estudiantes')->with('message', [
            'type' => 'error',
            'text' => 'No se pudo agregar.'
        ]);
    }
    }

    public function modificar_estudiante(Request $request)
    {
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        $modificar_estudiante =  Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put($this->apiUrl.'/'. $request->input("COD_ESTUDIANTE"), [
            "JORNADA_ESTUDIANTE" => $request->input("JORNADA_ESTUDIANTE"),
            "COD_NIVACAD_ANIOACAD" => $request->input("COD_NIVACAD_ANIOACAD"),
        ]);

       // Verificar si la solicitud fue exitosa y redireccionar con mensaje de éxito o error
       if ($modificar_estudiante->successful()) {
        return redirect('/estudiantes')->with('message', [
            'type' => 'success',
            'text' => 'Modificado exitosamente.'
        ]);
    } else {
        return redirect('/estudiantes')->with('message', [
            'type' => 'error',
            'text' => 'No se pudo modificar .'
        ]);
    }
    }
}
