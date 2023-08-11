<?php

namespace App\Http\Controllers\AXE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class loginController extends Controller
{   
    
    public function login(){
       return view('AXE/login');
    }
    
    public function ingresar(Request $request ){
        //print_r([$request->input("nombre"),$request->input("fecha"),$request->input("registro"),$request->input("codigo")]);die();
        $variableLogin = Http::post('http://localhost:4000/login',[
        "USUARIO" => $request->input("USUARIO"),
        "CONTRASENA" => $request->input("CONTRASENA"),
        ]);
      
        $variable= json_decode($variableLogin,true);
        if ( count($variable)  > 1){
            echo "nice";
            setcookie("token", $variable['token'], 0,"./");
            return view('AXE.AXE', compact('variable'));  
        } else {
            echo "Ha ocurrido un problema";
           return view('login', compact('variable'));
        }
    }
}