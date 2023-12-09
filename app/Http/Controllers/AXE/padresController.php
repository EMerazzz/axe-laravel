<?php

namespace App\Http\Controllers\AXE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class padresController extends Controller
{
    private $apiUrl = 'http://82.180.162.18:4000/padres_tutores';
    private $Url = 'http://82.180.162.18:4000/'; // Declaración de la variable de la URL de la API
    public function padres()
    {
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        // Obtener los datos de personas desde el controlador PersonasController
        $personasController = new personasController();
        $personas = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://82.180.162.18:4000/personas');
        $personasArreglo = json_decode($personas, true);

        // Obtener los datos de teléfonos
        $padres =Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl);
        $padresArreglo = json_decode($padres, true);

        return view('AXE.padres', compact('personasArreglo', 'padresArreglo'));
    }

    public function nuevo_padre(Request $request)
    {
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        $UsuarioValue = $_COOKIE["Usuario"];
        $personaSeleccionadaId = $request->input("COD_PERSONA");
        // Obtener los datos de la persona seleccionada por su ID desde la API de personas
        $personaSeleccionada =Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get("http://82.180.162.18:4000/personas/{$personaSeleccionadaId}");
       // dd($personaSeleccionada);
        $personaSeleccionadaData = json_decode($personaSeleccionada, true);
        //dd(($personaSeleccionadaData[0]['NOMBRE']));
      
            // Crear una solicitud para agregar un nuevo docente con los datos combinados
            $nuevo_padre = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->post($this->apiUrl, [
                "COD_PERSONA" => $request->input("COD_PERSONA"),
                "NOMBRE_PADRE_TUTOR" => $personaSeleccionadaData[0]['NOMBRE'],
               "APELLIDO_PADRE_TUTOR" => $personaSeleccionadaData[0]['APELLIDO'],
                "OCUPACION_PADRE_TUTOR" => $request->input("OCUPACION_PADRE_TUTOR"),
                "RELACION_PADRE_ESTUDIANTE" => $request->input("RELACION_PADRE_ESTUDIANTE"),
                "USUARIO_MODIFICADOR" => $UsuarioValue,
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
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        $UsuarioValue = $_COOKIE["Usuario"];
        $modificar_padre=Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put($this->apiUrl.'/'. $request->input("COD_PADRE_TUTOR"), [
            "NOMBRE_PADRE_TUTOR" => $request->input("NOMBRE_PADRE_TUTOR"),
            "APELLIDO_PADRE_TUTOR" => $request->input("APELLIDO_PADRE_TUTOR"),
            "TELEFONO" => $request->input("TELEFONO"),
            "RELACION_PADRE_ESTUDIANTE" => $request->input("RELACION_PADRE_ESTUDIANTE"),
            "USUARIO_MODIFICADOR" => $UsuarioValue,
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

    public function delete_padre(Request $request)
{
    $cookieEncriptada = request()->cookie('token');
    $token = decrypt($cookieEncriptada);

    $delete_padre = Http::withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->put('http://82.180.162.18:4000/del_padres_tutores/'.$request->input("COD_PADRE_TUTOR"));

    if ($delete_padre->successful()) {
        return redirect('/padres')->with('message', [
            'type' => 'success',
            'text' => 'Tutor Eliminado.'
        ]);
    } else {
        // Manejar casos de error
        $statusCode = $delete_padre->status();
        return redirect('/padres')->with('message', [
            'type' => 'error',
            'text' => "No se puede desactivar el teléfono. Código de estado: $statusCode"
        ]);
    }
}
}