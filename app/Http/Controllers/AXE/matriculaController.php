<?php

namespace App\Http\Controllers\AXE;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class matriculaController extends Controller


{
    private $apiUrl = 'http://82.180.162.18:4000/matricula'; // Declaración de la variable de la URL de la API
      public function matricula()
    {
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        // Obtener los datos de personas desde el controlador PersonasController
        $personasController = new personasController();
        $personas = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://82.180.162.18:4000/personas');
        $personasArreglo = json_decode($personas, true);
        // Obtener los datos de nivel academico desde el controlador nivel_academicoController
        $nivel_academicoController = new nivel_academicoController();
        $nivel_academico = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://82.180.162.18:4000/nivel_academico');
        $nivel_academicoArreglo = json_decode($nivel_academico,true);

        // Obtener los datos de año academico desde el controlador anio_academicoController
        $anio_academicoController = new anio_academicoController();
        $anio_academico = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://82.180.162.18:4000/anio_academico/');
        $anio_academicoArreglo = json_decode($anio_academico,true);

        // Obtener los datos de Jornada desde el controlador jornadasController
        $jornadasController = new jornadasController();
        $jornadas = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://82.180.162.18:4000/jornadas/');
        $jornadasArreglo = json_decode($jornadas,true);
        
         // Obtener los datos de secciones desde el controlador seccionesController
         $seccionesController = new seccionesController();
         $secciones = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://82.180.162.18:4000/Secciones/');
         $seccionesArreglo = json_decode($secciones,true);
            // Obtener los datos de personas desde el controlador padresController
            $padresController = new padresController();
            $padres = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('http://82.180.162.18:4000/padres_tutores');
            $padresArreglo = json_decode($padres, true);
            
        // Obtener los datos de matricula
        $matricula = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl);
        $matriculaArreglo = json_decode($matricula, true);

        $UsuarioValue = $_COOKIE["Usuario"];
        $OBJETO = "MATRICULA";
        $permisos = Http::post('http://82.180.162.18:4000/permisos_usuario',[
                "USUARIO" => $UsuarioValue,
                "OBJETO" =>  $OBJETO,
        ]);
        $permisosDisponibles = json_decode($permisos, true);
       
        // Retornar la vista con ambos conjuntos de datos
        return view('AXE.matricula', compact('personasArreglo','nivel_academicoArreglo','anio_academicoArreglo','jornadasArreglo','seccionesArreglo','matriculaArreglo','padresArreglo', 'permisosDisponibles'));
    }
   

    public function nueva_matricula(Request $request) {
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        $UsuarioValue = $_COOKIE["Usuario"];

        $identidad = $request->input("COD_PERSONA");
    
        // Obtener todas las matrículas desde la API
        $todas_las_matriculas = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl);
    
        if ($todas_las_matriculas->successful()) {
            $matriculas_lista = $todas_las_matriculas->json();
    
            // Verificar si la matrícula ya existe en la lista
            foreach ($matriculas_lista as $matricula) {
                if ((string)$matricula["COD_PERSONA"] === (string)$identidad) {
                    // La matrícula ya existe, generar mensaje de error
                    return redirect('/matricula')->with('message', [
                        'type' => 'error',
                        'text' => 'Este estudiante ya está matriculado.'
                    ])->withInput(); // Agregar esta línea para mantener los datos ingresados
                }
            }
        } else {
            return redirect('/matricula')->with('message', [
                'type' => 'error',
                'text' => 'No se pudo obtener la lista de matrículas.'
            ]);
        }
    $nueva_matricula = Http::withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->post($this->apiUrl,[    
    "COD_PERSONA" => $request->input("COD_PERSONA"),
    "COD_NIVEL_ACADEMICO"=> $request->input("COD_NIVEL_ACADEMICO"),
    "COD_ANIO_ACADEMICO"=> $request->input("COD_ANIO_ACADEMICO"),
    "ESTADO_MATRICULA"=> $request->input("ESTADO_MATRICULA"),
    "JORNADA"=> $request->input("JORNADA"),
    "SECCION"=> $request->input("SECCION"),
    "COD_PADRE_TUTOR"=> $request->input("COD_PADRE_TUTOR"),
    "USUARIO_MODIFICADOR" => $UsuarioValue,
        ]);
        
        // Verificar si la solicitud fue exitosa y redireccionar con mensaje de éxito o error
        if ($nueva_matricula ->successful()) {
            return redirect('/matricula')->with('message', [
                'type' => 'success',
                'text' => 'Matriculado exitosamente.'
            ]);
        } else {
            return redirect('/matricula')->with('message', [
                'type' => 'error',
                'text' => 'No se pudo matricular.'
            ]);
        }
    }

    public function modificar_matricula(Request $request ){
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);

        $UsuarioValue = $_COOKIE["Usuario"];
        $modificar_matricula = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put($this->apiUrl.'/'.$request->input("COD_MATRICULA"),[
            
            "COD_NIVEL_ACADEMICO"=> $request->input("COD_NIVEL_ACADEMICO"),
            "COD_ANIO_ACADEMICO"=> $request->input("COD_ANIO_ACADEMICO"),
            "ESTADO_MATRICULA"=> $request->input("ESTADO_MATRICULA"),
            "JORNADA"=> $request->input("JORNADA"),
            "SECCION"=> $request->input("SECCION"),
            "COD_PADRE_TUTOR"=> $request->input("COD_PADRE_TUTOR"),
            "USUARIO_MODIFICADOR" => $UsuarioValue,
        ]);
      
        if ($modificar_matricula ->successful()) {
            return redirect('/matricula')->with('message', [
                'type' => 'success',
                'text' => 'Se ha modificado el estudiante.'
            ]);
        } else {
            return redirect('/matricula')->with('message', [
                'type' => 'error',
                'text' => 'No se pudo modificar.'
            ]);
        }
    }

    public function delete_matricula(Request $request)
{
    $cookieEncriptada = request()->cookie('token');
    $token = decrypt($cookieEncriptada);

    $delete_matricula = Http::withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->put('http://82.180.162.18:4000/del_matricula/'.$request->input("COD_MATRICULA"));

    if ($elete_matricula->successful()) {
        return redirect('/matricula')->with('message', [
            'type' => 'success',
            'text' => 'Matricula Eliminada.'
        ]);
    } else {
        // Manejar casos de error
        $statusCode = $delete_telefono->status();
        return redirect('/matricula')->with('message', [
            'type' => 'error',
            'text' => "No se puede desactivar el teléfono. Código de estado: $statusCode"
        ]);
    }
}

}