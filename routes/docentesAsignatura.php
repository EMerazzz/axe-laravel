<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\docentesAsignaturaController;


Route::middleware(['checkToken', 'verificar.usuario:ASIGNATURAS DOCENTES'])->group(function () {
    Route::get('',[docentesAsignaturaController::class,'docentesAsignatura']);
    //de aqui 
    Route::post('/insertar',[docentesAsignaturaController::class,'nuevo_docentesAsignatura']);
    Route::post('/actualizar',[docentesAsignaturaController::class,'modificar_docentesAsignatura']);
    Route::post('/delete',[docentesAsignaturaController::class,'delete_docentesAsignatura']);
    //hasta aqui
});
