<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\bitacoraController;


Route::middleware(['checkToken', 'verificar.usuario:BITACORA'])->group(function () {
    Route::get('',[bitacoraController::class,'bitacora']);
    Route::post('/guardar',[bitacoraController::class,'guardar']);
    Route::post('/limpiar',[bitacoraController::class,'eliminarDatosBitacora']);
   
});
