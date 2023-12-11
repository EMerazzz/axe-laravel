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

    //INSERT

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
                "CARGO_ACTUAL" => $request->input("CARGO_ACTUAL"),
                "HORAS_SEMANALES" => $request->input("HORAS_SEMANALES"),
                "USUARIO_MODIFICADOR" => $UsuarioValue,
                "Estado_registro" => $request->input("Estado_registro"),
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
    
   //MODIFICAR
    public function modificar_docente(Request $request)
    {
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        $UsuarioValue = $_COOKIE["Usuario"];
        $Docenteselecionado = $request->input("COD_PERSONA");
        //dd($Docente);
            // Obtener todas las personas desde la API
            $todosDocentes = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get($this->apiUrl);
            
        if ($todosDocentes->successful()) {
            $docentes_lista = $todosDocentes->json();
            
            foreach ($docentes_lista as $docentes) {
               //dd ($docentes["COD_PERSONA"]);
               // dd ($Docenteselecionado);
               if ((string)$docentes["COD_PERSONA"] === (string)$Docenteselecionado) {
                  
                    // La persona ya existe, generar mensaje de error
                    return redirect('docentes')->with('message', [
                        'type' => 'error',
                        'text' => 'Este docente ya está regisrado.'
                    ])->withInput(); // Agregar esta línea para mantener los datos ingresados
                }
                
            }
        }
        $modificar_docente= Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put($this->apiUrl.'/'. $request->input("COD_DOCENTE"), [
            "COD_PERSONA" => $request->input("COD_PERSONA"),
            "CARGO_ACTUAL" => $request->input("CARGO_ACTUAL"),
            "HORAS_SEMANALES" => $request->input("HORAS_SEMANALES"),
            "USUARIO_MODIFICADOR" => $UsuarioValue,
            "Estado_registro" => $request->input("Estado_registro"),
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


    //DELETE
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

