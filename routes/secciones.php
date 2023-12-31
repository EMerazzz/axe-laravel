<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\seccionesController;


Route::middleware(['checkToken', 'verificar.usuario:SECCIONES'])->group(function () {
    Route::get('',[seccionesController::class,'secciones']);
    //de aqui 
    Route::post('/insertar',[seccionesController::class,'nueva_seccion']);
    Route::post('/actualizar',[seccionesController::class,'modificar_seccion']);
    //hasta aqui
    Route::post('/delete',[seccionesController::class,'delete_seccion']);
});