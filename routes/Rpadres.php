<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\RpadresController;


Route::middleware(['checkToken', 'verificar.usuario:REPORTES PADRES'])->group(function () {
    Route::get('',[RpadresController::class,'Rpadres']);
   
});