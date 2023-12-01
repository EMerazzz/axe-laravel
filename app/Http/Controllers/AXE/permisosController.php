<?php

namespace App\Http\Controllers\AXE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class permisosController extends Controller
{
    private $apiUrl = 'http://82.180.162.18:4000/permisos'; // Declaración de la variable de la URL de la API
    public function permisos()
    {
        $UsuarioValue = $_COOKIE["Usuario"];
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        // Obtener los datos de roles desde el controlador rolesController
        $rolesController = new rolesController();
        $roles = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://82.180.162.18:4000/roles');
        $rolesArreglo = json_decode($roles, true);
        
        // Obtener los datos de teléfonos
        $permisos = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl);
        $permisosArreglo = json_decode($permisos, true);

        return view('AXE.permisos', compact('UsuarioValue','rolesArreglo', 'permisosArreglo'));
    }

    public function nuevo_permiso(Request $request)
    {
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        $rolSeleccionadoId = $request->input("COD_ROL");
        // Obtener los datos de la persona seleccionada por su ID desde la API de personas
        $rolSeleccionado = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get("http://82.180.162.18:4000/roles/{$rolSeleccionadoId}");
       // dd($personaSeleccionada);
        $rolSeleccionadoData = json_decode($rolSeleccionado, true);
         
       // Obtener los datos de la persona seleccionada por su ID desde la API de personas
    $rolSeleccionado = Http::withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->get("http://82.180.162.18:4000/roles/{$rolSeleccionadoId}");
    $rolSeleccionadoData = json_decode($rolSeleccionado, true);

      // Obtener el valor del checkbox y asignar el valor adecuado
      /* $permisoInsercion = $request->input("PERMISO_INSERCION") ? 1 : 0;
      $permisoEliminacion = $request->input("PERMISO_ELIMINACION") ? 1 : 0;
      $permisoActualizacion = $request->input("PERMISO_ACTUALIZACION") ? 1 : 0;
      $permisoConsultar = $request->input("PERMISO_CONSULTAR") ? 1 : 0; */

   
        $nuevo_permiso = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post($this->apiUrl, [
            "PERMISO_INSERCION" => $request->input("PERMISO_INSERCION") ? 1 : 0,
            "PERMISO_ELIMINACION" =>  $request->input("PERMISO_ELIMINACION") ? 1 : 0,
            "PERMISO_ACTUALIZACION" => $request->input("PERMISO_ACTUALIZACION") ? 1 : 0,
            "PERMISO_CONSULTAR" => $request->input("PERMISO_CONSULTAR") ? 1 : 0,
            "MODIFICADO_POR" => $request->input("MODIFICADO_POR"),
            "COD_ROL" => $request->input("COD_ROL"),

        ]);

      // Verificar si la solicitud fue exitosa y redireccionar con mensaje de éxito o error
      if ($nuevo_permiso ->successful()) {
        return redirect('/permisos')->with('message', [
            'type' => 'success',
            'text' => 'Agregado exitosamente.'
        ]);
    } else {
        return redirect('/permisos')->with('message', [
            'type' => 'error',
            'text' => 'No se pudo agregar.'
        ]);
    }
    }

    public function modificar_permiso(Request $request)
    {   
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
         // Obtener el valor del checkbox y asignar el valor adecuado
      $permisoInsercion = $request->input("PERMISO_INSERCION") ? 1 : 0;
      $permisoEliminacion = $request->input("PERMISO_ELIMINACION") ? 1 : 0;
      $permisoActualizacion = $request->input("PERMISO_ACTUALIZACION") ? 1 : 0;
      $permisoConsultar = $request->input("PERMISO_CONSULTAR") ? 1 : 0;

        $modificar_permiso =  Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put($this->apiUrl.'/'. $request->input("COD_PERMISO"), [
            "PERMISO_INSERCION" => $permisoInsercion,
            "PERMISO_ELIMINACION" => $permisoEliminacion,
            "PERMISO_ACTUALIZACION" => $permisoActualizacion,
            "PERMISO_CONSULTAR" => $permisoConsultar,
            "MODIFICADO_POR" => $request->input("MODIFICADO_POR"),
            "COD_ROL" => $request->input("COD_ROL"),

        ]);

       // Verificar si la solicitud fue exitosa y redireccionar con mensaje de éxito o error
       if ($modificar_permiso->successful()) {
        return redirect('/permisos')->with('message', [
            'type' => 'success',
            'text' => 'Modificado exitosamente.'
        ]);
    } else {
        return redirect('/permisos')->with('message', [
            'type' => 'error',
            'text' => 'No se pudo modificar .'
        ]);
    }
    }
}