<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\permisosController;

Route::middleware(['checkToken', 'verificar.usuario'])->group(function () {
Route::get('',[permisosController::class,'permisos']);
//de aqui 
Route::post('/insertar',[permisosController::class,'nuevo_permiso']);
Route::post('/actualizar',[permisosController::class,'modificar_permiso']);
//hasta aqui
});