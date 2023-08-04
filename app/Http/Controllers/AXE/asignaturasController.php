<?php

namespace App\Http\Controllers\AXE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class asignaturasController extends Controller
{
    public function asignaturas(){
       $asignaturas = Http::get('http://localhost:4000/asignaturas');
       $citaArreglo = json_decode($asignaturas,true);
       //return $reservaciones;
       return view('AXE.asignaturas', compact('citaArreglo'));
       
    }


    public function nueva_asignatura(Request $request ){
        //print_r([$request->input("nombre"),$request->input("fecha"),$request->input("registro"),$request->input("codigo")]);die();
        $nueva_asignatura = Http::post('http://localhost:4000/asignaturas',[
        "NOMBRE_ASIGNATURA" => $request->input("NOMBRE_ASIGNATURA"),
        ]);
        return redirect('/asignaturas');
    }

    public function modificar_asignaturas(Request $request ){
        //print_r([$request->input("id"),$request->input("formato"),$request->input("servicios"),$request->input("tipo")]);die();
        $modificar_asignatura = Http::put('http://localhost:4000/asignaturas/'.$request->input("COD_ASIGNATURA"),[
        "COD_ASIGNATURA"=> $request->input("COD_ASIGNATURA"),
        "NOMBRE_ASIGNATURA" => $request->input("NOMBRE_ASIGNATURA"),
        ]);
       //print_r([$putformatos]);die();

        return redirect('/asignaturas');
    }


}