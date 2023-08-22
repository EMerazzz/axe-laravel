<?php

namespace App\Http\Controllers\AXE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use DateTime;

class rolesController extends Controller
{
    private $apiUrl = 'http://localhost:4000/roles'; // Declaración de la variable de la URL de la API
    public function roles()
    {
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        $roles = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl);
        $rolesArreglo = json_decode($roles, true);
        return view('AXE.roles', compact('rolesArreglo'));
    }

    public function nuevo_rol(Request $request)
    {
    
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        // Enviar la solicitud POST a la API para agregar la nueva persona
        $nuevo_rol = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post($this->apiUrl, [
            "DESCRIPCION" => $request->input("DESCRIPCION"),
            "MODIFICADO_POR" => $request->input("MODIFICADO_POR"),
        ]);
    
        // Verificar si la solicitud fue exitosa y redireccionar con mensaje de éxito o error
        if ($nuevo_rol->successful()) {
            return redirect('/roles')->with('message', [
                'type' => 'success',
                'text' => 'Rol agregado exitosamente.'
            ]);
        } else {
            return redirect('/roles')->with('message', [
                'type' => 'error',
                'text' => 'No se pudo agregar el Rol.'
            ]);
        }
    }
    

    public function modificar_rol(Request $request)
    {
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        
        $modificar_rol = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put($this->apiUrl.'/'.$request->input("COD_ROL"), [
            "DESCRIPCION" => $request->input("DESCRIPCION"),
            "MODIFICADO_POR" => $request->input("MODIFICADO_POR"),
            
        ]);
        if ($modificar_rol->successful()) {
            return redirect('/roles')->with('message', [
                'type' => 'success',
                'text' => 'Rol modificado exitosamente.'
            ]);
        } else {
            return redirect('/roles')->with('message', [
                'type' => 'error',
                'text' => 'No se pudo modificar el Rol.'
            ]);
        }
    }
}