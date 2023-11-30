<?php

namespace App\Http\Controllers\AXE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use DateTime;

class parametrosController extends Controller
{
    private $apiUrl = 'http://82.180.162.18:4000/parametros'; // Declaración de la variable de la URL de la API
    
    public function parametros()
    {   

        $UsuarioValue = $_COOKIE["Usuario"];
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        $parametros = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl);
        $parametrosArreglo = json_decode($parametros, true);
        //dd($UsuarioValue);
        return view('AXE.parametros', compact('UsuarioValue', 'parametrosArreglo'));
    }

    public function nuevo_parametro(Request $request)
{
    $cookieEncriptada = $request->cookie('token');
    $token = decrypt($cookieEncriptada);

    $UsuarioValue = $request->cookie('Usuario');

    // Enviar la solicitud POST a la API para agregar el nuevo rol
    $nuevo_parametros = Http::withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->post($this->apiUrl, [
        "PARAMETRO" => $request->input("PARAMETRO"),
        "VALOR" => $request->input("VALOR"), // Asignar el valor de Usuario a MODIFICADO_POR
        "USUARIO" => $request->input("USUARIO"),
        //"FECHA_CREADO" => $request->input("FECHA_CREADO"),
        //"FECHA_MODIFICADO" => $request->input("FECHA_MODIFICADO"),
    ]);

    // Verificar si la solicitud fue exitosa y redireccionar con mensaje de éxito o error
    if ($nuevo_parametros->successful()) {
        return redirect('/parametros')->with('message', [
            'type' => 'success',
            'text' => 'Parametro agregado exitosamente.'
        ]);
    } else {
        return redirect('/parametros')->with('message', [
            'type' => 'error',
            'text' => 'No se pudo agregar el Parametro.'
        ]);
    }
}

    public function modificar_parametro(Request $request)
    {
        $UsuarioValue = $request->cookie('Usuario');
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        
        $modificar_parametro = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put($this->apiUrl.'/'.$request->input("COD_PARAMETRO"), [
            "COD_PARAMETRO" => $request->input("COD_PARAMETRO"),
            "PARAMETRO" => $request->input("PARAMETRO"),
            "VALOR" => $request->input("VALOR"),
            "USUARIO" => $request->input("USUARIO"),
            //"FECHA_CREADO" => $request->input("FECHA_CREADO"),
            //"FECHA_MODIFICADO" => $request->input("FECHA_MODIFICADO"),
            
        ]);
        if ($modificar_parametro->successful()) {
            return redirect('/parametros')->with('message', [
                'type' => 'success',
                'text' => 'Parametro modificado exitosamente.'
            ]);
        } else {
            return redirect('/parametros')->with('message', [
                'type' => 'error',
                'text' => 'No se pudo modificar el Parametro.'
            ]);
        }
    }

    //Delete
    public function delete_parametro(Request $request)
    {
        try {
            $cookieEncriptada = request()->cookie('token');
            $token = decrypt($cookieEncriptada);
    
            // Agregar barra diagonal después de 'del_parametros'
            $delete_parametro = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->put('http://localhost:4000/del_parametros/' . $request->input("COD_PARAMETRO"));
    
            // Verificar si la solicitud fue exitosa
            if ($delete_parametro->successful()) {
                return redirect('/parametros')->with('message', [
                    'type' => 'success',
                    'text' => 'Parámetro eliminado correctamente.'
                ]);
            }
    
            // Manejar casos de error específicos
            $statusCode = $delete_parametro->status();
            if ($statusCode === 404) {
                return redirect('/parametros')->with('message', [
                    'type' => 'error',
                    'text' => 'Parámetro no encontrado.'
                ]);
            }
    
            return redirect('/parametros')->with('message', [
                'type' => 'error',
                'text' => "No se puede desactivar el objeto. Código de estado: $statusCode"
            ]);
    
        } catch (\Exception $e) {
            // Manejar excepciones
            return redirect('/parametros')->with('message', [
                'type' => 'error',
                'text' => "Error al intentar eliminar el objeto: " . $e->getMessage()
            ]);
        }
    }
    
}
