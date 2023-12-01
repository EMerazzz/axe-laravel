<?php

namespace App\Http\Controllers\AXE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use DateTime;

class roles_objetosController extends Controller
{
    private $apiUrl = 'http://82.180.162.18:4000/roles_objetos'; // Declaración de la variable de la URL de la API
   
    public function roles_objetos()
    {
    
        $cookieEncriptada = request()->cookie('token');//trae la cookie encriptada
        $token = decrypt($cookieEncriptada);//desencripta la cookie
        // Obtener los datos de roles desde el controlador 
        $rolesController = new rolesController();
        $roles = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://82.180.162.18:4000/roles');
        $rolesArreglo = json_decode($roles, true);
        // Obtener los datos de correos desde el controlador 
        $objetosController = new objetosController();
        $objetos = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://82.180.162.18:4000/objetos');
        $objetosArreglo = json_decode($objetos, true);
        
        $roles_objetos= Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl);
        $roles_objetos_Arreglo = json_decode($roles_objetos, true);

        return view('AXE.roles_objetos', compact('roles_objetos_Arreglo','rolesArreglo','objetosArreglo'));
    }

    public function nuevo_rol_objeto(Request $request)
    {
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        //usuario
        $UsuarioValue = $_COOKIE["Usuario"];
        //$identidad = $request->input("IDENTIDAD");
    
        // Enviar la solicitud POST a la API para agregar la nueva persona
        $nuevo_roles_objeto = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('http://82.180.162.18:4000/roles_objetos', [

            "COD_ROL" => $request->input("COD_ROL"),
            "COD_OBJETO" => $request->input("COD_OBJETO"),
            "PERMISO_INSERCION" => $request->input("PERMISO_INSERCION"),
            "PERMISO_ELIMINACION" => $request->input("PERMISO_ELIMINACION"),
            "PERMISO_ACTUALIZACION" => $request->input("PERMISO_ACTUALIZACION"),
            "PERMISO_CONSULTAR" => $request->input("PERMISO_CONSULTAR"),
            /* "FECHA_CREACION" => $request->input("FECHA_CREACION"),
            "MODIFICADO_POR" => $UsuarioValue,
            "ESTADO_registro" => $request->input("ESTADO_registro"),   */  
        ]);
    
        // Verificar si la solicitud fue exitosa y redireccionar con mensaje de éxito o error
        if ($nuevo_roles_objeto->successful()) {
            return redirect('/roles_objetos')->with('message', [
                'type' => 'success',
                'text' => 'Rol objeto exitosamente.'
            ]);
        } else {
            return redirect('/roles_objetos')->with('message', [
                'type' => 'error',
                'text' => 'No se pudo agregar el rol objeto.'
            ]);
        }
    }
    
    
    public function modificar_rol_objeto(Request $request)
    {
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        //usuario
        $UsuarioValue = $_COOKIE["Usuario"];
        //calcular edad
        //$fecha_nacimiento = $request->input("FECHA_NACIMIENTO");
        //$edad = $this->calcularEdad($fecha_nacimiento);

        $modificar_rol = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put($this->apiUrl.'/'.$request->input("COD_ROL_OBJETO"), [
            "COD_ROL" => $request->input("COD_ROL"),
            "COD_OBJETO" => $request->input("COD_OBJETO"),
            "PERMISO_INSERCION" => $request->input("PERMISO_INSERCION"),
            "PERMISO_ELIMINACION" => $request->input("PERMISO_ELIMINACION"),
            "PERMISO_ACTUALIZACION" => $request->input("PERMISO_ACTUALIZACION"),
            "PERMISO_CONSULTAR" => $request->input("PERMISO_CONSULTAR"),
            /* "FECHA_CREACION" => $request->input("FECHA_CREACION"),
            "MODIFICADO_POR" => $UsuarioValue,
            "ESTADO_registro" => $request->input("ESTADO_registro"),    */ 
        ]);
        if ($modificar_rol->successful()) {
            return redirect('/roles_objetos')->with('message', [
                'type' => 'success',
                'text' => 'Rol objeto modificada exitosamente.'
            ]);
        } else {
            return redirect('/roles_objetos')->with('message', [
                'type' => 'error',
                'text' => 'No se pudo modificar el rol objeto.'
            ]);
        }
    }
  
}