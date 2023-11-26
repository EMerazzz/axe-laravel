<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\asignaturasController;


Route::middleware(['checkToken'])->group(function () {
    Route::get('',[asignaturasController::class,'asignaturas']);
    //de aqui 
    Route::post('/insertar',[asignaturasController::class,'nueva_asignatura']);
    Route::post('/actualizar',[asignaturasController::class,'modificar_asignaturas']);
    Route::post('/delete',[asignaturasController::class,'delete_asignatura']);
    //hasta aqui
});
