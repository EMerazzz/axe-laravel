<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\estudiantesController;

Route::get('',[estudiantesController::class,'estudiantes']);
//de aqui 
Route::post('/insertar',[estudiantesController::class,'nuevo_estudiante']);
Route::post('/actualizar',[estudiantesController::class,'modificar_estudiante']);
//hasta aqui