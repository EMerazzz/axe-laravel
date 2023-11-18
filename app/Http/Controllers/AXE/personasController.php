<?php

namespace App\Http\Controllers\AXE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use DateTime;

class PersonasController extends Controller
{
    private $apiUrl = 'http://82.180.162.18:4000/personas'; // Declaración de la variable de la URL de la API
   
    public function personas()
    {
    
        $cookieEncriptada = request()->cookie('token');//trae la cookie encriptada
        $token = decrypt($cookieEncriptada);//desencripta la cookie
       

       // dd ( $UsuarioValue);
        $personas = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl);

        $personasArreglo = json_decode($personas, true);
        return view('AXE.personas', compact('personasArreglo'));
    }

    public function nueva_persona(Request $request)
    {
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        //usuario
        $UsuarioValue = $_COOKIE["Usuario"];
        $identidad = $request->input("IDENTIDAD");
    
        // Obtener todas las personas desde la API
        $todas_las_personas = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->apiUrl);
    
        if ($todas_las_personas->successful()) {
            $personas_lista = $todas_las_personas->json();
    
            foreach ($personas_lista as $persona) {
                if ($persona["IDENTIDAD"] === $identidad) {
                    // La persona ya existe, generar mensaje de error
                    return redirect('personas')->with('message', [
                        'type' => 'error',
                        'text' => 'Persona con esta identidad ya existe.'
                    ])->withInput(); // Agregar esta línea para mantener los datos ingresados
                }
                
            }
        }
        // Resto del código para calcular la edad
        $fecha_nacimiento = $request->input("FECHA_NACIMIENTO");
        $edad = $this->calcularEdad($fecha_nacimiento);
    
        // Enviar la solicitud POST a la API para agregar la nueva persona
        $nueva_persona = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('http://82.180.162.18:4000/INSpersonas', [
            "NOMBRE" => $request->input("NOMBRE"),
            "APELLIDO" => $request->input("APELLIDO"),
            "IDENTIDAD" => $request->input("IDENTIDAD"),
            "GENERO" => $request->input("GENERO"),
            "TIPO_PERSONA" => $request->input("TIPO_PERSONA"),
            "EDAD" => $edad,
            "FECHA_NACIMIENTO" => $fecha_nacimiento,
            "USUARIO_MODIFICADOR" => $UsuarioValue,
            //TELEFONOS
            "TELEFONO" => $request->input("TELEFONO"),
            "TIPO_TELEFONO" => $request->input("TIPO_TELEFONO"),
            //DIRECCIONES
            "DIRECCION"=> $request->input("DIRECCION"),
            "DEPARTAMENTO"=> $request->input("DEPARTAMENTO"),
            "CIUDAD"=> $request->input("CIUDAD"),
            "PAIS"=> $request->input("PAIS"),
            //CONTACTOS
            "NOMBRE_CONTACTO"=> $request->input("NOMBRE_CONTACTO"),
            "APELLIDO_CONTACTO"=> $request->input("APELLIDO_CONTACTO"),
            "TELEFONO_CONTACTO"=> $request->input("TELEFONO_CONTACTO"),
            "RELACION"=> $request->input("RELACION"),
            //correos
            "CORREO_ELECTRONICO"=> $request->input("CORREO_ELECTRONICO"),
        ]);
    
        // Verificar si la solicitud fue exitosa y redireccionar con mensaje de éxito o error
        if ($nueva_persona->successful()) {
            return redirect('/personas')->with('message', [
                'type' => 'success',
                'text' => 'Persona agregada exitosamente.'
            ]);
        } else {
            return redirect('/personas')->with('message', [
                'type' => 'error',
                'text' => 'No se pudo agregar la persona.'
            ]);
        }
    }
    
    

    private function calcularEdad($fecha_nacimiento)
    {
        $hoy = new DateTime();
        $nacimiento = new DateTime($fecha_nacimiento);
        $diferencia = $nacimiento->diff($hoy);
        return $diferencia->y;
    }

    public function modificar_persona(Request $request)
    {
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        //usuario
        $UsuarioValue = $_COOKIE["Usuario"];
        //calcular edad
        $fecha_nacimiento = $request->input("FECHA_NACIMIENTO");
        $edad = $this->calcularEdad($fecha_nacimiento);

        $modificar_persona = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put($this->apiUrl.'/'.$request->input("COD_PERSONA"), [
            "NOMBRE" => $request->input("NOMBRE"),
            "APELLIDO" => $request->input("APELLIDO"),
            "IDENTIDAD" => $request->input("IDENTIDAD"),
            "GENERO" => $request->input("GENERO"),
            "TIPO_PERSONA" => $request->input("TIPO_PERSONA"),
            "EDAD" => $edad,
            "FECHA_NACIMIENTO" => $fecha_nacimiento,
            "USUARIO_MODIFICADOR" => $UsuarioValue,
        ]);
        if ($modificar_persona->successful()) {
            return redirect('/personas')->with('message', [
                'type' => 'success',
                'text' => 'Persona modificada exitosamente.'
            ]);
        } else {
            return redirect('/personas')->with('message', [
                'type' => 'error',
                'text' => 'No se pudo modificar la persona.'
            ]);
        }
    }
}