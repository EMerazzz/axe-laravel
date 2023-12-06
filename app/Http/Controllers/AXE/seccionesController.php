<?php

namespace App\Http\Controllers\AXE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use DateTime;

class seccionesController extends Controller
{
    private $apiUrl = 'http://82.180.162.18:4000/Secciones'; // Declaración de la variable de la URL de la API
    public function secciones()
    {
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        $secciones = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl);
        $seccionesArreglo = json_decode($secciones, true);
        return view('AXE.secciones', compact('seccionesArreglo'));
    }

    public function nueva_seccion(Request $request)
    {
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        // Enviar la solicitud POST a la API para agregar la nueva persona

        $DESCRIPCION = $request->input("DESCRIPCION_SECCIONES");
    
        $todasSecciones = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl);

        // Obtener todas las personas desde la API
        $todas_secciones = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl);
    
        if ($todasSecciones->successful()) {
            $secciones_lista = $todas_secciones->json();
    
            foreach ($secciones_lista as $seccion) {
                if ($seccion["DESCRIPCION_SECCIONES"] === $DESCRIPCION) {
                    // La persona ya existe, generar mensaje de error
                    return redirect('/secciones')->with('message', [
                        'type' => 'error',
                        'text' => 'Esta seccion ya existe.'
                    ])->withInput(); // Agregar esta línea para mantener los datos ingresados
                }
                
            }
        }
      //  $PRIMER_INGRESO = $request->input("PRIMER_INGRESO") ? 1 : 0;


        $nueva_seccion = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post($this->apiUrl, [
            "DESCRIPCION_SECCIONES" => $request->input("DESCRIPCION_SECCIONES"),
        ]);
    
        // Verificar si la solicitud fue exitosa y redireccionar con mensaje de éxito o error
        if ($nueva_seccion->successful()) {
            return redirect('/secciones')->with('message', [
                'type' => 'success',
                'text' => 'Sección agregada exitosamente.'
            ]);
        } else {
            return redirect('/secciones')->with('message', [
                'type' => 'error',
                'text' => 'No se pudo agregar la sección.'
            ]);
        }
    }
    

    public function modificar_seccion(Request $request)
    {
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        
        $modificar_seccion = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put($this->apiUrl.'/'.$request->input("COD_SECCIONES"), [
            "DESCRIPCION_SECCIONES" => $request->input("DESCRIPCION_SECCIONES"),
            
        ]);
        if ($modificar_seccion->successful()) {
            return redirect('/secciones')->with('message', [
                'type' => 'success',
                'text' => 'Sección modificada exitosamente.'
            ]);
        } else {
            return redirect('/secciones')->with('message', [
                'type' => 'error',
                'text' => 'No se pudo modificar la sección.'
            ]);
        }
    }

    public function delete_seccion(Request $request)
{
    $cookieEncriptada = request()->cookie('token');
    $token = decrypt($cookieEncriptada);

    $delete_seccion = Http::withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->put('http://82.180.162.18:4000/del_secciones/'.$request->input("COD_SECCIONES"));

    if ($delete_seccion->successful()) {
        return redirect('/secciones')->with('message', [
            'type' => 'success',
            'text' => 'Sección Eliminada.'
        ]);
    } else {
        // Manejar casos de error
        $statusCode = $delete_seccion->status();
        return redirect('/secciones')->with('message', [
            'type' => 'error',
            'text' => "No se puede desactivar el teléfono. Código de estado: $statusCode"
        ]);
    }
}
}