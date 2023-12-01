<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Backup\Tasks\Backup\BackupJobFactory;
use Illuminate\Support\Facades\Artisan;


class BackupController extends Controller
{
    public function index()
    {
        return view('backup');
    }

    public function createBackup()
    {
        try {
            // Ejecutar el comando de Artisan para realizar el backup solo de la base de datos
            // y desactivar las notificaciones
            Artisan::call('backup:run', [
                '--only-db' => true,
                '--disable-notifications' => true,
            ]);

            return back()->with('success', 'Copia de seguridad de la base de datos creada exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al crear la copia de seguridad: '.$e->getMessage());
        }
    }
}
