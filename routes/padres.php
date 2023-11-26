<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\padresController;


Route::middleware(['checkToken'])->group(function () {
    Route::get('',[padresController::class,'padres']);
    //de aqui 
    Route::post('/insertar',[padresController::class,'nuevo_padre']);
    Route::post('/actualizar',[padresController::class,'modificar_padre']);
    Route::post('/delete',[padresController::class,'delete_padre']);
    //hasta aqui
});
