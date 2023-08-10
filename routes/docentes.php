<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\docentesController;

Route::get('',[docentesController::class,'docentes']);
//de aqui 
Route::post('/insertar',[docentesController::class,'nuevo_docente']);
Route::post('/actualizar',[docentesController::class,'modificar_docente']);
//hasta aqui