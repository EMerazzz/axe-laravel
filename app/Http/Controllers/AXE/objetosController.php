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


        $UsuarioValue = $_COOKIE["Usuario"];
        $OBJETO = "OBJETOS";
        $permisos = Http::post('http://82.180.162.18:4000/permisos_usuario',[
                "USUARIO" => $UsuarioValue,
                "OBJETO" =>  $OBJETO,
        ]);

        $permisosDisponibles = json_decode($permisos, true);

        return view('AXE.objetos', compact('objetosArreglo', 'permisosDisponibles'));
    }
    
    //funcion 
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
   
    //modificar put
    public function modificar_objetos(Request $request)
{
    $cookieEncriptada = request()->cookie('token');
    $token = decrypt($cookieEncriptada);

    $modificar_objetos = Http::withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->put($this->apiUrl.'/'.$request->input("COD_OBJETO"), [
        "OBJETO" => $request->input("OBJETO"),
        "DESCRIPCION" => $request->input("DESCRIPCION"),
        "TIPO_OBJETO" => $request->input("TIPO_OBJETO"),
    ]);
    
    if ($modificar_objetos->successful()) {
        return redirect('/objetos')->with('message', [
            'type' => 'success',
            'text' => 'Modificado exitosamente.'
        ]);
    } else {
        return redirect('/objetos')->with('message', [
            'type' => 'error',
            'text' => 'No se pudo modificar.'
        ]);
    }
}

//Delete
public function delete_objetos(Request $request)
{
    try {
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);

        $delete_objetos = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put('http://82.180.162.18:4000/del_objetos/'.$request->input("COD_OBJETO"));

        // Verificar si la solicitud fue exitosa
        if ($delete_objetos->successful()) {
            return redirect('/objetos')->with('message', [
                'type' => 'success',
                'text' => 'Objeto eliminado correctamente.'
            ]);
        } else {
            // Manejar casos de error
            $statusCode = $delete_objetos->status();
            return redirect('/objetos')->with('message', [
                'type' => 'error',
                'text' => "No se puede desactivar el objeto. Código de estado: $statusCode"
            ]);
        }
    } catch (\Exception $e) {
        // Manejar excepciones
        return redirect('/objetos')->with('message', [
            'type' => 'error',
            'text' => "Error al intentar eliminar el objeto: " . $e->getMessage()
        ]);
    }
}


}