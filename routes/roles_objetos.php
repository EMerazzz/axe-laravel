<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\roles_objetosController;


route::middleware(['checkToken'])->group(function () {
    Route::get('',[roles_objetosController::class,'roles_objetos']);
    //de aqui 
    Route::post('/insertar',[roles_objetosController::class,'nuevo_rol_objeto']);
    Route::post('/actualizar',[roles_objetosController::class,'modificar_rol_objeto']);
    Route::post('/delete',[roles_objetosController::class,'delete_rol_objeto']);
    //hasta aqui
});