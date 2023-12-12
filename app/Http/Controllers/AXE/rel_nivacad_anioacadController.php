<?php

namespace App\Http\Controllers\AXE;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class rel_nivacad_anioacadController extends Controller
{
    private $apiUrl = 'http://82.180.162.18:4000/rel_nivel_anio';

    public function rel_nivacad_anioacad()
    {
        try {
            $cookieEncriptada = request()->cookie ('token');
            $token = decrypt($cookieEncriptada);
        // Obtener los datos de roles desde el controlador Nivel_academicoController
        $nivel_academicoController = new nivel_academicoController();
        $nivel_academico = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://82.180.162.18:4000/nivel_academico');
        $nivel_academicoArreglo = json_decode($nivel_academico, true);

         // Obtener los datos de roles desde el controlador Anio_academicoController
         $anio_academicoController = new anio_academicoController();
         $anio_academico = Http::withHeaders([
             'Authorization' => 'Bearer ' . $token,
         ])->get('http://82.180.162.18:4000/anio_academico');
         $anio_academicoArreglo = json_decode($anio_academico, true);
 

         $rel_nivacad_anioacad = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl);
        $rel_nivacad_anioacadArreglo = json_decode($rel_nivacad_anioacad, true);

      /*       $rel_nivacad_anioacad = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get($this->apiUrl);
            $citaArreglo = json_decode($rel_nivacad_anioacad->body(), true);
            $asignaturas = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get($this->apiUrl);
               $asignaturas = json_decode($asignaturas,true); */
               //return $reservaciones;


            return view('AXE.rel_nivacad_anioacad', compact('rel_nivacad_anioacadArreglo','anio_academicoArreglo','nivel_academicoArreglo'));

        } catch (\Exception $exception) {
            // Manejar la excepción general y redireccionar con un mensaje de error
            return redirect('/rel_nivel_anio')->with('message', [
                'type' => 'error',
                'text' => $exception->getMessage(),
            ]);
        }
    }

    //insert
    public function insertarRelacionNivAcadAnioAcad(Request $request)
    {
        try {
            $cookieEncriptada = request()->cookie('token');
            $token = decrypt($cookieEncriptada);
    
            $nueva_rel_nivacad_anioacad = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->post($this->apiUrl, [
                "COD_NIVEL_ACADEMICO" => $request->input("COD_NIVEL_ACADEMICO"),
                "COD_ANIO_ACADEMICO" => $request->input("COD_ANIO_ACADEMICO"),
                "Estado_registro" => $request->input("Estado"),
            ]);
    
            if ($nueva_rel_nivacad_anioacad->successful()) {
                return redirect('/rel_nivacad_anioacad')->with('message', [
                    'type' => 'success',
                    'text' => 'Agregado exitosamente.'
                ]);
            } else {
                return redirect('/rel_nivacad_anioacad')->with('message', [
                    'type' => 'error',
                    'text' => 'No se pudo agregar.'
                ]);
            }
        } catch (\Exception $e) {
            // Manejar la excepción, por ejemplo, registrándola o redirigiendo a una página de error.
            return redirect('/rel_nivacad_anioacad')->with('message', [
                'type' => 'error',
                'text' => 'Error al procesar la solicitud.'
            ]);
        }
    }

    //modificar
    public function modificar_rel_nivacad_anioacad(Request $request)
    {
        try {
            $cookieEncriptada = request()->cookie('token');
            $token = decrypt($cookieEncriptada);

            $modificar_rel_nivacad_anioacad = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->put($this->apiUrl . '/' . $request->input("COD_NIVACAD_ANIOACAD"), [
                "COD_NIVEL_ACADEMICO" => $request->input("COD_NIVEL_ACADEMICO"),
                "COD_ANIO_ACADEMICO" => $request->input("COD_ANIO_ACADEMICO"),
                "Estado_registro" => $request->input("Estado"),
            ]);

            if ($modificar_rel_nivacad_anioacad->successful()) {
                return redirect('/rel_nivacad_anioacad')->with('message', [
                    'type' => 'success',
                    'text' => 'Agregado exitosamente.'
                ]);
            } else {
                return redirect('/rel_nivacad_anioacad')->with('message', [
                    'type' => 'error',
                    'text' => 'No se pudo editar.'
                ]);
            }
        } catch (\Exception $e) {
            // Manejar la excepción, por ejemplo, registrándola o redirigiendo a una página de error.
            return redirect('/rel_nivacad_anioacad')->with('message', [
                'type' => 'error',
                'text' => 'Error al procesar la solicitud.'
            ]);
        }
    }

    
}
