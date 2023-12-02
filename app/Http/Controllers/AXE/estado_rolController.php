<?php

namespace App\Http\Controllers\AXE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class estado_rolController extends Controller
{
    
    private $apiUrl = 'http://82.180.162.18:4000/estado_rol';
   //mostrar
    public function estado_rol()
    {
        try {
            $cookieEncriptada = request()->cookie('token');
            $token = decrypt($cookieEncriptada);
            
           
            $estado_rol = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get($this->apiUrl);
            //dd($token);
            //dd($estado_rol);

            $estado_rolArreglo = json_decode($estado_rol, true);
            //dd($estado_rolArreglo );
            return view('AXE.estado_rol', compact('estado_rolArreglo'));
        } catch (\Exception $e) {
            return view('AXE.estado_rol', compact('estado_rolArreglo'))->withErrors(['error' => 'Error al obtener datos.']);
        }
    }

    public function nuevo_estado_rol(Request $request)
    {
        try {
            $cookieEncriptada = request()->cookie('token');
            $token = decrypt($cookieEncriptada);

            $todas_los_estado_rol = Http::get($this->apiUrl);

            $nuevo_estado_rol = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->post($this->apiUrl, [
                "DESCRIPCION" => $request->input("DESCRIPCION"),
            ]);

            if ($nuevo_estado_rol->successful()) {
                return redirect('/estado_rol')->with('message', [
                    'type' => 'success',
                    'text' => 'Estado Rol agregado exitosamente.'
                ]);
            } else {
                return redirect('/estado_rol')->with('message', [
                    'type' => 'error',
                    'text' => 'No se pudo agregar el Estado Usuario.'
                ]);
            }
        } catch (\Exception $e) {
            return redirect('/login')->with('message', [
                'type' => 'error',
                'text' => 'Error al obtener el token.'
            ]);
        }
    }


    //Actualizar
    public function modificar_estado_rol(Request $request)
    {
        try {
            $cookieEncriptada = request()->cookie('token');
            $token = decrypt($cookieEncriptada);

            $modificar_estado_rol = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->put($this->apiUrl.'/'.$request->input("COD_ESTADO_ROL"), [
                "DESCRIPCION" => $request->input("DESCRIPCION"),
            ]);

            if ($modificar_estado_rol->successful()) {
                return redirect('/estado_rol')->with('message', [
                    'type' => 'success',
                    'text' => 'Estado modificado exitosamente.'
                ]);
            } else {
                return redirect('/estado_rol')->with('message', [
                    'type' => 'error',
                    'text' => 'No se pudo modificar el Estado.'
                ]);
            }
        } catch (\Exception $e) {
            return redirect('/login')->with('message', [
                'type' => 'error',
                'text' => 'Error al obtener el token.'
            ]);
        }
    }

    //DELETE
    public function del_estado_rol(Request $request)
{
    try {
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);

        $del_estado_rol = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put('http://82.180.162.18:4000/del_estado_rol/'.$request->input("COD_ESTADO_ROL"));

        if ($del_estado_rol->successful()) {
            return redirect('/estado_rol')->with('message', [
                'type' => 'success',
                'text' => 'Estado Rol eliminado correctamente.'
            ]);
        } else {
            $statusCode = $del_estado_rol->status();
            return redirect('/estado_rol')->with('message', [
                'type' => 'error',
                'text' => "No se puede desactivar el Estado Rol. Código de estado: $statusCode"
            ]);
        }
    } catch (\Exception $e) {
        return redirect('/login')->with('message', [
            'type' => 'error',
            'text' => 'Error al obtener el token.'
        ]);
    }
}


}
