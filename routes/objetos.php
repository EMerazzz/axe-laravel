<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\objetosController;


route::middleware(['checkToken'])->group(function () {
    Route::get('',[objetosController::class,'objetos']);
    //de aqui 
    Route::post('/insertar',[objetosController::class,'nuevo_objetos']);
    Route::post('/actualizar',[objetosController::class,'modificar_objeto']);
    //hasta aqui
});