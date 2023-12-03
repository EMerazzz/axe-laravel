<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\RpersonasController;


Route::middleware(['checkToken', 'verificar.usuario:REPORTES PERSONAS'])->group(function () {
    Route::get('',[RpersonasController::class,'Rpersonas']);
});