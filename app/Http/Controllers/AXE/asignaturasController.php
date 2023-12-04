<?php

namespace App\Http\Controllers\AXE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class asignaturasController extends Controller
{
    private $apiUrl = 'http://82.180.162.18:4000/asignaturas'; // Declaración de la variable de la URL de la API
    public function asignaturas(){
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
       $asignaturas = Http::withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->get($this->apiUrl);
       $citaArreglo = json_decode($asignaturas,true);
       //return $reservaciones;
       return view('AXE.asignaturas', compact('citaArreglo'));
       
    }

    public function nueva_asignatura(Request $request ){
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        $nombre_asignatura = $request->input("NOMBRE_ASIGNATURA");
    
        // Obtener todas las personas desde la API
        $todas_las_asignaturas = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl);
    
        if ($todas_las_asignaturas->successful()) {
            $asignatura_lista = $todas_las_asignaturas->json();
    
            foreach ($asignatura_lista as $asignatur) {
                if ($asignatur["NOMBRE_ASIGNATURA"] === $nombre_asignatura) {
                    // La persona ya existe, generar mensaje de error
                    return redirect('personas')->with('message', [
                        'type' => 'error',
                        'text' => 'Esta asigantura ya existe.'
                    ])->withInput(); // Agregar esta línea para mantener los datos ingresados
                }
                
            }
        }


        $nueva_asignatura = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post($this->apiUrl,[
        "NOMBRE_ASIGNATURA" => $request->input("NOMBRE_ASIGNATURA"),
        ]);
         // Verificar si la solicitud fue exitosa y redireccionar con mensaje de éxito o error
         if ($nueva_asignatura ->successful()) {
            return redirect('/asignaturas')->with('message', [
                'type' => 'success',
                'text' => 'Agregado exitosamente.'
            ]);
        } else {
            return redirect('/asignaturas')->with('message', [
                'type' => 'error',
                'text' => 'No se pudo agregar.'
            ]);
        }
    }

    public function modificar_asignaturas(Request $request ){
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        $modificar_asignatura = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put($this->apiUrl.'/'.$request->input("COD_ASIGNATURA"),[
        "COD_ASIGNATURA"=> $request->input("COD_ASIGNATURA"),
        "NOMBRE_ASIGNATURA" => $request->input("NOMBRE_ASIGNATURA"),
        ]);
       //print_r([$putformatos]);die();

       if ($modificar_asignatura->successful()) {
        return redirect('/asignaturas')->with('message', [
            'type' => 'success',
            'text' => 'Modificado exitosamente.'
        ]);
    } else {
        return redirect('/asignaturas')->with('message', [
            'type' => 'error',
            'text' => 'No se pudo modificar .'
        ]);
    }
    }

    public function delete_asignatura(Request $request)
{
    $cookieEncriptada = request()->cookie('token');
    $token = decrypt($cookieEncriptada);

    $delete_asignatura = Http::withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->put('http://82.180.162.18:4000/del_asignaturas/'.$request->input("COD_ASIGNATURA"));

    if ($delete_asignatura->successful()) {
        return redirect('/asignaturas')->with('message', [
            'type' => 'success',
            'text' => 'Asignatura Eliminada.'
        ]);
    } else {
        // Manejar casos de error
        $statusCode = $delete_telefono->status();
        return redirect('/asignaturas')->with('message', [
            'type' => 'error',
            'text' => "No se puede desactivar el teléfono. Código de estado: $statusCode"
        ]);
    }
}


}