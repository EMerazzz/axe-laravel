<?php

namespace App\Http\Controllers\AXE;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class contactoController extends Controller


{
    private $apiUrl = 'http://82.180.162.18:4000/contacto_emergencia'; // Declaración de la variable de la URL de la API
      public function contacto_emergencia()
    {$cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        // Obtener los datos de personas desde el controlador PersonasController
        $personasController = new personasController();
        $personas = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://82.180.162.18:4000/personas');
        $personasArreglo = json_decode($personas,true);
       
        // Obtener los datos de teléfonos
        $contacto_emergencia = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl);
        $contactoArreglo = json_decode($contacto_emergencia, true);
       
        // Retornar la vista con ambos conjuntos de datos
        return view('AXE.contacto', compact('personasArreglo', 'contactoArreglo'));
    }
   

    public function nuevo_contacto_emergencia(Request $request ){
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        $UsuarioValue = $_COOKIE["Usuario"];

    $nuevo_contacto = Http::withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->post($this->apiUrl,[
        
    "COD_PERSONA" => $request->input("COD_PERSONA"),
    "NOMBRE_CONTACTO"=> $request->input("NOMBRE_CONTACTO"),
    "APELLIDO_CONTACTO"=> $request->input("APELLIDO_CONTACTO"),
    "TELEFONO"=> $request->input("TELEFONO"),
    "RELACION"=> $request->input("RELACION"),
    "USUARIO_MODIFICADOR" => $UsuarioValue,
        ]);
        if ($nuevo_contacto ->successful()) {
            return redirect('/contacto')->with('message', [
                'type' => 'success',
                'text' => 'Contacto agregada exitosamente.'
            ]);
        } else {
            return redirect('/contacto')->with('message', [
                'type' => 'error',
                'text' => 'No se pudo agregar el contacto.'
            ]);
        }
    }

    public function modificar_contacto_emergencia(Request $request ){
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        $UsuarioValue = $_COOKIE["Usuario"];
        
        $modificar_contacto = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put($this->apiUrl.'/'.$request->input("COD_CONTACTO_EMERGENCIA"),[
        
        
            "COD_PERSONA" => $request->input("COD_PERSONA"),
            "NOMBRE_CONTACTO"=> $request->input("NOMBRE_CONTACTO"),
            "APELLIDO_CONTACTO"=> $request->input("APELLIDO_CONTACTO"),
            "TELEFONO"=> $request->input("TELEFONO"),
            "RELACION"=> $request->input("RELACION"),
            "USUARIO_MODIFICADOR" => $UsuarioValue,

        ]);
      

        if ($modificar_contacto->successful()) {
            return redirect('/contacto')->with('message', [
                'type' => 'success',
                'text' => 'Contacto modificado exitosamente.'
            ]);
        } else {
            return redirect('/contacto')->with('message', [
                'type' => 'error',
                'text' => 'No se pudo modificar el contacto.'
            ]);
        }
    }

}