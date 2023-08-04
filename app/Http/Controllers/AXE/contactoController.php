<?php

namespace App\Http\Controllers\AXE;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class contactoController extends Controller


{
      public function contacto_emergencia()
    {
        // Obtener los datos de personas desde el controlador PersonasController
        $personasController = new PersonasController();
        $personas = Http::get('http://localhost:4000/personas');
        $personasArreglo = json_decode($personas,true);
       
        // Obtener los datos de teléfonos
        $contacto_emergencia = Http::get('http://localhost:4000/contacto_emergencia');
        $contactoArreglo = json_decode($contacto_emergencia, true);
       
        // Retornar la vista con ambos conjuntos de datos
        return view('AXE.contacto', compact('personasArreglo', 'contactoArreglo'));
    }
   

    public function nuevo_contacto_emergencia(Request $request ){
    $nuevo_correo = Http::post('http://localhost:4000/nuevo_contacto_emergencia',[
        
    "COD_PERSONA" => $request->input("COD_PERSONA"),
    "NOMBRE_CONTACTO"=> $request->input("NOMBRE_CONTACTO"),
    "APELLIDO_CONTACTO"=> $request->input("APELLIDO_CONTACTO"),
    "TELEFONO"=> $request->input("TELEFONO"),
    "RELACION"=> $request->input("RELACION"),
    
        ]);
        //dd($request->input("COD_PERSONA"));
        return redirect('/contacto');
    }

    public function modificar_contacto_emergencia(Request $request ){
       
        $modificar_correo = Http::put('http://localhost:4000/modificar_contacto_emergencia/'.$request->input("COD_CONTACTO_EMERGENCIA"),[
            "COD_CONTACTO_EMERGENCIA" => $request->input("COD_CONTACTO_EMERGENCIA"),
        
            "COD_PERSONA" => $request->input("COD_PERSONA"),
            "NOMBRE_CONTACTO"=> $request->input("NOMBRE_CONTACTO"),
            "APELLIDO_CONTACTO"=> $request->input("APELLIDO_CONTACTO"),
            "TELEFONO"=> $request->input("TELEFONO"),
            "RELACION"=> $request->input("RELACION"),

        ]);
      

        return redirect('/contacto');
    }

}