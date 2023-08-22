<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\permisosController;

route::middleware(['checkToken'])->group(function () {
Route::get('',[permisosController::class,'permisos']);
//de aqui 
Route::post('/insertar',[permisosController::class,'nuevo_permiso']);
Route::post('/actualizar',[permisosController::class,'modificar_permiso']);
//hasta aqui
});