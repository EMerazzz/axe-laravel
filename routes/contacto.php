<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\contactoController;

Route::get('',[contactoController::class,'contacto_emergencia']);
//de aqui 
Route::post('/insertar',[contactoController::class,'nuevo_contacto_emergencia']);
Route::post('/actualizar',[contactoController::class,'modificar_contacto_emergencia']);
//hasta aqui