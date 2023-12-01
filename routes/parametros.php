<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\parametrosController;


route::middleware(['checkToken'])->group(function () {
    Route::get('',[parametrosController::class,'parametros']);
    //de aqui 
    Route::post('/insertar',[parametrosController::class,'nuevo_parametro']);
    Route::post('/actualizar',[parametrosController::class,'modificar_parametro']);
    Route::post('/delete',[parametrosController::class,'delete_parametro']);
    //hasta aqui
});