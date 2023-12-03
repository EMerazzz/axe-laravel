<?php

namespace App\Http\Controllers\AXE;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class BackupRestoreController extends Controller
{
    const urlapi = 'http://82.180.162.18:4000/';

    const uploadFolder = 'API_AXE/uploads'; // Carpeta donde se guarda el archivo en tu proyecto de las APIs

    public function backuprestore()
    {
        // Código para la cabecera
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        // Hacer la solicitud a la API de Express para obtener la lista de archivos de respaldo
        $backuprestore = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get(self::urlapi . 'SEGURIDAD/BACKUP-LIST');
        
        // Decodificar la respuesta JSON y obtener la lista de archivos
        $response = json_decode($backuprestore->body(), true);
        $citaArreglo = $response['Archivos de respaldo'] ?? [];

        // Pasar la lista de archivos a la vista junto con la URL API
        return view('AXE.backuprestore', ['citaArreglo' => $citaArreglo]);

    }

    public function backup()
    {
        try {
            $cookieEncriptada = request()->cookie('token');
            $token = decrypt($cookieEncriptada);

            // Hacer la solicitud a la API de Express para generar el respaldo
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->post(self::urlapi. 'SEGURIDAD/BACKUP');

            // Verificar si la solicitud fue exitosa (código de respuesta 200)
            if ($response->successful()) {
                $notification = [
                    'type' => 'success',
                    'title' => '¡Creación exitosa!',
                    'message' => 'El respaldo ha sido guardado.'
                ];
                return redirect('/backuprestore')->with('notification', $notification);
            } else {
                return redirect()->back()->with('error', 'No se pudo crear el archivo')->withInput();
            }
        } catch (\Exception $e) {
            // Manejar cualquier excepción que pueda ocurrir durante el proceso
            return view('AXE.backuprestore', ['error' => 'Error interno del servidor']);
        }
    }

    public function descargarBackup($filename)
    {
        // Código para la cabecera
        $cookieEncriptada = request()->cookie('token');
        $token = decrypt($cookieEncriptada);
        try {

            // Hacer la solicitud a la API para descargar el respaldo
            $response =  Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get(self::urlapi . 'SEGURIDAD/DESCARGAR-BACKUP/' . $filename);

            // Verificar si la solicitud fue exitosa (código de respuesta 200)
            if ($response->successful()) {
                // Configurar el encabezado de la respuesta para la descarga
                return response()->stream(
                    function () use ($response) {
                        echo $response->body();
                    },
                    200,
                    [
                        'Content-Type' => 'application/sql',
                        'Content-Disposition' => 'attachment; filename=' . $filename,
                    ]
                );
            } else {
                // Manejar errores de la API
                return response()->json(['error' => 'Error al descargar el archivo de respaldo'], $response->status());
            }

        } catch (\Exception $e) {
            \Log::error('Error al descargar el archivo de respaldo: ' . $e->getMessage());
            return response()->json(['error' => 'Error interno del servidor'], 500);
        }
    }

    public function deleteBackup($filename)
    {
        try {
            // Código para la cabecera
            $cookieEncriptada = request()->cookie('token');
            $token = decrypt($cookieEncriptada);

            // Realiza la solicitud a la API para eliminar el respaldo
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->delete(self::urlapi . 'SEGURIDAD/BACKUP-DELETE/' . $filename);

            // Verificar si la solicitud fue exitosa (código de respuesta 200)
            if ($response->successful()) {
                // Pasar la lista de archivos a la vista junto con la URL API
                $notification = [
                    'type' => 'success',
                    'title' => '¡Operación exitosa!',
                    'message' => 'El respaldo ha sido eliminado.'
                ];
                return redirect('/backuprestore')
                    ->with('notification', $notification);
            } else {
                return redirect()->back()->with('error', 'No se pudo eliminar el archivo')->withInput();
            }
        } catch (\Exception $e) {
            // Manejar cualquier excepción que pueda ocurrir durante el proceso
            return view('AXE.backuprestore', ['error' => 'Error interno del servidor']);
        }
    }

    public function deleteAllBU()
    {
        try {
            // Código para la cabecera
            $cookieEncriptada = request()->cookie('token');
            $token = decrypt($cookieEncriptada);

            // Realiza la solicitud a la API para eliminar el respaldo
            $response =Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->delete(self::urlapi . 'SEGURIDAD/BACKUP-DELETE-ALL');

            // Verificar si la solicitud fue exitosa (código de respuesta 200)
            if ($response->successful()) {
                // Pasar la lista de archivos a la vista junto con la URL API
                $notification = [
                    'type' => 'success',
                    'title' => '¡Operación exitosa!',
                    'message' => 'Todos los respaldos han sido eliminados.'
                ];
                return redirect('/backuprestore')
                    ->with('notification', $notification);
            } else {
                return redirect()->back()->with('error', 'No se pudieron eliminar los archivos')->withInput();
            }
        } catch (\Exception $e) {
            // Manejar cualquier excepción que pueda ocurrir durante el proceso
            return view('AXE.backuprestore', ['error' => 'Error interno del servidor']);
        }
    }

    public function showUploadSQLForm()
    {
        return view('AXE.uploadsql');
    }

    public function restore(Request $request)
    {
        try {
            // Código para la cabecera
            $cookieEncriptada = request()->cookie('token');
            $token = decrypt($cookieEncriptada);

            // Verificar si se proporcionó un archivo en la solicitud
            if ($request->hasFile('backupFile') && $request->file('backupFile')->isValid()) {
                // Obtener el archivo del formulario
                $backupFile = $request->file('backupFile');

                // Construir la solicitud a la API para subir el archivo
                $response =  Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                ]) ->attach('backupFile', file_get_contents($backupFile), $backupFile->getClientOriginalName())
                    ->post(self::urlapi . 'SEGURIDAD/RESTAURAR-BACKUP');
                
                // Verificar si la solicitud fue exitosa (código de respuesta 200)
                if ($response->successful()) {
                    // Pasar la lista de archivos a la vista junto con la URL API
                    $notification = [
                        'type' => 'success',
                        'title' => '¡Restauración exitosa!',
                        'message' => 'La base de datos ha sido restaurada.'
                    ];
                    return redirect('/backuprestore')
                        ->with('notification', $notification);
                } else {
                    return redirect()->back()->with('error', 'No se pudo restaurar la base de datos')->withInput();
                }
            } else {
                return redirect()->back()->with('error', 'Por favor, seleccione un archivo válido para restaurar')->withInput();
            }
        } catch (\Exception $e) {
            // Manejar cualquier excepción que pueda ocurrir durante el proceso
            return view('AXE.backuprestore', ['error' => 'Error interno del servidor']);
        }
    }
}