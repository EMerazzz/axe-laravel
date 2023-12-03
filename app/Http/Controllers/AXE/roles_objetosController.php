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



        $UsuarioValue = $_COOKIE["Usuario"];
        $OBJETO = "ROLES_OBJETOS";

        $permisos = Http::post('http://82.180.162.18:4000/permisos_usuario',[
                "USUARIO" => $UsuarioValue,
                "OBJETO" =>  $OBJETO,
        ]);
    
        $permisosDisponibles = json_decode($permisos, true);

        return view('AXE.roles_objetos', compact('roles_objetos_Arreglo','rolesArreglo','objetosArreglo', 'permisosDisponibles'));
    }
    

    //INSERT
    public function nuevo_rol_objeto(Request $request)
{
    // Obtener token de la cookie
    $cookieEncriptada = $request->cookie('token');
    $token = decrypt($cookieEncriptada);

    // Obtener usuario de la cookie
    $UsuarioValue = $request->cookie("Usuario");

    // Para $PERMISO_INSERCION
    $PERMISO_INSERCION = $request->input("PERMISO_INSERCION");
    if ($PERMISO_INSERCION === null) {
        $PERMISO_INSERCION = 0;
    }

    // Para $PERMISO_ELIMINACION
    $PERMISO_ELIMINACION = $request->input("PERMISO_ELIMINACION");
    if ($PERMISO_ELIMINACION === null) {
        $PERMISO_ELIMINACION = 0;
    }

    // Para $PERMISO_ACTUALIZACION
    $PERMISO_ACTUALIZACION = $request->input("PERMISO_ACTUALIZACION");
    if ($PERMISO_ACTUALIZACION === null) {
        $PERMISO_ACTUALIZACION = 0;
    }

    // Para $PERMISO_CONSULTAR
    $PERMISO_CONSULTAR = $request->input("PERMISO_CONSULTAR");
    if ($PERMISO_CONSULTAR === null) {
        $PERMISO_CONSULTAR = 0;
    }

    // Enviar solicitud POST a la API externa
    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->post('http://82.180.162.18:4000/roles_objetos', [
        "COD_ROL" => $request->input("COD_ROL"),
        "COD_OBJETO" => $request->input("COD_OBJETO"),
        "PERMISO_INSERCION" => $PERMISO_INSERCION,
        "PERMISO_ELIMINACION" =>  $PERMISO_ELIMINACION,
        "PERMISO_ACTUALIZACION" => $PERMISO_ACTUALIZACION,
        "PERMISO_CONSULTAR" => $PERMISO_CONSULTAR,
    ]);

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

        $roles_objetos= Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl);
        $roles_objetos_Arreglo = json_decode($roles_objetos, true);


    // Para $PERMISO_INSERCION
    $PERMISO_INSERCION = $request->input("PERMISO_INSERCION");
    
    if ($PERMISO_INSERCION === null) {
        $PERMISO_INSERCION = 0;
    }else{
        $PERMISO_INSERCION = 1;
    }



    // Para $PERMISO_ELIMINACION
    $PERMISO_ELIMINACION = $request->input("PERMISO_ELIMINACION");
    if ($PERMISO_ELIMINACION === null) {
        $PERMISO_ELIMINACION = 0;
    }else{
        $PERMISO_ELIMINACION = 1;
    }

    // Para $PERMISO_ACTUALIZACION
    $PERMISO_ACTUALIZACION = $request->input("PERMISO_ACTUALIZACION");
    if ($PERMISO_ACTUALIZACION === null) {
        $PERMISO_ACTUALIZACION = 0;
    }else{
        $PERMISO_ACTUALIZACION = 1;
    }

    // Para $PERMISO_CONSULTAR
    $PERMISO_CONSULTAR = $request->input("PERMISO_CONSULTAR");
    if ($PERMISO_CONSULTAR === null) {
        $PERMISO_CONSULTAR = 0;
    }else{
        $PERMISO_CONSULTAR = 1;
    }

        $modificar_rol = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put($this->apiUrl.'/'.$request->input("COD_ROL_OBJETO"), [
            "COD_ROL" => $request->input("COD_ROL"),
            "COD_OBJETO" => $request->input("COD_OBJETO"),
            "PERMISO_INSERCION" => $PERMISO_INSERCION,
            "PERMISO_ELIMINACION" =>  $PERMISO_ELIMINACION,
            "PERMISO_ACTUALIZACION" => $PERMISO_ACTUALIZACION,
            "PERMISO_CONSULTAR" => $PERMISO_CONSULTAR,
            /* "FECHA_CREACION" => $request->input("FECHA_CREACION"),
            "MODIFICADO_POR" => $UsuarioValue,
            "ESTADO_registro" => $request->input("ESTADO_registro"),    */ 
        ]);
        if ($modificar_rol->successful()) {
            /* 
            return redirect('/roles_objetos')->with('message', [
                'type' => 'success',
                'text' => 'Rol objeto modificada exitosamente.'
            ]);
            */
            return redirect('/roles_objetos')->with([
                'message' => [
                    'type' => 'success',
                    'text' => 'Rol objeto modificada exitosamente.'
                ],
                'roles_objetos_Arreglo' => $roles_objetos_Arreglo,
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