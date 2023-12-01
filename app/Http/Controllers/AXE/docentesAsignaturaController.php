<?php

namespace App\Http\Controllers\AXE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class docentesAsignaturaController extends Controller
{
    private $apiUrl = 'http://82.180.162.18:4000/docentes_asignaturas'; // Declaración de la variable de la URL de la API
    public function docentesAsignatura()
    {
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        $UsuarioValue = $_COOKIE["Usuario"];
        // Obtener los datos de personas desde el controlador PersonasController
        $docentesController = new docentesController();
        $docentes = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://82.180.162.18:4000/docentes');
        $docentesArreglo = json_decode($docentes, true);

        // Obtener los datos
        $docentesAsignatura = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl);
        $docentesAsignaturaArreglo = json_decode($docentesAsignatura, true);

        $asignaturasController = new asignaturasController();
        $asignaturas = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://82.180.162.18:4000/asignaturas');
        $asignaturasArreglo = json_decode($asignaturas, true);

        return view('AXE.docentesAsignatura', compact('docentesArreglo', 'docentesAsignaturaArreglo','asignaturasArreglo'));
    }

    public function nuevo_docentesAsignatura(Request $request)
    {
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        $UsuarioValue = $_COOKIE["Usuario"];
        $nuevo_docentesAsignatura = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post($this->apiUrl, [
            "COD_DOCENTE" => $request->input("COD_DOCENTE"),
            "COD_ASIGNATURA" => $request->input("COD_ASIGNATURA"),
            "HORAS_SEMANALES" => $request->input("HORAS_SEMANALES"),
            "USUARIO_MODIFICADOR" => $UsuarioValue,
        ]);

       // dd(json_decode($nuevo_docentesAsignatura));
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
        $UsuarioValue = $_COOKIE["Usuario"];
        $modificar_docentesAsignatura= Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            ])->put($this->apiUrl.'/'.$request->input("COD_DOCENTE_ASIGNATURA"), [
            "COD_ASIGNATURA" => $request->input("COD_ASIGNATURA"),
            "HORAS_SEMANALES" => $request->input("HORAS_SEMANALES"),
            "USUARIO_MODIFICADOR" => $UsuarioValue,
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
  
    
    public function delete_docentesAsignatura(Request $request)
{
    try {
        // Obtener y desencriptar el token
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);

        // Realizar la solicitud HTTP para eliminar el docente asignatura
        $delete_docentesAsignatura = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put('http://82.180.162.18:4000/del_docentesAsignatura/'.$request->input("COD_DOCENTE_ASIGNATURA"));

        // Verificar si la solicitud fue exitosa
        if ($delete_docentesAsignatura->successful()) {
            // Redirigir con un mensaje de éxito
            return redirect('/docentesAsignatura')->with('message', [
                'type' => 'success',
                'text' => 'Eliminado correctamente.'
            ]);
        } else {
            // Si la solicitud no fue exitosa, manejar casos de error
            $statusCode = $delete_docentesAsignatura->status(); // Obtener el código de estado

            // Redirigir con un mensaje de error detallado
            return redirect('/docentesAsignatura')->with('message', [
                'type' => 'error',
                'text' => "No se puede desactivar el objeto. Código de estado: $statusCode"
            ]);
        }
    } catch (\Exception $e) {
        // Capturar y manejar excepciones
        return redirect('/docentesAsignatura')->with('message', [
            'type' => 'error',
            'text' => "Error al intentar eliminar el objeto: " . $e->getMessage()
        ]);
    }
}

        

}