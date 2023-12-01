<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\telefonosController;


//hasta aqui
route::middleware(['checkToken'])->group(function () {
    Route::get('',[telefonosController::class,'telefonos']);
    //de aqui 
    Route::post('/insertar',[telefonosController::class,'nuevo_telefono']);
    Route::post('/actualizar',[telefonosController::class,'modificar_telefono']);
    Route::post('/delete',[telefonosController::class,'delete_telefono']);
});