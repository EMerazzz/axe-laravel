<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\RdocentesController;


Route::middleware(['checkToken', 'verificar.usuario:REPORTES DOCENTES'])->group(function () {
    Route::get('',[RdocentesController::class,'Rdocentes']);
   
});