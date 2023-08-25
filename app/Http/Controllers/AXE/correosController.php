<?php

namespace App\Http\Controllers\AXE;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class correosController extends Controller
{
    private $apiUrl = 'http://82.180.162.18:4000/correos';
      public function correos()
    { $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        // Obtener los datos de personas desde el controlador PersonasController
        $personasController = new PersonasController();
        $personas =Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://82.180.162.18:4000/personas');
        $personasArreglo = json_decode($personas,true);
       
        // Obtener los datos de teléfonos
        $correos = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl);
        $correosArreglo = json_decode($correos, true);
       
        // Retornar la vista con ambos conjuntos de datos
        return view('AXE.correos', compact('personasArreglo', 'correosArreglo'));
    }
   

    public function nuevo_correo(Request $request ){
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
    $nuevo_correo = Http::withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->post($this->apiUrl,[
        
    "COD_PERSONA" => $request->input("COD_PERSONA"),
    "CORREO_ELECTRONICO"=> $request->input("CORREO_ELECTRONICO"),
    
        ]);
        if ($nuevo_correo->successful()) {
            return redirect('/correos')->with('message', [
                'type' => 'success',
                'text' => 'Correo agregado exitosamente.'
            ]);
        } else {
            return redirect('/correos')->with('message', [
                'type' => 'error',
                'text' => 'No se pudo agregar el correo.'
            ]);
        }
    }

    public function modificar_correo(Request $request ){
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
       
        $modificar_correo = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put($this->apiUrl.'/'.$request->input("COD_CORREO"),[
            "COD_CORREO" => $request->input("COD_CORREO"),
        
            "CORREO_ELECTRONICO"=> $request->input("CORREO_ELECTRONICO"),
            

        ]);
      

        if ($modificar_correo->successful()) {
            return redirect('/correos')->with('message', [
                'type' => 'success',
                'text' => 'Correo modificado exitosamente.'
            ]);
        } else {
            return redirect('/correos')->with('message', [
                'type' => 'error',
                'text' => 'No se pudo modificar el correo.'
            ]);
        }
    }

}