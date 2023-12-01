<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\estado_usuarioController;

Route::middleware(['checkToken', 'verificar.usuario:ESTADO USUARIO'])->group(function () {
Route::get('',[estado_usuarioController::class,'estado_usuario']);
//de aqui 
Route::post('/insertar',[estado_usuarioController::class,'nuevo_estado_usuario']);
Route::post('/actualizar',[estado_usuarioController::class,'modificar_estado_usuario']);
//hasta aqui
});