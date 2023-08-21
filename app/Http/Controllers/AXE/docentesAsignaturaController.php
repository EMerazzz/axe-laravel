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
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        // Obtener los datos de personas desde el controlador PersonasController
        $docentesController = new docentesController();
        $docentes = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://localhost:4000/docentes');
        $docentesArreglo = json_decode($docentes, true);

        // Obtener los datos
        $docentesAsignatura = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl);
        $docentesAsignaturaArreglo = json_decode($docentesAsignatura, true);

        return view('AXE.docentesAsignatura', compact('docentesArreglo', 'docentesAsignaturaArreglo'));
    }

    public function nuevo_docentesAsignatura(Request $request)
    {
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        $nuevo_docentesAsignatura = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post($this->apiUrl, [
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
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        $modificar_docentesAsignatura= Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put($this->apiUrl.'/'. $request->input("COD_DOCENTE_ASIGNATURA"), [
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