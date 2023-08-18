<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\docentesAsignaturaController;


Route::middleware(['checkToken'])->group(function () {
    Route::get('',[docentesAsignaturaController::class,'docentesAsignatura']);
    //de aqui 
    Route::post('/insertar',[docentesAsignaturaController::class,'nuevo_docentesAsignatura']);
    Route::post('/actualizar',[docentesAsignaturaController::class,'modificar_docentesAsignatura']);
    //hasta aqui
});
