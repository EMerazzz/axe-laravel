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
   //MOSTRAR
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
    

    //INSERT
    public function nuevo_rol_objeto(Request $request)
{
    // Obtener token de la cookie
    $cookieEncriptada = $request->cookie('token');
    $token = decrypt($cookieEncriptada);

    // Obtener usuario de la cookie
    $UsuarioValue = $request->cookie("Usuario");

    // Validar datos de entrada si es necesario

    // Enviar solicitud POST a la API externa
    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->post('http://82.180.162.18:4000/roles_objetos', [
        "COD_ROL" => $request->input("COD_ROL"),
        "COD_OBJETO" => $request->input("COD_OBJETO"),
        "PERMISO_INSERCION" => $request->input("PERMISO_INSERCION"),
        "PERMISO_ELIMINACION" => $request->input("PERMISO_ELIMINACION"),
        "PERMISO_ACTUALIZACION" => $request->input("PERMISO_ACTUALIZACION"),
        "PERMISO_CONSULTAR" => $request->input("PERMISO_CONSULTAR"),
    ]);

    // Verificar la respuesta de la API
    if ($response->successful()) {
        return redirect('/roles_objetos')->with('message', [
            'type' => 'success',
            'text' => 'Rol objeto agregado exitosamente.'
        ]);
    } else {
        // Manejar error y redirigir
        $errorMessage = $response->json('message', 'No se pudo agregar el rol objeto.');
        return redirect('/roles_objetos')->with('message', [
            'type' => 'error',
            'text' => $errorMessage
        ]);
    }
}

    
    //MODIFICAR
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


    //DELETE
    public function delete_rol_objeto(Request $request)
    {
        try {
            $cookieEncriptada = request()->cookie('token');
            $token = decrypt($cookieEncriptada);
    
            // Agregar barra diagonal después de 'del_parametros'
            $delete_rol_objeto = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->put('http://82.180.162.18:4000/del_roles_objetos/' . $request->input("COD_ROL_OBJETO"));
    
            // Verificar si la solicitud fue exitosa
            if ($delete_rol_objeto->successful()) {
                return redirect('/roles_objetos')->with('message', [
                    'type' => 'success',
                    'text' => 'Rol Objeto eliminado correctamente.'
                ]);
            }
    
            // Manejar casos de error específicos
            $statusCode = $delete_rol_objeto->status();
            if ($statusCode === 404) {
                return redirect('/roles_objetos')->with('message', [
                    'type' => 'error',
                    'text' => 'Rol Objeto no encontrado.'
                ]);
            }
    
            return redirect('/roles_objetos')->with('message', [
                'type' => 'error',
                'text' => "No se puede desactivar el objeto. Código de estado: $statusCode"
            ]);
    
        } catch (\Exception $e) {
            // Manejar excepciones
            return redirect('/roles_objetos')->with('message', [
                'type' => 'error',
                'text' => "Error al intentar eliminar el objeto: " . $e->getMessage()
            ]);
        }
    }
  
}