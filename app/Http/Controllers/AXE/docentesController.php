<?php

namespace App\Http\Controllers\AXE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class docentesController extends Controller
{
    private $apiUrl = 'http://82.180.162.18:4000/docentes'; // Declaración de la variable de la URL de la API
    public function docentes()
    {
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        // Obtener los datos de personas desde el controlador PersonasController
        $personasController = new personasController();
        $personas = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://82.180.162.18:4000/personas');
        $personasArreglo = json_decode($personas, true);

        // Obtener los datos docentes
        $docentes = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl);
        $docentesArreglo = json_decode($docentes, true);

         // Obtener los datos de nivel academico desde el controlador nivel_academicoController
         $nivel_academicoController = new nivel_academicoController();
         $nivel_academico = Http::withHeaders([
             'Authorization' => 'Bearer ' . $token,
         ])->get('http://82.180.162.18:4000/nivel_academico');
         $nivel_academicoArreglo = json_decode($nivel_academico,true);

         $UsuarioValue = $_COOKIE["Usuario"];
            $OBJETO = "DOCENTES";
            $permisos = Http::post('http://82.180.162.18:4000/permisos_usuario',[
                    "USUARIO" => $UsuarioValue,
                    "OBJETO" =>  $OBJETO,
            ]);
            $permisosDisponibles = json_decode($permisos, true);
 

        return view('AXE.docentes', compact('personasArreglo', 'docentesArreglo','nivel_academicoArreglo', 'permisosDisponibles'));
    }

    public function nuevo_docente(Request $request)
    {
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        $UsuarioValue = $_COOKIE["Usuario"];
        $personaSeleccionadaId = $request->input("COD_PERSONA");
        // Obtener los datos de la persona seleccionada por su ID desde la API de personas
        $personaSeleccionada = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get("http://82.180.162.18:4000/personas/{$personaSeleccionadaId}");
       // dd($personaSeleccionada);
        $personaSeleccionadaData = json_decode($personaSeleccionada, true);
        //dd($personaSeleccionadaData);
       
            // Crear una solicitud para agregar un nuevo docente con los datos combinados
            $nuevo_docente = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->post($this->apiUrl, [
                "COD_PERSONA" => $request->input("COD_PERSONA"),
                "NOMBRE_DOCENTE" => $personaSeleccionadaData[0]['NOMBRE']. ' ' . $personaSeleccionadaData[0]['APELLIDO'],
                "ESPECIALIDAD" => $request->input("ESPECIALIDAD"),
                "GRADO_ENSENIANZA" => $request->input("GRADO_ENSENIANZA"),
                "USUARIO_MODIFICADOR" => $UsuarioValue,
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
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        $UsuarioValue = $_COOKIE["Usuario"];
        $modificar_docente= Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put($this->apiUrl.'/'. $request->input("COD_DOCENTE"), [
            "COD_PERSONA" => $request->input("COD_PERSONA"),
            "NOMBRE_DOCENTE" => $request->input("NOMBRE_DOCENTE"),
            "ESPECIALIDAD" => $request->input("ESPECIALIDAD"),
            "GRADO_ENSENIANZA" => $request->input("GRADO_ENSENIANZA"),
            "USUARIO_MODIFICADOR" => $UsuarioValue,
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

    public function delete_docente(Request $request)
{
    $cookieEncriptada = request()->cookie('token');
    $token = decrypt($cookieEncriptada);

    $delete_docente = Http::withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->put('http://82.180.162.18:4000/del_docentes/'.$request->input("COD_DOCENTE"));

    if ($delete_docente->successful()) {
        return redirect('/docentes')->with('message', [
            'type' => 'success',
            'text' => 'Nivel Academico Eliminado.'
        ]);
    } else {
        // Manejar casos de error
        $statusCode = $delete_docente->status();
        return redirect('/docentes')->with('message', [
            'type' => 'error',
            'text' => "No se puede desactivar el teléfono. Código de estado: $statusCode"
        ]);
    }
}
}

