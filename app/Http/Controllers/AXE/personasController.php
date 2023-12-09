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
        // Obtener los datos de telefonos desde el controlador 
        $telefonosController = new telefonosController();
        $telefonos = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://82.180.162.18:4000/telefonos');
        $telefonosArreglo = json_decode($telefonos, true);
        // Obtener los datos de correos desde el controlador 
        $correosController = new correosController();
        $correos = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://82.180.162.18:4000/correos');
        $correosArreglo = json_decode($correos, true);
        // Obtener los datos de direcciones desde el controlador 
        $direccionesController = new direccionesController();
        $direcciones = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://82.180.162.18:4000/direcciones');
        $direccionesArreglo = json_decode($direcciones, true);
        // Obtener los datos de Contacto emergencia desde el controlador 
        $contactoController = new contactoController();
        $contactos = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://82.180.162.18:4000/contacto_emergencia');
        $contactosArreglo = json_decode($contactos, true);


       // dd ( $UsuarioValue);
        $personas = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://82.180.162.18:4000/GETpersonas');
        $personasArreglo = json_decode($personas, true);
        //dd ($personasArreglo);
         // dd ( $UsuarioValue);
         $personas1 = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('http://82.180.162.18:4000/personas');
        $personas1Arreglo = json_decode($personas1, true);

        return view('AXE.personas', compact('personasArreglo','$personas1Arreglo ','telefonosArreglo','correosArreglo','direccionesArreglo','contactosArreglo'));
    }

    public function verpersona($COD_PERSONAS)
    {
        try {
            // Añadir el parámetro COD_PERSONAS al final de la URL de la API
            $apiUrlWithFilter = $this->apiUrl . '/' . $COD_PERSONAS;

            // Obtener la información de la persona desde la API
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . decrypt(request()->cookie('token')),
            ])->get($apiUrlWithFilter);

            // Verificar si la solicitud a la API fue exitosa
            if ($response->successful()) {
                $personaArreglo = $response->json();
                return view('AXE.personas', compact('personaArreglo'));
            } else {
                // Manejar errores de la API, por ejemplo, redirigir a una página de error
                return redirect()->route('error')->with('error', 'Error al obtener los detalles de la persona desde la API');
            }
        } catch (\Exception $e) {
            // Manejar otras excepciones, por ejemplo, redirigir a una página de error
            return redirect()->route('error')->with('error', 'Error interno al procesar la solicitud');
        }
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
        //post('http://82.180.162.18:4000/INSpersonas', [
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
            "Estado_registro"=> $request->input("Estado"),
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
            "IDENTIDAD" => $request->input("IDENTIDADUPD"),
            "GENERO" => $request->input("GENERO"),
            "TIPO_PERSONA" => $request->input("TIPO_PERSONA"),
            "EDAD" => $edad,
            "FECHA_NACIMIENTO" => $fecha_nacimiento,
            "USUARIO_MODIFICADOR" => $UsuarioValue,
              //TELEFONOS
              "TELEFONO" => $request->input("TELEFONOUPD"),
              "TIPO_TELEFONO" => $request->input("TIPO_TELEFONO"),
              //DIRECCIONES
              "DIRECCION"=> $request->input("DIRECCION"),
              "DEPARTAMENTO"=> $request->input("DEPARTAMENTO"),
              "CIUDAD"=> $request->input("CIUDAD"),
              "PAIS"=> $request->input("PAIS"),
              //CONTACTOS
              "NOMBRE_CONTACTO"=> $request->input("NOMBRE_CONTACTO"),
              "APELLIDO_CONTACTO"=> $request->input("APELLIDO_CONTACTO"),
              "TELEFONO_CONTACTO"=> $request->input("TELEFONO_CONTACTOUPD"),
              "RELACION"=> $request->input("RELACION"),
              //correos
              "CORREO_ELECTRONICO"=> $request->input("CORREO_ELECTRONICO"),
              "Estado_registro"=> $request->input("Estado"),
        ]);
        //dd($request->input("COD_PERSONA"));
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
    public function delete_persona(Request $request)
    {
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        
        $delete_usuario = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->put('http://82.180.162.18:4000/del_personas/'.$request->input("COD_PERSONA"));
        
        if ($delete_usuario->successful()) {
            return redirect('/personas')->with('message', [
                'type' => 'success',
                'text' => 'Persona eliminada.'
            ]);
        } else {
            return redirect('/personas')->with('message', [
                'type' => 'error',
                'text' => 'No se puede eliminar.'
            ]);
        }
    }
}