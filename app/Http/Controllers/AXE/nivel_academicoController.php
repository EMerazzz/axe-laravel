<?php

namespace App\Http\Controllers\AXE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use DateTime;

class nivel_academicoController extends Controller
{
    private $apiUrl = 'http://82.180.162.18:4000/nivel_academico'; // Declaración de la variable de la URL de la API
    public function nivel_academico()
    {
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        $nivel_academico = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl);
        $nivel_academicoArreglo = json_decode($nivel_academico, true);
        return view('AXE.nivel_academico', compact('nivel_academicoArreglo'));
    }

    public function nuevo_nivel_academico(Request $request)
    {
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
       
        // Obtener todas las personas desde la API
        $todas_los_niveles = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl);
    
        
        // Enviar la solicitud POST a la API para agregar la nueva persona
        $nuevo_nivel_academico = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post($this->apiUrl, [
            "descripcion" => $request->input("descripcion"),
        ]);
    
        // Verificar si la solicitud fue exitosa y redireccionar con mensaje de éxito o error
        if ($nuevo_nivel_academico->successful()) {
            return redirect('/nivel_academico')->with('message', [
                'type' => 'success',
                'text' => 'Nivel academico agregado exitosamente.'
            ]);
        } else {
            return redirect('/nivel_academico')->with('message', [
                'type' => 'error',
                'text' => 'No se pudo agregar el nivel academico.'
            ]);
        }
    }
    

    public function modificar_nivel_academico(Request $request)
    {
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        
        $modificar_nivel_academico = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put($this->apiUrl.'/'.$request->input("COD_NIVEL_ACADEMICO"), [
            "descripcion" => $request->input("descripcion"),
            
        ]);
        if ($modificar_nivel_academico->successful()) {
            return redirect('/nivel_academico')->with('message', [
                'type' => 'success',
                'text' => 'Nivel academico modificado exitosamente.'
            ]);
        } else {
            return redirect('/nivel_academico')->with('message', [
                'type' => 'error',
                'text' => 'No se pudo modificar el nivel academico.'
            ]);
        }
    }

    public function delete_nivel_academico(Request $request)
{
    $cookieEncriptada = request()->cookie('token');
    $token = decrypt($cookieEncriptada);

    $delete_nivel_academico = Http::withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->put('http://82.180.162.18:4000/del_nivel_academico/'.$request->input("COD_NIVEL_ACADEMICO"));

    if ($delete_nivel_academico->successful()) {
        return redirect('/nivel_academico')->with('message', [
            'type' => 'success',
            'text' => 'Nivel Academico Eliminado.'
        ]);
    } else {
        // Manejar casos de error
        $statusCode = $delete_nivel_academico->status();
        return redirect('/nivel_academico')->with('message', [
            'type' => 'error',
            'text' => "No se puede desactivar el teléfono. Código de estado: $statusCode"
        ]);
    }
}
}