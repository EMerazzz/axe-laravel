<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\asignaturasController;

Route::get('',[asignaturasController::class,'asignaturas']);
//de aqui 
Route::post('/insertar',[asignaturasController::class,'nueva_asignatura']);
Route::post('/actualizar',[asignaturasController::class,'modificar_asignaturas']);
//hasta aqui