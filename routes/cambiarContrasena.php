<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\cambiar_contrasenaController;

//de aqui 
Route::middleware(['checkToken', 'verificar.usuario:CAMBIAR_CONTRASENA'])->group(function () {
    Route::get('',[cambiar_contrasenaController::class,'mostrarContrasena']);
    Route::post('/nuevaContrasena',[cambiar_contrasenaController::class,'changeContrasena']);
});