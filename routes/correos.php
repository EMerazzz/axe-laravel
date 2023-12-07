<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\correosController;

Route::middleware(['checkToken', 'verificar.usuario:CORREOS'])->group(function () {
    Route::get('',[correosController::class,'correos']);
    //de aqui 
    Route::post('/insertar',[correosController::class,'nuevo_correo']);
    Route::post('/actualizar',[correosController::class,'modificar_correo']);
    Route::post('/delete',[correosController::class,'delete_correo']);
    //hasta aqui
});


