<?php

namespace App\Http\Controllers\AXE;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class rel_docentes_asigController extends Controller
{
    private $apiUrl = 'http://82.180.162.18:4000/rel_docentes_asig';

    public function rel_docentes_asig()
    {
        try {
            $cookieEncriptada = request()->cookie ('token');
            $token = decrypt($cookieEncriptada);
        // Obtener los datos de roles desde el controlador Nivel_academicoController
        $asignaturasController = new asignaturasController();
        $asignaturas = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://82.180.162.18:4000/asignaturas');
        $asignaturasArreglo = json_decode($asignaturas, true);

         // Obtener los datos de roles desde el controlador Anio_academicoController
         $docentesController = new docentesController();
         $docentes = Http::withHeaders([
             'Authorization' => 'Bearer ' . $token,
         ])->get('http://82.180.162.18:4000/docentes');
         $docentesArreglo = json_decode($docentes, true);

         // Obtener los datos de personas desde el controlador PersonasController
        $personasController = new personasController();
        $personas = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://82.180.162.18:4000/personas');
        $personasArreglo = json_decode($personas, true);
 

         $rel_docentes_asig = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl);
        $rel_docentes_asigArreglo = json_decode($rel_docentes_asig, true);

      /*       $rel_nivacad_anioacad = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get($this->apiUrl);
            $citaArreglo = json_decode($rel_nivacad_anioacad->body(), true);
            $asignaturas = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get($this->apiUrl);
               $asignaturas = json_decode($asignaturas,true); */
               //return $reservaciones;


            return view('AXE.rel_docentes_asig', compact('rel_docentes_asigArreglo','asignaturasArreglo','docentesArreglo','personasArreglo'));

        } catch (\Exception $exception) {
            // Manejar la excepción general y redireccionar con un mensaje de error
            return redirect('/rel_docentes_asig')->with('message', [
                'type' => 'error',
                'text' => $exception->getMessage(),
            ]);
        }
    }

    //insert
    public function insertarRelacion_Docente(Request $request)
    {
        try {
            $cookieEncriptada = request()->cookie('token');
            $token = decrypt($cookieEncriptada);

            $nueva_rel_docente_asig = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->post($this->apiUrl, [
                "COD_ASIGNATURA" => $request->input("COD_ASIGNATURA"),
                "COD_DOCENTE" => $request->input("COD_DOCENTE"),
                "Estado_registro" => $request->input("Estado"),
            ]);
            

            if ($nueva_rel_docente_asig->successful()) {
                return redirect('/rel_docentes_asig')->with('message', [
                    'type' => 'success',
                    'text' => 'Agregado exitosamente.'
                ]);
            } 
        } catch (ApiException $exception) {
            return redirect('/rel_docentes_asig')->with('message', [
                'type' => 'error',
                'text' => $exception->getMessage(),
            ]);
        } catch (\Exception $exception) {
            return redirect('/rel_docentes_asig')->with('message', [
                'type' => 'error',
                'text' => $exception->getMessage(),
            ]);
        }
    }

    //modificar
    public function modificar_Rel_Docente_Asig(Request $request)
    {
        try {
            $cookieEncriptada = request()->cookie('token');
            $token = decrypt($cookieEncriptada);

            $modificar_rel_docente_asig = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->put($this->apiUrl . '/' . $request->input("COD_DOCEN_ASIG"), [
                "COD_ASIGNATURA" => $request->input("COD_ASIGNATURA"),
                "COD_DOCENTE" => $request->input("COD_DOCENTE"),
                "Estado_registro" => $request->input("Estado"),
            ]);

            if ($nueva_rel_nivacad_anioacad->successful()) {
                return redirect('/rel_nivacad_anioacad')->with('message', [
                    'type' => 'success',
                    'text' => 'Agregado exitosamente.'
                ]);
            } 
        } catch (ApiException $exception) {
            return redirect('/rel_nivacad_anioacad')->with('message', [
                'type' => 'error',
                'text' => $exception->getMessage(),
            ]);
        } catch (\Exception $exception) {
            return redirect('/rel_nivacad_anioacad')->with('message', [
                'type' => 'error',
                'text' => $exception->getMessage(),
            ]);
        }
    }

    
}