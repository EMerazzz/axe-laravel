<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\direccionesController;



Route::middleware(['checkToken'])->group(function () {
    Route::get('',[direccionesController::class,'direcciones']);
    //de aqui 
    Route::post('/insertar',[direccionesController::class,'nueva_direccion']);
    Route::post('/actualizar',[direccionesController::class,'modificar_direccion']);
    Route::post('/delete',[direccionesController::class,'delete_direccion']);
    //hasta aqui
});
