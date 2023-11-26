<?php

namespace App\Http\Controllers\AXE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use DateTime;

class objetosController extends Controller

{
    private $apiUrl = 'http://82.180.162.18:4000/objetos'; // Declaración de la variable de la URL de la API
   
    public function objetos()
    {
    
        $cookieEncriptada = request()->cookie('token');//trae la cookie encriptada
        $token = decrypt($cookieEncriptada);//desencripta la cookie
       

       // dd ( $UsuarioValue);
        $objetos = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl);

        $objetosArreglo = json_decode($objetos, true);
        return view('AXE.objetos', compact('objetosArreglo'));
    }

    public function nuevo_objetos(Request $request ){
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        $nuevo_objeto = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post($this->apiUrl,[
        "OBJETO" => $request->input("OBJETO"),
        "DESCRIPCION" => $request->input("DESCRIPCION"),
        "TIPO_OBJETO" => $request->input("TIPO_OBJETO"),
        ]);
         // Verificar si la solicitud fue exitosa y redireccionar con mensaje de éxito o error
         if ($nuevo_objeto ->successful()) {
            return redirect('/objetos')->with('message', [
                'type' => 'success',
                'text' => 'Agregado exitosamente.'
            ]);
        } else {
            return redirect('/objetos')->with('message', [
                'type' => 'error',
                'text' => 'No se pudo agregar.'
            ]);
        }
    }

    public function modificar_objeto(Request $request ){
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        $modificar_objetos = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put($this->apiUrl.'/'.$request->input("COD_OBJETO"),[
        "COD_OBJETO"=> $request->input("COD_OBJETO"),
        "OBJETO" => $request->input("OBJETO"),
        "DESCRIPCION" => $request->input("DESCRIPCION"),
        "TIPO_OBJETO" => $request->input("TIPO_OBJETO"),
        ]);
       //print_r([$putformatos]);die();

       if ($modificar_objetos->successful()) {
        return redirect('/objetos')->with('message', [
            'type' => 'success',
            'text' => 'Modificado exitosamente.'
        ]);
    } else {
        return redirect('/objetos')->with('message', [
            'type' => 'error',
            'text' => 'No se pudo modificar .'
        ]);
    }
    }
}