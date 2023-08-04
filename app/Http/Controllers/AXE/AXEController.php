<?php

namespace App\Http\Controllers\AXE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class AXEController extends Controller
{
    public function AXE(){
        return view('AXE.AXE');
    }
}
