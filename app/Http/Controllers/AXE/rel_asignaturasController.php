<?php

namespace App\Http\Controllers\AXE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use DateTime;

class rel_asignaturasController extends Controller
{
    private $apiUrl = 'http://82.180.162.18:4000'; // Declaración de la variable de la URL de la API
    public function rel_asignaturas()
    {
        $UsuarioValue = $_COOKIE["Usuario"];
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
         
        //asignaturas
        $asignaturasController= new asignaturasController();
        $asignaturas = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl.'/asignaturas');
           $asignaturasArreglo = json_decode($asignaturas,true);
        
        //Rel nivacad
        $rel_nivacad_anioacadController = new rel_nivacad_anioacadController();
        $rel_nivacad_anioacad = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl.'/rel_nivel_anio');
        $rel_nivacad_anioacadArreglo = json_decode($rel_nivacad_anioacad, true);
        //rel_asignaturas
        $rel_asignaturas = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl.'/rel_asignaturas');
        $rel_asignaturasArreglo = json_decode($rel_asignaturas, true);

        $OBJETO = "rel_asignaturas";
        $permisos = Http::post($this->apiUrl.'/permisos_usuario',[
            "USUARIO" => $UsuarioValue,
            "OBJETO" =>  $OBJETO,
        ]);
        $permisosDisponibles = json_decode($permisos, true);
       //dd($rel_asignaturasArreglo);
        return view('AXE.rel_asignaturas', compact('UsuarioValue','rel_asignaturasArreglo','rel_nivacad_anioacadArreglo','asignaturasArreglo'));
    }

    public function nuevo_rel_asignaturas(Request $request)
    {
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
       
       
        // Obtener todas las personas desde la API
        $UsuarioValue = $_COOKIE["Usuario"];
       /* $USUARIO = $request->input("USUARIO");
    
        // Obtener todas las personas desde la API
        $todos_rel_asignaturas = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl.'/rel_asignaturas ');
    
        if ($todos_rel_asignaturas->successful()) {
            $rel_asignaturas_lista = $todos_rel_asignaturass->json();
    
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
*/
        // Enviar la solicitud POST a la API para agregar la nueva persona
        $nuevo_rel_asignaturas = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post($this->apiUrl.'/rel_asignaturas', [
            "COD_ASIGNATURA" => $request->input("COD_ASIGNATURA"),
            "COD_NIVACAD_ANIOACAD" => $request->input("COD_NIVACAD_ANIOACAD"),
            //"MODIFICADO_POR" => $UsuarioValue,
            "Estado_registro" => $request->input("Estado_registro"),
        ]);//dd($request->input("COD_ASIGNATURA"));
       //dd($request->input("COD_NIVACAD_ANIOACAD"));
       // dd($request->input("Estado_registro"));
    
        // Verificar si la solicitud fue exitosa y redireccionar con mensaje de éxito o error
        if ($nuevo_rel_asignaturas->successful()) {
            return redirect('/rel_asignaturas')->with('message', [
                'type' => 'success',
                'text' => 'Agregado exitosamente.'
            ]);
        } else {
            return redirect('/rel_asignaturas')->with('message', [
                'type' => 'error',
                'text' => 'No se pudo agregar.'
            ]);
        }
    }
    
    //update
    public function modificar_rel_asignaturas(Request $request)
    {
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        $UsuarioValue = $_COOKIE["Usuario"];

        $modificar_rel_asignaturas = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put($this->apiUrl.'/rel_asignaturas'.'/'.$request->input("COD_REL_ASIG"), [
            "COD_ASIGNATURA" => $request->input("COD_ASIGNATURA"),
            "COD_NIVACAD_ANIOACAD" => $request->input('COD_NIVACAD_ANIOACAD'),
           // "MODIFICADO_POR" => $UsuarioValue,
            "Estado_registro" => $request->input("Estado_registro"),
            
        ]); //dd($request->input("COD_ROL"));
        if ($modificar_rel_asignaturas->successful()) {
            return redirect('/rel_asignaturas')->with('message', [
                'type' => 'success',
                'text' => 'Modificado exitosamente.'
            ]);
        } else {
            return redirect('/rel_asignaturas')->with('message', [
                'type' => 'error',
                'text' => 'No se pudo modificar.'
            ]);
        }
    }
   
    //delete
   /* public function delete_usuario(Request $request)
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
*/
}

