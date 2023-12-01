<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\RmatriculasController;


Route::middleware(['checkToken'])->group(function () {
    Route::get('',[RmatriculasController::class,'Rmatriculas']);
   
});