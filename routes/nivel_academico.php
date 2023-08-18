<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\nivel_academicoController;


//hasta aqui
Route::middleware(['checkToken'])->group(function () {
    Route::get('',[nivel_academicoController::class,'nivel_academico']);
    //de aqui 
    Route::post('/insertar',[nivel_academicoController::class,'nuevo_nivel_academico']);
    Route::post('/actualizar',[nivel_academicoController::class,'modificar_nivel_academico']);
});
