<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\rel_asignaturasController;


//hasta aqui
Route::middleware(['checkToken'/*,'verificar.usuario:NIVEL ACADEMICO'*/])->group(function () {
    Route::get('',[rel_asignaturasController::class,'rel_asignaturas']);
    //de aqui 
    Route::post('/insertar',[rel_asignaturasController::class,'nuevo_rel_asignaturas']);
    Route::post('/actualizar',[rel_asignaturasController::class,'modificar_rel_asignaturas']);
   // Route::post('/delete',[rel_asignaturasController::class,'delete_nivel_academico']);
});
