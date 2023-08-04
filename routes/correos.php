<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\correosController;

Route::get('',[correosController::class,'correos']);
//de aqui 
Route::post('/insertar',[correosController::class,'nuevo_correo']);
Route::post('/actualizar',[correosController::class,'modificar_correo']);
//hasta aqui