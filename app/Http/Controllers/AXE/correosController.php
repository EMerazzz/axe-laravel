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
        $personasController = new personasController();
        $personas =Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://82.180.162.18:4000/personas');
        $personasArreglo = json_decode($personas,true);
       
        // Obtener los datos de teléfonos
        $correos = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl);
        $correosArreglo = json_decode($correos, true);

        $UsuarioValue = $_COOKIE["Usuario"];
        $OBJETO = "CORREOS";
        $permisos = Http::post('http://82.180.162.18:4000/permisos_usuario',[
                "USUARIO" => $UsuarioValue,
                "OBJETO" =>  $OBJETO,
        ]);
        $permisosDisponibles = json_decode($permisos, true);
        
        // Retornar la vista con ambos conjuntos de datos
        return view('AXE.correos', compact('personasArreglo', 'correosArreglo', 'permisosDisponibles'));
    }
   

    public function nuevo_correo(Request $request ){
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        $UsuarioValue = $_COOKIE["Usuario"];
    $nuevo_correo = Http::withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->post($this->apiUrl,[
        
    "COD_PERSONA" => $request->input("COD_PERSONA"),
    "CORREO_ELECTRONICO"=> $request->input("CORREO_ELECTRONICO"),
    "USUARIO_MODIFICADOR" => $UsuarioValue,
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
        $UsuarioValue = $_COOKIE["Usuario"];
        $modificar_correo = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put($this->apiUrl.'/'.$request->input("COD_CORREO"),[
            "COD_PERSONA" => $request->input("COD_PERSONA"),
            "CORREO_ELECTRONICO"=> $request->input("CORREO_ELECTRONICO"),
            "USUARIO_MODIFICADOR" => $UsuarioValue,

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

    public function delete_correo(Request $request)
    {
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        $delete_correo = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put('http://82.180.162.18:4000/del_correos/'.$request->input("COD_CORREO"));
        
        if ($delete_correo->successful()) {
            return redirect('/correos')->with('message', [
                'type' => 'success',
                'text' => 'Correo eliminado.'
            ]);

        } else {
            return redirect('/correos')->with('message', [
                'type' => 'error',
                'text' => 'No se puede eliminar.'
            ]);
        }
    }
}