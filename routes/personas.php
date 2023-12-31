<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\personasController;


Route::middleware(['checkToken', 'verificar.usuario:PERSONAS'])->group(function () {
    Route::get('',[personasController::class,'personas']);
    Route::get('ver',[personasController::class,'verpersona']);
    //de aqui 
    Route::post('/insertar',[personasController::class,'nueva_persona']);
    Route::post('/actualizar',[personasController::class,'modificar_persona']);
    //hasta aqui
    Route::post('/delete',[personasController::class,'delete_persona']);
});




//});