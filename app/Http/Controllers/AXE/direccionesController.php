<?php

namespace App\Http\Controllers\AXE;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class direccionesController extends Controller
{
    private $apiUrl = 'http://localhost:4000/direcciones';
      public function direcciones()
    { $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        // Obtener los datos de personas desde el controlador PersonasController
        $personasController = new PersonasController();
        $personas = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://localhost:4000/personas');
        $personasArreglo = json_decode($personas,true);
       
        // Obtener los datos de teléfonos
        $direcciones = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl);
        $direccionesArreglo = json_decode($direcciones, true);
       
        // Retornar la vista con ambos conjuntos de datos
        return view('AXE.direcciones', compact('personasArreglo', 'direccionesArreglo'));
    }
   

    public function nueva_direccion(Request $request ){

        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
    $nueva_direccion = Http::withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->post($this->apiUrl,[
        
    "COD_PERSONA" => $request->input("COD_PERSONA"),
    "DIRECCION"=> $request->input("DIRECCION"),
    "DEPARTAMENTO"=> $request->input("DEPARTAMENTO"),
    "CIUDAD"=> $request->input("CIUDAD"),
    "PAIS"=> $request->input("PAIS"),
        ]);
        if ($nueva_direccion ->successful()) {
            return redirect('/direcciones')->with('message', [
                'type' => 'success',
                'text' => 'Agregado exitosamente.'
            ]);
        } else {
            return redirect('/direcciones')->with('message', [
                'type' => 'error',
                'text' => 'No se pudo agregar la dirección.'
            ]);
        }
    }

    public function modificar_direccion(Request $request ){
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        $modificar_direccion = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put($this->apiUrl.'/'.$request->input("COD_DIRECCION"),[
            "COD_DIRECCION" => $request->input("COD_DIRECCION"),
        
            "DIRECCION"=> $request->input("DIRECCION"),
            "DEPARTAMENTO"=> $request->input("DEPARTAMENTO"),
            "CIUDAD"=> $request->input("CIUDAD"),
            "PAIS"=> $request->input("PAIS"),

        ]);
      

        if ($modificar_direccion->successful()) {
            return redirect('/direcciones')->with('message', [
                'type' => 'success',
                'text' => 'Dirección modificada exitosamente.'
            ]);
        } else {
            return redirect('/direcciones')->with('message', [
                'type' => 'error',
                'text' => 'No se pudo modificar la dirección.'
            ]);
        }
    }

}