<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\preguntasController;


Route::middleware(['checkToken', 'verificar.usuario:PREGUNTAS'])->group(function () {
    Route::get('',[preguntasController::class,'preguntas']);
    //de aqui 
    Route::post('/insertar',[preguntasController::class,'nueva_preguntas']);
    Route::post('/actualizar',[preguntasController::class,'modificar_preguntas']);
    Route::post('/delete',[preguntasController::class,'delete_preguntas']);
    //hasta aqui
});
