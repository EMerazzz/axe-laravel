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
            $rel_nivacad_anioacad = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get($this->apiUrl);
            $citaArreglo = json_decode($rel_nivacad_anioacad->body(), true);
            $asignaturas = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get($this->apiUrl);
               $asignaturas = json_decode($asignaturas,true);
               //return $reservaciones;


            return view('AXE.rel_nivacad_anioacad', compact('citaArreglo'));
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
                    'text' => 'Modificado exitosamente.'
                ]);
            } else {
                throw new ApiException($modificar_rel_nivacad_anioacad->json()['error']['message'] ?? 'No se pudo modificar.');
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
