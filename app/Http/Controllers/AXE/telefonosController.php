<?php

namespace App\Http\Controllers\AXE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class telefonosController extends Controller
{
    private $apiUrl = 'http://localhost:4000/telefonos'; // Declaración de la variable de la URL de la API
    public function telefonos()
    {
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        // Obtener los datos de personas desde el controlador PersonasController
        $personasController = new PersonasController();
        $personas = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://localhost:4000/personas');
        $personasArreglo = json_decode($personas, true);

        // Obtener los datos de teléfonos
        $telefonos = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl);
        $telefonosArreglo = json_decode($telefonos, true);

        return view('AXE.telefonos', compact('personasArreglo', 'telefonosArreglo'));
    }

    public function nuevo_telefono(Request $request)
    {
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);

        $nuevo_telefono = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post($this->apiUrl, [
            "COD_PERSONA" => $request->input("COD_PERSONA"),
            "TELEFONO" => $request->input("TELEFONO"),
            "TIPO_TELEFONO" => $request->input("TIPO_TELEFONO"),
        ]);

        if ($nuevo_telefono ->successful()) {
            return redirect('/telefonos')->with('message', [
                'type' => 'success',
                'text' => 'Teléfono agregado exitosamente.'
            ]);
        } else {
            return redirect('/telefonos')->with('message', [
                'type' => 'error',
                'text' => 'No se pudo agregar el Teléfono.'
            ]);
        }
    }

    public function modificar_telefono(Request $request)
    {
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        
        $modificar_telefono = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put($this->apiUrl.'/'. $request->input("COD_TELEFONO"), [
            "COD_TELEFONO" => $request->input("COD_TELEFONO"),
            "TELEFONO" => $request->input("TELEFONO"),
            "TIPO_TELEFONO" => $request->input("TIPO_TELEFONO"),
        ]);

        if ($modificar_telefono->successful()) {
            return redirect('/telefonos')->with('message', [
                'type' => 'success',
                'text' => 'Teléfono modificado exitosamente.'
            ]);
        } else {
            return redirect('/telefonos')->with('message', [
                'type' => 'error',
                'text' => 'No se pudo modificar el teléfono.'
            ]);
        }
    }
}
