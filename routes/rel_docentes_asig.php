<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\rel_docentes_asigController;


Route::middleware(['checkToken'])->group(function () {
    Route::get('',[rel_docentes_asigController::class,'rel_docentes_asig']);
    //de aqui 
    Route::post('/insertar',[rel_docentes_asigController::class,'insertarRelacion_Docente']);
    Route::post('/actualizar',[rel_docentes_asigController::class,'modificar_Rel_Docente_Asig']);
});