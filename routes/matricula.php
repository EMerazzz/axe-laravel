<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\matriculaController;

Route::middleware(['checkToken'])->group(function () {
Route::get('',[matriculaController::class,'matricula']);
//de aqui 
Route::post('/insertar',[matriculaController::class,'nueva_matricula']);
Route::post('/actualizar',[matriculaController::class,'modificar_matricula']);
Route::post('/delete',[matriculaController::class,'delete_matricula']);
//hasta aqui
});