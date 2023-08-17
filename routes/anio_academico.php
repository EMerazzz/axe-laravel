<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\anio_academicoController;

Route::get('',[anio_academicoController::class,'anio_academico']);
//de aqui 
Route::post('/insertar',[anio_academicoController::class,'nuevo_anio_academico']);
Route::post('/actualizar',[anio_academicoController::class,'modificar_anio_academico']);
//hasta aqui