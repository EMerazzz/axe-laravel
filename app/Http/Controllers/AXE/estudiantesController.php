<?php

namespace App\Http\Controllers\AXE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class estudiantesController extends Controller
{
    private $apiUrl = 'http://82.180.162.18:4000';
     // Declaración de la variable de la URL de la API
    public function estudiantes()
    {
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        // Obtener los datos de personas desde el controlador PersonasController
        $personasController = new personasController();
        $personas = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl.'/personas');
        $personasArreglo = json_decode($personas, true);
        // Obtener los datos de nivel academico desde el controlador nivel_academicoController
        $nivel_academicoController = new nivel_academicoController();
        $nivel_academico = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl.'/nivel_academico');
        $nivel_academicoArreglo = json_decode($nivel_academico,true);

        // Obtener los datos de año academico desde el controlador anio_academicoController
        $anio_academicoController = new anio_academicoController();
        $anio_academico = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl.'/anio_academico');
        $anio_academicoArreglo = json_decode($anio_academico,true);

        // Obtener los datos de Jornada desde el controlador jornadasController
        $jornadasController = new jornadasController();
        $jornadas = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl.'/jornadas');
        $jornadasArreglo = json_decode($jornadas,true);
        
         // Obtener los datos de secciones desde el controlador seccionesController
         $seccionesController = new seccionesController();
         $secciones = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl.'/Secciones');
         $seccionesArreglo = json_decode($secciones,true);
            // Obtener los datos de personas desde el controlador padresController
            $padresController = new padresController();
            $padres = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get($this->apiUrl.'/padres_tutores');
            $padresArreglo = json_decode($padres, true);
            
        // Obtener los datos de matricula
        $matricula = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl.'/matricula');
        $matriculaArreglo = json_decode($matricula, true);

        $UsuarioValue = $_COOKIE["Usuario"];
       /* $OBJETO = "MATRICULA";
        $permisos = Http::post($this->apiUrl.'/permisos_usuario',[
                "USUARIO" => $UsuarioValue,
                "OBJETO" =>  $OBJETO,
        ]);
        $permisosDisponibles = json_decode($permisos, true);*/
       
        // Retornar la vista con ambos conjuntos de datos
    return view('AXE.estudiantes', compact('personasArreglo','nivel_academicoArreglo','anio_academicoArreglo','jornadasArreglo','seccionesArreglo','matriculaArreglo','padresArreglo',/* 'permisosDisponibles'*/));
    }

   /* public function nuevo_estudiante(Request $request)
    {
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);

  
        $personaSeleccionadaId = $request->input("COD_PERSONA");
        // Obtener los datos de la persona seleccionada por su ID desde la API de personas
        $personaSeleccionada = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get("http://82.180.162.18:4000/personas/{$personaSeleccionadaId}");
       // dd($personaSeleccionada);
        $personaSeleccionadaData = json_decode($personaSeleccionada, true);
        //dd($personaSeleccionadaData);
        $nuevo_estudiante = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post($this->apiUrl, [
            "COD_PERSONA" => $request->input("COD_PERSONA"),
            "COD_PADRE_TUTOR" => $request->input("COD_PADRE_TUTOR"),
            "COD_NIVEL_ACADEMICO" => $request->input("COD_NIVEL_ACADEMICO"),
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
    }*/
}
