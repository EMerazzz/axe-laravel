<?php

namespace App\Http\Controllers\AXE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class docentesAsignaturaController extends Controller
{
    private $apiUrl = 'http://localhost:4000/docentes_asignaturas'; // Declaración de la variable de la URL de la API
    public function docentesAsignatura()
    {
        // Obtener los datos de personas desde el controlador PersonasController
        $docentesController = new docentesController();
        $docentes = Http::get('http://localhost:4000/docentes');
        $docentesArreglo = json_decode($docentes, true);

        // Obtener los datos
        $docentesAsignatura = Http::get($this->apiUrl);
        $docentesAsignaturaArreglo = json_decode($docentesAsignatura, true);

        return view('AXE.docentesAsignatura', compact('docentesArreglo', 'docentesAsignaturaArreglo'));
    }

    public function nuevo_docentesAsignatura(Request $request)
    {
        $nuevo_docentesAsignatura = Http::post($this->apiUrl, [
            "COD_DOCENTE" => $request->input("COD_DOCENTE"),
            "COD_ASIGNATURA" => $request->input("COD_ASIGNATURA"),
            "HORAS_SEMANALES" => $request->input("HORAS_SEMANALES"),
        ]);

      
        if ($nuevo_docentesAsignatura->successful()) {
            return redirect('/docentesAsignatura')->with('message', [
                'type' => 'success',
                'text' => 'Agregado exitosamente.'
            ]);
        } else {
            return redirect('/docentesAsignatura')->with('message', [
                'type' => 'error',
                'text' => 'No se pudo Agregar.'
            ]);
        }
    }

    public function modificar_docentesAsignatura(Request $request)
    {
        $modificar_docentesAsignatura=  Http::put($this->apiUrl.'/'. $request->input("COD_DOCENTE_ASIGNATURA"), [
            "COD_DOCENTE" => $request->input("COD_DOCENTE"),
            "COD_ASIGNATURA" => $request->input("COD_ASIGNATURA"),
            "HORAS_SEMANALES" => $request->input("HORAS_SEMANALES")
        ]);

        if ($modificar_docentesAsignatura->successful()) {
            return redirect('/docentesAsignatura')->with('message', [
                'type' => 'success',
                'text' => 'Modificado exitosamente.'
            ]);
        } else {
            return redirect('/docentesAsignatura')->with('message', [
                'type' => 'error',
                'text' => 'No se pudo modificar.'
            ]);
        }
    }
}