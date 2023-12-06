<?php

namespace App\Http\Controllers\AXE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class telefonosController extends Controller
{
    private $apiUrl = 'http://82.180.162.18:4000/telefonos'; // Declaración de la variable de la URL de la API
    public function telefonos()
    {
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        // Obtener los datos de personas desde el controlador PersonasController
        $personasController = new personasController();
        $personas = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://82.180.162.18:4000/personas');
        $personasArreglo = json_decode($personas, true);

        // Obtener los datos de teléfonos
        $telefonos = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl);
        $telefonosArreglo = json_decode($telefonos, true);

        $UsuarioValue = $_COOKIE["Usuario"];
        $OBJETO = "TELEFONOS";
        $permisos = Http::post('http://82.180.162.18:4000/permisos_usuario',[
                "USUARIO" => $UsuarioValue,
                "OBJETO" =>  $OBJETO,
        ]);
    
        $permisosDisponibles = json_decode($permisos, true);
        return view('AXE.telefonos', compact('personasArreglo', 'telefonosArreglo', 'permisosDisponibles'));
    }

    public function nuevo_telefono(Request $request)
    {
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        $UsuarioValue = $_COOKIE["Usuario"];
        
        $nuevo_telefono = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post($this->apiUrl, [
            "COD_PERSONA" => $request->input("COD_PERSONA"),
            "TELEFONO" => $request->input("TELEFONO"),
            "TIPO_TELEFONO" => $request->input("TIPO_TELEFONO"),
            "USUARIO_MODIFICADOR" => $UsuarioValue,
        ]);

        if ($nuevo_telefono ->successful()) {
            return redirect('/telefonos')->with('message', [
                'type' => 'success',
                'text' => 'Teléfono agregado exitosamente.'
            ]);
        } else {
            return redirect('/telefonos')->with('message', [
                'type' => 'error',
                'text' => 'No se pudo agregar el Teléfono.'
            ]);
        }
    }

    public function modificar_telefono(Request $request)
    {
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        $UsuarioValue = $_COOKIE["Usuario"];

        $modificar_telefono = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put($this->apiUrl.'/'. $request->input("COD_TELEFONO"), [

            //"COD_PERSONA" => $request->input("COD_PERSONA"),
            "TELEFONO" => $request->input("TELEFONOUPD"),
            "TIPO_TELEFONO" => $request->input("TIPO_TELEFONO"),
            "USUARIO_MODIFICADOR" => $UsuarioValue,
        ]);

        if ($modificar_telefono->successful()) {
            return redirect('/telefonos')->with('message', [
                'type' => 'success',
                'text' => 'Teléfono modificado exitosamente.'
            ]);
        } else {
            return redirect('/telefonos')->with('message', [
                'type' => 'error',
                'text' => 'No se pudo modificar el teléfono.'
            ]);
        }
    }

    public function delete_telefono(Request $request)
{
    $cookieEncriptada = request()->cookie('token');
    $token = decrypt($cookieEncriptada);

    $delete_telefono = Http::withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->put('http://82.180.162.18:4000/del_telefonos/'.$request->input("COD_TELEFONO"));

    if ($delete_telefono->successful()) {
        return redirect('/telefonos')->with('message', [
            'type' => 'success',
            'text' => 'Teléfono Eliminado.'
        ]);
    } else {
        // Manejar casos de error
        $statusCode = $delete_telefono->status();
        return redirect('/telefonos')->with('message', [
            'type' => 'error',
            'text' => "No se puede desactivar el teléfono. Código de estado: $statusCode"
        ]);
    }
}

}
