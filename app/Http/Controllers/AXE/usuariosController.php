<?php

namespace App\Http\Controllers\AXE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use DateTime;

class usuariosController extends Controller
{
    private $apiUrl = 'http://82.180.162.18:4000/usuarios'; // Declaración de la variable de la URL de la API
    public function usuarios()
    {
        $UsuarioValue = $_COOKIE["Usuario"];
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
         // Obtener los datos de PERSONAS desde el controlador PersonasController
         $personasController = new personasController();
         $personas = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://82.180.162.18:4000/personas');
         $personasArreglo = json_decode($personas, true);

        // Obtener los datos de roles desde el controlador rolesController
        $rolesController = new rolesController();
        $roles = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://82.180.162.18:4000/roles');
        $rolesArreglo = json_decode($roles, true);

         // Obtener los datos de roles desde el controlador rolesController
       /*  $estado_usuarioController = new estado_usuarioController();
         $estado_usuario = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://82.180.162.18:4000/estado_usuario');
         $estado_usuarioArreglo = json_decode($estado_usuario, true); */

        $usuarios = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://82.180.162.18:4000/usuarios');
        $usuariosArreglo = json_decode($usuarios, true);

        $OBJETO = "USUARIOS";
        $permisos = Http::post('http://82.180.162.18:4000/permisos_usuario',[
            "USUARIO" => $UsuarioValue,
            "OBJETO" =>  $OBJETO,
        ]);
        $permisosDisponibles = json_decode($permisos, true);
       
        return view('AXE.usuarios', compact('UsuarioValue','personasArreglo','rolesArreglo','usuariosArreglo', 'permisosDisponibles'));
    } 

    public function nuevo_usuario(Request $request)
    {
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
       
       
        // Obtener todas las personas desde la API
        $UsuarioValue = $_COOKIE["Usuario"];
        $USUARIO = $request->input("USUARIO");
    
        // Obtener todas las personas desde la API
        $todos_usuarios = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl);
    
        if ($todos_usuarios->successful()) {
            $usuarios_lista = $todos_usuarios->json();
    
            foreach ($usuarios_lista as $usuario) {
                if ($usuario["USUARIO"] === $USUARIO) {
                    // La persona ya existe, generar mensaje de error
                    return redirect('usuarios')->with('message', [
                        'type' => 'error',
                        'text' => 'Este usuario ya existe.'
                    ])->withInput(); // Agregar esta línea para mantener los datos ingresados
                }
                
            }
        }
      //  $PRIMER_INGRESO = $request->input("PRIMER_INGRESO") ? 1 : 0;

        // Enviar la solicitud POST a la API para agregar la nueva persona
        $nuevo_usuario = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post($this->apiUrl, [
            "USUARIO" => $request->input("USUARIO"),
            "CONTRASENA" => $request->input('CONTRASENA'),
            "MODIFICADO_POR" => $UsuarioValue,
            "COD_PERSONA" => $request->input("COD_PERSONA"),
            "COD_ESTADO_USUARIO" => $request->input("COD_ESTADO_USUARIO"),
            "COD_ROL" => $request->input("COD_ROL"),
        ]);
    
        // Verificar si la solicitud fue exitosa y redireccionar con mensaje de éxito o error
        if ($nuevo_usuario->successful()) {
            return redirect('/usuarios')->with('message', [
                'type' => 'success',
                'text' => 'Usuario agregado exitosamente.'
            ]);
        } else {
            return redirect('/usuarios')->with('message', [
                'type' => 'error',
                'text' => 'No se pudo agregar el Usuario.'
            ]);
        }
    }
    
    //update
    public function modificar_usuario(Request $request)
    {
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        $UsuarioValue = $_COOKIE["Usuario"];
        $modificar_usuario = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put($this->apiUrl.'/'.$request->input("COD_USUARIO"), [
            "USUARIO" => $request->input("USUARIO"),
            "CONTRASENA" => $request->input('CONTRASENA'),
            "PRIMER_INGRESO"=> $request->input('PRIMER_INGRESO'),
            "COD_ESTADO_USUARIO" => $request->input("COD_ESTADO_USUARIO"),
            "COD_ROL" => $request->input("COD_ROL"),
            "COD_PERSONA" => $request->input("COD_PERSONA"),
            "MODIFICADO_POR" =>  $UsuarioValue,
            
        ]); dd($request->input("COD_ROL"));
        if ($modificar_usuario->successful()) {
            return redirect('/usuarios')->with('message', [
                'type' => 'success',
                'text' => 'Usuario modificado exitosamente.'
            ]);
        } else {
            return redirect('/usuarios')->with('message', [
                'type' => 'error',
                'text' => 'No se pudo modificar el usuario.'
            ]);
        }
    }
   
    //delete
    public function delete_usuario(Request $request)
    {
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        $delete_usuario = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put('http://82.180.162.18:4000/del_usuarios/'.$request->input("COD_USUARIO"));
        
        if ($delete_usuario->successful()) {
            return redirect('/usuarios')->with('message', [
                'type' => 'success',
                'text' => 'Usuario eliminado.'
            ]);

        } else {
            return redirect('/usuarios')->with('message', [
                'type' => 'error',
                'text' => 'No se puede eliminar.'
            ]);
        }
    }

}

