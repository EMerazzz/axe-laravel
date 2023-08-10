<?php

namespace App\Http\Controllers\AXE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class docenteAsignaturaController extends Controller
{
    private $apiUrl = 'http://localhost:4000/docentes_asignaturas'; // Declaración de la variable de la URL de la API
    public function docenteAsignatura()
    {
        // Obtener los datos de personas desde el controlador PersonasController
        $docentesController = new PersonasController();
        $docentes = Http::get('http://localhost:4000/docentes');
        $docentesArreglo = json_decode($docentes, true);

        // Obtener los datos
        $docentesAsignatura = Http::get($this->apiUrl);
        $docentesAsignaturaArreglo = json_decode($docentesAsignatura, true);

        return view('AXE.docentesAsignatura', compact('docentesArreglo', 'docentesAsignaturaArreglo'));
    }

    public function nuevo_docenteAsignatura(Request $request)
    {
        $nuevo_docentesAsignatura = Http::post($this->apiUrl, [
            "COD_DOCENTE" => $request->input("COD_DOCENTE"),
            "COD_ASIGNATURA" => $request->input("COD_ASIGNATURA"),
            "HORAS_SEMANALES" => $request->input("HORAS_SEMANALES"),
        ]);

      // Verificar si la solicitud fue exitosa y redireccionar con mensaje de éxito o error
      if ($nuevo_docentesAsignatura->successful()) {
        return redirect('/docentesAsignatura')->with('success', 'Agregado exitosamente.');
    } else {
        return redirect('/docentesAsignatura')->with('error', 'No se pudo agregar.');
    }
    }

    public function modificar_docenteAsignatura(Request $request)
    {
        $modificar_docentesAsignatura=  Http::put($this->apiUrl.'/'. $request->input("COD_DOCENTE_ASIGNATURA"), [
            "COD_DOCENTE" => $request->input("COD_DOCENTE"),
            "COD_ASIGNATURA" => $request->input("COD_ASIGNATURA"),
            "HORAS_SEMANALES" => $request->input("HORAS_SEMANALES")
        ]);

       // Verificar si la solicitud fue exitosa y redireccionar con mensaje de éxito o error
       if ($modificar_docentesAsignatura->successful()) {
        return redirect('/docentesAsignatura')->with('success', 'Agregado exitosamente.');
    } else {
        return redirect('/docentesAsignatura')->with('error', 'No se pudo agregar.');
    }
    }
}
