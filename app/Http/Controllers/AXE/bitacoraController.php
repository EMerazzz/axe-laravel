<?php

namespace App\Http\Controllers\AXE;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class bitacoraController extends Controller


{
    private $apiUrl = 'http://82.180.162.18:4000/bitacora'; // Declaración de la variable de la URL de la API

      public function bitacora()
    {$cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
       
        // Obtener los datos de teléfonos
        $bitacora = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl);

        $bitacoraArreglo = json_decode($bitacora, true);

        $ESTADO_BITACORA = Http::get('http://82.180.162.18:4000/ESTADO_BITACORA');
        $ESTADO_BITACORA = json_decode($ESTADO_BITACORA, true);

        $ESTADO_BITACORA = $ESTADO_BITACORA['VALOR'];       

        // Retornar la vista con ambos conjuntos de datos
        return view('AXE.bitacora', compact('bitacoraArreglo', 'ESTADO_BITACORA'));
    }

    public function guardar(Request $request) {
        $valorCheckbox = $request->input('miTexto');

        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);

        //Activar y desactivar bitacora
        if ($valorCheckbox === '0') {
            $variableBITACORA = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->post('http://82.180.162.18:4000/triggers_delete/');   
            $mensaje = "Bitacora desactivada";
        } else {
            
            $variableBITACORA = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->post('http://82.180.162.18:4000/triggers_new/');
            $mensaje = "Bitacora activada";
        } 
        return $this->bitacora();
    }


    public function eliminarDatosBitacora(Request $request) {

        $ESTADO_BITACORA = Http::get('http://82.180.162.18:4000/LIMPIAR_BITACORA');

        $ESTADO_BITACORA = Http::get('http://82.180.162.18:4000/ESTADO_BITACORA');
        $ESTADO_BITACORA = json_decode($ESTADO_BITACORA, true);

        $ESTADO_BITACORA = $ESTADO_BITACORA['VALOR'];   

        return $this->bitacora();
    }

}