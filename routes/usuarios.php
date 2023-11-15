<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\usuariosController;

/*
Route::middleware(['checkToken', 'verificar.usuario'])->group(function () {
Route::get('',[usuariosController::class,'usuarios']);

//de aqui 
Route::post('/insertar',[usuariosController::class,'nuevo_usuario']);
Route::post('/actualizar',[usuariosController::class,'modificar_usuario']);
//hasta aqui
});
*/
Route::middleware(['checkToken', 'verificar.usuario:USUARIOS'])->group(function () {
    Route::get('',[usuariosController::class,'usuarios']);
    
    //de aqui 
    Route::post('/insertar',[usuariosController::class,'nuevo_usuario']);
    Route::post('/actualizar',[usuariosController::class,'modificar_usuario']);
    //hasta aqui
    });