<?php

namespace App\Http\Controllers\AXE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class asignaturasController extends Controller
{
    private $apiUrl = 'http://localhost:4000/asignaturas'; // Declaración de la variable de la URL de la API
    public function asignaturas(){
       $asignaturas = Http::get($this->apiUrl);
       $citaArreglo = json_decode($asignaturas,true);
       //return $reservaciones;
       return view('AXE.asignaturas', compact('citaArreglo'));
       
    }


    public function nueva_asignatura(Request $request ){
        //print_r([$request->input("nombre"),$request->input("fecha"),$request->input("registro"),$request->input("codigo")]);die();
        $nueva_asignatura = Http::post($this->apiUrl,[
        "NOMBRE_ASIGNATURA" => $request->input("NOMBRE_ASIGNATURA"),
        ]);
         // Verificar si la solicitud fue exitosa y redireccionar con mensaje de éxito o error
         if ($nueva_asignatura ->successful()) {
            return redirect('/asignaturas')->with('message', [
                'type' => 'success',
                'text' => 'Agregado exitosamente.'
            ]);
        } else {
            return redirect('/asignaturas')->with('message', [
                'type' => 'error',
                'text' => 'No se pudo agregar.'
            ]);
        }
    }

    public function modificar_asignaturas(Request $request ){
        //print_r([$request->input("id"),$request->input("formato"),$request->input("servicios"),$request->input("tipo")]);die();
        $modificar_asignatura = Http::put($this->apiUrl.'/'.$request->input("COD_ASIGNATURA"),[
        "COD_ASIGNATURA"=> $request->input("COD_ASIGNATURA"),
        "NOMBRE_ASIGNATURA" => $request->input("NOMBRE_ASIGNATURA"),
        ]);
       //print_r([$putformatos]);die();

       if ($modificar_asignatura->successful()) {
        return redirect('/asignaturas')->with('message', [
            'type' => 'success',
            'text' => 'Modificado exitosamente.'
        ]);
    } else {
        return redirect('/asignaturas')->with('message', [
            'type' => 'error',
            'text' => 'No se pudo modificar .'
        ]);
    }
    }


}