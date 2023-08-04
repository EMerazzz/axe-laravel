<?php

namespace App\Http\Controllers\AXE;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class direccionesController extends Controller


{
      public function direcciones()
    {
        // Obtener los datos de personas desde el controlador PersonasController
        $personasController = new PersonasController();
        $personas = Http::get('http://localhost:4000/personas');
        $personasArreglo = json_decode($personas,true);
       
        // Obtener los datos de teléfonos
        $direcciones = Http::get('http://localhost:4000/direcciones');
        $direccionesArreglo = json_decode($direcciones, true);
       
        // Retornar la vista con ambos conjuntos de datos
        return view('AXE.direcciones', compact('personasArreglo', 'direccionesArreglo'));
    }
   

    public function nueva_direccion(Request $request ){
    $nueva_direccion = Http::post('http://localhost:4000/nueva_direccion',[
        
    "COD_PERSONA" => $request->input("COD_PERSONA"),
    "DIRECCION"=> $request->input("DIRECCION"),
    "DEPARTAMENTO"=> $request->input("DEPARTAMENTO"),
    "CIUDAD"=> $request->input("CIUDAD"),
    "PAIS"=> $request->input("PAIS"),
        ]);
        //dd($request->input("COD_PERSONA"));
        return redirect('/direcciones');
    }

    public function modificar_direccion(Request $request ){
       
        $modificar_direccion = Http::put('http://localhost:4000/modificar_direccion/'.$request->input("COD_DIRECCION"),[
            "COD_DIRECCION" => $request->input("COD_DIRECCION"),
        
            "DIRECCION"=> $request->input("DIRECCION"),
            "DEPARTAMENTO"=> $request->input("DEPARTAMENTO"),
            "CIUDAD"=> $request->input("CIUDAD"),
            "PAIS"=> $request->input("PAIS"),

        ]);
      

        return redirect('/direcciones');
    }

}