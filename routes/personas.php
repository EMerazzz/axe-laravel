<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\personasController;

Route::get('',[personasController::class,'personas']);
//de aqui 
Route::post('/insertar',[personasController::class,'nueva_persona']);
Route::post('/actualizar',[personasController::class,'modificar_persona']);
//hasta aqui