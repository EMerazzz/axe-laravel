<?php

namespace App\Http\Controllers\AXE;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class personasController extends Controller


{
    public function personas(){
       
       $personas = Http::get('http://localhost:4000/personas');
       $personasArreglo = json_decode($personas,true);
       //return $reservaciones;
       return view('AXE.personas', compact('personasArreglo'));
       
    }
   

    public function nueva_persona(Request $request ){
        //print_r([$request->input("nombre"),$request->input("fecha"),$request->input("registro"),$request->input("codigo")]);die();
        $nueva_persona = Http::post('http://localhost:4000/personas',[
    "NOMBRE" => $request->input("NOMBRE"),
    "APELLIDO"=> $request->input("APELLIDO"),
    "IDENTIDAD"=> $request->input("IDENTIDAD"),
    "GENERO"=> $request->input("GENERO"),
    "TIPO_PERSONA"=> $request->input("TIPO_PERSONA"),
    "EDAD"=> $request->input("EDAD"),
    "FECHA_NACIMIENTO"=> $request->input("FECHA_NACIMIENTO"),
    "FECHA_SALIDA "=> $request->input("FECHA_SALIDA"),
    
        ]);
        return redirect('/personas');
    }

    public function modificar_persona(Request $request ){
        //print_r([$request->input("id"),$request->input("formato"),$request->input("servicios"),$request->input("tipo")]);die();
        $modificar_persona = Http::put('http://localhost:4000/personas/'.$request->input("COD_PERSONA"),[
    "NOMBRE" => $request->input("NOMBRE"),
    "APELLIDO"=> $request->input("APELLIDO"),
    "IDENTIDAD"=> $request->input("IDENTIDAD"),
    "GENERO"=> $request->input("GENERO"),
    "TIPO_PERSONA"=> $request->input("TIPO_PERSONA"),
    "EDAD"=> $request->input("EDAD"),
    "FECHA_NACIMIENTO"=> $request->input("FECHA_NACIMIENTO"),
    "FECHA_SALIDA "=> $request->input("FECHA_SALIDA"),

        ]);
       //print_r([$putformatos]);die();

        return redirect('/personas');
    }

}