<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\AXEController;

Route::middleware(['checkToken'])->group(function () {
    
Route::get('',[AXEController::class,'AXE']);
});
