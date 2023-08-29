<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\rolesController;

Route::middleware(['checkToken', 'verificar.usuario'])->group(function () {
Route::get('',[rolesController::class,'roles']);
//de aqui 
Route::post('/insertar',[rolesController::class,'nuevo_rol']);
Route::post('/actualizar',[rolesController::class,'modificar_rol']);
//hasta aqui
});