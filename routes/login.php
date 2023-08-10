<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\loginController;

Route::get('',[loginController::class,'login']);
Route::post('',[asignaturasController::class,'ingresar']);