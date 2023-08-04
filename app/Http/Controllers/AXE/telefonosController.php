<?php

namespace App\Http\Controllers\AXE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class telefonosController extends Controller
{
    public function telefonos()
    {
        // Obtener los datos de personas desde el controlador PersonasController
        $personasController = new PersonasController();
        $personas = Http::get('http://localhost:4000/personas');
        $personasArreglo = json_decode($personas, true);

        // Obtener los datos de teléfonos
        $telefonos = Http::get('http://localhost:4000/telefonos');
        $telefonosArreglo = json_decode($telefonos, true);

        // Paginar los teléfonos con 10 elementos por página
        /*$perPage = 10;
        $currentPage = request()->query('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $paginatedTelefonos = array_slice($telefonosArreglo, $offset, $perPage);
        $telefonosPaginados = new LengthAwarePaginator($paginatedTelefonos, count($telefonosArreglo), $perPage, $currentPage, []);
*/
        // Retornar la vista con los datos paginados
        return view('AXE.telefonos', compact('personasArreglo', 'telefonosArreglo'));
    }

    public function nuevo_telefono(Request $request)
    {
        $nuevo_telefono = Http::post('http://localhost:4000/nuevo_telefono', [
            "COD_PERSONA" => $request->input("COD_PERSONA"),
            "TELEFONO" => $request->input("TELEFONO"),
            "TIPO_TELEFONO" => $request->input("TIPO_TELEFONO"),
        ]);

        return redirect('/telefonos');
    }

    public function modificar_telefono(Request $request)
    {
        $modificar_telefono = Http::put('http://localhost:4000/modificar_telefono/' . $request->input("COD_TELEFONO"), [
            "COD_TELEFONO" => $request->input("COD_TELEFONO"),
            "TELEFONO" => $request->input("TELEFONO"),
            "TIPO_TELEFONO" => $request->input("TIPO_TELEFONO"),
        ]);

        return redirect('/telefonos');
    }
}
