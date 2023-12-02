<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\estado_rolController;

Route::middleware(['checkToken'])->group(function () {
Route::get('',[estado_rolController::class,'estado_rol']);
//de aqui 
Route::post('/insertar',[estado_rolController::class,'nuevo_estado_rol']);
Route::post('/actualizar',[estado_rolController::class,'modificar_estado_rol']);
Route::post('/delete',[estado_rolController::class,'del_estado_rol']);
//hasta aqui
});