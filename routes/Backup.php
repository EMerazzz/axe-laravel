<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BackupController;

// Asumiendo que ya has importado las clases necesarias al principio del archivo

route::middleware(['checkToken'])->group(function () {
    Route::get('/', [BackupController::class, 'index']);

    // Ruta para crear la copia de seguridad
    Route::post('/create', [BackupController::class, 'createBackup']);
});
